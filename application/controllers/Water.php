<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Water extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_water');
		$this->load->model('M_customer');
		$this->load->model('M_rates');
		$this->load->model('M_period');
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		$data['dataWater'] = $this->M_water->select_all();
		$data['dataCustomer'] = $this->M_customer->select_all();
		$data['dataRates'] = $this->M_rates->current_rate();
		$data['dataPeriod'] = $this->M_period->select_periode();

		$data['page'] = "water";
		$data['judul'] = "Water Bills";
		$data['deskripsi'] = "Manage Water Bills";

		$data['modal_tambah_water'] = show_my_modal('modals/modal_tambah_water', 'tambah-water', $data);

		$js = $this->load->view('water/water-js', null, true);
		$this->template->views('water/home', $data, $js);
	}

	public function tampil()
	{
		$customer = $this->input->get('customer');
		$startDate = $this->input->get("startDate");
		$endDate = $this->input->get("endDate");
		$owner = $this->input->get('owner');
		$data['dataWater'] = $this->M_water->select_filter($owner, $customer, $startDate, $endDate);
		$this->load->view('water/list_data', $data);
	}

	public function prosesTambah()
	{
		$this->form_validation->set_rules('idWater', 'Water Bill Code', 'trim|required');
		$this->form_validation->set_rules('kodeCus', 'Customer ID', 'required');
		$this->form_validation->set_rules('period', 'Period', 'required');
		$this->form_validation->set_rules('hiddenStandingCharge', 'Standing Charge', 'trim|required');
		$this->form_validation->set_rules('hiddenWaterRate', 'Water Rate', 'trim|required');
		$this->form_validation->set_rules('startMeter', 'Start Meter', 'trim|required|numeric');
		$this->form_validation->set_rules('endMeter', 'End Meter', 'trim|required|numeric');
		$this->form_validation->set_rules('cons', 'Cons', 'trim|required');
		$this->form_validation->set_rules('consumption', 'Consumption', 'trim|required');
		$this->form_validation->set_rules('taxArea', 'Tax Area', 'trim|required');
		$this->form_validation->set_rules('tax', 'Tax', 'trim|required');
		$this->form_validation->set_rules('total', 'Total', 'trim|required');

		$post = $this->input->post();
		$rate = $this->M_rates->select_by_id($post['hiddenIdTarif']);
		if ($this->form_validation->run() == TRUE) {
			if ($this->M_water->check_bill($post['kodeCus'], $post['period']) > 0) {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Water Bill For This Period Already Inserted', '20px');
			} else if ($post['endMeter'] < $post['startMeter']) {
				$out['status'] = '';
				$out['msg'] = show_err_msg('End Meter Must Be Greater Than Or Equal Start Meter', '20px');
			} else {
				$period = $this->M_period->select_periode_by_id($post['period']);

				$cons = $post['endMeter'] - $post['startMeter'];
				$consumption = $cons * $rate->water;
				$temp = $consumption + $rate->charge;
				$taxArea = ceil($temp * 0.1);
				$sum = $temp + $taxArea;
				$tax = ceil($sum * 0.1);
				$total = $sum + $tax;

				if ($period->mulai != $period->akhir) {
					$data = [
						'idWater' => $post['idWater'],
						'kodeCus' => $post['kodeCus'],
						'id_tarif' => $rate->id,
						'id_periode' => $post['period'],
						'startMeter' => $post['startMeter'],
						'endMeter' => $post['endMeter'],
						'cons' => $cons,
						'consumption' => $consumption,
						'tax_area' => $taxArea,
						'tax' => $tax,
						'total' => $total,
						'prorate' => $total
					];

					$result = $this->M_water->insert($data);
				} else {
					$data = [
						'idWater' => $post['idWater'],
						'kodeCus' => $post['kodeCus'],
						'id_tarif' => $rate->id,
						'id_periode' => $post['period'],
						'startMeter' => $post['startMeter'],
						'endMeter' => $post['endMeter'],
						'cons' => $cons,
						'consumption' => $consumption,
						'tax_area' => $taxArea,
						'tax' => $tax,
						'total' => $total,
						'prorate' => $total
					];

					$result = $this->M_water->insert($data);
				}

				if ($result > 0) {
					helper_log("add", "Menambah Data (Water)", $post['idWater']);
					$out['status'] = '';
					$out['msg'] = show_succ_msg('Water Bill Successfully Added', '20px');
				} else {
					$out['status'] = '';
					$out['msg'] = show_err_msg('Water Bill Failed To Add', '20px');
				}
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function update()
	{
		$id = trim($_POST['id']);

		$data['dataWater'] = $this->M_water->select_by_id($id);
		$data['dataCustomer'] = $this->M_customer->select_all();
		$data['dataRates'] = $this->M_rates->select_all();
		$data['userdata'] = $this->userdata;

		echo show_my_modal('modals/modal_update_water', 'update-water', $data);
	}

	public function prosesUpdate()
	{
		$this->form_validation->set_rules('kodeCus', 'Customer ID', 'trim|required');
		$this->form_validation->set_rules('periodStart', 'Period Start', 'trim|required');
		$this->form_validation->set_rules('periodEnd', 'Period End', 'trim|required');
		$this->form_validation->set_rules('dueDate', 'Due Date', 'trim|required');
		$this->form_validation->set_rules('startMeter', 'Start Meter', 'trim|required');
		$this->form_validation->set_rules('endMeter', 'End Meter', 'trim|required');
		$this->form_validation->set_rules('cons', 'Cons', 'trim|required');
		$this->form_validation->set_rules('consumption', 'Consumption', 'trim|required');
		$this->form_validation->set_rules('taxArea', 'Tax Area', 'trim|required');
		$this->form_validation->set_rules('tax', 'Tax', 'trim|required');
		$this->form_validation->set_rules('total', 'Total', 'trim|required');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_water->update($data);

			if ($result > 0) {
				helper_log("edit", "Mengubah Data (Water)", $post['idWater']);
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Water Bill Successfully Updated', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Water Bill Failed To Update', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function delete()
	{
		$id = $_POST['id'];
		$result = $this->M_water->delete($id);

		if ($result > 0) {
			helper_log("delete", "Menghapus Data (Water)", $id);
			echo show_succ_msg('Water Bill Successfully Deleted', '20px');
		} else {
			echo show_err_msg('Water Bill Failed To Delete', '20px');
		}
	}

	public function detail()
	{
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['dataWater'] = $this->M_water->select_detail($id);
		// $data['dataCustomer'] = $this->M_customer->select_by_pegawai($id);

		echo show_my_modal('modals/modal_detail_water', 'detail-water', $data, 'lg');
	}

	public function export()
	{
		error_reporting(E_ALL);

		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_water->select_all_water();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowCount = 1;

		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFill()->getStartColor()->setARGB('bfb8b8');
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);

		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");
		$objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");
		$objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");
		$objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");
		$objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");
		$objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");

		for ($i = 'A'; $i < 'O'; $i++) {
			$objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "Water Bill Code");
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Cus. ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "Period Start");
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "Period End");
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "Due Date");
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "Start Meter");
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "End Meter");
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, "Cons");
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, "Rates");
		$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, "Standing Charge");
		$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, "Consumption");
		$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, "Tax Area");
		$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, "Tax");
		$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, "Total");
		$rowCount++;

		foreach ($data as $value) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->kode_tagihan_air);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->kode_customer);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->start_periode);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->end_periode);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->due_date);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->start_meter);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value->end_meter);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value->cons);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value->tarif_air);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value->standing_charge);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value->consumption);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $value->tax_area);
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $value->tax);
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $value->total);
			$rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('./assets/excel/Water Bills.xlsx');
		$this->load->helper('download');
		helper_log("export", "Export Data (Water)");
		force_download('./assets/excel/Water Bills.xlsx', NULL);
	}

	public function import()
	{
		$this->form_validation->set_rules('excel', 'File', 'trim|required');


		if ($_FILES['excel']['name'] == '') {
			$this->session->set_flashdata('msg', 'File not selected');
		} else {
			$config['upload_path'] = './assets/excel/';
			$config['allowed_types'] = 'xls|xlsx';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('excel')) {
				$error = array('error' => $this->upload->display_errors());
			} else {
				$data = $this->upload->data();

				error_reporting(E_ALL);
				date_default_timezone_set('Asia/Jakarta');

				include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';

				$inputFileName = './assets/excel/' . $data['file_name'];
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

				$index = 0;
				foreach ($sheetData as $key => $value) {
					if ($key != 1) {
						$check = $this->M_water->check_tagihan($value['A']);
						$checkcustomer = $this->M_customer->check_customer($value['B']);
						if ($value['A'] != '') {
							if ($check != 1) {
								if ($checkcustomer != 0) {

									$resultData[$index]['kode_tagihan_air'] = $value['A'];
									$resultData[$index]['kode_customer'] = ($value['B']);
									$resultData[$index]['id_tarif'] = $value['C'];
									$resultData[$index]['id_periode'] = $value['D'];
									$resultData[$index]['start_meter'] = ($value['E']);
									$resultData[$index]['end_meter'] = $value['F'];
									$resultData[$index]['cons'] = $value['G'];
									$resultData[$index]['consumption'] = $value['H'];
									$resultData[$index]['tax_area'] = ceil($value['I']);
									$resultData[$index]['tax'] = ceil($value['J']);
									$resultData[$index]['total'] = ceil($value['K']);
								}
							}
						}
					}
					$index++;
				}

				unlink('./assets/excel/' . $data['file_name']);

				if (count($resultData) != 0) {

					$result = $this->M_water->insert_batch($resultData);
					if ($result > 0) {
						helper_log("import", "Import Data (Water)");
						$this->session->set_flashdata('msg', show_succ_msg('Water Bills Successfully Imported To Database'));
						redirect('Water');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Water Bills Failed To Import Into Database (Data Has Been Updated)', 'warning', 'fa-warning'));
					redirect('Water');
				}
			}
		}
	}
}

/* End of file Water.php */
/* Location: ./application/controllers/Water.php */

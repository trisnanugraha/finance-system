<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Electricity extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_electricity');
		$this->load->model('M_customer');
		$this->load->model('M_rates');
		$this->load->model('M_period');
		$this->load->model('M_water');
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		$data['dataElectricity'] = $this->M_electricity->select_all();
		$data['dataCustomer'] = $this->M_customer->select_all();
		$data['dataRates'] = $this->M_rates->current_rate();
		$data['dataPeriod'] = $this->M_period->select_periode();
		$data['page'] = "electricity";
		$data['judul'] = "Electricity Bills";
		$data['deskripsi'] = "Manage Electricity Bills";

		$data['modal_tambah_electricity'] = show_my_modal('modals/modal_tambah_electricity', 'tambah-electricity', $data);

		$js = $this->load->view('electricity/electricity-js', null, true);
		$this->template->views('electricity/home', $data, $js);
	}

	public function tampil()
	{
		$customer = $this->input->get("customer");
		$startDate = $this->input->get("startDate");
		$endDate = $this->input->get("endDate");
		$owner = $this->input->get('owner');
		$data['dataElectricity'] = $this->M_electricity->select_filter($owner, $customer, $startDate, $endDate);
		$this->load->view('electricity/list_data', $data);
	}

	public function prosesTambah()
	{
		$this->form_validation->set_rules('idListrik', 'Electricity Bill Code', 'trim|required');
		$this->form_validation->set_rules('kodeCus', 'Customer ID', 'trim|required');
		$this->form_validation->set_rules('period', 'Period', 'trim|required');
		$this->form_validation->set_rules('hiddenElectricityRate', 'Electricity Rate', 'trim|required');
		$this->form_validation->set_rules('dueDate', 'Due Date', 'trim|required');
		$this->form_validation->set_rules('startMeter', 'Start Meter', 'trim|required');
		$this->form_validation->set_rules('endMeter', 'End Meter', 'trim|required');
		$this->form_validation->set_rules('cons', 'Cons', 'trim|required');
		$this->form_validation->set_rules('consumption', 'Consumption', 'trim|required');
		$this->form_validation->set_rules('ppju', 'PPJU', 'trim|required');
		$this->form_validation->set_rules('total', 'Total', 'trim|required');


		$post = $this->input->post();
		if ($this->form_validation->run() == TRUE) {

			if ($this->M_electricity->check_bill($post['kodeCus'], $post['period']) > 0) {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Electricity Bill For This Period Already Inserted', '20px');
			} else if ($post['endMeter'] < $post['startMeter']) {
				$out['status'] = '';
				$out['msg'] = show_err_msg('End Meter Must Be Greater Than Or Equal Start Meter', '20px');
			} else {
				$startMeter = $post['startMeter'];
				$endMeter = $post['endMeter'];
				$cons = $endMeter - $startMeter;
				$rate = $this->M_rates->select_by_id($post['hiddenIdTarif']);
				$period = $this->M_period->select_periode_by_id($post['period']);
				$customer = $this->M_customer->select_by_id($post['kodeCus']);
				if ($period->mulai != $period->akhir) {
					$temp = (40 * $customer->kapasitas * $period->amount) / 30;
				} else {
					$temp =  (40 * $customer->kapasitas * $period->amount) / $period->amount;
				}
				$consumption = 0;
				if ($cons < $temp) {
					$consumption = $temp * $rate->electric;
				} else {
					$consumption = $cons * $rate->electric;
				}

				$ppju = $consumption * 0.03;
				$total = $consumption + $ppju;
				$prorate = $total * $period->amount / 30;

				if ($period->mulai != $period->akhir) {
					$data = [
						'id_listrik' => $post['idListrik'],
						'id_customer' => $post['kodeCus'],
						'id_tarif' => $rate->id,
						'id_periode' => $post['period'],
						'start_meter' => $startMeter,
						'end_meter' => $endMeter,
						'cons' => $cons,
						'consumption' => $consumption,
						'ppju' => $ppju,
						'total' => $total,
						'prorate' => $total
					];

					$result = $this->M_electricity->insert($data);
				} else {
					$data = [
						'id_listrik' => $post['idListrik'],
						'id_customer' => $post['kodeCus'],
						'id_tarif' => $rate->id,
						'id_periode' => $post['period'],
						'start_meter' => $startMeter,
						'end_meter' => $endMeter,
						'cons' => $cons,
						'consumption' => $consumption,
						'ppju' => $ppju,
						'total' => $total,
						'prorate' => $total
					];

					$result = $this->M_electricity->insert($data);
				}

				if ($post['kodeCus'] == 'T-B1' || $post['kodeCus'] == 'T-B2' || $post['kodeCus'] == 'T-B3') {
					$dataAir = [
						'idWater' => $post['idListrik'],
						'kodeCus' => $post['kodeCus'],
						'id_tarif' => $rate->id,
						'id_periode' => $post['period'],
						'startMeter' => 0,
						'endMeter' => 0,
						'cons' => 0,
						'consumption' => 0,
						'tax_area' => 0,
						'tax' => 0,
						'total' => 0
					];

					$this->M_water->insert($dataAir);
				}

				if ($result > 0) {
					helper_log("add", "Menambah Data (Electricity)", $data['id_listrik']);
					$out['status'] = '';
					$out['msg'] = show_succ_msg('Electricity Bill Added successfully', '20px');
				} else {
					$out['status'] = '';
					$out['msg'] = show_err_msg('Electricity Bill Failed To Add', '20px');
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
		$id = trim($_POST['kodeCus']);

		$data['dataCustomer'] = $this->M_customer->select_by_id($id);
		$data['dataDescription'] = $this->M_description->select_all();
		$data['userdata'] = $this->userdata;

		echo show_my_modal('modals/modal_update_customer', 'update-customer', $data);
	}

	public function prosesUpdate()
	{
		$this->form_validation->set_rules('kodeVir', 'Kode Virtual', 'trim|required');
		$this->form_validation->set_rules('nama', 'Nama Customer', 'trim|required');
		$this->form_validation->set_rules('unit', 'Unit Customer', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat Customer', 'trim|required');
		$this->form_validation->set_rules('jenis', 'Jenis', 'trim|required');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_customer->update($data);

			if ($result > 0) {
				helper_log("edit", "Mengubah Data (Electricity)");
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Electricity Bill Successfully Changed', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Electricity Bill Failed To Change', '20px');
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
		$result = $this->M_electricity->delete($id);

		if ($result > 0) {
			helper_log("delete", "Menghapus Data (Electricity)", $id);
			echo show_succ_msg('Electricity Bill Successfully Deleted', '20px');
		} else {
			echo show_err_msg('Electricity Bill Failed To Delete', '20px');
		}
	}

	public function detail()
	{

		$id 				= trim($_POST['id']);
		$data['dataElectricity'] = $this->M_electricity->select_detail($id);

		echo show_my_modal('modals/modal_detail_electricity', 'detail-electricity', $data, 'lg');
	}

	public function export()
	{
		error_reporting(E_ALL);

		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_electricity->select_all_electricity();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowCount = 1;

		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->getStartColor()->setARGB('bfb8b8');
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);

		// $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

		$objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");
		$objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");
		$objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");
		$objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");

		for ($i = 'A'; $i < 'M'; $i++) {
			$objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "Electricity Bill Code");
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Cus. ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "Period Start");
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "Period End");
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "Due Date");
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "Start Meter");
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "End Meter");
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, "Cons");
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, "Rates");
		$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, "Consumption");
		$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, "PPJU");
		$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, "Total");
		$rowCount++;

		foreach ($data as $value) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->id_listrik);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->id_customer);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->start_periode);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->end_periode);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->due_date);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->start_meter);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value->end_meter);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value->cons);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value->tarif_listrik);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value->consumption);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value->ppju);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $value->total);
			$rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('./assets/excel/Electricity Bills.xlsx');
		$this->load->helper('download');
		helper_log("export", "Export Data (Electricity)");
		force_download('./assets/excel/Electricity Bills.xlsx', NULL);
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
						$check = $this->M_electricity->check_nama($value['A']);
						$checkcustomer = $this->M_customer->check_customer($value['B']);
						if ($value['A'] != '') {
							if ($check != 1) {
								if ($checkcustomer != 0) {
									$resultData[$index]['id_listrik'] = $value['A'];
									$resultData[$index]['id_customer'] = $value['B'];
									$resultData[$index]['id_tarif'] = $value['C'];
									$resultData[$index]['id_periode'] = $value['D'];
									$resultData[$index]['start_meter'] = $value['E'];
									$resultData[$index]['end_meter'] = $value['F'];
									$resultData[$index]['cons'] = $value['G'];
									$resultData[$index]['consumption'] = ceil($value['H']);
									$resultData[$index]['ppju'] = ceil($value['I']);
									$resultData[$index]['total'] = ceil($value['J']);
								}
							}
						}
					}
					$index++;
				}

				unlink('./assets/excel/' . $data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_electricity->insert_batch($resultData);
					if ($result > 0) {
						helper_log("import", "Import Data (Electricity)");
						$this->session->set_flashdata('msg', show_succ_msg('Electricity Bills Successfully Imported To Database'));
						redirect('Electricity');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Electricity Bills Failed To Import Into Database (Data Has Been Updated)', 'warning', 'fa-warning'));
					redirect('Electricity');
				}
			}
		}
	}

	public function getPeriodJson()
	{
		$dataPeriod = $this->M_electricity->select_periode();

		$response = [
			"data" => $dataPeriod
		];
		echo json_encode($response);
	}
}

/* End of file Electricity.php */
/* Location: ./application/controllers/Electricity.php */

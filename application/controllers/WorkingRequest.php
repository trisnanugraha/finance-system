<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WorkingRequest extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_workingRequest');
		$this->load->model('M_customer');
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		$data['dataWorkingRequest'] = $this->M_workingRequest->select_all();
		$data['dataCustomer'] = $this->M_customer->select_all();

		$data['page'] = "Working Request";
		$data['judul'] = "Working Request Bills";
		$data['deskripsi'] = "Manage Working Request Bills";

		$data['modal_tambah_workingRequest'] = show_my_modal('modals/modal_tambah_workingRequest', 'tambah-workingRequest', $data);

		$js = $this->load->view('working-request/working-request-js', null, true);
		$this->template->views('working-request/home', $data, $js);
	}

	public function tampil()
	{
		$data['dataWorkingRequest'] = $this->M_workingRequest->select_all();
		$this->load->view('working-request/list_data', $data);
	}

	public function prosesTambah()
	{
		$this->form_validation->set_rules('noInvoiceWR', 'Working Request Bill Code', 'trim|required');
		$this->form_validation->set_rules('noWO', 'No WO', 'required');
		$this->form_validation->set_rules('noWR', 'No WR', 'required');
		$this->form_validation->set_rules('idCustomer', 'ID Customer', 'trim|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
		$this->form_validation->set_rules('total', 'Total', 'trim|required|numeric');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {

			$result = $this->M_workingRequest->insert($data);

				if ($result > 0) {
					$out['status'] = '';
					$out['msg'] = show_succ_msg('Working Request Bill Added successfully', '20px');
				} else {
					$out['status'] = '';
					$out['msg'] = show_err_msg('Working Request Bill Failed To Add', '20px');
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

		$data['dataWorkingRequest'] = $this->M_workingRequest->select_by_id($id);
		$data['dataCustomer'] = $this->M_customer->select_all();
		$data['userdata'] = $this->userdata;

		echo show_my_modal('modals/modal_update_workingRequest', 'update-workingRequest', $data);
	}

	public function prosesUpdate()
	{
		$this->form_validation->set_rules('noWO', 'No WO', 'required');
		$this->form_validation->set_rules('noWR', 'No WR', 'required');
		$this->form_validation->set_rules('idCustomer', 'ID Customer', 'trim|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
		$this->form_validation->set_rules('total', 'Total', 'trim|required|numeric');


		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_workingRequest->update($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Working Request Bill Successfully Updated', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Working Request Bill Failed To Update', '20px');
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
		$result = $this->M_workingRequest->delete($id);

		if ($result > 0) {
			echo show_succ_msg('Working Request Bill Successfully Deleted', '20px');
		} else {
			echo show_err_msg('Working Request Bill Failed To Delete', '20px');
		}
	}

	public function detail()
	{
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['dataWorkingRequest'] = $this->M_workingRequest->select_detail($id);
		// $data['dataCustomer'] = $this->M_customer->select_by_pegawai($id);

		echo show_my_modal('modals/modal_detail_workingRequest', 'detail-workingRequest', $data, 'lg');
	}

	public function export()
	{
		error_reporting(E_ALL);

		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data= $this->M_workingRequest->select_all_wr();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowCount = 1;

		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('bfb8b8');
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

		$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");

		for ($i = 'A'; $i < 'H'; $i++) {
			$objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "Working Request Bill Code");
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "No. WO");
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "No. WR");
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "Cus. ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "Date");
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "Keterangan");
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "Total");
		$rowCount++;

		foreach ($data as $value) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->no_invoice_wr);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->no_wo);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->no_wr);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->id_customer);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->tanggal);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->keterangan);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value->total);
			$rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('./assets/excel/Working-Request Bills.xlsx');

		$this->load->helper('download');
		force_download('./assets/excel/Working-Request Bills.xlsx', NULL);
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
						$check = $this->M_workingRequest->check_invoice($value['A']);
						$checkcustomer = $this->M_customer->check_customer($value['D']);
						if ($value['A'] != '') {
							if ($check != 1) {
								if ($checkcustomer != 0) {
									$resultData[$index]['no_invoice_wr'] = $value['A'];
									$resultData[$index]['no_wo'] = $value['B'];
									$resultData[$index]['no_wr'] = $value['C'];
									$resultData[$index]['id_customer'] = $value['D'];
									$resultData[$index]['tanggal'] = $value['E'];
									$resultData[$index]['keterangan'] = $value['F'];
									$resultData[$index]['total'] = ceil($value['G']);
								}
							}
						}
					}
					$index++;
				}
				
				unlink('./assets/excel/' . $data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_workingRequest->insert_batch($resultData);
					if ($result > 0) {
						$this->session->set_flashdata('msg', show_succ_msg('Working Request Bills Successfully Imported To Database'));
						redirect('WorkingRequest');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Working Request Bills Failed To Import Into Database (Data Has Been Updated)', 'warning', 'fa-warning'));
					redirect('WorkingRequest');
				}
			}
		}
	}
}

/* End of file WorkingRequest.php */
/* Location: ./application/controllers/WorkingRequest.php */

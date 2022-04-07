<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_customer');
		$this->load->model('M_owner');
		$this->load->model('M_description');
	}

	public function index() {
		$data['userdata'] = $this->userdata;
		$data['dataCustomer'] = $this->M_customer->select_all();
		$data['dataDescription'] = $this->M_description->select_all();
		$data['dataOwner'] = $this->M_owner->select_all();
		$data['page'] = "customer";
		$data['judul'] = "Customer";
		$data['deskripsi'] = "Manage Customer Data";
		$data['modal_tambah_customer'] = show_my_modal('modals/modal_tambah_customer', 'tambah-customer', $data);
		$js = $this->load->view('customer/customer-js', null, true);
		$this->template->views('customer/home', $data, $js);
	}

	function getAjax() {
        $dataCustomer = $this->M_customer->get_datatables();
        $record = array();
        $no = $_POST['start'];
        foreach ($dataCustomer as $data) {
            $no++;
			$row = [
					  'no' => $no,
					  'kodeCus' => $data['kodeCus'],
					  'kodeVir' => $data['kodeVir'],
				      'nama' => $data['nama'],
					  'unit' => $data['unit'],
					  'owner' => $data['owner'],
					];
			$record[] = $row;
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->M_customer->count_all(),
			"recordsFiltered" => $this->M_customer->count_filtered(),
			"data" => $record,
		);
        // output to json format
        echo json_encode($output);
    }

	// public function tampil() {
	// 	$data['dataCustomer'] = $this->M_customer->select_all();
	// 	$this->load->view('customer/list_data', $data);
	// }

	public function prosesTambah() {
		$this->form_validation->set_rules('kodeCus', 'Customer ID', 'trim|required');
		$this->form_validation->set_rules('kodeVir', 'Virtual Code', 'trim|required');
		$this->form_validation->set_rules('nama', 'Customer Name', 'trim|required');
		$this->form_validation->set_rules('unit', 'Customer Unit', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Address', 'trim|required');
		$this->form_validation->set_rules('jenis', 'Description', 'trim|required');
		$this->form_validation->set_rules('owner', 'Owner ID', 'trim|required');
		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_customer->insert($data);
			if ($result > 0) {
				helper_log("add", "Menambah Data (Customer)", $data['kodeCus']);
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Customer Data Successfully Added', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Customer Data Failed To Add', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}
		echo json_encode($out);
	}

	public function update() {
		$id = trim($_POST['kodeCus']);
		$data['dataCustomer'] = $this->M_customer->select_by_id($id);
		$data['dataDescription'] = $this->M_description->select_all();
		$data['dataOwner'] = $this->M_owner->select_all();
		$data['userdata'] = $this->userdata;
		echo show_my_modal('modals/modal_update_customer', 'update-customer', $data);
	}

	public function prosesUpdate() {
		$this->form_validation->set_rules('kodeVir', 'Virtual Code', 'trim|required');
		$this->form_validation->set_rules('nama', 'Customer Name', 'trim|required');
		$this->form_validation->set_rules('unit', 'Customer Unit', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Address', 'trim|required');
		$this->form_validation->set_rules('jenis', 'Description', 'trim|required');
		$this->form_validation->set_rules('owner', 'Owner ID', 'trim|required');
		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_customer->update($data);
			if ($result > 0) {
				helper_log("edit", "Mengubah Data (Customer)", $data['kodeCus']);
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Customer Data Successfully Changed', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Customer Data Failed To Change', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}
		echo json_encode($out);
	}

	public function delete() {
		$id = $_POST['kodeCus'];
		$result = $this->M_customer->delete($id);
		if ($result) {
			helper_log("add", "Menghapus Data (Customer)", $id);
			echo show_succ_msg('Customer Data Successfully Deleted', '20px');
		} else {
			echo show_err_msg('Customer Data Failed To Delete', '20px');
		}
	}

	public function detail() {
		$data['userdata'] 	= $this->userdata;
		$id 				= trim($_POST['kodeCus']);
		$data['dataCustomer'] = $this->M_customer->select_by_description($id);
		echo show_my_modal('modals/modal_detail_customer', 'detail-customer', $data, 'lg');
	}

	public function export() {
		error_reporting(E_ALL);
		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		$data = $this->M_customer->select_all();
		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 
		$rowCount = 1; 
		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->getStartColor()->setARGB('bfb8b8');
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(80);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		for ($i = 'A'; $i < 'I'; $i++) {
			$objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "Cus. ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Virtual Code");
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Name");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Unit");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "Address");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Type Room");
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Electricity Capacity");
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "Owner ID");
		$rowCount++;
		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->kodeCus); 
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->kodeVir); 
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->nama); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->unit); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->alamat); 
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value->tipe);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value->kapasitas); 
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value->owner); 
		    $rowCount++; 
		} 
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/Customer Data.xlsx'); 
		$this->load->helper('download');
		helper_log("export", "Export Data (Customer)");
		force_download('./assets/excel/Customer Data.xlsx', NULL);
	}

	public function import() {
		$this->form_validation->set_rules('excel', 'File', 'trim|required');
		if ($_FILES['excel']['name'] == '') {
			$this->session->set_flashdata('msg', 'File not selected');
		} else {
			$config['upload_path'] = './assets/excel/';
			$config['allowed_types'] = 'xls|xlsx';
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('excel')){
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('msg', show_msg($error, 'warning', 'fa-warning'));
				redirect('Customer');
			}
			else{
				$data = $this->upload->data();
				error_reporting(E_ALL);
				date_default_timezone_set('Asia/Jakarta');
				include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';
				$inputFileName = './assets/excel/' .$data['file_name'];
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$index = 0;
				foreach ($sheetData as $key => $value) {
					if ($key != 1) {
						$check = $this->M_customer->check_customer($value['C']);
						if ($check != 1) {
							$resultData[$index]['kode_customer'] = $value['A'];
							$resultData[$index]['kode_virtual'] = ($value['B']);
							$resultData[$index]['nama_customer'] = $value['C'];
							$resultData[$index]['unit_customer'] = $value['D'];
							$resultData[$index]['alamat_customer'] = $value['E'];
							$resultData[$index]['id_deskripsi'] = $value['F'];
							$resultData[$index]['id_owner'] = $value['G'];
						}
					}
					$index++;
				}
				unlink('./assets/excel/' .$data['file_name']);
				if (count($resultData) != 0) {
					$result = $this->M_customer->insert_batch($resultData);
					if ($result > 0) {
						helper_log("import", "Import Data (Customer)");
						$this->session->set_flashdata('msg', show_succ_msg('Customer Data Successfully Imported To Database'));
						redirect('Customer');
					} else {
						echo $result;
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Customer Data Failed To Import Into Database (Data Has Been Updated)', 'warning', 'fa-warning'));
					redirect('Customer');
				}
			}
		}
	}

	public function getCustomerJson(){
		$owner = $this->input->get('owner');
		$dataCustomer = $this->M_customer->select_filter($owner);
		$response = [
			"data" => $dataCustomer
		];
		echo json_encode($response);
	}
}

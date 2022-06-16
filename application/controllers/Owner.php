<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Owner extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_owner');
		$this->load->model('M_description');
		// $this->load->model('M_customer');
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		$data['dataOwner'] = $this->M_owner->select_all();
		$data['dataDescription'] = $this->M_description->select_all();
		// $data['dataCustomer'] = $this->M_customer->select_all();

		$data['page'] = "owner";
		$data['judul'] = "Owner";
		$data['deskripsi'] = "Manage Owner Data";

		$data['modal_tambah_owner'] = show_my_modal('modals/modal_tambah_owner', 'tambah-owner', $data);

		$js = $this->load->view('owner/owner-js', null, true);
		$this->template->views('owner/home', $data, $js);
	}

	function getAjax() {
        $dataOwner = $this->M_owner->get_datatables();
        $record = array();
        $no = $_POST['start'];
        foreach ($dataOwner as $data) {
            $no++;
			$row = [
					'no' => $no,
					'id' => $data['id'],
					'kodeVir' => $data['kodeVir'],
				    'nama' => $data['nama'],
					'unit' => $data['unit'],
					'is_active' => $data['is_active']
					];
			$record[] = $row;
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->M_owner->count_all(),
			"recordsFiltered" => $this->M_owner->count_filtered(),
			"data" => $record,
		);
        // output to json format
        echo json_encode($output);
    }

	public function prosesTambah()
	{
		$this->form_validation->set_rules('id', 'Owner ID', 'trim|required');
		$this->form_validation->set_rules('kodeVir', 'Virtual Code', 'trim|required');
		$this->form_validation->set_rules('nama', 'Owner Name', 'trim|required');
		$this->form_validation->set_rules('unit', 'Owner Unit', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Address', 'trim|required');
		$this->form_validation->set_rules('jenis', 'Description ID', 'trim|required');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_owner->insert($data);

			if ($result > 0) {
				helper_log("add", "Menambah Data (Owner)", $data['id']);
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Owner Data Successfully Added', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Owner Data Failed To Add', '20px');
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

		$data['dataOwner'] = $this->M_owner->select_by_id($id);
		$data['dataDescription'] = $this->M_description->select_all();
		// $data['dataCustomer'] = $this->M_customer->select_all();
		$data['userdata'] = $this->userdata;

		echo show_my_modal('modals/modal_update_owner', 'update-owner', $data);
	}

	public function prosesUpdate()
	{
		$this->form_validation->set_rules('kodeVir', 'Virtual Code', 'trim|required');
		$this->form_validation->set_rules('nama', 'Owner Name', 'trim|required');
		$this->form_validation->set_rules('unit', 'Owner Unit', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Address', 'trim|required');
		$this->form_validation->set_rules('jenis', 'Description ID', 'trim|required');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_owner->update($data);

			if ($result > 0) {
				helper_log("edit", "Mengubah Data (Owner)", $data['id']);
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Owner Data Successfully Changed', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Owner Data Failed To Change', '20px');
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
		$result = $this->M_owner->delete($id);

		if ($result > 0) {
			helper_log("delete", "Menghapus Data (Owner)", $id);
			echo show_succ_msg('Owner Data Successfully Deleted', '20px');
		} else {
			echo show_err_msg('Owner Data Failed To Delete', '20px');
		}
	}

	public function detail()
	{
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['dataOwner'] = $this->M_owner->select_detail($id);
		// $data['dataCustomer'] = $this->M_customer->select_by_pegawai($id);

		echo show_my_modal('modals/modal_detail_owner', 'detail-owner', $data, 'lg');
	}

	public function export()
	{
		error_reporting(E_ALL);

		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_owner->select_all();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowCount = 1;

		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('bfb8b8');
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(70);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

		for ($i = 'A'; $i < 'H'; $i++) {
			$objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "Owner ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Virtual Code");
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "Name");
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "Unit");
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "Address");
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "Type Room");
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "Electricity Capacity");
		$rowCount++;

		foreach ($data as $value) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->id);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->kodeVir);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->unit);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->alamat);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->tipe);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value->kapasitas);
			$rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('./assets/excel/Owner Data.xlsx');

		$this->load->helper('download');
		helper_log("export", "Export Data (Owner)");
		force_download('./assets/excel/Owner Data.xlsx', NULL);
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
						$check = $this->M_owner->check_id($value['A']);

						if ($check != 1) {
							$resultData[$index]['kode_owner'] = $value['A'];
							$resultData[$index]['kode_virtual'] = ($value['B']);
							$resultData[$index]['nama_owner'] = $value['C'];
							$resultData[$index]['unit_owner'] = $value['D'];
							$resultData[$index]['alamat_owner'] = $value['E'];
							$resultData[$index]['id_deskripsi'] = $value['F'];
						}
					}
					$index++;
				}

				unlink('./assets/excel/' . $data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_owner->insert_batch($resultData);
					if ($result > 0) {
						helper_log("import", "Import Data (Owner)");
						$this->session->set_flashdata('msg', show_succ_msg('Owner Data Successfully Imported To Database'));
						redirect('Owner');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Owner Data Failed To Import Into Database (Data Has Been Updated)', 'warning', 'fa-warning'));
					redirect('Owner');
				}
			}
		}
	}

	public function getOwnerJson()
	{
		$dataOwner = $this->M_owner->select_all_owner();

		$response = [
			"data" => $dataOwner
		];
		echo json_encode($response);
	}
}

/* End of file Owner.php */
/* Location: ./application/controllers/Owner.php */
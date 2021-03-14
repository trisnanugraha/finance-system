<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StorageParking extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_storageParking');
		$this->load->model('M_customer');
		$this->load->model('M_type_sp');
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		$data['dataStorageParking'] = $this->M_storageParking->select_all();
		$data['dataCustomer'] = $this->M_customer->select_all();
		$data['dataType'] = $this->M_type_sp->select_all();
		$data['page'] = "Storage Parking";
		$data['judul'] = "Storage/Parking Bills";
		$data['deskripsi'] = "Manage Storage/Parking Bills";

		$data['modal_tambah_storageParking'] = show_my_modal('modals/modal_tambah_storageParking', 'tambah-storageParking', $data);

		$js = $this->load->view('storage-parking/storage-parking-js', null, true);
		$this->template->views('storage-parking/home', $data, $js);
	}

	public function tampil()
	{
		$data['dataStorageParking'] = $this->M_storageParking->select_all();
		$this->load->view('storage-parking/list_data', $data);
	}

	public function prosesTambah()
	{
		$this->form_validation->set_rules('noInvoice', 'Invoice ID', 'trim|required');
		$this->form_validation->set_rules('type', 'Type Storage-Parking', 'trim|required');
		$this->form_validation->set_rules('kodeCus', 'Customer ID', 'trim|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
		$this->form_validation->set_rules('jumlahKendaraan', 'Jumlah Kendaraan', 'trim|required');
		$this->form_validation->set_rules('hargaParkir', 'Harga Parkir', 'trim|required');
		$this->form_validation->set_rules('hargaGudang', 'Harga Gudang', 'trim|required');
		$this->form_validation->set_rules('total', 'Total', 'trim|required');

		$post = $this->input->post();
		if ($this->form_validation->run() == TRUE) {

			$jumlahKendaraan = $post['jumlahKendaraan'];
			$hargaParkir = $post['hargaParkir'];
			$hargaGudang = $post['hargaGudang'];
			$total = ($jumlahKendaraan * $hargaParkir) + $hargaGudang;

			$data = [
				'noInvoice' => $post['noInvoice'],
				'type' => $post['type'],
				'kodeCus' => $post['kodeCus'],
				'tanggal' => $post['tanggal'],
				'keterangan' => $post['keterangan'],
				'jumlahKendaraan' => $jumlahKendaraan,
				'hargaParkir' => $hargaParkir,
				'hargaGudang' => $hargaGudang,
				'total' => $total
			];

			$result = $this->M_storageParking->insert($data);

				if ($result > 0) {
					$out['status'] = '';
					$out['msg'] = show_succ_msg('Storage/Parking Bill Added successfully', '20px');
				} else {
					$out['status'] = '';
					$out['msg'] = show_err_msg('Storage/Parking Bill Failed To Add', '20px');
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

		$data['dataStorageParking'] = $this->M_storageParking->select_by_id($id);
		$data['dataCustomer'] = $this->M_customer->select_all();
		$data['userdata'] = $this->userdata;

		echo show_my_modal('modals/modal_update_storageParking', 'update-storageParking', $data);
	}

	public function prosesUpdate()
	{
		$this->form_validation->set_rules('kodeCus', 'Customer ID', 'trim|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
		$this->form_validation->set_rules('jumlahKendaraan', 'Jumlah Kendaraan', 'trim|required');
		$this->form_validation->set_rules('hargaParkir', 'Harga Parkir', 'trim|required');
		$this->form_validation->set_rules('hargaGudang', 'Harga Gudang', 'trim|required');
		$this->form_validation->set_rules('total', 'Total', 'trim|required');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {

			$jumlahKendaraan = $post['jumlahKendaraan'];
			$hargaParkir = $post['hargaParkir'];
			$hargaGudang = $post['hargaGudang'];
			$total = ($jumlahKendaraan * $hargaParkir) + $hargaGudang;

			$data = [
				'noInvoice' => $post['noInvoice'],
				'kodeCus' => $post['kodeCus'],
				'tanggal' => $post['tanggal'],
				'keterangan' => $post['keterangan'],
				'jumlahKendaraan' => $jumlahKendaraan,
				'hargaParkir' => $hargaParkir,
				'hargaGudang' => $hargaGudang,
				'total' => $total
			];

			$result = $this->M_storageParking->update($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Storage/Parking Bill Successfully Changed', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Storage/Parking Bill Failed To Change', '20px');
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
		$result = $this->M_storageParking->delete($id);

		if ($result > 0) {
			echo show_succ_msg('Storage/Parking Bill Successfully Deleted', '20px');
		} else {
			echo show_err_msg('Storage/Parking Bill Failed To Delete', '20px');
		}
	}

	public function detail()
	{
		$data['userdata'] 	= $this->userdata;
		
		$id = trim($_POST['id']);
		$data['dataStorageParking'] = $this->M_storageParking->select_detail($id);

		echo show_my_modal('modals/modal_detail_storageParking', 'detail-storageParking', $data, 'lg');
	}

	public function export()
	{
		error_reporting(E_ALL);

		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data= $this->M_storageParking->select_all_storageParking();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowCount = 1;

		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('bfb8b8');
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode("_(* #,##0_);_(* \(#,##0\);_(* \"-\"??_);_(@_)");

		for ($i = 'A'; $i < 'J'; $i++) {
			$objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "Storage/Parking Bill Code");
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Cus. ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "Date");
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "Keterangan");
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "Jumlah Kendaraan");
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "Harga Parkir");
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "Harga Gudang");
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, "Total");
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, "Type");
		$rowCount++;

		foreach ($data as $value) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->no_invoice);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->id_customer);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->tanggal);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->keterangan);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->jumlah_kendaraan);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->harga_parkir);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value->harga_gudang);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value->total);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value->nama_type);
			$rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('./assets/excel/Storage-Parking Bills.xlsx');

		$this->load->helper('download');
		force_download('./assets/excel/Storage-Parking Bills.xlsx', NULL);
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
				$type_storage = 1;
				$type_parking = 2;
				foreach ($sheetData as $key => $value) {
					if ($key != 1) {
						$check = $this->M_storageParking->check_invoice($value['A']);
						$checkcustomer = $this->M_customer->check_customer($value['B']);
						if ($value['A'] != '') {
							if ($check != 1) {
								if ($checkcustomer != 0) {
									if($value['I'] == 'Storage') {
										$resultData[$index]['no_invoice'] = $value['A'];
										$resultData[$index]['id_type_sp'] = $type_storage;
										$resultData[$index]['id_customer'] = $value['B'];
										$resultData[$index]['tanggal'] = $value['C'];
										$resultData[$index]['keterangan'] = $value['D'];
										$resultData[$index]['jumlah_kendaraan'] = $value['E'];
										$resultData[$index]['harga_parkir'] = ceil($value['F']);
										$resultData[$index]['harga_gudang'] = ceil($value['G']);
										$resultData[$index]['total'] = ceil($value['H']);
									}
									else if($value['I'] == 'Parking') {
										$resultData[$index]['no_invoice'] = $value['A'];
										$resultData[$index]['id_type_sp'] = $type_parking;
										$resultData[$index]['id_customer'] = $value['B'];
										$resultData[$index]['tanggal'] = $value['C'];
										$resultData[$index]['keterangan'] = $value['D'];
										$resultData[$index]['jumlah_kendaraan'] = $value['E'];
										$resultData[$index]['harga_parkir'] = ceil($value['F']);
										$resultData[$index]['harga_gudang'] = ceil($value['G']);
										$resultData[$index]['total'] = ceil($value['H']);
									}
								}
							}
						}
					}
					$index++;
				}
				
				unlink('./assets/excel/' . $data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_storageParking->insert_batch($resultData);
					if ($result > 0) {
						$this->session->set_flashdata('msg', show_succ_msg('Storage/Parking Bills Successfully Imported To Database'));
						redirect('StorageParking');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Storage/Parking Bills Failed To Import Into Database (Data Has Been Updated)', 'warning', 'fa-warning'));
					redirect('StorageParking');
				}
			}
		}
	}
}

/* End of file StorageParking.php */
/* Location: ./application/controllers/StorageParking.php */

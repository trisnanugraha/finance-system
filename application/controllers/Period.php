<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Period extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_period');
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		$data['dataPeriod'] = $this->M_period->select_all();

		$data['page'] = "period";
		$data['judul'] = "Period List";
		$data['deskripsi'] = "Manage Period List";

		$data['modal_tambah_period'] = show_my_modal('modals/modal_tambah_period', 'tambah-period', $data);

		$js = $this->load->view('period/period-js', null, true);
		$this->template->views('period/home', $data, $js);
	}

	public function tampil()
	{
		$data['dataPeriod'] = $this->M_period->select_all();
		$this->load->view('period/list_data', $data);
	}

	public function prosesTambah()
	{
		$this->form_validation->set_rules('tambahPeriodRange', 'Period Range', 'trim|required');
		$this->form_validation->set_rules('tambahDueDate', 'Due Date', 'trim|required');

		$data = $this->input->post();

		if ($this->form_validation->run() == TRUE) {
			$dtStart = new DateTime($this->input->post('hiddenPeriodStart'));
			$dtEnd = new DateTime($this->input->post('hiddenPeriodEnd'));
			$diff = $dtEnd->diff($dtStart)->format('%a');
			$data = [
				'periodStart' => $this->input->post('hiddenPeriodStart'),
				'periodEnd' => $this->input->post('hiddenPeriodEnd'),
				'periodDue' => $this->input->post('hiddenPeriodDue'),
				'amountDays' => $diff
			];

			$result = $this->M_period->insert($data);

			if ($result > 0) {
				helper_log("add", "Menambah Data (Period)");
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Period List Added successfully', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Period List Failed To Add', '20px');
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

		$data['dataPeriod'] = $this->M_period->select_by_id($id);
		$data['userdata'] = $this->userdata;

		echo show_my_modal('modals/modal_update_period', 'update-period', $data);
	}

	public function prosesUpdate()
	{
		$this->form_validation->set_rules('periodRange', 'Period Range', 'trim|required');
		$this->form_validation->set_rules('dueDate', 'Period End', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			if (!$this->M_period->already_in_used($this->input->post('id'))) {

				$dtStart = new DateTime($this->input->post('hiddenPeriodStart'));
				$dtEnd = new DateTime($this->input->post('hiddenPeriodEnd'));
				$diff = $dtEnd->diff($dtStart)->format('%a');
				$data = [
					'periodStart' => $this->input->post('hiddenPeriodStart'),
					'periodEnd' => $this->input->post('hiddenPeriodEnd'),
					'periodDue' => $this->input->post('hiddenPeriodDue'),
					'amountDays' => $diff + 1,
					'id' => $this->input->post('id')
				];

				$result = $this->M_period->update($data);

				if ($result > 0) {
					helper_log("edit", "Mengubah Data (Period)", $data['id']);
					$out['status'] = '';
					$out['msg'] = show_succ_msg('Period List Updated successfully', '20px');
				} else {
					$out['status'] = '';
					$out['msg'] = show_err_msg('Period List Failed To Update', '20px');
				}
			} else {

				$out['status'] = '';
				$out['msg'] = show_err_msg('Period Failed To Update, Period already in used', '20px');
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
		$result = $this->M_period->delete($id);

		if ($result > 0) {
			helper_log("delete", "Menghapus Data (Period)", $id);
			echo show_succ_msg('Period List Deleted Successfully', '20px');
		} else {
			echo show_err_msg('Period List Failed To Delete', '20px');
		}
	}

	public function export()
	{
		error_reporting(E_ALL);

		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_period->export();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowCount = 1;

		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->getStartColor()->setARGB('bfb8b8');
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);

		// $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

		for ($i = 'A'; $i < 'N'; $i++) {
			$objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}


		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "Period ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Start Period");
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "End Period");
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "Due Date");
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "Amount Days");
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "Created At");

		$rowCount++;

		foreach ($data as $value) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->id);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->periodStart);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->periodEnd);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->dueDate);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->amount);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->created_at);
			$rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('./assets/excel/Period List.xlsx');
		$this->load->helper('download');
		helper_log("export", "Export Data (Period)");
		force_download('./assets/excel/Period List.xlsx', NULL);
		
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

						if($value['A'] != ''){
							$resultData[$index]['start_periode'] = $value['A'];
							$resultData[$index]['end_periode'] = ($value['B']);
							$resultData[$index]['due_date'] = ($value['C']);
							$dtStart = new DateTime($value['A']);
							$dtEnd = new DateTime($value['B']);
							$diff = $dtEnd->diff($dtStart)->format('%a');

							$resultData[$index]['amount_days'] = $diff;
						}
					}
					$index++;
				}

				unlink('./assets/excel/' . $data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_period->insert_batch($resultData);
					if ($result > 0) {
						helper_log("import", "Import Data (Period)");
						$this->session->set_flashdata('msg', show_succ_msg('Period List Successfully Imported To Database'));
						redirect('Period');
					}
				} else {
					var_dump($resultData);
					die();
					$this->session->set_flashdata('msg', show_msg('Period List Failed To Import Into Database (Data Has Been Updated)', 'warning', 'fa-warning'));
					redirect('Period');
				}
			}
		}
	}
	public function getPeriodJson()
	{
		$dataPeriod = $this->M_period->select_all_periode();

		$response = [
			"data" => $dataPeriod
		];
		echo json_encode($response);
	}
}

/* End of file Period.php */
/* Location: ./application/controllers/Period.php */

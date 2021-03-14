<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CF extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_gl');
		$this->load->model('M_coa');
		$this->load->model('M_period');
		$this->load->library('pdf');
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		$data['dataCF'] = $this->M_gl->select_cf();
		$data['dataCoA'] = $this->M_coa->select_all();
		$data['page'] = "Cash Flow";
		$data['judul'] = "Cash Flow";
		$data['deskripsi'] = "Manage Cash Flow Data";
		$data['modal_tambah_mtd'] = show_my_modal('modals/modal_tambah_mtd', 'tambah-mtd', $data);
		$data['modal_tambah_ytd'] = show_my_modal('modals/modal_tambah_ytd', 'tambah-ytd', $data);
		$js = $this->load->view('cf/cf-js', null, true);
		$this->template->views('cf/home', $data, $js);
	}

	public function tampil()
	{
		$startDate = $this->input->get("startDate");
		$data['dataCF'] = $this->M_gl->select_filter_cf($startDate);
		$this->load->view('cf/list_data', $data);
	}

	public function tambahMTD()
	{
		$this->form_validation->set_rules('mtd_coa', 'MTD CoA', 'trim|required');
		$this->form_validation->set_rules('mtd_month', 'MTD MONTH', 'trim|required');
		$this->form_validation->set_rules('mtd_year', 'MTD YEAR', 'trim|required');
		$this->form_validation->set_rules('mtd_total', 'MTD TOTAL', 'trim|required');
		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_gl->insert_mtd($data);
			if ($result > 0) {
				helper_log("add", "Menambah Data (MTD Budget)");
				$out['status'] = '';
				$out['msg'] = show_succ_msg('MTD BUDGET Successfully Added', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('MTD BUDGET Failed To Add', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function tambahYTD()
	{
		$this->form_validation->set_rules('ytd_coa', 'MTD CoA', 'trim|required');
		$this->form_validation->set_rules('ytd_year', 'MTD YEAR', 'trim|required');
		$this->form_validation->set_rules('ytd_total', 'MTD TOTAL', 'trim|required');
		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_gl->insert_ytd($data);
			if ($result > 0) {
				helper_log("add", "Menambah Data (YTD Budget)");
				$out['status'] = '';
				$out['msg'] = show_succ_msg('YTD BUDGET Successfully Added', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('YTD BUDGET Failed To Add', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}
		echo json_encode($out);
	}

	public function print()
	{
		$date = $this->input->post('date');
		$jt = $this->M_gl->print_cf($date);
		$pd = $this->M_gl->pendapatan($date);
		$pg = $this->M_gl->pengeluaran($date);
		$sa = $this->M_gl->saldo($date);
		if ($jt != null) {
			$data['dataJurnal'] = $jt;
			$data['dataPendapatan'] = $pd;
			$data['dataPengeluaran'] = $pg;
			$data['dataSaldo'] = $sa;
			$data['date'] = $date;
			$html = $this->load->view('cf/print', $data, true);
			$filename = 'Cash_Flow_' . time();
			$this->pdf->generate($html, $filename, true, 'letter');
		} else {
			redirect('/CF', 'refresh');
		}
	}
}

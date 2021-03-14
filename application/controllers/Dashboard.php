<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_customer');
		$this->load->model('M_owner');
	}

	public function index()
	{
		$data['jml_customer'] = $this->M_customer->total_rows();
		$data['jml_owner'] = $this->M_owner->total_rows();
		$data['userdata'] = $this->userdata;
		$data['page'] = "dashboard";
		$data['judul'] = "Dashboard";
		$data['deskripsi'] = "";
		$this->template->views('dashboard', $data);
	}
}
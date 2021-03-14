<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_auth');
	}

	public function index()
	{
		$session = $this->session->userdata('status');
		if ($session == '') {
			$this->load->view('login');
		} else {
			redirect('Dashboard');
		}
	}

	public function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == TRUE) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$data = $this->M_auth->login($username, $password);
			if ($data == false) {
				$this->session->set_flashdata('error_msg', 'Your username or password is incorrect');
				redirect('Auth');
			} else {
				$session = [
					'userdata' => $data,
					'status' => "Loged in"
				];

				$this->session->set_userdata('username', $username);
				$this->session->set_userdata($session);
				$ip = $this->input->ip_address();
				helper_log("login", "User Masuk Ke Sistem", "", $ip);
				if ($data->role_id == 0) {
					redirect('Dashboard');
				} else if ($data->role_id == 1) {
					redirect('Dashboard');
				} else if ($data->role_id == 3) {
					redirect('Teknisi');
				} else {
					redirect('User');
				}
			}
		} else {
			$this->session->set_flashdata('error_msg', validation_errors());
			redirect('Auth');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		helper_log("logout", "User Keluar Dari Sistem");
		redirect('Auth');
	}
}
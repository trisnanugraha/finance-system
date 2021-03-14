<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_log');
    }

    public function index()
    {
        $data['dataLog']     = $this->M_log->select_all();
        $data['userdata']         = $this->userdata;

        $data['page']             = "log";
        $data['judul']             = "Log";
        $data['deskripsi']         = "Log Aktivitas";

        $js = $this->load->view('log/log-js', null, true);
        $this->template->views('log/home', $data, $js);
    }

    public function tampil()
    {
        $data['dataLog'] = $this->M_log->select_all();
        $this->load->view('log/list_data', $data);
    }
}

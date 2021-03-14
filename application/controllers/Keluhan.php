<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluhan extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_keluhan');
        $this->load->model('M_parameter');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['dataKeluhan']     = $this->M_keluhan->select_all();
        $data['userdata']         = $this->userdata;

        $data['page']             = "keluhan";
        $data['judul']             = "Keluhan";
        $data['deskripsi']         = "";

        $js = $this->load->view('keluhan/keluhan-js', null, true);
        $this->template->views('keluhan/home', $data, $js);
    }

    public function tampil()
    {
        $data['dataKeluhan'] = $this->M_keluhan->select_all();
        $this->load->view('keluhan/list_data', $data);
    }

    public function detail()
    {

        $id                 = trim($_POST['id']);
        $data['dataKeluhan'] = $this->M_keluhan->select_detail($id);

        echo show_my_modal('modals/modal_detail_keluhan_admin', 'detail-keluhan', $data, 'lg');
    }

    public function print()
    {
        $dateA = $this->input->post('dateA');
        $dateB = $this->input->post('dateB');

        $keluhan = $this->M_keluhan->print($dateA, $dateB);

        if ($keluhan != null) {
            $signature = $this->M_parameter->select_by_id('authorized_signature_billing_key');

            $data['dataKeluhan'] = $keluhan;
            $data['dateA'] = $dateA;
            $data['dateB'] = $dateB;
            $data['signature'] = $signature;

            $html = $this->load->view('keluhan/print', $data, true);
            $filename = 'keluhan_' . $keluhan->kode_keluhan;
            $this->pdf->generate($html, $filename, true, 'letter');
        } else {
            redirect('/Keluhan', 'refresh');
        }
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teknisi extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_keluhan');
    }

    public function index()
    {
        $data['dataKeluhan']     = $this->M_keluhan->select_all();
        $data['userdata']         = $this->userdata;

        $data['page']             = "keluhan";
        $data['judul']             = "Keluhan";
        $data['deskripsi']         = "";

        $js = $this->load->view('teknisi/teknisi-js', null, true);
        $this->template->views('teknisi/home', $data, $js);
    }

    public function tampil()
    {
        $data['dataKeluhan'] = $this->M_keluhan->select_all();
        $this->load->view('teknisi/list_data', $data);
    }

    public function update()
    {
        $data['userdata']     = $this->userdata;
        $id                 = trim($_POST['id']);

        $data['dataKeluhan']     = $this->M_keluhan->select_update($id);

        echo show_my_modal('modals/modal_update_keluhan', 'update-keluhan', $data);
    }

    public function prosesUpdate()
    {
        $this->form_validation->set_rules('penyebab', 'Penyebab Keluhan', 'trim|required');
        $this->form_validation->set_rules('tindakan', 'Tindakan Penyelesaian Keluhan', 'trim');
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Keluhan Ditindak Lanjuti', 'trim|required');
        $this->form_validation->set_rules('status', 'Status Keluhan', 'trim|required');
        $this->form_validation->set_rules('pending', 'Alasan Pending Keluhan', 'trim');

        $data = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $result = $this->M_keluhan->update($data);

            if ($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Bank Account Successfully Changed', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Bank Account Failed To Change', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }
}

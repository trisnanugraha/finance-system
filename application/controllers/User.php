<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_ar');
        $this->load->model('M_keluhan');
        $this->load->model('M_coa');
        $this->load->model('M_billing');
        $this->load->model('M_period');
        $this->load->model('M_customer');
        $this->load->model('M_electricity');
        $this->load->model('M_water');
        $this->load->model('M_candidate_key');
        $this->load->model('M_bayar');
        $this->load->model('M_rates');
        $this->load->model('M_service');
        $this->load->model('M_owner');
        $this->load->model('M_parameter');
        $this->load->model('M_pinalty');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['dataAR']     = $this->M_ar->tagihan($this->userdata->username);
        $data['userdata']         = $this->userdata;

        $data['page']             = "tagihan";
        $data['judul']             = "Tagihan";
        $data['deskripsi']         = "";
        $this->template->views('user/tagihan', $data);
    }

    public function keluhan()
    {
        $data['dataKeluhan']     = $this->M_keluhan->select_all();
        $data['userdata']         = $this->userdata;

        $data['page']             = "keluhan pelanggan";
        $data['judul']             = "Keluhan Pelanggan";
        $data['deskripsi']         = "";

        $data['modal_tambah_keluhan'] = show_my_modal('modals/modal_tambah_keluhan', 'tambah-keluhan', $data);

        $js = $this->load->view('user/keluhan-js', null, true);
        $this->template->views('user/keluhan', $data, $js);
    }

    public function tampil()
    {
        $data['dataKeluhan'] = $this->M_keluhan->select_all();
        $this->load->view('user/list_data', $data);
    }

    public function prosesTambah()
    {
        $this->form_validation->set_rules('date', 'Tanggal Keluhan', 'trim|required');
        $this->form_validation->set_rules('uraian', 'Uraian Keluhan', 'trim|required');

        $post = $this->input->post();
        if ($this->form_validation->run() == TRUE) {

            $dt = DateTime::createFromFormat("Y-m-d", $post['date']);
            $dtNextMonth = $dt->modify('first day of next month');
            $year = $dtNextMonth->format('y');
            $month = $dtNextMonth->format('m');

            $currentNumber = $this->M_keluhan->get_last_id($dtNextMonth);

            $formatKeluhanId = $this->M_candidate_key->select_by_id('keluhan_key');

            $id = str_replace('@year', $year, $formatKeluhanId->key);
            $id = str_replace('@month', $month, $id);
            $id = str_replace('@counter', str_pad($currentNumber->maxNumber, $formatKeluhanId->counter_count, '0', STR_PAD_LEFT), $id);

            $data = [
                'kode_keluhan' => $id,
                'id_admin' => $this->userdata->id,
                'tanggal_keluhan' => $post['date'],
                'uraian' => $post['uraian'],
                'status' => 0,
                'd_c_note_date' => $dtNextMonth->format('Y/m/d')
            ];

            $result = $this->M_keluhan->insert($data);

            if ($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Keluhan Successfully Added', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Keluhan Failed To Add', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }

    public function detail()
    {

        $id                 = trim($_POST['id']);
        $data['dataKeluhan'] = $this->M_keluhan->select_detail($id);

        echo show_my_modal('modals/modal_detail_keluhan', 'detail-keluhan', $data, 'lg');
    }

    public function delete()
    {
        $id = $_POST['id'];
        $checkstatus = $this->M_keluhan->select_detail($id);

        if ($checkstatus->status == 1) {
            echo show_err_msg('Keluhan Telah Ditindak Lanjuti, Unable to Delete', '20px');
        } else if ($checkstatus->status == 2) {
            echo show_err_msg('Keluhan Sedang Ditindak Lanjuti, Unable to Delete', '20px');
        } else {
            $result = $this->M_keluhan->delete($id);

            if ($result > 0) {
                echo show_succ_msg('Keluhan Successfully Deleted', '20px');
            } else {
                echo show_err_msg('Keluhan Failed To Delete', '20px');
            }
        }
    }
}

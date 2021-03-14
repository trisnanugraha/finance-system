<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coa extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_coa');
		$this->load->model('M_coa_type');
	}

	public function index() {
		$data['userdata'] = $this->userdata;
		$data['dataCoa'] = $this->M_coa->select_all();
		$data['dataType'] = $this->M_coa_type->select_all();
		$data['page'] = "CoA";
		$data['judul'] = "Charts Of Accounts";
		$data['deskripsi'] = "Manage Charts Of Accounts";
		$data['modal_tambah_coa'] = show_my_modal('modals/modal_tambah_coa', 'tambah-coa', $data);
		$js = $this->load->view('coa/coa-js', null, true);
		$this->template->views('coa/home', $data, $js);
	}

	public function tampil() {
		$data['dataCoa'] = $this->M_coa->select_all();
		$this->load->view('coa/list_data', $data);
	}
	
	public function prosesTambah(){
		$this->form_validation->set_rules('parent', 'CoA Parent', 'trim|required');
		$this->form_validation->set_rules('coa_id', 'CoA ID', 'trim|required');
		$this->form_validation->set_rules('coa_name', 'CoA Name', 'trim|required');
		$this->form_validation->set_rules('acc_type', 'Account Type', 'trim|required');
		$this->form_validation->set_rules('jurnal', 'Jurnal Type', 'trim|required');
        $post = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $data = [
                'parent' => $post['parent'],
                'coa_id' => $post['coa_id'],
                'coa_name' => $post['coa_name'],
                'acc_type' => $post['acc_type'],
                'jurnal_tipe' => $post['jurnal']
            ];
            $result = $this->M_coa->insert($data);
            if ($result > 0) {
				helper_log("add", "Menambah Data (COA)", $data['coa_id']);
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Charts Of Accounts Data Successfully Added', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Charts Of Accounts Data Failed To Add', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }
        echo json_encode($out);
	}
	
	public function delete() {
		$id = $_POST['id_akun'];
		$result = $this->M_coa->delete($id);
		if ($result) {
			helper_log("delete", "Menghapus Data (COA)", $id);
			echo show_succ_msg('Charts Of Accounts Data Successfully Deleted', '20px');
		} else {
			echo show_err_msg('Charts Of Accounts Data Failed To Delete', '20px');
		}
	}

	public function getAkunJson()
	{
		$dataAkun = $this->M_coa->select_all_coa();
		$response = [
			"data" => $dataAkun
		];
		echo json_encode($response);
	}

	public function getAkunARJson()
	{
		$dataAkun = $this->M_coa->select_all_coa_ar();
		$response = [
			"data" => $dataAkun
		];
		echo json_encode($response);
	}
}
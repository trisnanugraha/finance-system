<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Description extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_description');
	}

	public function index() {
		$data['userdata'] = $this->userdata;
        $data['dataDescription'] = $this->M_description->select_all();
        
		$data['page'] = "description";
		$data['judul'] = "Description";
		$data['deskripsi'] = "Manage Description Data";

		$js = $this->load->view('description/description-js', null, true);
		$this->template->views('description/home', $data, $js);
	}

	public function tampil() {
		$data['dataDescription'] = $this->M_description->select_all();
		$this->load->view('description/list_data', $data);
	}

	public function update() {
		$id = trim($_POST['id']);

		$data['dataDescription'] = $this->M_description->select_by_id($id);
		$data['userdata'] = $this->userdata;

		echo show_my_modal('modals/modal_update_description', 'update-description', $data);
	}

	public function prosesUpdate() {
		$this->form_validation->set_rules('jenis', 'Group', 'trim|required');
		$this->form_validation->set_rules('sqm', 'Spacius Room', 'trim|required');
		$this->form_validation->set_rules('kapasitas', 'Electricity Capacity', 'trim|required');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_description->update($data);

			if ($result > 0) {
				$out['status'] = '';
				helper_log("edit", "Mengubah Data (Description)");
				$out['msg'] = show_succ_msg('Description Data Successfully Changed', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Description Data Failed To Change', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

}

/* End of file Description.php */
/* Location: ./application/controllers/Description.php */
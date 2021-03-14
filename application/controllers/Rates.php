<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rates extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_rates');
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		$data['dataRates'] = $this->M_rates->select_all();

		$data['page'] = "Rates";
		$data['judul'] = "Rates List";
		$data['deskripsi'] = "Manage Rates List";
		$data['modal_tambah_rate'] = show_my_modal('modals/modal_tambah_rates', 'tambah-rates', $data);

		$js = $this->load->view('rates/rates-js', null, true);
		$this->template->views('rates/home', $data, $js);
	}

	public function tampil()
	{
		$data['dataRates'] = $this->M_rates->select_all();
		$this->load->view('rates/list_data', $data);
	}

	public function tampilCurrentRate()
	{
		$data['current_rate'] = $this->M_rates->current_rate();
		$this->load->view('rates/current_rate', $data);
	}

	public function update()
	{
		$id = trim($_POST['id']);

		$data['dataRates'] = $this->M_rates->select_by_id($id);
		$data['userdata'] = $this->userdata;

		echo show_my_modal('modals/modal_update_rates', 'update-rates', $data);
	}

	public function delete()
	{
		$id = $_POST['id'];
		$result = $this->M_rates->delete($id);

		if ($result > 0) {
			helper_log("delete", "Menghapus Data (Rates)", $id);
			echo show_succ_msg('Rate Successfully Deleted', '20px');
		} else {
			echo show_err_msg('Rate Failed To Delete', '20px');
		}
	}

	public function prosesTambah()
	{
		$this->form_validation->set_rules('charge', 'Standing Charge', 'trim|required');
		$this->form_validation->set_rules('water', 'Water', 'trim|required');
		$this->form_validation->set_rules('electric', 'Electricity', 'trim|required');
		$this->form_validation->set_rules('sinking', 'Sinking Fund', 'trim|required');
		$this->form_validation->set_rules('service', 'Service Charge', 'trim|required');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_rates->insert($data);

			if ($result > 0) {
                helper_log("add", "Menambah Data (Rates)");
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Rate Data Successfully Added', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Rate Data Failed To Add', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}


	public function prosesUpdate()
	{
		$this->form_validation->set_rules('charge', 'Standing Charge', 'trim|required');
		$this->form_validation->set_rules('water', 'Water', 'trim|required');
		$this->form_validation->set_rules('electric', 'Electricity', 'trim|required');
		$this->form_validation->set_rules('sinking', 'Sinking Fund', 'trim|required');
		$this->form_validation->set_rules('service', 'Service Charge', 'trim|required');


		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			if (!$this->M_rates->already_in_used($data['id'])) {

				$result = $this->M_rates->update($data);

				if ($result > 0) {
					helper_log("edit", "Mengubah Data (Rates)");
					$out['status'] = '';
					$out['msg'] = show_succ_msg('Rates List Successfully Updated', '20px');
				} else {
					$out['status'] = '';
					$out['msg'] = show_err_msg('Rates List Failed To Update', '20px');
				}
			} else {

				$out['status'] = '';
				$out['msg'] = show_err_msg('Rates List Failed To Update, Rate already in used', '20px');
			}
			
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}
}

/* End of file Rates.php */
/* Location: ./application/controllers/Rates.php */

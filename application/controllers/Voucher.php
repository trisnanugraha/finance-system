<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_voucher');
		$this->load->model('M_customer');
		$this->load->model('M_giro_type');
		$this->load->model('M_bayar');
		$this->load->model('M_ar');
		$this->load->model('M_gl');
		$this->load->model('M_owner');
		$this->load->model('M_period');
		$this->load->model('M_billing');
		$this->load->model('M_service');
		$this->load->model('M_iuran');
		$this->load->model('M_asuransi');
		$this->load->model('M_type_pembayaran');
		$this->load->model('M_coa');
		$this->load->model('M_candidate_key');
		$this->load->library('pdf');
		$this->load->library('pdf_setengah');
		$this->load->library('pdf_setengah2');

		// $this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		// $data['dataVoucher'] = $this->M_voucher->select_all();
		// $data['dataCustomer'] = $this->M_customer->select_all();
		// $data['dataOwner'] = $this->M_owner->select_all();
		$data['dataGiroType'] = $this->M_giro_type->select_all();
		// $data['dataBayar'] = $this->M_bayar->select_all();
		// $data['dataAR'] = $this->M_ar->select_all();
		$data['dataCoA'] = $this->M_coa->select_all();
		$data['dataBank'] = $this->M_coa->select_bank();
		$data['dataPemType'] = $this->M_type_pembayaran->select_all();

		$data['page'] = "Voucher";
		$data['judul'] = "Voucher";
		$data['deskripsi'] = "Manage Voucher Data";

		$data['modal_tambah_voucher'] = show_my_modal('modals/modal_tambah_voucher', 'tambah-voucher', $data);
		$data['modal_pengurangan_bank'] = show_my_modal('modals/modal_pengurangan_bank', 'pengurangan-bank', $data);

		$js = $this->load->view('voucher/voucher-js', null, true);
		$this->template->views('voucher/home', $data, $js);
	}

	public function indexBayar()
	{
		$data['userdata'] = $this->userdata;
		// $data['dataVoucher'] = $this->M_voucher->select_all();
		// $data['dataCustomer'] = $this->M_customer->select_all();
		$data['dataOwner'] = $this->M_owner->select_all();
		$data['dataGiroType'] = $this->M_giro_type->select_all();
		// $data['dataBayar'] = $this->M_bayar->select_all();
		$data['dataAR'] = $this->M_ar->select_all();
		$data['dataCoA'] = $this->M_coa->select_all();
		// $data['dataBank'] = $this->M_coa->select_bank();
		$data['dataPemType'] = $this->M_type_pembayaran->select_all();

		$data['page'] = "Pembayaran Piutang";
		$data['judul'] = "Pembayaran Piutang";
		$data['deskripsi'] = "Manage Pembayaran Piutang Data";

		$js = $this->load->view('voucher/voucher-js', null, true);
		$this->template->views('modals/modal_bayar_ar', $data, $js);
	}

	public function indexBayarDeposit()
	{
		$data['userdata'] = $this->userdata;
		// $data['dataVoucher'] = $this->M_voucher->select_all();
		$data['dataTitipan'] = $this->M_voucher->select_all_titipan();
		// $data['dataCustomer'] = $this->M_customer->select_all();
		// $data['dataOwner'] = $this->M_owner->select_all();
		$data['dataGiroType'] = $this->M_giro_type->select_all();
		// $data['dataBayar'] = $this->M_bayar->select_all();
		$data['dataAR'] = $this->M_ar->select_all();
		$data['dataCoA'] = $this->M_coa->select_all();
		// $data['dataBank'] = $this->M_coa->select_bank();
		$data['dataPemType'] = $this->M_type_pembayaran->select_all();

		$data['page'] = "Pembayaran Piutang";
		$data['judul'] = "Pembayaran Piutang";
		$data['deskripsi'] = "Manage Pembayaran Piutang Data";

		$js = $this->load->view('voucher/voucher-js', null, true);
		$this->template->views('modals/modal_bayar_ar_titipan', $data, $js);
	}

	public function tampil()
	{
		$startDate = $this->input->get("startDate");
		$endDate = $this->input->get("endDate");
		$data['dataVoucher'] = $this->M_voucher->select_filter($startDate, $endDate);
		$this->load->view('voucher/list_data', $data);
	}

	public function prosesTambah()
	{
		$post = $this->input->post(null, TRUE);

		$result = $this->M_voucher->insert($post);

		if ($result > 0) {
			$this->M_gl->insert_vou($post);
			helper_log("add", "Menambah Data (Voucher)", $post['code']);
			$out['status'] = '';
			$out['msg'] = show_succ_msg('Voucher Data Successfully Added', '20px');
		} else {
			$out['status'] = '';
			$out['msg'] = show_err_msg('ID Voucher Already Inserted', '20px');
		}

		echo json_encode($out);
	}

	public function cekId()
	{
		if (isset($_POST['cek_submit_btn'])) {
			$voucherId = $_POST['voucher_id'];

			if ($this->M_voucher->check_bill($voucherId) > 0) {
				echo "Voucher ID Already Inserted";
			} else {
				echo "Voucher ID Available";
			}
		}
	}

	public function AR()
	{
		$post = $this->input->post(null, TRUE);

		$result = $this->M_voucher->insert_voucher($post);

		if ($result > 0) {

			$this->M_bayar->insert_out($post);
			$this->M_voucher->insert_titipan($post);
			$this->M_ar->update_ar_out($post);
			$this->M_gl->insert_voucher($post);
			$this->M_billing->pembayaran($post);
			$this->M_service->pembayaran($post);
// 			$this->M_iuran->pembayaran($post);
// 			$this->M_asuransi->pembayaran($post);

			helper_log("add", "Pembayaran (Piutang)", $post['bukti_transaksi']);
			$out['status'] = '';
			$out['msg'] = show_succ_msg('Pembayaran Piutang Successfully', '20px');
		} else {
			$out['status'] = '';
			$out['msg'] = show_err_msg('ID Voucher Already Inserted', '20px');
		}

		echo json_encode($out);
	}

	public function ART()
	{
		$post = $this->input->post(null, TRUE);

		$result = $this->M_voucher->insert_voucher_titipan($post);

		if ($result > 0) {

			$this->M_bayar->insert_out($post);
			$this->M_voucher->titipan_out($post);
			$this->M_ar->update_ar_out($post);
			$this->M_gl->insert_titipan($post);

			$this->M_billing->pembayaran($post);
			$this->M_service->pembayaran($post);
// 			$this->M_iuran->pembayaran($post);
// 			$this->M_asuransi->pembayaran($post);
			
			helper_log("add", "Pembayaran Titipan (Piutang)", $_POST['vouId']);
			$out['status'] = '';
			$out['msg'] = show_succ_msg('Pembayaran Piutang Successfully', '20px');
		} else {
			$out['status'] = '';
			$out['msg'] = show_err_msg('ID Voucher Already Inserted', '20px');
		}

		echo json_encode($out);
	}

	public function delete()
	{
		$id = $_POST['idVou'];

		$this->M_gl->update_voucher($id);
		$this->M_ar->update_bayar($id);
		$this->M_gl->update_bayar($id);
		// $this->M_gl->update_vendor($id);
		$this->M_billing->update_bayar($id);
		$this->M_service->update_bayar($id);
		$this->M_voucher->update_vendor($id);
		$this->M_voucher->delete_titipan($id);
		$this->M_bayar->delete($id);
		$result = $this->M_voucher->delete($id);

		if ($result) {
			helper_log("delete", "Menghapus Data (Voucher)", $id);
			echo show_succ_msg('Voucher Data Successfully Deleted', '20px');
		} else {
			echo show_err_msg('Voucher Data Failed To Delete', '20px');
		}
	}

	public function deleteBayar()
	{
		$id = $_POST['idBayar'];

		$this->M_voucher->update_bayar($id);
		$this->M_ar->update_bayar($id);
		$this->M_gl->update_bayar($id);
		$this->M_billing->update_bayar($id);
		$this->M_service->update_bayar($id);

		$result = $this->M_bayar->delete($id);

		if ($result) {
			helper_log("delete", "Menghapus Data Bayar (Voucher)", $id);
			echo show_succ_msg('Voucher Data Successfully Deleted', '20px');
		} else {
			echo show_err_msg('Voucher Data Failed To Delete', '20px');
		}
	}

	public function print_received($id)
	{
		$voucher = $this->M_voucher->print_received($id);

		if ($voucher != null) {

			$data['dataVoucher'] = $voucher;

			$html = $this->load->view('voucher/printBukti', $data, true);
			$filename = 'report_' . time();
			$this->pdf_setengah2->generate($html, $filename, true, 'letter');
		} else {
			redirect('/Voucher', 'refresh');
		}
	}

	public function print_bayar($id)
	{
		$voucher = $this->M_voucher->print($id);
		$bayar = $this->M_bayar->select_by_voucher_id($id);
		$vendor = $this->M_voucher->select_by_voucher_id($id);

		if ($voucher != null) {

			$data['dataVoucher'] = $voucher;
			$data['dataBayar'] = $bayar;
			$data['dataVendor'] = $vendor;

			$html = $this->load->view('voucher/print', $data, true);
			$header = $this->load->view('voucher/header', $data, true);
			$footer = $this->load->view('voucher/footer', $data, true);
			$mpdf = new \Mpdf\Mpdf([
				'mode' => 'utf-8',
				'format' => [215, 140],
				'margin_left' => 5,
				'margin_right' => 15,
				'margin_top' => 47,
				'margin_bottom' => 0,
				'margin_header' => 7,
				'margin_footer' => 7.8
			]);
			$mpdf->shrink_tables_to_fit = 0;
			$mpdf->SetHTMLHeader($header);
			$mpdf->setHTMLFooter($footer);
			$mpdf->WriteHTML($html);
			$filename = 'report_' . time();

			$mpdf->Output($filename . ".pdf", \Mpdf\Output\Destination::INLINE);
		} else {
			redirect('/Voucher', 'refresh');
		}
	}

	public function update()
	{
		$id = trim($_POST['id']);

		$voucher = $this->M_voucher->select_by_id($id);

		$data['userdata'] = $this->userdata;
		$data['dataVoucher'] = $voucher;
		// $data['dataTitipan'] = $this->M_voucher->select_all_titipan();
		// $data['dataCustomer'] = $this->M_customer->select_all();
		// $data['dataOwner'] = $this->M_owner->select_all();
		$data['dataGiroType'] = $this->M_giro_type->select_all();
		// $data['dataAR'] = $this->M_ar->select_all();
		$data['dataCoA'] = $this->M_coa->select_all();
		$data['dataBank'] = $this->M_coa->select_bank();
		// $data['dataKas'] = $this->M_coa->select_kas();
		// $data['dataPemType'] = $this->M_type_pembayaran->select_all();

		if ($voucher->so == 3) {
			$data['dataVendor'] = $this->M_voucher->select_by_voucher_id($id);
			echo show_my_modal('modals/modal_update_vendor', 'update-voucher', $data);
		} else {
			$data['dataBayar'] = $this->M_bayar->select_by_voucher_id($id);
			echo show_my_modal('modals/modal_update_bayar', 'update-voucher', $data);
		}

		// $data['page'] = "Update Voucher";
		// $data['judul'] = "Update Voucher";
		// $data['deskripsi'] = "Manage Update Voucher Data";

		// $js = $this->load->view('voucher/voucher-js', null, true);
		// $this->template->views('modals/modal_update_voucher', $data, $js);
	}

	public function prosesUpdate()
	{
		$this->form_validation->set_rules('relasi', 'Nama Relasi', 'trim|required');
		$this->form_validation->set_rules('vouDate', 'Voucher Date', 'trim|required');
		$this->form_validation->set_rules('giro', 'Transaction Type', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'Keterangan Voucher', 'trim|required');
		$this->form_validation->set_rules('bank', 'CoA Bank Voucher', 'trim|required');
		$this->form_validation->set_rules('vouTotal', 'Total Voucher', 'trim|required');
		$this->form_validation->set_rules('coa[]', 'Total Voucher', 'trim|required');
		$this->form_validation->set_rules('debit[]', 'Total Voucher', 'trim|required');
		$this->form_validation->set_rules('credit[]', 'Total Voucher', 'trim|required');

		$post = $this->input->post();

		if ($this->form_validation->run() == TRUE) {
			$voucher = $this->M_voucher->select_by_id($post['id']);
			$coa = $this->M_coa->select_by_coa($voucher->coa_id);

			if ($voucher->so == 3) {
				$this->M_gl->vendor_update($post);
				$this->M_voucher->vendor_update($post);
				$this->M_gl->update($post);
				$result = $this->M_voucher->update($post);

				if ($result > 0) {
					helper_log("edit", "Mengubah Data (Voucher)", $post['id']);
					$out['status'] = '';
					$out['msg'] = show_succ_msg('Voucher Data Successfully Changed', '20px');
				} else {
					$out['status'] = '';
					$out['msg'] = show_err_msg('Voucher Data Failed To Change', '20px');
				}
			} else {
				$this->M_gl->bayar_update($post);
				$this->M_bayar->bayar_update($post);
				$this->M_gl->update($post);
				$result = $this->M_voucher->update($post);

				if ($result > 0) {
					helper_log("edit", "Mengubah Data (Voucher)", $post['id']);
					$out['status'] = '';
					$out['msg'] = show_succ_msg('Voucher Data Successfully Changed', '20px');
				} else {
					$out['status'] = '';
					$out['msg'] = show_err_msg('Voucher Data Failed To Change', '20px');
				}
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function getKodeCusJson()
	{
		$dataBayarPeriod = $this->M_ar->select_all_bayar();

		$response = [
			"data" => $dataBayarPeriod
		];
		echo json_encode($response);
	}
}

/* End of file Voucher.php */
/* Location: ./application/controllers/Voucher.php */

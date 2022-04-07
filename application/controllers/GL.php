<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GL extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_gl');
		$this->load->model('M_coa');
		$this->load->model('M_billing');
		$this->load->model('M_period');
		$this->load->model('M_customer');
		$this->load->model('M_owner');
		$this->load->model('M_electricity');
		$this->load->model('M_water');
		$this->load->model('M_service');
		$this->load->model('M_rates');
		$this->load->model('M_parameter');
		$this->load->model('M_candidate_key');
		$this->load->model('M_pinalty');
		$this->load->library('pdf');
		$this->load->library('pdf_landscape');
	}

	public function index()
	{
		$data['userdata'] = $this->userdata;
		$data['dataGL'] = $this->M_gl->select_all();
		$data['dataCoA'] = $this->M_coa->select_all();
		$data['dataCoaPrint'] = $this->M_coa->print();
		$data['dataBilling'] = $this->M_billing->select_all();
		$data['dataCustomer'] = $this->M_customer->select_all();
		$data['dataOwner'] = $this->M_owner->select_all();
		$data['dataRates'] = $this->M_rates->select_all();
		$data['dataService'] = $this->M_service->select_all();
		$data['dataPeriod'] = $this->M_period->select_all();

		$data['page'] = "General Ledger";
		$data['judul'] = "General Ledger";
		$data['deskripsi'] = "Manage General Ledger Data";

		$data['modal_tambah_gl'] = show_my_modal('modals/modal_tambah_gl', 'tambah-gl', $data);

		$js = $this->load->view('gl/gl-js', null, true);
		$this->template->views('gl/home', $data, $js);
	}

	public function tampil()
	{
		$akun = $this->input->get('akun');
		$startDate = $this->input->get("startDate");
		$endDate = $this->input->get("endDate");
		$data['dataGL'] = $this->M_gl->select_filter($akun, $startDate, $endDate);
		$data['dataTotalGL'] = $this->M_gl->select_filter_total($akun, $startDate, $endDate);
		$this->load->view('gl/list_data', $data);
	}

	public function cekId()
	{
		if (isset($_POST['cek_submit_btn'])) {
			$glID = $_POST['gl_id'];

			if ($this->M_gl->check_bill_id($glID) > 0) {
				echo "GL Code Already Inserted";
			} else {
				echo "GL Code Available";
			}
		}
	}

	public function billing()
	{
		$this->form_validation->set_rules('period', 'Period', 'trim|required');
		$this->form_validation->set_rules('kodeCus', 'Customer', 'trim|required');

		$post = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$periode = $this->M_period->select_by_id($post['period']);
			$end = $this->M_period->get_end_periode($post['period']);

			// if ($this->M_gl->check_bill($post['kodeCus'], $end->periode_satu, 21) > 0) {
			// 	$out['status'] = '';
			// 	$out['msg'] = show_err_msg('General Ledger For This Period Already Inserted', '20px');
			// } else {

			$listrik = $this->M_electricity->select_by_customer_and_period($post['kodeCus'], $post['period']);
			$air = $this->M_water->select_by_customer_and_period($post['kodeCus'], $post['period']);
			$customer = $this->M_customer->select_by_id($post['kodeCus']);

			$stamp = $this->M_parameter->select_by_id('stamp_key');
			$bill_stamp_limit_key = $this->M_parameter->select_by_id('bill_stamp_limit_key');

			if (($listrik->total + $air->total) < floatval($bill_stamp_limit_key->param1)) {
				$stampValue = floatval($stamp->param1);
			} else {
				$stampValue = floatval($stamp->param2);
			}

			$data = [
				'bukti_transaksi' => $listrik->id_listrik,
				'id_customer' => $post['kodeCus'],
				'id_owner' => $customer->owner,
				'tanggal_transaksi' => $periode->tanggal_start,
				'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama,
				'kode_soa' => 21,
				'debit' => $listrik->total + $air->total + $stampValue,
				'credit' => 0,
				'so' => 1,
				'cash' => 0
			];
			$data2 = [
				'bukti_transaksi' => $listrik->id_listrik,
				'id_customer' => $post['kodeCus'],
				'id_owner' => $customer->owner,
				'tanggal_transaksi' => $periode->tanggal_start,
				'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama,
				'kode_soa' => 276,
				'debit' => 0,
				'credit' => $listrik->total,
				'so' => 1,
				'cash' => 0
			];
			$data3 = [
				'bukti_transaksi' => $listrik->id_listrik,
				'id_customer' => $post['kodeCus'],
				'id_owner' => $customer->owner,
				'tanggal_transaksi' => $periode->tanggal_start,
				'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama,
				'kode_soa' => 277,
				'debit' => 0,
				'credit' => $air->total,
				'so' => 1,
				'cash' => 0
			];
			$data4 = [
				'bukti_transaksi' => $listrik->id_listrik,
				'id_customer' => $post['kodeCus'],
				'id_owner' => $customer->owner,
				'tanggal_transaksi' => $periode->tanggal_start,
				'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama,
				'kode_soa' => 302,
				'debit' => 0,
				'credit' => $stampValue,
				'so' => 1,
				'cash' => 0
			];

			$result = $this->M_gl->insert2($data);

			$this->M_gl->insert2($data2);
			$this->M_gl->insert2($data3);
			$this->M_gl->insert2($data4);


			if ($result > 0) {
				helper_log("add", "Menambah Data Billing (GL)", $data['bukti_transaksi']);
				$out['status'] = '';
				$out['msg'] = show_succ_msg('General Ledger Data Successfully Added', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('General Ledger Data Failed To Add', '20px');
			}
			// }
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function billingPeriod()
	{
		$this->form_validation->set_rules('period', 'Period', 'trim|required');

		$post = $this->input->post();
		$row = 0;
		if ($this->form_validation->run() == TRUE) {

			$available = $this->M_billing->select_inv_not_bill($post['period']);

			foreach ($available as $a) {
				$periode = $this->M_period->select_by_id($a->id_periode);
				$end = $this->M_period->get_end_periode($a->id_periode);

				// if ($this->M_gl->check_bill($a->kode_customer, $end->periode_satu, 21) > 0) {
				// 	$out['status'] = '';
				// 	$out['msg'] = show_err_msg('General Ledger For This Period Already Inserted', '20px');
				// } else {

				$listrik = $this->M_electricity->select_by_id($a->id_listrik);
				$air = $this->M_water->select_by_id($a->kode_tagihan_air);
				$customer = $this->M_customer->select_by_id($a->kode_customer);

				$stamp = $this->M_parameter->select_by_id('stamp_key');
				$bill_stamp_limit_key = $this->M_parameter->select_by_id('bill_stamp_limit_key');

				if (($listrik->total + $air->total) < floatval($bill_stamp_limit_key->param1)) {
					$stampValue = floatval($stamp->param1);
				} else {
					$stampValue = floatval($stamp->param2);
				}

				$data = [
					'bukti_transaksi' => $a->id_listrik,
					'id_customer' => $a->kode_customer,
					'id_owner' => $customer->owner,
					'tanggal_transaksi' => $periode->tanggal_start,
					'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama,
					'kode_soa' => 21,
					'debit' => $listrik->total + $air->total + $stampValue,
					'credit' => 0,
					'so' => 1,
					'cash' => 0
				];
				$data2 = [
					'bukti_transaksi' => $a->id_listrik,
					'id_customer' => $a->kode_customer,
					'id_owner' => $customer->owner,
					'tanggal_transaksi' => $periode->tanggal_start,
					'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama,
					'kode_soa' => 276,
					'debit' => 0,
					'credit' => $listrik->total,
					'so' => 1,
					'cash' => 0
				];
				$data3 = [
					'bukti_transaksi' => $a->id_listrik,
					'id_customer' => $a->kode_customer,
					'id_owner' => $customer->owner,
					'tanggal_transaksi' => $periode->tanggal_start,
					'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama,
					'kode_soa' => 277,
					'debit' => 0,
					'credit' => $air->total,
					'so' => 1,
					'cash' => 0
				];
				$data4 = [
					'bukti_transaksi' => $a->id_listrik,
					'id_customer' => $a->kode_customer,
					'id_owner' => $customer->owner,
					'tanggal_transaksi' => $periode->tanggal_start,
					'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama,
					'kode_soa' => 302,
					'debit' => 0,
					'credit' => $stampValue,
					'so' => 1,
					'cash' => 0
				];

				$result = $this->M_gl->insert2($data);
				$this->M_gl->insert2($data2);
				$this->M_gl->insert2($data3);
				$this->M_gl->insert2($data4);
				// }

				$row = $result;
			}
			if ($row > 0) {
				helper_log("add", "Menambah Data Billing By Period (GL)", $data['bukti_transaksi']);
				$out['status'] = '';
				$out['msg'] = show_succ_msg('General Ledger Data Successfully Added', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('General Ledger Data Failed To Add', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function service()
	{
		$this->form_validation->set_rules('kodeOwner', 'Owner ID', 'trim|required');
		$this->form_validation->set_rules('period', 'Period', 'trim|required');
		$this->form_validation->set_rules('tarif', 'Tarif transaksi', 'trim|required');


		$post = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$periode = $this->M_period->select_by_id($post['period']);
			$end = $this->M_period->get_end_periode($post['period']);
			$owner = $this->M_owner->select_by_id($post['kodeOwner']);

			if ($this->M_gl->check_bill($owner->customer, $end->periode_satu, 22) > 0) {
				$out['status'] = '';
				$out['msg'] = show_err_msg('General Ledger For This Period Already Inserted', '20px');
			} else {
				$rate = $this->M_rates->select_by_id($post['tarif']);

				$id = $this->M_service->select_invoice_owner_period($post['kodeOwner'], $post['period']);

				$stamp = $this->M_parameter->select_by_id('stamp_key');
				$bill_stamp_limit_key = $this->M_parameter->select_by_id('bill_stamp_limit_key');

				$sinking = $owner->sqm * 3 * $rate->sinking;
				$service = $owner->sqm * 3 * $rate->service;

				if (($sinking + $service) < floatval($bill_stamp_limit_key->param1)) {
					$stampValue = floatval($stamp->param1);
				} else {
					$stampValue = floatval($stamp->param2);
				}

				$data = [
					'bukti_transaksi' => $id->id_service,
					'id_customer' => $owner->customer,
					'id_owner' => $post['kodeOwner'],
					'tanggal_transaksi' => $end->periode_satu,
					'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
					'kode_soa' => 22,
					'debit' => $sinking + $service + $stampValue,
					'credit' => 0,
					'so' => 1,
					'cash' => 0
				];
				$data11 = [
					'bukti_transaksi' => $id->id_service,
					'id_customer' => $owner->customer,
					'id_owner' => $post['kodeOwner'],
					'tanggal_transaksi' => $end->periode_satu,
					'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
					'kode_soa' => 302,
					'debit' => 0,
					'credit' => $stampValue,
					'so' => 1,
					'cash' => 0
				];
				$data12 = [
					'bukti_transaksi' => $id->id_service,
					'id_customer' => $owner->customer,
					'id_owner' => $post['kodeOwner'],
					'tanggal_transaksi' => $end->periode_satu,
					'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
					'kode_soa' => 189,
					'debit' => 0,
					'credit' => $sinking,
					'so' => 1,
					'cash' => 0
				];
				$data13 = [
					'bukti_transaksi' => $id->id_service,
					'id_customer' => $owner->customer,
					'id_owner' => $post['kodeOwner'],
					'tanggal_transaksi' => $end->periode_satu,
					'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
					'kode_soa' => 237,
					'debit' => 0,
					'credit' => $service,
					'so' => 1,
					'cash' => 0
				];
				$data14 = [
					'bukti_transaksi' => $id->id_service,
					'id_customer' => $owner->customer,
					'id_owner' => $post['kodeOwner'],
					'tanggal_transaksi' => $end->periode_satu,
					'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
					'kode_soa' => 237,
					'debit' => $service / 3,
					'credit' => 0,
					'so' => 1,
					'cash' => 0
				];
				$data15 = [
					'bukti_transaksi' => $id->id_service,
					'id_customer' => $owner->customer,
					'id_owner' => $post['kodeOwner'],
					'tanggal_transaksi' => $end->periode_satu,
					'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
					'kode_soa' => 275,
					'debit' => 0,
					'credit' => $service / 3,
					'so' => 1,
					'cash' => 0
				];
				$data21 = [
					'bukti_transaksi' => $id->id_service,
					'id_customer' => $owner->customer,
					'id_owner' => $post['kodeOwner'],
					'tanggal_transaksi' => $end->periode_dua,
					'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
					'kode_soa' => 237,
					'debit' => $service / 3,
					'credit' => 0,
					'so' => 1,
					'cash' => 0
				];
				$data22 = [
					'bukti_transaksi' => $id->id_service,
					'id_customer' => $owner->customer,
					'id_owner' => $post['kodeOwner'],
					'tanggal_transaksi' => $end->periode_dua,
					'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
					'kode_soa' => 275,
					'debit' => 0,
					'credit' => $service / 3,
					'so' => 1,
					'cash' => 0
				];
				$data31 = [
					'bukti_transaksi' => $id->id_service,
					'id_customer' => $owner->customer,
					'id_owner' => $post['kodeOwner'],
					'tanggal_transaksi' => $end->periode_tiga,
					'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
					'kode_soa' => 237,
					'debit' => $service / 3,
					'credit' => 0,
					'so' => 1,
					'cash' => 0
				];
				$data32 = [
					'bukti_transaksi' => $id->id_service,
					'id_customer' => $owner->customer,
					'id_owner' => $post['kodeOwner'],
					'tanggal_transaksi' => $end->periode_tiga,
					'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
					'kode_soa' => 275,
					'debit' => 0,
					'credit' => $service / 3,
					'so' => 1,
					'cash' => 0
				];

				$result = $this->M_gl->insert2($data);
				$this->M_gl->insert2($data11);
				$this->M_gl->insert2($data12);
				$this->M_gl->insert2($data13);
				$this->M_gl->insert2($data14);
				$this->M_gl->insert2($data15);
				$this->M_gl->insert2($data21);
				$this->M_gl->insert2($data22);
				$this->M_gl->insert2($data31);
				$this->M_gl->insert2($data32);

				if ($result > 0) {
					helper_log("add", "Menambah Data Service (GL)", $data['bukti_transaksi']);
					$out['status'] = '';
					$out['msg'] = show_succ_msg('General Ledger Bill Data Successfully Added', '20px');
				} else {
					$out['status'] = '';
					$out['msg'] = show_err_msg('General Ledger Bill Data Failed To Add', '20px');
				}
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function servicePeriod()
	{

		$this->form_validation->set_rules('period', 'Periode', 'trim|required');

		$post = $this->input->post();
		$row = 0;
		if ($this->form_validation->run() == TRUE) {

			$available = $this->M_service->select_inv_not_bill($post['period']);

			foreach ($available as $a) {
				$period = $this->M_period->select_by_id($post['period']);
				$end = $this->M_period->get_end_periode($post['period']);
				$owner = $this->M_owner->select_by_id($a->kode_owner);

				if ($this->M_gl->check_bill($owner->customer, $end->periode_satu, 22) > 0) {
					$out['status'] = '';
					$out['msg'] = show_err_msg('General Ledger For This Period Already Inserted', '20px');
				} else {
					$rate = $this->M_rates->select_by_id($post['tarif']);

					$id = $this->M_service->select_invoice_owner_period($a->kode_owner, $post['period']);

					$stamp = $this->M_parameter->select_by_id('stamp_key');
					$bill_stamp_limit_key = $this->M_parameter->select_by_id('bill_stamp_limit_key');

					$sinking = $owner->sqm * 3 * $rate->sinking;
					$service = $owner->sqm * 3 * $rate->service;

					if (($sinking + $service) < floatval($bill_stamp_limit_key->param1)) {
						$stampValue = floatval($stamp->param1);
					} else {
						$stampValue = floatval($stamp->param2);
					}

					$data = [
						'bukti_transaksi' => $id->id_service,
						'id_customer' => $owner->customer,
						'id_owner' => $a->kode_owner,
						'tanggal_transaksi' => $end->periode_satu,
						'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
						'kode_soa' => 22,
						'debit' => $sinking + $service + $stampValue,
						'credit' => 0,
						'so' => 1,
						'cash' => 0
					];
					$data11 = [
						'bukti_transaksi' => $id->id_service,
						'id_customer' => $owner->customer,
						'id_owner' => $a->kode_owner,
						'tanggal_transaksi' => $end->periode_satu,
						'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
						'kode_soa' => 302,
						'debit' => 0,
						'credit' => $stampValue,
						'so' => 1,
						'cash' => 0
					];
					$data12 = [
						'bukti_transaksi' => $id->id_service,
						'id_customer' => $owner->customer,
						'id_owner' => $a->kode_owner,
						'tanggal_transaksi' => $end->periode_satu,
						'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
						'kode_soa' => 189,
						'debit' => 0,
						'credit' => $sinking,
						'so' => 1,
						'cash' => 0
					];
					$data13 = [
						'bukti_transaksi' => $id->id_service,
						'id_customer' => $owner->customer,
						'id_owner' => $a->kode_owner,
						'tanggal_transaksi' => $end->periode_satu,
						'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
						'kode_soa' => 237,
						'debit' => 0,
						'credit' => $service,
						'so' => 1,
						'cash' => 0
					];
					$data14 = [
						'bukti_transaksi' => $id->id_service,
						'id_customer' => $owner->customer,
						'id_owner' => $a->kode_owner,
						'tanggal_transaksi' => $end->periode_satu,
						'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
						'kode_soa' => 237,
						'debit' => $service / 3,
						'credit' => 0,
						'so' => 1,
						'cash' => 0
					];
					$data15 = [
						'bukti_transaksi' => $id->id_service,
						'id_customer' => $owner->customer,
						'id_owner' => $a->kode_owner,
						'tanggal_transaksi' => $end->periode_satu,
						'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
						'kode_soa' => 275,
						'debit' => 0,
						'credit' => $service / 3,
						'so' => 1,
						'cash' => 0
					];
					$data21 = [
						'bukti_transaksi' => $id->id_service,
						'id_customer' => $owner->customer,
						'id_owner' => $a->kode_owner,
						'tanggal_transaksi' => $end->periode_dua,
						'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
						'kode_soa' => 237,
						'debit' => $service / 3,
						'credit' => 0,
						'so' => 1,
						'cash' => 0
					];
					$data22 = [
						'bukti_transaksi' => $id->id_service,
						'id_customer' => $owner->customer,
						'id_owner' => $a->kode_owner,
						'tanggal_transaksi' => $end->periode_dua,
						'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
						'kode_soa' => 275,
						'debit' => 0,
						'credit' => $service / 3,
						'so' => 1,
						'cash' => 0
					];
					$data31 = [
						'bukti_transaksi' => $id->id_service,
						'id_customer' => $owner->customer,
						'id_owner' => $a->kode_owner,
						'tanggal_transaksi' => $end->periode_tiga,
						'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
						'kode_soa' => 237,
						'debit' => $service / 3,
						'credit' => 0,
						'so' => 1,
						'cash' => 0
					];
					$data32 = [
						'bukti_transaksi' => $id->id_service,
						'id_customer' => $owner->customer,
						'id_owner' => $a->kode_owner,
						'tanggal_transaksi' => $end->periode_tiga,
						'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
						'kode_soa' => 275,
						'debit' => 0,
						'credit' => $service / 3,
						'so' => 1,
						'cash' => 0
					];

					$result = $this->M_gl->insert2($data);
					$this->M_gl->insert2($data11);
					$this->M_gl->insert2($data12);
					$this->M_gl->insert2($data13);
					$this->M_gl->insert2($data14);
					$this->M_gl->insert2($data15);
					$this->M_gl->insert2($data21);
					$this->M_gl->insert2($data22);
					$this->M_gl->insert2($data31);
					$this->M_gl->insert2($data32);
					$row = $result;
				}
			}
			if ($row > 0) {
				helper_log("add", "Menambah Data Service By Period (GL)");
				$out['status'] = '';
				$out['msg'] = show_succ_msg('General Ledger Service Bill Data Successfully Added', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('General Ledger Service Bill Data Failed To Add', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function prosesTambah()
	{
		$post = $this->input->post(null, TRUE);

		$this->M_gl->insert($post);

		if ($this->db->affected_rows() > 0) {
			helper_log("add", "Menambah Data (GL)", $post['code']);
			$out['status'] = '';
			$out['msg'] = show_succ_msg('General Ledger Data Successfully Added', '20px');
		} else {
			$out['status'] = '';
			$out['msg'] = show_err_msg('General Ledger Data Failed To Add', '20px');
		}
		echo json_encode($out);
	}

	public function delete()
	{
		$id = $_POST['id_gl'];
		$result = $this->M_gl->delete($id);

		if ($result) {
			helper_log("delete", "Menghapus Data (GL)", $id);
			echo show_succ_msg('General Ledger Data Successfully Deleted', '20px');
		} else {
			echo show_err_msg('General Ledger Data Failed To Delete', '20px');
		}
	}

	public function delete_all()
	{
		$post = $this->input->post(null, TRUE);
		$id = json_decode($_POST["checkbox_value"]);

		for ($count = 0; $count < count($id); $count++) {

			$result = $this->M_gl->delete_all($id[$count]);
		}
		if ($result > 0) {
			helper_log("delete", "Menghapus Semua Data (GL)");
			echo show_succ_msg('General Ledger List Deleted Successfully', '20px');
		} else {
			echo show_err_msg('General Ledger List Failed To Delete', '20px');
		}
	}

	public function print()
	{

		$coaA = $this->input->post('coaPrintA');
		$coaB = $this->input->post('coaPrintB');
		$dateA = $this->input->post('dateA');
		$dateB = $this->input->post('dateB');
		$report = $this->input->post('report');

		$gl = $this->M_gl->print($coaA, $coaB, $dateA, $dateB);
		$saldo = $this->M_gl->saldoAwal($dateA);
		$saldosur = $this->M_gl->saldoAwalsur($dateA);
		$glCus = $this->M_gl->printCus($coaA, $coaB, $dateA, $dateB);
		$glSur = $this->M_gl->printSurplus($dateA, $dateB);
		$glDef = $this->M_gl->printDefisit($dateA, $dateB);
		$glTgl = $this->M_gl->print_tgl($coaA, $coaB, $dateA, $dateB);

		$coa = $this->M_coa->select_between_coa($coaA, $coaB);

		if ($gl != null && $coaA != $coaB) {
			$coaNameA = $this->M_coa->select_by_id($coaA);
			$coaNameB = $this->M_coa->select_by_id($coaB);

			$data['dataGL'] = $gl;
			$data['dataSaldo'] = $saldo;
			$data['dataSaldoSur'] = $saldosur;
			$data['dataGLCus'] = $glCus;
			$data['dataGLSur'] = $glSur;
			$data['dataGLDef'] = $glDef;
			$data['dataGLTgl'] = $glTgl;
			$data['dateA'] = $dateA;
			$data['dateB'] = $dateB;
			$data['dataCoA'] = $coa;
			$data['report'] = $report;

			// var_dump($gl);

			$html = $this->load->view('gl/print', $data, true);
			$filename = 'General_Ledger_' . $coaNameA->coa_id . ' ~ ' . $coaNameB->coa_id . '_' . time();
			$this->pdf->generate($html, $filename, true, 'letter');
		} else if ($coaA == $coaB && $gl != null) {
			$coaNameA = $this->M_coa->select_by_id($coaA);
			$coaNameB = $this->M_coa->select_by_id($coaB);

			$data['dataGL'] = $gl;
			$data['dataSaldo'] = $saldo;
			$data['dataGLCus'] = $glCus;
			$data['dataGLTgl'] = $glTgl;
			$data['dateA'] = $dateA;
			$data['dateB'] = $dateB;
			$data['dataCoA'] = $coa;
			$data['report'] = $report;

			// var_dump($gl);

			$html = $this->load->view('gl/print', $data, true);
			$filename = 'General_Ledger_' . $coaNameA->coa_id . ' ~ ' . $coaNameB->coa_id . '_' . time();
			$this->pdf->generate($html, $filename, true, 'letter');
		} else if ($coaA == $coaB && $gl == null) {
			$coaNameA = $this->M_coa->select_by_id($coaA);
			$coaNameB = $this->M_coa->select_by_id($coaB);

			$data['dataGL'] = $gl;
			$data['dataSaldo'] = $saldo;
			$data['dataGLCus'] = $glCus;
			$data['dataGLTgl'] = $glTgl;
			$data['dateA'] = $dateA;
			$data['dateB'] = $dateB;
			$data['dataCoA'] = $coa;
			$data['report'] = $report;

			// var_dump($gl);

			$html = $this->load->view('gl/print_coa', $data, true);
			$filename = 'General_Ledger_' . $coaNameA->coa_id . ' ~ ' . $coaNameB->coa_id . '_' . time();
			$this->pdf->generate($html, $filename, true, 'letter');
		} else {
			redirect('/GL', 'refresh');
		}
	}

	public function printReport()
	{

		$report = $this->input->post('report');
		$date = $this->input->post('dateReport');

		if ($report == 1) {
			$gl = $this->M_gl->neraca($date);
			$jt = $this->M_gl->jurnalNeraca($date);
			$coa = $this->M_gl->parentCoANeraca($date);
			$glt = $this->M_gl->neracaTwo($date);
			$ct = $this->M_gl->parentTwoCoA($date);

			if ($gl != null) {

				$data['dataGL'] = $gl;
				$data['dataGLTwo'] = $glt;
				$data['dataJurnal'] = $jt;
				$data['dataCoA'] = $coa;
				$data['dataCoATwo'] = $ct;
				$data['report'] = $report;
				$data['date'] = $date;

				$html = $this->load->view('gl/printNeraca', $data, true);
				$filename = 'Balance_Sheet_Detail_' . $date;
				$this->pdf->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 2) {
			$gl = $this->M_gl->labaRugi($date);
			$jt = $this->M_gl->jurnalLabaRugi($date);
			$coa = $this->M_gl->parentCoA($date);

			if ($gl != null) {

				$data['dataGL'] = $gl;
				$data['dataJurnal'] = $jt;
				$data['dataCoA'] = $coa;
				$data['report'] = $report;
				$data['date'] = $date;

				$html = $this->load->view('gl/printLR', $data, true);
				$filename = 'Income_Statemnet_Detail_' . $date;
				$this->pdf->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 0) {
			$gl = $this->M_gl->neracaBulan($date);
			$jt = $this->M_gl->jurnalNeraca($date);
			$coa = $this->M_gl->parentCoA($date);

			if ($gl != null) {

				$data['dataGL'] = $gl;
				$data['dataJurnal'] = $jt;
				$data['dataCoA'] = $coa;
				$data['report'] = $report;
				$data['date'] = $date;

				$html = $this->load->view('gl/printNeracaBulan', $data, true);
				$filename = 'Balance_Sheet_' . $date;
				$this->pdf_landscape->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 3) {
			$gl = $this->M_gl->labaRugiBulan($date);
			$jt = $this->M_gl->jurnalLabaRugi($date);
			$coa = $this->M_gl->parentCoA($date);

			if ($gl != null) {

				$data['dataGL'] = $gl;
				$data['dataJurnal'] = $jt;
				$data['dataCoA'] = $coa;
				$data['report'] = $report;
				$data['date'] = $date;

				$html = $this->load->view('gl/printLRBulan', $data, true);
				$filename = 'Income_Statemnet_' . $date;
				$this->pdf_landscape->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 5) {
			$coa = 8;
			$gl = $this->M_gl->printBank($coa, $date);
			$saldo = $this->M_gl->saldoAwal($date);
			$glCus = $this->M_gl->printCusBank($coa, $date);
			$glTgl = $this->M_gl->print_tgl_bank($coa, $date);

			if ($gl != null) {
				$coaName = $this->M_coa->select_by_id($coa);

				$data['dataGL'] = $gl;
				$data['dataSaldo'] = $saldo;
				$data['dataGLCus'] = $glCus;
				$data['dataGLTgl'] = $glTgl;
				$data['coa'] = $coaName;
				$data['date'] = $date;

				$html = $this->load->view('gl/printBank', $data, true);
				$filename = 'Detail_' . $coaName->coa_id . '_' . $date;
				$this->pdf->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 6) {
			$coa = 9;
			$gl = $this->M_gl->printBank($coa, $date);
			$saldo = $this->M_gl->saldoAwal($date);
			$glCus = $this->M_gl->printCusBank($coa, $date);
			$glTgl = $this->M_gl->print_tgl_bank($coa, $date);

			if ($gl != null) {
				$coaName = $this->M_coa->select_by_id($coa);

				$data['dataGL'] = $gl;
				$data['dataSaldo'] = $saldo;
				$data['dataGLCus'] = $glCus;
				$data['dataGLTgl'] = $glTgl;
				$data['coa'] = $coaName;
				$data['date'] = $date;

				$html = $this->load->view('gl/printBank', $data, true);
				$filename = 'Detail_' . $coaName->coa_id . '_' . $date;
				$this->pdf->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 7) {
			$coa = 10;
			$gl = $this->M_gl->printBank($coa, $date);
			$saldo = $this->M_gl->saldoAwal($date);
			$glCus = $this->M_gl->printCusBank($coa, $date);
			$glTgl = $this->M_gl->print_tgl_bank($coa, $date);

			if ($gl != null) {
				$coaName = $this->M_coa->select_by_id($coa);

				$data['dataGL'] = $gl;
				$data['dataSaldo'] = $saldo;
				$data['dataGLCus'] = $glCus;
				$data['dataGLTgl'] = $glTgl;
				$data['coa'] = $coaName;
				$data['date'] = $date;

				$html = $this->load->view('gl/printBank', $data, true);
				$filename = 'Detail_' . $coaName->coa_id . '_' . $date;
				$this->pdf->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 8) {
			$coa = 452;
			$gl = $this->M_gl->printBank($coa, $date);
			$saldo = $this->M_gl->saldoAwal($date);
			$glCus = $this->M_gl->printCusBank($coa, $date);
			$glTgl = $this->M_gl->print_tgl_bank($coa, $date);

			if ($gl != null) {
				$coaName = $this->M_coa->select_by_id($coa);

				$data['dataGL'] = $gl;
				$data['dataSaldo'] = $saldo;
				$data['dataGLCus'] = $glCus;
				$data['dataGLTgl'] = $glTgl;
				$data['coa'] = $coaName;
				$data['date'] = $date;

				$html = $this->load->view('gl/printBank', $data, true);
				$filename = 'Detail_' . $coaName->coa_id . '_' . $date;
				$this->pdf->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 9) {
			$coa = 11;
			$gl = $this->M_gl->printBank($coa, $date);
			$saldo = $this->M_gl->saldoAwal($date);
			$glCus = $this->M_gl->printCusBank($coa, $date);
			$glTgl = $this->M_gl->print_tgl_bank($coa, $date);

			if ($gl != null) {
				$coaName = $this->M_coa->select_by_id($coa);

				$data['dataGL'] = $gl;
				$data['dataSaldo'] = $saldo;
				$data['dataGLCus'] = $glCus;
				$data['dataGLTgl'] = $glTgl;
				$data['coa'] = $coaName;
				$data['date'] = $date;

				$html = $this->load->view('gl/printBank', $data, true);
				$filename = 'Detail_' . $coaName->coa_id . '_' . $date;
				$this->pdf->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 10) {
			$coa = 2;
			$gl = $this->M_gl->printBank($coa, $date);
			$saldo = $this->M_gl->saldoAwal($date);
			$glCus = $this->M_gl->printCusBank($coa, $date);
			$glTgl = $this->M_gl->print_tgl_bank($coa, $date);

			if ($gl != null) {
				$coaName = $this->M_coa->select_by_id($coa);

				$data['dataGL'] = $gl;
				$data['dataSaldo'] = $saldo;
				$data['dataGLCus'] = $glCus;
				$data['dataGLTgl'] = $glTgl;
				$data['coa'] = $coaName;
				$data['date'] = $date;

				$html = $this->load->view('gl/printBank', $data, true);
				$filename = 'Detail_' . $coaName->coa_id . '_' . time();
				$this->pdf->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 11) {
			$gl = $this->M_gl->rekapGL($date);

			if ($gl != null) {

				$data['dataGL'] = $gl;
				$data['date'] = $date;

				$html = $this->load->view('gl/rekapGL', $data, true);
				$filename = 'Rekap_GL_' . $date;
				$this->pdf->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 12) {
			$gl = $this->M_gl->neraca($date);
			$jt = $this->M_gl->jurnalNeraca($date);
			$coa = $this->M_gl->parentCoA($date);

			if ($gl != null) {

				$data['dataGL'] = $gl;
				$data['dataJurnal'] = $jt;
				$data['dataCoA'] = $coa;
				$data['report'] = $report;
				$data['date'] = $date;

				$html = $this->load->view('gl/printBalanceSheet', $data, true);
				$filename = 'Balance_Sheet_' . $date;
				$this->pdf->generate($html, $filename, true, 'letter');
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 13) {

			$gl = $this->M_gl->rekapGL($date);
			$date = $this->input->post('dateReport');

			$totalSD = 0;
			$totalSC = 0;
			$totalMD = 0;
			$totalMC = 0;
			$totalRD = 0;
			$totalRC = 0;
			$totalND = 0;
			$totalNC = 0;

			if ($gl != null) {

				error_reporting(E_ALL);

				include_once './assets/phpexcel/Classes/PHPExcel.php';
				$objPHPExcel = new PHPExcel();

				$data = $this->M_gl->rekapGL($date);

				$objPHPExcel = new PHPExcel();
				$objPHPExcel->setActiveSheetIndex(0);
				$rowCount = 2;

				$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$objPHPExcel->getActiveSheet()->mergeCells('A1:B1')->setCellValue("A1", "MONTH : " . strtoupper(date('F', strtotime($date))));
				$objPHPExcel->getActiveSheet()->mergeCells('C1:D1')->setCellValue("C1", "SALDO AWAL");
				$objPHPExcel->getActiveSheet()->mergeCells('E1:F1')->setCellValue("E1", "MUTASI");
				$objPHPExcel->getActiveSheet()->mergeCells('G1:H1')->setCellValue("G1", "RUGI LABA");
				$objPHPExcel->getActiveSheet()->mergeCells('I1:J1')->setCellValue("I1", "NERACA");


				$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
				$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(25);
				$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFill()->getStartColor()->setARGB('bfb8b8');
				$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

				for ($i = 'C'; $i < 'K'; $i++) {
					$objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					$objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "KODE REKENING");
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "NAMA REKENING");
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "DEBET");
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "KREDIT");
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "DEBET");
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "KREDIT");
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "DEBET");
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, "KREDIT");
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, "DEBET");
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, "KREDIT");
				$rowCount++;

				foreach ($data as $gl) {

					if ($gl->jurnal_tipe == 1) {

						$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $gl->coa_id);
						$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $gl->coa_name);
						if (($gl->debitAwal - $gl->creditAwal) > 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $gl->debitAwal - $gl->creditAwal);
							$totalSD += ($gl->debitAwal - $gl->creditAwal);
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0,00');
						} else if (($gl->debitAwal - $gl->creditAwal) < 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $gl->debitAwal - $gl->creditAwal);
							$totalSD += ($gl->debitAwal - $gl->creditAwal);
						} else {
							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0,00');
						}

						$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $gl->debit);
						$totalMD += $gl->debit;
						$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $gl->credit);
						$totalMC += $gl->credit;
						$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '0,00');
						$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '0,00');

						if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) > 0) {

							$neracaDebit = ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit);

							$totalND += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit);

							$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $neracaDebit);
							$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '0,00');
						} else if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) < 0) {

							$neracaKredit = ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit);

							$totalND += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit);

							$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $neracaKredit);
							$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '0,00');
						} else {
							$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '0,00');
						}
					} else if ($gl->jurnal_tipe == 4 && $gl->kode_soa != 272) {

						$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $gl->coa_id);
						$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $gl->coa_name);
						if (($gl->debitAwal - $gl->creditAwal) > 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $gl->debitAwal - $gl->creditAwal);
							$totalSC += ($gl->debitAwal - $gl->creditAwal);
							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
						} else if (($gl->debitAwal - $gl->creditAwal) < 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $gl->debitAwal - $gl->creditAwal);
							$totalSC += ($gl->debitAwal - $gl->creditAwal);
						} else {
							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0,00');
						}
						$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $gl->debit);
						$totalMD += $gl->debit;
						$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $gl->credit);
						$totalMC += $gl->credit;
						$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '0,00');
						$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '0,00');

						if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) > 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit));
							$totalNC += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit);
						} else if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) < 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit));
							$totalNC += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit);
						} else {
							$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '0,00');
						}
					} else if ($gl->jurnal_tipe == 4 && $gl->kode_soa == 272) {

						$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $gl->coa_id);
						$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $gl->coa_name);
						if (($gl->retainedBebanLast + $gl->retainedPendapatanLast) >= 0) {
							if (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal) > 0) {
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $gl->debitAwal - $gl->creditAwal) + ($gl->retainedBebanLast + $gl->retainedPendapatanLast);
								$totalSC += ($gl->debitAwal - $gl->creditAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast));
								$totalRLD += ($gl->debitAwal - $gl->creditAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast));
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
							} else if (($gl->debitAwal) - ($gl->creditAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) < 0) {
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast) - $gl->creditAwal);
								$totalSC += (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - $gl->creditAwal);
								$totalRLC += (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - $gl->creditAwal);
							} else {
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0,00');
							}
						} else if (($gl->retainedBebanLast + $gl->retainedPendapatanLast) < 0) {
							if (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal) > 0) {
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, ($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal));
								$totalSD += (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal));
								$totalRLD += (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal));
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0,00');
							} else if (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - ($gl->creditAwal) < 0) {
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast) - $gl->creditAwal);
								$totalSC += (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - $gl->creditAwal);
								$totalRLC += (($gl->debitAwal + ($gl->retainedBebanLast + $gl->retainedPendapatanLast)) - $gl->creditAwal);
							} else {
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0,00');
							}
						}
						if (($gl->retainedBeban + $gl->retainedPendapatan) > 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $gl->retainedBeban + $gl->retainedPendapatan);
							$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '0,00');
						} else {
							$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $gl->debit);
							$totalMD += $gl->debit;
							$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $gl->credit);
							$totalMC += $gl->credit;
						}
						$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '0,00');
						$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '0,00');
						if (($gl->retainedBeban + $gl->retainedPendapatan) > 0) {
							if (($totalRLD) - ($totalRLC * -1 + ($gl->retainedBeban + $gl->retainedPendapatan)) > 0) {
								$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, ($totalRLD) - ($totalRLC * -1 + ($gl->retainedBeban + $gl->retainedPendapatan)));
								$totalNC += (($totalRLD) - ($totalRLC * -1 + ($gl->retainedBeban + $gl->retainedPendapatan)));
							} else if (($totalRLD) - ($totalRLC * -1 + ($gl->retainedBeban + $gl->retainedPendapatan)) < 0) {
								$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, ($totalRLD) - ($totalRLC + ($gl->retainedBeban + $gl->retainedPendapatan)));
								$totalNC += (($totalRLD) - ($totalRLC + ($gl->retainedBeban + $gl->retainedPendapatan)) * -1);
							} else {
								$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '0,00');
							}
						} else if (($gl->retainedBeban + $gl->retainedPendapatan) < 0) {
							if (($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC * -1) > 0) {
								$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, ($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC * -1));
								$totalNC += ($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC * -1);
							} else if (($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC * -1) < 0) {
								$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, ($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC * -1));
								$totalNC += (($totalRLD + ($gl->retainedBeban + $gl->retainedPendapatan)) - ($totalRLC) * -1);
							} else {
								$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '0,00');
							}
						} else {
							if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) > 0) {
								$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit));
								$totalNC += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit);
							} else if (($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit) < 0) {
								$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit));
								$totalNC += ($gl->debitAwal + $gl->debit) - ($gl->creditAwal + $gl->credit);
							} else {
								$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
								$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '0,00');
							}
						}
					} else if ($gl->jurnal_tipe == 2) {

						$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $gl->coa_id);
						$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $gl->coa_name);
						$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
						$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0,00');
						$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $gl->debit);
						$totalMD += $gl->debit;
						$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $gl->credit);
						$totalMC += $gl->credit;

						if (($gl->debit - $gl->credit) > 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, ($gl->debit - $gl->credit));
							$totalRD += ($gl->debit - $gl->credit);
							$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '0,00');
						} else if (($gl->debit - $gl->credit) < 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, ($gl->debit - $gl->credit));
							$totalRD += ($gl->debit - $gl->credit);
							$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '0,00');
						} else {
							$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '0,00');
						}
						$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
						$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '0,00');
					} else if ($gl->jurnal_tipe == 3) {

						$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $gl->coa_id);
						$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $gl->coa_name);
						$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
						$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0,00');
						$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $gl->debit);
						$totalMD += $gl->debit;
						$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $gl->credit);
						$totalMC += $gl->credit;
						if (($gl->debit - $gl->credit) > 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, ($gl->debit - $gl->credit));
							$totalRC += ($gl->debit - $gl->credit);
						} else if (($gl->debit - $gl->credit) < 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, ($gl->debit - $gl->credit));
							$totalRC += ($gl->debit - $gl->credit);
						} else {
							$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '0,00');
							$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '0,00');
						}
						$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
						$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '0,00');
					}
					$rowCount++;
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount += 1, '');
				$objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Saldo Rugi Laba');
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '0,00');
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0,00');
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '0,00');
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '0,00');
				if (($totalRC * -1) > $totalRD) {
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, ($totalRC * -1) - $totalRD);
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '0,00');
				} else {
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '0,00');
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, ($totalRD - ($totalRC * -1)));
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '0,00');
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '0,00');

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount += 1, '');
				$objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'TOTAL');
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $totalSD);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $totalSC);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $totalMD);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $totalMC);
				if (($totalRC * -1) > $totalRD) {
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $totalRD + (($totalRC * -1) - $totalRD));
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $totalRC);
				} else {
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $totalRD);
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $totalRC + ($totalRD - ($totalRC)));
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $totalND);
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $totalNC);

				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save('./assets/excel/Rekap GL - ' . $date . '.xlsx');

				$this->load->helper('download');
				force_download('./assets/excel/Rekap GL - ' . $date . '.xlsx', NULL);
			} else {
				redirect('/GL', 'refresh');
			}
		} else if ($report == 14) {

			$date = $this->input->post('dateReport');
			$gl = $this->M_gl->labaRugi($date);
			$jt = $this->M_gl->jurnalLabaRugi($date);
			$coa = $this->M_gl->parentCoA($date);

			if ($gl != null) {

				$date = $this->input->post('dateReport');
				$dataGL = $this->M_gl->labaRugi($date);
				$dataJurnal = $this->M_gl->jurnalLabaRugi($date);
				$dataCoA = $this->M_gl->parentCoA($date);

				error_reporting(E_ALL);

				include_once './assets/phpexcel/Classes/PHPExcel.php';
				$objPHPExcel = new PHPExcel();
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->setActiveSheetIndex(0);
				$rowCount = 6;

				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1')->setCellValue("A1", "Building Management SCBD Suites");
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2')->setCellValue("A2", "Surplus / Defisit Detail");
				$objPHPExcel->getActiveSheet()->mergeCells('A3:B3')->setCellValue("A3", "Bulan : " . strtoupper(date('F Y', strtotime($date))));
				$objPHPExcel->getActiveSheet()->mergeCells('A4:B4')->setCellValue("A4", "Valuta : IDR Indonesian Rupiah");

				$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
				$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(25);
				$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
				$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);
				// $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				// $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFill()->getStartColor()->setARGB('bfb8b8');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				// $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle('A1:D4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

				// $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

				for ($i = 'B'; $i < 'E'; $i++) {
					$objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					$objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}

				$totalNeracaC = 0;
				$totalNeracaL = 0;
				$totalNeracaV = 0;

				foreach ($dataJurnal as $jt) {

					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $jt->type_name);
					$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "");
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "");
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "");
					$rowCount++;

					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "");
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "");
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "");
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "");
					$rowCount++;

					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $jt->type_name);
					$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Current Month");
					$objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "Last Month");
					$objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "Varian");
					$objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getFont()->setBold(true);
					$rowCount++;

					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "");
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "");
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "");
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "");
					$rowCount++;

					$totalACP = 0;
					$totalALP = 0;
					$totalAVP = 0;

					foreach ($dataCoA as $coa) {

						if ($jt->jurnal_tipe == $coa->jurnal_tipe) {
							$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $coa->parent_name);
							$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "");
							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "");
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "");
							$rowCount++;

							$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "");
							$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "");
							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "");
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "");
							$rowCount++;

							$totalCP = 0;
							$totalLP = 0;
							$totalVP = 0;

							foreach ($dataGL as $gl) {
								if ($gl->parent == $coa->parent) {
									if ($gl->saldo == NULL && $gl->saldoLast == NULL) {
									} else {
										$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $gl->coa_name);

										if ($gl->saldo < 0 && $coa->jurnal_tipe == 2) {
											$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '(' . saldo_money($gl->saldo) . ')');
											$totalCP += $gl->saldo;
										} else if ($gl->saldo >= 0 && $coa->jurnal_tipe == 2) {
											$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, saldo_money($gl->saldo));
											$totalCP += $gl->saldo;
										} else if ($gl->saldo < 0 && $coa->jurnal_tipe == 3) {
											$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, saldo_money($gl->saldo));
											$totalCP += $gl->saldo;
										} else if ($gl->saldo >= 0 && $coa->jurnal_tipe == 3) {
											$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '(' . saldo_money($gl->saldo) . ')');
											$totalCP += $gl->saldo;
										} else {
											$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '(' . saldo_money(0, 00) . ')');
											$totalCP += 0;
										}

										if ($gl->saldoLast != null && $gl->saldoLast < 0 && $coa->jurnal_tipe == 2) {
											$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '(' . saldo_money($gl->saldoLast) . ')');
											$totalLP += $gl->saldoLast;
										} else if ($gl->saldoLast != null && $gl->saldoLast >= 0 && $coa->jurnal_tipe == 2) {
											$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, saldo_money($gl->saldoLast));
											$totalLP += $gl->saldoLast;
										} else if ($gl->saldoLast != null && $gl->saldoLast >= 0 && $coa->jurnal_tipe == 3) {
											$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, saldo_money($gl->saldoLast));
											$totalLP += $gl->saldoLast;
										} else if ($gl->saldoLast != null && $gl->saldoLast < 0 && $coa->jurnal_tipe == 3) {
											$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '(' . saldo_money($gl->saldoLast) . ')');
											$totalLP += $gl->saldoLast;
										} else {
											$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '(' . saldo_money(0, 00) . ')');
											$totalLP += 0;
										}

										if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) < 0 && $coa->jurnal_tipe == 2) {
											$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '(' . saldo_money($gl->saldo - $gl->saldoLast) . ')');
											$totalVP += ($gl->saldo - $gl->saldoLast);
										} else if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) >= 0 && $coa->jurnal_tipe == 2) {
											$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, saldo_money($gl->saldo - $gl->saldoLast));
											$totalVP += ($gl->saldo - $gl->saldoLast);
										} else if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) >= 0 && $coa->jurnal_tipe == 3) {
											$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '(' . saldo_money($gl->saldo - $gl->saldoLast) . ')');
											$totalVP += ($gl->saldo - $gl->saldoLast);
										} else if ($gl->saldoLast != null && ($gl->saldo - $gl->saldoLast) < 0 && $coa->jurnal_tipe == 3) {
											$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, saldo_money($gl->saldo - $gl->saldoLast));
											$totalVP += ($gl->saldo - $gl->saldoLast);
										} else if ($gl->saldoLast == null && $gl->saldo < 0 && $coa->jurnal_tipe == 2) {
											$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '(' . saldo_money($gl->saldo) . ')');
											$totalVP += $gl->saldo;
										} else if ($gl->saldoLast == null && $gl->saldo >= 0 && $coa->jurnal_tipe == 2) {
											$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, saldo_money($gl->saldo));
											$totalVP += $gl->saldo;
										} else if ($gl->saldoLast == null && $gl->saldo < 0 && $coa->jurnal_tipe == 3) {
											$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, saldo_money($gl->saldo));
											$totalVP += $gl->saldo;
										} else if ($gl->saldoLast == null && $gl->saldo >= 0 && $coa->jurnal_tipe == 3) {
											$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '(' . saldo_money($gl->saldo) . ')');
											$totalVP += $gl->saldo;
										} else {
											$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowDount, '(' . saldo_money(0, 00) . ')');
											$totalVP += 0;
										}
										$rowCount++;
									}
								}
							}

							$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'TOTAL ' . $coa->parent_name);
							$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount)->getFont()->setBold(true);
							if ($totalCP < 0 && $coa->jurnal_tipe == 2) {
								$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '(' . saldo_money($totalCP) . ')');
								$totalACP += $totalCP;
							} else if ($totalCP >= 0 && $coa->jurnal_tipe == 2) {
								$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, saldo_money($totalCP));
								$totalACP += $totalCP;
							} else if ($totalCP >= 0 && $coa->jurnal_tipe == 3) {
								$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '(' . saldo_money($totalCP) . ')');
								$totalACP += $totalCP;
							} else {
								$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, saldo_money($totalCP));
								$totalACP += $totalCP;
							}

							if ($totalLP < 0 && $coa->jurnal_tipe == 2) {
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '(' . saldo_money($totalLP) . ')');
								$totalALP += $totalLP;
							} else if ($totalLP >= 0 && $coa->jurnal_tipe == 2) {
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, saldo_money($totalLP));
								$totalALP += $totalLP;
							} else if ($totalLP >= 0 && $coa->jurnal_tipe == 3) {
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '(' . saldo_money($totalLP) . ')');
								$totalALP += $totalLP;
							} else {
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, saldo_money($totalLP));
								$totalALP += $totalLP;
							}

							if ($totalVP < 0 && $coa->jurnal_tipe == 2) {
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '(' . saldo_money($totalVP) . ')');
								$totalAVP += $totalVP;
							} else if ($totalVP >= 0 && $coa->jurnal_tipe == 2) {
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, saldo_money($totalVP));
								$totalAVP += $totalVP;
							} else if ($totalVP >= 0 && $coa->jurnal_tipe == 3) {
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '(' . saldo_money($totalVP) . ')');
								$totalAVP += $totalVP;
							} else {
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, saldo_money($totalVP));
								$totalAVP += $totalVP;
							}
							$rowCount++;

							$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "");
							$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "");
							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "");
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "");
							$rowCount++;
						}
					}

					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'TOTAL ' . $jt->type_name);
					$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount)->getFont()->setBold(true);
					if ($totalACP < 0 && $jt->jurnal_tipe == 2) {
						$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '(' . saldo_money($totalACP) . ')');
						$totalNeracaC += $totalACP;
					} else if ($totalACP >= 0 && $jt->jurnal_tipe == 2) {
						$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, saldo_money($totalACP));
						$totalNeracaC += $totalACP;
					} else if ($totalACP >= 0 && $jt->jurnal_tipe == 3) {
						$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '(' . saldo_money($totalACP) . ')');
						$totalNeracaC += $totalACP;
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, saldo_money($totalACP));
						$totalNeracaC += $totalACP;
					}

					if ($totalALP < 0 && $jt->jurnal_tipe == 2) {
						$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '(' . saldo_money($totalALP) . ')');
						$totalNeracaL += $totalALP;
					} else if ($totalALP >= 0 && $jt->jurnal_tipe == 2) {
						$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, saldo_money($totalALP));
						$totalNeracaL += $totalALP;
					} else if ($totalALP >= 0 && $jt->jurnal_tipe == 3) {
						$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '(' . saldo_money($totalALP) . ')');
						$totalNeracaL += $totalALP;
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, saldo_money($totalALP));
						$totalNeracaL += $totalALP;
					}

					if ($totalAVP < 0 && $jt->jurnal_tipe == 2) {
						$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '(' . saldo_money($totalAVP) . ')');
						$totalNeracaV += $totalAVP;
					} else if ($totalAVP >= 0 && $jt->jurnal_tipe == 2) {
						$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, saldo_money($totalAVP));
						$totalNeracaV += $totalAVP;
					} else if ($totalAVP >= 0 && $jt->jurnal_tipe == 3) {
						$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '(' . saldo_money($totalAVP) . ')');
						$totalNeracaV += $totalAVP;
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, saldo_money($totalAVP));
						$totalNeracaV += $totalAVP;
					}
					$rowCount++;
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "");
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "");
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "");
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "");
				$rowCount++;

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "");
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "");
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "");
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "");
				$rowCount++;

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "TOTAL Surplus/Defisit");
				$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount)->getFont()->setBold(true);

				if ($totalNeracaC > 0) {
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '(' . saldo_money($totalNeracaC) . ')');
				} else {
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, saldo_money($totalNeracaC));
				}

				if ($totalNeracaL > 0) {
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '(' . saldo_money($totalNeracaL) . ')');
				} else {
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, saldo_money($totalNeracaL));
				}

				if ($totalNeracaV > 0) {
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '(' . saldo_money($totalNeracaV) . ')');
				} else {
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, saldo_money($totalNeracaV));
				}

				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save('./assets/excel/Detail Surplus Defisit - ' . $date . '.xlsx');

				$this->load->helper('download');
				force_download('./assets/excel/Detail Surplus Defisit - ' . $date . '.xlsx', NULL);
			} else {
				redirect('/GL', 'refresh');
			}
		} else {
			redirect('/GL', 'refresh');
		}
	}

	public function getPeriodJson()
	{
		$dataGLPeriod = $this->M_gl->select_all_gl();

		$response = [
			"data" => $dataGLPeriod
		];
		echo json_encode($response);
	}

	// public function retained()
	// {
	// 	$available = $this->M_gl->select_retained();

	// 	foreach($available as $a){

	// 		$data = [
	//             'cash' => $a->id_gl,
	//             'bukti_transaksi' => $a->bukti_transaksi,
	//             'id_customer' => $a->id_customer,
	//             'id_owner' => $a->id_owner,
	//             'tanggal_transaksi' => $a->tanggal_transaksi,
	//             'keterangan' => $a->keterangan,
	//             'kode_soa' => $a->kode_soa,
	//             'debit' => $a->debit,
	//             'credit' => $a->credit,
	//             'so' => $a->so
	//         ];

	//         $this->M_gl->insert3($data);
	// 	}
	// }

	// public function retainedInput()
	// {
	// 	$currentDateTime = date('Y-m-d H:i:s');
	// 	$available = $this->M_gl->select_retained_input($currentDateTime);
	// 	$available2 = $this->M_gl->select_retained_input_last($currentDateTime);

	// 	foreach($available as $a){

	// 		$data = [
	//             'cash' => $a->cash,
	//             'bukti_transaksi' => $a->bukti_transaksi,
	//             'id_customer' => $a->id_customer,
	//             'id_owner' => $a->id_owner,
	//             'tanggal_transaksi' => $currentDateTime,
	//             'keterangan' => 'Retained Earning Current Year',
	//             'kode_soa' => 270,
	//             'debit' => $a->debit,
	//             'credit' => $a->credit,
	//             'so' => $a->so
	//         ];

	//         $this->M_gl->insert2($data);
	// 	}

	// 	foreach($available2 as $a){

	// 		$data = [
	//             'cash' => $a->cash,
	//             'bukti_transaksi' => $a->bukti_transaksi,
	//             'id_customer' => $a->id_customer,
	//             'id_owner' => $a->id_owner,
	//             'tanggal_transaksi' => $currentDateTime,
	//             'keterangan' => 'Retained Earning Last Year',
	//             'kode_soa' => 269,
	//             'debit' => $a->debit,
	//             'credit' => $a->credit,
	//             'so' => $a->so
	//         ];

	//         $this->M_gl->insert2($data);
	// 	}
	// }

	public function update()
	{
		$id = trim($_POST['id']);
		$gl = $this->M_gl->select_by_id($id);

		$data['userdata'] = $this->userdata;
		$data['dataGL'] = $this->M_gl->select_by_id($id);
		$data['dataBTGL'] = $this->M_gl->select_by_bt($gl->bukti_transaksi);
		$data['dataCoA'] = $this->M_coa->select_all();

		echo show_my_modal('modals/modal_update_gl', 'update-gl', $data, 'lg');
	}

	public function prosesUpdate()
	{
		$this->form_validation->set_rules('date', 'GL Date', 'trim|required');
		$this->form_validation->set_rules('ket[]', 'Keterangan GL', 'trim|required');
		$this->form_validation->set_rules('coa[]', 'COA', 'trim|required');
		$this->form_validation->set_rules('debit[]', 'Total Debit', 'trim|required');
		$this->form_validation->set_rules('credit[]', 'Total Credit', 'trim|required');

		$post = $this->input->post();

		if ($this->form_validation->run() == TRUE) {

			$result = $this->M_gl->update_gl($post);

			if ($result > 0) {
				helper_log("edit", "Mengubah Data (GL)", $post['id-bukti-tr']);
				$out['status'] = '';
				$out['msg'] = show_succ_msg('GL Data Successfully Changed', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('GL Data Failed To Change', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}
}

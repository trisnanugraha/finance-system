<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_service');
        $this->load->model('M_ar');
        $this->load->model('M_gl');
        $this->load->model('M_owner');
        $this->load->model('M_rates');
        $this->load->model('M_period');
        $this->load->model('M_parameter');
        $this->load->model('M_electricity');
        $this->load->model('M_candidate_key');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['userdata'] = $this->userdata;
        $data['dataService'] = $this->M_service->select_all();
        $data['dataOwner'] = $this->M_owner->select_all();
        $data['dataRates'] = $this->M_rates->current_rate();
        $data['dataPeriod'] = $this->M_period->select_service();

        $data['page'] = "Service Charge and Sinking Fund";
        $data['judul'] = "Service Bills";
        $data['deskripsi'] = "Manage Service Bills";

        $data['modal_tambah_service'] = show_my_modal('modals/modal_tambah_service', 'tambah-service', $data);

        $js = $this->load->view('service/service-js', null, true);
        $this->template->views('service/home', $data, $js);
    }

    public function tampil()
    {
        $owner = $this->input->get('owner');
        $startDate = $this->input->get("startDate");
        $endDate = $this->input->get("endDate");
        $data['dataService'] = $this->M_service->select_filter($owner, $startDate, $endDate);
        $this->load->view('service/list_data', $data);
    }

    public function tampilPeriodeOwner()
    {
        $owner = $this->input->post()['kodeOwner'];
        $data = $this->M_service->select_periode_service_owner($owner);
        $response = [
            "errorCode" => 0,
            "data" => $data
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function prosesTambah()
    {
        $this->form_validation->set_rules('kodeOwner', 'Owner ID', 'trim|required');
        $this->form_validation->set_rules('period', 'Period', 'trim|required');

        $post = $this->input->post();
        if ($this->form_validation->run() == TRUE) {

            if ($this->M_service->check_bill($post['kodeOwner'], $post['period']) > 0) {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Service Bill For This Period Already Inserted', '20px');
            } else {
                $rate = $this->M_rates->select_by_id($post['hiddenIdTarif']);
                $end = $this->M_period->get_end_periode($post['period']);
                $owner = $this->M_owner->select_by_id($post['kodeOwner']);

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

                if ($this->M_ar->check_bill($owner->customer, $post['period'], 22) > 0) {
                    $out['status'] = '';
                    $out['msg'] = show_err_msg('Kartu Piutang For This Period Already Inserted', '20px');
                } else {
                    $dataAR = [
                        'id_periode' => $post['period'],
                        'id_customer' => $owner->customer,
                        'id_owner' => $post['kodeOwner'],
                        'kode_soa' => 22,
                        'bukti_transaksi' => $id->id_service,
                        'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $post['kodeOwner'] . '',
                        'total' => $sinking + $service + $stampValue,
                        'sisa' => $sinking + $service + $stampValue,
                        'status' => 0,
                        'so' => 1
                    ];
                    $this->M_ar->insert($dataAR);

                    $data10 = [
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

                    $this->M_gl->insert2($data10);
                    $this->M_gl->insert2($data11);
                    $this->M_gl->insert2($data12);
                    $this->M_gl->insert2($data13);
                    $this->M_gl->insert2($data14);
                    $this->M_gl->insert2($data15);
                    $this->M_gl->insert2($data21);
                    $this->M_gl->insert2($data22);
                    $this->M_gl->insert2($data31);
                    $this->M_gl->insert2($data32);

                    $data = [
                        'kode_tagihan_service' => $id->id_service,
                        'kode_ower' => $post['kodeOwner'],
                        'id_tarif' => $rate->id,
                        'id_periode' => $post['period'],
                        'end_periode' => $end->end_periode,
                        'sinking_fund' => $sinking,
                        'service_charge' => $service,
                        'stamp' => $stampValue,
                        'paid' => 0,
                        'total' => $service + $sinking + $stampValue
                    ];

                    $result = $this->M_service->insert($data);

                    if ($result > 0) {
                        helper_log("add", "Menambah Data (Service Charge)", $data['kode_tagihan_service']);
                        $out['status'] = '';
                        $out['msg'] = show_succ_msg('Service Bill Data Successfully Added', '20px');
                    } else {
                        $out['status'] = '';
                        $out['msg'] = show_err_msg('Service Bill Data Failed To Add', '20px');
                    }
                }
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }

    public function print($id)
    {
        $sc = $this->M_service->print($id);

        if ($sc != null) {
            $signature = $this->M_parameter->select_by_id('authorized_signature_billing_key');

            $data['dataService'] = [$sc];
            $data['signature'] = $signature;

            $html = $this->load->view('service/print', $data, true);
            $filename = 'report_' . time();
            $this->pdf->generate($html, $filename, true, 'letter');
        } else {
            redirect('/Service', 'refresh');
        }
    }

    public function delete()
    {
        $id = $_POST['id'];
        $checkpaid = $this->M_service->select_by_id($id);

        if ($checkpaid->paid == 1) {
            echo show_err_msg('Service Charge Bill Already Paid, Unable to Delete', '20px');
        } else {

            $result = $this->M_service->delete($id);
            if ($result > 0) {
                helper_log("delete", "Menghapus Data (Service Charge)", $id);
                echo show_succ_msg('Service Charge Bill Deleted Successfully', '20px');
            } else {
                echo show_err_msg('Service Charge Bill Failed To Delete', '20px');
            }
        }
    }

    public function delete_all()
    {
        $post = $this->input->post(null, TRUE);
        $id = json_decode($_POST["checkbox_value"]);

        for ($count = 0; $count < count($id); $count++) {
            $checkpaid = $this->M_service->select_by_id($id[$count]);

            if ($checkpaid->paid == 1) {
                echo show_err_msg('Service Charge Bill Already Paid, Unable to Delete', '20px');
                $result = 0;
            } else {
                helper_log("delete", "Menghapus Semua Data (Service Charge)");
                $result = $this->M_service->delete_all($id[$count]);
            }
        }
        if ($result > 0) {
            echo show_succ_msg('Service Charge Bill List Deleted Successfully', '20px');
        } else if ($result < 0) {
            echo show_err_msg('Service Charge Bill List Failed To Delete', '20px');
        } else {
        }
    }

    public function prosesTambahByPeriod()
    {

        $this->form_validation->set_rules('period', 'Periode', 'trim|required');

        $post = $this->input->post();
        $row = 0;
        if ($this->form_validation->run() == TRUE) {

            $available = $this->M_service->select_inv_not_bill($post['period']);

            foreach ($available as $a) {
                $rate = $this->M_rates->select_by_id($post['tarif']);
                $end = $this->M_period->get_end_periode($post['period']);
                $owner = $this->M_owner->select_by_id($a->kode_owner);

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

                if ($this->M_ar->check_bill($owner->customer, $post['period'], 22) > 0) {
                    $out['status'] = '';
                    $out['msg'] = show_err_msg('Kartu Piutang For This Period Already Inserted', '20px');
                } else {
                    $dataAR = [
                        'id_periode' => $a->id_periode,
                        'id_customer' => $owner->customer,
                        'id_owner' => $a->kode_owner,
                        'kode_soa' => 22,
                        'bukti_transaksi' => $id->id_service,
                        'keterangan' => '' . date('d/m/Y', strtotime($end->periode_satu)) . '-' . date('d/m/Y', strtotime($end->end_periode)) . ' ' . $a->kode_owner . '',
                        'total' => $sinking + $service + $stampValue,
                        'sisa' => $sinking + $service + $stampValue,
                        'status' => 0,
                        'so' => 1
                    ];
                    $this->M_ar->insert($dataAR);

                    $data10 = [
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

					$this->M_gl->insert2($data10);
					$this->M_gl->insert2($data11);
					$this->M_gl->insert2($data12);
					$this->M_gl->insert2($data13);
					$this->M_gl->insert2($data14);
					$this->M_gl->insert2($data15);
					$this->M_gl->insert2($data21);
					$this->M_gl->insert2($data22);
					$this->M_gl->insert2($data31);
					$this->M_gl->insert2($data32);

                    $data = [
                        'kode_tagihan_service' => $id->id_service,
                        'kode_owner' => $a->kode_owner,
                        'id_tarif' => $rate->id,
                        'id_periode' => $post['period'],
                        'end_periode' => $end->end_periode,
                        'sinking_fund' => $sinking,
                        'service_charge' => $service,
                        'stamp' => $stampValue,
                        'total' => $service + $sinking + $stampValue,
                        'paid' => 0
                    ];
    
    
                    $result = $this->M_service->insert($data);
                    $row = $result;
                }

                
            }
            if ($row > 0) {
                helper_log("add", "Menambah Data By Period (Service Charge)");
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Service Bill Data Successfully Added', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Service Bill Data Failed To Add', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }

    public function printMultiple()
    {
        $id_periode = $this->input->post('period');
        $sc = $this->M_service->print_periode($id_periode);

        if ($sc != null) {
            $signature = $this->M_parameter->select_by_id('authorized_signature_billing_key');

            $data['dataService'] = $sc;
            $data['signature'] = $signature;


            $html = $this->load->view('service/print', $data, true);
            $filename = 'report_' . time();
            $paper = 'letter';
            $this->pdf->generate($html, $filename, true, $paper);
        } else {
            redirect('/Service', 'refresh');
        }
    }

    public function multipleServicePeriod()
    {
        $data['dataRates'] = $this->M_rates->current_rate();
        $data['dataPeriod'] = $this->M_service->select_period_not_bill();

        echo show_my_modal('modals/modal_tambah_service-period', 'add-service-period', $data);
    }

    public function countAvailableServicePeriod()
    {
        $id_period = $this->input->get('period');

        $availablebill = $this->M_service->select_inv_not_bill($id_period);

        $response = [
            'count' => count($availablebill)
        ];

        echo json_encode($response);
    }

    public function period()
    {
        $dataPeriod = $this->M_service->select_periode_service();

        $response = [
            'errorCode' => 0,
            'data' => $dataPeriod
        ];


        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function invoice()
    {

        $available = $this->M_service->select_invoice();

        foreach ($available as $a) {
            $period = $this->M_period->select_by_id($a->id_periode);
            $owner = $this->M_owner->select_by_id($a->kode_owner);

            $dt = DateTime::createFromFormat("Y-m-d", $a->end_periode);
            $dtNextMonth = $dt->modify('first day of next month');
            $year = $dtNextMonth->format('y');
            $month = $dtNextMonth->format('m');

            $currentNumber = $this->M_service->get_last_id($dtNextMonth);

            $formatBillingId = $this->M_candidate_key->select_by_id('service_key');

            $id = str_replace('@year', $year, $formatBillingId->key);
            $id = str_replace('@month', $month, $id);
            $id = str_replace('@counter', str_pad($currentNumber->maxNumber, $formatBillingId->counter_count, '0', STR_PAD_LEFT), $id);


            $data = [
                'id_service' => $id,
                'kode_owner' => $a->kode_owner,
                'id_periode' => $a->id_periode,
                'd_c_note_date' => $dtNextMonth->format('Y/m/d')
            ];

            $this->M_service->insert_invoice($data);
        }
    }
}

/* End of file Service.php */
/* Location: ./application/controllers/Service.php */

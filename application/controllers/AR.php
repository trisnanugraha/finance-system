<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AR extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_ar');
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
        $this->load->library('pdf_landscape');
    }

    public function index()
    {
        $data['userdata'] = $this->userdata;
        $data['dataAR'] = $this->M_ar->select_all();
        $data['dataARCUS'] = $this->M_ar->select_cus();
        $data['dataCoa'] = $this->M_coa->select_all();
        $data['dataCoaAR'] = $this->M_coa->select_all_coa_ar();
        $data['dataBilling'] = $this->M_billing->select_all();
        $data['dataCustomer'] = $this->M_customer->select_all();
        $data['dataService'] = $this->M_service->select_all();
        $data['dataOwner'] = $this->M_owner->select_all();
        $data['dataRates'] = $this->M_rates->select_all();
        $data['dataPeriod'] = $this->M_period->select_all();
        $data['page'] = "Kartu Piutang (AR)";
        $data['judul'] = "Kartu Piutang (AR)";
        $data['deskripsi'] = "Manage Kartu Piutang (AR) Data";
        $js = $this->load->view('ar/ar-js', null, true);
        $this->template->views('ar/home', $data, $js);
    }

    public function tampil()
    {
        $akun = $this->input->get('akun');
        $startDate = $this->input->get("startDate");
        $endDate = $this->input->get("endDate");
        $data['dataAR'] = $this->M_ar->select_filter($akun, $startDate, $endDate);
        $this->load->view('ar/list_data', $data);
    }

    public function billing()
    {
        $this->form_validation->set_rules('period', 'Period', 'trim|required');
        $this->form_validation->set_rules('kodeCus', 'Customer', 'trim|required');
        $post = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            if ($this->M_ar->check_bill($post['kodeCus'], $post['period'], 21) > 0) {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Kartu Piutang For This Period Already Inserted', '20px');
            } else {
                $periode = $this->M_period->select_by_id($post['period']);
                $end = $this->M_period->get_end_periode($post['period']);
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
                    'id_periode' => $post['period'],
                    'id_customer' => $post['kodeCus'],
                    'id_owner' => $customer->owner,
                    'kode_soa' => 21,
                    'bukti_transaksi' => $listrik->id_listrik,
                    'total' => $listrik->total + $air->total + $stampValue,
                    'sisa' => $listrik->total + $air->total + $stampValue,
                    'status' => 0,
                    'so' => 0,
                    'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama
                ];
                $result = $this->M_ar->insert($data);

                if ($result > 0) {
                    helper_log("add", "Menambah Data (Kartu Piutang)", $data['bukti_transaksi']);
                    $out['status'] = '';
                    $out['msg'] = show_succ_msg('Kartu Piutang Data Successfully Added', '20px');
                } else {
                    $out['status'] = '';
                    $out['msg'] = show_err_msg('Kartu Piutang Data Failed To Add', '20px');
                }
            }
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
                if ($this->M_ar->check_bill($a->kode_customer, $post['period'], 21) > 0) {
                    $out['status'] = '';
                    $out['msg'] = show_err_msg('Kartu Piutang For This Period Already Inserted', '20px');
                } else {
                    $periode = $this->M_period->select_by_id($a->id_periode);
                    $end = $this->M_period->get_end_periode($a->id_periode);
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
                        'id_periode' => $a->id_periode,
                        'id_customer' => $a->kode_customer,
                        'id_owner' => $customer->owner,
                        'kode_soa' => 21,
                        'bukti_transaksi' => $a->id_listrik,
                        'total' => $listrik->total + $air->total + $stampValue,
                        'sisa' => $listrik->total + $air->total + $stampValue,
                        'status' => 0,
                        'so' => 0,
                        'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama
                    ];
                    $result = $this->M_ar->insert($data);
                    $row = $result;
                }
            }
            if ($row > 0) {
                helper_log("add", "Menambah Data By Period (Kartu Piutang)");
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Kartu Piutang Data Successfully Added', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Kartu Piutang Data Failed To Add', '20px');
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
            $period = $this->M_period->select_by_id($post['period']);
            $end = $this->M_period->get_end_periode($post['period']);
            $owner = $this->M_owner->select_by_id($post['kodeOwner']);
            if ($this->M_ar->check_bill($owner->customer, $post['period'], 22) > 0) {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Kartu Piutang For This Period Already Inserted', '20px');
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
                $result = $this->M_ar->insert($data);
                if ($result > 0) {
                    helper_log("add", "Menambah Data Service (Kartu Piutang)", $data['bukti_transaksi']);
                    $out['status'] = '';
                    $out['msg'] = show_succ_msg('Kartu Piutang Bill Data Successfully Added', '20px');
                } else {
                    $out['status'] = '';
                    $out['msg'] = show_err_msg('Kartu Piutang Bill Data Failed To Add', '20px');
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
                if ($this->M_ar->check_bill($owner->customer, $post['period'], 22) > 0) {
                    $out['status'] = '';
                    $out['msg'] = show_err_msg('Kartu Piutang For This Period Already Inserted', '20px');
                } else {
                    $rate = $this->M_rates->select_by_id($post['tarif']);
                    $id = $this->M_service->select_invoice_owner_period($a->kode_owner, $post['period']);
                    $sinking = $owner->sqm * 3 * $rate->sinking;
                    $service = $owner->sqm * 3 * $rate->service;
                    $stamp = $this->M_parameter->select_by_id('stamp_key');
                    $bill_stamp_limit_key = $this->M_parameter->select_by_id('bill_stamp_limit_key');
                    if (($sinking + $service) < floatval($bill_stamp_limit_key->param1)) {
                        $stampValue = floatval($stamp->param1);
                    } else {
                        $stampValue = floatval($stamp->param2);
                    }
                    $data = [
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
                    $result = $this->M_ar->insert($data);
                    $row = $result;
                }
            }
            if ($row > 0) {
                helper_log("add", "Menambah Data Service By Period (Kartu Piutang)", $data['bukti_transaksi']);
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Kartu Piutang Data Successfully Added', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Kartu Piutang Data Failed To Add', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }
        echo json_encode($out);
    }

    public function delete()
    {
        $id = $_POST['id_ar'];
        $result = $this->M_ar->delete($id);
        if ($result) {
            helper_log("delete", "Menghapus Data (Kartu Piutang)", $id);
            echo show_succ_msg('Piutang (AR) Data Successfully Deleted', '20px');
        } else {
            echo show_err_msg('Piutang (AR) Data Failed To Delete', '20px');
        }
    }

    public function delete_all()
    {
        $post = $this->input->post(null, TRUE);
        $id = json_decode($_POST["checkbox_value"]);
        for ($count = 0; $count < count($id); $count++) {
            $result = $this->M_ar->delete_all($id[$count]);
        }
        if ($result > 0) {
            helper_log("delete", "Menghapus Semua Data (Kartu Piutang)");
            echo show_succ_msg('Piutang (AR) List Deleted Successfully', '20px');
        } else {
            echo show_err_msg('Piutang (AR) List Failed To Delete', '20px');
        }
    }

    public function multipleARPeriod()
    {
        $data['dataPeriod'] = $this->M_ar->select_period_not_bill();
        echo show_my_modal('modals/modal_tambah_ar-period', 'add-ar-period', $data);
    }

    public function countAvailableARPeriod()
    {
        $id_period = $this->input->get('period');
        $availablear = $this->M_ar->select_inv_not_bill($id_period);
        $response = [
            'count' => count($availablear)
        ];
        echo json_encode($response);
    }

    public function print()
    {
        $CoA = $this->input->post('CoA');
        $kodeCusA = $this->input->post('kodeCusA');
        $kodeCusB = $this->input->post('kodeCusB');
        $dateA = $this->input->post('dateA');
        $dateB = $this->input->post('dateB');

        if ($CoA == 21) {
            $ar = $this->M_ar->print($kodeCusA, $kodeCusB, $dateA, $dateB, $CoA);
            $arCus = $this->M_ar->print_cus_LA($kodeCusA, $kodeCusB, $dateA, $dateB);
            $bayarCus = $this->M_ar->print_bayar_cus_LA($kodeCusA, $kodeCusB, $dateA, $dateB);
            $temp_saldo = $this->M_ar->saldo_cus_LA($kodeCusA, $kodeCusB, $dateA, $dateB);
            $saldoBayar = $this->M_ar->saldo_bayar_LA($kodeCusA, $kodeCusB, $dateA, $dateB);

            $saldo = array();
            foreach ($temp_saldo as $s) {
                $tempSaldo = 0;
                foreach ($saldoBayar as $sb) {
                    if ($sb->id_customer == $s->id_customer) {
                        $tempSaldo += $sb->total;
                        $data[] = (object) [
                            'id_customer' => $sb->id_customer,
                            'saldo' => $s->saldo + $tempSaldo
                        ];
                    }
                }
                array_push($saldo);
            }
        } else if ($CoA == 22) {
            $ar = $this->M_ar->print($kodeCusA, $kodeCusB, $dateA, $dateB, $CoA);
            $arCus = $this->M_ar->print_cus_SCSF($kodeCusA, $kodeCusB, $dateA, $dateB);
            $bayarCus = $this->M_ar->print_bayar_cus_SCSF($kodeCusA, $kodeCusB, $dateA, $dateB);
            $saldo = $this->M_ar->saldo_cus_SCSF($kodeCusA, $kodeCusB, $dateA, $dateB);
        } else if ($CoA == 24) {
            $ar = $this->M_ar->print($kodeCusA, $kodeCusB, $dateA, $dateB, $CoA);
            $arCus = $this->M_ar->print_cus_iuran($kodeCusA, $kodeCusB, $dateA, $dateB);
            $bayarCus = $this->M_ar->print_bayar_cus_iuran($kodeCusA, $kodeCusB, $dateA, $dateB);
            $saldo = $this->M_ar->saldo_cus_iuran($kodeCusA, $kodeCusB, $dateA, $dateB);
        } else if ($CoA == 25) {
            $ar = $this->M_ar->print($kodeCusA, $kodeCusB, $dateA, $dateB, $CoA);
            $arCus = $this->M_ar->print_cus_asuransi($kodeCusA, $kodeCusB, $dateA, $dateB);
            $bayarCus = $this->M_ar->print_bayar_cus_asuransi($kodeCusA, $kodeCusB, $dateA, $dateB);
            $saldo = $this->M_ar->saldo_cus_asuransi($kodeCusA, $kodeCusB, $dateA, $dateB);
        }

        if ($ar != null) {
            $signature = $this->M_parameter->select_by_id('authorized_signature_billing_key');
            $CusA = $this->M_customer->select_by_id($kodeCusA);
            $CusB = $this->M_customer->select_by_id($kodeCusB);

            $data['dataCoA'] = $CoA;
            $data['dataAR'] = $ar;
            $data['dataARCus'] = $arCus;
            $data['dataBayarCus'] = $bayarCus;
            $data['dataSaldo'] = $saldo;
            // $data['dataSaldo'] = $data;
            $data['dataSaldoBayar'] = $saldoBayar;
            $data['dataCusA'] = $CusA;
            $data['dataCusB'] = $CusB;
            $data['dataDateA'] = $dateA;
            $data['dataDateB'] = $dateB;
            $data['signature'] = $signature;
            $html = $this->load->view('ar/print', $data, true);
            $filename = 'kartu_piutang_' . $dateA . '_' . $dateB;
            $this->pdf->generate($html, $filename);
        } else {
            redirect('/AR', 'refresh');
        }
    }

    public function print_aging()
    {
        $CoA = $this->input->post('CoA');
        $date = $this->input->post('date');

        if ($CoA == 21) {
            $ar = $this->M_ar->print_aging_la($date);
            $arCus = $this->M_ar->print_aging_la_cus($date);
            $bayar = $this->M_ar->print_aging_la_bayar($date);
        } else if ($CoA == 22) {
            $ar = $this->M_ar->print_aging_scsf($date);
            $arCus = $this->M_ar->print_aging_scsf_cus($date);
            $bayar = $this->M_ar->print_aging_scsf_bayar($date);
        } else if ($CoA == 24) {
            $ar = $this->M_ar->print_aging_iuran($date);
            $arCus = $this->M_ar->print_aging_iuran_cus($date);
            $bayar = $this->M_ar->print_aging_iuran_bayar($date);
        } else if ($CoA == 25) {
            $ar = $this->M_ar->print_aging_asuransi($date);
            $arCus = $this->M_ar->print_aging_asuransi_cus($date);
            $bayar = $this->M_ar->print_aging_asuransi_bayar($date);
        }

        if ($ar != null) {

            $data['dataAR'] = $ar;
            $data['dataARCus'] = $arCus;
            $data['dataBayar'] = $bayar;
            $data['dataCoA'] = $CoA;
            $data['dataDate'] = $date;

            $html = $this->load->view('ar/print_aging', $data, true);
            $filename = 'aging_piutang_' . $date;
            $this->pdf_landscape->generate($html, $filename, true, 'letter');
        } else {
            redirect('/AR', 'refresh');
        }
    }

    public function getPeriodJson()
    {
        $dataARPeriod = $this->M_ar->select_all_ar();
        $response = [
            "data" => $dataARPeriod
        ];
        echo json_encode($response);
    }
}

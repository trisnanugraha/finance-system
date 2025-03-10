<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_ar');
        $this->load->model('M_billing');
        $this->load->model('M_period');
        $this->load->model('M_customer');
        $this->load->model('M_electricity');
        $this->load->model('M_gl');
        $this->load->model('M_water');
        $this->load->model('M_parameter');
        $this->load->model('M_candidate_key');
        $this->load->model('M_pinalty');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['userdata'] = $this->userdata;
        $data['dataBilling'] = $this->M_billing->select_all();
        $data['dataPeriod'] = $this->M_period->select_all();
        $data['dataCustomer'] = $this->M_customer->select_all();
        $data['page'] = "Billing";
        $data['judul'] = "Billing List";
        $data['deskripsi'] = "Manage Billing List";
        $data['modal_tambah_billing'] = show_my_modal('modals/modal_tambah_billing', 'tambah-billing', $data);
        $js = $this->load->view('billing/billing-js', null, true);
        $this->template->views('billing/home', $data, $js);
    }

    public function tampil()
    {
        $customer = $this->input->get("customer");
        $startDate = $this->input->get("startDate");
        $endDate = $this->input->get("endDate");
        $data['dataBilling'] = $this->M_billing->select_filter($customer, $startDate, $endDate);
        $this->load->view('billing/list_data', $data);
    }

    public function tampilPeriodeCustomer()
    {
        $id_customer = $this->input->post()['kodeCus'];
        $data = $this->M_billing->select_periode_billing_customer($id_customer);
        $response = [
            "errorCode" => 0,
            "data" => $data
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function prosesTambah()
    {
        $this->form_validation->set_rules('period', 'Period', 'trim|required');
        $this->form_validation->set_rules('kodeCus', 'Customer', 'trim|required');
        $post = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $customer = $this->M_customer->select_by_id($post['kodeCus']);
            $end = $this->M_period->get_end_periode($post['period']);
            $periode = $this->M_period->select_by_id($post['period']);

            $dt = DateTime::createFromFormat("Y-m-d", $periode->periodEnd);
            $dtNextMonth = $dt->modify('first day of next month');
            $year = $dtNextMonth->format('y');
            $month = $dtNextMonth->format('m');

            $currentNumber = $this->M_billing->get_last_id($dtNextMonth);
            $formatBillingId = $this->M_candidate_key->select_by_id('billing_key');
            $id = str_replace('@year', $year, $formatBillingId->key);
            $id = str_replace('@month', $month, $id);
            $id = str_replace('@counter', str_pad($currentNumber->maxNumber, $formatBillingId->counter_count, '0', STR_PAD_LEFT), $id);

            $listrik = $this->M_electricity->select_by_customer_and_period($post['kodeCus'], $post['period']);
            $air = $this->M_water->select_by_customer_and_period($post['kodeCus'], $post['period']);

            $stamp = $this->M_parameter->select_by_id('stamp_key');
            $bill_stamp_limit_key = $this->M_parameter->select_by_id('bill_stamp_limit_key');

            if (($listrik->total + $air->total) < floatval($bill_stamp_limit_key->param1)) {
                $stampValue = floatval($stamp->param1);
            } else {
                $stampValue = floatval($stamp->param2);
            }

            if ($this->M_ar->check_bill($post['kodeCus'], $post['period'], 21) > 0) {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Kartu Piutang For This Period Already Inserted', '20px');
            } else {
                $dataAR = [
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
                $resultAR = $this->M_ar->insert($dataAR);

                if ($resultAR > 0) {
                    // if ($this->M_gl->check_bill($post['kodeCus'], $end->periode_satu, 21) > 0) {
                    //     $out['status'] = '';
                    //     $out['msg'] = show_err_msg('General Ledger For This Period Already Inserted', '20px');
                    // } else {
                        $dataGL1 = [
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
                        $dataGL2 = [
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
                        $dataGL3 = [
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
                        $dataGL4 = [
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


                        $this->M_gl->insert2($dataGL2);
                        $this->M_gl->insert2($dataGL3);
                        $this->M_gl->insert2($dataGL4);
                        $resultGL = $this->M_gl->insert2($dataGL1);

                        if ($resultGL > 0) {
                            $data = [
                                'id_billing' => $listrik->id_listrik,
                                'id_customer' => $post['kodeCus'],
                                'id_periode' => $post['period'],
                                'kode_tagihan_listrik' => $listrik->id_listrik,
                                'kode_tagihan_air' => $air->kode_tagihan_air,
                                'total_pinalty' => 0,
                                'paid' => 0,
                                'admin' => $this->userdata->id,
                                'paid_date' => null,
                                'd_c_note_date' => $dtNextMonth->format('Y/m/d'),
                                'stamp' => $stampValue
                            ];
                            $result = $this->M_billing->insert($data);
                            if ($result > 0) {
                                $out['status'] = '';
                                helper_log("add", "Menambah Data (Billing)", $data['id_billing']);
                                $out['msg'] = show_succ_msg('Billing Data Successfully Added', '20px');
                            } else {
                                $out['status'] = '';
                                $out['msg'] = show_err_msg('Billing Data Failed To Add', '20px');
                            }
                        } else {
                            $out['status'] = '';
                            $out['msg'] = show_err_msg('General Ledger Data Failed To Add', '20px');
                        }
                    // }
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

    public function prosesTambahByPeriod()
    {
        $this->form_validation->set_rules('period', 'Period', 'trim|required');
        $post = $this->input->post();
        $row = 0;
        if ($this->form_validation->run() == TRUE) {
            $available = $this->M_billing->select_inv_not_bill($post['period']);
            foreach ($available as $a) {
                $customer = $this->M_customer->select_by_id($a->kode_customer);
                $periode = $this->M_period->select_by_id($a->id_periode);
                $end = $this->M_period->get_end_periode($a->id_periode);
                $dt = DateTime::createFromFormat("Y-m-d", $periode->periodEnd);
                $dtNextMonth = $dt->modify('first day of next month');
                $year = $dtNextMonth->format('y');
                $month = $dtNextMonth->format('m');
                $listrik = $this->M_electricity->select_by_id($a->id_listrik);
                $air = $this->M_water->select_by_id($a->kode_tagihan_air);
                $currentNumber = $this->M_billing->get_last_id($dtNextMonth);
                $formatBillingId = $this->M_candidate_key->select_by_id('billing_key');
                $id = str_replace('@year', $year, $formatBillingId->key);
                $id = str_replace('@month', $month, $id);
                $id = str_replace('@counter', str_pad($currentNumber->maxNumber, $formatBillingId->counter_count, '0', STR_PAD_LEFT), $id);
                $stamp = $this->M_parameter->select_by_id('stamp_key');
                $bill_stamp_limit_key = $this->M_parameter->select_by_id('bill_stamp_limit_key');
                if (($listrik->total + $air->total) < floatval($bill_stamp_limit_key->param1)) {
                    $stampValue = floatval($stamp->param1);
                } else {
                    $stampValue = floatval($stamp->param2);
                }

                if ($this->M_ar->check_bill($a->kode_customer, $a->id_periode, 21) > 0) {
                    $out['status'] = '';
                    $out['msg'] = show_err_msg('Kartu Piutang For This Period Already Inserted', '20px');
                } else {
                    $dataAR = [
                        'id_periode' => $a->id_periode,
                        'id_customer' => $a->kode_customer,
                        'id_owner' => $customer->owner,
                        'kode_soa' => 21,
                        'bukti_transaksi' => $listrik->id_listrik,
                        'total' => $listrik->total + $air->total + $stampValue,
                        'sisa' => $listrik->total + $air->total + $stampValue,
                        'status' => 0,
                        'so' => 0,
                        'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama
                    ];
                    $resultAR = $this->M_ar->insert($dataAR);

                    if ($resultAR > 0) {
                        // if ($this->M_gl->check_bill($post['kodeCus'], $end->periode_satu, 21) > 0) {
                        //     $out['status'] = '';
                        //     $out['msg'] = show_err_msg('General Ledger For This Period Already Inserted', '20px');
                        // } else {
                            $dataGL1 = [
                                'bukti_transaksi' => $listrik->id_listrik,
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
                            $dataGL2 = [
                                'bukti_transaksi' => $listrik->id_listrik,
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
                            $dataGL3 = [
                                'bukti_transaksi' => $listrik->id_listrik,
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
                            $dataGL4 = [
                                'bukti_transaksi' => $listrik->id_listrik,
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

                            $this->M_gl->insert2($dataGL2);
                            $this->M_gl->insert2($dataGL3);
                            $this->M_gl->insert2($dataGL4);
                            $resultGL = $this->M_gl->insert2($dataGL1);

                            if ($resultGL > 0) {
                                $data = [
                                    'id_billing' => $listrik->id_listrik,
                                    'id_customer' => $a->kode_customer,
                                    'id_periode' => $a->id_periode,
                                    'kode_tagihan_listrik' => $listrik->id_listrik,
                                    'kode_tagihan_air' => $air->kode_tagihan_air,
                                    'total_pinalty' => 0,
                                    'paid' => 0,
                                    'admin' => $this->userdata->id,
                                    'paid_date' => null,
                                    'd_c_note_date' => $dtNextMonth->format('Y/m/d'),
                                    'stamp' => $stampValue
                                ];
                                $result = $this->M_billing->insert($data);
                                $row = $result;
                            // } else {
                            //     $out['status'] = '';
                            //     $out['msg'] = show_err_msg('General Ledger Data Failed To Add', '20px');
                            // }
                        }
                    } else {
                        $out['status'] = '';
                        $out['msg'] = show_err_msg('Kartu Piutang Data Failed To Add', '20px');
                    }
                }
            }
            if ($row > 0) {
                $out['status'] = '';
                helper_log("add", "Menambah Data By Period (Billing)");
                $out['msg'] = show_succ_msg('Billing Data Successfully Added', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Billing Data Failed To Add', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }
        echo json_encode($out);
    }

    public function delete()
    {
        $id = $_POST['id'];
        $checkpaid = $this->M_billing->select_by_id($id);
        if ($checkpaid->paid == 1) {
            echo show_err_msg('Billing Already Paid, Unable to Delete', '20px');
        } else {
            $result = $this->M_billing->delete($id);
            if ($result > 0) {
                helper_log("delete", "Menghapus Data (Billing)", $id);
                echo show_succ_msg('Billing List Deleted Successfully', '20px');
            } else {
                echo show_err_msg('Billing List Failed To Delete', '20px');
            }
        }
    }

    public function delete_all()
    {
        $post = $this->input->post(null, TRUE);
        $id = json_decode($_POST["checkbox_value"]);
        for ($count = 0; $count < count($id); $count++) {
            $checkpaid = $this->M_billing->select_by_id($id[$count]);
            if ($checkpaid->paid == 1) {
                echo show_err_msg('Billing Already Paid, Unable to Delete', '20px');
                $result = 0;
            } else {
                helper_log("delete", "Menghapus Semua Data (Billing)");
                $result = $this->M_billing->delete_all($id[$count]);
            }
        }
        if ($result > 0) {
            echo show_succ_msg('Billing List Deleted Successfully', '20px');
        } else if ($result < 0) {
            echo show_err_msg('Billing List Failed To Delete', '20px');
        }
    }

    public function print($idBilling)
    {
        $billing = $this->M_billing->select_by_id($idBilling);
        if ($billing != null) {
            $signature = $this->M_parameter->select_by_id('authorized_signature_billing_key');
            $data['dataBilling'] = [$billing];
            $data['signature'] = $signature;
            $html = $this->load->view('billing/print', $data, true);
            $filename = 'report_' . time();
            $this->pdf->generate($html, $filename);
        } else {
            redirect('/Billing', 'refresh');
        }
    }

    public function printMultiple()
    {
        $idPeriode = $this->input->post('period');
        $billing = $this->M_billing->select_by_periode($idPeriode);
        if ($billing != null) {
            $signature = $this->M_parameter->select_by_id('authorized_signature_billing_key');
            $data['dataBilling'] = $billing;
            $data['signature'] = $signature;
            $html = $this->load->view('billing/print', $data, true);
            $filename = 'report_' . time();
            $this->pdf->generate($html, $filename);
        } else {
            redirect('/Billing', 'refresh');
        }
    }

    public function multipleBillingPeriod()
    {
        $data['dataPeriod'] = $this->M_billing->select_period_not_bill();
        echo show_my_modal('modals/modal_tambah_billing-period', 'add-billing-period', $data);
    }

    public function countAvailableBillingPeriod()
    {
        $id_period = $this->input->get('period');
        $availablebill = $this->M_billing->select_inv_not_bill($id_period);
        $response = ['count' => count($availablebill)];
        echo json_encode($response);
    }

    public function period()
    {
        $dataPeriod = $this->M_billing->select_periode_billing();
        $response = [
            'errorCode' => 0,
            'data' => $dataPeriod
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

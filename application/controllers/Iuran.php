<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Iuran extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_iuran');
        $this->load->model('M_owner');
        $this->load->model('M_rates');
        $this->load->model('M_period');
        $this->load->model('M_parameter');
        $this->load->model('M_gl');
        $this->load->model('M_ar');
        $this->load->model('M_candidate_key');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['userdata'] = $this->userdata;
        $data['dataIuran'] = $this->M_iuran->select_all();
        $data['dataOwner'] = $this->M_owner->select_all();
        $data['dataRates'] = $this->M_rates->current_rate();

        $data['page'] = "Iuran IPK";
        $data['judul'] = "IPK Bills";
        $data['deskripsi'] = "Manage IPK Bills";
        $data['dataPeriod'] = $this->M_iuran->select_period_not_bill();

        $data['modal_tambah_iuran'] = show_my_modal('modals/modal_tambah_iuran', 'tambah-iuran', $data);

        $js = $this->load->view('iuran/iuran-js', null, true);
        $this->template->views('iuran/home', $data, $js);
    }

    public function tampil()
    {
        $owner = $this->input->get("owner");
        $startDate = $this->input->get("startDate");
        $endDate = $this->input->get("endDate");
        $data['dataIuran'] = $this->M_iuran->select_filter($owner, $startDate, $endDate);
        $this->load->view('iuran/list_data', $data);
    }

    public function prosesTambah()
    {
        $this->form_validation->set_rules('period', 'Period', 'trim|required');
        $this->form_validation->set_rules('total', 'Total', 'trim|required');

        $post = $this->input->post();
        $row = 0;
        if ($this->form_validation->run() == TRUE) {
            $available = $this->M_iuran->select_inv_not_bill($post['period']);
            foreach ($available as $a) {
                $periode = $this->M_iuran->select_period($post['period']);
                $owner = $this->M_owner->select_by_id($a->kode_owner);

                $dt = DateTime::createFromFormat("Y-m-d", $periode->periodStart);
                $dtNextMonth = $dt->modify('+1 day');
                $year = $dtNextMonth->format('y');
                $month = $dtNextMonth->format('m');

                $currentNumber = $this->M_iuran->get_last_id($dtNextMonth);

                $formatBillingId = $this->M_candidate_key->select_by_id('iuran_key');

                $id = str_replace('@year', $year, $formatBillingId->key);
                $id = str_replace('@month', $month, $id);
                $id = str_replace('@counter', str_pad($currentNumber->maxNumber, $formatBillingId->counter_count, '0', STR_PAD_LEFT), $id);

                $total = ($owner->sqm / 16329) * $post['total'];

                $stamp = $this->M_parameter->select_by_id('stamp_key');
                $bill_stamp_limit_key = $this->M_parameter->select_by_id('bill_stamp_limit_key');
                if (($total) < floatval($bill_stamp_limit_key->param1)) {
                    $stampValue = floatval($stamp->param1);
                } else {
                    $stampValue = floatval($stamp->param2);
                }

                $data = [
                    'id_iuran' => $id,
                    'kode_owner' => $a->kode_owner,
                    'id_periode' => $post['period'],
                    'stamp' => $stampValue,
                    'total_iuran' => $total + $stampValue,
                    'created_by' => $this->userdata->id,
                    'd_c_note_date' => $dtNextMonth->format('Y/m/d')
                ];

                $dataGL = [
                    'bukti_transaksi' => $id,
                    'id_customer' => $owner->customer,
                    'id_owner' => $a->kode_owner,
                    'tanggal_transaksi' => $periode->first_day,
                    'keterangan' => '' . date('d/m/Y', strtotime($periode->first_day)) . '-' . date('d/m/Y', strtotime($periode->last_day)) . ' ' . $owner->id . ' ' . $owner->nama,
                    'kode_soa' => 24,
                    'debit' => $total + $stampValue,
                    'credit' => 0,
                    'so' => 1,
                    'cash' => 0
                ];

                $data2 = [
                    'bukti_transaksi' => $id,
                    'id_customer' => $owner->customer,
                    'id_owner' => $a->kode_owner,
                    'tanggal_transaksi' => $periode->first_day,
                    'keterangan' => '' . date('d/m/Y', strtotime($periode->first_day)) . '-' . date('d/m/Y', strtotime($periode->last_day)) . ' ' . $owner->id . ' ' . $owner->nama,
                    'kode_soa' => 223,
                    'debit' => 0,
                    'credit' => $total,
                    'so' => 1,
                    'cash' => 0
                ];

                $data3 = [
                    'bukti_transaksi' => $id,
                    'id_customer' => $owner->customer,
                    'id_owner' => $a->kode_owner,
                    'tanggal_transaksi' => $periode->first_day,
                    'keterangan' => '' . date('d/m/Y', strtotime($periode->first_day)) . '-' . date('d/m/Y', strtotime($periode->last_day)) . ' ' . $owner->id . ' ' . $owner->nama,
                    'kode_soa' => 302,
                    'debit' => 0,
                    'credit' => $stampValue,
                    'so' => 1,
                    'cash' => 0
                ];

                $dataAR = [
                    'id_periode' => $post['period'],
                    'id_customer' => $owner->customer,
                    'id_owner' => $a->kode_owner,
                    'kode_soa' => 24,
                    'bukti_transaksi' => $id,
                    'total' => $total + $stampValue,
                    'sisa' => $total + $stampValue,
                    'status' => 0,
                    'so' => 0,
                    'keterangan' => '' . date('d/m/Y', strtotime($periode->periodStart)) . '-' . date('d/m/Y', strtotime($periode->periodEnd)) . ' ' . $customer->kodeCus . ' ' . $customer->nama
                ];

                $this->M_ar->insert($dataAR);
                $this->M_gl->insert2($dataGL);
                $this->M_gl->insert2($data2);
                $this->M_gl->insert2($data3);
                $result = $this->M_iuran->insert($data);
                $row += $result;
            }

            if ($row > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('IPK Bill Data Successfully Added', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('IPK Bill Data Failed To Add', '20px');
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

        $result = $this->M_iuran->delete($id);
        if ($result > 0) {
            helper_log("delete", "Menghapus Data (IPK)", $id);
            echo show_succ_msg('IPK Bill Deleted Successfully', '20px');
        } else {
            echo show_err_msg('IPK Bill Failed To Delete', '20px');
        }
    }

    public function delete_all()
    {
        $post = $this->input->post(null, TRUE);
        $id = json_decode($_POST["checkbox_value"]);

        for ($count = 0; $count < count($id); $count++) {
            $result = $this->M_iuran->delete_all($id[$count]);
        }
        if ($result > 0) {
            echo show_succ_msg('IPK Bill List Deleted Successfully', '20px');
        } else if ($result < 0) {
            echo show_err_msg('IPK Bill List Failed To Delete', '20px');
        } else {
        }
    }

    public function countAvailablePeriod()
    {
        $id_period = $this->input->get('period');

        $availablebill = $this->M_iuran->select_inv_not_bill($id_period);

        $response = [
            'count' => count($availablebill)
        ];

        echo json_encode($response);
    }

    public function period()
    {
        $dataPeriod = $this->M_iuran->select_periode_iuran();

        $response = [
            'errorCode' => 0,
            'data' => $dataPeriod
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function print($id)
    {
        $sc = $this->M_iuran->print($id);

        if ($sc != null) {
            $signature = $this->M_parameter->select_by_id('authorized_signature_billing_key');

            $data['dataIuran'] = [$sc];
            $data['signature'] = $signature;


            $html = $this->load->view('iuran/print', $data, true);
            $filename = 'report_' . time();
            $this->pdf->generate($html, $filename, true, 'letter');
        } else {
            redirect('/Iuran', 'refresh');
        }
    }

    public function printMultiple()
    {
        $idPeriode = $this->input->post('period');
        $sc = $this->M_iuran->print_by_periode($idPeriode);

        if ($sc != null) {
            $signature = $this->M_parameter->select_by_id('authorized_signature_billing_key');

            $data['dataIuran'] = $sc;
            $data['signature'] = $signature;

            $html = $this->load->view('iuran/print', $data, true);
            $filename = 'report_' . time();
            $this->pdf->generate($html, $filename);
        } else {
            redirect('/Iuran', 'refresh');
        }
    }
}

/* End of file Iuran.php */
/* Location: ./application/controllers/Iuran.php */

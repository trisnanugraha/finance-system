<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asuransi extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_asuransi');
        $this->load->model('M_owner');
        $this->load->model('M_rates');
        $this->load->model('M_period');
        $this->load->model('M_parameter');
        $this->load->model('M_gl');
        $this->load->model('M_candidate_key');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['userdata'] = $this->userdata;
        $data['dataAsuransi'] = $this->m_asuransi->select_all();
        $data['dataOwner'] = $this->M_owner->select_all();
        $data['dataRates'] = $this->M_rates->current_rate();

        $data['page'] = "Asuransi";
        $data['judul'] = "Asuransi Bills";
        $data['deskripsi'] = "Manage Asuransi Bills";
        $data['dataPeriod'] = $this->m_asuransi->select_period_not_bill();

        $data['modal_tambah_asuransi'] = show_my_modal('modals/modal_tambah_asuranasi', 'tambah-asuransi', $data);

        $js = $this->load->view('asuransi/asuransi-js', null, true);
        $this->template->views('asuransi/home', $data, $js);
    }

    public function tampil()
    {
        $owner = $this->input->get("owner");
        $startDate = $this->input->get("startDate");
        $endDate = $this->input->get("endDate");
        $data['dataAsuransi'] = $this->m_asuransi->select_filter($owner, $startDate, $endDate);
        $this->load->view('asuransi/list_data', $data);
    }

    public function prosesTambah()
    {
        $this->form_validation->set_rules('period', 'Period', 'trim|required');
        $this->form_validation->set_rules('total', 'Total', 'trim|required');

        $post = $this->input->post();
        $row = 0;
        if ($this->form_validation->run() == TRUE) {
            $available = $this->m_asuransi->select_inv_not_bill($post['period']);
            foreach ($available as $a) {
                $periode = $this->m_asuransi->select_period($post['period']);
                $owner = $this->M_owner->select_by_id($a->kode_owner);

                $dt = DateTime::createFromFormat("Y-m-d", $periode->periodEnd);
                $dtNextMonth = $dt->modify('first day of next month');
                $year = $dtNextMonth->format('y');
                $month = $dtNextMonth->format('m');
                
                $currentNumber = $this->m_asuransi->get_last_id($dtNextMonth);
    
                $formatBillingId = $this->M_candidate_key->select_by_id('asuransi_key');
    
                $id = str_replace('@year', $year, $formatBillingId->key);
                $id = str_replace('@month', $month, $id);
                $id = str_replace('@counter', str_pad($currentNumber->maxNumber, $formatBillingId->counter_count, '0', STR_PAD_LEFT), $id);
            
                $total = ($owner->sqm / 16329) * $post['total'];
                // $id = 'test';
                $data = [
                    'id_asuransi' => $id,
                    'kode_owner' => $a->kode_owner,
                    'id_periode' => $post['period'],
                    'total_asuransi' => $total,
                    'created_by' => $this->userdata->id,
                    'd_c_note_date' => $dtNextMonth->format('Y/m/d')
                ];
                
                $dataGL = [
                    'bukti_transaksi' => $id,
                    'id_customer' => $owner->customer,
                    'id_owner' => $a->kode_owner,
                    'tanggal_transaksi' => $periode->first_day,
                    'keterangan' => '' . date('d/m/Y', strtotime($periode->first_day)) . '-' . date('d/m/Y', strtotime($periode->last_day)) . ' ' . $owner->id . ' ' . $owner->nama,
                    'kode_soa' => 25,
                    'debit' => $total,
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
                    'kode_soa' => 220,
                    'debit' => 0,
                    'credit' => $total,
                    'so' => 1,
                    'cash' => 0
                ];
                $this->M_gl->insert2($dataGL);
                $this->M_gl->insert2($data2);
                $result = $this->m_asuransi->insert($data);
                $row += $result;
            }

            if ($row > 0) {               
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Asuransi Bill Data Successfully Added', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Asuransi Bill Data Failed To Add', '20px');
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
       
        $result = $this->m_asuransi->delete($id);
        if ($result > 0) {
            helper_log("delete", "Menghapus Data (Asuransi)", $id);
            echo show_succ_msg('Asuransi Bill Deleted Successfully', '20px');
        } else {
            echo show_err_msg('Asuransi Bill Failed To Delete', '20px');
        }
    }

    public function delete_all()
    {
        $post = $this->input->post(null, TRUE);
        $id = json_decode($_POST["checkbox_value"]);

        for ($count = 0; $count < count($id); $count++) {
            $result = $this->m_asuransi->delete_all($id[$count]);
        }
        if ($result > 0) {
            echo show_succ_msg('Asuransi Bill List Deleted Successfully', '20px');
        } else if ($result < 0) {
            echo show_err_msg('Asuransi Bill List Failed To Delete', '20px');
        } else {
        }
    }

    public function countAvailablePeriod()
    {
        $id_period = $this->input->get('period');

        $availablebill = $this->m_asuransi->select_inv_not_bill($id_period);

        $response = [
            'count' => count($availablebill)
        ];

        echo json_encode($response);
    }

    public function period()
    {
        $dataPeriod = $this->m_asuransi->select_periode_asuransi();

        $response = [
            'errorCode' => 0,
            'data' => $dataPeriod
        ];


        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

/* End of file Asuransi.php */
/* Location: ./application/controllers/Asuransi.php */

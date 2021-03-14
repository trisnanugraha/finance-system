<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pinalty extends CI_Model{

    private $tableName = 'pinalty';

    public function select_all(){
        $query = $this->db->select([
            'py.id_pinalty',
            'py.id_periode',
            'p.start_periode',
            'p.end_periode',
            'p.amount_days',
            'p.due_date',
            'py.kode_customer',
            'c.unit_customer',
            'c.nama_customer',
            'c.alamat_customer',
            'c.kode_virtual',
            'py.total'
        ])->from("{$this->tableName} py")
            ->join("customer c", "py.kode_customer = c.kode_customer")
            ->join("periode p", "py.id_periode = p.id_periode")
            ->order_by('py.id_pinalty', 'ASC')
			->get();

        return $query->result();
    }

    public function select_by_id($id) {
	
		$query = $this->db->select([
            'py.id_pinalty',
            'py.id_periode',
            'p.start_periode',
            'p.end_periode',
            'p.amount_days',
            'p.due_date',
            'py.kode_customer',
            'c.unit_customer',
            'c.nama_customer',
            'c.alamat_customer',
            'c.kode_virtual',
            'py.total'
        ])->from("{$this->tableName} py")
            ->join("customer c", "py.kode_customer = c.kode_customer")
            ->join("periode p", "py.id_periode = p.id_periode")
		    ->where('py.id_pinalty', $id)
	    	->get();

		return $query->row();
    }

    public function select_by_customer_and_period($customer, $period)
	{
        $query = 
            "SELECT 
                py.id_pinalty,
                py.id_periode,
                p.start_periode,
                p.end_periode,
                p.amount_days,
                p.due_date,
                py.kode_customer,
                c.unit_customer,
                c.nama_customer,
                c.alamat_customer,
                c.kode_virtual,
                py.total
            FROM pinalty py
                JOIN periode p
                ON p.id_periode = py.id_periode
                JOIN customer c
                ON c.kode_customer = py.kode_customer
            WHERE py.kode_customer = '{$customer}' AND MONTH(start_periode) = MONTH('{$period}')";

            $data = $this->db->query($query);

            return $data->row();
    }
}

?>
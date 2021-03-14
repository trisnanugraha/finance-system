<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_coa extends CI_Model
{
	private $tableName = 'coa';

	public function select_all_coa()
	{
		$sql = "SELECT * FROM coa ORDER BY coa.coa_id";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all_coa_ar()
	{
		$sql = "SELECT * FROM coa WHERE (coa.id_akun = 21 OR coa.id_akun = 22) ORDER BY coa.coa_id";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all()
	{

		$query = $this->db->select([
			'co.id_akun',
			'co.parent',
			'co.coa_id',
			'co.coa_name',
			'co.acc_type',
			'co.jurnal_tipe',
			'ct.type_name',
			'co.parent_name'
		])->from("{$this->tableName} co")
			->join('coa_type ct', 'ct.coa_type_id = co.jurnal_tipe')
			->order_by('co.coa_id', 'ASC')
			->get();

		return $query->result();
	}

	public function select_by_id($id)
	{

		$query = $this->db->select([
			'co.id_akun',
			'co.parent',
			'co.coa_id',
			'co.coa_name',
			'co.acc_type',
			'co.jurnal_tipe',
			'co.parent_name',
			'ct.type_name'
		])->from("{$this->tableName} co")
			->join('coa_type ct', 'ct.coa_type_id = co.jurnal_tipe')
			->where('co.id_akun', $id)
			->order_by('co.coa_id', 'ASC')
			->get();

		return $query->row();
	}

	public function select_by_coa($id)
	{

		$query = $this->db->select([
			'co.id_akun',
			'co.parent',
			'co.coa_id',
			'co.coa_name',
			'co.acc_type',
			'co.jurnal_tipe',
			'co.parent_name',
			'ct.type_name'
		])->from("{$this->tableName} co")
			->join('coa_type ct', 'ct.coa_type_id = co.jurnal_tipe')
			->where('co.coa_id', $id)
			->order_by('co.coa_id', 'ASC')
			->get();

		return $query->row();
	}

	public function print()
	{

		$query = $this->db->select([
			'co.id_akun',
			'co.parent',
			'co.coa_id',
			'co.coa_name',
			'co.acc_type',
			'co.jurnal_tipe',
			'co.parent_name',
			'ct.type_name'
		])->from("{$this->tableName} co")
			->join('coa_type ct', 'ct.coa_type_id = co.jurnal_tipe')
			->group_by('co.coa_id')
			->order_by('co.coa_id', 'ASC')
			->get();

		return $query->result();
	}

	public function insert($params)
	{

		$this->db->insert($this->tableName, $params);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$where = ['id_akun' => $id];
		$this->db->delete($this->tableName, $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function select_bank()
	{
		$query =
			"SELECT 
					coa.id_akun,
					coa.parent,
					coa.coa_id,
					coa.parent_name,
					coa.coa_name
				FROM coa
				WHERE coa.id_akun = 8
					OR coa.id_akun = 9
					OR coa.id_akun = 10 
					OR coa.id_akun = 11
					OR coa.id_akun = 12
					OR coa.id_akun = 13
					OR coa.id_akun = 2
					OR coa.id_akun = 190
				ORDER BY coa.coa_id";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_kas()
	{
		$query =
			"SELECT 
					coa.id_akun,
					coa.parent,
					coa.coa_id,
					coa.parent_name,
					coa.coa_name
				FROM coa
				WHERE coa.id_akun = 2
				ORDER BY coa.coa_id";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_between_coa($coaA, $coaB)
	{
		$query =
			"SELECT 
					coa.id_akun,
					coa.parent,
					coa.coa_id,
					coa.parent_name,
					coa.coa_name
				FROM coa
				WHERE coa.id_akun BETWEEN '{$coaA}' AND '{$coaB}'
				ORDER BY coa.coa_id";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_by_parent($parent)
	{

		$query =
			"SELECT 
				coa.id_akun, 
				coa.parent, 
				coa.coa_id, 
				coa.coa_name,
				coa.parent_name,
				coa.jurnal_tipe
			FROM coa 
			WHERE coa.id_akun = '{$parent}'
			ORDER BY coa.coa_id";

		$data = $this->db->query($query);

		return $data->result();
	}
}

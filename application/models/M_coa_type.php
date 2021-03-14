<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_coa_type extends CI_Model {
	private $tableName = 'coa_type';
	public function select_all_type() {
		$sql = "SELECT * FROM coa_type";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all() {
		$sql = "SELECT coa_type_id AS id, type_name AS name FROM coa_type";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_by_id($id) {
	
		$query = $this->db->select('coa_type_id AS id, type_name AS name')
		->where('coa_type_id', $id)
		->get($this->tableName);

		return $query->row();
    }
}

/* End of file M_coa_type.php */
/* Location: ./application/models/M_coa_type.php */
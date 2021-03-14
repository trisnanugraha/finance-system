<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_giro_type extends CI_Model {
	
	private $tableName = 'giro_type';
	
	public function select_all_type() {
		$sql = "SELECT * FROM giro_type";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all() {
		$sql = "SELECT giro_type_id, type_giro_name FROM giro_type";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_by_id($id) {
	
		$query = $this->db->select('giro_type_id, type_giro_name')
		->where('giro_type_id', $id)
		->get($this->tableName);

		return $query->row();
    }
}
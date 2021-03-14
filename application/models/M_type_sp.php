<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_type_sp extends CI_Model {
	
	private $tableName = 'type_storage_parking';
	
	public function select_all_type() {
		$sql = "SELECT * FROM type_storage_parking";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all() {
		$sql = "SELECT id_type_sp, nama_type FROM type_storage_parking";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_by_id($id) {
	
		$query = $this->db->select('id_type_sp, nama_type')
		->where('type_storage_parking', $id)
		->get($this->tableName);

		return $query->row();
    }
}

/* End of file M_type_sp.php */
/* Location: ./application/models/M_type_sp.php */
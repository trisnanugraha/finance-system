<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_type_pembayaran extends CI_Model {
	
	private $tableName = 'type_pembayaran';
	
	public function select_all_type() {
		$sql = "SELECT * FROM type_pembayaran";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all() {
		$sql = "SELECT type_pembayaran_id, type_pembayaran_name FROM type_pembayaran";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_by_id($id) {
	
		$query = $this->db->select('type_pembayaran_id, type_pembayaran_name')
		->where('type_pembayaran_id', $id)
		->get($this->tableName);

		return $query->row();
    }
}

/* End of file M_type_pembayaran.php */
/* Location: ./application/models/M_type_pembayaran.php */
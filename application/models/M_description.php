<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_description extends CI_Model {
	private $tableName = "deskripsi";
	public function select_all_deskripsi() {
		$sql = "SELECT * FROM deskripsi";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all() {
		$sql = "SELECT deskripsi.id_deskripsi AS id, deskripsi.jenis_deskripsi AS jenis, deskripsi.tipe_deskripsi AS tipe, deskripsi.sqm AS sqm, deskripsi.kapasitas AS kapasitas FROM deskripsi";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT deskripsi.id_deskripsi AS id, deskripsi.jenis_deskripsi AS jenis, deskripsi.tipe_deskripsi AS tipe, deskripsi.sqm AS sqm, deskripsi.kapasitas AS kapasitas FROM deskripsi WHERE deskripsi.id_deskripsi = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}
    
    public function update($params) {
		$data = array(
			'jenis_deskripsi' => $params['jenis'],
			'tipe_deskripsi' => $params['tipe'],
			'sqm' => $params['sqm'],
			'kapasitas' => $params['kapasitas']
		);

		$where = ['id_deskripsi' => $params['id']];
		$this->db->update($this->tableName, $data, $where);

		return $this->db->affected_rows();
	}

	public function total_rows() {
		$data = $this->db->get('deskripsi');

		return $data->num_rows();
	}
}

/* End of file M_description.php */
/* Location: ./application/models/M_description.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bank extends CI_Model {
	private $tableName = 'bank';
	public function select_all_bank() {
		$sql = "SELECT * FROM bank";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all() {
		$sql = "SELECT bank.kode_bank AS id, bank.no_rek AS rekening, bank.nama_bank AS nama FROM bank";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_by_id($id) {
	
		$query = $this->db->select('kode_bank AS id, no_rek AS rekening, nama_bank AS nama')
		->where('kode_bank', $id)
		->get($this->tableName);

		return $query->row();
    }

    public function insert($params) {
		
		$data = [
			'kode_bank' => $params['id'],
			'no_rek' => $params['rekening'],
			'nama_bank' => $params['nama']
		];
		$this->db->insert($this->tableName, $data);

		return $this->db->affected_rows();
	}
    
    public function update($params) {
		
		// $sql = "UPDATE bank SET no_rek='" .$data['rekening'] ."', nama_bank='" .$data['nama'] ."' WHERE kode_bank='" .$data['id'] ."'";

		// $this->db->query($sql);

		$data = array(
			'no_rek' => $params['rekening'],
			'nama_bank' => $params['nama']
		);

		$where = array('kode_bank' => $params['id']);

		// $this->db->query($sql);
		$this->db->update($this->tableName, $data, $where);

		return $this->db->affected_rows();
	}

	// public function select_by_air($id) {
	// 	$sql = "SELECT air.id_air AS id, air.start_meter AS meterStart, air.end_meter AS meterEnd, tenant.nama_tenant AS nama FROM air,tenant WHERE air.id_tenant = tenant.id_tenant AND air.id_air = '{$id}'";

	// 	$data = $this->db->query($sql);

	// 	return $data->row();
    // }
    
    public function delete($id) {
		$this->db->delete($this->tableName, ['kode_bank' => $id]);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function total_rows() {
		$data = $this->db->get('bank');

		return $data->num_rows();
	}
}

/* End of file M_bank.php */
/* Location: ./application/models/M_bank.php */
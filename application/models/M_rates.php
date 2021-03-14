<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rates extends CI_Model {

	private $tableName = 'tarif';

	public function select_all_rate() {
		// $sql = "SELECT * FROM tarif";

		$data = $this->db->get($this->tableName);

		return $data->result();
	}

	public function select_all() {

		$query = $this->db->select([
			'id_tarif AS id', 
			'standing_charge AS charge', 
			'tarif_air AS water', 
			'tarif_listrik AS electric',
			'tarif_sinking_fund AS sinking',
			'tarif_service_charge AS service',
			'created_at'
		])
			->order_by('id', 'desc')
			->get($this->tableName);
		return $query->result();
	}

	public function current_rate()
	{

		$query = $this->db->select([
			'id_tarif AS id',
			'standing_charge AS charge',
			'tarif_air AS water',
			'tarif_listrik AS electric',
			'tarif_sinking_fund AS sinking',
			'tarif_service_charge AS service',
			'created_at'
		])
			->order_by('id', 'desc')
			->limit(1)
			->get($this->tableName);
		return $query->row();
	}


	public function select_by_id($id) {
		
		$query = $this->db->select([
			'id_tarif AS id',
			'standing_charge AS charge',
			'tarif_air AS water',
			'tarif_listrik AS electric',
			'tarif_sinking_fund AS sinking',
			'tarif_service_charge AS service',
			'created_at'
		])->where('id_tarif', $id)
			->order_by('id', 'desc')
			->limit(1)
			->get($this->tableName);

		return $query->row();
	}

	public function update($params) {
		$data = [
			'standing_charge' => $params['charge'],
			'tarif_air' => $params['water'],
			'tarif_listrik' => $params['electric'],
			'tarif_sinking_fund' => $params['sinking'],
			'tarif_service_charge' => $params['service']
		];
		$where = ['id_tarif' => $params['id']];
		$this->db->update($this->tableName, $data, $where);

		return $this->db->affected_rows();
	}


	public function delete($id)
	{
		$where = ['id_tarif' => $id];
		$this->db->delete($this->tableName, $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function insert($params){
	
		$data = [
			'standing_charge' => $params['charge'],
			'tarif_air' => $params['water'],
			'tarif_listrik' => $params['electric'],
			'tarif_sinking_fund' => $params['sinking'],
			'tarif_service_charge' => $params['service']
		];
		$this->db->insert($this->tableName, $data);
		return $this->db->affected_rows();
	}

	public function total_rows() {
		$data = $this->db->get('tarif');

		return $data->num_rows();
	}

	public function already_in_used($id){
		$in_electric = $this->db->where(['id_tarif' => $id])
						->count_all_results('listrik');
		$in_water = $this->db->where(['id_tarif' => $id])
						->count_all_results('air');

		return ($in_electric > 0 || $in_water > 0);
	}
}

/* End of file M_rates.php */
/* Location: ./application/models/M_rates.php */
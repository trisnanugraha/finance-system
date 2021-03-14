<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_owner extends CI_Model {
	private $tableName = 'owner';

	public function select_all_owner() {
		
		$sql = "SELECT * FROM owner ORDER BY owner.nama_owner";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all() {

		$query = $this->db->select([
				'o.kode_owner AS id',
				'o.kode_virtual AS kodeVir',
				'o.nama_owner AS nama',
				'o.unit_owner AS unit',
				'o.alamat_owner AS alamat',
				'o.id_deskripsi',
				'd.tipe_deskripsi AS tipe',
				'd.kapasitas AS kapasitas',
				'd.sqm AS sqm',
				'o.customer'
			])->from("{$this->tableName} o")
				->join('deskripsi d', 'o.id_deskripsi = d.id_deskripsi')
				->order_by('o.kode_owner', 'ASC')
				->get();

		return $query->result();
	}

	public function select_by_id($id) {
		$query = $this->db->select([
			'o.kode_owner AS id',
			'o.kode_virtual AS kodeVir',
			'o.nama_owner AS nama',
			'o.unit_owner AS unit',
			'o.alamat_owner AS alamat',
			'o.id_deskripsi',
			'd.tipe_deskripsi AS tipe',
			'd.kapasitas AS kapasitas',
			'd.sqm AS sqm',
			'o.customer'
		])->from("{$this->tableName} o")
			->join('deskripsi d', 'o.id_deskripsi = d.id_deskripsi')
			->where('o.kode_owner', $id)
			->order_by('o.kode_owner', 'ASC')
			->get();
		
		return $query->row();
	}

	public function select_by_desc($id) {
		$sql = "SELECT deskripsi.jenis_deskripsi AS jenis, deskripsi.tipe_deskripsi AS tipe, deskripsi.kapasitas AS kapasitas FROM deskripsi WHERE deskripsi.id_deskripsi = owner.id_deskripsi AND owner.id_deskripsi = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_detail($id) {
		$sql = "SELECT owner.kode_owner AS id, owner.customer, owner.kode_virtual AS kodeVir, owner.nama_owner AS nama, owner.unit_owner AS unit, owner.alamat_owner AS alamat, deskripsi.jenis_deskripsi AS jenis, deskripsi.tipe_deskripsi AS tipe, deskripsi.kapasitas AS kapasitas FROM owner, deskripsi WHERE owner.id_deskripsi = deskripsi.id_deskripsi AND owner.kode_owner='{$id}'";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function check_owner($kode)
	{
		$this->db->where('kode_owner', $kode);
		$data = $this->db->get('owner');

		return $data->num_rows();
	}


	public function update($params) {
		$data = array(
			'kode_virtual' => $params['kodeVir'],
			'nama_owner' => $params['nama'],
			'unit_owner' => $params['unit'],
			'alamat_owner' => $params['alamat'],
			'id_deskripsi' => $params['jenis']
		);

		$where = array('kode_owner' => $params['id']);
		$this->db->update($this->tableName, $data, $where);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$this->db->delete($this->tableName, ['kode_owner' => $id]);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function insert($params) {
		$data = [
			'kode_owner' => $params['id'],
			'kode_virtual' => $params['kodeVir'],
			'nama_owner' => $params['nama'],
			'unit_owner' => $params['unit'],
			'alamat_owner' => $params['alamat'],
			'id_deskripsi' => $params['jenis'],
			'customer' => 'T-'.$params['id']
		];
		$this->db->insert($this->tableName, $data);
		
		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		
		$this->db->insert_batch($this->tableName, $data);
		
		return $this->db->affected_rows();
	}

	public function check_id($nama) {
		
		$this->db->where('kode_owner', $nama);
		$data = $this->db->get('owner');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get($this->tableName);

		return $data->num_rows();
	}
}

/* End of file M_owner.php */
/* Location: ./application/models/M_owner.php */
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_keluhan extends CI_Model
{
	private $tableName = 'keluhan';

	public function select_all()
	{
		$sql =
			"SELECT
				keluhan.kode_keluhan,
				keluhan.id_admin,
				admin.username,
				admin.nama,
				keluhan.tanggal_keluhan,
				keluhan.uraian,
				keluhan.penyebab,
				keluhan.tindakan,
				keluhan.tanggal_selesai,
				keluhan.status,
				keluhan.pending,
				keluhan.d_c_note_date,
				keluhan.created_at,
				keluhan.update_at
			FROM keluhan
				JOIN admin
				ON admin.id = keluhan.id_admin
			ORDER BY keluhan.kode_keluhan ASC";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function print($dateA, $dateB)
	{
		$sql =
			"SELECT
				keluhan.kode_keluhan,
				keluhan.id_admin,
				admin.username,
				admin.nama,
				keluhan.tanggal_keluhan,
				keluhan.uraian,
				keluhan.penyebab,
				keluhan.tindakan,
				keluhan.tanggal_selesai,
				keluhan.status,
				keluhan.pending,
				keluhan.d_c_note_date,
				keluhan.created_at,
				keluhan.update_at
			FROM keluhan
				JOIN admin
				ON admin.id = keluhan.id_admin
			WHERE keluhan.tanggal_keluhan BETWEEN CAST('{$dateA}' AS DATE) AND CAST('{$dateB}' AS DATE)
			ORDER BY keluhan.kode_keluhan ASC";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_detail($id)
	{
		$query = $this->db->select([
			'k.kode_keluhan',
			'k.id_admin',
			'a.username',
			'a.nama',
			'k.tanggal_keluhan',
			'k.uraian',
			'k.penyebab',
			'k.tindakan',
			'k.tanggal_selesai',
			'k.status',
			'k.pending',
			'k.d_c_note_date',
			'k.created_at',
			'k.update_at'
		])->from('keluhan k')
			->join('admin a', 'a.id = k.id_admin')
			->order_by('k.kode_keluhan', 'ASC')
			->where('k.kode_keluhan', $id)
			->get();

		return $query->row();
	}

	public function select_update($id)
	{
		$query = $this->db->select([
			'k.kode_keluhan',
			'k.id_admin',
			'a.username',
			'a.nama',
			'k.tanggal_keluhan',
			'k.uraian',
			'k.penyebab',
			'k.tindakan',
			'k.tanggal_selesai',
			'k.status',
			'k.pending',
			'k.d_c_note_date',
			'k.created_at',
			'k.update_at'
		])->from('keluhan k')
			->join('admin a', 'a.id = k.id_admin')
			->order_by('k.kode_keluhan', 'ASC')
			->where('k.kode_keluhan', $id)
			->get();

		return $query->row();
	}

	public function insert($params)
	{
		$this->db->insert($this->tableName, $params);

		return $this->db->affected_rows();
	}

	public function update($params)
	{
		$data = array(
			'penyebab' => $params['penyebab'],
			'tindakan' => $params['tindakan'],
			'tanggal_selesai' => $params['tanggal_selesai'],
			'status' => $params['status'],
			'pending' => $params['pending']
		);

		$where = array('kode_keluhan' => $params['id']);

		$this->db->update($this->tableName, $data, $where);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$where = ['kode_keluhan' => $id];
		$this->db->delete($this->tableName, $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function get_last_id($dt)
	{
		$currentNumber = $this->db->query('SELECT get_increment_keluhan_id(?, ?) as maxNumber', [$dt->format('Y'), $dt->format('m')]);

		return $currentNumber->row();
	}
}

/* End of file M_bank.php */
/* Location: ./application/models/M_bank.php */
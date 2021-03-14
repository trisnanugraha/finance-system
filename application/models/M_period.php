<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_period extends CI_Model
{
	private $tableName = 'periode';
	public function select_all_periode()
	{
		$sql = "SELECT * FROM periode";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all()
	{
		$query  = $this->db->select([
			'id_periode AS id',
			'start_periode AS periodStart',
			'end_periode AS periodEnd',
			'due_date AS dueDate',
			'amount_days AS amount'
		])
			->from($this->tableName)
			->order_by('start_periode', 'DESC')
			->get();
		return $query->result();
	}

	public function select_periode()
	{
		$sql =
			"SELECT 
				periode.id_periode AS id,
				periode.start_periode AS periodStart,
				DAY(periode.start_periode) AS mulai,
				DAY(periode.end_periode) AS akhir,
				periode.end_periode AS periodEnd,
				periode.due_date AS dueDate,
				periode.amount_days AS amount
			FROM periode 
			ORDER BY start_periode DESC";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_periode_by_id($id_periode)
	{
		$sql =
			"SELECT 
				periode.id_periode AS id,
				periode.start_periode AS periodStart,
				DAY(periode.start_periode) AS mulai,
				DAY(periode.end_periode) AS akhir,
				periode.end_periode AS periodEnd,
				periode.due_date AS dueDate,
				periode.amount_days AS amount
			FROM periode 
			WHERE periode.id_periode = '{$id_periode}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function export()
	{
		$query  = $this->db->select([
			'id_periode AS id',
			'start_periode AS periodStart',
			'end_periode AS periodEnd',
			'due_date AS dueDate',
			'amount_days AS amount',
			'created_at'
		])
			->from($this->tableName)
			->order_by('id', 'ASC')
			->get();
		return $query->result();
	}

	public function get_end_periode($id_periode)
	{
		$sql =
			"SELECT 
				periode.id_periode,
				periode.start_periode,
				DATE_ADD(DATE_ADD(LAST_DAY(periode.start_periode), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS periode_satu,
				DATE_ADD(DATE_ADD(LAST_DAY(periode.start_periode + INTERVAL 1 MONTH), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS periode_dua,
				periode.start_periode - INTERVAL 1 MONTH AS periode_min_satu,
				DATE_ADD(DATE_ADD(LAST_DAY(periode.start_periode + INTERVAL 2 MONTH), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS periode_tiga,
				LAST_DAY(periode.start_periode + INTERVAL 2 MONTH) AS end_periode
			FROM periode 
			WHERE periode.id_periode = '{$id_periode}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_tanggal($tgl)
	{
		$sql =
			"SELECT 
				periode.id_periode,
				periode.start_periode,
				DATE_ADD(DATE_ADD(LAST_DAY(periode.start_periode), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS periode_satu,
				LAST_DAY(periode.start_periode) AS end_periode
			FROM periode 
			WHERE MONTH(periode.start_periode) = MONTH('{$tgl}') 
				AND YEAR(periode.start_periode) = YEAR('{$tgl}')";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_by_id($id)
	{
		$query  = 
			"SELECT 
				periode.id_periode AS id,
				periode.start_periode AS periodStart,
				periode.end_periode AS periodEnd,
				DATE_ADD(LAST_DAY(periode.end_periode), INTERVAL 1 DAY) AS tanggal_start,
				periode.due_date AS dueDate,
				periode.amount_days AS amount
			FROM periode
			WHERE periode.id_periode = '{$id}'";

		$data = $this->db->query($query);

		return $data->row();
	}

	public function select_service()
	{
		$sql = "SELECT 
					id_periode AS id,
					start_periode AS periodStart,
					DATE_ADD(DATE_ADD(LAST_DAY(periode.start_periode), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS start_periode,
					end_periode AS periodEnd,
					due_date AS dueDate,
					LAST_DAY(start_periode + INTERVAL 2 MONTH) AS end_periode,
					amount_days + 59 AS amount
				FROM periode
				WHERE 
				   (MONTH(start_periode) = 1 
				OR MONTH(start_periode) = 4 
				OR MONTH(start_periode) = 7 
				OR MONTH(start_periode) = 10)
				AND amount_days > 27";

		$data = $this->db->query($sql);

		return $data->result();
	}


	public function update($params)
	{
		$data = [
			'start_periode' => $params['periodStart'],
			'end_periode' => $params['periodEnd'],
			'due_date' => $params['periodDue'],
			'amount_days' => $params['amountDays']
		];

		$where = ['id_periode' => $params['id']];
		$this->db->update($this->tableName, $data, $where);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$where = ['id_periode' => $id];
		$this->db->delete($this->tableName, $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function insert($params)
	{

		$data = [
			'start_periode' => $params['periodStart'],
			'end_periode' => $params['periodEnd'],
			'due_date' => $params['periodDue'],
			'amount_days' => $params['amountDays']
		];

		$this->db->insert($this->tableName, $data);

		return $this->db->affected_rows();
	}

	public function insert_batch($data)
	{
		$this->db->insert_batch($this->tableName, $data);
		return $this->db->affected_rows();
	}

	public function total_rows()
	{
		$data = $this->db->get('periode');

		return $data->num_rows();
	}

	public function already_in_used($id)
	{
		$in_electric = $this->db->where(['id_periode' => $id])
			->count_all_results('listrik');
		$in_water = $this->db->where(['id_periode' => $id])
			->count_all_results('air');

		return ($in_electric > 0 || $in_water > 0);
	}
}

/* End of file M_period.php */
/* Location: ./application/models/M_period.php */

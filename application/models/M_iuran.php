<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_iuran extends CI_Model
{
	private $tableName = 'iuran';

    public function select_all()
    {

        $sql =
                "SELECT
                    i.id_iuran,
                    i.kode_owner,
                    o.nama_owner,
                    o.kode_owner,
                    i.id_periode,
                    DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS start_periode,
                    LAST_DAY(p.start_periode + INTERVAL 1 MONTH) AS end_periode,
                    i.total_iuran
                FROM iuran i
                    JOIN owner o ON o.kode_owner = i.kode_owner
                    JOIN periode p ON p.id_periode = i.id_periode
				ORDER BY p.start_periode DESC, i.id_iuran";

            $query = $this->db->query($sql);
            return $query->result();
    }

    public function select_filter($owner, $startDate, $endDate)
    {

        if (!empty($startDate) && !empty($endDate) && empty($owner)) {

            $sql =
                "SELECT
                    i.id_iuran,
                    i.kode_owner,
                    o.nama_owner,
                    o.kode_owner,
                    i.id_periode,
                    DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS start_periode,
                    LAST_DAY(p.start_periode) AS end_periode,
                    i.total_iuran
                FROM iuran i
                    JOIN owner o ON o.kode_owner = i.kode_owner
                    JOIN periode p ON p.id_periode = i.id_periode
				WHERE p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, i.id_iuran";

            $query = $this->db->query($sql);
            return $query->result();
        } else if (!empty($owner) && !empty($startDate) && !empty($endDate)) {

            $sql =
                "SELECT
                    i.id_iuran,
                    i.kode_owner,
                    o.nama_owner,
                    o.kode_owner,
                    i.id_periode,
                    DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS start_periode,
                    LAST_DAY(p.start_periode) AS end_periode,
                    i.total_iuran
                FROM iuran i
                    JOIN owner o ON o.kode_owner = i.kode_owner
                    JOIN periode p ON p.id_periode = i.id_periode
				WHERE s.kode_owner = '{$owner}' AND p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, i.id_iuran";

            $query = $this->db->query($sql);
            return $query->result();
        } else {

            $sql =
                "SELECT
                    i.id_iuran,
                    i.kode_owner,
                    o.nama_owner,
                    o.kode_owner,
                    i.id_periode,
                    DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS start_periode,
                    LAST_DAY(p.start_periode) AS end_periode,
                    i.total_iuran
                FROM iuran i
                    JOIN owner o ON o.kode_owner = i.kode_owner
                    JOIN periode p ON p.id_periode = i.id_periode
				ORDER BY p.start_periode DESC, i.id_iuran";

            $query = $this->db->query($sql);
            return $query->result();
        }
    }

    public function get_last_id($dt)
    {
        $currentNumber = $this->db->query('SELECT get_increment_iuran_id(?, ?) as maxNumber', [$dt->format('Y'), $dt->format('m')]);

        return $currentNumber->row();
    }

    public function select_inv_not_bill($id_periode)
    {
        $query = $this->db->select('*')
            ->from('view_available_periode_iuran')
            ->where('id_periode', $id_periode)->get();

        return $query->result();
    }

    public function insert($params)
    {
        $this->db->insert($this->tableName, $params);

        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->delete($this->tableName, ['id_iuran' => $id]);

        if ($this->db->error()['code'] == 1451) {
            return false;
        } else {
            return true;
        }
    }

    public function delete_all($id)
    {
        $this->db->where_in('id_iuran', $id);
        $this->db->delete($this->tableName);

        if ($this->db->error()['code'] == 1451) {
            return false;
        } else {
            return true;
        }
    }

    public function select_period_not_bill()
    {
        $query  =
            "SELECT
				p.id_periode AS id,
				p.start_periode AS periodStart,
				DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS first_day,
				p.end_periode AS periodEnd,
				LAST_DAY(p.start_periode) AS last_day,
				p.due_date AS dueDate,
				p.amount_days + 59 AS amount
			FROM periode p
			WHERE p.id_periode IN 
				(SELECT 
						vp.id_periode 
					FROM view_available_periode_iuran vp 
					GROUP BY vp.id_periode) 
			ORDER BY p.start_periode ASC";

        $data = $this->db->query($query);

        return $data->result();
    }

    public function select_periode_iuran()
    {
        $query =
            "SELECT
				i.id_periode,
				DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS start_periode,
				i.end_periode
			FROM iuran i
				JOIN periode p
					ON(p.id_periode = i.id_periode)
			GROUP BY
				i.id_periode";

        $data = $this->db->query($query);

        return $data->result();
    }

    public function select_period($id)
	{
		$query  = 
			"SELECT 
				p.id_periode AS id,
				p.start_periode AS periodStart,
				DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS first_day,
				p.end_periode AS periodEnd,
				LAST_DAY(p.start_periode) AS last_day,
				p.due_date AS dueDate,
				p.amount_days AS amount
			FROM periode p
			WHERE p.id_periode = '{$id}'";

		$data = $this->db->query($query);

		return $data->row();
	}
}

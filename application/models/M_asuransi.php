<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_asuransi extends CI_Model
{
    private $tableName = 'asuransi';

    public function select_all()
    {

        $sql =
            "SELECT
                    i.id_asuransi,
                    i.kode_owner,
                    o.nama_owner,
                    o.kode_owner,
                    i.id_periode,
                    p.start_periode AS start_periode,
                    p.end_periode AS end_periode,
                    i.total_asuransi
                FROM asuransi i
                    JOIN owner o ON o.kode_owner = i.kode_owner
                    JOIN periode p ON p.id_periode = i.id_periode
				ORDER BY p.start_periode DESC, i.id_asuransi";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function select_filter($owner, $startDate, $endDate)
    {

        if (!empty($startDate) && !empty($endDate) && empty($owner)) {

            $sql =
                "SELECT
                    i.id_asuransi,
                    i.kode_owner,
                    o.nama_owner,
                    o.kode_owner,
                    i.id_periode,
                    p.start_periode AS start_periode,
                    p.end_periode AS end_periode,
                    i.total_asuransi
                FROM asuransi i
                    JOIN owner o ON o.kode_owner = i.kode_owner
                    JOIN periode p ON p.id_periode = i.id_periode
				WHERE p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, i.id_asuransi";

            $query = $this->db->query($sql);
            return $query->result();
        } else if (!empty($owner) && !empty($startDate) && !empty($endDate)) {

            $sql =
                "SELECT
                    i.id_asuransi,
                    i.kode_owner,
                    o.nama_owner,
                    o.kode_owner,
                    i.id_periode,
                    p.start_periode AS start_periode,
                    p.end_periode AS end_periode,
                    i.total_asuransi
                FROM asuransi i
                    JOIN owner o ON o.kode_owner = i.kode_owner
                    JOIN periode p ON p.id_periode = i.id_periode
				WHERE s.kode_owner = '{$owner}' AND p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, i.id_asuransi";

            $query = $this->db->query($sql);
            return $query->result();
        } else {

            $sql =
                "SELECT
                    i.id_asuransi,
                    i.kode_owner,
                    o.nama_owner,
                    o.kode_owner,
                    i.id_periode,
                    p.start_periode AS start_periode,
                    p.end_periode AS end_periode,
                    i.total_asuransi
                FROM asuransi i
                    JOIN owner o ON o.kode_owner = i.kode_owner
                    JOIN periode p ON p.id_periode = i.id_periode
				ORDER BY p.start_periode DESC, i.id_asuransi";

            $query = $this->db->query($sql);
            return $query->result();
        }
    }

    public function get_last_id($dt)
    {
        $currentNumber = $this->db->query('SELECT get_increment_asuransi_id(?, ?) as maxNumber', [$dt->format('Y'), $dt->format('m')]);

        return $currentNumber->row();
    }

    public function select_inv_not_bill($id_periode)
    {
        $query = $this->db->select('*')
            ->from('view_available_periode_asuransi')
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
        $this->db->delete($this->tableName, ['id_asuransi' => $id]);

        if ($this->db->error()['code'] == 1451) {
            return false;
        } else {
            return true;
        }
    }

    public function delete_all($id)
    {
        $this->db->where_in('id_asuransi', $id);
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
				p.start_periode AS first_day,
				p.end_periode AS periodEnd,
				p.end_periode AS last_day,
				p.due_date AS dueDate,
				p.amount_days + 59 AS amount
			FROM periode p
			WHERE p.id_periode IN 
				(SELECT 
						vp.id_periode 
					FROM view_available_periode_asuransi vp 
					GROUP BY vp.id_periode) 
			ORDER BY p.start_periode ASC";

        $data = $this->db->query($query);

        return $data->result();
    }

    public function select_periode_asuransi()
    {
        $query =
            "SELECT
				i.id_periode,
				p.start_periode AS start_periode,
				p.end_periode
			FROM asuransi i
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
				p.start_periode AS first_day,
				p.end_periode AS periodEnd,
				p.end_periode AS last_day,
				p.due_date AS dueDate,
				p.amount_days AS amount
			FROM periode p
			WHERE p.id_periode = '{$id}'";

        $data = $this->db->query($query);

        return $data->row();
    }

    public function print($id)
    {
        $sql =
            "SELECT
				s.id_asuransi,
				s.kode_owner,
				o.nama_owner,
				o.unit_owner,
				o.kode_virtual,
				o.alamat_owner,
				o.id_deskripsi,
				d.jenis_deskripsi,
				d.sqm,
				s.id_periode,
				p.start_periode,
				p.start_periode AS periodStart,
				p.due_date AS dueDate,
				p.end_periode,
				p.end_periode AS periodEnd,
                s.stamp,
                s.total_asuransi,
				s.created_at,
				s.updated_at
			FROM asuransi s
				JOIN owner o
					ON(o.kode_owner = s.kode_owner)
				JOIN periode p
					ON(p.id_periode = s.id_periode)
				JOIN deskripsi d
					ON(d.id_deskripsi = o.id_deskripsi)
			WHERE s.id_iuran = '{$id}'";

        $data = $this->db->query($sql);

        return $data->row();
    }

    public function print_by_periode($id_periode)
    {
        $query =
            "SELECT
                s.id_asuransi,
                s.kode_owner,
                o.nama_owner,
                o.unit_owner,
                o.kode_virtual,
                o.alamat_owner,
                o.id_deskripsi,
                d.jenis_deskripsi,
                d.sqm,
                s.id_periode,
                p.start_periode,
                p.start_periode AS periodStart,
                p.due_date AS dueDate,
                p.end_periode,
                p.end_periode AS periodEnd,
                s.stamp,
                s.total_asuransi,
                s.created_at,
                s.updated_at
            FROM asuransi s
                JOIN owner o
                    ON(o.kode_owner = s.kode_owner)
                JOIN periode p
                    ON(p.id_periode = s.id_periode)
                JOIN deskripsi d
                    ON(d.id_deskripsi = o.id_deskripsi)
			WHERE s.id_periode = '{$id_periode}'";

        $data = $this->db->query($query);

        return $data->result();
    }
}

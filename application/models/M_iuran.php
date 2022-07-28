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

    public function select_by_id($id)
    {

        $query =
            "SELECT
				b.id_billing,
				b.id_customer,
				c.nama_customer,
				c.kode_virtual,
				c.unit_customer,
				c.alamat_customer,
				d.jenis_deskripsi,
				d.kapasitas,
				b.id_periode,
				p.start_periode,
				day(p.start_periode) as mulai,
				day(p.end_periode) as akhir,
				p.end_periode,
				p.due_date,
				p.amount_days,
				b.kode_tagihan_listrik,
				l.prorate as prorate_listrik,
				l.total as total_listrik,
				l.start_meter as start_meter_listrik,
				l.end_meter as end_meter_listrik,
				l.cons as cons_listrik,
				l.consumption as consumption_listrik,
				l.ppju,
				t_l.tarif_listrik,
				b.kode_tagihan_air,
				a.prorate as prorate_air,
				a.total as total_air,
				a.start_meter as start_meter_air,
				a.end_meter as end_meter_air,
				a.cons as cons_air,
				a.consumption as consumption_air,
				a.tax_area,
				a.tax,
				t_a.tarif_air,
				t_a.standing_charge,
				b.total_pinalty,
				b.paid,
				b.admin,
				ad.username as username_admin,
				b.stamp,
				b.d_c_note_date,
				b.created_at,
				(SELECT (SUM(ar.total) - SUM(ar.sisa)) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, billing JOIN periode ON billing.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = '{$id}' AND ar.status != 1)) as last,
               	(SELECT SUM(ar.total) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, billing JOIN periode ON billing.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = '{$id}' AND ar.status != 1)) as total,
                (SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, billing JOIN periode ON billing.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = '{$id}' AND ar.status != 1)) as previous
			FROM billing b
				JOIN customer c 
				ON b.id_customer = c.kode_customer 
				JOIN periode p
				ON b.id_periode = p.id_periode 
				JOIN listrik l
				ON b.kode_tagihan_listrik = l.id_listrik 
				JOIN air a
				ON b.kode_tagihan_air = a.kode_tagihan_air 
				JOIN admin ad 
				ON b.admin = ad.id
				JOIN deskripsi d 
				ON c.id_deskripsi = d.id_deskripsi
				JOIN tarif t_a
				ON a.id_tarif = t_a.id_tarif
				JOIN tarif t_l
				ON l.id_tarif = t_l.id_tarif
			WHERE b.id_billing = '{$id}'";

        $data = $this->db->query($query);

        return $data->row();
    }

    public function print($id)
    {
        $sql =
            "SELECT
				s.id_iuran,
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
				DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS periodStart,
				LAST_DAY(p.start_periode) AS dueDate,
				p.end_periode,
				LAST_DAY(p.start_periode) AS periodEnd,
                s.total_iuran,
				s.created_at,
				s.updated_at,
				(SELECT (SUM(ar.total) - SUM(ar.sisa)) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, iuran JOIN periode ON iuran.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = iuran.kode_owner AND ar.kode_soa = '22' AND iuran.id_iuran = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = iuran.kode_owner AND ar.kode_soa = '22' AND iuran.id_iuran = '{$id}' AND ar.status != 1)) as last,
               	(SELECT SUM(ar.total) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, iuran JOIN periode ON iuran.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = iuran.kode_owner AND ar.kode_soa = '22' AND iuran.id_iuran = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = iuran.kode_owner AND ar.kode_soa = '22' AND iuran.id_iuran = '{$id}' AND ar.status != 1)) as totalp,
                (SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, iuran JOIN periode ON iuran.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = iuran.kode_owner AND ar.kode_soa = '22' AND iuran.id_iuran = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = iuran.kode_owner AND ar.kode_soa = '22' AND iuran.id_iuran = '{$id}' AND ar.status != 1)) as previous
			FROM iuran s
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
}

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
				WHERE a.kode_owner = '{$owner}' AND p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
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
				a.id_asuransi,
				a.kode_owner,
				o.nama_owner,
				o.unit_owner,
				o.kode_virtual,
				o.alamat_owner,
				o.id_deskripsi,
				d.jenis_deskripsi,
				d.sqm,
				a.id_periode,
				p.start_periode,
				p.start_periode AS periodStart,
				p.due_date AS dueDate,
				p.end_periode,
				p.end_periode AS periodEnd,
                a.stamp,
                a.total_asuransi,
				a.created_at,
				a.updated_at,
                (SELECT (SUM(ar.total) - SUM(ar.sisa)) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, asuransi JOIN periode ON asuransi.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = '{$id}' AND ar.status != 1)) as last,
				(SELECT SUM(ar.total) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, asuransi JOIN periode ON asuransi.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = '{$id}' AND ar.status != 1)) as total,
                (SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, asuransi JOIN periode ON asuransi.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = '{$id}' AND ar.status != 1)) as previous
			FROM asuransi a
				JOIN owner o
					ON(o.kode_owner = a.kode_owner)
				JOIN periode p
					ON(p.id_periode = a.id_periode)
				JOIN deskripsi d
					ON(d.id_deskripsi = o.id_deskripsi)
			WHERE a.id_asuransi = '{$id}'";

        $data = $this->db->query($sql);

        return $data->row();
    }

    public function print_by_periode($id_periode)
    {
        $query =
            "SELECT
                a.id_asuransi,
                a.kode_owner,
                o.nama_owner,
                o.unit_owner,
                o.kode_virtual,
                o.alamat_owner,
                o.id_deskripsi,
                d.jenis_deskripsi,
                d.sqm,
                a.id_periode,
                p.start_periode,
                p.start_periode AS periodStart,
                p.due_date AS dueDate,
                p.end_periode,
                p.end_periode AS periodEnd,
                a.stamp,
                a.total_asuransi,
                a.created_at,
                a.updated_at,
                SELECT (SUM(ar.total) - SUM(ar.sisa)) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, asuransi JOIN periode ON asuransi.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = i.id_asuransi AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = i.id_asuransi AND ar.status != 1)) as last,
                (SELECT SUM(ar.total) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, asuransi JOIN periode ON asuransi.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = i.id_asuransi AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = i.id_asuransi AND ar.status != 1)) as total,
                (SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, asuransi JOIN periode ON asuransi.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = i.id_asuransi AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = asuransi.kode_owner AND ar.kode_soa = '22' AND asuransi.id_asuransi = i.id_asuransi AND ar.status != 1)) as previous
            FROM asuransi a
                JOIN owner o
                    ON(o.kode_owner = a.kode_owner)
                JOIN periode p
                    ON(p.id_periode = a.id_periode)
                JOIN deskripsi d
                    ON(d.id_deskripsi = o.id_deskripsi)
			WHERE a.id_periode = '{$id_periode}'";

        $data = $this->db->query($query);

        return $data->result();
    }


    public function pembayaran($post)
	{

		$id = json_decode($_POST["id"]);
		$kodeOwner = json_decode($_POST["kodeOwner"]);
		$akun = json_decode($_POST["akun"]);

		for ($i = 0; $i < count($id); $i++) {

			$CoA = $this->M_coa->select_by_coa($akun[$i]);

			if ($akun[$i] != NULL) {
				if ($CoA->id_akun == 25) {
					$data = array(
						'paid' => 1,
						'paid_date' => $post['date']
					);
					$where = array(
						'kode_owner' => $kodeOwner[$i],
						'id_periode' => $post['period']
					);

					$this->db->update($this->tableName, $data, $where);
				} else {
				}
			}
		}
	}

    public function select_paid($date, $owner)
	{
		$query =
			"SELECT asuransi.id_asuransi
            FROM asuransi
            WHERE asuransi.id_asuransi IN
                (SELECT ar.bukti_transaksi
                FROM ar
                WHERE ar.kode_soa = 25
                    AND ar.id_owner = '{$owner}'
                    AND ar.status != 0)
                AND asuransi.paid_date = CAST('{$date}' AS DATE)";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function update_bayar($id)
	{
		$dataBayar = $this->M_bayar->select_by_voucher_id($id);

		foreach ($dataBayar as $bayar) {
			if ($bayar->kode_soa == 25) {
				$dataAsuransi = $this->M_ar->get_bukti_transaksi($bayar->id_ar);

				foreach ($dataAsuransi as $a) {
					$data = array(
						'paid' => 0,
						'paid_date' => NULL
					);
					$where = array('id_asuransi' => $a->bukti_transaksi);
					$this->db->update($this->tableName, $data, $where);
				}
			}
		}
	}
}

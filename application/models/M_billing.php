<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_billing extends CI_Model
{

	private $tableName = 'billing';
	private $formatId = 'IN@year-@month@counter';

	public function select_all()
	{

		$query = $this->db->select([
			'b.id_billing',
			'b.id_customer',
			'c.nama_customer',
			'c.kode_virtual',
			'c.unit_customer',
			'c.alamat_customer',
			'd.jenis_deskripsi',
			'b.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'b.kode_tagihan_listrik',
			'l.total as total_listrik',
			'l.prorate as prorate_listrik',
			'b.kode_tagihan_air',
			'a.total as total_air',
			'a.prorate as prorate_air',
			'b.total_pinalty',
			'b.paid',
			'b.admin',
			'ad.username as username_admin',
			'b.stamp',
			'b.d_c_note_date',
			'b.created_at'
		])->from("{$this->tableName} b")
			->join("customer c", "b.id_customer = c.kode_customer")
			->join("periode p", "b.id_periode = p.id_periode")
			->join("listrik l", "b.kode_tagihan_listrik = l.id_listrik")
			->join("air a", "b.kode_tagihan_air = a.kode_tagihan_air")
			->join("admin ad", "b.admin = ad.id")
			->join("deskripsi d", "c.id_deskripsi = d.id_deskripsi")
			->get();

		return $query->result();
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

	public function select_by_periode($id_periode)
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
				(SELECT (SUM(ar.total) - SUM(ar.sisa)) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, billing JOIN periode ON billing.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1)) as last,
               	(SELECT SUM(ar.total) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, billing JOIN periode ON billing.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1)) as total,
                (SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, billing JOIN periode ON billing.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1)) as previous
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
			WHERE b.id_periode = '{$id_periode}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function get_total($id_billing)
	{

		$sql =
			"SELECT 
				b.id_billing as id_billing,
				b.id_customer,
				c.nama_customer,
				c.kode_virtual,
				c.unit_customer,
				c.alamat_customer,
				d.jenis_deskripsi,
				b.id_periode,
				p.start_periode,
				p.end_periode,
				p.due_date,
				p.amount_days,
				b.kode_tagihan_listrik,
				l.total AS total_listrik,
				l.prorate AS prorate_listrik,
				b.kode_tagihan_air,
				a.total AS total_air,
				a.prorate AS prorate_air,
				(l.total + a.total + b.stamp + b.total_pinalty) AS total_billing,
				b.paid,
				b.admin,
				ad.username AS username_admin,
				b.total_pinalty,
				b.stamp,
				b.d_c_note_date,
				b.created_at
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
			WHERE b.id_billing = '{$id_billing}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_filter($customer, $startDate, $endDate)
	{

		if (!empty($startDate) && !empty($endDate) && empty($customer)) {

			$sql =
				"SELECT
					b.id_billing,
					b.id_customer,
					c.nama_customer,
					c.unit_customer,
					b.id_periode,
					p.start_periode,
					p.end_periode,
					b.kode_tagihan_listrik,
					l.total AS total_listrik,
					l.prorate AS prorate_listrik,
					b.kode_tagihan_air,
					a.total AS total_air,
					a.prorate AS prorate_air,
					b.total_pinalty,
					b.stamp,
					(SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, billing JOIN periode ON billing.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1)) as previous
				FROM billing b
					JOIN customer c
					ON b.id_customer = c.kode_customer
					JOIN periode p
					ON b.id_periode = p.id_periode
					JOIN listrik l
					ON b.kode_tagihan_listrik = l.id_listrik
					JOIN air a
					ON b.kode_tagihan_air = a.kode_tagihan_air
				WHERE MONTH(p.start_periode) BETWEEN CAST(MONTH('{$startDate}') AS DATE) AND CAST(MONTH('{$endDate}') AS DATE)
				ORDER BY p.start_periode DESC, b.id_billing";

			$query = $this->db->query($sql);
			return $query->result();
		} else if (!empty($customer) && !empty($startDate) && !empty($endDate)) {

			$sql =
				"SELECT
					b.id_billing,
					b.id_customer,
					c.nama_customer,
					c.unit_customer,
					b.id_periode,
					p.start_periode,
					p.end_periode,
					b.kode_tagihan_listrik,
					l.total AS total_listrik,
					l.prorate AS prorate_listrik,
					b.kode_tagihan_air,
					a.total AS total_air,
					a.prorate AS prorate_air,
					b.total_pinalty,
					b.stamp,
					(SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, billing JOIN periode ON billing.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1)) as previous
				FROM billing b
					JOIN customer c
					ON b.id_customer = c.kode_customer
					JOIN periode p
					ON b.id_periode = p.id_periode
					JOIN listrik l
					ON b.kode_tagihan_listrik = l.id_listrik
					JOIN air a
					ON b.kode_tagihan_air = a.kode_tagihan_air
				WHERE b.id_customer = '{$customer}' AND MONTH(p.start_periode) BETWEEN CAST(MONTH('{$startDate}') AS DATE) AND CAST(MONTH('{$endDate}') AS DATE)
				ORDER BY p.start_periode DESC, b.id_billing";

			$query = $this->db->query($sql);
			return $query->result();
		} else {

			$sql =
				"SELECT
					b.id_billing,
					b.id_customer,
					c.nama_customer,
					c.unit_customer,
					b.id_periode,
					p.start_periode,
					p.end_periode,
					b.kode_tagihan_listrik,
					l.total AS total_listrik,
					l.prorate AS prorate_listrik,
					b.kode_tagihan_air,
					a.total AS total_air,
					a.prorate AS prorate_air,
					b.total_pinalty,
					b.stamp,
					(SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, billing JOIN periode ON billing.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_customer = billing.id_customer AND ar.kode_soa = '21' AND billing.id_billing = b.id_billing AND ar.status != 1)) as previous
				FROM billing b
					JOIN customer c
					ON b.id_customer = c.kode_customer
					JOIN periode p
					ON b.id_periode = p.id_periode
					JOIN listrik l
					ON b.kode_tagihan_listrik = l.id_listrik
					JOIN air a
					ON b.kode_tagihan_air = a.kode_tagihan_air
				-- WHERE p.start_periode <= CURDATE() AND MONTH(p.start_periode) = MONTH(CURDATE())
				ORDER BY p.start_periode DESC, b.id_billing";

			$query = $this->db->query($sql);
			return $query->result();
		}
	}

	public function select_periode_billing()
	{

		$query = $this->db->select([
			'b.id_periode',
			'p.start_periode',
			'p.end_periode'
		])->from("{$this->tableName} b")
			->join("periode p", "b.id_periode = p.id_periode")
			->group_by('b.id_periode')
			->order_by('p.start_periode', 'DESC')
			->get();

		return $query->result();
	}

	public function select_periode_billing_customer($customer)
	{
		$subquery = $this->db->select('id_periode')->from($this->tableName)->where('id_customer', $customer)->get_compiled_select();

		$query = $this->db->select('*')
			->from('view_periode_billing_customer')
			->where('kode_customer', $customer)
			->where("id_periode not in ($subquery)", null, false)
			->get();
		return $query->result();
	}

	public function select_inv_not_bill($id_periode)
	{
		$query = $this->db->select('*')
			->from('view_available_periode_billing')
			->where('id_periode', $id_periode)->get();

		return $query->result();
	}

	public function select_period_not_bill()
	{
		$subquery = $this->db->select('id_periode')
			->from('view_available_periode_billing')
			->group_by('id_periode')->get_compiled_select();


		$query  = $this->db->select([
			'id_periode AS id',
			'start_periode AS periodStart',
			'end_periode AS periodEnd',
			'due_date AS dueDate',
			'amount_days AS amount'
		])
			->from('periode')
			->where("id_periode in ($subquery)", null, false)
			->order_by('start_periode', 'ASC')
			->get();

		return $query->result();
	}

	public function get_last_id($dt)
	{
		$currentNumber = $this->db->query('SELECT get_increment_billing_id(?, ?) as maxNumber', [$dt->format('Y'), $dt->format('m')]);

		return $currentNumber->row();
	}

	public function insert($params)
	{
		$this->db->insert($this->tableName, $params);

		return $this->db->affected_rows();
	}

	public function update($params)
	{
		$data = array(
			'no_rek' => $params['rekening'],
			'nama_bank' => $params['nama']
		);

		$where = array('kode_bank' => $params['id']);

		$this->db->update($this->tableName, $data, $where);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->delete($this->tableName, ['id_billing' => $id]);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function delete_all($id)
	{
		$this->db->where_in('id_billing', $id);
		$this->db->delete($this->tableName);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function select_candidate_key_by_id($id)
	{
		$query = $this->db->select([
			'id',
			'name',
			'desc',
			'key',
			'counter_count'
		])->from($this->tableName)
			->where('id', $id)
			->get();

		return $query->row();
	}

	public function pembayaran($post)
	{

		$id = json_decode($_POST["id"]);
		$akun = json_decode($_POST["akun"]);

		for ($i = 0; $i < count($id); $i++) {

			$ar = $this->M_ar->select_by_id($id[$i]);
			$CoA = $this->M_coa->select_by_coa($akun[$i]);

			if ($akun[$i] != NULL) {
				if ($CoA->id_akun == 21) {
					$data = array(
						'paid' => 1,
						'paid_date' => $post['date']
					);
					$where = array(
						'id_customer' => $ar->id_customer,
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
			"SELECT billing.id_billing
            FROM billing
            WHERE billing.id_billing IN
                (SELECT ar.bukti_transaksi
                FROM ar
                WHERE ar.kode_soa = 21
                    AND ar.id_customer = '{$owner}'
                	AND ar.status != 0)
                AND billing.paid_date = CAST('{$date}' AS DATE)";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function update_bayar($id)
	{
		$dataBayar = $this->M_bayar->select_by_voucher_id($id);

		foreach ($dataBayar as $bayar) {
			if ($bayar->kode_soa == 21) {
				$dataBill = $this->M_ar->get_bukti_transaksi($bayar->id_ar);

				foreach ($dataBill as $bil) {
					$data = array(
						'paid' => 0,
						'paid_date' => NULL
					);
					$where = array('id_billing' => $bil->bukti_transaksi);
					$this->db->update($this->tableName, $data, $where);
				}
			}
		}
	}
}

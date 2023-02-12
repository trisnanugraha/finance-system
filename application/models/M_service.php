<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_service extends CI_Model
{
	private $tableName = 'service';
	private $tableNameDua = 'invoice_service';

	public function select_all()
	{

		$query = $this->db->select([
			's.kode_tagihan_service',
			's.kode_owner',
			'o.nama_owner',
			'o.unit_owner',
			'o.kode_virtual',
			'o.alamat_owner',
			'o.id_deskripsi',
			'd.jenis_deskripsi',
			's.id_tarif',
			't.tarif_sinking_fund',
			't.tarif_service_charge',
			's.id_periode',
			'p.start_periode',
			'p.due_date',
			'p.end_periode AS periodEnd',
			's.end_periode',
			's.sinking_fund',
			's.service_charge',
			's.stamp',
			's.paid',
			's.paid_date',
			's.total',
			's.created_at',
			's.updated_at'
		])->from("{$this->tableName} s")
			->join('owner o', 's.kode_owner = o.kode_owner')
			->join('periode p', 's.id_periode = p.id_periode')
			->join('tarif t', 's.id_tarif = t.id_tarif')
			->join("deskripsi d", "o.id_deskripsi = d.id_deskripsi")
			->order_by('s.kode_tagihan_service', 'ASC')
			->order_by('p.start_periode', 'ASC')
			->get();

		return $query->result();
	}

	public function select_invoice_owner_period($owner, $period)
	{

		$query = $this->db->select('*')
			->from('invoice_service')
			->where('kode_owner', $owner)
			->where('id_periode', $period)
			->get();

		return $query->row();
	}

	public function select_by_id($id)
	{

		$query = $this->db->select([
			's.kode_tagihan_service',
			's.kode_owner',
			'o.nama_owner',
			'o.unit_owner',
			'o.kode_virtual',
			'o.alamat_owner',
			'o.id_deskripsi',
			'd.jenis_deskripsi',
			's.id_periode',
			'p.start_periode',
			'p.due_date',
			'p.end_periode AS periodEnd',
			's.id_tarif',
			't.tarif_sinking_fund',
			't.tarif_service_charge',
			's.end_periode',
			's.sinking_fund',
			's.service_charge',
			's.stamp',
			's.paid',
			's.paid_date',
			's.total',
			's.created_at',
			's.updated_at'
		])->from("{$this->tableName} s")
			->join('owner o', 's.kode_owner = o.kode_owner')
			->join('tarif t', 's.id_tarif = t.id_tarif')
			->join('periode p', 's.id_periode = p.id_periode')
			->join("deskripsi d", "o.id_deskripsi = d.id_deskripsi")
			->where('s.kode_tagihan_service', $id)
			->get();

		return $query->row();
	}

	public function select_by_periode($id_periode)
	{

		$query = $this->db->select([
			's.kode_tagihan_service',
			's.kode_owner',
			'o.nama_owner',
			'o.unit_owner',
			'o.kode_virtual',
			'o.alamat_owner',
			'o.id_deskripsi',
			'd.jenis_deskripsi',
			's.id_periode',
			'p.start_periode',
			'p.due_date',
			'p.end_periode AS periodEnd',
			's.id_tarif',
			't.tarif_sinking_fund',
			't.tarif_service_charge',
			's.end_periode',
			's.sinking_fund',
			's.service_charge',
			's.stamp',
			's.paid',
			's.paid_date',
			's.total',
			's.created_at',
			's.updated_at'
		])->from("{$this->tableName} s")
			->join('tarif t', 's.id_tarif = t.id_tarif')
			->join('owner o', 's.kode_owner = o.kode_owner')
			->join('periode p', 's.id_periode = p.id_periode')
			->join("deskripsi d", "o.id_deskripsi = d.id_deskripsi")
			->where('s.id_periode', $id_periode)
			->get();

		return $query->result();
	}

	public function select_filter($owner, $startDate, $endDate)
	{

		if (!empty($startDate) && !empty($endDate) && empty($owner)) {

			$sql =
				"SELECT
					s.kode_tagihan_service,
					s.kode_owner,
					o.nama_owner,
					o.unit_owner,
					o.kode_virtual,
					o.alamat_owner,
					o.id_deskripsi,
					d.jenis_deskripsi,
					s.id_periode,
					p.start_periode,
					p.due_date,
					DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS periode_satu,
					p.end_periode AS periodEnd,
					s.id_tarif,
					t.tarif_sinking_fund,
					t.tarif_service_charge,
					s.end_periode,
					s.sinking_fund,
					s.service_charge,
					s.stamp,
					s.paid,
					s.paid_date,
					s.total,
					s.created_at,
					s.updated_at,
					(SELECT (SUM(ar.total) - SUM(ar.sisa)) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode)) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as last,
               		(SELECT SUM(ar.total) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode)) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as totalp,
                	(SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode)) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as previous
				FROM service s
					JOIN tarif t
					ON s.id_tarif = t.id_tarif
					JOIN owner o
					ON s.kode_owner = o.kode_owner
					JOIN periode p
					ON s.id_periode = p.id_periode
					JOIN deskripsi d
					ON o.id_deskripsi = d.id_deskripsi
				WHERE p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, s.kode_tagihan_service";

			$query = $this->db->query($sql);
			return $query->result();
		} else if (!empty($owner) && !empty($startDate) && !empty($endDate)) {

			$sql =
				"SELECT
					s.kode_tagihan_service,
					s.kode_owner,
					o.nama_owner,
					o.unit_owner,
					o.kode_virtual,
					o.alamat_owner,
					o.id_deskripsi,
					d.jenis_deskripsi,
					s.id_periode,
					p.start_periode,
					p.due_date,
					DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS periode_satu,
					p.end_periode AS periodEnd,
					s.id_tarif,
					t.tarif_sinking_fund,
					t.tarif_service_charge,
					s.end_periode,
					s.sinking_fund,
					s.service_charge,
					s.stamp,
					s.paid,
					s.paid_date,
					s.total,
					s.created_at,
					s.updated_at,
					(SELECT (SUM(ar.total) - SUM(ar.sisa)) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as last,
               		(SELECT SUM(ar.total) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as totalp,
                	(SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as previous
				FROM service s
					JOIN tarif t
					ON s.id_tarif = t.id_tarif
					JOIN owner o
					ON s.kode_owner = o.kode_owner
					JOIN periode p
					ON s.id_periode = p.id_periode
					JOIN deskripsi d
					ON o.id_deskripsi = d.id_deskripsi
				WHERE s.kode_owner = '{$owner}' AND p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, s.kode_tagihan_service";

			$query = $this->db->query($sql);
			return $query->result();
		} else {

			$sql =
				"SELECT
					s.kode_tagihan_service,
					s.kode_owner,
					o.nama_owner,
					o.unit_owner,
					o.kode_virtual,
					o.alamat_owner,
					o.id_deskripsi,
					d.jenis_deskripsi,
					s.id_periode,
					p.start_periode,
					p.due_date,
					p.end_periode AS periodEnd,
					s.id_tarif,
					t.tarif_sinking_fund,
					t.tarif_service_charge,
					DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL -1 MONTH) AS periode_satu,
					s.end_periode,
					s.sinking_fund,
					s.service_charge,
					s.stamp,
					s.paid,
					s.paid_date,
					s.total,
					s.created_at,
					s.updated_at,
					(SELECT (SUM(ar.total) - SUM(ar.sisa)) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as last,
               		(SELECT SUM(ar.total) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as totalp,
                	(SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as previous
				FROM service s
					JOIN tarif t
					ON s.id_tarif = t.id_tarif
					JOIN owner o
					ON s.kode_owner = o.kode_owner
					JOIN periode p
					ON s.id_periode = p.id_periode
					JOIN deskripsi d
					ON o.id_deskripsi = d.id_deskripsi
				-- WHERE p.start_periode <= CURDATE() AND MONTH(p.start_periode) = MONTH(CURDATE())
				ORDER BY p.start_periode DESC, s.kode_tagihan_service";

			$query = $this->db->query($sql);
			return $query->result();
		}
	}

	public function get_last_id($dt)
	{
		$currentNumber = $this->db->query('SELECT get_increment_service_id(?, ?) as maxNumber', [$dt->format('Y'), $dt->format('m')]);

		return $currentNumber->row();
	}

	public function select_inv_not_bill($id_periode)
	{
		$query = $this->db->select('*')
			->from('view_available_periode_service')
			->where('id_periode', $id_periode)->get();

		return $query->result();
	}

	public function select_invoice()
	{
		$sql =
			"SELECT
				id_periode,
				start_periode,
				end_periode,
				kode_owner
			FROM view_invoice_service
			WHERE
				!EXISTS
					(SELECT
						`invoice_service`.`id_periode`,
						`invoice_service`.`kode_owner`
					FROM `invoice_service`
					WHERE `invoice_service`.`id_periode` = `view_invoice_service`.`id_periode`
					AND `invoice_service`.`kode_owner` = `view_invoice_service`.`kode_owner`
					LIMIT 1)
				AND view_invoice_service.kode_owner != 'B1'
				AND view_invoice_service.kode_owner != 'B2'
				AND view_invoice_service.kode_owner != 'B3'
				AND view_invoice_service.kode_owner != '2-SPA'";

		$query = $this->db->query($sql);

		return $query->result();
	}

	public function select_period_not_bill()
	{
		$query  =
			"SELECT
				p.id_periode AS id,
				p.start_periode AS periodStart,
				DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS first_day,
				p.end_periode AS periodEnd,
				LAST_DAY(p.start_periode + INTERVAL 2 MONTH) AS last_day,
				p.due_date AS dueDate,
				p.amount_days + 59 AS amount
			FROM periode p
			WHERE p.id_periode IN
				(SELECT
						vp.id_periode
					FROM view_available_periode_service vp
					GROUP BY vp.id_periode)
			ORDER BY p.start_periode ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_periode_service()
	{
		$query =
			"SELECT
				s.id_periode,
				DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS start_periode,
				s.end_periode
			FROM service s
				JOIN periode p
					ON(p.id_periode = s.id_periode)
			GROUP BY
				s.id_periode";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_periode_service_owner($owner)
	{
		$subquery = $this->db->select('id_periode')->from($this->tableName)->where('kode_owner', $owner)->get_compiled_select();

		$query = $this->db->select('*')
			->from('view_periode_service_owner')
			->where('kode_owner', $owner)
			->where("id_periode not in ($subquery)", null, false)
			->get();
		return $query->result();
	}

	public function check_tagihan($nama)
	{
		$this->db->where('kode_tagihan_service', $nama);
		$data = $this->db->get('service');

		return $data->num_rows();
	}

	public function insert($params)
	{

		$this->db->insert($this->tableName, $params);

		return $this->db->affected_rows();
	}

	public function insert_invoice($params)
	{

		$this->db->insert($this->tableNameDua, $params);

		return $this->db->affected_rows();
	}

	public function insert_batch($data)
	{
		$this->db->insert_batch('service', $data);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->delete($this->tableName, ['kode_tagihan_service' => $id]);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function delete_all($id)
	{
		$this->db->where_in('kode_tagihan_service', $id);
		$this->db->delete($this->tableName);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function check_bill($kode_owner, $id_periode)
	{
		$data = $this->db->where([
			'kode_owner' => $kode_owner,
			'id_periode' => $id_periode
		])
			->count_all_results('service');
		return $data;
	}

	public function check_nama($nama)
	{
		$this->db->where('kode_tagihan_service', $nama);
		$data = $this->db->get('service');

		return $data->num_rows();
	}

	public function check_owner($nama)
	{
		$this->db->where('kode_owner', $nama);
		$data = $this->db->get('service');

		return $data->num_rows();
	}

	public function total_rows()
	{
		$data = $this->db->get('service');

		return $data->num_rows();
	}

	public function pembayaran($post)
	{

		$id = json_decode($_POST["id"]);
		$kodeOwner = json_decode($_POST["kodeOwner"]);
		$akun = json_decode($_POST["akun"]);

		for ($i = 0; $i < count($id); $i++) {

			$CoA = $this->M_coa->select_by_coa($akun[$i]);

			if ($akun[$i] != NULL) {
				if ($CoA->id_akun == 22) {
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
			"SELECT service.kode_tagihan_service
            FROM service
            WHERE service.kode_tagihan_service IN
                (SELECT ar.bukti_transaksi
                FROM ar
                WHERE ar.kode_soa = 22
                    AND ar.id_owner = '{$owner}'
                	AND ar.status != 0)
                AND service.paid_date = CAST('{$date}' AS DATE)";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function update_bayar($id)
	{
		$dataBayar = $this->M_bayar->select_by_voucher_id($id);

		foreach ($dataBayar as $bayar) {
			if ($bayar->kode_soa == 22) {
				$dataSC = $this->M_ar->get_bukti_transaksi($bayar->id_ar);

				foreach ($dataSC as $sc) {
					$data = array(
						'paid' => 0,
						'paid_date' => NULL
					);
					$where = array('kode_tagihan_service' => $sc->bukti_transaksi);
					$this->db->update($this->tableName, $data, $where);
				}
			}
		}
	}

	public function print($id)
	{
		$sql =
			"SELECT
				s.kode_tagihan_service,
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
				LAST_DAY(p.start_periode + INTERVAL 2 MONTH) AS periodEnd,
				s.id_tarif,
				t.tarif_sinking_fund,
				t.tarif_service_charge,
				s.end_periode,
				s.sinking_fund,
				s.service_charge,
				s.stamp,
				s.paid,
				s.paid_date,
				s.total,
				s.created_at,
				s.updated_at,
				(SELECT (SUM(ar.total) - SUM(ar.sisa)) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = '{$id}' AND ar.status != 1)) as last,
				(SELECT SUM(ar.total) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = '{$id}' AND ar.status != 1)) as totalp,
                (SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = '{$id}' AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = '{$id}' AND ar.status != 1)) as previous
			FROM service s
				JOIN owner o
					ON(o.kode_owner = s.kode_owner)
				JOIN tarif t
					ON(t.id_tarif = s.id_tarif)
				JOIN periode p
					ON(p.id_periode = s.id_periode)
				JOIN deskripsi d
					ON(d.id_deskripsi = o.id_deskripsi)
			WHERE s.kode_tagihan_service = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function print_periode($id)
	{
		$sql =
			"SELECT
				s.kode_tagihan_service,
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
				LAST_DAY(p.start_periode + INTERVAL 2 MONTH) AS periodEnd,
				s.id_tarif,
				t.tarif_sinking_fund,
				t.tarif_service_charge,
				s.end_periode,
				s.sinking_fund,
				s.service_charge,
				s.stamp,
				s.paid,
				s.paid_date,
				s.total,
				s.created_at,
				s.updated_at,
				(SELECT (SUM(ar.total) - SUM(ar.sisa)) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as last,
               	(SELECT SUM(ar.total) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as totalp,
                (SELECT SUM(ar.sisa) FROM ar JOIN periode p ON p.id_periode = ar.id_periode, service JOIN periode ON service.id_periode = periode.id_periode WHERE (MONTH(p.start_periode) < MONTH(periode.start_periode) AND YEAR(p.start_periode) = YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1) OR (YEAR(p.start_periode) < YEAR(periode.start_periode) AND ar.id_owner = service.kode_owner AND ar.kode_soa = '22' AND service.kode_tagihan_service = s.kode_tagihan_service AND ar.status != 1)) as previous
			FROM service s
				JOIN owner o
					ON(o.kode_owner = s.kode_owner)
				JOIN tarif t
					ON(t.id_tarif = s.id_tarif)
				JOIN periode p
					ON(p.id_periode = s.id_periode)
				JOIN deskripsi d
					ON(d.id_deskripsi = o.id_deskripsi)
			WHERE (s.id_periode = '{$id}' AND s.total > 3000)";

		$data = $this->db->query($sql);

		return $data->result();
	}
}

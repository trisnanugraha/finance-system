<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ar extends CI_Model
{
	private $tableName = 'ar';

	public function select_all_ar()
	{
		$sql = "SELECT ar.id_ar, ar.id_periode, p.start_periode FROM ar JOIN periode p ON(ar.id_periode = p.id_periode) GROUP BY ar.id_periode";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all_bayar()
	{
		$sql = "SELECT ar.id_customer, c.nama_customer, c.unit_customer FROM ar JOIN customer c ON(ar.id_customer = c.kode_customer) GROUP BY c.unit_customer";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all()
	{
		$query = $this->db->select([
			'pa.id_ar',
			'pa.id_customer',
			'c.nama_customer',
			'c.unit_customer',
			'c.kode_virtual AS cusVirtual',
			'c.alamat_customer',
			'pa.id_owner',
			'o.nama_owner',
			'o.unit_owner',
			'o.alamat_owner',
			'o.kode_virtual AS ownerVirtual',
			'pa.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'pa.kode_soa',
			'co.coa_id',
			'co.coa_name',
			'pa.keterangan',
			'pa.bukti_transaksi',
			'pa.sisa',
			'pa.total',
			'pa.status',
			'pa.so',
			'pa.created_at',
			'pa.updated_at'
		])->from("{$this->tableName} pa")
			->join("customer c", "pa.id_customer = c.kode_customer")
			->join("owner o", "pa.id_owner = o.kode_owner")
			->join("periode p", "pa.id_periode = p.id_periode")
			->join("coa co", "co.id_akun = pa.kode_soa")
			->order_by('pa.id_ar', 'ASC')
			->get();

		return $query->result();
	}

	public function select_by_id($id)
	{
		$query = $this->db->select([
			'pa.id_ar',
			'pa.id_customer',
			'c.nama_customer',
			'c.unit_customer',
			'c.kode_virtual AS cusVirtual',
			'c.alamat_customer',
			'pa.id_owner',
			'o.nama_owner',
			'o.unit_owner',
			'o.alamat_owner',
			'o.kode_virtual AS ownerVirtual',
			'pa.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'pa.kode_soa',
			'co.coa_id',
			'co.coa_name',
			'pa.keterangan',
			'pa.bukti_transaksi',
			'pa.sisa',
			'pa.total',
			'pa.status',
			'pa.so',
			'pa.created_at',
			'pa.updated_at'
		])->from("{$this->tableName} pa")
			->join("customer c", "pa.id_customer = c.kode_customer")
			->join("periode p", "pa.id_periode = p.id_periode")
			->join("owner o", "pa.id_owner = o.kode_owner")
			->join("coa co", "co.id_akun = pa.kode_soa")
			->order_by('pa.id_ar', 'ASC')
			->where('pa.id_ar', $id)
			->get();

		return $query->row();
	}

	public function tagihan($id)
	{
		$query = $this->db->select([
			'pa.id_ar',
			'pa.id_customer',
			'c.nama_customer',
			'c.unit_customer',
			'c.kode_virtual AS cusVirtual',
			'c.alamat_customer',
			'pa.id_owner',
			'o.nama_owner',
			'o.unit_owner',
			'o.alamat_owner',
			'o.kode_virtual AS ownerVirtual',
			'pa.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'pa.kode_soa',
			'co.coa_id',
			'co.coa_name',
			'pa.keterangan',
			'pa.bukti_transaksi',
			'pa.sisa',
			'pa.total',
			'pa.status',
			'pa.so',
			'pa.created_at',
			'pa.updated_at'
		])->from("{$this->tableName} pa")
			->join("customer c", "pa.id_customer = c.kode_customer")
			->join("periode p", "pa.id_periode = p.id_periode")
			->join("owner o", "pa.id_owner = o.kode_owner")
			->join("coa co", "co.id_akun = pa.kode_soa")
			->order_by('pa.status', 'ASC')
			->order_by('p.start_periode', 'DESC')
			->order_by('pa.id_ar', 'ASC')
			->where('c.unit_customer', $id)
			->get();

		return $query->result();
	}

	public function select_filter($akun, $startDate, $endDate)
	{
		if (!empty($startDate) && !empty($endDate) && empty($akun)) {
			$sql =
				"SELECT
					pa.id_ar,
					pa.id_customer,
					c.nama_customer,
					c.unit_customer,
					c.kode_virtual AS cusVirtual,
					c.alamat_customer,
					pa.id_owner,
					o.nama_owner,
					o.unit_owner,
					o.alamat_owner,
					o.kode_virtual AS ownerVirtual,
					pa.id_periode,
					p.start_periode,
					p.end_periode,
					p.due_date,
					DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS first_service,
					DATE_ADD(DATE_ADD(LAST_DAY(p.due_date), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS first_billing,
					p.amount_days,
					(SELECT billing.d_c_note_date FROM billing WHERE billing.id_billing = pa.bukti_transaksi AND pa.kode_soa = 21) AS d_c_note_billing,
                    (SELECT DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) FROM service JOIN periode p ON p.id_periode = service.id_periode WHERE service.kode_tagihan_service = pa.bukti_transaksi AND pa.kode_soa = 22) AS d_c_note_service,
					pa.kode_soa,
					co.coa_id,
					co.coa_name,
					pa.keterangan,
					pa.bukti_transaksi,
					pa.sisa,
					pa.total,
					pa.status,
					pa.so,
					pa.created_at,
					pa.updated_at
				FROM ar pa
					JOIN customer c
					ON pa.id_customer = c.kode_customer
					JOIN periode p
					ON pa.id_periode = p.id_periode
					JOIN owner o
					ON pa.id_owner = o.kode_owner
					JOIN coa co
					ON co.id_akun = pa.kode_soa
				WHERE p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, pa.bukti_transaksi";

			$query = $this->db->query($sql);
			return $query->result();
		} else if (!empty($akun) && !empty($startDate) && !empty($endDate)) {
			$sql =
				"SELECT
					pa.id_ar,
					pa.id_customer,
					c.nama_customer,
					c.unit_customer,
					c.kode_virtual AS cusVirtual,
					c.alamat_customer,
					pa.id_owner,
					o.nama_owner,
					o.unit_owner,
					o.alamat_owner,
					o.kode_virtual AS ownerVirtual,
					pa.id_periode,
					p.start_periode,
					p.end_periode,
					p.due_date,
					DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS first_service,
					DATE_ADD(DATE_ADD(LAST_DAY(p.due_date), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS first_billing,
					p.amount_days,
					(SELECT billing.d_c_note_date FROM billing WHERE billing.id_billing = pa.bukti_transaksi AND pa.kode_soa = 21) AS d_c_note_billing,
                    (SELECT DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) FROM service JOIN periode p ON p.id_periode = service.id_periode WHERE service.kode_tagihan_service = pa.bukti_transaksi AND pa.kode_soa = 22) AS d_c_note_service,
					pa.kode_soa,
					co.coa_id,
					co.coa_name,
					pa.keterangan,
					pa.bukti_transaksi,
					pa.sisa,
					pa.total,
					pa.status,
					pa.so,
					pa.created_at,
					pa.updated_at
				FROM ar pa
					JOIN customer c
					ON pa.id_customer = c.kode_customer
					JOIN periode p
					ON pa.id_periode = p.id_periode
					JOIN owner o
					ON pa.id_owner = o.kode_owner
					JOIN coa co
					ON co.id_akun = pa.kode_soa
				WHERE pa.kode_soa = '{$akun}' 
					AND p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, pa.bukti_transaksi";

			$query = $this->db->query($sql);
			return $query->result();
		} else {

			$sql =
				"SELECT
					pa.id_ar,
					pa.id_customer,
					c.nama_customer,
					c.unit_customer,
					c.kode_virtual AS cusVirtual,
					c.alamat_customer,
					pa.id_owner,
					o.nama_owner,
					o.unit_owner,
					o.alamat_owner,
					o.kode_virtual AS ownerVirtual,
					pa.id_periode,
					p.start_periode,
					p.end_periode,
					p.due_date,
					DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS first_service,
					DATE_ADD(DATE_ADD(LAST_DAY(p.due_date), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS first_billing,
					p.amount_days,
					(SELECT billing.d_c_note_date FROM billing WHERE billing.id_billing = pa.bukti_transaksi AND pa.kode_soa = 21) AS d_c_note_billing,
                    (SELECT DATE_ADD(DATE_ADD(LAST_DAY(p.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) FROM service JOIN periode p ON p.id_periode = service.id_periode WHERE service.kode_tagihan_service = pa.bukti_transaksi AND pa.kode_soa = 22) AS d_c_note_service,
					pa.kode_soa,
					co.coa_id,
					co.coa_name,
					pa.keterangan,
					pa.bukti_transaksi,
					pa.sisa,
					pa.total,
					pa.status,
					pa.so,
					pa.created_at,
					pa.updated_at
				FROM ar pa
					JOIN customer c
					ON pa.id_customer = c.kode_customer
					JOIN periode p
					ON pa.id_periode = p.id_periode
					JOIN owner o
					ON pa.id_owner = o.kode_owner
					JOIN coa co
					ON co.id_akun = pa.kode_soa
				-- WHERE AND p.start_periode <= CURDATE() AND MONTH(p.start_periode) = MONTH(CURDATE())
				ORDER BY p.start_periode DESC, pa.bukti_transaksi";

			$query = $this->db->query($sql);
			return $query->result();
		}
	}

	public function select_periode_ar()
	{

		$query = $this->db->select([
			'pa.id_periode',
			'p.start_periode',
			'p.end_periode'
		])->from("{$this->tableName} pa")
			->join("periode p", "pa.id_periode = p.id_periode")
			->group_by('pa.id_periode')
			->get();

		return $query->result();
	}

	public function get_last_id($dt)
	{
		$currentNumber = $this->db->query('SELECT get_increment_ar_id(?, ?) as maxNumber', [$dt->format('Y'), $dt->format('m')]);

		return $currentNumber->row();
	}

	public function insert($params)
	{

		$this->db->insert($this->tableName, $params);

		return $this->db->insert_id();
	}

	public function update_ar_out($post)
	{
		$id = json_decode($_POST["id"]);
		$akun = json_decode($_POST["akun"]);
		$credit = json_decode($_POST["credit"]);

		for ($i = 0; $i < count($id); $i++) {

			if ($akun[$i] != NULL) {
				$CoA = $this->M_coa->select_by_coa($akun[$i]);
				$ar = $this->M_ar->select_by_id($id[$i]);
				$sisa = ($ar->sisa - $credit[$i]);

				if ($CoA->id_akun == 22) {
					if ($sisa <= 50) {
						$data = array(
							'status' => 1,
							'sisa' => 0
						);
						$where = array('id_ar' => $id[$i]);
						$this->db->update($this->tableName, $data, $where);
					} else {
						$data = array(
							'status' => 2,
							'sisa' => $sisa
						);
						$where = array('id_ar' => $id[$i]);
						$this->db->update($this->tableName, $data, $where);
					}
				} else if ($CoA->id_akun == 21) {
					if ($sisa <= 50) {
						$data = array(
							'status' => 1,
							'sisa' => 0
						);
						$where = array('id_ar' => $id[$i]);
						$this->db->update($this->tableName, $data, $where);
					} else {
						$data = array(
							'status' => 2,
							'sisa' => $sisa
						);
						$where = array('id_ar' => $id[$i]);
						$this->db->update($this->tableName, $data, $where);
					}
				} else {
				}
			}
		}
		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$where = ['id_ar' => $id];
		$this->db->delete($this->tableName, $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function delete_all($id)
	{
		$this->db->where_in('id_ar', $id);
		$this->db->delete($this->tableName);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function update_bayar($id)
	{
		$dataBayar = $this->M_bayar->select_by_id($id);

		foreach ($dataBayar as $bayar) {
			$ar = $this->M_ar->select_by_id($bayar->id_ar);
			if ($bayar->kode_soa == 22) {
				$data = array(
					'sisa' => $ar->sisa + $bayar->credit,
					'status' => 0
				);
				$where = array('id_ar' => $bayar->id_ar);
				$this->db->update($this->tableName, $data, $where);
			} else if ($bayar->kode_soa == 21) {
				$data = array(
					'sisa' => $ar->sisa + $bayar->credit,
					'status' => 0
				);
				$where = array('id_ar' => $bayar->id_ar);
				$this->db->update($this->tableName, $data, $where);
			} else {
			}
		}
	}

	public function check_bill($id_customer, $periode, $coa)
	{
		$data = $this->db->where([
			'id_customer' => $id_customer,
			'id_periode' => $periode,
			'kode_soa' => $coa,
		])
			->count_all_results('ar');
		return $data;
	}

	public function select_cus()
	{

		$sql =
			"SELECT
				pa.id_ar,
				pa.id_customer,
				c.nama_customer,
				c.unit_customer,
				c.kode_virtual AS cusVirtual,
				c.alamat_customer,
				pa.id_owner,
				o.nama_owner,
				o.unit_owner,
				o.alamat_owner,
				o.kode_virtual AS ownerVirtual,
				pa.id_periode,
				p.start_periode,
				p.end_periode,
				p.due_date,
				p.amount_days,
				pa.kode_soa,
				co.coa_id,
				co.coa_name,
				pa.keterangan,
				pa.bukti_transaksi,
				pa.sisa,
				pa.total,
				pa.status,
				pa.so,
				pa.created_at,
				pa.updated_at
			FROM ar pa
				JOIN customer c
				ON pa.id_customer = c.kode_customer
				JOIN periode p
				ON pa.id_periode = p.id_periode
				JOIN owner o
				ON pa.id_owner = o.kode_owner
				JOIN coa co
				ON co.id_akun = pa.kode_soa
			GROUP BY pa.id_customer 
			ORDER BY pa.id_customer ASC";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function print($kodeCusA, $kodeCusB, $dateA, $dateB, $CoA)
	{

		$sql =
			"SELECT 
				ar.id_ar, 
				ar.id_customer,
                customer.nama_customer,
				ar.id_periode,
				ar.id_owner,
				owner.nama_owner,
                ar.kode_soa,
				periode.start_periode AS arTgl, 
				ar.keterangan AS arKet, 
				ar.bukti_transaksi AS arBT, 
				ar.total AS arTotal, 
				(SELECT bayar.id_bayar FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS id_bayar,
				(SELECT bayar.id_voucher FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS id_voucher,
				(SELECT bayar.tanggal_bayar FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemTgl,
				(SELECT bayar.keterangan FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemKet, 
				(SELECT voucher.bukti_transaksi FROM voucher JOIN bayar ON bayar.id_voucher = voucher.id_voucher WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(voucher.tanggal_voucher) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemBT,
				(SELECT SUM(bayar.credit) FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemTotal
			FROM ar 
				JOIN periode 
				ON periode.id_periode = ar.id_periode
				JOIN owner
				ON owner.kode_owner = ar.id_owner
				JOIN customer
                ON customer.kode_customer = ar.id_customer
			WHERE (ar.id_customer BETWEEN '{$kodeCusA}' AND '{$kodeCusB}') 
				AND (MONTH(periode.start_periode) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}') OR MONTH(periode.due_date) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}'))
				AND (ar.kode_soa = '{$CoA}')
			GROUP BY ar.id_customer, ar.kode_soa
			ORDER BY ar.id_customer ASC";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function print_cus_LA($kodeCusA, $kodeCusB, $dateA, $dateB)
	{

		$sql =
			"SELECT 
				ar.id_ar, 
				ar.id_customer,
                customer.nama_customer,
				ar.id_periode,
				ar.id_owner,
				owner.nama_owner,
                ar.kode_soa,
				DATE_ADD(DATE_ADD(LAST_DAY(periode.due_date), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS arTgl,
				periode.start_periode, 
				ar.keterangan AS arKet, 
				ar.bukti_transaksi AS arBT, 
				ar.total AS arTotal, 
				(SELECT bayar.id_bayar FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS id_bayar,
				(SELECT bayar.id_voucher FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS id_voucher,
				(SELECT bayar.tanggal_bayar FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemTgl,
				(SELECT bayar.keterangan FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemKet, 
				(SELECT voucher.bukti_transaksi FROM voucher JOIN bayar ON bayar.id_voucher = voucher.id_voucher WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(voucher.tanggal_voucher) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemBT,
				(SELECT SUM(bayar.credit) FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemTotal
			FROM ar 
				JOIN periode 
				ON periode.id_periode = ar.id_periode
				JOIN owner
				ON owner.kode_owner = ar.id_owner
				JOIN customer
                ON customer.kode_customer = ar.id_customer
			WHERE (ar.id_customer BETWEEN '{$kodeCusA}' AND '{$kodeCusB}') 
				AND MONTH(periode.due_date) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')
				AND ar.kode_soa = 21
			ORDER BY ar.id_customer ASC, periode.start_periode";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function saldo_cus_LA($kodeCusA, $kodeCusB, $dateA, $dateB)
	{

		$sql =
			"SELECT 
				ar.id_ar,
				ar.id_customer,
				customer.nama_customer,
				ar.id_periode,
				periode.start_periode,
				ar.kode_soa,
				ar.bukti_transaksi,
				ar.total,
				SUM(ar.sisa) as saldo
			FROM ar 
				JOIN periode 
				ON periode.id_periode = ar.id_periode
				JOIN owner
				ON owner.kode_owner = ar.id_owner
				JOIN customer
                ON customer.kode_customer = ar.id_customer
			WHERE (ar.id_customer BETWEEN '{$kodeCusA}' AND '{$kodeCusB}') 
				AND (periode.due_date < '{$dateA}')
				AND ar.kode_soa = 21
			GROUP BY ar.id_customer
			ORDER BY ar.id_customer ASC, periode.start_periode";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function print_cus_SCSF($kodeCusA, $kodeCusB, $dateA, $dateB)
	{

		$sql =
			"SELECT 
				ar.id_ar, 
				ar.id_customer,
                customer.nama_customer,
				ar.id_periode,
				ar.id_owner,
				owner.nama_owner,
                ar.kode_soa,
				DATE_ADD(DATE_ADD(LAST_DAY(periode.start_periode), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS arTgl,
				periode.start_periode, 
				ar.keterangan AS arKet, 
				ar.bukti_transaksi AS arBT, 
				ar.total AS arTotal, 
				(SELECT bayar.id_bayar FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS id_bayar,
				(SELECT bayar.id_voucher FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS id_voucher,
				(SELECT bayar.tanggal_bayar FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemTgl,
				(SELECT bayar.keterangan FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemKet, 
				(SELECT voucher.bukti_transaksi FROM voucher JOIN bayar ON bayar.id_voucher = voucher.id_voucher WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa GROUP BY ar.kode_soa) AS pemBT,
				(SELECT SUM(bayar.credit) FROM bayar WHERE bayar.id_ar = ar.id_ar AND bayar.kode_soa = ar.kode_soa AND (MONTH(bayar.tanggal_bayar) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')) GROUP BY ar.kode_soa) AS pemTotal
			FROM ar 
				JOIN periode 
				ON periode.id_periode = ar.id_periode
				JOIN owner
				ON owner.kode_owner = ar.id_owner
				JOIN customer
                ON customer.kode_customer = ar.id_customer
			WHERE (ar.id_customer BETWEEN '{$kodeCusA}' AND '{$kodeCusB}') 
				AND MONTH(periode.start_periode) BETWEEN MONTH('{$dateA}') AND MONTH('{$dateB}')
				AND ar.kode_soa = 22
			ORDER BY ar.id_customer ASC, periode.start_periode";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function saldo_cus_SCSF($kodeCusA, $kodeCusB, $dateA, $dateB)
	{

		$sql =
			"SELECT 
				ar.id_ar,
				ar.id_customer,
				customer.nama_customer,
				ar.id_owner,
				owner.nama_owner,
				ar.id_periode,
				periode.start_periode,
				ar.kode_soa,
				ar.bukti_transaksi,
				ar.total,
				SUM(ar.sisa) as saldo
			FROM ar 
				JOIN periode 
				ON periode.id_periode = ar.id_periode
				JOIN owner
				ON owner.kode_owner = ar.id_owner
				JOIN customer
                ON customer.kode_customer = ar.id_customer
			WHERE (ar.id_customer BETWEEN '{$kodeCusA}' AND '{$kodeCusB}') 
				AND (periode.start_periode < '{$dateA}')
				AND ar.kode_soa = 22
			GROUP BY ar.id_customer
			ORDER BY ar.id_customer ASC, periode.start_periode";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function print_aging_la($date)
	{
		$sql =
			"SELECT
				pa.id_ar,
				pa.id_customer,
				c.nama_customer,
				c.unit_customer,
				c.kode_virtual AS cusVirtual,
				c.alamat_customer,
				pa.id_owner,
				o.nama_owner,
				o.unit_owner,
				o.alamat_owner,
				o.kode_virtual AS ownerVirtual,
				pa.id_periode,
				p.start_periode,
				p.end_periode,
				p.due_date,
				TIMESTAMPDIFF(MONTH, (p.due_date), ('{$date}')) as selisih,
				p.amount_days,
				pa.kode_soa,
				co.coa_id,
				co.coa_name,
				pa.keterangan,
				pa.bukti_transaksi,
				pa.sisa,
				pa.total,
				pa.status,
				pa.so,
				pa.created_at,
				pa.updated_at,
				bayar.tanggal_bayar
			FROM ar pa
				JOIN customer c
				ON pa.id_customer = c.kode_customer
				JOIN periode p
				ON pa.id_periode = p.id_periode
				JOIN owner o
				ON pa.id_owner = o.kode_owner
				JOIN coa co
				ON co.id_akun = pa.kode_soa,
				bayar
			WHERE (status != 1 AND (p.due_date) <= ('{$date}') AND pa.kode_soa = 21) 
				OR (pa.status = 1 AND (bayar.tanggal_bayar) > ('{$date}')AND (p.due_date) <= ('{$date}') AND pa.id_ar = bayar.id_ar AND pa.kode_soa = 21 AND bayar.kode_soa = pa.kode_soa)
			GROUP BY pa.id_customer
			ORDER BY pa.id_customer";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function print_aging_la_cus($date)
	{
		$sql =
			"SELECT
				pa.id_ar,
				pa.id_customer,
				c.nama_customer,
				c.unit_customer,
				c.kode_virtual AS cusVirtual,
				c.alamat_customer,
				pa.id_owner,
				o.nama_owner,
				o.unit_owner,
				o.alamat_owner,
				o.kode_virtual AS ownerVirtual,
				pa.id_periode,
				p.start_periode,
				p.end_periode,
				p.due_date,
				TIMESTAMPDIFF(MONTH, (p.due_date), ('{$date}')) as selisih,
				p.amount_days,
				pa.kode_soa,
				co.coa_id,
				co.coa_name,
				pa.keterangan,
				pa.bukti_transaksi,
				pa.sisa,
				pa.total,
				pa.status,
				pa.so,
				pa.created_at,
				pa.updated_at,
				bayar.tanggal_bayar
			FROM ar pa
				JOIN customer c
				ON pa.id_customer = c.kode_customer
				JOIN periode p
				ON pa.id_periode = p.id_periode
				JOIN owner o
				ON pa.id_owner = o.kode_owner
				JOIN coa co
				ON co.id_akun = pa.kode_soa,
				bayar
			WHERE (status != 1 AND (p.due_date) <= ('{$date}') AND pa.kode_soa = 21) 
				OR (pa.status = 1 AND (bayar.tanggal_bayar) > ('{$date}') AND (p.due_date) <= ('{$date}') AND pa.id_ar = bayar.id_ar AND pa.kode_soa = 21 AND bayar.kode_soa = pa.kode_soa)
			GROUP BY pa.bukti_transaksi
			ORDER BY pa.id_customer";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function print_aging_la_bayar($date)
	{
		$sql =
			"SELECT 
				bayar.id_bayar, 
				bayar.id_ar, 
				MONTH(bayar.tanggal_bayar) - MONTH('{$date}') as monthbayar,
				('{$date}') as datekeluar,
				bayar.tanggal_bayar,
				bayar.credit, 
				bayar.debit,
				ar.id_customer,
				bayar.kode_soa,
				ar.status,
                p.due_date,
                ar.total
			FROM bayar
				JOIN ar
				ON ar.id_ar = bayar.id_ar
				JOIN periode p 
				ON ar.id_periode = p.id_periode
			WHERE 
				bayar.id_ar IN 
					(SELECT ar.id_ar 
					FROM ar 
						JOIN periode p 
						ON ar.id_periode = p.id_periode 
					WHERE (ar.status != 1 AND (p.due_date) <= ('{$date}') AND ar.kode_soa = 21)
						OR (ar.status = 1 AND (bayar.tanggal_bayar) > ('{$date}') AND (p.due_date) <= ('{$date}') AND ar.id_ar = bayar.id_ar AND ar.kode_soa = 21 AND bayar.kode_soa = ar.kode_soa)
					GROUP BY ar.bukti_transaksi)
				AND bayar.credit > 0
				AND bayar.kode_soa = 21
			GROUP BY bayar.id_bayar";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function print_aging_scsf($date)
	{
		$sql =
			"SELECT
				pa.id_ar,
				pa.id_customer,
				c.nama_customer,
				c.unit_customer,
				c.kode_virtual AS cusVirtual,
				c.alamat_customer,
				pa.id_owner,
				o.nama_owner,
				o.unit_owner,
				o.alamat_owner,
				o.kode_virtual AS ownerVirtual,
				pa.id_periode,
				p.start_periode,
				p.end_periode,
				p.due_date,
				TIMESTAMPDIFF(MONTH, (p.start_periode), ('{$date}')) as selisih,
				p.amount_days,
				pa.kode_soa,
				co.coa_id,
				co.coa_name,
				pa.keterangan,
				pa.bukti_transaksi,
				pa.sisa,
				pa.total,
				pa.status,
				pa.so,
				pa.created_at,
				pa.updated_at,
				bayar.tanggal_bayar
			FROM ar pa
				JOIN customer c
				ON pa.id_customer = c.kode_customer
				JOIN periode p
				ON pa.id_periode = p.id_periode
				JOIN owner o
				ON pa.id_owner = o.kode_owner
				JOIN coa co
				ON co.id_akun = pa.kode_soa,
				bayar
			WHERE (status != 1 AND (p.start_periode) <= ('{$date}') AND pa.kode_soa = 22) 
				OR (pa.status = 1 AND (bayar.tanggal_bayar) > ('{$date}') AND (p.start_periode) <= ('{$date}') AND pa.id_ar = bayar.id_ar AND pa.kode_soa = 22 AND bayar.kode_soa = pa.kode_soa)
			GROUP BY pa.id_owner
			ORDER BY pa.id_owner";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function print_aging_scsf_cus($date)
	{
		$sql =
			"SELECT
				pa.id_ar,
				pa.id_customer,
				c.nama_customer,
				c.unit_customer,
				c.kode_virtual AS cusVirtual,
				c.alamat_customer,
				pa.id_owner,
				o.nama_owner,
				o.unit_owner,
				o.alamat_owner,
				o.kode_virtual AS ownerVirtual,
				pa.id_periode,
				p.start_periode,
				p.end_periode,
				p.due_date,
				TIMESTAMPDIFF(MONTH, (p.start_periode), ('{$date}')) as selisih,
				p.amount_days,
				pa.kode_soa,
				co.coa_id,
				co.coa_name,
				pa.keterangan,
				pa.bukti_transaksi,
				pa.sisa,
				pa.total,
				pa.status,
				pa.so,
				pa.created_at,
				pa.updated_at,
				bayar.tanggal_bayar
			FROM ar pa
				JOIN customer c
				ON pa.id_customer = c.kode_customer
				JOIN periode p
				ON pa.id_periode = p.id_periode
				JOIN owner o
				ON pa.id_owner = o.kode_owner
				JOIN coa co
				ON co.id_akun = pa.kode_soa,
				bayar
			WHERE (status != 1 AND (p.start_periode) <= ('{$date}')  AND pa.kode_soa = 22) 
				OR (pa.status = 1 AND (bayar.tanggal_bayar) > ('{$date}') AND (p.start_periode) <= ('{$date}') AND pa.id_ar = bayar.id_ar AND pa.kode_soa = 22 AND bayar.kode_soa = pa.kode_soa)
			GROUP BY pa.bukti_transaksi
			ORDER BY pa.id_owner";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function print_aging_scsf_bayar($date)
	{
		$sql =
			"SELECT 
				bayar.id_bayar, 
				bayar.id_ar, 
				MONTH(bayar.tanggal_bayar) - MONTH('{$date}') as monthbayar,
				('{$date}') as datekeluar,
				bayar.tanggal_bayar,
				bayar.credit, 
				bayar.debit,
				ar.id_customer,
				ar.id_owner,
				bayar.kode_soa,
				ar.status,
				p.start_periode,
				ar.total
			FROM bayar
				JOIN ar
				ON ar.id_ar = bayar.id_ar
				JOIN periode p 
				ON ar.id_periode = p.id_periode
			WHERE 
				bayar.id_ar IN 
					(SELECT ar.id_ar 
					FROM ar 
						JOIN periode p 
						ON ar.id_periode = p.id_periode 
					WHERE (ar.status != 1 AND (p.start_periode) <= ('{$date}') AND ar.kode_soa = 22)
							OR (ar.status = 1 AND (bayar.tanggal_bayar) > ('{$date}') AND (p.start_periode) <= ('{$date}') AND ar.id_ar = bayar.id_ar AND ar.kode_soa = 22 AND bayar.kode_soa = ar.kode_soa)
						GROUP BY ar.bukti_transaksi)
				AND bayar.credit > 0
				AND bayar.kode_soa = 22
		GROUP BY bayar.id_bayar";

		$data = $this->db->query($sql);

		return $data->result();
	}
}

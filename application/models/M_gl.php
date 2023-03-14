<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_gl extends CI_Model
{
	private $tableName = 'gl';

	public function select_all_gl()
	{
		$sql = "SELECT * FROM gl GROUP BY gl.tanggal_transaksi";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all()
	{

		$query = $this->db->select([
			'gl.id_gl',
			'gl.bukti_transaksi',
			'gl.id_customer',
			'gl.id_owner',
			'o.nama_owner',
			'o.unit_owner',
			'o.alamat_owner',
			'o.kode_virtual AS ownerVirtual',
			'c.nama_customer',
			'c.unit_customer',
			'c.alamat_customer',
			'c.kode_virtual AS cusVirtual',
			'gl.tanggal_transaksi',
			'gl.keterangan',
			'gl.kode_soa',
			'co.coa_id',
			'co.coa_name',
			'gl.debit',
			'gl.credit',
			'gl.so',
			'gl.created_at'
		])->from("{$this->tableName} gl")
			->join("customer c", "gl.id_customer = c.kode_customer")
			->join("owner o", "gl.id_owner = o.kode_owner")
			->join("coa co", "gl.kode_soa = co.id_akun")
			->get();

		return $query->result();
	}

	public function select_by_id($id)
	{

		$query = $this->db->select([
			'gl.id_gl',
			'gl.bukti_transaksi',
			'gl.id_customer',
			'gl.id_owner',
			'o.nama_owner',
			'o.unit_owner',
			'o.alamat_owner',
			'o.kode_virtual AS ownerVirtual',
			'c.nama_customer',
			'c.unit_customer',
			'c.alamat_customer',
			'c.kode_virtual AS cusVirtual',
			'gl.tanggal_transaksi',
			'gl.keterangan',
			'gl.kode_soa',
			'co.coa_id',
			'co.coa_name',
			'gl.debit',
			'gl.credit',
			'gl.so',
			'gl.created_at'
		])->from("{$this->tableName} gl")
			->join("customer c", "gl.id_customer = c.kode_customer")
			->join("owner o", "gl.id_owner = o.kode_owner")
			->join("coa co", "gl.kode_soa = co.id_akun")
			->where('gl.id_gl', $id)
			->get();

		return $query->row();
	}

	public function select_by_bt($id)
	{

		$query = $this->db->select([
			'gl.id_gl',
			'gl.bukti_transaksi',
			'gl.id_customer',
			'gl.id_owner',
			'gl.tanggal_transaksi',
			'gl.keterangan',
			'gl.kode_soa',
			'co.coa_id',
			'co.coa_name',
			'gl.debit',
			'gl.credit',
			'gl.so',
			'gl.created_at'
		])->from("{$this->tableName} gl")
			->join("coa co", "gl.kode_soa = co.id_akun")
			->where('gl.bukti_transaksi', $id)
			->get();

		return $query->result();
	}

	public function select_filter($akun, $startDate, $endDate)
	{

		if (!empty($startDate) && !empty($endDate) && empty($akun)) {

			$sql =
				"SELECT
					gl.id_gl,
					gl.bukti_transaksi,
					gl.id_customer,
					gl.id_owner,
					o.nama_owner,
					o.unit_owner,
					o.alamat_owner,
					o.kode_virtual AS ownerVirtual,
					c.nama_customer,
					c.unit_customer,
					c.alamat_customer,
					c.kode_virtual AS cusVirtual,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					-- SUM(gl.debit) AS debit,
					-- SUM(gl.credit) AS credit,
					gl.debit,
					gl.credit,
					gl.so,
					gl.created_at
				FROM gl
					JOIN customer c
					ON gl.id_customer = c.kode_customer
					JOIN owner o
					ON gl.id_owner = o.kode_owner
					JOIN coa co
					ON gl.kode_soa = co.id_akun
				WHERE gl.tanggal_transaksi BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				-- GROUP BY gl.bukti_transaksi
				ORDER BY gl.tanggal_transaksi DESC, gl.bukti_transaksi";

			$query = $this->db->query($sql);
			return $query->result();
		} else if (!empty($akun) && !empty($startDate) && !empty($endDate)) {

			$sql =
				"SELECT
					gl.id_gl,
					gl.bukti_transaksi,
					gl.id_customer,
					gl.id_owner,
					o.nama_owner,
					o.unit_owner,
					o.alamat_owner,
					o.kode_virtual AS ownerVirtual,
					c.nama_customer,
					c.unit_customer,
					c.alamat_customer,
					c.kode_virtual AS cusVirtual,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					-- SUM(gl.debit) AS debit,
					-- SUM(gl.credit) AS credit,
					gl.debit,
					gl.credit,
					gl.so,
					gl.created_at
				FROM gl
					JOIN customer c
					ON gl.id_customer = c.kode_customer
					JOIN owner o
					ON gl.id_owner = o.kode_owner
					JOIN coa co
					ON gl.kode_soa = co.id_akun
				WHERE gl.kode_soa = '{$akun}' AND gl.tanggal_transaksi BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				-- GROUP BY gl.bukti_transaksi
				ORDER BY gl.tanggal_transaksi DESC, gl.bukti_transaksi";

			$query = $this->db->query($sql);
			return $query->result();
		} else {

			$sql =
				"SELECT
					gl.id_gl,
					gl.bukti_transaksi,
					gl.id_customer,
					gl.id_owner,
					o.nama_owner,
					o.unit_owner,
					o.alamat_owner,
					o.kode_virtual AS ownerVirtual,
					c.nama_customer,
					c.unit_customer,
					c.alamat_customer,
					c.kode_virtual AS cusVirtual,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					-- SUM(gl.debit) AS debit,
					-- SUM(gl.credit) AS credit,
					gl.debit,
					gl.credit,
					gl.so,
					gl.created_at
				FROM gl
					JOIN customer c
					ON gl.id_customer = c.kode_customer
					JOIN owner o
					ON gl.id_owner = o.kode_owner
					JOIN coa co
					ON gl.kode_soa = co.id_akun
					WHERE gl.tanggal_transaksi <= CURDATE() AND (MONTH(gl.tanggal_transaksi) = MONTH(CURDATE()) OR MONTH(gl.tanggal_transaksi) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))) AND YEAR(gl.tanggal_transaksi) = YEAR(CURDATE())
				-- GROUP BY gl.bukti_transaksi
				ORDER BY gl.tanggal_transaksi DESC, gl.bukti_transaksi";

			$query = $this->db->query($sql);
			return $query->result();
		}
	}

	public function select_filter_total($akun, $startDate, $endDate)
	{

		if (!empty($startDate) && !empty($endDate) && empty($akun)) {

			$sql =
				"SELECT
					gl.id_gl,
					gl.bukti_transaksi,
					gl.id_customer,
					gl.id_owner,
					o.nama_owner,
					o.unit_owner,
					o.alamat_owner,
					o.kode_virtual AS ownerVirtual,
					c.nama_customer,
					c.unit_customer,
					c.alamat_customer,
					c.kode_virtual AS cusVirtual,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					SUM(gl.debit) AS debit,
					SUM(gl.credit) AS credit,
					-- gl.debit,
					-- gl.credit,
					gl.so,
					gl.created_at
				FROM gl
					JOIN customer c
					ON gl.id_customer = c.kode_customer
					JOIN owner o
					ON gl.id_owner = o.kode_owner
					JOIN coa co
					ON gl.kode_soa = co.id_akun
				WHERE gl.tanggal_transaksi BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				GROUP BY gl.bukti_transaksi
				ORDER BY gl.tanggal_transaksi DESC, gl.bukti_transaksi";

			$query = $this->db->query($sql);
			return $query->result();
		} else if (!empty($akun) && !empty($startDate) && !empty($endDate)) {

			$sql =
				"SELECT
					gl.id_gl,
					gl.bukti_transaksi,
					gl.id_customer,
					gl.id_owner,
					o.nama_owner,
					o.unit_owner,
					o.alamat_owner,
					o.kode_virtual AS ownerVirtual,
					c.nama_customer,
					c.unit_customer,
					c.alamat_customer,
					c.kode_virtual AS cusVirtual,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					SUM(gl.debit) AS debit,
					SUM(gl.credit) AS credit,
					-- gl.debit,
					-- gl.credit,
					gl.so,
					gl.created_at
				FROM gl
					JOIN customer c
					ON gl.id_customer = c.kode_customer
					JOIN owner o
					ON gl.id_owner = o.kode_owner
					JOIN coa co
					ON gl.kode_soa = co.id_akun
				WHERE gl.kode_soa = '{$akun}' AND gl.tanggal_transaksi BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				GROUP BY gl.bukti_transaksi
				ORDER BY gl.tanggal_transaksi DESC, gl.bukti_transaksi";

			$query = $this->db->query($sql);
			return $query->result();
		} else {

			$sql =
				"SELECT
					gl.id_gl,
					gl.bukti_transaksi,
					gl.id_customer,
					gl.id_owner,
					o.nama_owner,
					o.unit_owner,
					o.alamat_owner,
					o.kode_virtual AS ownerVirtual,
					c.nama_customer,
					c.unit_customer,
					c.alamat_customer,
					c.kode_virtual AS cusVirtual,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					SUM(gl.debit) AS debit,
					SUM(gl.credit) AS credit,
					-- gl.debit,
					-- gl.credit,
					gl.so,
					gl.created_at
				FROM gl
					JOIN customer c
					ON gl.id_customer = c.kode_customer
					JOIN owner o
					ON gl.id_owner = o.kode_owner
					JOIN coa co
					ON gl.kode_soa = co.id_akun
				WHERE gl.tanggal_transaksi <= CURDATE() AND (MONTH(gl.tanggal_transaksi) = MONTH(CURDATE()) OR MONTH(gl.tanggal_transaksi) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)))
				GROUP BY gl.bukti_transaksi
				ORDER BY gl.tanggal_transaksi DESC, gl.bukti_transaksi";

			$query = $this->db->query($sql);
			return $query->result();
		}
	}

	public function select_bayar_ar($date, $bukti)
	{

		$query =
			"SELECT
				gl.id_gl AS id,
				gl.bukti_transaksi,
				gl.tanggal_transaksi,
				bayar.id_ar,
				bayar.tanggal_bayar,
				ar.bukti_transaksi
			FROM gl,
				bayar
			JOIN ar
			ON bayar.id_ar = ar.id_ar
			WHERE
				gl.bukti_transaksi = '{$bukti}' AND
				(CAST(gl.tanggal_transaksi AS DATE) = CAST('{$date}' AS DATE))";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_vendor_ar($date, $bukti)
	{

		$query =
			"SELECT
				gl.id_gl AS id,
				gl.bukti_transaksi,
				gl.tanggal_transaksi,
				vendor.id_voucher,
				vendor.tanggal_transaksi
			FROM gl,
				vendor
			WHERE
				gl.bukti_transaksi = '{$bukti}' AND
				(CAST(gl.tanggal_transaksi AS DATE) = CAST('{$date}' AS DATE))";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_bayar_vou($date, $bukti)
	{

		$query =
			"SELECT
				gl.id_gl AS id,
				gl.bukti_transaksi,
				gl.tanggal_transaksi,
				gl.keterangan,
				bayar.id_ar,
				bayar.tanggal_bayar,
				voucher.id_voucher,
				voucher.keterangan
			FROM gl,
				bayar
			JOIN voucher
			ON bayar.id_voucher = voucher.id_voucher
			WHERE
				gl.bukti_transaksi = '{$bukti}'
				AND (CAST(gl.tanggal_transaksi AS DATE) = CAST('{$date}' AS DATE))
				AND gl.keterangan != voucher.keterangan
			GROUP BY
				gl.id_gl";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_vou($date, $bukti, $ket)
	{

		$query =
			"SELECT
				gl.id_gl AS id,
				gl.bukti_transaksi,
				gl.tanggal_transaksi,
				gl.keterangan,
				voucher.id_voucher,
				voucher.bukti_transaksi,
				voucher.tanggal_voucher,
				voucher.keterangan
			FROM gl,
				voucher
			WHERE
				gl.bukti_transaksi = '{$bukti}'
				AND (CAST(gl.tanggal_transaksi AS DATE) = CAST('{$date}' AS DATE))
				AND gl.keterangan = '{$ket}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function get_last_id($dt)
	{

		$currentNumber = $this->db->query('SELECT get_increment_gl_id(?, ?) as maxNumber', [$dt->format('Y'), $dt->format('m')]);

		return $currentNumber->row();
	}

	public function insert($post)
	{

		$code = json_decode($_POST["code"]);
		$akun = json_decode($_POST["akun"]);
		$keterangan = json_decode($_POST["keterangan"]);
		$debit = json_decode($_POST["debit"]);
		$kredit = json_decode($_POST["kredit"]);

		for ($i = 0; $i < count($code); $i++) {

			$CoA = $this->M_coa->select_by_coa($akun[$i]);

			$data = array(
				'bukti_transaksi' => $code[$i],
				'id_customer' => 'T-10A',
				'id_owner' => '10A',
				'tanggal_transaksi' => $post['date'],
				'keterangan' => $keterangan[$i],
				'kode_soa' => $CoA->id_akun,
				'debit' => $debit[$i],
				'credit' => $kredit[$i],
				'so' => 1,
				'cash' => 0
			);
			$this->db->insert($this->tableName, $data);
		}
		return $this->db->affected_rows();
	}

	public function insert_vou($post)
	{

		$code = json_decode($_POST["code"]);
		$akun = json_decode($_POST["akun"]);
		$keterangan = json_decode($_POST["keterangan"]);
		$debit = json_decode($_POST["debit"]);
		$kredit = json_decode($_POST["kredit"]);

		for ($i = 0; $i < count($code); $i++) {

			if ($akun[$i] != NULL) {
				$CoA = $this->M_coa->select_by_coa($akun[$i]);

				$data = array(
					'bukti_transaksi' => $code[$i],
					'id_customer' => 'T-10A',
					'id_owner' => '10A',
					'tanggal_transaksi' => $post['date'],
					'keterangan' => $keterangan[$i],
					'kode_soa' => $CoA->id_akun,
					'debit' => $debit[$i],
					'credit' => $kredit[$i],
					'so' => 1,
					'cash' => 1
				);
				$this->db->insert($this->tableName, $data);
			}
		}
		return $this->db->affected_rows();
	}

	public function insert_mtd($params)
	{

		$data = [
			'kode_soa' => $params['mtd_coa'],
			'tanggal_mtd' => $params['mtd_year'] . '-' . $params['mtd_month'] . '-01',
			'total_mtd' => $params['mtd_total']
		];
		$this->db->insert('mtd_budget', $data);

		return $this->db->affected_rows();
	}

	public function insert_ytd($params)
	{

		$data = [
			'kode_soa' => $params['ytd_coa'],
			'tanggal_ytd' => $params['ytd_year'] . '-01-01',
			'total_ytd' => $params['ytd_total']
		];
		$this->db->insert('ytd_budget', $data);

		return $this->db->affected_rows();
	}

	public function insert2($params)
	{

		$this->db->insert($this->tableName, $params);

		return $this->db->insert_id();
	}

	public function insert3($params)
	{

		$this->db->insert('retained', $params);

		return $this->db->insert_id();
	}

	public function insert_voucher($post)
	{

		$id = json_decode($_POST["id"]);
		$code = json_decode($_POST["bukti_transaksi"]);
		$kodeOwner = json_decode($_POST["kodeOwner"]);
		$akun = json_decode($_POST["akun"]);
		$debit = json_decode($_POST["debit"]);
		$credit = json_decode($_POST["credit"]);
		$keterangan = json_decode($_POST["keterangan"]);

		for ($i = 0; $i < count($id); $i++) {

			$ownerCus = $this->M_owner->select_by_id($kodeOwner[$i]);
			$ar = $this->M_ar->select_by_id($id[$i]);
			$CoA = $this->M_coa->select_by_coa($akun[$i]);

			if ($akun[$i] != NULL) {
				if ($CoA->id_akun == 21) {
					$data = array(
						'bukti_transaksi' => $code[$i],
						'id_customer' => $ownerCus->customer,
						'id_owner' => $kodeOwner[$i],
						'tanggal_transaksi' => $post['date'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => $CoA->id_akun,
						'debit' => $debit[$i],
						'credit' => $credit[$i],
						'so' => 1,
						'cash' => 1
					);
					$this->db->insert($this->tableName, $data);
				} else if ($CoA->id_akun == 22) {
					$data = array(
						'bukti_transaksi' => $code[$i],
						'id_customer' => $ownerCus->customer,
						'id_owner' => $kodeOwner[$i],
						'tanggal_transaksi' => $post['date'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => $CoA->id_akun,
						'debit' => $debit[$i],
						'credit' => $credit[$i],
						'so' => 1,
						'cash' => 1
					);
					$this->db->insert($this->tableName, $data);
				} else {
					$data = array(
						'bukti_transaksi' => $code[$i],
						'id_customer' => $ownerCus->customer,
						'id_owner' => $kodeOwner[$i],
						'tanggal_transaksi' => $post['date'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => $CoA->id_akun,
						'debit' => $debit[$i],
						'credit' => $credit[$i],
						'so' => 1,
						'cash' => 1
					);
					$this->db->insert($this->tableName, $data);
				}
			}
		}
		return $this->db->affected_rows();
	}

	public function insert_titipan($post)
	{

		$id = json_decode($_POST["id"]);
		$code = json_decode($_POST["bukti_transaksi"]);
		$kodeOwner = json_decode($_POST["kodeOwner"]);
		$akun = json_decode($_POST["akun"]);
		$debit = json_decode($_POST["debit"]);
		$credit = json_decode($_POST["credit"]);
		$keterangan = json_decode($_POST["keterangan"]);

		for ($i = 0; $i < count($id); $i++) {

			$ownerCus = $this->M_owner->select_by_id($kodeOwner[$i]);
			$ar = $this->M_ar->select_by_id($id[$i]);
			$CoA = $this->M_coa->select_by_coa($akun[$i]);

			if ($akun[$i] != NULL) {
				if ($CoA->id_akun == 21) {
					$data = array(
						'bukti_transaksi' => $code[$i],
						'id_customer' => $ownerCus->customer,
						'id_owner' => $kodeOwner[$i],
						'tanggal_transaksi' => $post['date'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => $CoA->id_akun,
						'debit' => $debit[$i],
						'credit' => $credit[$i],
						'so' => 1,
						'cash' => 1
					);
					$this->db->insert($this->tableName, $data);
				} else if ($CoA->id_akun == 22) {
					$data = array(
						'bukti_transaksi' => $code[$i],
						'id_customer' => $ownerCus->customer,
						'id_owner' => $kodeOwner[$i],
						'tanggal_transaksi' => $post['date'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => $CoA->id_akun,
						'debit' => $debit[$i],
						'credit' => $credit[$i],
						'so' => 1,
						'cash' => 1
					);
					$this->db->insert($this->tableName, $data);
				} else if ($CoA->parent == 1 || $CoA->parent == 3 || $CoA->parent == 4 || $CoA->parent == 5  || $CoA->parent == 7) {
					$data = array(
						'bukti_transaksi' => $code[$i],
						'id_customer' => $ownerCus->customer,
						'id_owner' => $kodeOwner[$i],
						'tanggal_transaksi' => $post['date'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => 190,
						'debit' => $debit[$i],
						'credit' => $credit[$i],
						'so' => 1,
						'cash' => 1
					);
					$this->db->insert($this->tableName, $data);
				} else {
					$data = array(
						'bukti_transaksi' => $code[$i],
						'id_customer' => $ownerCus->customer,
						'id_owner' => $kodeOwner[$i],
						'tanggal_transaksi' => $post['date'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => $CoA->id_akun,
						'debit' => $debit[$i],
						'credit' => $credit[$i],
						'so' => 1,
						'cash' => 1
					);
					$this->db->insert($this->tableName, $data);
				}
			}
		}
		return $this->db->affected_rows();
	}

	public function delete($id)
	{

		$where = ['id_gl' => $id];
		$this->db->delete($this->tableName, $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function delete_all($id)
	{

		$this->db->where_in('id_gl', $id);
		$this->db->delete($this->tableName);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function check_bill($id_customer, $periode, $coa)
	{

		$data = $this->db->where([
			'id_customer' => $id_customer,
			'tanggal_transaksi' => $periode,
			'kode_soa' => $coa
		])
			->count_all_results('gl');
		return $data;
	}

	public function check_bill_id($id_gl)
	{
		$data = $this->db->where([
			'bukti_transaksi' => $id_gl
		])
			->count_all_results('gl');
		return $data;
	}

	public function update($params)
	{
		if ($params['giro'] == 1 || $params['giro'] == 2) {
			$data = array(
				'kode_soa' => $params['bank'],
				'keterangan' => $params['keterangan'],
				'tanggal_transaksi' => $params['vouDate'],
				'debit' => $params['vouTotal']
			);

			$where = array('id_gl' => $params['idgl']);
			$this->db->update($this->tableName, $data, $where);
		} else {
			$data = array(
				'kode_soa' => $params['bank'],
				'keterangan' => $params['keterangan'],
				'tanggal_transaksi' => $params['vouDate'],
				'credit' => $params['vouTotal']
			);

			$where = array('id_gl' => $params['idgl']);
			$this->db->update($this->tableName, $data, $where);
		}
		return $this->db->affected_rows();
	}

	public function bayar_update($post)
	{

		for ($i = 0; $i < count($post['idv']); $i++) {
			$data = array(
				'bukti_transaksi' => $post['id'],
				'tanggal_transaksi' => $post['vouDate'],
				'keterangan' => $post['ket'][$i],
				'kode_soa' => $post['coa'][$i],
				'debit' => $post['debit'][$i],
				'credit' => $post['credit'][$i]
			);

			$where = array('id_gl' => $post['idg'][$i]);
			$this->db->update($this->tableName, $data, $where);
		}

		return $this->db->affected_rows();
	}

	public function update_gl($post)
	{
		for ($i = 0; $i < count($post['idg']); $i++) {
			$data = array(
				'tanggal_transaksi' => $post['date'],
				'keterangan' => $post['ket'][$i],
				'kode_soa' => $post['coa'][$i],
				'debit' => $post['debit'][$i],
				'credit' => $post['credit'][$i]
			);

			$where = array('id_gl' => $post['idg'][$i]);
			$this->db->update($this->tableName, $data, $where);
		}

		return $this->db->affected_rows();
	}

	public function vendor_update($post)
	{
		for ($i = 0; $i < count($post['idv']); $i++) {
			$data = array(
				'tanggal_transaksi' => $post['vouDate'],
				'keterangan' => $post['ket'][$i],
				'kode_soa' => $post['coa'][$i],
				'debit' => $post['debit'][$i],
				'credit' => $post['credit'][$i]
			);

			$where = array('id_gl' => $post['idg'][$i]);
			$this->db->update($this->tableName, $data, $where);
		}

		return $this->db->affected_rows();
	}

	public function update_bayar($id)
	{

		$dataBayar = $this->M_bayar->select_by_id($id);
		$dataVendor = $this->M_voucher->select_all_vendor_voucher($id);

		foreach ($dataBayar as $bayar) {

			$dataGLAR = $this->M_gl->select_bayar_ar($bayar->tanggal_bayar, $bayar->bukti_transaksi);

			foreach ($dataGLAR as $glAR) {
				$this->M_gl->delete_all($glAR->id);
			}
		}

		foreach ($dataVendor as $vendor) {

			$dataGLAR = $this->M_gl->select_bayar_ar($vendor->tanggal_transaksi, $vendor->id_voucher);

			foreach ($dataGLAR as $glAR) {
				$this->M_gl->delete_all($glAR->id);
			}
		}
	}

	public function update_vendor($id)
	{
		$where = ['bukti_transaksi' => $id];
		$this->db->delete($this->tableName, $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function update_voucher($id)
	{

		$where = ['bukti_transaksi' => $id];
		$this->db->delete($this->tableName, $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function print($coaA, $coaB, $dateA, $dateB)
	{

		$query =
			"SELECT
				t1.id_gl,
				t1.id_customer,
				t1.id_owner,
				t1.kode_soa,
				t1.coa_id,
				t1.coa_name,
				t1.bukti_transaksi,
				t1.tanggal_transaksi,
				t1.keterangan,
				t1.debit,
				t1.credit,
				t1.so,
				t1.created_at,
				(SELECT (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE (gl.kode_soa BETWEEN '{$coaA}' AND '{$coaB}') AND gl.tanggal_transaksi < '{$dateA}' AND gl.so = 1) AS saldoAwal,
			CASE WHEN
				t1.kode_soa<>t2.kode_soa
			THEN
				@saldo := t1.debit -t1.credit
			ELSE
				@saldo := @saldo + t1.debit - t1.credit
			END
				saldo
			FROM
				(SELECT
					gl.id_gl,
					gl.id_customer,
					gl.id_owner,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					gl.bukti_transaksi,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.debit,
					gl.credit,
					gl.so,
					gl.created_at,
					@baris1 := @baris1 + 1 baris
				FROM gl
					JOIN coa co
					ON co.id_akun = gl.kode_soa,
					(SELECT @baris1 := 0) tx
				WHERE
					(gl.kode_soa BETWEEN '{$coaA}' AND '{$coaB}') AND (gl.so = 1)
				GROUP BY 
					gl.kode_soa
				ORDER BY
					gl.kode_soa, gl.tanggal_transaksi) t1
				LEFT JOIN
					(SELECT
						gl.kode_soa,
						@baris2 := @baris2+1 baris
					FROM
						gl,
						(SELECT @baris2 := 1) tx
					WHERE
						(gl.kode_soa BETWEEN '{$coaA}' AND '{$coaB}') AND (gl.so = 1)
					ORDER BY
						gl.kode_soa) t2
					ON t1.baris=t2.baris 
					JOIN 
						(SELECT @saldo := (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE (gl.kode_soa BETWEEN '{$coaA}' AND '{$coaB}') AND gl.tanggal_transaksi < '{$dateA}' AND gl.so = 1) t3
			ORDER BY
				t1.kode_soa, t1.tanggal_transaksi, t1.bukti_transaksi";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function print_tgl($coaA, $coaB, $dateA, $dateB)
	{

		$query =
			"SELECT
				t1.id_gl,
				t1.id_customer,
				t1.id_owner,
				t1.kode_soa,
				t1.coa_id,
				t1.coa_name,
				t1.bukti_transaksi,
				t1.tanggal_transaksi,
				t1.keterangan,
				t1.debit,
				t1.credit,
				t1.so,
				t1.created_at,
				(SELECT (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE gl.tanggal_transaksi < '{$dateA}' AND gl.so = 1) AS saldoAwal,
			CASE WHEN
				t1.kode_soa<>t2.kode_soa
			THEN
				@saldo := t1.debit -t1.credit
			ELSE
				@saldo := @saldo + t1.debit - t1.credit
			END
				saldo
			FROM
				(SELECT
					gl.id_gl,
					gl.id_customer,
					gl.id_owner,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					gl.bukti_transaksi,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.debit,
					gl.credit,
					gl.so,
					gl.created_at,
					@baris1 := @baris1 + 1 baris
				FROM gl
					JOIN coa co
					ON co.id_akun = gl.kode_soa,
					(SELECT @baris1 := 0) tx
				WHERE
					(gl.kode_soa BETWEEN '{$coaA}' AND '{$coaB}') AND gl.tanggal_transaksi BETWEEN CAST('{$dateA}' AS DATE) AND CAST('{$dateB}' AS DATE) AND (gl.so = 1)
				GROUP BY 
					gl.tanggal_transaksi
				ORDER BY
					co.coa_id, gl.tanggal_transaksi) t1
				LEFT JOIN
					(SELECT
						gl.kode_soa,
						@baris2 := @baris2+1 baris
					FROM
						gl,
						(SELECT @baris2 := 1) tx
					WHERE
						(gl.kode_soa BETWEEN '{$coaA}' AND '{$coaB}') AND gl.tanggal_transaksi BETWEEN CAST('{$dateA}' AS DATE) AND CAST('{$dateB}' AS DATE) AND (gl.so = 1)
					ORDER BY
						gl.kode_soa) t2
					ON t1.baris=t2.baris 
					JOIN 
						(SELECT @saldo := (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE (gl.kode_soa BETWEEN '{$coaA}' AND '{$coaB}') AND gl.tanggal_transaksi < '{$dateA}' AND gl.so = 1) t3
			ORDER BY
				t1.kode_soa, t1.tanggal_transaksi, t1.bukti_transaksi";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function printCus($coaA, $coaB, $dateA, $dateB)
	{

		$query =
			"SELECT
				t1.id_gl,
				t1.id_customer,
				t1.id_owner,
				t1.kode_soa,
				t1.coa_id,
				t1.coa_name,
				t1.bukti_transaksi,
				t1.tanggal_transaksi,
				t1.keterangan,
				t1.debit,
				t1.credit,
				t1.so,
				t1.created_at,
				(SELECT (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE gl.tanggal_transaksi < '{$dateA}' AND gl.so = 1) AS saldoAwal,
			CASE WHEN
				t1.kode_soa<>t2.kode_soa
			THEN
				@saldo := t1.debit -t1.credit
			ELSE
				@saldo := @saldo + t1.debit - t1.credit
			END
				saldo
			FROM
				(SELECT
					gl.id_gl,
					gl.id_customer,
					gl.id_owner,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					gl.bukti_transaksi,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.debit,
					gl.credit,
					gl.so,
					gl.created_at,
					@baris1 := @baris1 + 1 baris
				FROM gl
					JOIN coa co
					ON co.id_akun = gl.kode_soa,
					(SELECT @baris1 := 0) tx
				WHERE
					(gl.kode_soa BETWEEN '{$coaA}' AND '{$coaB}') AND (gl.tanggal_transaksi) BETWEEN CAST('{$dateA}' AS DATE) AND CAST('{$dateB}' AS DATE) AND (gl.so = 1)
				ORDER BY 
					co.coa_id, gl.tanggal_transaksi, gl.bukti_transaksi) t1
				LEFT JOIN
					(SELECT
						gl.kode_soa,
						@baris2 := @baris2+1 baris
					FROM
						gl,
						(SELECT @baris2 := 1) tx
					WHERE
						(gl.kode_soa BETWEEN '{$coaA}' AND '{$coaB}') AND gl.tanggal_transaksi BETWEEN CAST('{$dateA}' AS DATE) AND CAST('{$dateB}' AS DATE) AND (gl.so = 1)
					ORDER BY
						gl.kode_soa, gl.tanggal_transaksi, gl.bukti_transaksi) t2
					ON t1.baris=t2.baris 
					JOIN 
						(SELECT @saldo := (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE (gl.kode_soa BETWEEN '{$coaA}' AND '{$coaB}') AND gl.tanggal_transaksi < '{$dateA}' AND gl.so = 1) t3
			ORDER BY
				t1.kode_soa, t1.tanggal_transaksi, t1.bukti_transaksi";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function printBank($coa, $date)
	{

		$query =
			"SELECT
				t1.id_gl,
				t1.id_customer,
				t1.id_owner,
				t1.kode_soa,
				t1.coa_id,
				t1.coa_name,
				t1.bukti_transaksi,
				t1.tanggal_transaksi,
				t1.keterangan,
				t1.debit,
				t1.credit,
				t1.so,
				t1.created_at,
				(SELECT (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE gl.kode_soa = '{$coa}' AND MONTH(gl.tanggal_transaksi) < MONTH('{$date}') AND gl.so = 1) AS saldoAwal,
			CASE WHEN
				t1.kode_soa<>t2.kode_soa
			THEN
				@saldo := t1.debit -t1.credit
			ELSE
				@saldo := @saldo + t1.debit - t1.credit
			END
				saldo
			FROM
				(SELECT
					gl.id_gl,
					gl.id_customer,
					gl.id_owner,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					gl.bukti_transaksi,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.debit,
					gl.credit,
					gl.so,
					gl.created_at,
					@baris1 := @baris1 + 1 baris
				FROM gl
					JOIN coa co
					ON co.id_akun = gl.kode_soa,
					(SELECT @baris1 := 0) tx
				WHERE
					(gl.kode_soa = '{$coa}') AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}') AND YEAR(gl.tanggal_transaksi) =  YEAR('{$date}') AND (gl.so = 1)
				GROUP BY 
					gl.kode_soa) t1
				LEFT JOIN
					(SELECT
						gl.kode_soa,
						@baris2 := @baris2+1 baris
					FROM
						gl,
						(SELECT @baris2 := 1) tx
					WHERE
						(gl.kode_soa = '{$coa}') AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}') AND YEAR(gl.tanggal_transaksi) =  YEAR('{$date}') AND (gl.so = 1)
					ORDER BY
						gl.kode_soa) t2
					ON t1.baris=t2.baris 
					JOIN 
						(SELECT @saldo := (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE gl.kode_soa = '{$coa}' AND MONTH(gl.tanggal_transaksi) < MONTH('{$date}') AND gl.so = 1) t3";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function print_tgl_bank($coa, $date)
	{

		$query =
			"SELECT
				t1.id_gl,
				t1.id_customer,
				t1.id_owner,
				t1.kode_soa,
				t1.coa_id,
				t1.coa_name,
				t1.bukti_transaksi,
				t1.tanggal_transaksi,
				t1.keterangan,
				t1.debit,
				t1.credit,
				t1.so,
				t1.created_at,
				(SELECT (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE gl.kode_soa = '{$coa}' AND MONTH(gl.tanggal_transaksi) < MONTH('{$date}') AND gl.so = 1) AS saldoAwal,
			CASE WHEN
				t1.kode_soa<>t2.kode_soa
			THEN
				@saldo := t1.debit -t1.credit
			ELSE
				@saldo := @saldo + t1.debit - t1.credit
			END
				saldo
			FROM
				(SELECT
					gl.id_gl,
					gl.id_customer,
					gl.id_owner,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					gl.bukti_transaksi,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.debit,
					gl.credit,
					gl.so,
					gl.created_at,
					@baris1 := @baris1 + 1 baris
				FROM gl
					JOIN coa co
					ON co.id_akun = gl.kode_soa,
					(SELECT @baris1 := 0) tx
				WHERE
					(gl.kode_soa = '{$coa}') AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}') AND YEAR(gl.tanggal_transaksi) =  YEAR('{$date}') AND (gl.so = 1)
				GROUP BY 
					gl.tanggal_transaksi) t1
				LEFT JOIN
					(SELECT
						gl.kode_soa,
						@baris2 := @baris2+1 baris
					FROM
						gl,
						(SELECT @baris2 := 1) tx
					WHERE
						(gl.kode_soa = '{$coa}') AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}') AND YEAR(gl.tanggal_transaksi) =  YEAR('{$date}') AND (gl.so = 1)
					ORDER BY
						gl.kode_soa) t2
					ON t1.baris=t2.baris 
					JOIN 
						(SELECT @saldo := (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE gl.kode_soa = '{$coa}' AND MONTH(gl.tanggal_transaksi) < MONTH('{$date}') AND gl.so = 1) t3";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function printCusBank($coa, $date)
	{

		$query =
			"SELECT
				t1.id_gl,
				t1.id_customer,
				t1.id_owner,
				t1.kode_soa,
				t1.coa_id,
				t1.coa_name,
				t1.bukti_transaksi,
				t1.tanggal_transaksi,
				t1.keterangan,
				t1.debit,
				t1.credit,
				t1.so,
				t1.created_at,
				(SELECT (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE gl.kode_soa = '{$coa}' AND MONTH(gl.tanggal_transaksi) < MONTH('{$date}') AND gl.so = 1) AS saldoAwal,
			CASE WHEN
				t1.kode_soa<>t2.kode_soa
			THEN
				@saldo := t1.debit -t1.credit
			ELSE
				@saldo := @saldo + t1.debit - t1.credit
			END
				saldo
			FROM
				(SELECT
					gl.id_gl,
					gl.id_customer,
					gl.id_owner,
					gl.kode_soa,
					co.coa_id,
					co.coa_name,
					gl.bukti_transaksi,
					gl.tanggal_transaksi,
					gl.keterangan,
					gl.debit,
					gl.credit,
					gl.so,
					gl.created_at,
					@baris1 := @baris1 + 1 baris
				FROM gl
					JOIN coa co
					ON co.id_akun = gl.kode_soa,
					(SELECT @baris1 := 0) tx
				WHERE
					(gl.kode_soa = '{$coa}') AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}') AND YEAR(gl.tanggal_transaksi) =  YEAR('{$date}') AND (gl.so = 1)
				ORDER BY 
					gl.tanggal_transaksi, gl.bukti_transaksi) t1
				LEFT JOIN
					(SELECT
						gl.kode_soa,
						@baris2 := @baris2+1 baris
					FROM
						gl,
						(SELECT @baris2 := 1) tx
					WHERE
						(gl.kode_soa = '{$coa}') AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}') AND YEAR(gl.tanggal_transaksi) =  YEAR('{$date}') AND (gl.so = 1)
					ORDER BY
						gl.kode_soa) t2
					ON t1.baris=t2.baris 
					JOIN 
						(SELECT @saldo := (sum(gl.debit) - sum(gl.credit)) FROM gl WHERE gl.kode_soa = '{$coa}' AND MONTH(gl.tanggal_transaksi) < MONTH('{$date}') AND gl.so = 1) t3";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function neraca($date)
	{

		$query =
			"SELECT 
				gl.tanggal_transaksi, 
				SUM(gl.debit) AS debit, 
				SUM(gl.credit) AS credit, 
				SUM(gl.debit) - SUM(gl.credit) AS saldo,
				gl.kode_soa,
				gl.so,
				coa.coa_id,
				coa.parent,
				coa.parent_two,
				coa.coa_name,
				coa.jurnal_tipe, 
				MONTH('{$date}') as month,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE (g.tanggal_transaksi) <= LAST_DAY(DATE_SUB(('{$date}'), INTERVAL 1 MONTH)) AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoLast
			FROM gl 
				JOIN coa 
				on gl.kode_soa = coa.id_akun 
			WHERE (gl.tanggal_transaksi) <= ('{$date}')
				AND (coa.jurnal_tipe = 1 OR coa.jurnal_tipe = 4)
				AND gl.so = 1
			GROUP BY gl.kode_soa
			ORDER BY coa.coa_id ASC";


		$data = $this->db->query($query);

		return $data->result();
	}

	public function neracaTwo($date)
	{

		$query =
			"SELECT 
				gl.tanggal_transaksi, 
				SUM(gl.debit) AS debit, 
				SUM(gl.credit) AS credit, 
				SUM(gl.debit) - SUM(gl.credit) AS saldo,
				gl.kode_soa,
				gl.so,
				coa.coa_id,
				coa.parent_detail,
				coa.parent_detail_name,
				coa.parent_two,
				coa.coa_name,
				coa.jurnal_tipe,
				MONTH('{$date}') as month,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa co on g.kode_soa = co.id_akun WHERE (g.tanggal_transaksi) <= LAST_DAY(DATE_SUB(('{$date}'), INTERVAL 1 MONTH)) AND coa.parent_detail = co.parent_detail AND g.so = 1) saldoLast
			FROM gl 
				JOIN coa 
				on gl.kode_soa = coa.id_akun 
			WHERE (gl.tanggal_transaksi) <= ('{$date}')
				AND (coa.jurnal_tipe = 1 OR coa.jurnal_tipe = 4)
				AND gl.so = 1
			GROUP BY coa.parent_detail
			ORDER BY coa.coa_id ASC";


		$data = $this->db->query($query);

		return $data->result();
	}

	public function jurnalNeraca($date)
	{

		$query =
			"SELECT 
				gl.tanggal_transaksi, 
				SUM(gl.debit) AS debit, 
				SUM(gl.credit) AS credit,
				gl.kode_soa,
				gl.so,
				coa.coa_id,
				coa.parent,
				coa.parent_two,
				coa.coa_name,
				coa.jurnal_tipe,
				jt.type_name,
				MONTH('{$date}') as month,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND (g.tanggal_transaksi) <= ('{$date}')) AS retainedBeban,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND (g.tanggal_transaksi) <= LAST_DAY(DATE_SUB(('{$date}'), INTERVAL 1 MONTH))) AS retainedBebanLast,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND (g.tanggal_transaksi) <= ('{$date}')) AS retainedPendapatan,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND (g.tanggal_transaksi) <= LAST_DAY(DATE_SUB(('{$date}'), INTERVAL 1 MONTH))) AS retainedPendapatanLast,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND YEAR(g.tanggal_transaksi) <= YEAR(DATE_SUB(('{$date}'), INTERVAL 1 YEAR))) AS retainedBebanLastYear,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND YEAR(g.tanggal_transaksi) <= YEAR(DATE_SUB(('{$date}'), INTERVAL 1 YEAR))) AS retainedPendapatanLastYear,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE g.kode_soa = 272 AND g.so =  1 AND YEAR(g.tanggal_transaksi) <= YEAR(DATE_SUB(('{$date}'), INTERVAL 1 YEAR))) AS surplusLastYear,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 1 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbJan,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 1 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpJan,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 2 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbFeb,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 2 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpFeb,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 3 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbMar,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 3 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpMar,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 4 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbApr,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 4 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpApr,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 5 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbMei,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 5 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpMei,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 6 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbJun,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 6 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpJun,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 7 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbJul,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 7 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpJul,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 8 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbAug,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 8 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpAug,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 9 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbSep,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 9 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpSep,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 10 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbOct,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 10 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpOct,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 11 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbNov,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 11 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpNov,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 2 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 12 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rbDes,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g JOIN coa ON coa.id_akun = g.kode_soa WHERE coa.jurnal_tipe = 3 AND g.so =  1 AND MONTH(g.tanggal_transaksi) = 12 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}')) AS rpDes
			FROM gl 
				JOIN coa 
				on gl.kode_soa = coa.id_akun
				JOIN coa_type jt
				ON coa.jurnal_tipe = jt.coa_type_id
			WHERE (gl.tanggal_transaksi) <= ('{$date}')
				AND (coa.jurnal_tipe = 1 OR coa.jurnal_tipe = 4)
				AND gl.so = 1
			GROUP BY coa.jurnal_tipe
			ORDER BY coa.coa_id ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function labaRugi($date)
	{

		$query =
			"SELECT
				gl.tanggal_transaksi,
				(SELECT SUM(g.debit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND (g.so = 1) AND g.kode_soa = gl.kode_soa) as debit,
				(SELECT SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND (g.so = 1) AND g.kode_soa = gl.kode_soa) as credit,
				(SELECT (SUM(g.debit) - SUM(g.credit)) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND (g.so = 1) AND g.kode_soa = gl.kode_soa) as saldo,
				gl.kode_soa, 
				gl.so,
				coa.coa_id,
				coa.parent,
				coa.coa_name,
				coa.jurnal_tipe,
				MONTH('{$date}') as month,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH(DATE_SUB(('{$date}'), INTERVAL 1 MONTH)) AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoLast,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH(DATE_SUB(('{$date}'), INTERVAL 1 MONTH)) AND YEAR(g.tanggal_transaksi) = YEAR(DATE_SUB(('{$date}'), INTERVAL 1 YEAR)) AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoLast12
			FROM gl 
				JOIN coa
				on gl.kode_soa = coa.id_akun 
			WHERE (coa.jurnal_tipe = 2 OR coa.jurnal_tipe = 3)
				AND gl.so = 1
			GROUP BY gl.kode_soa
			ORDER BY coa.coa_id ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function jurnalLabaRugi($date)
	{

		$query =
			"SELECT 
				gl.tanggal_transaksi, 
				SUM(gl.debit) AS debit, 
				SUM(gl.credit) AS credit, 
				SUM(gl.debit) - SUM(gl.credit) AS saldo, 
				gl.kode_soa,
				gl.so,
				coa.coa_id,
				coa.parent,
				coa.coa_name,
				coa.jurnal_tipe,
				jt.type_name
			FROM gl 
				JOIN coa 
				on gl.kode_soa = coa.id_akun
				JOIN coa_type jt
				ON coa.jurnal_tipe = jt.coa_type_id
			WHERE MONTH(gl.tanggal_transaksi) = MONTH('{$date}') AND YEAR(gl.tanggal_transaksi) =  YEAR('{$date}') 
				AND (coa.jurnal_tipe = 2 OR coa.jurnal_tipe = 3)
				AND gl.so = 1
			GROUP BY coa.jurnal_tipe
			ORDER BY coa.coa_id ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function parentCoA($date)
	{

		$query =
			"SELECT 
				coa.parent, 
				coa.coa_id, 
				coa.coa_name, 
				gl.kode_soa, 
				coa.jurnal_tipe,
				gl.tanggal_transaksi,
				coa.parent_name,
				jt.type_name
			FROM gl 
				JOIN coa 
				ON coa.id_akun = gl.kode_soa
				JOIN coa_type jt
				ON coa.jurnal_tipe = jt.coa_type_id
			WHERE YEAR(gl.tanggal_transaksi) = YEAR('{$date}')
					OR gl.kode_soa = 272
					OR gl.kode_soa = 271 
			GROUP BY coa.parent
			ORDER BY coa.coa_id ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function parentCoANeraca($date)
	{

		$query =
			"SELECT 
				coa.parent, 
				coa.coa_id, 
				coa.coa_name, 
				gl.kode_soa, 
				coa.jurnal_tipe,
				gl.tanggal_transaksi,
				coa.parent_name,
				jt.type_name
			FROM gl 
				JOIN coa 
				ON coa.id_akun = gl.kode_soa
				JOIN coa_type jt
				ON coa.jurnal_tipe = jt.coa_type_id
			WHERE YEAR(gl.tanggal_transaksi) <= YEAR('{$date}')
			GROUP BY coa.parent
			ORDER BY coa.coa_id ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function parentTwoCoA($date)
	{

		$query =
			"SELECT 
				coa.parent, 
				coa.parent_two, 
				coa.coa_id, 
				coa.coa_name, 
				gl.kode_soa, 
				coa.jurnal_tipe,
				gl.tanggal_transaksi,
				coa.parent_name,
				coa.parent_two_name,
				jt.type_name
			FROM gl 
				JOIN coa 
				ON coa.id_akun = gl.kode_soa
				JOIN coa_type jt
				ON coa.jurnal_tipe = jt.coa_type_id
			WHERE YEAR(gl.tanggal_transaksi) <= YEAR('{$date}') 
			GROUP BY coa.parent_two
			ORDER BY coa.coa_id ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function neracaBulan($date)
	{

		$query =
			"SELECT 
				gl.tanggal_transaksi,
                SUM(gl.debit) AS debit, 
                SUM(gl.credit) AS credit, 
                SUM(gl.debit) - SUM(gl.credit) AS saldo,
                gl.kode_soa, 
                gl.so,
                coa.coa_id,
                coa.parent,
                coa.coa_name,
				coa.jurnal_tipe, 
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 1 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoJanuari,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 2 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoFebruari,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 3 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoMaret,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 4 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoApril,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 5 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoMei,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 6 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoJuni,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 7 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoJuli,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 8 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoAgustus,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 9 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoSeptember,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 10 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoOktober,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 11 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoNovember,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 12 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoDesember
            FROM gl 
                JOIN coa 
                on gl.kode_soa = coa.id_akun 
            WHERE (gl.tanggal_transaksi) <= ('{$date}')
                AND (coa.jurnal_tipe = 1 OR coa.jurnal_tipe = 4)
                AND gl.so = 1
            GROUP BY gl.kode_soa
            ORDER BY coa.coa_id ASC";


		$data = $this->db->query($query);

		return $data->result();
	}

	public function labaRugiBulan($date)
	{

		$query =
			"SELECT
				gl.tanggal_transaksi,
                SUM(gl.debit) AS debit, 
                SUM(gl.credit) AS credit, 
                SUM(gl.debit) - SUM(gl.credit) AS saldo,
                gl.kode_soa, 
                gl.so,
                coa.coa_id,
                coa.parent,
                coa.coa_name,
				coa.jurnal_tipe, 
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 1 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoJanuari,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 2 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoFebruari,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 3 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.so = 1) saldoMaret,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 4 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoApril,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 5 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoMei,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 6 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoJuni,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 7 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoJuli,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 8 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoAgustus,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 9 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoSeptember,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 10 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoOktober,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 11 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoNovember,
                (SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = 12 AND MONTH(g.tanggal_transaksi) <= MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1) saldoDesember
            FROM gl 
                JOIN coa 
                on gl.kode_soa = coa.id_akun 
            WHERE MONTH(gl.tanggal_transaksi) <= MONTH('{$date}')
                AND YEAR(gl.tanggal_transaksi) =  YEAR('{$date}')
                AND (coa.jurnal_tipe = 2 OR coa.jurnal_tipe = 3)
                AND gl.so = 1
            GROUP BY gl.kode_soa
            ORDER BY coa.coa_id ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_cf()
	{
		$sql =
			"SELECT 
				gl.id_gl, 
				gl.tanggal_transaksi, 
				gl.kode_soa, 
				coa.coa_id, 
				coa.coa_name,
				gl.cash, 
				(SELECT 
					mtd_budget.total_mtd 
				FROM mtd_budget 
				WHERE MONTH(gl.tanggal_transaksi) =  MONTH(mtd_budget.tanggal_mtd) 
					AND gl.kode_soa = mtd_budget.kode_soa 
					AND gl.so = 1) total_mtd, 
				(SELECT 
					ytd_budget.total_ytd 
				FROM ytd_budget 
				WHERE YEAR(ytd_budget.tanggal_ytd) = YEAR(gl.tanggal_transaksi) 
					AND gl.kode_soa = ytd_budget.kode_soa 
					AND gl.so = 1) total_ytd 
			FROM gl 
				JOIN coa 
				ON coa.id_akun = gl.kode_soa
			WHERE gl.cash = 1
			GROUP BY gl.kode_soa";

		$query = $this->db->query($sql);

		return $query->result();
	}

	public function select_filter_cf($date)
	{
		if (!empty($date)) {
			$sql =
				"SELECT 
					gl.id_gl, 
					gl.tanggal_transaksi, 
					gl.kode_soa, 
					coa.coa_id, 
					coa.coa_name, 
					coa.jurnal_tipe,
					gl.cash, 
					(SELECT co.coa_name FROM coa co WHERE co.id_akun = coa.parent) AS parent, 
					(SELECT mtd_budget.total_mtd FROM mtd_budget WHERE MONTH('{$date}') =  MONTH(mtd_budget.tanggal_mtd) AND gl.kode_soa = mtd_budget.kode_soa AND gl.so = 1) mtd_budget, 
					(SELECT ytd_budget.total_ytd FROM ytd_budget WHERE YEAR(ytd_budget.tanggal_ytd) = YEAR('{$date}') AND gl.kode_soa = ytd_budget.kode_soa AND gl.so = 1) ytd_budget, 
					(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS mtd_actual, 
					(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS ytd_actual 
				FROM gl 
				JOIN coa ON coa.id_akun = gl.kode_soa 
				WHERE gl.cash = 1
					AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}') 
					AND YEAR(gl.tanggal_transaksi) = YEAR('{$date}')
				GROUP BY gl.kode_soa";

			$query = $this->db->query($sql);

			return $query->result();
		} else {

			$sql =
				"SELECT 
					gl.id_gl, 
					gl.tanggal_transaksi, 
					gl.kode_soa, 
					coa.coa_id, 
					coa.coa_name, 
					coa.jurnal_tipe,
					gl.cash,
					(SELECT co.coa_name FROM coa co WHERE co.id_akun = coa.parent) AS parent, 
					(SELECT mtd_budget.total_mtd FROM mtd_budget WHERE MONTH(CURDATE()) =  MONTH(mtd_budget.tanggal_mtd) AND gl.kode_soa = mtd_budget.kode_soa AND gl.so = 1) mtd_budget, 
					(SELECT ytd_budget.total_ytd FROM ytd_budget WHERE YEAR(ytd_budget.tanggal_ytd) = YEAR(CURDATE()) AND gl.kode_soa = ytd_budget.kode_soa AND gl.so = 1) ytd_budget, 
					(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH(CURDATE()) AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS mtd_actual, 
					(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE YEAR(g.tanggal_transaksi) = YEAR(CURDATE()) AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS ytd_actual 
				FROM gl 
				JOIN coa ON coa.id_akun = gl.kode_soa 
				WHERE gl.cash = 1
					AND MONTH(gl.tanggal_transaksi) = MONTH(CURDATE())
					AND YEAR(gl.tanggal_transaksi) = YEAR(CURDATE())
				GROUP BY gl.kode_soa";

			$query = $this->db->query($sql);
			return $query->result();
		}
	}

	public function print_cf($date)
	{
		$sql =
			"SELECT 
				gl.id_gl, 
				gl.tanggal_transaksi, 
				gl.kode_soa, 
				coa.coa_id, 
				coa.coa_name, 
				coa.jurnal_tipe, 
				coa.cf,
				gl.cash,
				(SELECT co.coa_name FROM coa co WHERE co.id_akun = coa.parent) AS parent, 
				(SELECT mtd_budget.total_mtd FROM mtd_budget WHERE MONTH('{$date}') =  MONTH(mtd_budget.tanggal_mtd) AND gl.kode_soa = mtd_budget.kode_soa AND gl.so = 1) mtd_budget, 
				(SELECT ytd_budget.total_ytd FROM ytd_budget WHERE YEAR(ytd_budget.tanggal_ytd) = YEAR('{$date}') AND gl.kode_soa = ytd_budget.kode_soa AND gl.so = 1) ytd_budget, 
				(SELECT ABS(SUM(g.debit) - SUM(g.credit)) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS mtd_actual, 
				(SELECT ABS(SUM(g.debit) - SUM(g.credit)) FROM gl g WHERE YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS ytd_actual 
			FROM gl 
			JOIN coa ON coa.id_akun = gl.kode_soa 
			WHERE gl.cash = 1
				AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}') 
				AND YEAR(gl.tanggal_transaksi) = YEAR('{$date}')
			GROUP BY coa.group";

		$query = $this->db->query($sql);

		return $query->result();
	}

	public function pendapatan($date)
	{
		$sql =
			"SELECT 
				gl.id_gl, 
				gl.tanggal_transaksi, 
				gl.kode_soa, 
				coa.coa_id, 
				coa.coa_name, 
				coa.jurnal_tipe,
				coa.cf,
				gl.cash,
				(SELECT co.coa_name FROM coa co WHERE co.id_akun = coa.parent) AS parent, 
				(SELECT mtd_budget.total_mtd FROM mtd_budget WHERE MONTH(mtd_budget.tanggal_mtd) = MONTH('{$date}') AND gl.kode_soa = mtd_budget.kode_soa AND gl.so = 1) mtd_budget, 
				(SELECT ytd_budget.total_ytd FROM ytd_budget WHERE YEAR(ytd_budget.tanggal_ytd) = YEAR('{$date}') AND gl.kode_soa = ytd_budget.kode_soa AND gl.so = 1) ytd_budget, 
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS mtd_actual, 
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS ytd_actual,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH(DATE_SUB(('{$date}'), INTERVAL 1 MONTH)) AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS mtd_actual_last,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE YEAR(g.tanggal_transaksi) = YEAR(DATE_SUB(('{$date}'), INTERVAL 1 YEAR)) AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS ytd_actual_last
			FROM gl 
				JOIN coa 
				ON coa.id_akun = gl.kode_soa
			WHERE coa.cf = 0 
				AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}')
				AND YEAR(gl.tanggal_transaksi) = YEAR('{$date}')
				AND gl.cash = 1
			GROUP BY gl.kode_soa";

		$query = $this->db->query($sql);

		return $query->result();
	}

	public function pengeluaran($date)
	{
		$sql =
			"SELECT 
				gl.id_gl, 
				gl.tanggal_transaksi, 
				gl.kode_soa, 
				coa.coa_id, 
				coa.coa_name, 
				coa.jurnal_tipe,
				coa.cf,
				gl.cash,
				(SELECT co.coa_name FROM coa co WHERE co.id_akun = coa.parent) AS parent, 
				(SELECT mtd_budget.total_mtd FROM mtd_budget WHERE MONTH(mtd_budget.tanggal_mtd) = MONTH('{$date}') AND gl.kode_soa = mtd_budget.kode_soa AND gl.so = 1) mtd_budget, 
				(SELECT ytd_budget.total_ytd FROM ytd_budget WHERE YEAR(ytd_budget.tanggal_ytd) = YEAR('{$date}') AND gl.kode_soa = ytd_budget.kode_soa AND gl.so = 1) ytd_budget, 
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS mtd_actual, 
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS ytd_actual,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH(DATE_SUB(('{$date}'), INTERVAL 1 MONTH)) AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS mtd_actual_last,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE YEAR(g.tanggal_transaksi) = YEAR(DATE_SUB(('{$date}'), INTERVAL 1 YEAR)) AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS ytd_actual_last 
			FROM gl 
				JOIN coa 
				ON coa.id_akun = gl.kode_soa
			WHERE coa.cf = 0
				AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}')
				AND YEAR(gl.tanggal_transaksi) = YEAR('{$date}')
				AND gl.cash = 1
			GROUP BY coa.parent";

		$query = $this->db->query($sql);

		return $query->result();
	}

	public function saldo($date)
	{
		$sql =
			"SELECT 
				gl.id_gl, 
				gl.tanggal_transaksi, 
				gl.kode_soa, 
				coa.coa_id, 
				coa.coa_name, 
				coa.jurnal_tipe,
				coa.cf,
				gl.cash,
				(SELECT co.coa_name FROM coa co WHERE co.id_akun = coa.parent) AS parent, 
				(SELECT mtd_budget.total_mtd FROM mtd_budget WHERE MONTH(mtd_budget.tanggal_mtd) = MONTH('{$date}') AND gl.kode_soa = mtd_budget.kode_soa AND gl.so = 1) mtd_budget, 
				(SELECT ytd_budget.total_ytd FROM ytd_budget WHERE YEAR(ytd_budget.tanggal_ytd) = YEAR('{$date}') AND gl.kode_soa = ytd_budget.kode_soa AND gl.so = 1) ytd_budget, 
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS mtd_actual, 
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS ytd_actual,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH(DATE_SUB(('{$date}'), INTERVAL 1 MONTH)) AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS mtd_actual_last,
				(SELECT SUM(g.debit) - SUM(g.credit) FROM gl g WHERE YEAR(g.tanggal_transaksi) = YEAR(DATE_SUB(('{$date}'), INTERVAL 1 YEAR)) AND gl.kode_soa = g.kode_soa AND g.so = 1 AND g.cash = 1) AS ytd_actual_last 
			FROM gl 
				JOIN coa 
				ON coa.id_akun = gl.kode_soa
			WHERE gl.cash = 1
				AND coa.cf = 1
				AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}')
				AND YEAR(gl.tanggal_transaksi) = YEAR('{$date}')
			GROUP BY gl.kode_soa";

		$query = $this->db->query($sql);

		return $query->result();
	}

	public function rekapGL($date)
	{
		$query =
			"SELECT
				gl.id_gl,
				gl.id_customer,
				gl.id_owner,
				gl.kode_soa,
				co.coa_id,
				co.coa_name,
				co.jurnal_tipe,
				gl.bukti_transaksi,
				gl.tanggal_transaksi,
				gl.keterangan,
				(SELECT sum(g.debit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND (g.so = 1) AND g.kode_soa = gl.kode_soa) as debit,
				(SELECT sum(g.credit) FROM gl g WHERE MONTH(g.tanggal_transaksi) = MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND (g.so = 1) AND g.kode_soa = gl.kode_soa) as credit,
				gl.so,
				gl.created_at,
				(SELECT SUM(gl.debit) - SUM(gl.credit) FROM gl JOIN coa ON coa.id_akun = gl.kode_soa WHERE coa.jurnal_tipe = 2 AND gl.so =  1 AND YEAR(gl.tanggal_transaksi) = YEAR('{$date}') AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}')) AS retainedBeban,
				(SELECT SUM(gl.debit) - SUM(gl.credit) FROM gl JOIN coa ON coa.id_akun = gl.kode_soa WHERE coa.jurnal_tipe = 2 AND gl.so =  1 AND (gl.tanggal_transaksi) <= (DATE_SUB(('{$date}'), INTERVAL 1 MONTH))) AS retainedBebanLast,
				(SELECT SUM(gl.debit) - SUM(gl.credit) FROM gl JOIN coa ON coa.id_akun = gl.kode_soa WHERE coa.jurnal_tipe = 3 AND gl.so =  1 AND YEAR(gl.tanggal_transaksi) = YEAR('{$date}') AND MONTH(gl.tanggal_transaksi) = MONTH('{$date}')) AS retainedPendapatan,
				(SELECT SUM(gl.debit) - SUM(gl.credit) FROM gl JOIN coa ON coa.id_akun = gl.kode_soa WHERE coa.jurnal_tipe = 3 AND gl.so =  1 AND (gl.tanggal_transaksi) <= (DATE_SUB(('{$date}'), INTERVAL 1 MONTH))) AS retainedPendapatanLast,
				(SELECT sum(g.debit) FROM gl g WHERE (MONTH(g.tanggal_transaksi) < MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND g.kode_soa = gl.kode_soa) OR (YEAR(g.tanggal_transaksi) < YEAR('{$date}') AND g.kode_soa = gl.kode_soa)) AS debitAwal,
				(SELECT sum(g.credit) FROM gl g WHERE (MONTH(g.tanggal_transaksi) < MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND g.kode_soa = gl.kode_soa) OR (YEAR(g.tanggal_transaksi) < YEAR('{$date}') AND g.kode_soa = gl.kode_soa)) AS creditAwal,
				(SELECT (sum(g.debit) - sum(g.credit)) FROM gl g WHERE MONTH(g.tanggal_transaksi) < MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') AND g.kode_soa = gl.kode_soa OR YEAR(g.tanggal_transaksi) < YEAR('{$date}') AND g.kode_soa = gl.kode_soa) AS saldoAwal
			FROM gl
				JOIN coa co
				ON co.id_akun = gl.kode_soa
			-- WHERE
			-- 	MONTH(gl.tanggal_transaksi) = MONTH('{$date}') AND YEAR(gl.tanggal_transaksi) = YEAR('{$date}') AND (gl.so = 1)
			GROUP BY 
				gl.kode_soa
			ORDER BY
				gl.kode_soa";

		$query = $this->db->query($query);

		return $query->result();
	}

	public function saldoAwal($date)
	{
		$query =
			"SELECT
				g.kode_soa,
				co.coa_id,
				co.coa_name,
				sum(g.debit) as debit,
				sum(g.credit) as credit,
				(sum(g.debit) - sum(g.credit)) AS saldoAwal
			FROM gl g
				JOIN coa co
				ON g.kode_soa = co.id_akun
			WHERE MONTH(g.tanggal_transaksi) < MONTH('{$date}') AND YEAR(g.tanggal_transaksi) = YEAR('{$date}') OR YEAR(g.tanggal_transaksi) < YEAR('{$date}') 
				AND g.so = 1
			GROUP BY g.kode_soa";

		$query = $this->db->query($query);

		return $query->result();
	}

	public function saldoAwalSur($date)
	{
		$query =
			"SELECT
				g.kode_soa,
				co.coa_id,
				co.coa_name,
				month(g.tanggal_transaksi) as monthsur,
				year(g.tanggal_transaksi) as year,
				sum(g.debit) as debit,
				sum(g.credit) as credit,
				(sum(g.debit) - sum(g.credit)) AS saldoAwal
			FROM gl g
				JOIN coa co
				ON g.kode_soa = co.id_akun
			WHERE YEAR(g.tanggal_transaksi) <= YEAR('{$date}')
				AND g.so = 1
				AND g.kode_soa = 272
			GROUP BY month(g.tanggal_transaksi)";

		$query = $this->db->query($query);

		return $query->result();
	}

	public function printSurplus($dateA, $dateB)
	{

		$query =
			"SELECT SUM(gl.debit) - SUM(gl.credit) as surplus,
					MONTH(gl.tanggal_transaksi) as month,
					YEAR(gl.tanggal_transaksi) as year,
					MONTH('{$dateA}') as monthStart,
					MONTH('{$dateB}') as monthEnd,
					LAST_DAY(gl.tanggal_transaksi) as last_day
				FROM gl
						JOIN coa
						on gl.kode_soa = coa.id_akun
					WHERE YEAR(gl.tanggal_transaksi) = YEAR('{$dateA}')
						AND (coa.jurnal_tipe = 3)
						AND gl.so = 1
					GROUP BY MONTH(gl.tanggal_transaksi)
					ORDER BY MONTH(gl.tanggal_transaksi) ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function printDefisit($dateA, $dateB)
	{

		$query =
			"SELECT SUM(gl.debit) - SUM(gl.credit) as defisit,
					MONTH(gl.tanggal_transaksi) as month,
					YEAR(gl.tanggal_transaksi) as year,
					MONTH('{$dateA}') as monthStart,
					MONTH('{$dateB}') as monthEnd
				FROM gl
						JOIN coa
						on gl.kode_soa = coa.id_akun
					WHERE YEAR(gl.tanggal_transaksi) = YEAR('{$dateA}')
						AND (coa.jurnal_tipe = 2)
						AND gl.so = 1
					GROUP BY MONTH(gl.tanggal_transaksi)
					ORDER BY MONTH(gl.tanggal_transaksi) ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function saldoAwalSurLast($date)
	{
		$query =
			"SELECT
				g.kode_soa,
				co.coa_id,
				co.coa_name,
				month(g.tanggal_transaksi) as monthsur,
				year(g.tanggal_transaksi) as year,
				sum(g.debit) as debit,
				sum(g.credit) as credit,
				(sum(g.debit) - sum(g.credit)) AS saldoAwal 
			FROM gl g
				JOIN coa co
				ON g.kode_soa = co.id_akun
			WHERE YEAR(g.tanggal_transaksi) <= YEAR('{$date}') 
				AND g.so = 1
				AND g.kode_soa = 271
			GROUP BY month(g.tanggal_transaksi)";

		$query = $this->db->query($query);

		return $query->result();
	}

	public function printSurplusLast($dateA, $dateB)
	{

		$query =
			"SELECT SUM(gl.debit) - SUM(gl.credit) as surplus, 
					MONTH(gl.tanggal_transaksi) as month,
					YEAR(gl.tanggal_transaksi) as year,
					MONTH('{$dateA}') as monthStart,
					MONTH('{$dateB}') as monthEnd,
					LAST_DAY(gl.tanggal_transaksi) as last_day
				FROM gl 
						JOIN coa 
						on gl.kode_soa = coa.id_akun 
					WHERE YEAR(gl.tanggal_transaksi) <= YEAR(DATE_SUB(('{$dateA}'), INTERVAL 1 YEAR))
						AND (coa.jurnal_tipe = 3)
						AND gl.so = 1
					GROUP BY MONTH(gl.tanggal_transaksi)
					ORDER BY MONTH(gl.tanggal_transaksi) ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function printDefisitLast($dateA, $dateB)
	{

		$query =
			"SELECT SUM(gl.debit) - SUM(gl.credit) as defisit, 
					MONTH(gl.tanggal_transaksi) as month,
					YEAR(gl.tanggal_transaksi) as year,
					MONTH('{$dateA}') as monthStart,
					MONTH('{$dateB}') as monthEnd
				FROM gl 
						JOIN coa 
						on gl.kode_soa = coa.id_akun 
					WHERE YEAR(gl.tanggal_transaksi) <= YEAR(DATE_SUB(('{$dateA}'), INTERVAL 1 YEAR))
						AND (coa.jurnal_tipe = 2)
						AND gl.so = 1
					GROUP BY MONTH(gl.tanggal_transaksi)
					ORDER BY MONTH(gl.tanggal_transaksi) ASC";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function insert_voucher_from_detail($post)
	{
		$this->db->insert($this->tableName, $post);
		return $this->db->affected_rows();
	}
}

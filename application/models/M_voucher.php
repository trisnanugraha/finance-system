<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_voucher extends CI_Model
{
	private $tableName = 'voucher';
	private $formatId = 'BM@year-@month@counter';

	public function select_all()
	{
		$query =
			"SELECT
				v.id_voucher,
				v.bukti_transaksi,
				v.id_customer,
				c.nama_customer,
				c.kode_virtual AS cusVirtual,
				c.unit_customer,
				c.alamat_customer,
				v.id_owner,
				o.nama_owner,
				o.kode_virtual AS ownerVirtual,
				o.unit_owner,
				o.alamat_owner,
				v.tipe_giro,
				gt.type_giro_name,
				v.bank,
				co.coa_id,
				co.coa_name,
				v.tanggal_voucher,
				v.keterangan,
				v.total,
				v.so,
				v.relasi,
				v.titipan,
				v.created_at,
				v.updated_at,
				(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = v.id_voucher AND gl.kode_soa = v.bank AND gl.keterangan = v.keterangan AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND gl.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND gl.credit = v.total))) AS id_gl,
				(SELECT bayar.id_bayar FROM bayar WHERE bayar.id_voucher = v.id_voucher AND bayar.kode_soa = v.bank AND bayar.keterangan = v.keterangan AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND bayar.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND bayar.credit = v.total))) AS id_bayar,
				(SELECT vendor.id_vendor FROM vendor WHERE vendor.id_voucher = v.id_voucher AND vendor.kode_soa = v.bank AND vendor.keterangan = v.keterangan AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND vendor.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND vendor.credit = v.total))) AS id_vendor
			FROM voucher v
				JOIN customer c 
				ON c.kode_customer = v.id_customer
				JOIN owner o 
				ON o.kode_owner = v.id_owner
				JOIN coa co 
				ON co.id_akun = v.bank
				JOIN giro_type gt 
				ON gt.giro_type_id = v.tipe_giro";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_filter($startDate, $endDate)
	{
		if (!empty($startDate) && !empty($endDate)) {

			$query =
				"SELECT
					v.id_voucher,
					v.bukti_transaksi,
					v.id_customer,
					c.nama_customer,
					c.kode_virtual AS cusVirtual,
					c.unit_customer,
					c.alamat_customer,
					v.id_owner,
					o.nama_owner,
					o.kode_virtual AS ownerVirtual,
					o.unit_owner,
					o.alamat_owner,
					v.tipe_giro,
					gt.type_giro_name,
					v.bank,
					co.coa_id,
					co.coa_name,
					v.tanggal_voucher,
					v.keterangan,
					v.total,
					v.so,
					v.relasi,
					v.titipan,
					v.created_at,
					v.updated_at,
					(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = v.id_voucher AND gl.kode_soa = v.bank AND gl.keterangan = v.keterangan  AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND gl.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND gl.credit = v.total))) AS id_gl,
					(SELECT bayar.id_bayar FROM bayar WHERE bayar.id_voucher = v.id_voucher AND bayar.kode_soa = v.bank AND bayar.keterangan = v.keterangan AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND bayar.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND bayar.credit = v.total))) AS id_bayar,
					(SELECT vendor.id_vendor FROM vendor WHERE vendor.id_voucher = v.id_voucher AND vendor.kode_soa = v.bank AND vendor.keterangan = v.keterangan AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND vendor.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND vendor.credit = v.total))) AS id_vendor
				FROM voucher v
					JOIN customer c 
					ON c.kode_customer = v.id_customer
					JOIN owner o 
					ON o.kode_owner = v.id_owner
					JOIN coa co 
					ON co.id_akun = v.bank
					JOIN giro_type gt 
					ON gt.giro_type_id = v.tipe_giro
				WHERE v.tanggal_voucher BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)";

			$data = $this->db->query($query);

			return $data->result();
		} else {
			$query =
				"SELECT
					v.id_voucher,
					v.bukti_transaksi,
					v.id_customer,
					c.nama_customer,
					c.kode_virtual AS cusVirtual,
					c.unit_customer,
					c.alamat_customer,
					v.id_owner,
					o.nama_owner,
					o.kode_virtual AS ownerVirtual,
					o.unit_owner,
					o.alamat_owner,
					v.tipe_giro,
					gt.type_giro_name,
					v.bank,
					co.coa_id,
					co.coa_name,
					v.tanggal_voucher,
					v.keterangan,
					v.total,
					v.so,
					v.relasi,
					v.titipan,
					v.created_at,
					v.updated_at,
					(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = v.id_voucher AND gl.kode_soa = v.bank AND gl.keterangan = v.keterangan  AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND gl.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND gl.credit = v.total))) AS id_gl,
					(SELECT bayar.id_bayar FROM bayar WHERE bayar.id_voucher = v.id_voucher AND bayar.kode_soa = v.bank AND bayar.keterangan = v.keterangan AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND bayar.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND bayar.credit = v.total))) AS id_bayar,
					(SELECT vendor.id_vendor FROM vendor WHERE vendor.id_voucher = v.id_voucher AND vendor.kode_soa = v.bank AND vendor.keterangan = v.keterangan AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND vendor.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND vendor.credit = v.total))) AS id_vendor
				FROM voucher v
					JOIN customer c 
					ON c.kode_customer = v.id_customer
					JOIN owner o 
					ON o.kode_owner = v.id_owner
					JOIN coa co 
					ON co.id_akun = v.bank
					JOIN giro_type gt 
					ON gt.giro_type_id = v.tipe_giro
				WHERE v.tanggal_voucher <= CURDATE() AND (MONTH(v.tanggal_voucher) = MONTH(CURDATE()) OR MONTH(v.tanggal_voucher) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))) AND YEAR(v.tanggal_voucher) = YEAR(CURDATE())
				LIMIT 10";

			$data = $this->db->query($query);

			return $data->result();
		}
	}

	public function select_by_id($id)
	{
		$query =
			"SELECT
				v.id_voucher,
				v.bukti_transaksi,
				v.id_customer,
				c.nama_customer,
				c.kode_virtual AS cusVirtual,
				c.unit_customer,
				c.alamat_customer,
				v.id_owner,
				o.nama_owner,
				o.kode_virtual AS ownerVirtual,
				o.unit_owner,
				o.alamat_owner,
				v.tipe_giro,
				gt.type_giro_name,
				v.bank,
				co.coa_id,
				co.coa_name,
				v.tanggal_voucher,
				v.keterangan,
				v.total,
				v.so,
				v.relasi,
				v.titipan,
				v.created_at,
				v.updated_at,
				(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = v.id_voucher AND gl.kode_soa = v.bank AND gl.keterangan = v.keterangan  AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND gl.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND gl.credit = v.total))) AS id_gl,
				(SELECT bayar.id_bayar FROM bayar WHERE bayar.id_voucher = v.id_voucher AND bayar.kode_soa = v.bank AND bayar.keterangan = v.keterangan AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND bayar.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND bayar.credit = v.total))) AS id_bayar,
				(SELECT vendor.id_vendor FROM vendor WHERE vendor.id_voucher = v.id_voucher AND vendor.kode_soa = v.bank AND vendor.keterangan = v.keterangan AND ((v.tipe_giro = 1 OR v.tipe_giro = 2 AND vendor.debit = v.total) OR (v.tipe_giro = 3 OR v.tipe_giro = 4 AND vendor.credit = v.total))) AS id_vendor
			FROM voucher v
				JOIN customer c 
				ON c.kode_customer = v.id_customer
				JOIN owner o 
				ON o.kode_owner = v.id_owner
				JOIN coa co 
				ON co.id_akun = v.bank
				JOIN giro_type gt 
				ON gt.giro_type_id = v.tipe_giro
			WHERE v.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->row();
	}

	public function select_all_titipan()
	{
		$query =
			"SELECT
				titipan.id_titipan,
				titipan.id_customer,
				customer.nama_customer,
				customer.unit_customer,
				titipan.id_owner,
				owner.nama_owner,
				owner.unit_owner,
				titipan.kode_soa,
				coa.coa_id,
				coa.coa_name,
				coa.parent,
				coa.parent_name,
				titipan.id_voucher,
				titipan.so,
				titipan.tanggal_masuk,
				titipan.total,
				titipan.keterangan,
				(SELECT voucher.bank FROM voucher WHERE voucher.id_voucher = titipan.id_voucher) AS bank,
				(SELECT coa.coa_id FROM voucher JOIN coa ON voucher.bank = coa.id_akun WHERE voucher.id_voucher = titipan.id_voucher) AS coa_bank,
				(SELECT coa.coa_name FROM voucher JOIN coa ON voucher.bank = coa.id_akun WHERE voucher.id_voucher = titipan.id_voucher) AS name_bank,
				(SELECT voucher.relasi FROM voucher WHERE voucher.id_voucher = titipan.id_voucher) AS relasi,
				(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = titipan.id_voucher AND gl.kode_soa = titipan.kode_soa AND gl.keterangan = titipan.keterangan) AS id_gl
			FROM titipan
				JOIN customer 
				ON customer.kode_customer = titipan.id_customer
				JOIN owner 
				ON owner.kode_owner = titipan.id_owner
				JOIN coa 
				ON coa.id_akun = titipan.kode_soa";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_titipan_by_id($id)
	{
		$query =
			"SELECT
				titipan.id_titipan,
				titipan.id_customer,
				customer.nama_customer,
				customer.unit_customer,
				titipan.id_owner,
				owner.nama_owner,
				owner.unit_owner,
				titipan.kode_soa,
				coa.coa_id,
				coa.coa_name,
				coa.parent,
				coa.parent_name,
				titipan.id_voucher,
				titipan.so,
				titipan.tanggal_masuk,
				titipan.total,
				titipan.keterangan,
				(SELECT voucher.bank FROM voucher WHERE voucher.id_voucher = titipan.id_voucher) AS bank,
				(SELECT coa.coa_id FROM voucher JOIN coa ON voucher.bank = coa.id_akun WHERE voucher.id_voucher = titipan.id_voucher) AS coa_bank,
				(SELECT coa.coa_name FROM voucher JOIN coa ON voucher.bank = coa.id_akun WHERE voucher.id_voucher = titipan.id_voucher) AS name_bank,
				(SELECT voucher.relasi FROM voucher WHERE voucher.id_voucher = titipan.id_voucher) AS relasi,
				(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = titipan.id_voucher AND gl.kode_soa = titipan.kode_soa AND gl.keterangan = titipan.keterangan) AS id_gl
			FROM titipan
				JOIN customer 
				ON customer.kode_customer = titipan.id_customer
				JOIN owner 
				ON owner.kode_owner = titipan.id_owner
				JOIN coa 
				ON coa.id_akun = titipan.kode_soa
			WHERE titipan.id_titipan = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_titipan_voucher($id)
	{
		$query =
			"SELECT
				titipan.id_titipan,
				titipan.id_customer,
				customer.nama_customer,
				customer.unit_customer,
				titipan.id_owner,
				owner.nama_owner,
				owner.unit_owner,
				titipan.kode_soa,
				coa.coa_id,
				coa.coa_name,
				coa.parent,
				coa.parent_name,
				titipan.id_voucher,
				titipan.so,
				titipan.tanggal_masuk,
				titipan.total,
				titipan.keterangan,
				(SELECT voucher.bank FROM voucher WHERE voucher.id_voucher = titipan.id_voucher) AS bank,
				(SELECT coa.coa_id FROM voucher JOIN coa ON voucher.bank = coa.id_akun WHERE voucher.id_voucher = titipan.id_voucher) AS coa_bank,
				(SELECT coa.coa_name FROM voucher JOIN coa ON voucher.bank = coa.id_akun WHERE voucher.id_voucher = titipan.id_voucher) AS name_bank,
				(SELECT voucher.total FROM voucher JOIN coa ON voucher.bank = coa.id_akun WHERE voucher.id_voucher = titipan.id_voucher) AS total_voucher,
				(SELECT voucher.relasi FROM voucher WHERE voucher.id_voucher = titipan.id_voucher) AS relasi,
				(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = titipan.id_voucher AND gl.kode_soa = titipan.kode_soa AND gl.keterangan = titipan.keterangan) AS id_gl
			FROM titipan
				JOIN customer 
				ON customer.kode_customer = titipan.id_customer
				JOIN owner 
				ON owner.kode_owner = titipan.id_owner
				JOIN coa 
				ON coa.id_akun = titipan.kode_soa
			WHERE titipan.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_all_vendor()
	{
		$query =
			"SELECT 
				vendor.id_vendor, 
				vendor.id_voucher, 
				vendor.tanggal_transaksi, 
				vendor.kode_soa, 
				coa.coa_id, 
				coa.coa_name, 
				coa.parent,
				coa.cf,
				vendor.keterangan,
				vendor.debit,
				vendor.credit,
				SUM(vendor.debit) - SUM(vendor.credit) AS total, 
				vendor.so,
				(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = vendor.id_voucher AND gl.kode_soa = vendor.kode_soa AND gl.keterangan = vendor.keterangan AND gl.debit = vendor.debit AND gl.credit = vendor.credit) AS id_gl
			FROM vendor 
				JOIN coa 
				ON coa.id_akun = vendor.kode_soa
			-- WHERE coa.parent <> 1
			-- 	AND coa.parent <> 3
			-- 	AND coa.parent <> 4
			-- 	AND coa.parent <> 5
			-- 	AND coa.parent <> 7
			GROUP BY vendor.id_vendor";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_filter_vendor($startDate, $endDate)
	{
		if (!empty($startDate) && !empty($endDate)) {

			$query =
				"SELECT 
					vendor.id_vendor, 
					vendor.id_voucher, 
					vendor.tanggal_transaksi, 
					vendor.kode_soa, 
					coa.coa_id, 
					coa.coa_name, 
					coa.parent,
					coa.cf,
					vendor.keterangan,
					vendor.debit,
					vendor.credit,
					SUM(vendor.debit) - SUM(vendor.credit) AS total, 
					vendor.so,
					(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = vendor.id_voucher AND gl.kode_soa = vendor.kode_soa AND gl.keterangan = vendor.keterangan  AND gl.debit = vendor.debit AND gl.credit = vendor.credit) AS id_gl
				FROM vendor 
					JOIN coa 
					ON coa.id_akun = vendor.kode_soa
				WHERE 
					-- coa.parent <> 1
					-- AND coa.parent <> 3
					-- AND coa.parent <> 4
					-- AND coa.parent <> 5
					-- AND coa.parent <> 7
					-- AND 
					vendor.tanggal_transaksi BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				GROUP BY vendor.id_vendor";

			$data = $this->db->query($query);

			return $data->result();
		} else {
			$query =
				"SELECT 
					vendor.id_vendor, 
					vendor.id_voucher, 
					vendor.tanggal_transaksi, 
					vendor.kode_soa, 
					coa.coa_id, 
					coa.coa_name, 
					coa.parent,
					coa.cf,
					vendor.keterangan,
					vendor.debit,
					vendor.credit,
					SUM(vendor.debit) - SUM(vendor.credit) AS total, 
					vendor.so,
					(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = vendor.id_voucher AND gl.kode_soa = vendor.kode_soa AND gl.keterangan = vendor.keterangan  AND gl.debit = vendor.debit AND gl.credit = vendor.credit) AS id_gl
				FROM vendor 
					JOIN coa 
					ON coa.id_akun = vendor.kode_soa
				WHERE 
					-- coa.parent <> 1
					-- AND coa.parent <> 3
					-- AND coa.parent <> 4
					-- AND coa.parent <> 5
					-- AND coa.parent <> 7
					-- AND 
					vendor.tanggal_transaksi <= CURDATE() AND (MONTH(vendor.tanggal_transaksi) = MONTH(CURDATE()) OR MONTH(vendor.tanggal_transaksi) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)))
				GROUP BY vendor.id_vendor";

			$data = $this->db->query($query);

			return $data->result();
		}
	}

	public function select_all_vendor_voucher($id)
	{
		$query =
			"SELECT 
				vendor.id_vendor, 
				vendor.id_voucher, 
				vendor.tanggal_transaksi, 
				vendor.kode_soa, 
				coa.coa_id, 
				coa.coa_name, 
				coa.parent,
				coa.cf,
				UPPER(vendor.keterangan) AS keterangan,
				vendor.debit,
				vendor.credit,
				SUM(vendor.debit) - SUM(vendor.credit) AS total, 
				vendor.so,
				(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = vendor.id_voucher AND gl.kode_soa = vendor.kode_soa AND gl.keterangan = vendor.keterangan  AND gl.debit = vendor.debit AND gl.credit = vendor.credit) AS id_gl
			FROM vendor 
				JOIN coa 
				ON coa.id_akun = vendor.kode_soa
			WHERE vendor.id_voucher = '{$id}'
			GROUP BY vendor.id_vendor";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function get_last_id($dt)
	{
		$currentNumber = $this->db->query('SELECT get_increment_voucher_id(?, ?) as maxNumber', [$dt->format('Y'), $dt->format('m')]);

		return $currentNumber->row();
	}

	public function check_bill($id_voucher)
	{
		$data = $this->db->where([
			'id_voucher' => $id_voucher
		])
			->count_all_results('voucher');
		return $data;
	}

	public function insert($post)
	{
		$code = json_decode($_POST["code"]);
		$akun = json_decode($_POST["akun"]);
		$keterangan = json_decode($_POST["keterangan"]);
		$relasi = json_decode($_POST["relasi"]);
		$debit = json_decode($_POST["debit"]);
		$kredit = json_decode($_POST["kredit"]);

		if ($this->M_voucher->check_bill($code[0]) > 0) {
			return 0;
		} else {
			for ($i = 0; $i < count($code); $i++) {
				if ($akun[$i] != NULL) {
					$CoA = $this->M_coa->select_by_coa($akun[$i]);
					if ($post['giro'] == 1 || $post['giro'] == 2) {
						if ($CoA->parent == 1 && $debit[$i] > 0 || $CoA->parent == 3 && $debit[$i] > 0 || $CoA->parent == 4 && $debit[$i] > 0 || $CoA->parent == 5 && $debit[$i] > 0  || $CoA->parent == 7 && $debit[$i] > 0) {
							$data = array(
								'id_voucher' => $code[$i],
								'bukti_transaksi' => $code[$i],
								'id_customer' => 'T-10A',
								'id_owner' => '10A',
								'tipe_giro' => $post['giro'],
								'bank' =>  $CoA->id_akun,
								'tanggal_voucher' => $post['date'],
								'keterangan' => $keterangan[$i],
								'total' => $debit[$i],
								'so' => 3,
								'relasi' => $relasi[$i],
								'titipan' => 1
							);
							$this->db->insert($this->tableName, $data);

							$data1 = array(
								'id_voucher' => $code[$i],
								'kode_soa' =>  $CoA->id_akun,
								'tanggal_transaksi' => $post['date'],
								'keterangan' => $keterangan[$i],
								'debit' => $debit[$i],
								'credit' => $kredit[$i],
								'so' => 3
							);
							$this->db->insert('vendor', $data1);
						} else {
							$data = array(
								'id_voucher' => $code[$i],
								'kode_soa' =>  $CoA->id_akun,
								'tanggal_transaksi' => $post['date'],
								'keterangan' => $keterangan[$i],
								'debit' => $debit[$i],
								'credit' => $kredit[$i],
								'so' => 3
							);
							$this->db->insert('vendor', $data);
						}
					} else {
						if ($CoA->parent == 1 && $kredit[$i] > 0 || $CoA->parent == 3 && $kredit[$i] > 0 || $CoA->parent == 4 && $kredit[$i] > 0 || $CoA->parent == 5 && $kredit[$i] > 0  || $CoA->parent == 7 && $kredit[$i] > 0) {
							$data = array(
								'id_voucher' => $code[$i],
								'bukti_transaksi' => $code[$i],
								'id_customer' => 'T-10A',
								'id_owner' => '10A',
								'tipe_giro' => $post['giro'],
								'bank' =>  $CoA->id_akun,
								'tanggal_voucher' => $post['date'],
								'keterangan' => $keterangan[$i],
								'total' => $kredit[$i],
								'so' => 3,
								'relasi' => $relasi[$i],
								'titipan' => 1
							);
							$this->db->insert($this->tableName, $data);

							$data1 = array(
								'id_voucher' => $code[$i],
								'kode_soa' =>  $CoA->id_akun,
								'tanggal_transaksi' => $post['date'],
								'keterangan' => $keterangan[$i],
								'debit' => $debit[$i],
								'credit' => $kredit[$i],
								'so' => 3
							);
							$this->db->insert('vendor', $data1);
						} else {
							$data = array(
								'id_voucher' => $code[$i],
								'kode_soa' =>  $CoA->id_akun,
								'tanggal_transaksi' => $post['date'],
								'keterangan' => $keterangan[$i],
								'debit' => $debit[$i],
								'credit' => $kredit[$i],
								'so' => 3
							);
							$this->db->insert('vendor', $data);
						}
					}
				}
			}
		}
		return $this->db->affected_rows();
	}

	public function insert2($params)
	{

		$this->db->insert($this->tableName, $params);

		return $this->db->affected_rows();
	}

	public function update($params)
	{
		$data = array(
			'bank' => $params['bank'],
			'tipe_giro' => $params['giro'],
			'tanggal_voucher' => $params['vouDate'],
			'keterangan' => $params['keterangan'],
			'relasi' => $params['relasi'],
			'total' => $params['vouTotal']
		);

		$where = array('id_voucher' => $params['id']);
		$this->db->update($this->tableName, $data, $where);

		return $this->db->affected_rows();
	}

	public function vendor_update($post)
	{

		for ($i = 0; $i < count($post['idv']); $i++) {
			$data = array(
				'id_voucher' => $post['id'],
				'keterangan' => $post['ket'][$i],
				'tanggal_transaksi' => $post['vouDate'],
				'kode_soa' => $post['coa'][$i],
				'debit' => $post['debit'][$i],
				'credit' => $post['credit'][$i]
			);

			$where = array('id_vendor' => $post['idv'][$i]);
			$this->db->update('vendor', $data, $where);
		}

		$voucher = $this->M_voucher->select_by_id($post['id']);
		if ($voucher->tipe_giro == 1 || $voucher->tipe_giro == 2) {
			$data1 = array(
				'id_voucher' => $post['id'],
				'keterangan' => $post['keterangan'],
				'tanggal_transaksi' => $post['vouDate'],
				'kode_soa' => $post['bank'],
				'debit' => $post['vouTotal'],
				'credit' => 0
			);

			$where1 = array('id_vendor' => $post['idvendor']);
			$this->db->update('vendor', $data1, $where1);
		} else {
			$data1 = array(
				'id_voucher' => $post['id'],
				'keterangan' => $post['keterangan'],
				'tanggal_transaksi' => $post['vouDate'],
				'kode_soa' => $post['bank'],
				'debit' => 0,
				'credit' => $post['vouTotal']
			);

			$where1 = array('id_vendor' => $post['idvendor']);
			$this->db->update('vendor', $data1, $where1);
		}


		return $this->db->affected_rows();
	}

	public function update_titipan($params)
	{
		$data = array(
			'total' => $params['vouTotal'],
			'nilai' => $params['vouTotal']
		);

		$where = array(
			'id_voucher' => $params['id']
		);
		$this->db->update('titipan', $data, $where);
	}

	public function update_vendor($id)
	{
		$where = ['id_voucher' => $id];
		$this->db->delete('vendor', $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function insert_voucher($post)
	{

		$id = json_decode($_POST["id"]);
		$code = json_decode($_POST["bukti_transaksi"]);
		$kodeOwner = json_decode($_POST["kodeOwner"]);
		$akun = json_decode($_POST["akun"]);
		$debit = json_decode($_POST["debit"]);
		$keterangan = json_decode($_POST["keterangan"]);

		if ($this->M_voucher->check_bill($code[0]) > 0) {
			return 0;
		} else {
			for ($i = 0; $i < count($id); $i++) {
				$CoA = $this->M_coa->select_by_coa($akun[$i]);
				$ar = $this->M_ar->select_by_id($id[$i]);
				$owner = $this->M_owner->select_by_id($kodeOwner[$i]);

				if ($akun[$i] != NULL) {
					if ($post['relasi'] == 1) {
						if ($ar->id_ar == 1) {
							if ($CoA->parent == 1 && $debit[$i] > 0 || $CoA->parent == 3 && $debit[$i] > 0 || $CoA->parent == 4 && $debit[$i] > 0 || $CoA->parent == 5 && $debit[$i] > 0  || $CoA->parent == 7 && $debit[$i] > 0) {
								$data = array(
									'id_voucher' => $code[$i],
									'bukti_transaksi' => $code[$i],
									'id_customer' => $owner->customer,
									'id_owner' => $kodeOwner[$i],
									'tipe_giro' => $post['giro'],
									'bank' =>  $CoA->id_akun,
									'tanggal_voucher' => $post['date'],
									'keterangan' => $keterangan[$i],
									'total' => $debit[$i],
									'so' => 1,
									'relasi' => $owner->customer,
									'titipan' => 1
								);
								$this->db->insert($this->tableName, $data);
							} else if ($CoA->parent == 187 && $debit[$i] > 0) {
								$data = array(
									'id_voucher' => $code[$i],
									'bukti_transaksi' => $code[$i],
									'id_customer' => $owner->customer,
									'id_owner' => $kodeOwner[$i],
									'tipe_giro' => $post['giro'],
									'bank' =>  $CoA->id_akun,
									'tanggal_voucher' => $post['date'],
									'keterangan' => $keterangan[$i],
									'total' => $debit[$i],
									'so' => 1,
									'relasi' => $owner->customer,
									'titipan' => 1
								);
								$this->db->insert($this->tableName, $data);
							}
						} else {
							if ($CoA->parent == 1 && $debit[$i] > 0 || $CoA->parent == 3 && $debit[$i] > 0 || $CoA->parent == 4 && $debit[$i] > 0 || $CoA->parent == 5 && $debit[$i] > 0  || $CoA->parent == 7 && $debit[$i] > 0) {
								$data = array(
									'id_voucher' => $code[$i],
									'bukti_transaksi' => $code[$i],
									'id_customer' => $ar->id_customer,
									'id_owner' => $kodeOwner[$i],
									'tipe_giro' => $post['giro'],
									'bank' =>  $CoA->id_akun,
									'tanggal_voucher' => $post['date'],
									'keterangan' => $keterangan[$i],
									'total' => $debit[$i],
									'so' => 1,
									'relasi' => $ar->id_customer,
									'titipan' => 1
								);
								$this->db->insert($this->tableName, $data);
							} else if ($CoA->parent == 187 && $debit[$i] > 0) {
								$data = array(
									'id_voucher' => $code[$i],
									'bukti_transaksi' => $code[$i],
									'id_customer' => $ar->id_customer,
									'id_owner' => $kodeOwner[$i],
									'tipe_giro' => $post['giro'],
									'bank' =>  $CoA->id_akun,
									'tanggal_voucher' => $post['date'],
									'keterangan' => $keterangan[$i],
									'total' => $debit[$i],
									'so' => 1,
									'relasi' => $ar->id_customer,
									'titipan' => 1
								);
								$this->db->insert($this->tableName, $data);
							}
						}
					} else if ($post['relasi'] == 2) {
						if ($CoA->parent == 1 && $debit[$i] > 0 || $CoA->parent == 3 && $debit[$i] > 0 || $CoA->parent == 4 && $debit[$i] > 0 || $CoA->parent == 5 && $debit[$i] > 0  || $CoA->parent == 7 && $debit[$i] > 0) {
							$data = array(
								'id_voucher' => $code[$i],
								'bukti_transaksi' => $code[$i],
								'id_customer' => $ar->id_customer,
								'id_owner' => $kodeOwner[$i],
								'tipe_giro' => $post['giro'],
								'bank' =>  $CoA->id_akun,
								'tanggal_voucher' => $post['date'],
								'keterangan' => $keterangan[$i],
								'total' => $debit[$i],
								'so' => 0,
								'relasi' => $kodeOwner[$i],
								'titipan' => 1
							);
							$this->db->insert($this->tableName, $data);
						} else if ($CoA->parent == 187 && $debit[$i] > 0) {
							$data = array(
								'id_voucher' => $code[$i],
								'bukti_transaksi' => $code[$i],
								'id_customer' => $ar->id_customer,
								'id_owner' => $kodeOwner[$i],
								'tipe_giro' => $post['giro'],
								'bank' =>  $CoA->id_akun,
								'tanggal_voucher' => $post['date'],
								'keterangan' => $keterangan[$i],
								'total' => $debit[$i],
								'so' => 0,
								'relasi' => $kodeOwner[$i],
								'titipan' => 1
							);
							$this->db->insert($this->tableName, $data);
						}
					} else {
						if ($CoA->parent == 1 && $debit[$i] > 0 || $CoA->parent == 3 && $debit[$i] > 0 || $CoA->parent == 4 && $debit[$i] > 0 || $CoA->parent == 5 && $debit[$i] > 0  || $CoA->parent == 7 && $debit[$i] > 0) {
							$data = array(
								'id_voucher' => $code[$i],
								'bukti_transaksi' => $code[$i],
								'id_customer' => $ar->id_customer,
								'id_owner' => $kodeOwner[$i],
								'tipe_giro' => $post['giro'],
								'bank' =>  $CoA->id_akun,
								'tanggal_voucher' => $post['date'],
								'keterangan' => $keterangan[$i],
								'total' => $debit[$i],
								'so' => 2,
								'relasi' => 'UMUM',
								'titipan' => 1
							);
							$this->db->insert($this->tableName, $data);
						} else if ($CoA->parent == 187 && $debit[$i] > 0) {
							$data = array(
								'id_voucher' => $code[$i],
								'bukti_transaksi' => $code[$i],
								'id_customer' => $ar->id_customer,
								'id_owner' => $kodeOwner[$i],
								'tipe_giro' => $post['giro'],
								'bank' =>  $CoA->id_akun,
								'tanggal_voucher' => $post['date'],
								'keterangan' => $keterangan[$i],
								'total' => $debit[$i],
								'so' => 2,
								'relasi' => 'UMUM',
								'titipan' => 1
							);
							$this->db->insert($this->tableName, $data);
						}
					}
				}
			}
		}
		return $this->db->affected_rows();
	}

	public function insert_voucher_titipan($post)
	{

		$id = json_decode($_POST["id"]);
		$code = json_decode($_POST["bukti_transaksi"]);
		$kodeOwner = json_decode($_POST["kodeOwner"]);
		$akun = json_decode($_POST["akun"]);
		$debit = json_decode($_POST["debit"]);
		$credit = json_decode($_POST["credit"]);
		$keterangan = json_decode($_POST["keterangan"]);

		if ($this->M_voucher->check_bill($code[0]) > 0) {
			return 0;
		} else {
			for ($i = 0; $i < count($id); $i++) {
				$CoA = $this->M_coa->select_by_coa($akun[$i]);
				$ar = $this->M_ar->select_by_id($id[$i]);

				if ($akun[$i] != NULL) {
					if ($CoA->parent == 1 && $debit[$i] > 0 || $CoA->parent == 3 && $debit[$i] > 0 || $CoA->parent == 4 && $debit[$i] > 0 || $CoA->parent == 5 && $debit[$i] > 0  || $CoA->parent == 7 && $debit[$i] > 0) {
						$data = array(
							'id_voucher' => $code[$i],
							'bukti_transaksi' => $code[$i],
							'id_customer' => $ar->id_customer,
							'id_owner' => $kodeOwner[$i],
							'tipe_giro' => $post['giro'],
							'bank' =>  $CoA->id_akun,
							'tanggal_voucher' => $post['date'],
							'keterangan' => $keterangan[$i],
							'total' => $debit[$i],
							'so' => $post['so'],
							'relasi' => $post['relasi'],
							'titipan' => 1
						);
						$this->db->insert($this->tableName, $data);
					} else if ($CoA->parent == 187 && $debit[$i] > 0) {
						$data = array(
							'id_voucher' => $code[$i],
							'bukti_transaksi' => $code[$i],
							'id_customer' => $ar->id_customer,
							'id_owner' => $kodeOwner[$i],
							'tipe_giro' => $post['giro'],
							'bank' =>  $CoA->id_akun,
							'tanggal_voucher' => $post['date'],
							'keterangan' => $keterangan[$i],
							'total' => $debit[$i],
							'so' => $post['so'],
							'relasi' => $post['relasi'],
							'titipan' => 1
						);
						$this->db->insert($this->tableName, $data);
					}
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

			$CoA = $this->M_coa->select_by_coa($akun[$i]);
			$ar = $this->M_ar->select_by_id($id[$i]);

			if ($akun[$i] != NULL && $CoA->parent == 187 && $credit[$i] > 0) {
				if ($post['relasi'] == 1) {
					$data = array(
						'id_customer' =>  'T-' . $kodeOwner[$i],
						'id_owner' => $kodeOwner[$i],
						'kode_soa' => $CoA->id_akun,
						'id_voucher' => $code[$i],
						'total' => $credit[$i],
						'nilai' => $credit[$i],
						'tanggal_masuk' => $post['date'],
						'so' => 1,
						'keterangan' => $keterangan[$i]
					);
					$this->db->insert('titipan', $data);
				} else if ($post['relasi'] == 2) {
					$data = array(
						'id_customer' =>  'T-' . $kodeOwner[$i],
						'id_owner' => $kodeOwner[$i],
						'kode_soa' => $CoA->id_akun,
						'id_voucher' => $code[$i],
						'total' => $credit[$i],
						'nilai' => $credit[$i],
						'tanggal_masuk' => $post['date'],
						'so' => 0,
						'keterangan' => $keterangan[$i]
					);
					$this->db->insert('titipan', $data);
				} else {
					$data = array(
						'id_customer' =>  'T-' . $kodeOwner[$i],
						'id_owner' => $kodeOwner[$i],
						'kode_soa' => $CoA->id_akun,
						'id_voucher' => $code[$i],
						'total' => $credit[$i],
						'nilai' => $credit[$i],
						'tanggal_masuk' => $post['date'],
						'so' => 2,
						'keterangan' => $keterangan[$i]
					);
					$this->db->insert('titipan', $data);
				}
			} else {
			}
		}
		return $this->db->affected_rows();
	}

	public function titipan_out($post)
	{
		$id = json_decode($_POST["id"]);
		$code = json_decode($_POST["bukti_transaksi"]);
		$kodeOwner = json_decode($_POST["kodeOwner"]);
		$akun = json_decode($_POST["akun"]);
		$debit = json_decode($_POST["debit"]);
		$keterangan = json_decode($_POST["keterangan"]);

		for ($i = 0; $i < count($id); $i++) {

			if ($akun[$i] != NULL) {
				$CoA = $this->M_coa->select_by_coa($akun[$i]);

				if ($CoA->parent == 187 && $debit[$i] > 0) {
					$sisa = ($post['total'] - $debit[$i]);
					$data = array(
						'total' => $sisa
					);
					$where = array('id_titipan' => $post['idt']);
					$this->db->update('titipan', $data, $where);
				}
			}
		}
		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$where = ['id_voucher' => $id];
		$this->db->delete('titipan', $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function delete_titipan($id)
	{
		$where = ['id_voucher' => $id];
		$this->db->delete($this->tableName, $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function update_bayar($id)
	{
		$bayar = $this->M_bayar->select_by_id($id);
		$voucher = $this->M_voucher->select_by_id($bayar->id_voucher);

		$data = array(
			'total' => $voucher->total + $bayar->total_pembayaran
		);
		$where = array('id_voucher' => $bayar->id_voucher);
		$this->db->update($this->tableName, $data, $where);
	}

	public function print_received($id)
	{

		$query =
			"SELECT 
				voucher.id_voucher,
				voucher.bukti_transaksi,
				voucher.tanggal_voucher,
				UPPER(voucher.keterangan) AS keterangan,
				voucher.id_customer,
				customer.nama_customer,
				customer.alamat_customer,
				customer.unit_customer,
				voucher.id_owner,
				owner.nama_owner,
				owner.alamat_owner,
				voucher.total,
				voucher.so,
				voucher.relasi
			FROM voucher 
				JOIN customer 
				ON customer.kode_customer = voucher.id_customer 
				JOIN owner 
				ON owner.kode_owner = voucher.id_owner
			WHERE voucher.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function print_received_keluar($id)
	{

		$query =
			"SELECT 
				voucher.id_voucher,
				voucher.bukti_transaksi,
				voucher.tanggal_voucher,
				UPPER(voucher.keterangan) AS keterangan,
				voucher.id_customer,
				customer.nama_customer,
				customer.alamat_customer,
				customer.unit_customer,
				voucher.id_owner,
				owner.nama_owner,
				owner.alamat_owner,
				voucher.total,
				voucher.so,
				voucher.relasi
			FROM voucher 
				JOIN customer 
				ON customer.kode_customer = voucher.id_customer 
				JOIN owner 
				ON owner.kode_owner = voucher.id_owner
			WHERE voucher.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function print($id)
	{
		$sql =
			"SELECT 
				voucher.id_voucher, 
				voucher.bukti_transaksi, 
				voucher.id_customer, 
				customer.nama_customer, 
				customer.unit_customer, 
				customer.alamat_customer, 
				customer.kode_virtual AS cusKode, 
				voucher.id_owner, 
				owner.nama_owner, 
				owner.unit_owner, 
				owner.alamat_owner, 
				owner.kode_virtual AS ownKode, 
				voucher.tipe_giro, 
				giro_type.type_giro_name, 
				voucher.bank, 
				coa.coa_id, 
				coa.coa_name,
				coa.cf, 
				voucher.tanggal_voucher, 
				UPPER(voucher.keterangan) AS keterangan, 
				voucher.total, 
				voucher.so,
				voucher.relasi
			FROM voucher 
				JOIN customer 
				ON customer.kode_customer = voucher.id_customer 
				JOIN owner 
				ON owner.kode_owner = voucher.id_owner 
				JOIN giro_type 
				ON giro_type.giro_type_id = voucher.tipe_giro 
				JOIN coa 
				ON coa.id_akun = voucher.bank 
			WHERE voucher.id_voucher = '{$id}'";

		$data = $this->db->query($sql);

		return $data->result();
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_voucher extends CI_Model
{
	private $tableName = 'voucher';

	public function select_all()
	{
		$query =
			"SELECT
				v.id_voucher,
				v.bukti_transaksi,
				v.id_customer,
				c.nama_customer,
				c.unit_customer,
				v.id_owner,
				o.nama_owner,
				o.unit_owner,
				v.tipe_giro,
				v.bank,
				co.coa_id,
				co.coa_name,
				v.tanggal_voucher,
				v.keterangan,
				v.total,
				v.so,
				v.relasi,
				v.titipan
			FROM voucher v
				JOIN customer c
				ON c.kode_customer = v.id_customer
				JOIN owner o
				ON o.kode_owner = v.id_owner
				JOIN coa co
				ON co.id_akun = v.bank";

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
					c.unit_customer,
					v.id_owner,
					o.nama_owner,
					o.unit_owner,
					v.tipe_giro,
					v.bank,
					co.coa_id,
					co.coa_name,
					v.tanggal_voucher,
					v.keterangan,
					v.total,
					v.so,
					v.relasi,
					v.titipan
				FROM voucher v
					JOIN customer c
					ON c.kode_customer = v.id_customer
					JOIN owner o
					ON o.kode_owner = v.id_owner
					JOIN coa co
					ON co.id_akun = v.bank
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
					c.unit_customer,
					v.id_owner,
					o.nama_owner,
					o.unit_owner,
					v.tipe_giro,
					v.bank,
					co.coa_id,
					co.coa_name,
					v.tanggal_voucher,
					v.keterangan,
					v.total,
					v.so,
					v.relasi,
					v.titipan
				FROM voucher v
					JOIN customer c
					ON c.kode_customer = v.id_customer
					JOIN owner o
					ON o.kode_owner = v.id_owner
					JOIN coa co
					ON co.id_akun = v.bank
				WHERE v.tanggal_voucher <= CURDATE() AND (MONTH(v.tanggal_voucher) = MONTH(CURDATE()) OR MONTH(v.tanggal_voucher) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))) AND YEAR(v.tanggal_voucher) = YEAR(CURDATE())";

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
				c.unit_customer,
				v.id_owner,
				o.nama_owner,
				o.unit_owner,
				v.tipe_giro,
				v.bank,
				co.coa_id,
				co.coa_name,
				v.tanggal_voucher,
				v.keterangan,
				v.total,
				v.so,
				v.relasi,
				v.titipan
			FROM voucher v
				JOIN customer c
				ON c.kode_customer = v.id_customer
				JOIN owner o
				ON o.kode_owner = v.id_owner
				JOIN coa co
				ON co.id_akun = v.bank
			WHERE v.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->row();
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

	public function bayar_update($post)
	{
		for ($i = 0; $i < count($post['idv']); $i++) {
			$CoA = $this->M_coa->select_by_id($post['coa'][$i]);
			if ($post['giro'] == 1 || $post['giro'] == 2) {
				if ($CoA->parent == 1 && $post['debit'][$i] > 0 || $CoA->parent == 3 && $post['debit'][$i] > 0 || $CoA->parent == 4 && $post['debit'][$i] > 0 || $CoA->parent == 5 && $post['debit'][$i] > 0  || $CoA->parent == 7 && $post['debit'][$i] > 0 || $CoA->parent == 187 && $post['debit'][$i] > 0) {
					$data = array(
						'bank' => $post['coa'][$i],
						'tanggal_voucher' => $post['vouDate'],
						'keterangan' => $post['ket'][$i],
						'total' => $post['debit'][$i]
					);

					$where = array('id_voucher' => $post['id']);
					$this->db->update($this->tableName, $data, $where);

					return $this->db->affected_rows();
				}
			} else {
				if ($CoA->parent == 1 && $post['credit'][$i] > 0 || $CoA->parent == 3 && $post['credit'][$i] > 0 || $CoA->parent == 4 && $post['credit'][$i] > 0 || $CoA->parent == 5 && $post['credit'][$i] > 0  || $CoA->parent == 7 && $post['credit'][$i] > 0 || $CoA->parent == 187 && $post['credit'][$i]) {
					$data = array(
						'bank' => $post['coa'][$i],
						'tanggal_voucher' => $post['vouDate'],
						'keterangan' => $post['ket'][$i],
						'total' => $post['credit'][$i]
					);

					$where = array('id_voucher' => $post['id']);
					$this->db->update($this->tableName, $data, $where);

					return $this->db->affected_rows();
				}
			}
		}
		return $this->db->affected_rows();
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

	public function delete($id)
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

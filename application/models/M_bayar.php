<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_bayar extends CI_Model
{
	private $tableName = 'bayar';

	public function select_all()
	{
		$query =
			"SELECT
				bayar.id_bayar,
				bayar.id_voucher,
				bayar.id_ar,
				ar.id_customer AS arCus,
				customer.nama_customer AS arNama,
				customer.unit_customer AS arUnit,
				customer.alamat_customer AS arAlamat,
				ar.id_owner AS owner,
				owner.nama_owner AS arNamaOwner,
				owner.alamat_owner AS arAlamatOwner,
				owner.unit_owner AS arUnitOwner,
				ar.bukti_transaksi,
				UPPER(ar.keterangan) AS arKet,
				ar.total,
				ar.sisa,
				ar.status,
				ar.so,
				UPPER(bayar.keterangan) AS keterangan,
				bayar.tanggal_bayar,
				bayar.tipe_pembayaran,
				bayar.kode_soa,
				coa.coa_id,
				coa.coa_name,
				coa.parent,
				coa.cf,
				bayar.debit,
				bayar.credit,
				bayar.so,
				gl.id_gl
			FROM bayar
				JOIN ar
				ON ar.id_ar = bayar.id_ar
				JOIN customer
				ON customer.kode_customer = ar.id_customer
				JOIN owner
				ON owner.kode_owner = ar.id_owner
				JOIN coa
				ON coa.id_akun = bayar.kode_soa
				LEFT JOIN gl
				ON gl.bukti_transaksi = bayar.id_voucher
			WHERE coa.parent <> 1
				AND coa.parent <> 3
				AND coa.parent <> 4
				AND coa.parent <> 5
				AND coa.parent <> 7";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_filter($startDate, $endDate)
	{
		if (!empty($startDate) && !empty($endDate)) {

			$query =
				"SELECT
					bayar.id_bayar,
					bayar.id_voucher,
					bayar.id_ar,
					ar.id_customer AS arCus,
					customer.nama_customer AS arNama,
					customer.unit_customer AS arUnit,
					customer.alamat_customer AS arAlamat,
					ar.id_owner AS owner,
					owner.nama_owner AS arNamaOwner,
					owner.alamat_owner AS arAlamatOwner,
					owner.unit_owner AS arUnitOwner,
					ar.bukti_transaksi,
					UPPER(ar.keterangan) AS arKet,
					ar.total,
					ar.sisa,
					ar.status,
					ar.so,
					UPPER(bayar.keterangan) AS keterangan,
					bayar.tanggal_bayar,
					bayar.tipe_pembayaran,
					bayar.kode_soa,
					coa.coa_id,
					coa.coa_name,
					coa.parent,
					coa.cf,
					bayar.debit,
					bayar.credit,
					bayar.so,
					gl.id_gl
				FROM bayar
					JOIN ar
					ON ar.id_ar = bayar.id_ar
					JOIN customer
					ON customer.kode_customer = ar.id_customer
					JOIN owner
					ON owner.kode_owner = ar.id_owner
					JOIN coa
					ON coa.id_akun = bayar.kode_soa
					LEFT JOIN gl
					ON gl.bukti_transaksi = bayar.id_voucher
				WHERE coa.parent <> 1
					AND coa.parent <> 3
					AND coa.parent <> 4
					AND coa.parent <> 5
					AND coa.parent <> 7
					AND bayar.tanggal_bayar BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)";

			$data = $this->db->query($query);

			return $data->result();
		} else {
			$query =
				"SELECT
					bayar.id_bayar,
					bayar.id_voucher,
					bayar.id_ar,
					ar.id_customer AS arCus,
					customer.nama_customer AS arNama,
					customer.unit_customer AS arUnit,
					customer.alamat_customer AS arAlamat,
					ar.id_owner AS owner,
					owner.nama_owner AS arNamaOwner,
					owner.alamat_owner AS arAlamatOwner,
					owner.unit_owner AS arUnitOwner,
					ar.bukti_transaksi,
					UPPER(ar.keterangan) AS arKet,
					ar.total,
					ar.sisa,
					ar.status,
					ar.so,
					UPPER(bayar.keterangan) AS keterangan,
					bayar.tanggal_bayar,
					bayar.tipe_pembayaran,
					bayar.kode_soa,
					coa.coa_id,
					coa.coa_name,
					coa.parent,
					coa.cf,
					bayar.debit,
					bayar.credit,
					bayar.so,
					gl.id_gl
				FROM bayar
					JOIN ar
					ON ar.id_ar = bayar.id_ar
					JOIN customer
					ON customer.kode_customer = ar.id_customer
					JOIN owner
					ON owner.kode_owner = ar.id_owner
					JOIN coa
					ON coa.id_akun = bayar.kode_soa
					LEFT JOIN gl
					ON gl.bukti_transaksi = bayar.id_voucher
				WHERE coa.parent <> 1
					AND coa.parent <> 3
					AND coa.parent <> 4
					AND coa.parent <> 5
					AND coa.parent <> 7
					AND bayar.tanggal_bayar <= CURDATE() AND (MONTH(bayar.tanggal_bayar) = MONTH(CURDATE()) OR MONTH(bayar.tanggal_bayar) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)))";

			$data = $this->db->query($query);

			return $data->result();
		}
	}

	public function select_by_id($id)
	{
		$query =
			"SELECT
				bayar.id_bayar,
				bayar.id_voucher,
				bayar.id_ar,
				ar.id_customer AS arCus,
				customer.nama_customer AS arNama,
				customer.unit_customer AS arUnit,
				customer.alamat_customer AS arAlamat,
				ar.id_owner AS owner,
				owner.nama_owner AS arNamaOwner,
				owner.alamat_owner AS arAlamatOwner,
				owner.unit_owner AS arUnitOwner,
				ar.bukti_transaksi,
				UPPER(ar.keterangan) AS arKet,
				ar.total,
				ar.sisa,
				ar.status,
				ar.so,
				UPPER(bayar.keterangan) AS keterangan,
				bayar.tanggal_bayar,
				bayar.tipe_pembayaran,
				bayar.kode_soa,
				coa.coa_id,
				coa.coa_name,
				coa.parent,
				coa.cf,
				bayar.debit,
				bayar.credit,
				bayar.so,
				gl.id_gl
			FROM bayar
				JOIN ar
					ON ar.id_ar = bayar.id_ar
				JOIN customer
					ON customer.kode_customer = ar.id_customer
				JOIN owner
					ON owner.kode_owner = ar.id_owner
				JOIN coa
					ON coa.id_akun = bayar.kode_soa
				LEFT JOIN gl
					ON gl.bukti_transaksi = bayar.id_voucher
			WHERE bayar.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function insert_out($post)
	{
		$id = json_decode($_POST["id"]);
		$code = json_decode($_POST["bukti_transaksi"]);
		$akun = json_decode($_POST["akun"]);
		$debit = json_decode($_POST["debit"]);
		$credit = json_decode($_POST["credit"]);
		$keterangan = json_decode($_POST["keterangan"]);

		for ($i = 0; $i < count($id); $i++) {

			$CoA = $this->M_coa->select_by_coa($akun[$i]);

			if ($akun[$i] != NULL) {
				$data = array(
					'id_ar' => $id[$i],
					'id_voucher' =>  $code[$i],
					'type' => 'out',
					'keterangan' => $keterangan[$i],
					'tanggal_bayar' => $post['date'],
					'tipe_pembayaran' => $post['pemType'],
					'kode_soa' => $CoA->id_akun,
					'debit' => $debit[$i],
					'credit' => $credit[$i],
					'so' => 1
				);
				$this->db->insert($this->tableName, $data);
			}
		}
		return $this->db->affected_rows();
	}

	public function check_bayar($idAR)
	{
		$query =
			"SELECT
				bayar.id_bayar,
				bayar.id_ar
			FROM bayar
			WHERE
				(bayar.id_ar = '{$idAR}')";

		$data = $this->db->query($query);

		return $data->result();
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

	public function bayar_update($post)
	{

		for ($i = 0; $i < count($post['idv']); $i++) {
			$data = array(
				'id_voucher' => $post['id'],
				'keterangan' => $post['ket'][$i],
				'tanggal_bayar' => $post['vouDate'],
				'kode_soa' => $post['coa'][$i],
				'debit' => $post['debit'][$i],
				'credit' => $post['credit'][$i]
			);

			$where = array('id_bayar' => $post['idv'][$i]);
			$this->db->update($this->tableName, $data, $where);
		}

		$voucher = $this->M_voucher->select_by_id($post['id']);
		if ($voucher->tipe_giro == 1 || $voucher->tipe_giro == 2) {
			$data1 = array(
				'id_voucher' => $post['id'],
				'keterangan' => $post['keterangan'],
				'tanggal_bayar' => $post['vouDate'],
				'kode_soa' => $post['bank'],
				'debit' => $post['vouTotal'],
				'credit' => 0
			);

			$where1 = array('id_bayar' => $post['idbayar']);
			$this->db->update($this->tableName, $data1, $where1);
		} else {
			$data1 = array(
				'id_voucher' => $post['id'],
				'keterangan' => $post['keterangan'],
				'tanggal_bayar' => $post['vouDate'],
				'kode_soa' => $post['bank'],
				'debit' => 0,
				'credit' => $post['vouTotal']
			);

			$where1 = array('id_bayar' => $post['idbayar']);
			$this->db->update($this->tableName, $data1, $where1);
		}

		return $this->db->affected_rows();
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_bayar extends CI_Model
{
	private $tableName = 'bayar';

	public function select_filter($startDate, $endDate)
	{
		if (!empty($startDate) && !empty($endDate)) {

			$query =
				"SELECT
					bayar.id_bayar,
					bayar.id_voucher,
					bayar.id_ar,
					ar.bukti_transaksi,
					bayar.keterangan AS keterangan,
					bayar.tanggal_bayar,
					bayar.tipe_pembayaran,
					bayar.kode_soa,
					coa.coa_id,
					coa.coa_name,
					bayar.debit,
					bayar.credit,
					bayar.so,
					(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = bayar.id_voucher AND gl.kode_soa = bayar.kode_soa AND gl.keterangan = bayar.keterangan AND gl.debit = bayar.debit AND gl.credit = bayar.credit) AS id_gl
				FROM bayar
					JOIN ar
						ON ar.id_ar = bayar.id_ar
					JOIN customer
						ON customer.kode_customer = ar.id_customer
					JOIN owner
						ON owner.kode_owner = ar.id_owner
					JOIN coa
						ON coa.id_akun = bayar.kode_soa
				WHERE bayar.tanggal_bayar BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)";

			$data = $this->db->query($query);

			return $data->result();
		} else {
			$query =
				"SELECT
					bayar.id_bayar,
					bayar.id_voucher,
					bayar.id_ar,
					ar.bukti_transaksi,
					bayar.keterangan AS keterangan,
					bayar.tanggal_bayar,
					bayar.tipe_pembayaran,
					bayar.kode_soa,
					coa.coa_id,
					coa.coa_name,
					bayar.debit,
					bayar.credit,
					bayar.so,
					(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = bayar.id_voucher AND gl.kode_soa = bayar.kode_soa AND gl.keterangan = bayar.keterangan) AS id_gl
				FROM bayar
					JOIN ar
						ON ar.id_ar = bayar.id_ar
					JOIN customer
						ON customer.kode_customer = ar.id_customer
					JOIN owner
						ON owner.kode_owner = ar.id_owner
					JOIN coa
						ON coa.id_akun = bayar.kode_soa
				WHERE bayar.tanggal_bayar <= CURDATE() AND (MONTH(bayar.tanggal_bayar) = MONTH(CURDATE()) OR MONTH(bayar.tanggal_bayar) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)))";

			$data = $this->db->query($query);

			return $data->result();
		}
	}

	public function select_by_voucher_id($id)
	{
		$query =
			"SELECT
				bayar.id_bayar,
				bayar.id_voucher,
				bayar.id_ar,
				bayar.keterangan AS keterangan,
				bayar.tanggal_bayar,
				bayar.tipe_pembayaran,
				bayar.kode_soa,
				coa.coa_id,
				coa.coa_name,
				bayar.debit,
				bayar.credit,
				bayar.so,
				(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = bayar.id_voucher AND gl.kode_soa = bayar.kode_soa AND gl.keterangan = bayar.keterangan) AS id_gl
			FROM bayar
				JOIN ar
					ON ar.id_ar = bayar.id_ar
				JOIN customer
					ON customer.kode_customer = ar.id_customer
				JOIN owner
					ON owner.kode_owner = ar.id_owner
				JOIN coa
					ON coa.id_akun = bayar.kode_soa
			WHERE bayar.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function insert_out($post, $admin)
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
			$ownerCus = $this->M_owner->select_by_id($kodeOwner[$i]);

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
				$last_id = $this->db->insert_id();

				if($last_id != NULL){
					$glData = array(
						'bukti_transaksi' => $code[$i],
						'id_customer' => $ownerCus->customer,
						'id_owner' => $kodeOwner[$i],
						'tanggal_transaksi' => $post['date'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => $CoA->id_akun,
						'debit' => $debit[$i],
						'credit' =>$credit[$i],
						'so' => 1,
						'cash' => 1,
						'created_by' => $admin,
						'voucher_id' => $last_id
					);
	
					$this->M_gl->insert_voucher_from_detail($glData);
				}
			}
		}
		return $this->db->affected_rows();
	}

	public function insert_detail($post, $admin)
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
			$ownerCus = $this->M_owner->select_by_id($kodeOwner[$i]);

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
				$last_id = $this->db->insert_id();

				if($last_id != NULL){
					$glData = array(
						'bukti_transaksi' => $code[$i],
						'id_customer' => $ownerCus->customer,
						'id_owner' => $kodeOwner[$i],
						'tanggal_transaksi' => $post['date'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => $CoA->id_akun,
						'debit' => $debit[$i],
						'credit' =>$credit[$i],
						'so' => 1,
						'cash' => 1,
						'created_by' => $admin,
						'voucher_id' => $last_id
					);
	
					$this->M_gl->insert_voucher_from_detail($glData);
				}
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

		return $this->db->affected_rows();
	}

	public function get_by_voucher_id($id)
	{
		$query =
			"SELECT
				bayar.id_bayar,
				bayar.id_voucher,
				bayar.id_ar,
				bayar.keterangan AS keterangan,
				bayar.tanggal_bayar,
				bayar.tipe_pembayaran,
				bayar.kode_soa,
				coa.coa_id,
				coa.coa_name,
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
					ON gl.voucher_id = bayar.id_bayar
			WHERE bayar.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}
}

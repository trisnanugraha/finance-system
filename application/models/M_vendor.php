<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_vendor extends CI_Model
{
	private $tableName = 'vendor';

	public function select_filter($startDate, $endDate)
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
					vendor.so,
					(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = vendor.id_voucher AND gl.kode_soa = vendor.kode_soa AND gl.keterangan = vendor.keterangan AND gl.debit = vendor.debit AND gl.credit = vendor.credit) AS id_gl
				FROM vendor
					JOIN coa
					ON coa.id_akun = vendor.kode_soa
				WHERE vendor.tanggal_transaksi BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)";

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
					vendor.keterangan,
					vendor.debit,
					vendor.credit,
					vendor.so,
					(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = vendor.id_voucher AND gl.kode_soa = vendor.kode_soa AND gl.keterangan = vendor.keterangan AND gl.debit = vendor.debit AND gl.credit = vendor.credit) AS id_gl
				FROM vendor
					JOIN coa
					ON coa.id_akun = vendor.kode_soa
				WHERE vendor.tanggal_transaksi <= CURDATE() AND (MONTH(vendor.tanggal_transaksi) = MONTH(CURDATE()) OR MONTH(vendor.tanggal_transaksi) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))) AND YEAR(vendor.tanggal_transaksi) = YEAR(CURDATE())";

			$data = $this->db->query($query);

			return $data->result();
		}
	}

	public function select_by_voucher_id($id)
	{
		$query =
			"SELECT
				vendor.id_vendor,
				vendor.id_voucher,
				vendor.tanggal_transaksi,
				vendor.kode_soa,
				coa.coa_id,
				coa.coa_name,
				vendor.keterangan AS keterangan,
				vendor.debit,
				vendor.credit,
				vendor.so,
				(SELECT gl.id_gl FROM gl WHERE gl.bukti_transaksi = vendor.id_voucher AND gl.kode_soa = vendor.kode_soa AND gl.keterangan = vendor.keterangan AND gl.debit = vendor.debit AND gl.credit = vendor.credit) AS id_gl
			FROM vendor
				JOIN coa
					ON coa.id_akun = vendor.kode_soa
			WHERE vendor.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function update($post)
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
}

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

	public function get_by_voucher_id($id)
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
				gl.id_gl
			FROM vendor
				JOIN coa
					ON coa.id_akun = vendor.kode_soa
				LEFT JOIN gl
					ON gl.voucher_id = vendor.id_vendor
			WHERE vendor.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function insert($post, $admin)
	{
		$code = json_decode($_POST["code"]);
		$akun = json_decode($_POST["akun"]);
		$keterangan = json_decode($_POST["keterangan"]);
		$relasi = json_decode($_POST["relasi"]);
		$debit = json_decode($_POST["debit"]);
		$kredit = json_decode($_POST["kredit"]);

		for ($i = 0; $i < count($code); $i++) {

			$CoA = $this->M_coa->select_by_coa($akun[$i]);
			
			if ($akun[$i] != NULL) {
				$data = array(
					'id_voucher' => $code[$i],
					'kode_soa' =>  $CoA->id_akun,
					'tanggal_transaksi' => $post['date'],
					'keterangan' => $keterangan[$i],
					'debit' => $debit[$i],
					'credit' => $kredit[$i],
					'so' => 3
				);
				
				$this->db->insert($this->tableName, $data);
				$last_id = $this->db->insert_id();

				if($last_id != NULL){
					$glData = array(
						'bukti_transaksi' => $code[$i],
						'id_customer' => 'T-10A',
						'id_owner' => '10A',
						'tanggal_transaksi' => $post['date'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => $CoA->id_akun,
						'debit' => $debit[$i],
						'credit' => $kredit[$i],
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
		$keterangan = json_decode($_POST["keterangan"]);
		$akun = json_decode($_POST["akun"]);
		$debit = json_decode($_POST["debit"]);
		$kredit = json_decode($_POST["credit"]);

		for ($i = 0; $i < count($keterangan); $i++) {

			$CoA = $this->M_coa->select_by_coa($akun[$i]);
			
			if ($akun[$i] != NULL) {
				$data = array(
					'id_voucher' => $id,
					'kode_soa' =>  $CoA->id_akun,
					'tanggal_transaksi' => $post['vouDate'],
					'keterangan' => $keterangan[$i],
					'debit' => $debit[$i],
					'credit' => $kredit[$i],
					'so' => 3
				);
				
				$this->db->insert($this->tableName, $data);
				$last_id = $this->db->insert_id();

				if($last_id != NULL){
					$glData = array(
						'bukti_transaksi' => $id,
						'id_customer' => 'T-10A',
						'id_owner' => '10A',
						'tanggal_transaksi' => $post['vouDate'],
						'keterangan' => $keterangan[$i],
						'kode_soa' => $CoA->id_akun,
						'debit' => $debit[$i],
						'credit' => $kredit[$i],
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
}

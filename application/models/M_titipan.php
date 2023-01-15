<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_titipan extends CI_Model
{
	private $tableName = 'titipan';

	public function select_all()
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
				voucher.bank,
                cv.coa_id,
                cv.coa_name,
                voucher.relasi,
                gl.id_gl
			FROM titipan
				JOIN customer
				ON customer.kode_customer = titipan.id_customer
				JOIN owner
				ON owner.kode_owner = titipan.id_owner
				JOIN coa
				ON coa.id_akun = titipan.kode_soa
				LEFT JOIN voucher
                ON voucher.id_voucher = titipan.id_voucher
                LEFT JOIN coa cv
                ON cv.id_akun = voucher.bank
                LEFT JOIN gl
                ON gl.bukti_transaksi = titipan.id_voucher
            GROUP BY titipan.id_titipan";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_by_id($id)
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
				voucher.bank,
                cv.coa_id,
                cv.coa_name,
                voucher.relasi,
                gl.id_gl
			FROM titipan
				JOIN customer
				ON customer.kode_customer = titipan.id_customer
				JOIN owner
				ON owner.kode_owner = titipan.id_owner
				JOIN coa
				ON coa.id_akun = titipan.kode_soa
				LEFT JOIN voucher
                ON voucher.id_voucher = titipan.id_voucher
                LEFT JOIN coa cv
                ON cv.id_akun = voucher.bank
                LEFT JOIN gl
                ON gl.bukti_transaksi = titipan.id_voucher
			WHERE titipan.id_titipan = '{$id}'
			GROUP BY titipan.id_titipan";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_by_voucher_id($id)
	{
		$query =
			"SELECT
				titipan.id_titipan,
				titipan.id_customer,
				titipan.id_owner,
				titipan.kode_soa,
				titipan.id_voucher,
				titipan.so,
				titipan.tanggal_masuk,
				titipan.total,
				titipan.keterangan
			FROM titipan
			WHERE titipan.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_detail_by_voucher_id($id)
	{
		$query =
			"SELECT
				td.id_titipan,
				td.id_voucher,
				td.total,
				titipan.total AS totalTitipan
			FROM titipan_detail td
			JOIN titipan
				ON titipan.id_titipan = td.id_titipan
			WHERE td.id_voucher = '{$id}'";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function insert($post)
	{
		$id = json_decode($_POST["id"]);
		$code = json_decode($_POST["bukti_transaksi"]);
		$kodeOwner = json_decode($_POST["kodeOwner"]);
		$akun = json_decode($_POST["akun"]);
		$credit = json_decode($_POST["credit"]);
		$keterangan = json_decode($_POST["keterangan"]);

		for ($i = 0; $i < count($id); $i++) {

			$CoA = $this->M_coa->select_by_coa($akun[$i]);

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
					$this->db->insert($this->tableName, $data);
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
					$this->db->insert($this->tableName, $data);
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
					$this->db->insert($this->tableName, $data);
				}
			} else {
			}
		}
		return $this->db->affected_rows();
	}

	public function update_out($post)
	{
		$id = json_decode($_POST["id"]);
		$code = json_decode($_POST["bukti_transaksi"]);
		$akun = json_decode($_POST["akun"]);
		$debit = json_decode($_POST["debit"]);

		for ($i = 0; $i < count($id); $i++) {

			if ($akun[$i] != NULL) {
				$CoA = $this->M_coa->select_by_coa($akun[$i]);

				if ($CoA->parent == 187 && $debit[$i] > 0) {
					$sisa = ($post['total'] - $debit[$i]);
					$data = array(
						'total' => $sisa
					);
					$where = array('id_titipan' => $post['idt']);
					$this->db->update($this->tableName, $data, $where);

					$data2 = array(
						'id_titipan' => $post['idt'],
						'id_voucher' => $code[$i],
						'total' => $debit[$i]
					);
					$this->db->insert('titipan_detail', $data2);
				}
			}
		}
		return $this->db->affected_rows();
	}

	public function update_in($id)
	{
		$titipan = $this->M_titipan->select_detail_by_voucher_id($id);

		$data = array(
			'total' => $titipan[0]->totalTitipan + $titipan[0]->total
		);
		$where = array('id_titipan' => $titipan[0]->id_titipan);
		$this->db->update($this->tableName, $data, $where);

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

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_electricity extends CI_Model
{
	private $tableName = 'listrik';

	public function select_periode()
	{
		$sql = "SELECT listrik.id_listrik, listrik.id_periode, p.start_periode FROM listrik JOIN periode p ON(listrik.id_periode = p.id_periode) GROUP BY listrik.id_periode";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all_electricity()
	{
		$query = $this->db->select([
			'l.id_listrik',
			'l.id_customer',
			'c.nama_customer',
			'c.unit_customer',
			'l.id_tarif',
			't.tarif_listrik',
			'l.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'l.start_meter',
			'l.end_meter',
			'l.cons',
			'l.consumption',
			'l.ppju',
			'l.total',
			'l.prorate',
			'l.created_at'
		])->from('listrik l')
			->join('customer c', 'l.id_customer= c.kode_customer')
			->join('tarif t', 'l.id_tarif = t.id_tarif')
			->join('periode p', 'l.id_periode = p.id_periode')
			->order_by('l.id_listrik', 'ASC')
			->order_by('p.start_periode', 'ASC')
			->get();

		return $query->result();
	}

	public function select_filter($owner, $customer, $startDate, $endDate)
	{

		if (!empty($startDate) && !empty($endDate) && empty($owner) && empty($customer)) {

			$sql =
				"SELECT
					l.id_listrik,
					l.id_customer,
					c.nama_customer,
					c.unit_customer,
					c.id_owner,
					l.id_periode,
					p.start_periode,
					p.end_periode,
					l.total,
					l.prorate
				FROM listrik l
					JOIN customer c
					ON l.id_customer= c.kode_customer
					JOIN owner o
					ON c.id_owner = o.kode_owner
					JOIN periode p
					ON p.id_periode = l.id_periode
				WHERE p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, l.id_listrik";

			$query = $this->db->query($sql);
			return $query->result();
		} else if (!empty($customer) && !empty($startDate) && !empty($endDate) && empty($owner)) {

			$sql =
				"SELECT
					l.id_listrik,
					l.id_customer,
					c.nama_customer,
					c.unit_customer,
					c.id_owner,
					l.id_periode,
					p.start_periode,
					p.end_periode,
					l.total,
					l.prorate
				FROM listrik l
					JOIN customer c
					ON l.id_customer= c.kode_customer
					JOIN owner o
					ON c.id_owner = o.kode_owner
					JOIN periode p
					ON p.id_periode = l.id_periode
					WHERE l.id_customer = '{$customer}' AND p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, l.id_listrik";

			$query = $this->db->query($sql);
			return $query->result();
		} else if (!empty($customer) && !empty($startDate) && !empty($endDate) && !empty($owner)) {

			$sql =
				"SELECT
					l.id_listrik,
					l.id_customer,
					c.nama_customer,
					c.unit_customer,
					c.id_owner,
					l.id_periode,
					p.start_periode,
					p.end_periode,
					l.total,
					l.prorate
				FROM listrik l
					JOIN customer c
					ON l.id_customer= c.kode_customer
					JOIN owner o
					ON c.id_owner = o.kode_owner
					JOIN periode p
					ON p.id_periode = l.id_periode
					WHERE l.id_customer = '{$customer}' AND c.id_owner = '{$owner}' AND p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, l.id_listrik";

			$query = $this->db->query($sql);
			return $query->result();
		} else {

			$sql =
				"SELECT
					l.id_listrik,
					l.id_customer,
					c.nama_customer,
					c.unit_customer,
					c.id_owner,
					l.id_periode,
					p.start_periode,
					p.end_periode,
					l.total,
					l.prorate
				FROM listrik l
					JOIN customer c
					ON l.id_customer= c.kode_customer
					JOIN owner o
					ON c.id_owner = o.kode_owner
					JOIN periode p
					ON p.id_periode = l.id_periode
				-- WHERE p.start_periode <= CURDATE() AND MONTH(p.start_periode) = MONTH(CURDATE())
				ORDER BY p.start_periode DESC, l.id_listrik
				LIMIT 100";

			$query = $this->db->query($sql);
			return $query->result();
		}
	}

	public function select_all()
	{

		$query = $this->db->select([
			'l.id_listrik',
			'l.id_customer',
			'c.nama_customer',
			'c.unit_customer',
			'l.id_tarif',
			't.tarif_listrik',
			'l.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'l.start_meter',
			'l.end_meter',
			'l.cons',
			'l.consumption',
			'l.ppju',
			'l.total',
			'l.prorate',
			'l.created_at'
		])->from('listrik l')
			->join('customer c', 'l.id_customer= c.kode_customer')
			->join('tarif t', 'l.id_tarif = t.id_tarif')
			->join('periode p', 'l.id_periode = p.id_periode')
			->order_by('p.start_periode', 'DESC')
			->get();

		return $query->result();
	}

	public function select_by_id($id)
	{
		$query = $this->db->select([
			'l.id_listrik',
			'l.id_customer',
			'c.nama_customer',
			'c.unit_customer',
			'l.id_tarif',
			't.tarif_listrik',
			'l.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'l.start_meter',
			'l.end_meter',
			'l.cons',
			'l.consumption',
			'l.ppju',
			'l.total',
			'l.prorate',
			'l.created_at'
		])->from('listrik l')
			->join('customer c', 'l.id_customer= c.kode_customer')
			->join('tarif t', 'l.id_tarif = t.id_tarif')
			->join('periode p', 'l.id_periode = p.id_periode')
			->order_by('p.start_periode', 'DESC')
			->where('l.id_listrik', $id)
			->get();

		return $query->row();
	}

	public function select_detail($id)
	{
		$query = $this->db->select([
			'l.id_listrik',
			'l.id_customer',
			'c.nama_customer',
			'c.unit_customer',
			'c.alamat_customer',
			'l.id_tarif',
			't.tarif_listrik',
			'l.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'l.start_meter',
			'l.end_meter',
			'l.cons',
			'l.consumption',
			'l.ppju',
			'l.total',
			'l.prorate',
			'd.kapasitas',
			'l.created_at'
		])->from('listrik l')
			->join('customer c', 'l.id_customer= c.kode_customer')
			->join('tarif t', 'l.id_tarif = t.id_tarif')
			->join('periode p', 'l.id_periode = p.id_periode')
			->join('deskripsi d', 'd.id_deskripsi = c.id_deskripsi')
			->order_by('p.start_periode', 'DESC')
			->where('l.id_listrik', $id)
			->get();

		return $query->row();
	}

	public function select_by_customer($id)
	{
		$sql = "SELECT listrik.id_listrik AS id, 
						listrik.periode_start AS periodStart, 
						listrik.periode_end AS periodEnd, 
						listrik.due_date AS dueDate, 
						listrik.start_meter AS startMeter, 
						listrik.end_meter AS endMeter, 
						listrik.cons AS cons, 
						listrik.consumption AS consumption, 
						listrik.ppju AS ppju, 
						listrik.total AS total, 
						listrik.prorate AS prorate, 
						customer.kode_customer AS kodeCus, 
						customer.nama_customer AS nama, 
						deskripsi.kapasitas AS kapasitas 
						FROM listrik, customer, deskripsi 
						WHERE listrik.id_customer = customer.kode_customer 
						AND customer.id_deskripsi = deskripsi.id_deskripsi 
						AND listrik.id_listrik = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function get_last_id($dt)
	{
		$currentNumber = $this->db->query('SELECT get_increment_electric_id(?, ?) as maxNumber', [$dt->format('Y'), $dt->format('m')]);

		return $currentNumber->row();
	}

	public function update($data)
	{
		$sql = "UPDATE customer SET kode_virtual='" . $data['kodeVir'] . "', nama_customer='" . $data['nama'] . "', unit_customer='" . $data['unit'] . "', alamat_customer='" . $data['alamat'] . "', id_deskripsi=" . $data['jenis'] . " WHERE kode_customer='" . $data['kodeCus'] . "'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->delete($this->tableName, ['id_listrik' => $id]);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function insert($params)
	{
		$data = [
			'id_listrik' => $params['id_listrik'],
			'id_customer' => $params['id_customer'],
			'id_tarif' => $params['id_tarif'],
			'id_periode' => $params['id_periode'],
			'start_meter' => $params['start_meter'],
			'end_meter' => $params['end_meter'],
			'cons' => $params['cons'],
			'consumption' => $params['consumption'],
			'ppju' => $params['ppju'],
			'total' => $params['total'],
			'prorate' => $params['prorate']
		];
		$this->db->insert($this->tableName, $data);

		return $this->db->affected_rows();
	}

	public function insert_batch($data)
	{
		$this->db->insert_batch('listrik', $data);

		return $this->db->affected_rows();
	}

	public function select_by_customer_and_period($customer, $period)
	{
		$query = $this->db->select('*')
			->from($this->tableName)
			->where('id_customer', $customer)
			->where('id_periode', $period)
			->get();

		return $query->row();
	}

	public function check_nama($nama)
	{
		$this->db->where('id_listrik', $nama);
		$data = $this->db->get('listrik');

		return $data->num_rows();
	}

	public function check_owner($nama)
	{
		$this->db->where('id_customer', $nama);
		$data = $this->db->get('listrik');

		return $data->num_rows();
	}

	public function total_rows()
	{
		$data = $this->db->get('listrik');

		return $data->num_rows();
	}

	public function check_bill($id_customer, $id_periode)
	{
		$data = $this->db->where([
			'id_customer' => $id_customer,
			'id_periode' => $id_periode
		])
			->count_all_results('listrik');
		return $data;
	}
}

/* End of file M_electricity.php */
/* Location: ./application/models/M_electricity.php */

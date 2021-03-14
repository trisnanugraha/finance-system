<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_water extends CI_Model
{
	private $tableName = 'air';

	public function select_periode()
	{

		$sql = "SELECT air.kode_tagihan_air, air.id_periode, p.start_periode FROM air JOIN periode p ON(air.id_periode = p.id_periode) GROUP BY air.id_periode";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all_water()
	{

		$query = $this->db->select([
			'a.kode_tagihan_air',
			'a.kode_customer',
			'c.nama_customer',
			'c.unit_customer',
			'a.id_tarif',
			't.tarif_air',
			't.standing_charge',
			'a.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'a.start_meter',
			'a.end_meter',
			'a.cons',
			'a.consumption',
			'a.tax_area',
			'a.tax',
			'a.total',
			'a.prorate',
			'a.created_at'
		])->from("{$this->tableName} a")
			->join('customer c', 'a.kode_customer= c.kode_customer')
			->join('tarif t', 'a.id_tarif = t.id_tarif')
			->join('periode p', 'a.id_periode = p.id_periode')
			->order_by('a.kode_tagihan_air', 'ASC')
			->order_by('p.start_periode', 'ASC')
			->get();

		return $query->result();
	}

	public function select_filter($owner, $customer, $startDate, $endDate)
	{

		if (!empty($startDate) && !empty($endDate) && empty($owner) && empty($customer)) {

			$sql =
				"SELECT
					a.kode_tagihan_air,
					a.kode_customer,
					c.nama_customer,
					c.unit_customer,
					c.id_owner,
					a.id_periode,
					p.start_periode,
					p.end_periode,
					a.total,
					a.prorate
				FROM air a
				JOIN customer c
					ON a.kode_customer = c.kode_customer
					JOIN owner o
					ON c.id_owner = o.kode_owner
					JOIN periode p
					ON p.id_periode = a.id_periode
				WHERE p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, a.kode_tagihan_air";

			$query = $this->db->query($sql);
			return $query->result();
		} else if (!empty($customer) && !empty($startDate) && !empty($endDate) && empty($owner)) {

			$sql =
				"SELECT
					a.kode_tagihan_air,
					a.kode_customer,
					c.nama_customer,
					c.unit_customer,
					c.id_owner,
					a.id_periode,
					p.start_periode,
					p.end_periode,
					a.total,
					a.prorate
				FROM air a
				JOIN customer c
					ON a.kode_customer = c.kode_customer
					JOIN owner o
					ON c.id_owner = o.kode_owner
					JOIN periode p
					ON p.id_periode = a.id_periode
				WHERE a.kode_customer = '{$customer}' AND p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, a.kode_tagihan_air";

			$query = $this->db->query($sql);
			return $query->result();
		} else if (!empty($customer) && !empty($startDate) && !empty($endDate) && !empty($owner)) {

			$sql =
				"SELECT
					a.kode_tagihan_air,
					a.kode_customer,
					c.nama_customer,
					c.unit_customer,
					c.id_owner,
					a.id_periode,
					p.start_periode,
					p.end_periode,
					a.total,
					a.prorate
				FROM air a
				JOIN customer c
					ON a.kode_customer = c.kode_customer
					JOIN owner o
					ON c.id_owner = o.kode_owner
					JOIN periode p
					ON p.id_periode = a.id_periode
				WHERE a.kode_customer = '{$customer}' AND c.id_owner = '{$owner}' AND p.start_periode BETWEEN CAST('{$startDate}' AS DATE) AND CAST('{$endDate}' AS DATE)
				ORDER BY p.start_periode DESC, a.kode_tagihan_air";

			$query = $this->db->query($sql);
			return $query->result();
		} else {

			$sql =
				"SELECT
					a.kode_tagihan_air,
					a.kode_customer,
					c.nama_customer,
					c.unit_customer,
					c.id_owner,
					a.id_periode,
					p.start_periode,
					p.end_periode,
					a.total,
					a.prorate
				FROM air a
				JOIN customer c
					ON a.kode_customer = c.kode_customer
					JOIN owner o
					ON c.id_owner = o.kode_owner
					JOIN periode p
					ON p.id_periode = a.id_periode
				-- WHERE p.start_periode <= CURDATE() AND MONTH(p.start_periode) = MONTH(CURDATE())
				ORDER BY p.start_periode DESC, a.kode_tagihan_air ASC
				LIMIT 100";

			$query = $this->db->query($sql);
			return $query->result();
		}
	}

	public function select_all()
	{
		$query = $this->db->select([
			'a.kode_tagihan_air',
			'a.kode_customer',
			'c.nama_customer ',
			'c.unit_customer',
			'a.id_tarif',
			't.tarif_air',
			't.standing_charge',
			'a.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'a.start_meter',
			'a.end_meter',
			'a.cons',
			'a.consumption',
			'a.tax_area',
			'a.tax',
			'a.total',
			'a.prorate',
			'a.created_at'
		])->from("{$this->tableName} a")
			->join('customer c', 'a.kode_customer= c.kode_customer')
			->join('tarif t', 'a.id_tarif = t.id_tarif')
			->join('periode p', 'a.id_periode = p.id_periode')
			->order_by('a.kode_tagihan_air', 'DESC')
			->order_by('p.start_periode', 'DESC')
			->get();
		// $data = $this->db->query($sql);

		return $query->result();
	}

	public function select_by_id($id)
	{
		$query = $this->db->select([
			'a.kode_tagihan_air',
			'a.kode_customer',
			'c.nama_customer',
			'c.unit_customer',
			'a.id_tarif',
			't.tarif_air',
			't.standing_charge',
			'a.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'a.start_meter',
			'a.end_meter',
			'a.cons',
			'a.consumption',
			'a.tax_area',
			'a.tax',
			'a.total',
			'a.prorate',
			'a.created_at'
		])->from("{$this->tableName} a")
			->join('customer c', 'a.kode_customer= c.kode_customer')
			->join('tarif t', 'a.id_tarif = t.id_tarif')
			->join('periode p', 'a.id_periode = p.id_periode')
			->order_by('a.kode_tagihan_air', 'DESC')
			->order_by('p.start_periode', 'DESC')
			->where('a.kode_tagihan_air', $id)
			->get();

		return $query->row();
	}

	public function select_detail($id)
	{
		$query = $this->db->select([
			'a.kode_tagihan_air',
			'a.kode_customer',
			'c.nama_customer',
			'c.unit_customer',
			'c.alamat_customer',
			'a.id_tarif',
			't.tarif_air',
			't.standing_charge',
			'a.id_periode',
			'p.start_periode',
			'p.end_periode',
			'p.due_date',
			'p.amount_days',
			'a.start_meter',
			'a.end_meter',
			'a.cons',
			'a.consumption',
			'a.tax_area',
			'a.tax',
			'a.total',
			'a.prorate',
			'a.created_at'
		])->from("{$this->tableName} a")
			->join('customer c', 'a.kode_customer= c.kode_customer')
			->join('tarif t', 'a.id_tarif = t.id_tarif')
			->join('periode p', 'a.id_periode = p.id_periode')
			->where('a.kode_tagihan_air', $id)
			->order_by('a.kode_tagihan_air', 'DESC')
			->order_by('p.start_periode', 'DESC')
			->get();

		return $query->row();
	}

	public function select_by_customer($id)
	{
		$sql = "SELECT COUNT(*) AS jml FROM customer WHERE kode_customer = {$id}";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_by_tarif($id)
	{
		$sql = "SELECT COUNT(*) AS jml FROM tarif WHERE id_tarif = {$id}";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function update($data)
	{
		$sql = "UPDATE air SET kode_customer='" . $data['kodeCus'] . "', periode_start='" . $data['periodStart'] . "', periode_end='" . $data['periodEnd'] . "', due_date='" . $data['dueDate'] . "', start_meter=" . $data['startMeter'] . ", end_meter=" . $data['endMeter'] . ", cons=" . $data['cons'] . ", consumption=" . $data['consumption'] . ", tax_area=" . $data['taxArea'] . ", tax=" . $data['tax'] . ", total=" . $data['total'] . " WHERE kode_tagihan_air='" . $data['id'] . "'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->delete($this->tableName, ['kode_tagihan_air' => $id]);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function insert($params)
	{
		$data = [
			'kode_tagihan_air' => $params['idWater'],
			'kode_customer' => $params['kodeCus'],
			'id_tarif' => $params['id_tarif'],
			'id_periode' => $params['id_periode'],
			'start_meter' => $params['startMeter'],
			'end_meter' => $params['endMeter'],
			'cons' => $params['cons'],
			'consumption' => $params['consumption'],
			'tax_area' => $params['tax_area'],
			'tax' => $params['tax'],
			'total' => $params['total'],
			'prorate' => $params['prorate']
		];
		$this->db->insert($this->tableName, $data);

		return $this->db->affected_rows();
	}

	public function insert_batch($data)
	{
		$this->db->insert_batch('air', $data);
		return $this->db->affected_rows();
	}

	public function select_by_customer_and_period($customer, $period)
	{
		$query = $this->db->select('*')
			->from('air')
			->where('kode_customer', $customer)
			->where('id_periode', $period)
			->get();

		return $query->row();
	}

	public function check_tagihan($nama)
	{
		$this->db->where('kode_tagihan_air', $nama);
		$data = $this->db->get('air');

		return $data->num_rows();
	}

	public function total_rows()
	{
		$data = $this->db->get('air');

		return $data->num_rows();
	}

	public function check_bill($id_customer, $id_periode)
	{
		$data = $this->db->where([
			'kode_customer' => $id_customer,
			'id_periode' => $id_periode
		])
			->count_all_results('air');
		return $data;
	}

	public function get_last_id($dt)
	{
		$currentNumber = $this->db->query('SELECT get_increment_water_id(?, ?) as maxNumber', [$dt->format('Y'), $dt->format('m')]);

		return $currentNumber->row();
	}
}

/* End of file M_water.php */
/* Location: ./application/models/M_water.php */

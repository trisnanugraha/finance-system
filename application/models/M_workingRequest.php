<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_workingRequest extends CI_Model
{
	private $tableName = 'wo';

	public function select_all_wr(){

		$query = $this->db->select([
			'wr.no_invoice_wr',
			'wr.no_wo',
			'wr.no_wr',
			'wr.id_customer',
			'c.kode_customer',
			'c.nama_customer',
			'c.unit_customer',
			'c.alamat_customer',
			'wr.tanggal',
			'wr.keterangan',
			'wr.total'
		])->from("{$this->tableName} wr")
			->join('customer c', 'wr.id_customer = c.kode_customer')
			->order_by('wr.no_invoice_wr', 'ASC')
			->get();

		return $query->result();
	}

	public function select_filter($owner, $customer, $startDate, $endDate){
		
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
					a.total
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

		}else if (!empty($customer) && !empty($startDate) && !empty($endDate) && empty($owner)) {

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
					a.total
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
			
		}else if (!empty($customer) && !empty($startDate) && !empty($endDate) && !empty($owner)) {

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
					a.total
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
			
		}else{

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
					a.total
				FROM air a
				JOIN customer c
					ON a.kode_customer = c.kode_customer
					JOIN owner o
					ON c.id_owner = o.kode_owner
					JOIN periode p
					ON p.id_periode = a.id_periode
				-- WHERE p.start_periode <= CURDATE() AND MONTH(p.start_periode) = MONTH(CURDATE())
				ORDER BY p.start_periode DESC, a.kode_tagihan_air";
				
			$query = $this->db->query($sql);
			return $query->result();
		}
	}

	public function select_all()
	{
		$query = $this->db->select([
			'wr.no_invoice_wr',
			'wr.no_wo',
			'wr.no_wr',
			'c.kode_customer',
			'c.nama_customer',
			'c.unit_customer',
			'c.alamat_customer',
			'wr.tanggal',
			'wr.keterangan',
			'wr.total'
		])->from("{$this->tableName} wr")
			->join('customer c', 'wr.id_customer = c.kode_customer')
			->order_by('wr.no_invoice_wr', 'ASC')
			->get();
		// $data = $this->db->query($sql);

		return $query->result();
	}

	public function select_by_id($id)
	{
		$query = $this->db->select([
			'wr.no_invoice_wr',
			'wr.no_wo',
			'wr.no_wr',
			'wr.id_customer',
			'wr.tanggal',
			'wr.keterangan',
			'wr.total'
		])->from("{$this->tableName} wr")
			->join('customer c', 'wr.id_customer = c.kode_customer')
			->order_by('wr.no_invoice_wr', 'ASC')
			->where('wr.no_invoice_wr', $id)
			->get();

		return $query->row();
	}

	public function select_detail($id)
	{
		$query = $this->db->select([
			'wr.no_invoice_wr',
			'wr.no_wo',
			'wr.no_wr',
			'c.kode_customer',
			'c.nama_customer',
			'c.unit_customer',
			'c.alamat_customer',
			'wr.tanggal',
			'wr.keterangan',
			'wr.total'
		])->from("{$this->tableName} wr")
			->join('customer c', 'wr.id_customer = c.kode_customer')
			->order_by('wr.no_invoice_wr', 'ASC')
			->where('wr.no_invoice_wr', $id)
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
		$sql = "UPDATE wo SET no_wo='" . $data['noWO'] . "', no_wr='" . $data['noWR'] . "', id_customer='" . $data['idCustomer'] . "', tanggal=" . $data['tanggal'] . ", keterangan=" . $data['keterangan'] . ", total=" . $data['total'] . " WHERE no_invoice_wr ='" . $data['noInvoiceWR'] . "'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	// public function update($params)
	// {
	// 	$data = [
	// 		'no_wo' => $params['noWO'],
	// 		'no_wr' => $params['noWR'],
	// 		'id_customer' => $params['idCustomer'],
	// 		'tanggal' => $params['tanggal'],
	// 		'keterangan' => $params['keterangan'],
	// 		'total' => $params['total']
	// 	];

	// 	$where = ['no_invoice_wr' => $params['no_invoice_wr']];
	// 	$this->db->update($this->tableName, $data, $where);

	// 	return $this->db->affected_rows();
	// }

	public function delete($id)
	{
		$this->db->delete($this->tableName, ['no_invoice_wr' => $id]);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function insert($params)
	{
		$data = [
			'no_invoice_wr' => $params['noInvoiceWR'],
			'no_wo' => $params['noWO'],
			'no_wr' => $params['noWR'],
			'id_customer' => $params['idCustomer'],
			'tanggal' => $params['tanggal'],
			'keterangan' => $params['keterangan'],
			'total' => $params['total']
		];
		$this->db->insert($this->tableName, $data);

		return $this->db->affected_rows();
	}

	public function insert_batch($data)
	{
		$this->db->insert_batch('wo', $data);
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

	public function check_invoice($nama)
	{
		$this->db->where('no_invoice_wr', $nama);
		$data = $this->db->get('wo');

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

/* End of file M_workingRequest.php */
/* Location: ./application/models/M_workingRequest.php */

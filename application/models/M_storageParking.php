<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_storageParking extends CI_Model
{
	private $tableName = 'storage_parking';

	public function select_all_storageParking()
	{
		$query = $this->db->select([
			 'sp.no_invoice',
			 'sp.id_customer',
			 'c.nama_customer',
			 'sp.tanggal',
			 'sp.keterangan',
			 'sp.jumlah_kendaraan',
			 'sp.harga_parkir',
			 'sp.harga_gudang',
			 'sp.total',
			 'tsp.nama_type'
		])->from('storage_parking sp')
			->join('customer c', 'sp.id_customer= c.kode_customer')
			->join('type_storage_parking tsp', 'sp.id_type_sp = tsp.id_type_sp')
			->order_by('sp.no_invoice', 'ASC')
			->get();

		return $query->result();
	}

	public function select_filter($customer, $owner)
	{
		$query = $this->db->select([
			'sp.no_invoice',
			'sp.id_customer',
			'sp.tanggal',
			'sp.keterangan',
			'sp.jumlah_kendaraan',
			'sp.harga_parkir',
			'sp.harga_gudang',
			'sp.total',
			'c.nama_customer',
			'c.unit_customer',
			'tsp.nama_type'
		])->from('storage_parking sp')
			->join('customer c', 'sp.id_customer= c.kode_customer')
			->join('type_storage_parking tsp', 'sp.id_type_sp = tsp.id_type_sp')
			->join('owner o', 'c.id_owner = o.kode_owner');

		if (!empty($owner)) {
			$query = $query->where('o.kode_owner', $owner);
		}

		if (!empty($customer)) {
			$query = $query->where('c.kode_customer', $customer);
		}

		$query = $query->get();

		return $query->result();
	}
	
	public function select_all()
	{

		$query = $this->db->select([
			'sp.no_invoice',
			'c.kode_customer',
			'c.nama_customer',
			'sp.tanggal',
			'sp.keterangan',
			'sp.jumlah_kendaraan',
			'sp.harga_parkir',
			'sp.harga_gudang',
			'sp.total',
			'c.nama_customer',
			'c.unit_customer',
			'tsp.nama_type'
		])->from('storage_parking sp')
			->join('customer c', 'sp.id_customer = c.kode_customer')
			->join('type_storage_parking tsp', 'sp.id_type_sp = tsp.id_type_sp')
			->order_by('sp.no_invoice', 'ASC')
			->get();

		return $query->result();
	}

	public function select_by_id($id)
	{
		$query = $this->db->select([
			'sp.no_invoice',
			'sp.id_customer',
			'c.nama_customer',
			'sp.tanggal',
			'sp.keterangan',
			'sp.jumlah_kendaraan',
			'sp.harga_parkir',
			'sp.harga_gudang',
			'sp.total',
			'tsp.nama_type'
		])->from('storage_parking sp')
			->join('customer c', 'sp.id_customer = c.kode_customer')
			->join('type_storage_parking tsp', 'sp.id_type_sp = tsp.id_type_sp')
			->order_by('sp.no_invoice', 'ASC')
			->where('sp.no_invoice', $id)
			->get();

		return $query->row();
	}

	public function select_detail($id)
	{
		$query = $this->db->select([
			'sp.no_invoice',
			'c.kode_customer',
			'c.nama_customer',
			'c.unit_customer',
			'c.alamat_customer',
			'sp.tanggal',
			'sp.keterangan',
			'sp.jumlah_kendaraan',
			'sp.harga_parkir',
			'sp.harga_gudang',
			'sp.total',
			'tsp.nama_type'
		])->from('storage_parking sp')
			->join('customer c', 'sp.id_customer = c.kode_customer')
			->join('type_storage_parking tsp', 'sp.id_type_sp = tsp.id_type_sp')
			->order_by('sp.no_invoice', 'ASC')
			->where('sp.no_invoice', $id)
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
		$sql = "UPDATE storage_parking SET id_customer='" . $data['kodeCus'] . "', tanggal='" . $data['tanggal'] . "', keterangan='" . $data['keterangan'] . "', jumlah_kendaraan=" . $data['jumlahKendaraan'] . ", harga_parkir=" . $data['hargaParkir'] . ", harga_gudang=" . $data['hargaGudang'] . ", total=" . $data['total'] . " WHERE no_invoice='" . $data['noInvoice'] . "'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->delete($this->tableName, ['no_invoice' => $id]);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function insert($params)
	{
		$data = [
			'no_invoice' => $params['noInvoice'],
			'id_type_sp' => $params['type'],
			'id_customer' => $params['kodeCus'],
			'tanggal' => $params['tanggal'],
			'keterangan' => $params['keterangan'],
			'jumlah_kendaraan' => $params['jumlahKendaraan'],
			'harga_parkir' => $params['hargaParkir'],
			'harga_gudang' => $params['hargaGudang'],
			'total' => $params['total']
		];
		$this->db->insert($this->tableName, $data);

		return $this->db->affected_rows();
	}

	public function insert_batch($data)
	{
		$this->db->insert_batch('storage_parking', $data);

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

	public function check_invoice($nama)
	{
		$this->db->where('no_invoice', $nama);
		$data = $this->db->get('storage_parking');

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
		$data = $this->db->get('storage_parking');

		return $data->num_rows();
	}

	// public function check_bill($id_customer, $id_periode)
	// {
	// 	$data = $this->db->where([
	// 		'id_customer' => $id_customer,
	// 		'id_periode' => $id_periode
	// 	])
	// 		->count_all_results('listrik');
	// 	return $data;
	// }
}

/* End of file M_electricity.php */
/* Location: ./application/models/M_electricity.php */

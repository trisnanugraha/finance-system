<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_customer extends CI_Model
{
	private $tableName = "customer";

	var $column_order = array('', 'kode_customer', 'c.kode_virtual', 'nama_customer', 'unit_customer', 'c.id_owner');
    var $column_search = array('kode_customer', 'c.kode_virtual', 'nama_customer', 'unit_customer', 'c.id_owner');
    var $order = array('kode_customer' => 'asc');

	private function _get_datatables_query() {
		$this->db->select(
			'c.kode_customer AS kodeCus,
			c.kode_virtual AS kodeVir,
			c.nama_customer AS nama,
			c.unit_customer AS unit,
			c.alamat_customer AS alamat,
			c.id_deskripsi,
			c.id_owner AS owner,
			d.tipe_deskripsi AS tipe,
			d.kapasitas AS kapasitas,
			d.sqm AS luas');
			$this->db->from("{$this->tableName} c");
			$this->db->join('deskripsi d', 'c.id_deskripsi = d.id_deskripsi');
			$this->db->join('owner o', 'c.id_owner = o.kode_owner');
		$i = 0;
		foreach ($this->column_search as $item) { // loop column 
			if($_POST['search']['value']) { // if datatable send POST for search
                if($i===0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
		}
		  
		if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

	function get_datatables() {
		$this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result_array();
	}

	function count_filtered() {
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all(){
		return $this->db->count_all("{$this->tableName}");
	}

	public function select_all_customer()
	{
		$sql = "SELECT * FROM customer";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all()
	{

		$query = $this->db->select([
			'c.kode_customer AS kodeCus',
			'c.kode_virtual AS kodeVir',
			'c.nama_customer AS nama',
			'c.unit_customer AS unit',
			'c.alamat_customer AS alamat',
			'c.id_deskripsi',
			'o.kode_owner AS owner',
			'd.tipe_deskripsi AS tipe',
			'd.kapasitas AS kapasitas',
			'd.sqm AS luas'
		])->from("{$this->tableName} c")
			->join('deskripsi d', 'c.id_deskripsi = d.id_deskripsi')
			->join('owner o', 'c.id_owner = o.kode_owner')
			->order_by('c.kode_customer', 'ASC')
			->get();

		return $query->result();
	}
	
	public function select_filter($owner)
	{
		$query = $this->db->select([
			'c.kode_customer AS kodeCus',
			'c.kode_virtual AS kodeVir',
			'c.nama_customer AS nama',
			'c.unit_customer AS unit',
			'c.alamat_customer AS alamat',
			'c.id_deskripsi',
			'o.kode_owner AS owner',
			'd.jenis_deskripsi AS jenis',
			'd.kapasitas AS kapasitas',
			'd.sqm AS luas'
		])->from("{$this->tableName} c")
			->join('deskripsi d', 'c.id_deskripsi = d.id_deskripsi')
			->join('owner o', 'c.id_owner = o.kode_owner')
			->order_by('c.kode_customer', 'ASC');

		if (!empty($owner)) {
			$query = $query->where('o.kode_owner', $owner);
		}
		$query = $query->get();
		return $query->result();
	}

	public function select_by_id($id)
	{

		$query = $this->db->select([
			'c.kode_customer AS kodeCus',
			'c.kode_virtual AS kodeVir',
			'c.nama_customer AS nama',
			'c.unit_customer AS unit',
			'c.alamat_customer AS alamat',
			'c.id_deskripsi',
			'o.kode_owner AS owner',
			'd.jenis_deskripsi AS jenis',
			'd.kapasitas AS kapasitas',
			'd.sqm AS luas'
		])->from("{$this->tableName} c")
			->join('deskripsi d', 'c.id_deskripsi = d.id_deskripsi')
			->join('owner o', 'c.id_owner = o.kode_owner')
			->where('c.kode_customer', $id)
			->order_by('c.kode_customer', 'ASC')
			->get();

		return $query->row();
	}

	public function select_by_description($id)
	{
		$sql = "SELECT customer.kode_customer AS kodeCus, customer.kode_virtual AS kodeVir, customer.nama_customer AS nama, customer.unit_customer AS unit, customer.alamat_customer AS alamat, deskripsi.jenis_deskripsi AS jenis, deskripsi.tipe_deskripsi AS tipe, deskripsi.kapasitas AS kapasitas, deskripsi.sqm AS luas, owner.kode_owner AS owner FROM customer, deskripsi, owner WHERE customer.id_deskripsi = deskripsi.id_deskripsi AND customer.id_owner = owner.kode_owner AND customer.kode_customer='{$id}'";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function update($params)
	{
		
		$data = array(
			'kode_virtual' => $params['kodeVir'],
			'nama_customer' => $params['nama'],
			'unit_customer' => $params['unit'],
			'alamat_customer' => $params['alamat'],
			'id_deskripsi' => $params['jenis'],
			'id_owner' => $params['owner']
		);

		$where = array('kode_customer' => $params['kodeCus']);

		$this->db->update($this->tableName, $data, $where);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->delete($this->tableName, ['kode_customer' => $id]);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function insert($params)
	{
		$data = array(
			'kode_customer' => $params['kodeCus'],
			'kode_virtual' => $params['kodeVir'],
			'nama_customer' => $params['nama'],
			'unit_customer' => $params['unit'],
			'alamat_customer' => $params['alamat'],
			'id_deskripsi' => $params['jenis'],
			'id_owner' => $params['owner']
		);

		$this->db->insert($this->tableName, $data);

		return $this->db->affected_rows();
	}

	public function insert_batch($data)
	{
		$this->db->insert_batch($this->tableName, $data);
		return $this->db->affected_rows();
	}

	public function check_customer($kode)
	{
		$this->db->where('kode_customer', $kode);
		$data = $this->db->get('customer');

		return $data->num_rows();
	}

	public function total_rows()
	{
		$data = $this->db->get('customer');

		return $data->num_rows();
	}
}

/* End of file M_customer.php */
/* Location: ./application/models/M_customer.php */

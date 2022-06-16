<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_owner extends CI_Model {
	private $tableName = 'owner';
	var $column_order = array('', 'kode_owner', 'kode_virtual', 'nama_owner', 'unit_owner', 'is_active');
    var $column_search = array('kode_owner', 'kode_virtual', 'nama_owner', 'unit_owner', 'is_active');
    var $order = array('kode_owner' => 'asc'); 

	private function _get_datatables_query() {
		$this->db->select(
			'o.kode_owner AS id,
			o.kode_virtual AS kodeVir,
			o.nama_owner AS nama,
			o.unit_owner AS unit,
			o.alamat_owner AS alamat,
			o.id_deskripsi,
			d.tipe_deskripsi AS tipe,
			d.kapasitas AS kapasitas,
			d.sqm AS sqm,
			o.customer,
			o.is_active,');
			$this->db->from("{$this->tableName} o");
			$this->db->join('deskripsi d', 'o.id_deskripsi = d.id_deskripsi');
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


	public function select_all_owner() {
		
		$sql = "SELECT * FROM owner ORDER BY owner.nama_owner";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all() {

		$query = $this->db->select([
				'o.kode_owner AS id',
				'o.kode_virtual AS kodeVir',
				'o.nama_owner AS nama',
				'o.unit_owner AS unit',
				'o.alamat_owner AS alamat',
				'o.id_deskripsi',
				'd.tipe_deskripsi AS tipe',
				'd.kapasitas AS kapasitas',
				'd.sqm AS sqm',
				'o.customer',
				'o.is_active AS isActive'
			])->from("{$this->tableName} o")
				->join('deskripsi d', 'o.id_deskripsi = d.id_deskripsi')
				->order_by('o.kode_owner', 'ASC')
				->get();

		return $query->result();
	}

	public function select_by_id($id) {
		$query = $this->db->select([
			'o.kode_owner AS id',
			'o.kode_virtual AS kodeVir',
			'o.nama_owner AS nama',
			'o.unit_owner AS unit',
			'o.alamat_owner AS alamat',
			'o.id_deskripsi',
			'd.tipe_deskripsi AS tipe',
			'd.kapasitas AS kapasitas',
			'd.sqm AS sqm',
			'o.customer',
			'o.is_active AS isActive'
		])->from("{$this->tableName} o")
			->join('deskripsi d', 'o.id_deskripsi = d.id_deskripsi')
			->where('o.kode_owner', $id)
			->order_by('o.kode_owner', 'ASC')
			->get();
		
		return $query->row();
	}

	public function select_by_desc($id) {
		$sql = "SELECT deskripsi.jenis_deskripsi AS jenis, deskripsi.tipe_deskripsi AS tipe, deskripsi.kapasitas AS kapasitas FROM deskripsi WHERE deskripsi.id_deskripsi = owner.id_deskripsi AND owner.id_deskripsi = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_detail($id) {
		$sql = "SELECT owner.kode_owner AS id, owner.customer, owner.kode_virtual AS kodeVir, owner.nama_owner AS nama, owner.unit_owner AS unit, owner.is_active AS isActive, owner.alamat_owner AS alamat, deskripsi.jenis_deskripsi AS jenis, deskripsi.tipe_deskripsi AS tipe, deskripsi.kapasitas AS kapasitas FROM owner, deskripsi WHERE owner.id_deskripsi = deskripsi.id_deskripsi AND owner.kode_owner='{$id}'";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function check_owner($kode)
	{
		$this->db->where('kode_owner', $kode);
		$data = $this->db->get('owner');

		return $data->num_rows();
	}


	public function update($params) {
		$data = array(
			'kode_virtual' => $params['kodeVir'],
			'nama_owner' => $params['nama'],
			'unit_owner' => $params['unit'],
			'alamat_owner' => $params['alamat'],
			'id_deskripsi' => $params['jenis'],
			'is_active' => $params['is_active']
		);

		$where = array('kode_owner' => $params['id']);
		$this->db->update($this->tableName, $data, $where);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$this->db->delete($this->tableName, ['kode_owner' => $id]);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function insert($params) {
		$data = [
			'kode_owner' => $params['id'],
			'kode_virtual' => $params['kodeVir'],
			'nama_owner' => $params['nama'],
			'unit_owner' => $params['unit'],
			'alamat_owner' => $params['alamat'],
			'id_deskripsi' => $params['jenis'],
			'customer' => 'T-'.$params['id'],
			'.is_active' => true
		];
		$this->db->insert($this->tableName, $data);
		
		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		
		$this->db->insert_batch($this->tableName, $data);
		
		return $this->db->affected_rows();
	}

	public function check_id($nama) {
		
		$this->db->where('kode_owner', $nama);
		$data = $this->db->get('owner');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get($this->tableName);

		return $data->num_rows();
	}
}

/* End of file M_owner.php */
/* Location: ./application/models/M_owner.php */
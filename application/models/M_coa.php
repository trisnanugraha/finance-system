<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_coa extends CI_Model
{
	private $tableName = 'coa';
	var $column_order = array('coa_id', 'coa_name', 'type_name', 'acc_type'); //set column field database for datatable orderable
    var $column_search = array('coa_id', 'coa_name', 'type_name', 'acc_type'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('coa_id' => 'asc'); // default order 
  
	private function _get_datatables_query() {
		$this->db->select(
			'co.id_akun,
			co.parent,
			co.coa_id,
			co.coa_name,
			co.acc_type,
			co.jurnal_tipe,
			ct.type_name,
			co.parent_name');
			$this->db->from("{$this->tableName} co");
			$this->db->join('coa_type ct', 'ct.coa_type_id = co.jurnal_tipe');
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

	public function select_all_coa()
	{
		$sql = "SELECT * FROM coa ORDER BY coa.coa_id";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all_coa_ar()
	{
		$sql = "SELECT * FROM coa WHERE (coa.id_akun = 21 OR coa.id_akun = 22 OR coa.id_akun = 24) ORDER BY coa.coa_id";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all()
	{

		$query = $this->db->select([
			'co.id_akun',
			'co.parent',
			'co.coa_id',
			'co.coa_name',
			'co.acc_type',
			'co.jurnal_tipe',
			'ct.type_name',
			'co.parent_name'
		])->from("{$this->tableName} co")
			->join('coa_type ct', 'ct.coa_type_id = co.jurnal_tipe')
			->order_by('co.coa_id', 'ASC')
			->get();

		return $query->result();
	}

	public function select_by_id($id)
	{

		$query = $this->db->select([
			'co.id_akun',
			'co.parent',
			'co.coa_id',
			'co.coa_name',
			'co.acc_type',
			'co.jurnal_tipe',
			'co.parent_name',
			'ct.type_name'
		])->from("{$this->tableName} co")
			->join('coa_type ct', 'ct.coa_type_id = co.jurnal_tipe')
			->where('co.id_akun', $id)
			->order_by('co.coa_id', 'ASC')
			->get();

		return $query->row();
	}

	public function select_by_coa($id)
	{

		$query = $this->db->select([
			'co.id_akun',
			'co.parent',
			'co.coa_id',
			'co.coa_name',
			'co.acc_type',
			'co.jurnal_tipe',
			'co.parent_name',
			'ct.type_name'
		])->from("{$this->tableName} co")
			->join('coa_type ct', 'ct.coa_type_id = co.jurnal_tipe')
			->where('co.coa_id', $id)
			->order_by('co.coa_id', 'ASC')
			->get();

		return $query->row();
	}

	public function print()
	{

		$query = $this->db->select([
			'co.id_akun',
			'co.parent',
			'co.coa_id',
			'co.coa_name',
			'co.acc_type',
			'co.jurnal_tipe',
			'co.parent_name',
			'ct.type_name'
		])->from("{$this->tableName} co")
			->join('coa_type ct', 'ct.coa_type_id = co.jurnal_tipe')
			->group_by('co.coa_id')
			->order_by('co.coa_id', 'ASC')
			->get();

		return $query->result();
	}

	public function insert($params)
	{

		$this->db->insert($this->tableName, $params);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$where = ['id_akun' => $id];
		$this->db->delete($this->tableName, $where);

		if ($this->db->error()['code'] == 1451) {
			return false;
		} else {
			return true;
		}
	}

	public function select_bank()
	{
		$query =
			"SELECT 
					coa.id_akun,
					coa.parent,
					coa.coa_id,
					coa.parent_name,
					coa.coa_name
				FROM coa
				WHERE coa.id_akun = 8
					OR coa.id_akun = 9
					OR coa.id_akun = 10 
					OR coa.id_akun = 11
					OR coa.id_akun = 12
					OR coa.id_akun = 13
					OR coa.id_akun = 2
					OR coa.id_akun = 190
				ORDER BY coa.coa_id";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_kas()
	{
		$query =
			"SELECT 
					coa.id_akun,
					coa.parent,
					coa.coa_id,
					coa.parent_name,
					coa.coa_name
				FROM coa
				WHERE coa.id_akun = 2
				ORDER BY coa.coa_id";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_between_coa($coaA, $coaB)
	{
		$query =
			"SELECT 
					coa.id_akun,
					coa.parent,
					coa.coa_id,
					coa.parent_name,
					coa.coa_name
				FROM coa
				WHERE coa.id_akun BETWEEN '{$coaA}' AND '{$coaB}'
				ORDER BY coa.coa_id";

		$data = $this->db->query($query);

		return $data->result();
	}

	public function select_by_parent($parent)
	{

		$query =
			"SELECT 
				coa.id_akun, 
				coa.parent, 
				coa.coa_id, 
				coa.coa_name,
				coa.parent_name,
				coa.jurnal_tipe
			FROM coa 
			WHERE coa.id_akun = '{$parent}'
			ORDER BY coa.coa_id";

		$data = $this->db->query($query);

		return $data->result();
	}
}

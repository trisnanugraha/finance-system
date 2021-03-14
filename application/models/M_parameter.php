<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_parameter extends CI_Model
{

    private $tableName = 'parameter';

    public function select_by_id($id){
        $query = $this->db->select('*')
        ->from($this->tableName)
        ->where('id', $id)
        ->get();
        return $query->row();
    }
}
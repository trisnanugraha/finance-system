<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_candidate_key extends CI_Model
{

    private $tableName = 'candidate_key';
    
    public function select_by_id($id){
        $query = $this->db->select([
            'id',
            'name',
            'desc',
            'key',
            'counter_count'
        ])->from($this->tableName)
        ->where('id', $id)
        ->get();

        return $query->row();
    }

}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_auth extends CI_Model
{
	public function login($user, $pass)
	{

		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('username', $user);

		$data = $this->db->get();

		if ($data->num_rows() == 1) {
			$hash = $data->row()->password;
			if (password_verify($pass, $hash)) {
				return $data->row();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}

/* End of file M_auth.php */
/* Location: ./application/models/M_auth.php */
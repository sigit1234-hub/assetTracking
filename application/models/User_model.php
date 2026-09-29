<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	protected $table = 'users';

	public function get_by_email($email)
	{
		return $this->db->get_where($this->table, ['email' => $email])->row_array();
	}

	public function get($id)
	{
		return $this->db->get_where($this->table, ['id' => $id])->row_array();
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function touch_last_login($id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->table, ['last_login' => date('Y-m-d H:i:s')]);
	}
}

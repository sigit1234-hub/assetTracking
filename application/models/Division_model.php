<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Division_model extends CI_Model {
	protected $table = 'divisions';
	public function get_all() { return $this->db->order_by('name','ASC')->get($this->table)->result_array(); }
	public function get($id) { return $this->db->get_where($this->table, ['id'=>$id])->row_array(); }
}

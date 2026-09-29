<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
	protected $table = 'laptop_categories';

	public function get_all() { return $this->db->order_by('name','ASC')->get($this->table)->result_array(); }

	public function get_with_count()
	{
		$this->db->select('laptop_categories.*, COUNT(laptops.id) as total_unit');
		$this->db->from($this->table);
		$this->db->join('laptops', 'laptops.category_id = laptop_categories.id', 'left');
		$this->db->group_by('laptop_categories.id');
		$this->db->order_by('laptop_categories.name', 'ASC');
		return $this->db->get()->result_array();
	}

	public function create($data) { $this->db->insert($this->table, $data); return $this->db->insert_id(); }
	public function delete($id) { return $this->db->delete($this->table, ['id'=>$id]); }

	public function find_or_create_by_name($name)
	{
		$name = trim($name);
		if ($name === '') return NULL;
		$row = $this->db->where('LOWER(name) =', strtolower($name))->get($this->table)->row_array();
		if ($row) return $row['id'];
		return $this->create(['name' => $name]);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_model extends CI_Model {
	protected $table = 'laptop_brands';

	public function get_all() { return $this->db->order_by('name','ASC')->get($this->table)->result_array(); }

	public function get_with_count()
	{
		$this->db->select('laptop_brands.*, COUNT(laptops.id) as total_unit');
		$this->db->from($this->table);
		$this->db->join('laptops', 'laptops.brand_id = laptop_brands.id', 'left');
		$this->db->group_by('laptop_brands.id');
		$this->db->order_by('laptop_brands.name', 'ASC');
		return $this->db->get()->result_array();
	}

	public function create($data) { $this->db->insert($this->table, $data); return $this->db->insert_id(); }
	public function delete($id) { return $this->db->delete($this->table, ['id'=>$id]); }

	/**
	 * Cari brand berdasarkan nama (case-insensitive). Jika belum ada, buat otomatis.
	 * Dipakai saat import Excel supaya admin tidak perlu mendaftarkan merk lebih dulu.
	 */
	public function find_or_create_by_name($name)
	{
		$name = trim($name);
		if ($name === '') return NULL;
		$row = $this->db->where('LOWER(name) =', strtolower($name))->get($this->table)->row_array();
		if ($row) return $row['id'];
		return $this->create(['name' => $name]);
	}
}

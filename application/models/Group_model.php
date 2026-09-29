<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends CI_Model {

	protected $table = 'groups';

	public function get_all()
	{
		return $this->db->order_by('name', 'ASC')->get($this->table)->result_array();
	}

	public function get($id)
	{
		return $this->db->get_where($this->table, ['id' => $id])->row_array();
	}

	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	/**
	 * Cari grup berdasarkan nama (case-insensitive). Jika belum ada, buat otomatis.
	 * Dipakai saat import Excel data pekerja.
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

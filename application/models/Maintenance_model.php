<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance_model extends CI_Model {

	protected $table = 'maintenance';

	protected function base_select()
	{
		$this->db->select('maintenance.*, laptops.asset_id, laptops.model, laptop_brands.name as brand_name');
		$this->db->from($this->table);
		$this->db->join('laptops', 'laptops.id = maintenance.laptop_id', 'left');
		$this->db->join('laptop_brands', 'laptop_brands.id = laptops.brand_id', 'left');
	}

	public function get_active()
	{
		$this->base_select();
		$this->db->where('maintenance.status !=', 'selesai');
		$this->db->order_by('maintenance.date_in', 'DESC');
		return $this->db->get()->result_array();
	}

	public function get_history()
	{
		$this->base_select();
		$this->db->order_by('maintenance.date_in', 'DESC');
		return $this->db->get()->result_array();
	}

	public function get($id)
	{
		$this->base_select();
		$this->db->where('maintenance.id', $id);
		return $this->db->get()->row_array();
	}

	public function get_history_by_laptop($laptop_id)
	{
		$this->base_select();
		$this->db->where('maintenance.laptop_id', $laptop_id);
		$this->db->order_by('maintenance.date_in', 'DESC');
		return $this->db->get()->result_array();
	}

	public function create($data) { $this->db->insert($this->table, $data); return $this->db->insert_id(); }
	public function update($id, $data) { $this->db->where('id', $id); return $this->db->update($this->table, $data); }

	public function count_active() { return $this->db->where('status !=', 'selesai')->count_all_results($this->table); }
	public function count_waiting_parts() { return $this->db->where('status', 'menunggu-sparepart')->count_all_results($this->table); }
	public function count_completed_this_month()
	{
		$this->db->where('status', 'selesai');
		$this->db->where("DATE_FORMAT(date_out, '%Y-%m') =", date('Y-m'));
		return $this->db->count_all_results($this->table);
	}
	public function avg_duration_days()
	{
		$row = $this->db->select('AVG(DATEDIFF(date_out, date_in)) as avg_days')
			->where('status', 'selesai')->where('date_out IS NOT NULL', NULL, FALSE)
			->get($this->table)->row_array();
		return $row && $row['avg_days'] ? round($row['avg_days'], 1) : 0;
	}
}

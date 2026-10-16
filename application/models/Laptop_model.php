<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laptop_model extends CI_Model {

	protected $table = 'laptops';

	protected function base_select()
	{
		$this->db->select('laptops.*, laptop_brands.name as brand_name, laptop_categories.name as category_name,
			employees.name as employee_name, employees.id as employee_id, groups.name as group_name');
		$this->db->from($this->table);
		$this->db->join('laptop_brands', 'laptop_brands.id = laptops.brand_id', 'left');
		$this->db->join('laptop_categories', 'laptop_categories.id = laptops.category_id', 'left');
		$this->db->join('employees', 'employees.id = laptops.current_employee_id', 'left');
		$this->db->join('groups', 'groups.id = employees.group_id', 'left');
	}

	public function get_all($filters = [], $limit = NULL, $offset = 0)
	{
		$this->base_select();
		$this->apply_filters($filters);
		$this->db->order_by('laptops.id', 'DESC');
		if ($limit) $this->db->limit($limit, $offset);
		return $this->db->get()->result_array();
	}

	public function count_all($filters = [])
	{
		$this->db->from($this->table);
		$this->db->join('employees', 'employees.id = laptops.current_employee_id', 'left');
		$this->apply_filters($filters);
		return $this->db->count_all_results();
	}

	protected function apply_filters($filters)
	{
		if ( ! empty($filters['status'])) $this->db->where('laptops.status', $filters['status']);
		if ( ! empty($filters['status_in'])) $this->db->where_in('laptops.status', $filters['status_in']);
		if ( ! empty($filters['brand_id'])) $this->db->where('laptops.brand_id', $filters['brand_id']);
		if ( ! empty($filters['group_id'])) $this->db->where('employees.group_id', $filters['group_id']);
		if ( ! empty($filters['purchase_year'])) $this->db->where('laptops.purchase_year', $filters['purchase_year']);
		if ( ! empty($filters['location'])) $this->db->where('laptops.location', $filters['location']);
		if ( ! empty($filters['q']))
		{
			$q = $filters['q'];
			$this->db->group_start();
			$this->db->like('laptops.asset_id', $q);
			$this->db->or_like('laptops.serial_number', $q);
			$this->db->or_like('laptops.model', $q);
			$this->db->or_like('employees.name', $q);
			$this->db->group_end();
		}
	}

	public function get($id)
	{
		$this->base_select();
		$this->db->where('laptops.id', $id);
		return $this->db->get()->row_array();
	}

	public function get_by_asset_id($asset_id)
	{
		return $this->db->get_where($this->table, ['asset_id' => $asset_id])->row_array();
	}

	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function delete($id)
	{
		return $this->db->delete($this->table, ['id' => $id]);
	}

	public function serial_exists($serial_number)
	{
		return (bool) $this->db->where('serial_number', $serial_number)->count_all_results($this->table);
	}

	public function last_sequence()
	{
		$rows = $this->db->select('asset_id')->get($this->table)->result_array();
		$max = 0;
		foreach ($rows as $row)
		{
			if (preg_match('/CIS-(\d+)\//', $row['asset_id'], $m))
			{
				$max = max($max, (int) $m[1]);
			}
		}
		return $max;
	}

	/* -------- dashboard stats -------- */
	public function count_by_status($status)
	{
		return $this->db->where('status', $status)->count_all_results($this->table);
	}

	public function status_summary()
	{
		$statuses = ['tersedia','digunakan','maintenance','dipinjamkan','rusak','nonaktif'];
		$out = [];
		foreach ($statuses as $s) $out[$s] = $this->count_by_status($s);
		return $out;
	}

	public function usage_trend($months = 6)
	{
		// Menghitung jumlah laptop dengan status "digunakan" per bulan berdasarkan laptop_usage.start_date
		$labels = []; $data = [];
		for ($i = $months - 1; $i >= 0; $i--)
		{
			$ts = strtotime("-$i months");
			$label = date('M', $ts);
			$ym = date('Y-m', $ts);
			$count = $this->db->where("DATE_FORMAT(start_date, '%Y-%m') =", $ym)->count_all_results('laptop_usage');
			$labels[] = $label;
			$data[] = $count;
		}
		return ['labels' => $labels, 'data' => $data];
	}

	public function recent($limit = 5)
	{
		$this->base_select();
		$this->db->order_by('laptops.created_at', 'DESC');
		$this->db->limit($limit);
		return $this->db->get()->result_array();
	}

	public function total_value()
	{
		return $this->db->select_sum('purchase_price')->get($this->table)->row()->purchase_price;
	}

	public function count_per_group()
	{
		$this->db->select('groups.name as `group`, COUNT(laptops.id) as total');
		$this->db->from('laptops');
		$this->db->join('employees', 'employees.id = laptops.current_employee_id');
		$this->db->join('groups', 'groups.id = employees.group_id');
		$this->db->group_by('groups.name');
		return $this->db->get()->result_array();
	}
}

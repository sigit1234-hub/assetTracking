<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usage_model extends CI_Model {

	protected $table = 'laptop_usage';

	protected function base_select()
	{
		$this->db->select('laptop_usage.*, laptops.asset_id, laptops.model, laptops.serial_number, laptop_brands.name as brand_name, employees.nik as employee_nik,
			laptops.status as laptop_status,
			employees.name as employee_name, groups.name as group_name,
			bast.bast_number, bast.status as bast_status, bast.handover_type as bast_type,
			rb.bast_number as return_bast_number, rb.status as return_bast_status, rb.handover_date as return_bast_date');
		$this->db->from($this->table);
		$this->db->join('laptops', 'laptops.id = laptop_usage.laptop_id', 'left');
		$this->db->join('laptop_brands', 'laptop_brands.id = laptops.brand_id', 'left');
		$this->db->join('employees', 'employees.id = laptop_usage.employee_id', 'left');
		$this->db->join('groups', 'groups.id = employees.group_id', 'left');
		$this->db->join('bast', 'bast.id = laptop_usage.bast_id', 'left');
		$this->db->join('bast rb', 'rb.id = laptop_usage.return_bast_id', 'left');
	}

	/**
	 * Filter bersama untuk halaman Penggunaan Laptop & Riwayat Penggunaan.
	 * Kunci: q (SN / Asset ID / nama laptop / nama karyawan / PN / nomor BAST),
	 * laptop_id, group_id, brand_id, jenis (tetap|sementara), kondisi (overdue|segera),
	 * status (aktif|selesai), date_from, date_to (berdasarkan tanggal serah terima).
	 */
	protected function apply_filters($f)
	{
		if ( ! empty($f['q']))
		{
			$q = $f['q'];
			$this->db->group_start();
			$this->db->like('laptops.serial_number', $q);
			$this->db->or_like('laptops.asset_id', $q);
			$this->db->or_like('laptops.model', $q);
			$this->db->or_like('laptop_brands.name', $q);
			$this->db->or_like('employees.name', $q);
			$this->db->or_like('employees.nik', $q);
			$this->db->or_like('bast.bast_number', $q);
			$this->db->or_like('rb.bast_number', $q);
			$this->db->group_end();
		}
		if ( ! empty($f['laptop_id'])) $this->db->where('laptop_usage.laptop_id', $f['laptop_id']);
		if ( ! empty($f['group_id']))  $this->db->where('employees.group_id', $f['group_id']);
		if ( ! empty($f['brand_id']))  $this->db->where('laptops.brand_id', $f['brand_id']);

		if (($f['jenis'] ?? '') === 'tetap')      $this->db->where('laptop_usage.expected_return_date IS NULL', NULL, FALSE);
		if (($f['jenis'] ?? '') === 'sementara')  $this->db->where('laptop_usage.expected_return_date IS NOT NULL', NULL, FALSE);

		if (($f['kondisi'] ?? '') === 'overdue')
		{
			$this->db->where('laptop_usage.is_active', 1);
			$this->db->where('laptop_usage.expected_return_date <', date('Y-m-d'));
		}
		elseif (($f['kondisi'] ?? '') === 'segera')
		{
			$this->db->where('laptop_usage.is_active', 1);
			$this->db->where('laptop_usage.expected_return_date >=', date('Y-m-d'));
			$this->db->where('laptop_usage.expected_return_date <=', date('Y-m-d', strtotime('+7 days')));
		}

		if (($f['status'] ?? '') === 'aktif')   $this->db->where('laptop_usage.is_active', 1);
		if (($f['status'] ?? '') === 'selesai') $this->db->where('laptop_usage.is_active', 0);

		if ( ! empty($f['date_from'])) $this->db->where('laptop_usage.start_date >=', $f['date_from']);
		if ( ! empty($f['date_to']))   $this->db->where('laptop_usage.start_date <=', $f['date_to']);
	}

	public function get_active($filters = [])
	{
		$this->base_select();
		$this->db->where('laptop_usage.is_active', 1);
		$this->apply_filters($filters);
		$this->db->order_by('laptop_usage.start_date', 'DESC');
		return $this->db->get()->result_array();
	}

	public function get_history($filters = [])
	{
		$this->base_select();
		$this->apply_filters($filters);
		$this->db->order_by('laptop_usage.start_date', 'DESC');
		return $this->db->get()->result_array();
	}

	public function get_by_laptop($laptop_id)
	{
		$this->base_select();
		$this->db->where('laptop_usage.laptop_id', $laptop_id);
		$this->db->order_by('laptop_usage.start_date', 'DESC');
		return $this->db->get()->result_array();
	}

	public function get($id)
	{
		$this->base_select();
		$this->db->where('laptop_usage.id', $id);
		return $this->db->get()->row_array();
	}

	public function get_active_by_laptop($laptop_id)
	{
		$this->db->where(['laptop_id' => $laptop_id, 'is_active' => 1]);
		return $this->db->get($this->table)->row_array();
	}

	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function close($id, $data)
	{
		$data['is_active'] = 0;
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function close_link_return_bast($usage_id, $return_bast_id)
	{
		$this->db->where('id', $usage_id);
		return $this->db->update($this->table, ['return_bast_id' => $return_bast_id]);
	}

	public function count_active() { return $this->db->where('is_active', 1)->count_all_results($this->table); }

	public function count_loan()
	{
		$this->db->where('is_active', 1);
		$this->db->where('expected_return_date IS NOT NULL', NULL, FALSE);
		return $this->db->count_all_results($this->table);
	}

	public function count_due_soon($days = 7)
	{
		$this->db->where('is_active', 1);
		$this->db->where('expected_return_date IS NOT NULL', NULL, FALSE);
		$this->db->where('expected_return_date >=', date('Y-m-d'));
		$this->db->where('expected_return_date <=', date('Y-m-d', strtotime("+$days days")));
		return $this->db->count_all_results($this->table);
	}

	public function count_overdue()
	{
		$this->db->where('is_active', 1);
		$this->db->where('expected_return_date IS NOT NULL', NULL, FALSE);
		$this->db->where('expected_return_date <', date('Y-m-d'));
		return $this->db->count_all_results($this->table);
	}

	public function get_overdue_list()
	{
		$this->base_select();
		$this->db->where('laptop_usage.is_active', 1);
		$this->db->where('laptop_usage.expected_return_date IS NOT NULL', NULL, FALSE);
		$this->db->where('laptop_usage.expected_return_date <', date('Y-m-d'));
		return $this->db->get()->result_array();
	}

	public function get_due_soon_list($days = 7)
	{
		$this->base_select();
		$this->db->where('laptop_usage.is_active', 1);
		$this->db->where('laptop_usage.expected_return_date IS NOT NULL', NULL, FALSE);
		$this->db->where('laptop_usage.expected_return_date >=', date('Y-m-d'));
		$this->db->where('laptop_usage.expected_return_date <=', date('Y-m-d', strtotime("+$days days")));
		return $this->db->get()->result_array();
	}
}

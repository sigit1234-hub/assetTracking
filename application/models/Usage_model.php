<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Usage_model extends CI_Model
{
    protected $table = 'laptop_usage';

    protected function base_select()
    {
        $this->db->select('laptop_usage.*, laptops.asset_id, laptops.model, laptops.status as laptop_status,
			employees.name as employee_name, groups.name as group_name,
			bast.bast_number, bast.status as bast_status');
        $this->db->from($this->table);
        $this->db->join('laptops', 'laptops.id = laptop_usage.laptop_id', 'left');
        $this->db->join('employees', 'employees.id = laptop_usage.employee_id', 'left');
        $this->db->join('groups', 'groups.id = employees.group_id', 'left');
        $this->db->join('bast', 'bast.id = laptop_usage.bast_id', 'left');
    }

    public function get_active($filters = [])
    {
        $this->base_select();
        $this->db->where('laptop_usage.is_active', 1);
        if (! empty($filters['q'])) {
            $this->db->group_start();
            $this->db->like('laptops.asset_id', $filters['q']);
            $this->db->or_like('employees.name', $filters['q']);
            $this->db->or_like('laptops.serial_number', $filters['q']);
            $this->db->group_end();
        }
        if (! empty($filters['group_id'])) {
            $this->db->where('employees.group_id', $filters['group_id']);
        }
        $this->db->order_by('laptop_usage.start_date', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_history($filters = [])
    {
        $this->base_select();
        if (! empty($filters['laptop_id'])) {
            $this->db->where('laptop_usage.laptop_id', $filters['laptop_id']);
        }
        if (! empty($filters['group_id'])) {
            $this->db->where('employees.group_id', $filters['group_id']);
        }
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

    public function count_active()
    {
        return $this->db->where('is_active', 1)->count_all_results($this->table);
    }

    public function count_loan()
    {
        $this->db->where('is_active', 1);
        $this->db->where('expected_return_date IS NOT NULL', null, false);
        return $this->db->count_all_results($this->table);
    }

    public function count_due_soon($days = 7)
    {
        $this->db->where('is_active', 1);
        $this->db->where('expected_return_date IS NOT NULL', null, false);
        $this->db->where('expected_return_date >=', date('Y-m-d'));
        $this->db->where('expected_return_date <=', date('Y-m-d', strtotime("+$days days")));
        return $this->db->count_all_results($this->table);
    }

    public function count_overdue()
    {
        $this->db->where('is_active', 1);
        $this->db->where('expected_return_date IS NOT NULL', null, false);
        $this->db->where('expected_return_date <', date('Y-m-d'));
        return $this->db->count_all_results($this->table);
    }

    public function get_overdue_list()
    {
        $this->base_select();
        $this->db->where('laptop_usage.is_active', 1);
        $this->db->where('laptop_usage.expected_return_date IS NOT NULL', null, false);
        $this->db->where('laptop_usage.expected_return_date <', date('Y-m-d'));
        return $this->db->get()->result_array();
    }

    public function get_due_soon_list($days = 7)
    {
        $this->base_select();
        $this->db->where('laptop_usage.is_active', 1);
        $this->db->where('laptop_usage.expected_return_date IS NOT NULL', null, false);
        $this->db->where('laptop_usage.expected_return_date >=', date('Y-m-d'));
        $this->db->where('laptop_usage.expected_return_date <=', date('Y-m-d', strtotime("+$days days")));
        return $this->db->get()->result_array();
    }
}

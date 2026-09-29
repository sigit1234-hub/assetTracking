<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Employee_model extends CI_Model
{
    protected $table = 'employees';

    protected function base_select()
    {
        $this->db->select('employees.*, groups.name as group_name');
        $this->db->from($this->table);
        $this->db->join('groups', 'groups.id = employees.group_id', 'left');
    }

    public function get_all($filters = [], $limit = null, $offset = 0)
    {
        $this->base_select();
        $this->apply_filters($filters);
        $this->db->order_by('employees.name', 'ASC');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    public function count_all($filters = [])
    {
        $this->db->from($this->table);
        $this->db->join('groups', 'groups.id = employees.group_id', 'left');
        $this->apply_filters($filters);
        return $this->db->count_all_results();
    }

    protected function apply_filters($filters)
    {
        if (! empty($filters['group_id'])) {
            $this->db->where('employees.group_id', $filters['group_id']);
        }
        if (! empty($filters['q'])) {
            $q = $filters['q'];
            $this->db->group_start();
            $this->db->like('employees.name', $q);
            $this->db->or_like('employees.nik', $q);
            $this->db->or_like('employees.email', $q);
            $this->db->group_end();
        }
    }

    public function get($id)
    {
        $this->base_select();
        $this->db->where('employees.id', $id);
        return $this->db->get()->row_array();
    }

    public function nik_exists($nik)
    {
        return (bool) $this->db->where('nik', $nik)->count_all_results($this->table);
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
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

	protected $table = 'notifications';

	public function get_all($limit = 30)
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit($limit);
		return $this->db->get($this->table)->result_array();
	}

	public function count_unread() { return $this->db->where('is_read', 0)->count_all_results($this->table); }

	public function mark_read($id) { return $this->db->update($this->table, ['is_read' => 1], ['id' => $id]); }

	public function mark_all_read() { return $this->db->update($this->table, ['is_read' => 1]); }

	public function create($data) { $this->db->insert($this->table, $data); return $this->db->insert_id(); }
}

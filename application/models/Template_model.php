<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_model extends CI_Model {

	protected $table = 'bast_templates';

	public function get_all()
	{
		$rows = $this->db->order_by('id', 'ASC')->get($this->table)->result_array();
		return array_map([$this, 'with_defaults'], $rows);
	}

	public function get_by_type($handover_type)
	{
		$row = $this->db->get_where($this->table, ['handover_type' => $handover_type])->row_array();
		return $this->with_defaults($row);
	}

	/**
	 * Pastikan field signer_name/signer_role/approver_name/approver_role selalu
	 * ada di array (walau NULL), supaya tidak terjadi "Undefined array key"
	 * kalau database belum di-migrasi dengan kolom terbaru.
	 * Lihat: database/migration_template_signers.sql
	 */
	private function with_defaults($row)
	{
		if ( ! $row) return $row;
		$defaults = ['signer_name' => NULL, 'signer_role' => NULL, 'approver_name' => NULL, 'approver_role' => NULL];
		return array_merge($defaults, $row);
	}

	public function update_by_type($handover_type, $data)
	{
		$this->db->where('handover_type', $handover_type);
		return $this->db->update($this->table, $data);
	}
}

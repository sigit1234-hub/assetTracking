<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bast_model extends CI_Model {

	protected $table = 'bast';

	protected function base_select()
	{
		$this->db->select('bast.*, laptops.asset_id, laptops.model, laptops.serial_number, laptops.brand_id,
			laptop_brands.name as brand_name,
			employees.name as employee_name, employees.nik, employees.position, employees.email as employee_email,
			employees.phone as employee_phone,
			groups.name as group_name,
			users.name as created_by_name');
		$this->db->from($this->table);
		$this->db->join('laptops', 'laptops.id = bast.laptop_id', 'left');
		$this->db->join('laptop_brands', 'laptop_brands.id = laptops.brand_id', 'left');
		$this->db->join('employees', 'employees.id = bast.employee_id', 'left');
		$this->db->join('groups', 'groups.id = employees.group_id', 'left');
		$this->db->join('users', 'users.id = bast.created_by', 'left');
	}

	public function get_all($filters = [], $limit = NULL, $offset = 0)
	{
		$this->base_select();
		$this->apply_filters($filters);
		$this->db->order_by('bast.id', 'DESC');
		if ($limit) $this->db->limit($limit, $offset);
		return $this->db->get()->result_array();
	}

	public function count_all($filters = [])
	{
		$this->db->from($this->table);
		$this->db->join('employees', 'employees.id = bast.employee_id', 'left');
		$this->apply_filters($filters);
		return $this->db->count_all_results();
	}

	protected function apply_filters($filters)
	{
		if ( ! empty($filters['status'])) $this->db->where('bast.status', $filters['status']);
		if ( ! empty($filters['group_id'])) $this->db->where('employees.group_id', $filters['group_id']);
		if ( ! empty($filters['laptop_id'])) $this->db->where('bast.laptop_id', $filters['laptop_id']);
		if ( ! empty($filters['q']))
		{
			$q = $filters['q'];
			$this->db->group_start();
			$this->db->like('bast.bast_number', $q);
			$this->db->or_like('employees.name', $q);
			$this->db->group_end();
		}
	}

	public function get($id)
	{
		$this->base_select();
		$this->db->where('bast.id', $id);
		return $this->db->get()->row_array();
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

	public function last_sequence_this_year()
	{
		$this->db->like('bast_number', 'BAST/IT/' . date('Y'), 'after');
		$row = $this->db->select('bast_number')->order_by('id', 'DESC')->limit(1)->get($this->table)->row_array();
		if ( ! $row) return 0;
		preg_match('/(\d+)$/', $row['bast_number'], $m);
		return isset($m[1]) ? (int) $m[1] : 0;
	}

	public function count_by_status($status)
	{
		return $this->db->where('status', $status)->count_all_results($this->table);
	}

	public function status_summary()
	{
		$out = [];
		foreach (['draft','menunggu','aktif','selesai','dibatalkan'] as $s) $out[$s] = $this->count_by_status($s);
		return $out;
	}

	public function sign_receiver($id)
	{
		$data = ['signed_by_receiver' => 1];
		$bast = $this->get($id);
		if ($bast && $bast['signed_by_approver']) $data['status'] = 'aktif';
		else $data['status'] = 'menunggu';
		return $this->update($id, $data);
	}

	public function sign_approver($id)
	{
		$data = ['signed_by_approver' => 1];
		$bast = $this->get($id);
		if ($bast && $bast['signed_by_receiver']) $data['status'] = 'aktif';
		return $this->update($id, $data);
	}

	public function get_by_token($token)
	{
		$this->base_select();
		$this->db->where('bast.signature_token', $token);
		return $this->db->get()->row_array();
	}

	public function generate_signature_token($id)
	{
		$token = bin2hex(random_bytes(20));
		$this->update($id, ['signature_token' => $token]);
		return $token;
	}

	/**
	 * Simpan tanda tangan (path file gambar) untuk salah satu pihak: admin, receiver, atau approver.
	 * Otomatis memperbarui status BAST: jika penerima & atasan sudah TTD -> Aktif.
	 */
	public function save_signature($id, $role, $filepath)
	{
		$bast = $this->get($id);
		if ( ! $bast) return FALSE;

		$now = date('Y-m-d H:i:s');
		$data = [];

		if ($role === 'admin')
		{
			$data['admin_signature'] = $filepath;
			$data['admin_signed_at'] = $now;
		}
		elseif ($role === 'penerima')
		{
			$data['receiver_signature']  = $filepath;
			$data['receiver_signed_at']  = $now;
			$data['signed_by_receiver']  = 1;
		}
		elseif ($role === 'atasan')
		{
			$data['approver_signature']  = $filepath;
			$data['approver_signed_at']  = $now;
			$data['signed_by_approver']  = 1;
		}
		else
		{
			return FALSE;
		}

		$willBeReceiverSigned = $role === 'penerima' ? TRUE : (bool) $bast['signed_by_receiver'];
		$willBeApproverSigned = $role === 'atasan' ? TRUE : (bool) $bast['signed_by_approver'];

		if ($willBeReceiverSigned && $willBeApproverSigned) $data['status'] = 'aktif';
		elseif ($willBeReceiverSigned || $willBeApproverSigned) $data['status'] = 'menunggu';

		return $this->update($id, $data);
	}

	public function cancel($id)
	{
		return $this->update($id, ['status' => 'dibatalkan']);
	}

	public function complete($id)
	{
		return $this->update($id, ['status' => 'selesai']);
	}

	/**
	 * Buat dokumen BAST Pengembalian secara otomatis saat laptop dikembalikan
	 * (dipanggil dari Usage::process_return()). Dokumen ini langsung berstatus
	 * 'selesai' karena mencatat peristiwa yang sudah terjadi (bukan menunggu approval).
	 */
	public function create_return_document($laptop_id, $employee_id, $checklist, $overall_condition, $notes, $created_by)
	{
		$seq = $this->last_sequence_this_year();
		$data = [
			'bast_number'           => generate_bast_number($seq),
			'laptop_id'             => $laptop_id,
			'employee_id'           => $employee_id,
			'handover_type'         => 'pengembalian',
			'handover_date'         => date('Y-m-d'),
			'condition_on_handover' => $overall_condition,
			'checklist'             => json_encode($checklist),
			'notes'                 => $notes,
			'status'                => 'selesai',
			'signed_by_receiver'    => 1,
			'signed_by_approver'    => 1,
			'created_by'            => $created_by,
		];
		$id = $this->create($data);
		$this->generate_signature_token($id);
		return $id;
	}
}

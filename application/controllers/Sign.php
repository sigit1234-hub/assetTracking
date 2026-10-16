<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sign Controller
 * Halaman publik (tanpa login) untuk karyawan penerima & atasan menandatangani
 * BAST secara digital melalui link unik yang dibagikan (email/WhatsApp/dsb).
 */
class Sign extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Bast_model');
		$this->config->load('company');
	}

	public function pad($token = NULL, $role = NULL)
	{
		if ( ! $token || ! in_array($role, ['penerima', 'atasan'], TRUE))
		{
			show_404();
			return;
		}

		$bast = $this->Bast_model->get_by_token($token);
		if ( ! $bast)
		{
			echo $this->load->view('sign/invalid', ['message' => 'Link tanda tangan tidak valid atau sudah kedaluwarsa.'], TRUE);
			return;
		}

		if ($bast['status'] === 'dibatalkan')
		{
			echo $this->load->view('sign/invalid', ['message' => 'Dokumen BAST ini telah dibatalkan dan tidak dapat ditandatangani.'], TRUE);
			return;
		}

		// Token khusus peran tidak boleh dipakai untuk peran lain
		if ( ! empty($bast['token_role']) && $bast['token_role'] !== $role)
		{
			echo $this->load->view('sign/invalid', ['message' => 'Link tanda tangan tidak sesuai dengan peran Anda.'], TRUE);
			return;
		}

		$already_signed = ($role === 'penerima') ? $bast['signed_by_receiver'] : $bast['signed_by_approver'];

		$company = [
			'name'          => $this->config->item('company_name'),
			'division'      => $this->config->item('company_division'),
			'approver_name' => $this->config->item('default_approver_name'),
			'approver_role' => $this->config->item('default_approver_role'),
		];

		$data = [
			'bast'           => $bast,
			'role'           => $role,
			'role_label'     => $this->role_label($bast, $role),
			'signer_name'    => $role === 'penerima' ? $bast['employee_name'] : ($bast['approver_name'] ?: $company['approver_name']),
			'already_signed' => $already_signed,
			'company'        => $company,
			'token'          => $token,
		];

		$this->load->view('sign/pad', $data);
	}

	protected function role_label($bast, $role)
	{
		if ($bast['handover_type'] === 'pengembalian')
		{
			return $role === 'penerima' ? 'Penyerah (Yang Mengembalikan Perangkat)' : 'Team Leader / Mengetahui';
		}
		return $role === 'penerima' ? 'Penerima Perangkat' : 'Atasan / Mengetahui';
	}

	public function submit()
	{
		$token = $this->input->post('token');
		$role  = $this->input->post('role');
		$signature_data = $this->input->post('signature_data');

		if ( ! $token || ! in_array($role, ['penerima', 'atasan'], TRUE) || empty($signature_data))
		{
			$this->session->set_flashdata('sign_error', 'Data tanda tangan tidak lengkap. Silakan coba lagi.');
			redirect('ttd/' . $token . '/' . $role);
			return;
		}

		$bast = $this->Bast_model->get_by_token($token);
		if ( ! $bast)
		{
			show_404();
			return;
		}

		if ( ! empty($bast['token_role']) && $bast['token_role'] !== $role)
		{
			show_404();
			return;
		}

		// Decode base64 PNG dari canvas signature pad
		if (preg_match('/^data:image\/png;base64,(.+)$/', $signature_data, $m))
		{
			$binary = base64_decode($m[1]);
		}
		else
		{
			$this->session->set_flashdata('sign_error', 'Format tanda tangan tidak valid.');
			redirect('ttd/' . $token . '/' . $role);
			return;
		}

		$upload_dir = FCPATH . 'assets/uploads/signatures/';
		if ( ! is_dir($upload_dir)) mkdir($upload_dir, 0755, TRUE);

		$filename = 'ttd-' . $role . '-' . $bast['id'] . '-' . time() . '.png';
		file_put_contents($upload_dir . $filename, $binary);

		$relative_path = 'assets/uploads/signatures/' . $filename;
		$saved = $this->Bast_model->save_signature($bast['id'], $role, $relative_path);

		if ( ! $saved)
		{
			log_message('error', 'Gagal menyimpan tanda tangan BAST id=' . $bast['id'] . ' role=' . $role . '. Kemungkinan kolom signature belum ada di database — jalankan database/migration_ttd_digital.sql');
			echo $this->load->view('sign/invalid', [
				'message' => 'Terjadi kesalahan saat menyimpan tanda tangan. Silakan hubungi Admin IT — kemungkinan konfigurasi sistem perlu diperbarui.',
			], TRUE);
			return;
		}

		$this->load->view('sign/success', [
			'bast' => $bast,
			'role' => $role,
		]);
	}
}

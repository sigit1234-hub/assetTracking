<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bast extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Bast_model');
		$this->load->model('Laptop_model');
		$this->load->model('Employee_model');
		$this->load->model('Group_model');
		$this->load->model('Usage_model');
		$this->load->model('Template_model');
	}

	public function index()
	{
		$filters = [
			'status'      => $this->input->get('status'),
			'group_id' => $this->input->get('group_id'),
			'q'           => $this->input->get('q'),
		];
		// Daftar BAST hanya memuat Serah Terima Awal & Sementara
		$filters['exclude_type'] = 'pengembalian';

		$data = [
			'page_title' => 'Daftar BAST',
			'bast_list'  => $this->Bast_model->get_all($filters, 15, 0),
			'groups'     => $this->Group_model->get_all(),
			'filters'    => $filters,
			'summary'    => $this->Bast_model->status_summary('!pengembalian'),
		];
		$this->render('bast/index', $data);
	}

	/**
	 * Daftar BAST Pengembalian — terpisah dari Daftar BAST serah terima.
	 */
	public function returns()
	{
		$filters = [
			'status'   => $this->input->get('status'),
			'group_id' => $this->input->get('group_id'),
			'q'        => $this->input->get('q'),
		];
		$filters['handover_type'] = 'pengembalian';

		$data = [
			'page_title' => 'Daftar BAST Pengembalian',
			'bast_list'  => $this->Bast_model->get_all($filters, 15, 0),
			'groups'     => $this->Group_model->get_all(),
			'filters'    => $filters,
			'summary'    => $this->Bast_model->status_summary('pengembalian'),
		];
		$this->render('bast/returns', $data);
	}

	/**
	 * Wizard pembuatan BAST — 4 langkah, disimpan sementara di session
	 * agar admin dapat maju/mundur antar step tanpa kehilangan data.
	 */
	/**
	 * Pintu masuk khusus untuk BAST Serah Terima Sementara (peminjaman).
	 * Menggunakan wizard yang sama dengan Buat BAST Baru, hanya saja diberi
	 * penanda "is_loan" supaya field estimasi tanggal pengembalian WAJIB diisi
	 * dan judul halaman menyesuaikan.
	 */
	public function create()
	{
		$step = (int) $this->input->get('step') ?: 1;
		$wizard = $this->session->userdata('bast_wizard') ?: [];

		/**
		 * Mode "Sementara" (peminjaman) ditandai lewat ?mode=sementara di URL.
		 * Begitu terdeteksi, ditulis ke sesi wizard supaya tetap terbawa
		 * sepanjang step 2/3/4 walau URL step berikutnya tidak menyertakan
		 * parameter mode lagi.
		 *
		 * Kalau admin membuka "Buat BAST Baru" biasa dalam keadaan wizard
		 * benar-benar kosong (belum ada laptop terpilih, tanpa mode/laptop_id
		 * di URL), pastikan flag is_loan dari sesi SEBELUMNYA yang mungkin
		 * ditinggal begitu saja ikut di-reset — supaya tidak salah nyangkut.
		 */
		if ($this->input->get('mode') === 'sementara')
		{
			$wizard['is_loan'] = TRUE;
			$this->session->set_userdata('bast_wizard', $wizard);
		}
		elseif ($step === 1 && empty($wizard['laptop_id']) && ! $this->input->get('laptop_id'))
		{
			$wizard['is_loan'] = FALSE;
			$this->session->set_userdata('bast_wizard', $wizard);
		}

		/**
		 * Jika admin datang dari tombol "Buat BAST" di Data Laptop atau
		 * Detail Laptop (membawa ?laptop_id=X di URL), dan wizard belum
		 * punya laptop terpilih, langsung isi otomatis dan lompat ke Step 2
		 * — admin tidak perlu memilih ulang laptop yang sama dari daftar.
		 */
		$laptop_id_from_url = $this->input->get('laptop_id');
		if ($laptop_id_from_url && empty($wizard['laptop_id']))
		{
			$laptop_check = $this->Laptop_model->get($laptop_id_from_url);
			if ($laptop_check && in_array($laptop_check['status'], ['tersedia', 'digunakan'], TRUE))
			{
				$wizard['laptop_id'] = $laptop_id_from_url;
				$this->session->set_userdata('bast_wizard', $wizard);
				if ($step < 2) $step = 2;
			}
		}

		$selected_laptop = NULL;
		if ( ! empty($wizard['laptop_id'])) $selected_laptop = $this->Laptop_model->get($wizard['laptop_id']);

		$selected_employee = NULL;
		if ( ! empty($wizard['employee_id'])) $selected_employee = $this->Employee_model->get($wizard['employee_id']);

		$is_loan = ! empty($wizard['is_loan']);
		$handover_type_preview = ($is_loan || ! empty($wizard['expected_return_date'])) ? 'peminjaman' : 'serah_terima_awal';

		$data = [
			'page_title' => $is_loan ? 'Buat BAST Serah Terima Sementara' : 'Buat BAST Baru',
			'is_loan'    => $is_loan,
			'step'       => $step,
			'wizard'     => $wizard,
			'laptops'    => $this->Laptop_model->get_all(['status_in' => ['tersedia', 'digunakan']]),
			'employees'  => $this->Employee_model->get_all(),
			'groups'     => $this->Group_model->get_all(),
			'selected_laptop'  => $selected_laptop,
			'selected_employee'=> $selected_employee,
			'next_bast_number' => generate_bast_number($this->Bast_model->last_sequence_this_year()),
			'template'   => $this->Template_model->get_by_type($handover_type_preview),
		];
		$this->render('bast/create', $data);
	}

	public function save_step1()
	{
		$wizard = $this->session->userdata('bast_wizard') ?: [];
		$wizard['laptop_id'] = $this->input->post('laptop_id');
		$this->session->set_userdata('bast_wizard', $wizard);
		redirect('bast/buat?step=2');
	}

	public function save_step2()
	{
		$wizard = $this->session->userdata('bast_wizard') ?: [];

		$employee_id = $this->input->post('employee_id');
		if ($employee_id === 'new')
		{
			$group = $this->Group_model->get($this->input->post('group_id'));
			$employee_id = $this->Employee_model->create([
				'nik'         => $this->input->post('nik', TRUE),
				'name'        => $this->input->post('employee_name', TRUE),
				'position'    => $this->input->post('position', TRUE),
				'group_id' => $this->input->post('group_id') ?: NULL,
				'email'       => $this->input->post('email', TRUE),
				'phone'       => $this->input->post('phone', TRUE),
			]);
		}

		$wizard['employee_id'] = $employee_id;
		$this->session->set_userdata('bast_wizard', $wizard);
		redirect('bast/buat?step=3');
	}

	public function save_step3()
	{
		$wizard = $this->session->userdata('bast_wizard') ?: [];

		$checklist = [];
		foreach (['unit_laptop', 'charger', 'tas', 'mouse', 'adapter', 'aksesoris_lain'] as $item)
		{
			$checklist[$item] = $this->input->post('checklist_' . $item) ?: 'lengkap';
		}

		$expected_return_date = $this->input->post('expected_return_date') ?: NULL;

		// Untuk BAST Serah Terima Sementara, estimasi tanggal pengembalian WAJIB diisi
		// (validasi server-side, tidak cukup hanya mengandalkan atribut "required" di HTML).
		if ( ! empty($wizard['is_loan']) && ! $expected_return_date)
		{
			$this->session->set_flashdata('toast', 'Estimasi tanggal pengembalian wajib diisi untuk BAST Serah Terima Sementara.');
			redirect('bast/buat?step=3');
			return;
		}

		$wizard['handover_date']         = $this->input->post('handover_date') ?: date('Y-m-d');
		$wizard['location']              = $this->input->post('location', TRUE);
		$wizard['purpose']               = $this->input->post('purpose', TRUE);
		$wizard['expected_return_date']  = $expected_return_date;
		$wizard['condition_on_handover'] = $this->input->post('condition_on_handover', TRUE) ?: 'Baik';
		$wizard['checklist']             = $checklist;
		$wizard['notes']                 = $this->input->post('notes', TRUE);
		$wizard['signer_name']           = $this->input->post('signer_name', TRUE);
		$wizard['signer_role']           = $this->input->post('signer_role', TRUE);
		$wizard['approver_name']         = $this->input->post('approver_name', TRUE);
		$wizard['approver_role']         = $this->input->post('approver_role', TRUE);

		$this->session->set_userdata('bast_wizard', $wizard);
		redirect('bast/buat?step=4');
	}

	/**
	 * Finalisasi: dipanggil dari step 4 (preview) — men-generate dokumen BAST
	 * berdasarkan aksi tombol: draft | pdf | kirim
	 */
	public function finalize()
	{
		$wizard = $this->session->userdata('bast_wizard');
		if ( ! $wizard || empty($wizard['laptop_id']) || empty($wizard['employee_id']))
		{
			redirect('bast/buat');
			return;
		}

		$action = $this->input->post('action') ?: 'draft';
		$seq = $this->Bast_model->last_sequence_this_year();

		$status = 'draft';
		if ($action === 'send') $status = 'menunggu';

		// Kalau ada estimasi tanggal pengembalian, ini serah terima SEMENTARA (peminjaman).
		// Kalau tidak, ini serah terima AWAL/tetap.
		$handover_type = $wizard['expected_return_date'] ? 'peminjaman' : 'serah_terima_awal';
		$template = $this->Template_model->get_by_type($handover_type);

		$data = [
			'bast_number'           => generate_bast_number($seq),
			'laptop_id'             => $wizard['laptop_id'],
			'employee_id'           => $wizard['employee_id'],
			'handover_type'         => $handover_type,
			'handover_date'         => $wizard['handover_date'],
			'location'              => $wizard['location'],
			'purpose'               => $wizard['purpose'],
			'expected_return_date'  => $wizard['expected_return_date'] ?: NULL,
			'condition_on_handover' => $wizard['condition_on_handover'],
			'checklist'             => json_encode($wizard['checklist']),
			'notes'                 => $wizard['notes'],
			'status'                => $status,
			'approver_name'         => $wizard['approver_name'] ?: (($template && $template['approver_name']) ? $template['approver_name'] : $this->config->item('default_approver_name')),
			'approver_role'         => $wizard['approver_role'] ?: (($template && $template['approver_role']) ? $template['approver_role'] : $this->config->item('default_approver_role')),
			'signer_name'           => $wizard['signer_name'] ?: (($template && $template['signer_name']) ? $template['signer_name'] : NULL),
			'signer_role'           => $wizard['signer_role'] ?: (($template && $template['signer_role']) ? $template['signer_role'] : NULL),
			'created_by'            => $this->current_user['id'],
		];

		$bast_id = $this->Bast_model->create($data);
		$this->Bast_model->generate_signature_token($bast_id);

		// Tandai laptop sedang digunakan/dipinjamkan & catat sesi penggunaan
		$laptop = $this->Laptop_model->get($wizard['laptop_id']);
		$new_status = $wizard['expected_return_date'] ? 'dipinjamkan' : 'digunakan';
		$this->Laptop_model->update($wizard['laptop_id'], [
			'status' => $new_status,
			'current_employee_id' => $wizard['employee_id'],
		]);
		$this->Usage_model->create([
			'laptop_id'   => $wizard['laptop_id'],
			'employee_id' => $wizard['employee_id'],
			'bast_id'     => $bast_id,
			'start_date'  => $wizard['handover_date'],
			'expected_return_date' => $wizard['expected_return_date'] ?: NULL,
			'is_active'   => 1,
		]);

		$this->session->unset_userdata('bast_wizard');

		$msg = ($action === 'send') ? 'BAST berhasil dibuat dan dikirim untuk tanda tangan' : 'BAST berhasil disimpan';
		$this->session->set_flashdata('toast', $msg . ' — ' . $data['bast_number']);

		if ($action === 'pdf') {
			redirect('bast/pdf/' . $bast_id);
			return;
		}
		redirect('bast/detail/' . $bast_id);
	}

	public function detail($id)
	{
		$bast = $this->Bast_model->get($id);
		if ( ! $bast) show_404();

		// Pastikan token TTD per peran ada (BAST lama)
		if (empty($bast['receiver_token']) || empty($bast['approver_token']))
		{
			$this->Bast_model->ensure_role_tokens($id);
			$bast = $this->Bast_model->get($id);
		}

		$data = [
			'page_title' => $bast['bast_number'],
			'bast'       => $bast,
			'checklist'  => json_decode($bast['checklist'], TRUE) ?: [],
			'template'   => $this->Template_model->get_by_type($bast['handover_type']),
		];
		$this->render('bast/detail', $data);
	}

	public function pdf($id)
	{
		$bast = $this->Bast_model->get($id);
		if ( ! $bast) show_404();

		require_once APPPATH . 'third_party/pdf/autoload.php';

		$checklist_labels = [
			'unit_laptop' => 'Unit Laptop', 'charger' => 'Charger', 'tas' => 'Tas Laptop',
			'mouse' => 'Mouse', 'adapter' => 'Adapter', 'aksesoris_lain' => 'Aksesoris Lain',
			'kondisi_fisik' => 'Kondisi Fisik', 'layar' => 'Layar', 'keyboard' => 'Keyboard',
			'baterai' => 'Baterai', 'port_usb' => 'Port USB', 'sistem_operasi' => 'Sistem Operasi',
		];
		$checklist = json_decode($bast['checklist'], TRUE) ?: [];

		$html = $this->load->view('bast/pdf_template', [
			'bast' => $bast,
			'checklist' => $checklist,
			'checklist_labels' => $checklist_labels,
			'company' => $this->data['company'],
			'template' => $this->Template_model->get_by_type($bast['handover_type']),
		], TRUE);

		$options = new \Dompdf\Options();
		$options->set('isRemoteEnabled', false);
		$options->set('defaultFont', 'DejaVu Sans');

		$dompdf = new \Dompdf\Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		$filename = str_replace('/', '-', $bast['bast_number']) . '.pdf';

		// TRUE = tampil di tab baru (untuk tombol "Print"), FALSE = paksa download (tombol "Download PDF")
		$asAttachment = $this->input->get('mode') !== 'view';
		$dompdf->stream($filename, ['Attachment' => $asAttachment]);
		exit;
	}

	/**
	 * Buat ulang token/link TTD untuk Penyerah atau Team Leader (khusus admin yang login).
	 */
	public function regenerate_token($id, $who = '')
	{
		$map = ['penyerah' => 'penerima', 'teamleader' => 'atasan'];
		$bast = $this->Bast_model->get($id);
		if ( ! $bast || ! isset($map[$who]))
		{
			show_404();
			return;
		}
		if ($bast['status'] === 'dibatalkan')
		{
			$this->session->set_flashdata('toast', 'BAST sudah dibatalkan, token tidak dapat dibuat ulang.');
			redirect('bast/detail/' . $id);
			return;
		}

		$this->Bast_model->regenerate_role_token($id, $map[$who]);
		$label = $who === 'penyerah' ? 'Penyerah' : 'Team Leader';
		$this->session->set_flashdata('toast', 'Token TTD ' . $label . ' dibuat ulang. Link lama tidak berlaku lagi.');
		redirect('bast/detail/' . $id);
	}

	public function send_for_signature($id)
	{
		$this->Bast_model->update($id, ['status' => 'menunggu']);
		$this->session->set_flashdata('toast', 'BAST dikirim untuk tanda tangan');
		redirect('bast/detail/' . $id);
	}

	/**
	 * Kirim email notifikasi BAST ke alamat email karyawan penerima.
	 * Ini adalah fitur OPSIONAL — dipicu manual dari tombol "Kirim Email"
	 * di halaman detail BAST. Tidak memengaruhi status atau alur BAST lainnya,
	 * jadi tetap aman digunakan meskipun SMTP belum dikonfigurasi.
	 */
	/**
	 * Halaman tanda tangan admin (Pihak Pertama / Menyerahkan) — dilakukan
	 * langsung dari dalam sistem karena admin sudah login.
	 */
	public function sign_admin_page($id)
	{
		$bast = $this->Bast_model->get($id);
		if ( ! $bast) show_404();

		$this->render('bast/sign_admin', [
			'page_title' => 'Tanda Tangan Admin',
			'bast' => $bast,
		]);
	}

	public function sign_admin_submit($id)
	{
		$bast = $this->Bast_model->get($id);
		if ( ! $bast) show_404();

		$signature_data = $this->input->post('signature_data');
		if (empty($signature_data) || ! preg_match('/^data:image\/png;base64,(.+)$/', $signature_data, $m))
		{
			$this->session->set_flashdata('toast', 'Tanda tangan tidak valid, silakan coba lagi.');
			redirect('bast/ttd-admin/' . $id);
			return;
		}

		$upload_dir = FCPATH . 'assets/uploads/signatures/';
		if ( ! is_dir($upload_dir)) mkdir($upload_dir, 0755, TRUE);

		$filename = 'ttd-admin-' . $id . '-' . time() . '.png';
		file_put_contents($upload_dir . $filename, base64_decode($m[1]));

		$saved = $this->Bast_model->save_signature($id, 'admin', 'assets/uploads/signatures/' . $filename);

		if ( ! $saved)
		{
			log_message('error', 'Gagal menyimpan tanda tangan admin BAST id=' . $id . '. Kemungkinan kolom signature belum ada di database — jalankan database/migration_ttd_digital.sql');
			$this->session->set_flashdata('toast', 'Gagal menyimpan tanda tangan. Kemungkinan database belum diperbarui — hubungi Admin IT.');
			redirect('bast/ttd-admin/' . $id);
			return;
		}

		$this->session->set_flashdata('toast', 'Tanda tangan admin berhasil disimpan');
		redirect('bast/detail/' . $id);
	}

	public function send_email($id)
	{
		$sent = $this->send_bast_email($id);
		$this->session->set_flashdata('toast', $sent
			? 'Email BAST berhasil dikirim ke penerima'
			: 'Gagal mengirim email. Periksa konfigurasi SMTP di application/config/email.php');
		redirect('bast/detail/' . $id);
	}

	private function send_bast_email($id)
	{
		$bast = $this->Bast_model->get($id);
		if ( ! $bast || empty($bast['employee_email']))
		{
			log_message('error', 'send_bast_email: BAST tidak ditemukan atau email penerima kosong (id=' . $id . ')');
			return FALSE;
		}

		$this->load->library('email');

		$body = $this->load->view('bast/email_template', [
			'bast' => $bast,
			'company' => $this->data['company'],
			'recipient_label' => $bast['employee_name'],
			'detail_url' => $bast['signature_token'] ? site_url('ttd/' . $bast['signature_token'] . '/penerima') : site_url('bast/detail/' . $bast['id']),
		], TRUE);

		$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
		$this->email->to($bast['employee_email']);
		$this->email->subject('Menunggu Tanda Tangan — BAST ' . $bast['bast_number']);
		$this->email->message($body);

		$sent = $this->email->send();
		if ( ! $sent)
		{
			log_message('error', 'send_bast_email failed: ' . $this->email->print_debugger(['headers']));
		}
		return $sent;
	}

	public function cancel($id)
	{
		$this->Bast_model->cancel($id);
		$this->session->set_flashdata('toast', 'BAST telah dibatalkan');
		redirect('bast/detail/' . $id);
	}

	public function templates()
	{
		$this->render('bast/templates', [
			'page_title' => 'Template BAST',
			'templates'  => $this->Template_model->get_all(),
		]);
	}

	public function template_preview($type)
	{
		$template = $this->Template_model->get_by_type($type);
		if ( ! $template) show_404();

		$this->render('bast/template_preview', [
			'page_title' => $template['title'],
			'template'   => $template,
			'company'    => $this->data['company'],
		]);
	}

	public function template_edit($type)
	{
		$template = $this->Template_model->get_by_type($type);
		if ( ! $template) show_404();

		if ($this->input->method() === 'post')
		{
			$this->Template_model->update_by_type($type, [
				'title'          => $this->input->post('title', TRUE),
				'document_title' => $this->input->post('document_title', TRUE),
				'statement_text' => $this->input->post('statement_text', TRUE),
				'signer_name'    => $this->input->post('signer_name', TRUE) ?: NULL,
				'signer_role'    => $this->input->post('signer_role', TRUE) ?: NULL,
				'approver_name'  => $this->input->post('approver_name', TRUE) ?: NULL,
				'approver_role'  => $this->input->post('approver_role', TRUE) ?: NULL,
			]);
			$this->session->set_flashdata('toast', 'Template "' . $this->input->post('title', TRUE) . '" berhasil diperbarui');
			redirect('bast/template');
			return;
		}

		$this->render('bast/template_edit', [
			'page_title' => 'Edit ' . $template['title'],
			'template'   => $template,
		]);
	}
}

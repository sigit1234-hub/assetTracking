<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Employee_model');
		$this->load->model('Group_model');
	}

	public function index()
	{
		$filters = [
			'group_id' => $this->input->get('group_id'),
			'q'        => $this->input->get('q'),
		];

		$per_page = 10;
		$page = max(1, (int) $this->input->get('page'));
		$offset = ($page - 1) * $per_page;

		$total = $this->Employee_model->count_all($filters);

		$data = [
			'page_title' => 'Data Pekerja',
			'employees'  => $this->Employee_model->get_all($filters, $per_page, $offset),
			'groups'     => $this->Group_model->get_all(),
			'filters'    => $filters,
			'total'      => $total,
			'page'       => $page,
			'per_page'   => $per_page,
			'total_pages'=> max(1, ceil($total / $per_page)),
		];

		$this->render('employee/index', $data);
	}

	public function create()
	{
		if ($this->input->method() === 'post')
		{
			$this->form_validation->set_rules('name', 'Nama', 'required');
			$this->form_validation->set_rules('nik', 'PN', 'required');

			if ($this->form_validation->run())
			{
				$nik = $this->input->post('nik', TRUE);
				if ($this->Employee_model->nik_exists($nik))
				{
					$this->session->set_flashdata('toast', "PN $nik sudah terdaftar. Gunakan PN lain.");
					redirect('pekerja/tambah');
					return;
				}

				$this->Employee_model->create([
					'nik'      => $nik,
					'name'     => $this->input->post('name', TRUE),
					'position' => $this->input->post('position', TRUE),
					'group_id' => $this->input->post('group_id') ?: NULL,
					'email'    => $this->input->post('email', TRUE),
					'phone'    => $this->input->post('phone', TRUE),
				]);
				$this->session->set_flashdata('toast', 'Data pekerja ' . $this->input->post('name', TRUE) . ' berhasil ditambahkan');
				redirect('pekerja');
				return;
			}
		}

		$data = [
			'page_title' => 'Tambah Pekerja',
			'employee'   => NULL,
			'groups'     => $this->Group_model->get_all(),
		];
		$this->render('employee/form', $data);
	}

	public function edit($id)
	{
		$employee = $this->Employee_model->get($id);
		if ( ! $employee) show_404();

		if ($this->input->method() === 'post')
		{
			$this->Employee_model->update($id, [
				'name'     => $this->input->post('name', TRUE),
				'position' => $this->input->post('position', TRUE),
				'group_id' => $this->input->post('group_id') ?: NULL,
				'email'    => $this->input->post('email', TRUE),
				'phone'    => $this->input->post('phone', TRUE),
				'is_active'=> $this->input->post('is_active') ? 1 : 0,
			]);
			$this->session->set_flashdata('toast', 'Data pekerja ' . $employee['name'] . ' berhasil diperbarui');
			redirect('pekerja');
			return;
		}

		$data = [
			'page_title' => 'Edit Pekerja',
			'employee'   => $employee,
			'groups'     => $this->Group_model->get_all(),
		];
		$this->render('employee/form', $data);
	}

	public function delete($id)
	{
		$employee = $this->Employee_model->get($id);
		if ($employee)
		{
			$this->Employee_model->delete($id);
			$this->session->set_flashdata('toast', 'Data pekerja ' . $employee['name'] . ' berhasil dihapus');
		}
		redirect('pekerja');
	}

	public function import()
	{
		if ($this->input->method() === 'post' && ! empty($_FILES['file']['name']))
		{
			$result = $this->process_import_file($_FILES['file']);

			$msg = $result['inserted'] . ' pekerja berhasil ditambahkan.';
			if ($result['skipped'] > 0) $msg .= ' ' . $result['skipped'] . ' baris dilewati.';

			$this->session->set_flashdata('toast', $msg);
			$this->render('employee/import', ['page_title' => 'Import Data Pekerja', 'import_result' => $result]);
			return;
		}
		$this->render('employee/import', ['page_title' => 'Import Data Pekerja', 'import_result' => NULL]);
	}

	/**
	 * Parse file .xlsx atau .csv, validasi tiap baris, lalu masukkan ke tabel employees.
	 * Grup yang belum ada di master data akan otomatis dibuat.
	 *
	 * Kolom yang diharapkan (baris pertama = header, diabaikan):
	 * nik, nama, jabatan, grup, email, no_hp
	 */
	private function process_import_file($file)
	{
		$result = ['inserted' => 0, 'skipped' => 0, 'errors' => []];

		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		$rows = [];

		if ($ext === 'xlsx')
		{
			require_once APPPATH . 'third_party/xlsx/SimpleXLSX.php';
			if ($xlsx = \Shuchkin\SimpleXLSX::parse($file['tmp_name']))
			{
				$rows = $xlsx->rows();
			}
			else
			{
				$result['errors'][] = 'File .xlsx tidak dapat dibaca: ' . \Shuchkin\SimpleXLSX::parseError();
				return $result;
			}
		}
		elseif ($ext === 'csv')
		{
			if (($handle = fopen($file['tmp_name'], 'r')) !== FALSE)
			{
				while (($line = fgetcsv($handle, 0, ',')) !== FALSE) $rows[] = $line;
				fclose($handle);
			}
		}
		else
		{
			$result['errors'][] = 'Format file tidak didukung. Gunakan .xlsx atau .csv.';
			return $result;
		}

		if (count($rows) < 2)
		{
			$result['errors'][] = 'File tidak berisi data (hanya header atau kosong).';
			return $result;
		}

		array_shift($rows); // buang baris header

		foreach ($rows as $i => $row)
		{
			$rowNum = $i + 2;
			$row = array_pad($row, 6, '');
			list($nik, $nama, $jabatan, $grup, $email, $hp) = array_map('trim', array_slice($row, 0, 6));

			if ($nik === '' || $nama === '')
			{
				$result['skipped']++;
				$result['errors'][] = "Baris $rowNum dilewati: PN dan Nama wajib diisi.";
				continue;
			}
			if ($this->Employee_model->nik_exists($nik))
			{
				$result['skipped']++;
				$result['errors'][] = "Baris $rowNum dilewati: PN '$nik' sudah terdaftar.";
				continue;
			}

			$this->Employee_model->create([
				'nik'      => $nik,
				'name'     => $nama,
				'position' => $jabatan,
				'group_id' => $grup !== '' ? $this->Group_model->find_or_create_by_name($grup) : NULL,
				'email'    => $email,
				'phone'    => $hp,
			]);
			$result['inserted']++;
		}

		return $result;
	}

	/**
	 * Unduh template Excel untuk import data pekerja massal.
	 */
	public function download_template()
	{
		require_once APPPATH . 'third_party/xlsx/SimpleXLSXGen.php';

		$rows = [
			['pn','nama','jabatan','grup','email','no_hp'],
			['EMP-2026-0001','Contoh Nama Pekerja','Staff Operasional','Operations','contoh.nama@nusantaradigital.co.id','0812-0000-0001'],
			['EMP-2026-0002','Contoh Nama Kedua','Staff Finance','Finance','contoh.kedua@nusantaradigital.co.id','0812-0000-0002'],
		];

		\Shuchkin\SimpleXLSXGen::fromArray($rows, 'Template Import Pekerja')
			->downloadAs('template-import-pekerja.xlsx');
		exit;
	}
}

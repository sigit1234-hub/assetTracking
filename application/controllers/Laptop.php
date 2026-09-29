<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laptop extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Laptop_model');
		$this->load->model('Brand_model');
		$this->load->model('Category_model');
		$this->load->model('Group_model');
		$this->load->model('Usage_model');
		$this->load->model('Maintenance_model');
		$this->load->model('Bast_model');
	}

	public function index()
	{
		$filters = [
			'status'      => $this->input->get('status'),
			'brand_id'    => $this->input->get('brand_id'),
			'group_id' => $this->input->get('group_id'),
			'q'           => $this->input->get('q'),
		];

		$per_page = 10;
		$page = max(1, (int) $this->input->get('page'));
		$offset = ($page - 1) * $per_page;

		$total = $this->Laptop_model->count_all($filters);

		$data = [
			'page_title' => 'Data Laptop',
			'laptops'    => $this->Laptop_model->get_all($filters, $per_page, $offset),
			'brands'     => $this->Brand_model->get_all(),
			'groups'     => $this->Group_model->get_all(),
			'filters'    => $filters,
			'total'      => $total,
			'page'       => $page,
			'per_page'   => $per_page,
			'total_pages'=> max(1, ceil($total / $per_page)),
		];

		$this->render('laptop/index', $data);
	}

	public function create()
	{
		if ($this->input->method() === 'post')
		{
			$this->form_validation->set_rules('serial_number', 'Serial Number', 'required');
			$this->form_validation->set_rules('model', 'Model', 'required');

			if ($this->form_validation->run())
			{
				$seq = $this->Laptop_model->last_sequence();
				$purchase_year = $this->input->post('purchase_year') ?: date('Y');
				$data = [
					'asset_id'      => generate_asset_id($seq, $purchase_year),
					'serial_number' => $this->input->post('serial_number', TRUE),
					'brand_id'      => $this->input->post('brand_id') ?: NULL,
					'category_id'   => $this->input->post('category_id') ?: NULL,
					'model'         => $this->input->post('model', TRUE),
					'processor'     => $this->input->post('processor', TRUE),
					'ram'           => $this->input->post('ram', TRUE),
					'storage'       => $this->input->post('storage', TRUE),
					'os'            => $this->input->post('os', TRUE),
					'purchase_year' => $purchase_year,
					'location'      => $this->input->post('location', TRUE),
					'status'        => $this->input->post('status') ?: 'tersedia',
					'condition_notes' => $this->input->post('condition_notes', TRUE),
				];
				$id = $this->Laptop_model->create($data);
				$this->session->set_flashdata('toast', 'Data laptop berhasil disimpan sebagai ' . $data['asset_id']);
				redirect('laptop');
				return;
			}
		}

		$data = [
			'page_title' => 'Tambah Laptop',
			'laptop'     => NULL,
			'brands'     => $this->Brand_model->get_all(),
			'categories' => $this->Category_model->get_all(),
			'next_seq'   => $this->Laptop_model->last_sequence() + 1,
		];
		$this->render('laptop/form', $data);
	}

	public function edit($id)
	{
		$laptop = $this->Laptop_model->get($id);
		if ( ! $laptop) show_404();

		if ($this->input->method() === 'post')
		{
			$data = [
				'serial_number' => $this->input->post('serial_number', TRUE),
				'brand_id'      => $this->input->post('brand_id') ?: NULL,
				'category_id'   => $this->input->post('category_id') ?: NULL,
				'model'         => $this->input->post('model', TRUE),
				'processor'     => $this->input->post('processor', TRUE),
				'ram'           => $this->input->post('ram', TRUE),
				'storage'       => $this->input->post('storage', TRUE),
				'os'            => $this->input->post('os', TRUE),
				'purchase_year' => $this->input->post('purchase_year') ?: NULL,
				'location'      => $this->input->post('location', TRUE),
				'status'        => $this->input->post('status'),
				'condition_notes' => $this->input->post('condition_notes', TRUE),
			];
			$this->Laptop_model->update($id, $data);
			$this->session->set_flashdata('toast', 'Data laptop ' . $laptop['asset_id'] . ' berhasil diperbarui');
			redirect('laptop/detail/' . $id);
			return;
		}

		$data = [
			'page_title' => 'Edit Laptop',
			'laptop'     => $laptop,
			'brands'     => $this->Brand_model->get_all(),
			'categories' => $this->Category_model->get_all(),
		];
		$this->render('laptop/form', $data);
	}

	public function detail($id)
	{
		$laptop = $this->Laptop_model->get($id);
		if ( ! $laptop) show_404();

		$data = [
			'page_title' => $laptop['asset_id'],
			'laptop'     => $laptop,
			'usage_history' => $this->Usage_model->get_by_laptop($id),
			'maintenance_history' => $this->Maintenance_model->get_history_by_laptop($id),
			'bast_docs'  => $this->Bast_model->get_all(['laptop_id' => $id]),
		];
		$this->render('laptop/detail', $data);
	}

	public function delete($id)
	{
		$laptop = $this->Laptop_model->get($id);
		if ($laptop)
		{
			$this->Laptop_model->delete($id);
			$this->session->set_flashdata('toast', 'Laptop ' . $laptop['asset_id'] . ' berhasil dihapus');
		}
		redirect('laptop');
	}

	public function import()
	{
		if ($this->input->method() === 'post' && ! empty($_FILES['file']['name']))
		{
			$result = $this->process_import_file($_FILES['file']);

			$msg = $result['inserted'] . ' laptop berhasil ditambahkan.';
			if ($result['skipped'] > 0) $msg .= ' ' . $result['skipped'] . ' baris dilewati.';

			$this->session->set_flashdata('toast', $msg);
			$data = [
				'page_title' => 'Import Data Laptop',
				'import_result' => $result,
			];
			$this->render('laptop/import', $data);
			return;
		}
		$this->render('laptop/import', ['page_title' => 'Import Data Laptop', 'import_result' => NULL]);
	}

	/**
	 * Parse file .xlsx atau .csv yang diunggah, validasi tiap baris,
	 * lalu masukkan ke tabel laptops. Merk & kategori yang belum ada
	 * di master data akan otomatis dibuat.
	 *
	 * Kolom yang diharapkan (baris pertama = header, diabaikan):
	 * serial_number, merk, model, kategori, processor, ram, storage, os,
	 * tahun_pengadaan, lokasi, status
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
		$seq = $this->Laptop_model->last_sequence();
		$validStatuses = ['tersedia','digunakan','maintenance','dipinjamkan','rusak','nonaktif'];

		foreach ($rows as $i => $row)
		{
			$rowNum = $i + 2; // nomor baris asli di file (setelah header)
			$row = array_pad($row, 11, '');
			list($serial, $merk, $model, $kategori, $processor, $ram, $storage, $os, $tahun, $lokasi, $status) = array_map('trim', array_slice($row, 0, 11));

			if ($serial === '' || $model === '')
			{
				$result['skipped']++;
				$result['errors'][] = "Baris $rowNum dilewati: Serial Number dan Model wajib diisi.";
				continue;
			}
			if ($this->Laptop_model->serial_exists($serial))
			{
				$result['skipped']++;
				$result['errors'][] = "Baris $rowNum dilewati: Serial Number '$serial' sudah terdaftar.";
				continue;
			}

			$status = strtolower($status);
			if ( ! in_array($status, $validStatuses, TRUE)) $status = 'tersedia';
			$rowYear = is_numeric($tahun) ? (int) $tahun : (int) date('Y');

			$seq++;
			$this->Laptop_model->create([
				'asset_id'       => generate_asset_id($seq - 1, $rowYear),
				'serial_number'  => $serial,
				'brand_id'       => $merk !== '' ? $this->Brand_model->find_or_create_by_name($merk) : NULL,
				'category_id'    => $kategori !== '' ? $this->Category_model->find_or_create_by_name($kategori) : NULL,
				'model'          => $model,
				'processor'      => $processor,
				'ram'            => $ram,
				'storage'        => $storage,
				'os'             => $os,
				'purchase_year'  => $rowYear,
				'location'       => $lokasi,
				'status'         => $status,
			]);
			$result['inserted']++;
		}

		return $result;
	}

	/**
	 * Unduh template Excel untuk import data laptop massal.
	 */
	public function download_template()
	{
		require_once APPPATH . 'third_party/xlsx/SimpleXLSXGen.php';

		$rows = [
			['serial_number','merk','model','kategori','processor','ram','storage','os','tahun_pengadaan','lokasi','status'],
			['SN-EXAMPLE-001','Lenovo','ThinkPad E14','Business Laptop','Intel Core i5-1235U','8 GB','512GB SSD','Windows 11 Pro','2026','Jakarta HO','tersedia'],
			['SN-EXAMPLE-002','Dell','Latitude 5440','Business Laptop','Intel Core i5-1335U','8 GB','256GB SSD','Windows 11 Pro','2026','Surabaya','tersedia'],
		];

		\Shuchkin\SimpleXLSXGen::fromArray($rows, 'Template Import Laptop')
			->downloadAs('template-import-laptop.xlsx');
		exit;
	}

	/**
	 * Cetak label stiker satu laptop (untuk printer label seperti Brother PT-D610BT).
	 */
	public function label($id)
	{
		$laptop = $this->Laptop_model->get($id);
		if ( ! $laptop) show_404();

		$this->load->view('laptop/label', [
			'laptops' => [$laptop],
		]);
	}

	/**
	 * Cetak label stiker untuk beberapa laptop sekaligus (dipilih via checkbox di Data Laptop).
	 */
	public function label_bulk()
	{
		$ids = $this->input->post('ids');
		if (empty($ids) || ! is_array($ids))
		{
			$this->session->set_flashdata('toast', 'Pilih minimal satu laptop untuk dicetak labelnya.');
			redirect('laptop');
			return;
		}

		$laptops = [];
		foreach ($ids as $id)
		{
			$l = $this->Laptop_model->get($id);
			if ($l) $laptops[] = $l;
		}

		if (empty($laptops))
		{
			$this->session->set_flashdata('toast', 'Data laptop yang dipilih tidak ditemukan.');
			redirect('laptop');
			return;
		}

		$this->load->view('laptop/label', ['laptops' => $laptops]);
	}

	public function categories()
	{
		if ($this->input->method() === 'post')
		{
			$this->Category_model->create([
				'name' => $this->input->post('name', TRUE),
				'description' => $this->input->post('description', TRUE),
			]);
			$this->session->set_flashdata('toast', 'Kategori berhasil ditambahkan');
			redirect('laptop/kategori');
			return;
		}
		$data = ['page_title' => 'Kategori Laptop', 'items' => $this->Category_model->get_with_count(), 'type' => 'kategori'];
		$this->render('laptop/reference_list', $data);
	}

	public function brands()
	{
		if ($this->input->method() === 'post')
		{
			$this->Brand_model->create(['name' => $this->input->post('name', TRUE)]);
			$this->session->set_flashdata('toast', 'Merk berhasil ditambahkan');
			redirect('laptop/merk');
			return;
		}
		$data = ['page_title' => 'Merk dan Model', 'items' => $this->Brand_model->get_with_count(), 'type' => 'merk'];
		$this->render('laptop/reference_list', $data);
	}
}

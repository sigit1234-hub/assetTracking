<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Maintenance_model');
		$this->load->model('Laptop_model');
	}

	public function index()
	{
		$data = [
			'page_title' => 'Laptop Dalam Perbaikan',
			'items'      => $this->Maintenance_model->get_active(),
			'count_active'   => $this->Maintenance_model->count_active(),
			'count_waiting'  => $this->Maintenance_model->count_waiting_parts(),
			'count_done'     => $this->Maintenance_model->count_completed_this_month(),
			'avg_duration'   => $this->Maintenance_model->avg_duration_days(),
		];
		$this->render('maintenance/index', $data);
	}

	public function history()
	{
		$data = [
			'page_title' => 'Riwayat Maintenance',
			'items'      => $this->Maintenance_model->get_history(),
		];
		$this->render('maintenance/history', $data);
	}

	public function create()
	{
		if ($this->input->method() === 'post')
		{
			$laptop_id = $this->input->post('laptop_id');
			$this->Maintenance_model->create([
				'laptop_id'  => $laptop_id,
				'issue'      => $this->input->post('issue', TRUE),
				'technician' => $this->input->post('technician', TRUE),
				'date_in'    => $this->input->post('date_in') ?: date('Y-m-d'),
				'estimated_date_out' => $this->input->post('estimated_date_out') ?: NULL,
				'status'     => 'proses',
			]);
			$this->Laptop_model->update($laptop_id, ['status' => 'maintenance', 'current_employee_id' => NULL]);
			$this->session->set_flashdata('toast', 'Catatan maintenance berhasil ditambahkan');
			redirect('maintenance');
			return;
		}

		$data = [
			'page_title' => 'Catat Maintenance',
			'laptops'    => $this->Laptop_model->get_all(),
		];
		$this->render('maintenance/form', $data);
	}

	public function complete($id)
	{
		$item = $this->Maintenance_model->get($id);
		if ($item)
		{
			$this->Maintenance_model->update($id, ['status' => 'selesai', 'date_out' => date('Y-m-d')]);
			$this->Laptop_model->update($item['laptop_id'], ['status' => 'tersedia']);
			$this->session->set_flashdata('toast', 'Maintenance ' . $item['asset_id'] . ' ditandai selesai');
		}
		redirect('maintenance');
	}
}

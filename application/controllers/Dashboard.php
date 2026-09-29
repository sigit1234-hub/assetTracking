<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Laptop_model');
		$this->load->model('Bast_model');
		$this->load->model('Usage_model');
		$this->load->model('Maintenance_model');
	}

	public function index()
	{
		$status = $this->Laptop_model->status_summary();

		$data = [
			'page_title'   => 'Dashboard',
			'total_laptop' => array_sum($status),
			'status'       => $status,
			'bast_active'  => $this->Bast_model->count_by_status('aktif'),
			'bast_waiting' => $this->Bast_model->count_by_status('menunggu'),
			'usage_trend'  => $this->Laptop_model->usage_trend(6),
			'recent'       => $this->Laptop_model->recent(5),
			'due_soon'     => $this->Usage_model->get_due_soon_list(7),
			'overdue'      => $this->Usage_model->get_overdue_list(),
			'maint_active' => $this->Maintenance_model->count_active(),
		];

		$this->render('dashboard/index', $data);
	}
}

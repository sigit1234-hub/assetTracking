<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Laptop_model');
		$this->load->model('Bast_model');
	}

	public function index()
	{
		$data = [
			'page_title'    => 'Laporan & Analytics',
			'status'        => $this->Laptop_model->status_summary(),
			'usage_trend'   => $this->Laptop_model->usage_trend(6),
			'per_group'     => $this->Laptop_model->count_per_group(),
			'bast_summary'  => $this->Bast_model->status_summary(),
			'total_laptop'  => array_sum($this->Laptop_model->status_summary()),
			'bast_this_year'=> $this->Bast_model->last_sequence_this_year(),
		];
		$this->render('report/index', $data);
	}

	public function export($type)
	{
		// Placeholder export: implementasi produksi menggunakan PhpSpreadsheet / dompdf
		$this->session->set_flashdata('toast', 'Laporan berhasil diekspor ke ' . strtoupper($type));
		redirect('laporan');
	}
}

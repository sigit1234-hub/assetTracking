<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notification_model');
	}

	public function index()
	{
		$data = [
			'page_title' => 'Pusat Notifikasi',
			'items'      => $this->Notification_model->get_all(),
		];
		$this->render('notification/index', $data);
	}

	public function mark_read($id)
	{
		$this->Notification_model->mark_read($id);
		redirect('notifikasi');
	}

	public function mark_all_read()
	{
		$this->Notification_model->mark_all_read();
		redirect('notifikasi');
	}
}

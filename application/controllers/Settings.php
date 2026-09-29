<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	public function index()
	{
		if ($this->input->method() === 'post')
		{
			$data = [
				'name'  => $this->input->post('name', TRUE),
				'phone' => $this->input->post('phone', TRUE),
			];
			$this->User_model->update($this->current_user['id'], $data);
			$this->session->set_userdata('user_name', $data['name']);
			$this->session->set_flashdata('toast', 'Profil berhasil diperbarui');
			redirect('pengaturan');
			return;
		}

		$data = [
			'page_title' => 'Pengaturan',
			'user'       => $this->User_model->get($this->current_user['id']),
		];
		$this->render('settings/index', $data);
	}
}

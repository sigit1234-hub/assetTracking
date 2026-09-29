<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller
 * Base controller: memastikan user sudah login, menyiapkan data umum
 * (nama admin, jumlah notifikasi belum dibaca, dsb) untuk semua halaman.
 */
class MY_Controller extends CI_Controller {

	protected $current_user = NULL;

	public function __construct()
	{
		parent::__construct();

		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
			return;
		}

		$this->current_user = [
			'id'       => $this->session->userdata('user_id'),
			'name'     => $this->session->userdata('user_name'),
			'email'    => $this->session->userdata('user_email'),
			'division' => $this->session->userdata('user_division'),
			'role'     => $this->session->userdata('user_role'),
		];

		$this->load->model('Notification_model');
		$this->data['current_user']        = $this->current_user;
		$this->data['unread_notifications'] = $this->Notification_model->count_unread();
		$this->data['company'] = [
			'name'          => $this->config->item('company_name'),
			'division'      => $this->config->item('company_division'),
			'approver_name' => $this->config->item('default_approver_name'),
			'approver_role' => $this->config->item('default_approver_role'),
		];
	}

	/**
	 * Merender view dengan template (sidebar + topbar + footer)
	 */
	protected function render($view, $data = [])
	{
		$data = array_merge($this->data, $data);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		echo '<main id="page">';
		$this->load->view($view, $data);
		echo '</main></div></div>';
		$this->load->view('templates/footer', $data);
	}
}

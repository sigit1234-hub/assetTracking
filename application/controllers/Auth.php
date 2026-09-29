<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
            return;
        }

        $error = null;

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Kata Sandi', 'required');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email', true);
                $password = $this->input->post('password');
                $user = $this->User_model->get_by_email($email);

                if ($user && password_verify($password, $user['password']) && $user['is_active']) {
                    $this->session->set_userdata([
                        'logged_in'     => true,
                        'user_id'       => $user['id'],
                        'user_name'     => $user['name'],
                        'user_email'    => $user['email'],
                        'user_division' => $user['division'],
                        'user_role'     => $user['role'],
                    ]);
                    $this->User_model->touch_last_login($user['id']);
                    redirect('dashboard');
                    return;
                }
                $error = 'Email atau kata sandi salah. Silakan coba lagi.';
            } else {
                $error = validation_errors();
            }
        }

        $company = [
            'name'     => $this->config->item('company_name'),
            'division' => $this->config->item('company_division'),
        ];
        $this->load->view('auth/login', ['error' => $error, 'company' => $company]);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
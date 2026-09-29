<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Usage extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Usage_model');
        $this->load->model('Laptop_model');
        $this->load->model('Bast_model');
        $this->load->model('Group_model');
    }

    public function index()
    {
        $filters = [
            'q'           => $this->input->get('q'),
            'group_id' => $this->input->get('group_id'),
        ];

        $data = [
            'page_title' => 'Penggunaan Laptop',
            'usages'     => $this->Usage_model->get_active($filters),
            'groups'     => $this->Group_model->get_all(),
            'filters'    => $filters,
            'count_active'   => $this->Usage_model->count_active(),
            'count_loan'     => $this->Usage_model->count_loan(),
            'count_due_soon' => $this->Usage_model->count_due_soon(7),
            'count_overdue'  => $this->Usage_model->count_overdue(),
        ];

        $this->render('usage/index', $data);
    }

    public function history()
    {
        $data = [
            'page_title' => 'Riwayat Penggunaan',
            'history'    => $this->Usage_model->get_history([
                'laptop_id'   => $this->input->get('laptop_id'),
                'group_id' => $this->input->get('group_id'),
            ]),
            'laptops'    => $this->Laptop_model->get_all(),
            'groups'     => $this->Group_model->get_all(),
        ];
        $this->render('usage/history', $data);
    }

    public function return_form()
    {
        $laptop_id = $this->input->get('laptop_id');

        $data = [
            'page_title'   => 'Pengembalian Laptop',
            'candidates'   => $this->Laptop_model->get_all(['status_in' => ['digunakan', 'dipinjamkan']]),
            'selected_id'  => $laptop_id,
        ];
        $this->render('usage/return_form', $data);
    }

    public function process_return()
    {
        if ($this->input->method() !== 'post') {
            redirect('penggunaan');
            return;
        }

        $laptop_id = $this->input->post('laptop_id');
        $laptop = $this->Laptop_model->get($laptop_id);
        if (! $laptop) {
            $this->session->set_flashdata('toast', 'Laptop tidak ditemukan');
            redirect('penggunaan');
            return;
        }

        $condition = $this->input->post('overall_condition') ?: 'baik';
        $new_status = ($condition === 'perlu_maintenance' || $condition === 'ada_kerusakan') ? 'maintenance' : 'tersedia';
        $notes = $this->input->post('notes', true);

        // Susun checklist kondisi per bagian (Kondisi Fisik, Layar, Keyboard, dst)
        $part_labels = ['kondisi_fisik','layar','keyboard','charger','baterai','port_usb','sistem_operasi'];
        $checklist = [];
        foreach ($part_labels as $i => $key) {
            $checklist[$key] = $this->input->post('part_' . $i) ?: 'baik';
        }

        $employee_id_before_return = $laptop['current_employee_id'] ?: $laptop['employee_id'];

        // tutup sesi penggunaan aktif
        $active_usage = $this->Usage_model->get_active_by_laptop($laptop_id);
        if ($active_usage) {
            $this->Usage_model->close($active_usage['id'], [
                'end_date'         => date('Y-m-d'),
                'return_condition' => $condition,
                'return_notes'     => $notes,
            ]);

            if ($active_usage['bast_id']) {
                $this->Bast_model->complete($active_usage['bast_id']);
            }
            if (empty($employee_id_before_return)) {
                $employee_id_before_return = $active_usage['employee_id'];
            }
        }

        $this->Laptop_model->update($laptop_id, [
            'status' => $new_status,
            'current_employee_id' => null,
        ]);

        // Buat dokumen BAST Pengembalian secara otomatis (Template Pengembalian Aset)
        $return_bast_id = null;
        if ($employee_id_before_return) {
            $return_bast_id = $this->Bast_model->create_return_document(
                $laptop_id,
                $employee_id_before_return,
                $checklist,
                $condition,
                $notes,
                $this->current_user['id']
            );
        }

        $msg = 'Pengembalian ' . $laptop['asset_id'] . ' berhasil diproses';
        if ($return_bast_id) {
            $msg .= ' — Dokumen Pengembalian dibuat otomatis';
            $this->session->set_flashdata('toast', $msg);
            redirect('bast/detail/' . $return_bast_id);
            return;
        }

        $this->session->set_flashdata('toast', $msg);
        redirect('penggunaan');
    }
}

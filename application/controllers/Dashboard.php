<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->authentication()) {
            redirect('login_view');
        }
    }

    public function index()
    {
        $this->load->view('dashboard');
    }

    // public function chartgaji()
    // {
    //     $dt_payroll = $this->payroll->read_data_payroll_terbaru();
    //     $dt_payroll_staff = $this->payroll->read_data_payroll_terbaru_staff();
    //     $dt_payroll_nonstaff = $this->payroll->read_data_payroll_terbaru_nonstaff();

    //     echo json_encode(["dtpay" => $dt_payroll, "dtstaff" => $dt_payroll_staff, "dtnonstaff" => $dt_payroll_nonstaff]);
    // }
}
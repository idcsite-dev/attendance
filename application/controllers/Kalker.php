<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kalker extends MY_Controller
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
        $dt_kary = $this->kary->read_all_data();
        $data['dt_kary'] = $dt_kary;

        $this->load->view('data_absensi/karyawan/view', $data);
    }
}
<?php

class My_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('captcha');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('user_agent');
        $this->load->library('excel');

        // DB
        $this->load->model("Standard_model", 'std');
        $this->load->model("Second_model", 'scd');
        $this->load->model("Libur_model", 'libur');
        $this->load->model("Jenis_model", 'jenis');
        $this->load->model("Karyawan_model", 'kary');
        $this->load->model("Kalker_model", 'kk');
        $this->load->model("Keterangan_model", 'ket');
        $this->load->model("Timesheet_model", 'ts');
        $this->load->model("Dash_model", 'dash');
        $this->load->model("Mesin_model", 'msn');
        $this->load->model("Pph_model", 'pph');
        $this->load->model("Rapelan_model", 'rpl');
        $this->load->model("Rapelanlembur_model", 'rpll');
        $this->load->model("Pesangon_model", 'psg');
        $this->load->model("Uanghadir_model", 'uah');

        // API
        $this->load->model("API_model", 'api');
    }

    public function authentication()
    {
        return ($this->session->userdata('login'));
    }
}
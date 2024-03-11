<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kalker_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $db_proll = $this->load->database('db_payroll_att', true);
    }

    public function read_all_data()
    {
        return $this->db->get_where('tb_kary', ['tgl_hapus' => '1970-01-01 00:00:00'])->result();
    }

    public function read_data_by_id($id_payroll)
    {
        return $this->db->get_where('tb_kary', ['id_kary' => $id_payroll, 'tgl_hapus' => '1970-01-01 00:00:00'])->row();
    }
}
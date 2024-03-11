<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_model extends CI_Model
{
    public function read_all_data()
    {
        return $this->db->get_where('tb_hari_libur', ['tgl_hapus' => '1970-01-01 00:00:00'])->result();
    }

    public function read_data_by_id($id_payroll)
    {
        return $this->db->get_where('vw_payroll', ['id_payroll' => $id_payroll, 'tgl_hapus' => '1970-01-01 00:00:00'])->row();
    }

    public function read_data_lembur_by_id($id_payroll)
    {
        return $this->db->get_where('vw_payroll_lembur', ['id_payroll' => $id_payroll])->result();
    }

    public function read_data_detail_terima_by_id($id_payroll)
    {
        return $this->db->get_where('vw_payroll_detail', ['id_payroll' => $id_payroll, 'id_jenis_ket' => 1])->result();
    }

    public function read_data_detail_potong_by_id($id_payroll)
    {
        return $this->db->get_where('vw_payroll_detail', ['id_payroll' => $id_payroll, 'id_jenis_ket' => 2])->result();
    }

    public function jml_detail_terima($id_payroll)
    {
        return $this->db->query("SELECT SUM(nilai) as sub_terima FROM vw_payroll_detail WHERE id_payroll = " . $id_payroll . "  AND id_jenis_ket = 1")->row();
    }

    public function jml_detail_potong($id_payroll)
    {
        return $this->db->query("SELECT SUM(nilai) as sub_terima FROM vw_payroll_detail WHERE id_payroll = " . $id_payroll . "  AND id_jenis_ket = 2")->row();
    }
}
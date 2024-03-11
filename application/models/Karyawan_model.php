<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{
    public function read_all_data($depart)
    {
        return $this->db->get_where('tb_kary', ['tgl_hapus' => '1970-01-01 00:00:00', 'tgl_nonaktif' => '1970-01-01', 'depart' => $depart])->result();
    }

    public function read_data_by_id($id_kary)
    {
        return $this->db->get_where('tb_kary', ['id_kary' => $id_kary, 'tgl_hapus' => '1970-01-01 00:00:00'])->row();
    }
}
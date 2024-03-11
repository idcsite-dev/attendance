<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Libur_model extends CI_Model
{
    private $table = 'tb_hari_libur';

    public function read_all_data()
    {
        return $this->db->get_where('tb_hari_libur', ['tgl_hapus' => '1970-01-01 00:00:00'])->result();
    }
}
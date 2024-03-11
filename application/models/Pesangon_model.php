<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesangon_model extends CI_Model
{
    public function read_all_data()
    {
        return $this->db->get_where('vw_pesangon')->result();
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

    public function read_data_detail_rpl($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=19")->row();
    }

    public function deletePsg($bulan, $tahun)
    {
        $query = $this->db->get_where('vw_payroll_kary', ['bulan' => $bulan, 'tahun' => $tahun])->result();
        if (!empty($query)) {
            foreach ($query as $list) {
                $id_payroll_kary = $list->id_payroll_kary;
                $total_tunj_tidak_tetap = $list->total_tunj_tidak_tetap;
                $dtdet = $this->read_data_detail_rpl($id_payroll_kary);
                if (!empty($dtdet)) {
                    $nakhir = intval($total_tunj_tidak_tetap) - intval($dtdet->nilai);
                    $dtakhir = [
                        'total_tunj_tidak_tetap' => $nakhir,
                    ];

                    // hapus rpl
                    $this->db->where('id_payroll_kary', $id_payroll_kary);
                    $this->db->where('id_tambahan', 19);
                    $this->db->delete('tb_payroll_detail');

                    // update tot_tidak_tetap
                    $this->db->where('id_payroll_kary', $id_payroll_kary);
                    $this->db->update('tb_payroll_kary', $dtakhir);
                }
            }

            return true;
        } else {
            return false;
        }
    }
}
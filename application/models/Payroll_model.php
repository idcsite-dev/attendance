<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payroll_model extends CI_Model
{
    public function read_all_data()
    {
        return $this->db->get_where('vw_payroll', ['tgl_hapus' => '1970-01-01 00:00:00'])->result();
    }

    public function read_data_insentif($source, $bulan, $tahun)
    {
        return $this->db->get_where($source, ['bulan' => $bulan, 'tahun' => $tahun])->result();
    }

    public function read_data_roll($source, $bulan, $tahun)
    {
        return $this->db->get_where($source, ['bulan' => $bulan, 'tahun' => $tahun])->row();
    }

    public function read_6_data_terbaru()
    {
        return $this->db->query("SELECT * FROM vw_payroll WHERE tgl_hapus ='1970-01-01 00:00:00' ORDER BY tgl_akhir_gaji DESC LIMIT 6")->result();
    }

    public function total_gaji_staff($id_payroll)
    {
        return $this->db->query("SELECT SUM(grand_total) as gaji_staff FROM vw_payroll_kary WHERE tipe='Staff' AND id_payroll =" . $id_payroll)->row();
    }

    public function total_gaji_nonstaff($id_payroll)
    {
        return $this->db->query("SELECT SUM(grand_total) as gaji_nonstaff FROM vw_payroll_kary WHERE tipe='Non Staff' AND id_payroll =" . $id_payroll)->row();
    }

    public function read_data_detail($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary)->result();
    }

    public function read_data_detail_hadir($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=3")->row();
    }

    public function read_data_detail_absen($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=11")->row();
    }

    public function read_data_detail_pphtrm($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=7")->row();
    }

    public function read_data_detail_pphptg($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=12")->row();
    }

    public function read_data_detail_thr($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=5")->row();
    }

    public function read_data_detail_jkes($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=9")->row();
    }

    public function read_data_detail_jstek($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=8")->row();
    }

    public function read_data_detail_bonus($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=6")->row();
    }

    public function read_data_detail_ins($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=16")->row();
    }

    public function read_data_detail_rpl($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=17")->row();
    }

    public function read_data_detail_rpll($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=18")->row();
    }

    public function read_data_detail_psg($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=19")->row();
    }

    public function read_data_detail_pph($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_payroll_kary . " AND id_tambahan=7")->row();
    }

    public function read_data_det_ins($id_payroll_detail)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_detail = " . $id_payroll_detail . " AND id_tambahan=16")->row();
    }

    public function read_data_det_rpl($id_payroll_detail)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_detail = " . $id_payroll_detail . " AND id_tambahan=17")->row();
    }

    public function read_data_det_rpll($id_payroll_detail)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_detail = " . $id_payroll_detail . " AND id_tambahan=18")->row();
    }

    public function read_data_det_psg($id_payroll_detail)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_detail = " . $id_payroll_detail . " AND id_tambahan=19")->row();
    }

    public function read_data_det_pph($id_payroll_detail)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_detail = " . $id_payroll_detail . " AND id_tambahan=7")->row();
    }

    public function read_data_det_pph_pot($id_payroll_detail)
    {
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_detail = " . $id_payroll_detail . " AND id_tambahan=12")->row();
    }

    public function att_aktual($thisDate, $id_kary)
    {
        $db_proll = $this->load->database('db_payroll_att', true);
        return $db_proll->query("SELECT * FROM vw_att_aktual WHERE id_kary = " . $id_kary .
            " AND (tgl_att_aktual_awal >= '" . $thisDate . "' AND tgl_att_aktual_akhir <='" . $thisDate . "')")->row();
    }

    public function read_all_data_id_payroll($id_payroll)
    {
        return $this->db->query("SELECT * FROM vw_payroll_kary WHERE id_payroll = " . $id_payroll . " ORDER BY id_payroll_kary ASC")->result();
    }

    public function get_data_kary_detail($id_karyawan, $bulan, $tahun)
    {
        return $this->db->query("SELECT * FROM vw_payroll_kary " .
            " WHERE id_kary = " . $id_karyawan .
            " AND bulan = " . $bulan . " AND tahun = " . $tahun)->row();
    }

    public function read_all_data_kary_gaji($bulan, $tahun)
    {
        $bulan = sprintf("%02d", $bulan);
        $tglstart = $tahun . "-" . $bulan . "-01";
        return $this->db->query("SELECT id_kary, gaji_pokok, id_gaji, grade, tipe, bpjs_kes, bp_jamsostek FROM vw_gaji WHERE tgl_nonaktif = '1970-01-01' OR tgl_nonaktif >='" . $tglstart . "'")->result();
    }

    public function read_all_data_perkary_gaji($id_kary, $bulan, $tahun)
    {
        $bulan = $bulan = sprintf("%02d", $bulan);
        $tglstart = $tahun . "-" . $bulan . "-01";
        return $this->db->query("SELECT id_kary, gaji_pokok, id_gaji, grade, tipe, bpjs_kes, bp_jamsostek FROM vw_gaji WHERE (tgl_nonaktif = '1970-01-01' OR tgl_nonaktif >='" . $tglstart . "') AND id_kary =" . $id_kary)->row();
    }

    public function read_data_kary_payroll($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_kary WHERE id_payroll_kary =" . $id_payroll_kary)->result();
    }

    public function read_data_kary_payroll_ins($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM tb_payroll_kary WHERE id_payroll_kary =" . $id_payroll_kary)->row();
    }

    public function cek_lembur($thisDate, $id_kary)
    {
        return $this->db->query("SELECT * FROM tb_payroll_lembur WHERE tgl_lembur = '1970-01-01'=" . $thisDate . "' AND id_kary =" . $id_kary)->row();
    }

    public function read_all_data_kary()
    {
        return $this->db->get_where('vw_gaji', ['tgl_nonaktif' => '1970-01-01'])->result();
    }

    public function read_data_payroll($id_payroll)
    {
        // return $this->db->get_where('vw_payroll_kary', ['id_payroll' => $id_payroll, 'tgl_hapus' => '1970-01-01 00:00:00'])->result();
        return $this->db->query("SELECT * FROM vw_payroll_kary WHERE id_payroll = " . $id_payroll . " ORDER BY id_payroll ASC")->result();
    }

    public function read_data_payroll_kary($id_payroll_kary)
    {
        return $this->db->query("SELECT * FROM vw_payroll_kary WHERE id_payroll_kary = " . $id_payroll_kary)->row();
    }

    public function read_data_pyroll($id_payroll)
    {
        return $this->db->get_where('vw_payroll', ['id_payroll' => $id_payroll, 'tgl_hapus' => '1970-01-01 00:00:00'])->row();
    }

    public function read_data_by_id($id_payroll, $id_payroll_kary)
    {
        return $this->db->get_where('vw_payroll_kary', ['id_payroll' => $id_payroll, 'id_payroll_kary' => $id_payroll_kary, 'tgl_hapus' => '1970-01-01 00:00:00'])->row();
    }

    public function get_ua($grade)
    {
        return $this->db->get_where('tb_uanghadir', ['grade' => $grade])->row();
    }

    public function get_att($bulan, $tahun, $id_kary)
    {
        $db_proll = $this->load->database('db_payroll_att', true);
        return $db_proll->get_where('tb_b' . $bulan, ['tahun' => $tahun, 'id_kary' => $id_kary])->row();
    }

    public function get_spl($date, $id_kary)
    {
        // $db_proll = $this->load->database('db_payroll_att', true);
        // return $db_proll->get_where('tb_spl', ['tgl_spl' => $date, 'id_kary' => $id_kary])->row();
        return $this->db->get_where('tb_spl', ['tgl_spl' => $date, 'id_kary' => $id_kary])->row();
    }

    public function get_code_att($attcode)
    {
        // $db_proll = $this->load->database('db_payroll_att', true);
        // return $db_proll->get_where('tb_ket_kerja', ['kode_ket_kerja' => $attcode])->row();
        return $this->db->get_where('tb_ket_kerja', ['kode_ket_kerja' => $attcode])->row();
    }

    public function get_sum_lembur($tglawal, $tglakhir, $id_kary)
    {
        return $this->db->query("SELECT SUM(subtotal_lembur) AS ttl_lembur FROM vw_payroll_lembur WHERE (tgl_lembur >= '" . $tglawal . "' AND tgl_lembur <= '" . $tglakhir . "') AND id_kary = " . $id_kary)->row();
    }

    public function get_ph($thisDate)
    {
        return $this->db->get_where('tb_hari_libur', ['tgl_hari_libur' => $thisDate])->row();
    }

    public function read_data_lembur_by_id($id_pay_kary)
    {
        $query = $this->db->get_where('vw_payroll_kary', ['id_payroll_kary' => $id_pay_kary])->row();
        if (!empty($query)) {
            $id_kary = $query->id_kary;
            $tglawal = $query->tgl_awal_lembur;
            $tglakhir = $query->tgl_akhir_lembur;
            return $this->db->get_where('vw_payroll_lembur', ['id_kary' => $id_kary, 'tgl_lembur >=' => $tglawal, 'tgl_lembur <=' => $tglakhir])->result();
        } else {
            return;
        }
    }

    public function read_data_detail_terima_by_id($id_pay_kary)
    {
        // return $this->db->get_where('vw_payroll_detail', ['id_payroll_kary' => $id_pay_kary, 'id_jenis_ket' => 1])->result();
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary =" . $id_pay_kary . " AND id_jenis_ket = 1 ORDER BY no_urut ASC")->result();
    }

    public function read_data_detail_potong_by_id($id_pay_kary)
    {
        // return $this->db->get_where('vw_payroll_detail', ['id_payroll_kary' => $id_pay_kary, 'id_jenis_ket' => 2])->result();
        return $this->db->query("SELECT * FROM vw_payroll_detail WHERE id_payroll_kary =" . $id_pay_kary . " AND id_jenis_ket = 2 ORDER BY no_urut ASC")->result();
    }

    public function jml_detail_terima($id_pay_kary)
    {
        return $this->db->query("SELECT SUM(nilai) as sub_terima FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_pay_kary . "  AND id_jenis_ket = 1")->row();
    }

    public function jml_detail_potong($id_pay_kary)
    {
        return $this->db->query("SELECT SUM(nilai) as sub_potong FROM vw_payroll_detail WHERE id_payroll_kary = " . $id_pay_kary . "  AND id_jenis_ket = 2")->row();
    }

    public function add_payroll($data)
    {
        $this->db->insert('tb_payroll', $data);
        if ($this->db->affected_rows() > 0) {
            $dtpayroll = $this->db->query("SELECT * FROM tb_payroll ORDER BY id_payroll DESC LIMIT 1")->row();
            return ['status' => 200, 'id_payroll' => $dtpayroll->id_payroll];
        } else {
            return ['status' => 400];
        }
    }

    public function add_tambahan($data)
    {
        $this->db->insert('tb_payroll_detail', $data);
    }

    public function gen_payroll($data)
    {
        $this->db->insert('tb_payroll_kary', $data);
        if ($this->db->affected_rows() > 0) {
            $dtpayroll = $this->db->query("SELECT * FROM tb_payroll_kary ORDER BY id_payroll_kary DESC LIMIT 1")->row();
            return ['status' => 200, 'id_payroll_kary' => $dtpayroll->id_payroll_kary];
        } else {
            return ['status' => 400];
        }
    }

    public function add_ov($data)
    {
        $this->db->insert('tb_payroll_lembur', $data);
    }

    public function update_ov($dtov, $id_payroll_lembur)
    {
        $this->db->where('id_payroll_lembur', $id_payroll_lembur);
        $this->db->update('tb_payroll_lembur', $dtov);
    }

    public function add_total_gaji($data, $id_payroll_kary)
    {
        $this->db->where('id_payroll_kary', $id_payroll_kary);
        $this->db->update('tb_payroll_kary', $data);
    }

    public function update_payroll($data, $id_payroll)
    {
        $this->db->where('id_payroll', $id_payroll);
        $this->db->update('tb_payroll', $data);
    }

    public function update_lembur($data, $id_payroll_kary)
    {
        $this->db->where('id_payroll_kary', $id_payroll_kary);
        $this->db->update('tb_payroll_kary', $data);
    }

    public function input_tambahan($data)
    {
        $this->db->insert('tb_payroll_detail', $data);
    }

    public function update_tambahan($data, $id_payroll_kary, $id)
    {
        $this->db->where('id_payroll_kary', $id_payroll_kary);
        $this->db->where('id_tambahan', $id);
        $this->db->update('tb_payroll_detail', $data);
    }

    public function cek_detail($id_payroll_kary, $id)
    {
        $query = $this->db->query("SELECT * FROM tb_payroll_detail WHERE id_payroll_kary=" .
            $id_payroll_kary . " AND id_tambahan =" . $id)->row();
        return $query;
    }

    public function update_bp($data, $id_payroll_kary)
    {
        $this->db->where('id_payroll_kary', $id_payroll_kary);
        $this->db->where('id_tambahan', 8);
        $this->db->update('tb_payroll_detail', $data);
    }

    public function get_bp($id_payroll_kary)
    {
        $query = $this->db->query("SELECT * FROM tb_payroll_detail WHERE id_payroll_kary=" .
            $id_payroll_kary . " AND id_tambahan =8")->row();
        return $query;
    }
    public function update_detail($id_payroll_kary, $data)
    {
        $this->db->where('id_payroll_kary', $id_payroll_kary);
        $this->db->where('id_tambahan', 16);
        $this->db->update('tb_payroll_detail', $data);
    }

    public function deletePph($bulan, $tahun)
    {
        $query = $this->db->get_where('vw_payroll_kary', ['bulan' => $bulan, 'tahun' => $tahun])->result();
        if (!empty($query)) {
            foreach ($query as $list) {
                $id_payroll_kary = $list->id_payroll_kary;
                $total_tunj_tidak_tetap = $list->total_tunj_tidak_tetap;
                $dtdet = $this->read_data_detail_pph($id_payroll_kary);
                if (!empty($dtdet)) {
                    $nakhir = intval($total_tunj_tidak_tetap) - intval($dtdet->nilai);
                    $dtakhir = [
                        'total_tunj_tidak_tetap' => $nakhir,
                    ];

                    // hapus pph penerimaan
                    $this->db->where('id_payroll_kary', $id_payroll_kary);
                    $this->db->where('id_tambahan', 7);
                    $this->db->delete('tb_payroll_detail');

                    // hapus pph potongan
                    $this->db->where('id_payroll_kary', $id_payroll_kary);
                    $this->db->where('id_tambahan', 12);
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

    public function delete_payroll($id_payroll)
    {
        $query = $this->db->get_where('tb_payroll', ['id_payroll' => $id_payroll])->row();
        if (!empty($query)) {
            $tgl_awal_lembur = $query->tgl_awal_lembur;
            $tgl_akhir_lembur = $query->tgl_akhir_lembur;
            $this->db->where('tgl_lembur >=', $tgl_awal_lembur);
            $this->db->where('tgl_lembur <=', $tgl_akhir_lembur);
            $this->db->delete('tb_payroll_lembur');

            $dtkary = $this->db->get_where('tb_payroll_kary', ['id_payroll' => $id_payroll])->result();
            if (!empty($dtkary)) {
                foreach ($dtkary as $lstdetail) {
                    $id_payroll_kary = $lstdetail->id_payroll_kary;
                    $this->db->where('id_payroll_kary', $id_payroll_kary);
                    $this->db->delete('tb_payroll_detail');
                }
            }

            $this->db->where('id_payroll', $id_payroll);
            $this->db->delete('tb_payroll_kary');

            $this->db->where('id_payroll', $id_payroll);
            $this->db->delete('tb_payroll');

            return true;
        }

    }

    public function hapuskaryproll($id_payroll_kary, $id_kary, $tglawal, $tglakhir)
    {
        $this->db->where('id_payroll_kary', $id_payroll_kary);
        $this->db->delete('tb_payroll_kary');

        $this->db->where('id_payroll_kary', $id_payroll_kary);
        $this->db->delete('tb_payroll_detail');

        $this->db->where('tgl_lembur >=', $tglawal);
        $this->db->where('tgl_lembur <=', $tglakhir);
        $this->db->where('id_kary', $id_kary);
        $this->db->delete('tb_payroll_lembur');

        return true;

    }

    public function total_gaji($id_payroll)
    {
        $total_gaji = $this->db->query("SELECT SUM(grand_total) as gnd_gaji FROM vw_payroll_kary WHERE id_payroll =" . $id_payroll)->row();
        $data = [
            'total_gaji' => intval($total_gaji->gnd_gaji),
        ];
        $this->db->where('id_payroll', $id_payroll);
        $this->db->update('tb_payroll', $data);
    }

    public function detail_payroll($id_pay)
    {
        return $this->db->get_where('vw_payroll', ['id_payroll' => $id_pay])->row();
    }

    public function get_lmbr($date, $id_kary)
    {
        return $this->db->get_where('vw_payroll_lembur', ['tgl_lembur' => $date, 'id_kary' => $id_kary])->row();
    }

    public function depart()
    {
        return $this->db->query("SELECT DISTINCT depart FROM tb_kary")->result();

    }

    public function read_data_payroll_terbaru()
    {
        $query = $this->db->query("SELECT bulan, tahun FROM vw_payroll WHERE tgl_hapus ='1970-01-01 00:00:00'")->result();
        if (!empty($query)) {
            $dta = array();
            foreach ($query as $lst) {
                $row = array();
                $month = array('1' => 'JANUARI', '2' => 'FEBRUARI', '3' => 'MARET', '4' => 'APRIL', '5' => 'MEI',
                    '6' => 'JUNI', '7' => 'JULI', '8' => 'AGUSTUS', '9' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOPEMBER', '12' => 'DESEMBER',
                );

                $bulan = $month[$lst->bulan];
                $bulan = substr($bulan, 0, 3);
                $tahun = $lst->tahun;
                $row[] = $bulan . " " . $tahun;
                $dta[] = $row;
            }
            return $dta;
        }
    }

    public function read_data_payroll_terbaru_staff()
    {
        $query = $this->db->query("SELECT total_gaji_staff FROM vw_payroll WHERE tgl_hapus ='1970-01-01 00:00:00' ORDER BY tgl_akhir_gaji DESC LIMIT 6")->result();
        if (!empty($query)) {
            $data = array();
            foreach ($query as $lst) {
                $data[] = number_format($lst->total_gaji_staff);
            }

            return $data;
        }
    }

    public function read_data_payroll_terbaru_nonstaff()
    {
        $query = $this->db->query("SELECT total_gaji_nonstaff FROM vw_payroll WHERE tgl_hapus ='1970-01-01 00:00:00' ORDER BY tgl_akhir_gaji DESC LIMIT 6")->result();
        if (!empty($query)) {
            $data = array();
            foreach ($query as $lst) {
                $data[] = number_format($lst->total_gaji_nonstaff);
            }

            return $data;
        }
    }

    public function getlaspay($bulan, $tahun)
    {
        $query = $this->db->query("SELECT * FROM vw_payroll WHERE tgl_hapus ='1970-01-01 00:00:00' ORDER BY tgl_akhir_gaji DESC LIMIT 1")->row();
        return $query;
    }

    public function get_payroll_kary($id_payroll)
    {
        $query = $this->db->query("SELECT id_kary, gaji_pokok FROM vw_payroll_kary WHERE tgl_hapus ='1970-01-01 00:00:00' ORDER BY tgl_akhir_gaji DESC")->result();
        return $query;
    }

    public function get_payroll_kary_by_id($id_pay, $depart, $tipe)
    {

        // return $depart . " " . $tipe;
        // die;

        if ($depart == 0 && $tipe == 0) {
            return $this->db->query("SELECT * FROM vw_payroll_kary WHERE id_payroll =" . $id_pay)->result();
        } else {
            if ($depart != 0) {
                if ($tipe == 0) {
                    return $this->db->query("SELECT * FROM vw_payroll_kary WHERE id_payroll =" . $id_pay . " AND depart ='" . $depart . "'")->result();
                } else {
                    return $this->db->query("SELECT * FROM vw_payroll_kary WHERE id_payroll =" . $id_pay . " AND depart ='" . $depart . "' AND tipe='" . $tipe . "'")->result();
                }
            } else {
                if ($tipe == 0) {
                    return $this->db->query("SELECT * FROM vw_payroll_kary WHERE id_payroll =" . $id_pay)->result();
                } else {
                    return $this->db->query("SELECT * FROM vw_payroll_kary WHERE id_payroll =" . $id_pay . " AND tipe ='" . $tipe . "'")->result();
                }
            }
        }

    }
}
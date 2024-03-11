<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include library PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Data_payroll extends MY_Controller
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
        $dt_payroll = $this->payroll->read_all_data();
        $depart = $this->payroll->depart();
        $data['dt_payroll'] = $dt_payroll;
        $data['depart'] = $depart;
        $this->load->view('data_payroll/view', $data);
    }

    public function cetak_slip()
    {

        $this->load->helper("terbilang");
        $this->load->library('pdf');

        $id_pay = trim(htmlspecialchars($this->input->get('q1', true)));
        $id_pay_kary = trim(htmlspecialchars($this->input->get('q', true)));

        $dt_payroll = $this->payroll->read_data_by_id($id_pay, $id_pay_kary);
        $dt_p_lembur = $this->payroll->read_data_lembur_by_id($id_pay_kary, $id_pay);
        $dt_p_detail_terima = $this->payroll->read_data_detail_terima_by_id($id_pay_kary);
        $dt_p_detail_potong = $this->payroll->read_data_detail_potong_by_id($id_pay_kary);
        $sub_terima = $this->payroll->jml_detail_terima($id_pay_kary);
        $sub_potong = $this->payroll->jml_detail_potong($id_pay_kary);

        // 3 tabel :
        // $jml_hari = count($dt_p_lembur);
        // $jml_akhir = fmod($jml_hari, 12);
        // if ($jml_akhir == 0) {
        //     $jml_akhir = 11;
        // }

        // $tgl_akhir = $dt_payroll->tgl_akhir_lembur;
        // $tgl_awal_1 = $dt_payroll->tgl_awal_lembur;
        // $tgl_akhir_1 = date('Y-m-d', strtotime('+1 days', strtotime($tgl_awal_1)));
        // $tgl_awal_2 = date('Y-m-d', strtotime('+1 days', strtotime($tgl_akhir_1)));
        // $tgl_akhir_2 = date('Y-m-d', strtotime('+11 days', strtotime($tgl_awal_2)));
        // $tgl_awal_3 = date('Y-m-d', strtotime('+1 days', strtotime($tgl_akhir_2)));
        // $tgl_akhir_3 = date('Y-m-d', strtotime('+' . $jml_akhir . ' days', strtotime($tgl_awal_3)));

        // 2 tabel :
        $jml_hari = count($dt_p_lembur);
        $jml_akhir = ($jml_hari - 1) - 17;

        $tgl_akhir = $dt_payroll->tgl_akhir_lembur;
        $tgl_awal_1 = $dt_payroll->tgl_awal_lembur;
        $tgl_akhir_1 = date('Y-m-d', strtotime('+17 days', strtotime($tgl_awal_1)));
        $tgl_awal_3 = date('Y-m-d', strtotime('+1 days', strtotime($tgl_akhir_1)));
        $tgl_akhir_3 = date('Y-m-d', strtotime('+' . ($jml_akhir - 1) . ' days', strtotime($tgl_awal_3)));

        // echo json_encode([$jml_akhir]);
        // echo json_encode([$tgl_awal_1 . " " . $tgl_akhir_1 . " | " . $tgl_awal_3 . " " . $tgl_akhir_3]);
        // die;

        if (!empty($dt_payroll)) {
            $terbilang = ucwords(number_to_words(intval($dt_payroll->total_penerimaan) - intval($sub_potong->sub_potong))) . ' Rupiah';
            $data['dt_payroll'] = $dt_payroll;
            $data['terbilang'] = $terbilang;
            $data['dt_p_lembur'] = $dt_p_lembur;
            $data['dt_p_detail_terima'] = $dt_p_detail_terima;
            $data['dt_p_detail_potong'] = $dt_p_detail_potong;
            $data['sub_terima'] = $sub_terima;
            $data['sub_potong'] = $sub_potong;
            $data['tgl_awal_1'] = $tgl_awal_1;
            $data['tgl_akhir_1'] = $tgl_akhir_1;
            // $data['tgl_awal_2'] = $tgl_awal_2;
            // $data['tgl_akhir_2'] = $tgl_akhir_2;
            $data['tgl_awal_3'] = $tgl_awal_3;
            $data['tgl_akhir_3'] = $tgl_akhir_3;
            // $html = $this->load->view('data_payroll/slip_gaji_kecil', $data, true);
            $html = $this->load->view('data_payroll/slip_gaji_kecil_new', $data, true);
            $this->pdf->createPDF($html, "SLIP_GAJI", false);
        } else {
            echo 'error';
        }

    }

    // public function cetak_slip_all()
    // {

    //     $this->load->helper("terbilang");
    //     $this->load->library('pdf');

    //     $tipe = trim(htmlspecialchars($this->input->get('q1', true)));
    //     $id_pay = trim(htmlspecialchars($this->input->get('q', true)));

    //     $dt_payroll_kary_all = $this->payroll->read_data_payroll($id_pay);
    //     $dt_proll = $this->payroll->read_data_pyroll($id_pay);
    //     // echo json_encode([$dt_payroll_kary_all]);
    //     // die;

    //     if (!empty($dt_payroll_kary_all)) {
    //         $data['dt_payroll_kary_all'] = $dt_payroll_kary_all;
    //         $data['dt_proll'] = $dt_proll;
    //         $html = $this->load->view('data_payroll/slip_gaji_kecil_all', $data, true);
    //         $this->pdf->createPDF($html, "SLIP_GAJI", false);
    //     } else {
    //         echo 'error';
    //     }
    // }

    public function cetak_slip_all()
    {

        $this->load->helper("terbilang");
        $this->load->library('pdf');

        // $tipe = trim(htmlspecialchars($this->input->get('q1', true)));
        $id_pay = trim(htmlspecialchars($this->input->get('q', true)));

        $dt_payroll_kary_all = $this->payroll->read_data_payroll($id_pay);
        $dt_proll = $this->payroll->read_data_pyroll($id_pay);
        // echo json_encode([$dt_payroll_kary_all]);
        // die;

        if (!empty($dt_payroll_kary_all)) {
            $data['dt_payroll_kary_all'] = $dt_payroll_kary_all;
            $data['dt_proll'] = $dt_proll;
            $html = $this->load->view('data_payroll/slip_gaji_kecil_all_new', $data, true);
            $this->pdf->createPDF($html, "SLIP_GAJI ALL", false);
        } else {
            echo 'error';
        }
    }

    public function hapus()
    {
        $id_payroll = trim(htmlspecialchars($this->input->post('id_pay', true)));
        if (!empty($id_payroll)) {
            $query = $this->payroll->delete_payroll($id_payroll);
            if ($query) {
                echo json_encode(['statusCode' => 200, "pesan" => "Data payroll berhasil dihapus"]);
            } else {
                echo json_encode(['statusCode' => 404, "pesan" => "Data payroll gagal dihapus"]);
            }
        } else {
            echo json_encode(['statusCode' => 404, "pesan" => "Id payroll tidak ditemukan"]);
        }
    }

    public function over_time($id_payroll)
    {
        $this->load->library('pdf');
        $dt_payroll = $this->payroll->read_data_by_id($id_payroll);
        $dt_p_lembur = $this->payroll->read_data_lembur_by_id($id_payroll);

        if (!empty($dt_payroll)) {
            $data['dt_payroll'] = $dt_payroll;
            $data['dt_p_lembur'] = $dt_p_lembur;
            $html = $this->load->view('data_payroll/over_time', $data, true);
            $this->pdf->createPDF($html, "OVERTIME", false);
        } else {
            echo 'error';
        }
    }

    public function gen_lembur($tglawal, $tglakhir, $bln, $tahun, $id_kary, $gaji_pokok, $tipe)
    {
        if ($tipe == "Non Staff") {
            $nilai = 0;
            $lembur_perhari = 0;
            $tgl_start = strtotime($tglawal . ' 12:00');
            $tgl_akhir = strtotime($tglakhir . ' 12:00');
            $thisDate = "";
            $att_code = "";
            $stat_ov = 0;
            $splov = 0;
            for ($i = $tgl_start; $i <= $tgl_akhir; $i = $i + 86400) {
                $thisDate = date('Y-m-d', $i);
                $jmljk = 11;
                $tahun = date('Y', strtotime($thisDate));
                $bulan = intval(date('m', strtotime($thisDate)));
                $tgl_get = intval(date('d', strtotime($thisDate)));
                $tmb_lembur = $this->payroll->get_spl($thisDate, $id_kary);
                if (!empty($tmb_lembur)) {
                    $jm_awal = strtotime($tmb_lembur->jam_mulai);
                    $jm_akhir = strtotime($tmb_lembur->jam_akhir);
                    $diff = $jm_akhir - $jm_awal;
                    $spl = floor($diff / (60 * 60));
                } else {
                    $spl = 0;
                }

                $aktual = $this->payroll->att_aktual($thisDate, $id_kary);
                if (!empty($aktual)) {
                    $att_code = $aktual->kode_ket_kerja;
                    $dtcode = $this->payroll->get_code_att($att_code);
                    if (!empty($dtcode)) {
                        $id_ket_kerja = $dtcode->id_ket_kerja;
                    } else {
                        $id_ket_kerja = 0;
                    }

                    $nilai_lembur = sprintf("%.2f", intval($gaji_pokok) / 173);
                    $hari_libur = $this->payroll->get_ph($thisDate);
                    if (!empty($hari_libur)) { // TGL INI ADA HARI LIBUR
                        $jmlov = 29;
                        if ($hari_libur->stat_lembur == "PH") {
                            if ($att_code == "N" || $att_code == "D" || $att_code == "SR" || $att_code == "DOF" || $att_code == "NOF") {
                                $lembur_perhari = $lembur_perhari + (29 * $nilai_lembur);
                                if ($spl > 0) {
                                    $splov = $spl * 4;
                                    $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                    $jmlov = $jmlov + $splov;
                                    $jmljk = $jmljk + $spl;
                                }
                                $id_jenis_lembur = 2;
                                $stat_ov = 1;
                                $id_ket_kerja = 26;
                            } else {
                                $stat_ov = 0;
                            }
                        } else if ($hari_libur->stat_lembur == "PHD") {
                            if ($att_code == "D" || $att_code == "SRD" || $att_code == "DOF") {
                                $lembur_perhari = $lembur_perhari + (29 * $nilai_lembur);
                                if ($spl > 0) {
                                    $splov = $spl * 4;
                                    $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                    $jmlov = $jmlov + $splov;
                                    $jmljk = $jmljk + $spl;
                                }
                                $id_jenis_lembur = 2;
                                $stat_ov = 1;
                                $id_ket_kerja = 28;
                            } else {
                                $stat_ov = 0;
                            }
                        } else if ($hari_libur->stat_lembur == "PHN") {
                            if ($att_code == "N" || $att_code == "SRN" || $att_code == "NOF") {
                                $lembur_perhari = $lembur_perhari + (29 * $nilai_lembur);
                                if ($spl > 0) {
                                    $splov = $spl * 4;
                                    $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                    $jmlov = $jmlov + $splov;
                                    $jmljk = $jmljk + $spl;
                                }
                                $id_jenis_lembur = 2;
                                $stat_ov = 1;
                                $id_ket_kerja = 27;
                            } else {
                                $stat_ov = 0;
                            }
                        } else if ($hari_libur->stat_lembur == "PHH") {
                            if ($att_code == "N" || $att_code == "D" || $att_code == "SR" || $att_code == "DOF" || $att_code == "NOF") {
                                $lembur_perhari = $lembur_perhari + (29 * $nilai_lembur);
                                if ($spl > 0) {
                                    $splov = $spl * 4;
                                    $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                    $jmlov = $jmlov + $splov;
                                    $jmljk = $jmljk + $spl;
                                }
                                $id_jenis_lembur = 2;
                                $stat_ov = 1;
                                $id_ket_kerja = 26;
                            } else if ($att_code == "RG") {
                                $jmljk = 6;
                                $jmlov = 12;
                                $lembur_perhari = $lembur_perhari + (12 * $nilai_lembur);
                                if ($spl > 0) {
                                    $splov = $spl * 4;
                                    $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                    $jmlov = $jmlov + $splov;
                                    $jmljk = $jmljk + $spl;
                                }

                                $id_jenis_lembur = 2;
                                $stat_ov = 1;
                                $id_ket_kerja = 26;
                            } else {
                                $stat_ov = 0;
                            }
                        }
                    } else { // JIKA TIDAK ADA HARI LIBUR
                        $jmlov = 7.5;
                        if ($att_code == "N" || $att_code == "D" || $att_code == "SR" || $att_code == "DOF" || $att_code == "NOF") {
                            $lembur_perhari = $lembur_perhari + (7.5 * $nilai_lembur);
                            if ($spl > 0) {
                                $splov = $spl * 2;
                                $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                $jmlov = $jmlov + $splov;
                                $jmljk = $jmljk + $spl;
                            }
                            $id_jenis_lembur = 1;
                            $stat_ov = 1;
                        } else {
                            $stat_ov = 0;
                        }
                    }

                    if ($att_code == "DOF" || $att_code == "NOF") {
                        $jmljk = 0;
                    }

                    if ($stat_ov == 1) {
                        $dtov = [
                            'id_kary' => $id_kary,
                            'tgl_lembur' => $thisDate,
                            'id_jenis_lembur' => $id_jenis_lembur,
                            'jml_jam_kerja' => $jmljk,
                            'overtime' => $jmlov,
                            'id_ket_kerja' => $id_ket_kerja,
                        ];
                    } else {
                        $dtov = [
                            'id_kary' => $id_kary,
                            'tgl_lembur' => $thisDate,
                            'id_jenis_lembur' => 0,
                            'jml_jam_kerja' => 0,
                            'overtime' => 0,
                            'id_ket_kerja' => $id_ket_kerja,
                        ];
                    }

                    $this->payroll->add_ov($dtov);
                } else {
                    $att = $this->payroll->get_att($bulan, $tahun, $id_kary);
                    if (!empty($att)) {
                        $tb = 't' . $tgl_get;
                        $att_code = $att->{$tb};
                        $dtcode = $this->payroll->get_code_att($att_code);
                        if (!empty($dtcode)) {
                            $id_ket_kerja = $dtcode->id_ket_kerja;
                        } else {
                            $id_ket_kerja = 0;
                        }

                        $nilai_lembur = sprintf("%.2f", intval($gaji_pokok) / 173);
                        $hari_libur = $this->payroll->get_ph($thisDate);
                        if (!empty($hari_libur)) { // TGL INI ADA HARI LIBUR
                            $jmlov = 29;
                            if ($hari_libur->stat_lembur == "PH") {
                                if ($att_code == "N" || $att_code == "D" || $att_code == "SR" || $att_code == "DOF" || $att_code == "NOF") {
                                    $lembur_perhari = $lembur_perhari + (29 * $nilai_lembur);
                                    if ($spl > 0) {
                                        $splov = $spl * 4;
                                        $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                        $jmlov = $jmlov + $splov;
                                        $jmljk = $jmljk + $spl;
                                    }
                                    $id_jenis_lembur = 2;
                                    $stat_ov = 1;
                                    $id_ket_kerja = 26;
                                } else {
                                    $stat_ov = 0;
                                }
                            } else if ($hari_libur->stat_lembur == "PHD") {
                                if ($att_code == "D" || $att_code == "SRD" || $att_code == "DOF") {
                                    $lembur_perhari = $lembur_perhari + (29 * $nilai_lembur);
                                    if ($spl > 0) {
                                        $splov = $spl * 4;
                                        $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                        $jmlov = $jmlov + $splov;
                                        $jmljk = $jmljk + $spl;
                                    }
                                    $id_jenis_lembur = 2;
                                    $stat_ov = 1;
                                    $id_ket_kerja = 28;
                                } else {
                                    $stat_ov = 0;
                                }
                            } else if ($hari_libur->stat_lembur == "PHN") {
                                if ($att_code == "N" || $att_code == "SRN" || $att_code == "NOF") {
                                    $lembur_perhari = $lembur_perhari + (29 * $nilai_lembur);
                                    if ($spl > 0) {
                                        $splov = $spl * 4;
                                        $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                        $jmlov = $jmlov + $splov;
                                        $jmljk = $jmljk + $spl;
                                    }
                                    $id_jenis_lembur = 2;
                                    $stat_ov = 1;
                                    $id_ket_kerja = 27;
                                } else {
                                    $stat_ov = 0;
                                }
                            } else if ($hari_libur->stat_lembur == "PHH") {
                                if ($att_code == "N" || $att_code == "D" || $att_code == "SR" || $att_code == "DOF" || $att_code == "NOF") {
                                    $lembur_perhari = $lembur_perhari + (29 * $nilai_lembur);
                                    if ($spl > 0) {
                                        $splov = $spl * 4;
                                        $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                        $jmlov = $jmlov + $splov;
                                        $jmljk = $jmljk + $spl;
                                    }
                                    $id_jenis_lembur = 2;
                                    $stat_ov = 1;
                                    $id_ket_kerja = 26;
                                } else if ($att_code == "RG") {
                                    $jmljk = 6;
                                    $jmlov = 12;
                                    $lembur_perhari = $lembur_perhari + (12 * $nilai_lembur);
                                    if ($spl > 0) {
                                        $splov = $spl * 4;
                                        $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                        $jmlov = $jmlov + $splov;
                                        $jmljk = $jmljk + $spl;
                                    }

                                    $id_jenis_lembur = 2;
                                    $stat_ov = 1;
                                    $id_ket_kerja = 26;
                                } else {
                                    $stat_ov = 0;
                                }
                            }
                        } else { // JIKA TIDAK ADA HARI LIBUR
                            $jmlov = 7.5;
                            if ($att_code == "N" || $att_code == "D" || $att_code == "SR" || $att_code == "DOF" || $att_code == "NOF") {
                                $lembur_perhari = $lembur_perhari + (7.5 * $nilai_lembur);
                                if ($spl > 0) {
                                    $splov = $spl * 2;
                                    $lembur_perhari = $lembur_perhari + ($splov * $nilai_lembur);
                                    $jmlov = $jmlov + $splov;
                                    $jmljk = $jmljk + $spl;
                                }
                                $id_jenis_lembur = 1;
                                $stat_ov = 1;
                            } else {
                                $stat_ov = 0;
                            }
                        }

                        if ($att_code == "DOF" || $att_code == "NOF") {
                            $jmljk = 0;
                        }

                        if ($stat_ov == 1) {
                            $dtov = [
                                'id_kary' => $id_kary,
                                'tgl_lembur' => $thisDate,
                                'id_jenis_lembur' => $id_jenis_lembur,
                                'jml_jam_kerja' => $jmljk,
                                'overtime' => $jmlov,
                                'id_ket_kerja' => $id_ket_kerja,
                            ];
                        } else {
                            $dtov = [
                                'id_kary' => $id_kary,
                                'tgl_lembur' => $thisDate,
                                'id_jenis_lembur' => 0,
                                'jml_jam_kerja' => 0,
                                'overtime' => 0,
                                'id_ket_kerja' => $id_ket_kerja,
                            ];
                        }

                        $this->payroll->add_ov($dtov);
                    } else {
                        $dtov = [
                            'id_kary' => $id_kary,
                            'tgl_lembur' => $thisDate,
                            'id_jenis_lembur' => 0,
                            'jml_jam_kerja' => 0,
                            'overtime' => 0,
                            'id_ket_kerja' => 25,
                        ];

                        $this->payroll->add_ov($dtov);
                    }
                }

            }

            return intval($lembur_perhari);
        } else {
            return 0;
        }
    }

    public function gen_uanghadir($id_payroll_kary, $grade, $tipe, $tglawal, $tglakhir, $bln, $tahun, $id_kary, $gaji_pokok)
    {
        $nilai = 0;
        $uanghadir = 0;
        $tgl_start = strtotime($tglawal . ' 12:00');
        $tgl_akhir = strtotime($tglakhir . ' 12:00');
        $thisDate = "";
        $att_code = "";

        $n_ua = $this->payroll->get_ua($grade);
        if (!empty($n_ua)) {
            $nilai = $n_ua->nilai;
        } else {
            $nilai = 0;
        }

        for ($i = $tgl_start; $i <= $tgl_akhir; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $tahun = date('Y', strtotime($thisDate));
            $bulan = intval(date('m', strtotime($thisDate)));
            $tgl_get = intval(date('d', strtotime($thisDate)));
            $hari_libur = $this->payroll->get_ph($thisDate);
            $att = $this->payroll->get_att($bulan, $tahun, $id_kary);
            if (!empty($att)) {
                $tb = 't' . $tgl_get;
                $att_code = $att->{$tb};
                if (!empty($hari_libur)) { // TGL INI ADA HARI LIBUR
                    if ($hari_libur->stat_lembur == "PH") {
                        if ($att_code == "D" || $att_code == "N" || $att_code == "RG" || $att_code == "SRN" || $att_code == "SRD" || $att_code == "TRV" || $att_code == "TGS") {
                            $uanghadir = $uanghadir + $nilai;
                        }
                    } else if ($hari_libur->stat_lembur == "PHD") {
                        if ($att_code == "D" || $att_code == "RG" || $att_code == "SRN" || $att_code == "SRD" || $att_code == "TRV" || $att_code == "TGS") {
                            $uanghadir = $uanghadir + $nilai;
                        }
                    } else if ($hari_libur->stat_lembur == "PHN") {
                        if ($att_code == "N" || $att_code == "RG" || $att_code == "SRN" || $att_code == "SRD" || $att_code == "TRV" || $att_code == "TGS") {
                            $uanghadir = $uanghadir + $nilai;
                        }
                    } else if ($hari_libur->stat_lembur == "PHH") {
                        if ($att_code == "D" || $att_code == "N" || $att_code == "RG" || $att_code == "SRN" || $att_code == "SRD" || $att_code == "TRV" || $att_code == "TGS") {
                            $uanghadir = $uanghadir + $nilai;
                        }
                    }
                } else {
                    if ($att_code == "D" || $att_code == "N" || $att_code == "RG" || $att_code == "SRN" || $att_code == "SRD" || $att_code == "TRV" || $att_code == "TGS") {
                        $uanghadir = $uanghadir + $nilai;
                    } else if ($att_code == "OFF") {
                        if ($tipe == "STAFF") {
                            $uanghadir = $uanghadir + $nilai;
                        }
                    }
                }
            }
        }

        // $uanghadir = sprintf("%.1f", $uanghadir);
        return intval($uanghadir);
    }

    public function gen_absensi($id_payroll_kary, $tglawal, $tglakhir, $bulan, $tahun, $id_kary, $gaji_pokok)
    {
        $jmlabsen = 0;
        $tgl_start = strtotime($tglawal . ' 12:00');
        $tgl_akhir = strtotime($tglakhir . ' 12:00');
        $jmlhari = date('t', strtotime($tglakhir));
        $thisDate = "";
        $att_code = "";
        $nilai_harian = intval($gaji_pokok / intval($jmlhari));

        for ($i = $tgl_start; $i <= $tgl_akhir; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $tahun = date('Y', strtotime($thisDate));
            $bulan = intval(date('m', strtotime($thisDate)));
            $tgl_get = intval(date('d', strtotime($thisDate)));
            $hari_libur = $this->payroll->get_ph($thisDate);
            $att = $this->payroll->get_att($bulan, $tahun, $id_kary);
            if (!empty($att)) {
                $tb = 't' . $tgl_get;
                $att_code = $att->{$tb};
                if ($att_code == "STS" || $att_code == "LWOP" || $att_code == "A") {
                    $jmlabsen = $jmlabsen + 1;
                }
            }

        }

        $total_absen = $nilai_harian * $jmlabsen;
        return intval($total_absen);
    }

    public function gen_payroll($bulan, $tahun, $tglawal, $tglakhir, $id_payroll)
    {

        $dt_kary = $this->payroll->read_all_data_kary_gaji($bulan, $tahun);

        if (!empty($dt_kary)) {
            foreach ($dt_kary as $list) {
                $id_kary = $list->id_kary;
                $gaji_pokok = $list->gaji_pokok;
                $id_gaji = $list->id_gaji;
                $grade = $list->grade;
                $tipe = $list->tipe;
                $bpjs_kes = $list->bpjs_kes;
                $bp_jamsostek = $list->bp_jamsostek;
                // $nilai_lembur = $list->nilai_lembur;
                $pph = 0;
                $ovt = $this->gen_lembur($tglawal, $tglakhir, $bulan, $tahun, $id_kary, $gaji_pokok, $tipe);
                // $ovt = 0;
                if ($gaji_pokok == "" || $gaji_pokok == null) {
                    $gaji_pokok = 0;
                }

                // $ovt = 0;
                $data = [
                    'id_gaji' => $id_gaji,
                    'id_payroll' => $id_payroll,
                    'gaji_pokok' => $gaji_pokok,
                    'total_lembur' => intval($ovt),
                    'total_tunj_tidak_tetap' => 0,
                    'total_potongan' => 0,
                    'status_payroll_kary' => 'T',
                    'tgl_buat' => date('Y-m-d'),
                    'tgl_edit' => date('Y-m-d'),
                    'tgl_hapus' => '1970-01-01 00:00:00',
                    'id_user' => 1,
                ];

                $result = $this->payroll->gen_payroll($data);
                if ($result['status'] == 200) {
                    $id_payroll_kary = $result['id_payroll_kary'];

                    // add uang hadir
                    $uh = $this->gen_uanghadir($id_payroll_kary, $grade, $tipe, $tglawal, $tglakhir, $bulan, $tahun, $id_kary, $gaji_pokok);
                    $data = [
                        'id_payroll_kary' => $id_payroll_kary,
                        'id_tambahan' => 3,
                        'nilai' => intval($uh),
                    ];
                    $this->payroll->add_tambahan($data);

                    // add absensi
                    $abs = $this->gen_absensi($id_payroll_kary, $tglawal, $tglakhir, $bulan, $tahun, $id_kary, $gaji_pokok);
                    $data = [
                        'id_payroll_kary' => $id_payroll_kary,
                        'id_tambahan' => 11,
                        'nilai' => intval($abs),
                    ];
                    $this->payroll->add_tambahan($data);

                    // add bpjs_kes
                    $data = [
                        'id_payroll_kary' => $id_payroll_kary,
                        'id_tambahan' => 9,
                        'nilai' => intval($bpjs_kes),
                    ];
                    $this->payroll->add_tambahan($data);

                    // add bpjs_tk
                    $data = [
                        'id_payroll_kary' => $id_payroll_kary,
                        'id_tambahan' => 8,
                        'nilai' => intval($bp_jamsostek),
                    ];
                    $this->payroll->add_tambahan($data);

                    // add pph penerimaan
                    // $data = [
                    //     'id_payroll_kary' => $id_payroll_kary,
                    //     'id_tambahan' => 7,
                    //     'nilai' => 0,
                    // ];
                    // $this->payroll->add_tambahan($data);

                    // add pph potongan
                    // $data = [
                    //     'id_payroll_kary' => $id_payroll_kary,
                    //     'id_tambahan' => 12,
                    //     'nilai' => 0,
                    // ];
                    // $this->payroll->add_tambahan($data);

                    // add THR
                    $data = [
                        'id_payroll_kary' => $id_payroll_kary,
                        'id_tambahan' => 5,
                        'nilai' => 0,
                    ];
                    $this->payroll->add_tambahan($data);

                    //hitung gaji prorate
                    $this->prorate($id_kary, $id_payroll_kary, $gaji_pokok, $bulan, $tahun);

                    //hitung total tunjangan dan total potongan :
                    $pph_potong = 0;
                    $pph_terima = 0;
                    $bonus = 0;
                    $thr = 0;

                    $total_tidak_tetap = $uh + $pph_terima + $bonus + $thr;
                    $total_potong = $bpjs_kes + $bp_jamsostek + $pph_potong + $abs;

                    $data = [
                        'total_tunj_tidak_tetap' => $total_tidak_tetap,
                        'total_potongan' => $total_potong,
                        'id_user' => 1,
                    ];

                    $this->payroll->add_total_gaji($data, $id_payroll_kary);
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function gen_payroll_kary($id_payroll, $bulan, $tahun, $tglawal, $tglakhir, $id_payroll_kary, $id_kary)
    {

        $dt_kary = $this->payroll->read_all_data_perkary_gaji($id_kary, $bulan, $tahun);
        if (!empty($dt_kary)) {
            $id_kary = $dt_kary->id_kary;
            $gaji_pokok = $dt_kary->gaji_pokok;
            $id_gaji = $dt_kary->id_gaji;
            $grade = $dt_kary->grade;
            $tipe = $dt_kary->tipe;
            $bpjs_kes = $dt_kary->bpjs_kes;
            $bp_jamsostek = $dt_kary->bp_jamsostek;
            $pph = 0;
            $ovt = $this->gen_lembur($tglawal, $tglakhir, $bulan, $tahun, $id_kary, $gaji_pokok, $tipe);
            // $ovt = 0;

            $data = [
                'id_gaji' => $id_gaji,
                'id_payroll' => $id_payroll,
                'gaji_pokok' => $gaji_pokok,
                'total_lembur' => intval($ovt),
                'total_tunj_tidak_tetap' => 0,
                'total_potongan' => 0,
                'status_payroll_kary' => 'T',
                'tgl_buat' => date('Y-m-d'),
                'tgl_edit' => date('Y-m-d'),
                'tgl_hapus' => '1970-01-01 00:00:00',
                'id_user' => 1,
            ];

            $result = $this->payroll->gen_payroll($data);
            if ($result['status'] == 200) {
                $id_payroll_kary = $result['id_payroll_kary'];

                // add uang hadir
                $uh = $this->gen_uanghadir($id_payroll_kary, $grade, $tipe, $tglawal, $tglakhir, $bulan, $tahun, $id_kary, $gaji_pokok);
                $data = [
                    'id_payroll_kary' => $id_payroll_kary,
                    'id_tambahan' => 3,
                    'nilai' => intval($uh),
                ];
                $this->payroll->add_tambahan($data);

                // add absensi
                $abs = $this->gen_absensi($id_payroll_kary, $tglawal, $tglakhir, $bulan, $tahun, $id_kary, $gaji_pokok);
                $data = [
                    'id_payroll_kary' => $id_payroll_kary,
                    'id_tambahan' => 11,
                    'nilai' => intval($abs),
                ];
                $this->payroll->add_tambahan($data);

                // add bpjs_kes
                $data = [
                    'id_payroll_kary' => $id_payroll_kary,
                    'id_tambahan' => 9,
                    'nilai' => intval($bpjs_kes),
                ];
                $this->payroll->add_tambahan($data);

                // add bpjs_tk
                $data = [
                    'id_payroll_kary' => $id_payroll_kary,
                    'id_tambahan' => 8,
                    'nilai' => intval($bp_jamsostek),
                ];
                $this->payroll->add_tambahan($data);

                // add pph penerimaan
                $data = [
                    'id_payroll_kary' => $id_payroll_kary,
                    'id_tambahan' => 7,
                    'nilai' => 0,
                ];
                $this->payroll->add_tambahan($data);

                // add pph potongan
                $data = [
                    'id_payroll_kary' => $id_payroll_kary,
                    'id_tambahan' => 12,
                    'nilai' => 0,
                ];
                $this->payroll->add_tambahan($data);

                // add THR
                $data = [
                    'id_payroll_kary' => $id_payroll_kary,
                    'id_tambahan' => 5,
                    'nilai' => 0,
                ];
                $this->payroll->add_tambahan($data);

                //hitung gaji prorate
                $this->prorate($id_kary, $id_payroll_kary, $gaji_pokok, $bulan, $tahun);

                //hitung total tunjangan dan total potongan :
                $pph_potong = 0;
                $pph_terima = 0;
                $bonus = 0;
                $thr = 0;

                $total_tidak_tetap = $uh + $pph_terima + $bonus + $thr;
                $total_potong = $bpjs_kes + $bp_jamsostek + $pph_potong + $abs;

                $data = [
                    'total_tunj_tidak_tetap' => $total_tidak_tetap,
                    'total_potongan' => $total_potong,
                    'id_user' => 1,
                ];

                $this->payroll->add_total_gaji($data, $id_payroll_kary);
            }

            return true;

        } else {
            return false;
        }

    }

    public function add_payroll()
    {

        $bulan = trim(htmlspecialchars($this->input->post('bulan', true)));
        $tahun = trim(htmlspecialchars($this->input->post('tahun', true)));
        $tglawal = trim(htmlspecialchars($this->input->post('tglawal', true)));
        $tglakhir = trim(htmlspecialchars($this->input->post('tglakhir', true)));

        $tglnow = date('Y-m-d');
        $bn = intval($bulan);

        $dt_kary = $this->payroll->read_all_data_kary();
        if (empty($dt_kary)) {
            echo json_encode(['statusCode' => 400, 'pesan' => 'Tidak ada karyawan terdaftar']);
            die;
        }

        $data = [
            'tgl_payroll' => $tglnow,
            'bulan' => $bn,
            'tahun' => $tahun,
            'tgl_awal_lembur' => $tglawal,
            'tgl_akhir_lembur' => $tglakhir,
            'tgl_awal_gaji' => $tglawal,
            'tgl_akhir_gaji' => $tglakhir,
            'total_gaji_staff' => 0,
            'total_gaji_nonstaff' => 0,
            'total_gaji' => 0,
            'status_payroll' => 'T',
            'tgl_buat' => date('Y-m-d'),
            'tgl_edit' => date('Y-m-d'),
            'tgl_hapus' => '1970-01-01 00:00:00',
            'id_user' => 1,
        ];

        $result = $this->payroll->add_payroll($data);
        if ($result['status'] == 200) {
            $id_payroll = $result['id_payroll'];
            $query = $this->gen_payroll($bulan, $tahun, $tglawal, $tglakhir, $id_payroll);
            if ($query) {
                $this->payroll->total_gaji($id_payroll);
                $this->total_gaji_by_tipe($id_payroll);
                echo json_encode(['statusCode' => 200, 'pesan' => 'Generate Sukses']);
            } else {
                echo json_encode(['statusCode' => 400, 'pesan' => 'Generate gagal']);
            }
        } else {
            echo json_encode(['statusCode' => 400, 'pesan' => 'Generate gagal']);
        }
    }

    public function total_gaji_by_tipe($id_payroll)
    {
        $gajistaff = $this->payroll->total_gaji_staff($id_payroll);
        $gajinonstaff = $this->payroll->total_gaji_nonstaff($id_payroll);

        $data = [
            'total_gaji_staff' => intval($gajistaff->gaji_staff),
            'total_gaji_nonstaff' => intval($gajinonstaff->gaji_nonstaff),
        ];

        $result = $this->payroll->update_payroll($data, $id_payroll);
        return true;
    }

    public function prorate($id_kary, $id_payroll_kary, $gaji_pokok, $bulan, $tahun)
    {

        $bulan = sprintf("%02d", $bulan);
        $tglawal = $tahun . "-" . $bulan . "-01";
        $jml_hari = date('t', strtotime($tglawal));
        $tglakhir = date("Y-m-d", strtotime("+" . ($jml_hari - 1) . " days", strtotime($tglawal)));

        // echo json_encode([$tglawal, $tglakhir]);
        // die;

        $tgl_start = strtotime($tglawal . " 12:00");
        $tgl_akhir = strtotime($tglakhir . " 12:00");
        $thisDate = "";
        $att_code = "";
        $waktu_off = 0;
        $total_gaji_pokok = 0;

        for ($i = $tgl_start; $i <= $tgl_akhir; $i = $i + 86400) {
            $thisDate = date("Y-m-d", $i);
            $tahun = date("Y", strtotime($thisDate));
            $bulan = intval(date("m", strtotime($thisDate)));
            $tgl_get = intval(date("d", strtotime($thisDate)));
            $att = $this->payroll->get_att($bulan, $tahun, $id_kary);
            if (!empty($att)) {
                $tb = 't' . $tgl_get;
                $att_code = $att->{$tb};
                if ($att_code != "" || $att_code != "KSG") {
                    if ($att_code == "TERM" || $att_code == "RSG" || $att_code == "EOC" || $att_code == "PHK") {
                        $waktu_off += 1;
                    }
                }
            }
        }

        if ($waktu_off > 0) {
            $nilai_prorate = intval(($gaji_pokok / $jml_hari));
            $total_gaji_pokok = ($jml_hari - $waktu_off) * $nilai_prorate;

            $data = [
                'gaji_pokok' => intval($total_gaji_pokok),
            ];

            $this->payroll->update_lembur($data, $id_payroll_kary);
        }

        return true;
    }

    public function detail_payroll()
    {

        $id_pay = trim(htmlspecialchars($this->input->post('id_pay', true)));
        $dtpayroll = $this->payroll->detail_payroll($id_pay);
        if (!empty($dtpayroll)) {
            $month = array('1' => 'JANUARI', '2' => 'FEBRUARI', '3' => 'MARET', '4' => 'APRIL', '5' => 'MEI',
                '6' => 'JUNI', '7' => 'JULI', '8' => 'AGUSTUS', '9' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOPEMBER', '12' => 'DESEMBER',
            );

            $bulan = $month[$dtpayroll->bulan];
            $tahun = $dtpayroll->tahun;
            echo json_encode(['statusCode' => 200, 'bulan' => $bulan, 'tahun' => $tahun]);
        } else {
            echo json_encode(['statusCode' => 400]);
        }
    }

    public function hitungulang()
    {
        $id_pay_kary = trim(htmlspecialchars($this->input->post('id_pay_kary', true)));
        $dtpayrollkary = $this->payroll->read_data_payroll_kary($id_pay_kary);

        if (!empty($dtpayrollkary)) {
            // echo json_encode([$dtpayrollkary]);
            // die;
            $id_payroll = $dtpayrollkary->id_payroll;
            $id_kary = $dtpayrollkary->id_kary;
            $bulan = $dtpayrollkary->bulan;
            $tahun = $dtpayrollkary->tahun;
            $tglawal = $dtpayrollkary->tgl_awal_lembur;
            $tglakhir = $dtpayrollkary->tgl_akhir_lembur;
            $tglnow = date('Y-m-d');
            $this->payroll->hapuskaryproll($id_pay_kary, $id_kary, $tglawal, $tglakhir);
            $query = $this->gen_payroll_kary($id_payroll, $bulan, $tahun, $tglawal, $tglakhir, $id_pay_kary, $id_kary);
            if ($query) {
                $this->payroll->total_gaji($id_payroll);
                $this->total_gaji_by_tipe($id_payroll);
                echo json_encode(['statusCode' => 200, 'pesan' => 'Generate payroll perkaryawan sukses']);
            } else {
                echo json_encode(['statusCode' => 400, 'pesan' => 'Generate payroll perkaryawan gagal']);
            }
        } else {
            echo json_encode(['statusCode' => 400, 'pesan' => 'Data karyawan tidak ditemukan']);

        }

    }

    public function getlastpay()
    {
        $bulan = intval(trim(htmlspecialchars($this->input->post('bulan', true))));
        $tahun = intval(trim(htmlspecialchars($this->input->post('tahun', true))));

        $dtpay = $this->payroll->getlaspay($bulan, $tahun);
        if (!empty($dtpay)) {
            $tgl_lembur = $dtpay->tgl_akhir_lembur;
            $tgl_lanjut = date('Y-m-d', strtotime("+1 days", strtotime($tgl_lembur)));
            $tgl_akhir = date('Y-m-d', strtotime("+30 days", strtotime($tgl_lanjut)));

            echo json_encode(["statusCode" => 200, "tgl_awal" => $tgl_lanjut, "tgl_akhir" => $tgl_akhir]);
        } else {
            $tgl_lanjut = date('Y-m-d');
            $tgl_akhir = date('Y-m-d');
            echo json_encode(["statusCode" => 400, "tgl_awal" => $tgl_lanjut, "tgl_akhir" => $tgl_akhir]);
        }
    }

    public function detail_payroll_kary()
    {
        $id_pay = trim(htmlspecialchars($this->input->get('id_pay', true)));
        $depart = trim(htmlspecialchars($this->input->get('q', true)));
        $tipe = trim(htmlspecialchars($this->input->get('q2', true)));
        $depart = str_replace('|', ' ', $depart);

        $dtprolkary = $this->payroll->get_payroll_kary_by_id($id_pay, $depart, $tipe);
        // echo json_encode([$dtprolkary]);
        // die;
        $data['dtprolkary'] = $dtprolkary;
        $this->load->view('data_payroll/detail_payroll_kary', $data);
    }

    public function import()
    {

        $bulan = intval($this->input->post('bulan'));
        $tahun = intval($this->input->post('tahun'));
        $table = "tb_payroll";

        $dtp = $this->payroll->read_data_roll($table, $bulan, $tahun);
        if (!empty($dtp)) {
            $id_payroll = $dtp->id_payroll;
            $path = $_FILES["importFile"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            $sourceKaryawan = 'tb_payroll_kary';
            $field = 'id_payroll_kary';
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                $no = 1;

                for ($row = 6; $row <= $highestRow; $row++) {
                    $id_payroll_kary = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $no_nik = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $gaji_pokok = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $lembur = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    // echo json_encode([$lembur]);
                    // die;

                    $uanghadir = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $thr = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $bonus = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $pph = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $rapelan = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $pesangon = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                    $insentif = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                    $ttunj = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                    $bpkes = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                    $bpkerja = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                    $absensi = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                    $tpot = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
                    $gtot = $worksheet->getCellByColumnAndRow(24, $row)->getValue();

                    $data = [
                        'gaji_pokok' => intval($gaji_pokok),
                        'total_lembur' => intval($lembur),
                        'total_tunj_tidak_tetap' => intval($ttunj),
                        'total_potongan' => intval($tpot),
                    ];

                    $this->payroll->update_lembur($data, $id_payroll_kary);

                    //insentif
                    $id = 16;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($insentif),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        $data = [
                            'id_payroll_kary' => $id_payroll_kary,
                            'id_tambahan' => $id,
                            'nilai' => intval($insentif),
                        ];
                        $this->payroll->input_tambahan($data);
                    }

                    //rapelan
                    $id = 17;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($rapelan),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        $data = [
                            'id_payroll_kary' => $id_payroll_kary,
                            'id_tambahan' => $id,
                            'nilai' => intval($rapelan),
                        ];
                        $this->payroll->input_tambahan($data);
                    }

                    //pesangon
                    $id = 19;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($pesangon),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        $data = [
                            'id_payroll_kary' => $id_payroll_kary,
                            'id_tambahan' => $id,
                            'nilai' => intval($pesangon),
                        ];
                        $this->payroll->input_tambahan($data);
                    }

                    //bpkerja
                    $id = 8;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($bpkerja),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        $data = [
                            'id_payroll_kary' => $id_payroll_kary,
                            'id_tambahan' => $id,
                            'nilai' => intval($bpkerja),
                        ];
                        $this->payroll->input_tambahan($data);
                    }

                    //bpkes
                    $id = 9;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($bpkes),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        $data = [
                            'id_payroll_kary' => $id_payroll_kary,
                            'id_tambahan' => $id,
                            'nilai' => intval($bpkes),
                        ];
                        $this->payroll->input_tambahan($data);
                    }

                    //pph
                    $id = 7;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($pph),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        $data = [
                            'id_payroll_kary' => $id_payroll_kary,
                            'id_tambahan' => $id,
                            'nilai' => intval($pph),
                        ];
                        $this->payroll->input_tambahan($data);
                    }

                    //pph
                    $id = 12;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($pph),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        $data = [
                            'id_payroll_kary' => $id_payroll_kary,
                            'id_tambahan' => $id,
                            'nilai' => intval($pph),
                        ];
                        $this->payroll->input_tambahan($data);
                    }

                    //thr
                    $id = 5;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($thr),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        $data = [
                            'id_payroll_kary' => $id_payroll_kary,
                            'id_tambahan' => $id,
                            'nilai' => intval($thr),
                        ];
                        $this->payroll->input_tambahan($data);
                    }

                    //bonus
                    $id = 6;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($bonus),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        if (intval($bonus) > 0) {
                            $data = [
                                'id_payroll_kary' => $id_payroll_kary,
                                'id_tambahan' => $id,
                                'nilai' => intval($bonus),
                            ];
                            $this->payroll->input_tambahan($data);
                        }
                    }

                    //uanghadir
                    $id = 3;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($uanghadir),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        $data = [
                            'id_payroll_kary' => $id_payroll_kary,
                            'id_tambahan' => $id,
                            'nilai' => intval($uanghadir),
                        ];
                        $this->payroll->input_tambahan($data);
                    }

                    //absensi
                    $id = 11;
                    $cekinst = $this->payroll->cek_detail($id_payroll_kary, $id);
                    if (!empty($cekinst)) {
                        $data = [
                            'nilai' => intval($absensi),
                        ];
                        $this->payroll->update_tambahan($data, $id_payroll_kary, $id);
                    } else {
                        $data = [
                            'id_payroll_kary' => $id_payroll_kary,
                            'id_tambahan' => $id,
                            'nilai' => intval($absensi),
                        ];
                        $this->payroll->input_tambahan($data);
                    }

                    $this->payroll->total_gaji($id_payroll);
                }
            }
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Import Data Gaji Berhasil'));
        } else {
            echo json_encode(['statusCode' => 400, 'Payroll tidak ditemukan']);
            die;
        }

    }

    public function export_excel()
    {
        $depart = "ALL DEPARTEMEN";
        $idpay = trim(htmlspecialchars($this->input->get('q', true)));
        $dtpay = $this->payroll->read_data_pyroll($idpay);
        $bulan = sprintf("%02d", $dtpay->bulan);
        $tahun = $dtpay->tahun;
        $tgl_start = $tahun . '-' . $bulan . '-01';
        $bth = strtoupper(date('M Y', strtotime($tgl_start)));
        $bt = date('MY', strtotime($tgl_start));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border left dengan garis tipis
            ],
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border left dengan garis tipis
            ],
        ];
        $sheet->setCellValue('A1', "PT UNGGUL DINAMIKA UTAMA"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->setCellValue('A2', $depart); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->setCellValue('A3', "DATA PAYROLL " . $bth); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->setCellValue('A4', ""); // Set kolom A1 dengan tulisan "DATA SISWA"
        // $sheet->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('A2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('A3')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('A1')->getFont()->setSize(20); // Set bold kolom A1
        $sheet->getStyle('A2')->getFont()->setSize(18); // Set bold kolom A1
        $sheet->getStyle('A3')->getFont()->setSize(14); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A5', "ID");
        $sheet->setCellValue('B5', "NIK/NRP");
        $sheet->setCellValue('C5', "NAMA");
        $sheet->setCellValue('D5', "DEPARTEMEN");
        $sheet->setCellValue('E5', "POSISI");
        $sheet->setCellValue('F5', "TIPE");
        $sheet->setCellValue('G5', "GAJI POKOK");
        $sheet->setCellValue('H5', "JML. HARI HADIR");
        $sheet->setCellValue('I5', "JML. JAM LEMBUR");
        $sheet->setCellValue('J5', "LEMBUR");
        $sheet->setCellValue('K5', "UANG HADIR");
        $sheet->setCellValue('L5', "THR");
        $sheet->setCellValue('M5', "BONUS");
        $sheet->setCellValue('N5', "PPN 21 TERIMA");
        $sheet->setCellValue('O5', "RAPELAN");
        $sheet->setCellValue('P5', "RAPELAN LEMBUR");
        $sheet->setCellValue('Q5', "PESANGON");
        $sheet->setCellValue('R5', "INSENTIF");
        $sheet->setCellValue('S5', "TOTAL TUNJ. TIDAK TETAP");
        $sheet->setCellValue('T5', "POT. BPJS KESEHATAN");
        $sheet->setCellValue('U5', "POT. BP JAMSOSTEK");
        $sheet->setCellValue('V5', "POT. ABSENSI");
        $sheet->setCellValue('W5', "POT PPH 21");
        $sheet->setCellValue('X5', "TOTAL POTONGAN");
        $sheet->setCellValue('Y5', "GRAND TOTAL");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A5')->applyFromArray($style_col);
        $sheet->getStyle('B5')->applyFromArray($style_col);
        $sheet->getStyle('C5')->applyFromArray($style_col);
        $sheet->getStyle('D5')->applyFromArray($style_col);
        $sheet->getStyle('E5')->applyFromArray($style_col);
        $sheet->getStyle('F5')->applyFromArray($style_col);
        $sheet->getStyle('G5')->applyFromArray($style_col);
        $sheet->getStyle('H5')->applyFromArray($style_col);
        $sheet->getStyle('I5')->applyFromArray($style_col);
        $sheet->getStyle('J5')->applyFromArray($style_col);
        $sheet->getStyle('K5')->applyFromArray($style_col);
        $sheet->getStyle('L5')->applyFromArray($style_col);
        $sheet->getStyle('M5')->applyFromArray($style_col);
        $sheet->getStyle('N5')->applyFromArray($style_col);
        $sheet->getStyle('O5')->applyFromArray($style_col);
        $sheet->getStyle('P5')->applyFromArray($style_col);
        $sheet->getStyle('Q5')->applyFromArray($style_col);
        $sheet->getStyle('R5')->applyFromArray($style_col);
        $sheet->getStyle('S5')->applyFromArray($style_col);
        $sheet->getStyle('T5')->applyFromArray($style_col);
        $sheet->getStyle('U5')->applyFromArray($style_col);
        $sheet->getStyle('V5')->applyFromArray($style_col);
        $sheet->getStyle('W5')->applyFromArray($style_col);
        $sheet->getStyle('X5')->applyFromArray($style_col);
        $sheet->getStyle('Y5')->applyFromArray($style_col);
        $catdata = $this->payroll->read_all_data_id_payroll($idpay);
        if (!empty($catdata)) {
            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 6
            foreach ($catdata as $data) { // Lakukan looping pada variabel payroll
                $id_payroll_kary = $data->id_payroll_kary;

                $dtdetail = $this->payroll->read_data_detail_hadir($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $uanghadir = $dtdetail->nilai;
                } else {
                    $uanghadir = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_absen($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $absensi = $dtdetail->nilai;
                } else {
                    $absensi = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_pphtrm($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $pph21trm = $dtdetail->nilai;
                } else {
                    $pph21trm = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_pphptg($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $pph21ptg = $dtdetail->nilai;
                } else {
                    $pph21ptg = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_thr($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $thr = $dtdetail->nilai;
                } else {
                    $thr = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_jkes($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $jkes = $dtdetail->nilai;
                } else {
                    $jkes = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_jstek($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $jsostek = $dtdetail->nilai;
                } else {
                    $jsostek = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_bonus($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $bonus = $dtdetail->nilai;
                } else {
                    $bonus = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_ins($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $insentif = $dtdetail->nilai;
                } else {
                    $insentif = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_rpl($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $rapelan = $dtdetail->nilai;
                } else {
                    $rapelan = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_rpll($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $rapelanlbr = $dtdetail->nilai;
                } else {
                    $rapelanlbr = 0;
                }

                $dtdetail = $this->payroll->read_data_detail_psg($id_payroll_kary);
                if (!empty($dtdetail)) {
                    $pesangon = $dtdetail->nilai;
                } else {
                    $pesangon = 0;
                }

                $ttunj = intval($data->gaji_pokok) + intval($data->total_lembur) + intval($uanghadir) + intval($thr) + intval($bonus) + intval($pph21trm) + intval($rapelan) + intval($rapelanlbr) + intval($pesangon) + intval($insentif);
                $pot = intval($jkes) + intval($jsostek) + intval($absensi) + intval($pph21trm);
                $gtot = intval($ttunj) - intval($pot);

                $sheet->setCellValue('A' . $numrow, $data->id_payroll_kary);
                $sheet->setCellValue('B' . $numrow, $data->no_nik);
                $sheet->setCellValue('C' . $numrow, $data->nama_lengkap);
                $sheet->setCellValue('D' . $numrow, $data->depart);
                $sheet->setCellValue('E' . $numrow, $data->posisi);
                $sheet->setCellValue('F' . $numrow, $data->tipe);
                $sheet->setCellValue('G' . $numrow, $data->gaji_pokok);
                $sheet->setCellValue('H' . $numrow, '0');
                $sheet->setCellValue('I' . $numrow, '0');
                $sheet->setCellValue('J' . $numrow, $data->total_lembur);
                $sheet->setCellValue('K' . $numrow, $uanghadir);
                $sheet->setCellValue('L' . $numrow, $thr);
                $sheet->setCellValue('M' . $numrow, $bonus);
                $sheet->setCellValue('N' . $numrow, $pph21trm);
                $sheet->setCellValue('O' . $numrow, $rapelan);
                $sheet->setCellValue('P' . $numrow, $rapelanlbr);
                $sheet->setCellValue('Q' . $numrow, $pesangon);
                $sheet->setCellValue('R' . $numrow, $insentif);
                $sheet->setCellValue('S' . $numrow, $ttunj);
                $sheet->setCellValue('T' . $numrow, $jkes);
                $sheet->setCellValue('U' . $numrow, $jsostek);
                $sheet->setCellValue('V' . $numrow, $absensi);
                $sheet->setCellValue('W' . $numrow, $pph21ptg);
                $sheet->setCellValue('X' . $numrow, $pot);
                $sheet->setCellValue('Y' . $numrow, $gtot);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('N' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('O' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('P' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('Q' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('R' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('S' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('T' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('U' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('V' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('W' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('X' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('Y' . $numrow)->applyFromArray($style_row);

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
            }

        }

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(30); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(40); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(60); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('I')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('J')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('K')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('L')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('M')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('N')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('O')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('P')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('Q')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('R')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('S')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('T')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('U')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('V')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('W')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('X')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('Y')->setWidth(20); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Data Payroll " . $bth);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="DataPayroll' . $bt . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

}
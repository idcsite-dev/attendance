<?php

$month = array(
    '1' => 'JANUARI', '2' => 'FEBRUARI', '3' => 'MARET', '4' => 'APRIL', '5' => 'MEI', '6' => 'JUNI',
    '7' => 'JULI', '8' => 'AGUSTUS', '9' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOPEMBER', '12' => 'DESEMBER',
);

$bulan = $month[$dt_proll->bulan];
$tahun = $dt_proll->tahun;

?>

<!DOCTYPE html>
<html>

<head>
     <title>SLIP GAJI <?=$bulan ?? ''?> <?=$tahun ?? ''?></title>
     <style>
     @page {
          margin: 0;
     }

     body {
          font-family: "source_sans_proregular", Calibri, Arial, Candara, Segoe, Segoe UI, Optima, sans-serif;
     }

     .container {
          width: 100%;
          padding: 30px 100px 0px 100px;
     }

     .text-center {
          text-align: center;
     }

     .text-small {
          font-size: 35px;
     }

     .row {
          width: 95%;
          display: flex;
          flex-wrap: wrap;
          margin-right: 0px;
          margin-left: 0px;
     }

     .col-lg-2 {
          width: 25%;
          float: left;
     }

     .col-lg-3 {
          width: 25%;
          float: left;
     }

     .col-lg-4 {
          width: 40%;
          float: left;
     }

     .col-lg-5 {
          width: 33%;
          float: left;
     }

     .col-lg-12 {
          width: 100%;
          float: left;
     }

     .col-lg-6 {
          width: 50%;
          float: left;
     }

     .row::after {
          content: "";
          clear: both;
          display: table;
     }

     #tbdetail {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          font-size: 25px;
          width: 98%;
          margin-top: 0px;
          margin-left: 0px;
     }

     #tbdetail td {
          border: 2px dashed black;
          height: 15px;
     }

     #tbdetail td,
     #tbdetail th {
          padding: 5px;
     }

     #tbdetail th {
          border: 2px dashed black;
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          color: black;
     }


     #tbdetailgaji {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          font-size: 30px;
          width: 90%;
          margin-top: 0px;
          margin-left: 0px;
     }

     #tbdetailgaji td {
          border: 0px dashed black;
          height: 5px;
     }

     #tbdetailgaji td,
     #tbdetailgaji th {
          padding: 2px;
     }






     #tbdetailgajidetail {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          font-size: 25px;
          width: 90%;
          margin-top: 0px;
          margin-left: 0px;
     }

     #tbdetailgajidetail td {
          border: 2px dashed black;
          height: 5px;
     }

     #tbdetailgajidetail td,
     #tbdetailgajidetail th {
          padding: 2px;
     }


     #tbketdata {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          font-size: 30px;
          width: 100%;
          margin-top: -20px;
          margin-left: -15px;
     }

     #tbketdata td {
          border: 0px dashed black;
          height: 15px;
     }

     #tbketdata td,
     #tbketdata th {
          padding: 15px;
     }

     #tbketdata th {
          border: 0px dashed black;
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          color: black;
     }



     #tbdetterima {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          font-size: 30px;
          width: 100%;
          margin-top: -20px;
          margin-left: -15px;
     }

     #tbdetterima td {
          border: 0px dashed black;
          height: 15px;
     }

     #tbdetterima td,
     #tbdetterima th {
          padding: 5;
     }

     #tbdetterima th {
          border: 0px dashed black;
          padding-top: 5px;
          padding-bottom: 5px;
          text-align: left;
          color: black;
     }




     #tbdetpotong {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          font-size: 30px;
          width: 100%;
          margin-top: -20px;
          margin-left: -15px;
     }

     #tbdetpotong td {
          border: 0px dashed black;
          height: 15px;
     }

     #tbdetpotong td,
     #tbdetpotong th {
          padding: 15px;
     }

     #tbdetpotong th {
          border: 0px dashed black;
          padding-top: 5px;
          padding-bottom: 5px;
          text-align: left;
          color: black;
     }

     #tbttd {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          font-size: 30px;
          width: 85%;
          margin-top: 50px;
          margin-left: -15px;
     }

     #tbttd td {
          border: 0px dashed black;
          height: 15px;
     }

     #tbttd td,
     #tbttd th {
          padding: 15px;
     }

     #tbttd th {
          border: 0px dashed black;
          padding-top: 5px;
          padding-bottom: 5px;
          text-align: left;
          color: black;
     }
     </style>
</head>

<body>
     <?php

$this->load->helper("terbilang");
$this->load->library('pdf');

foreach ($dt_payroll_kary_all as $lstkyrall) {

    $id_pay = $lstkyrall->id_payroll;
    $id_pay_kary = $lstkyrall->id_payroll_kary;

    $dt_payroll = $this->payroll->read_data_by_id($id_pay, $id_pay_kary);
    $dt_p_lembur = $this->payroll->read_data_lembur_by_id($id_pay_kary, $id_pay);
    $dt_p_detail_terima = $this->payroll->read_data_detail_terima_by_id($id_pay_kary);
    $dt_p_detail_potong = $this->payroll->read_data_detail_potong_by_id($id_pay_kary);
    $sub_terima = $this->payroll->jml_detail_terima($id_pay_kary);
    $sub_potong = $this->payroll->jml_detail_potong($id_pay_kary);
    $jml_hari = count($dt_p_lembur);
    $jml_akhir = fmod($jml_hari, 12);
    if ($jml_akhir == 0) {
        $jml_akhir = 11;
    }

    $tgl_akhir = $dt_payroll->tgl_akhir_lembur;
    $tgl_awal_1 = $dt_payroll->tgl_awal_lembur;
    $tgl_akhir_1 = date('Y-m-d', strtotime('+11 days', strtotime($tgl_awal_1)));
    $tgl_awal_2 = date('Y-m-d', strtotime('+1 days', strtotime($tgl_akhir_1)));
    $tgl_akhir_2 = date('Y-m-d', strtotime('+11 days', strtotime($tgl_awal_2)));
    $tgl_awal_3 = date('Y-m-d', strtotime('+1 days', strtotime($tgl_akhir_2)));
    $tgl_akhir_3 = date('Y-m-d', strtotime('+' . $jml_akhir . ' days', strtotime($tgl_awal_3)));

    if (!empty($dt_payroll)) {
        $terbilang = ucwords(number_to_words($dt_payroll->grand_total)) . ' Rupiah';

        ?>
     <div class="row" style="margin-bottom:20px;">
          <div id="printableArea">
               <div class="container">
                    <div class="row">
                         <div class="col-lg-5" style="text-align:left;">
                              <p style="font-size:35px;font-weight:bold;">PT UNGGUL DINAMIKA UTAMA</p>
                         </div>
                         <div class="col-lg-5" style="text-align:center;">
                              <p style="font-size:35px;font-weight:bold;">DOKUMEN PRIBADI DAN RAHASIA</p>
                         </div>
                         <div class="col-lg-5" style="">
                              <p style="font-size:35px;font-weight:bold;text-align:right;">SLIP GAJI
                                   <?=$bulan . " " . $tahun?>
                              </p>
                         </div>
                    </div>
                    <div class="row" style="margin-top:-50px;">
                         <div class="col-lg-5">
                              <p style="font-size:33px;">Nama : <?=$dt_payroll->nama_lengkap ?? ''?></p>
                              <p style="font-size:33px;margin-top:-30px;">NIK : <?=$dt_payroll->no_nik ?? ''?></p>
                         </div>
                         <div class="col-lg-6">
                              <p style="font-size:33px;">Departemen : <?=$dt_payroll->depart ?? ''?></p>
                              <p style="font-size:33px;margin-top:-30px;">Jabatan : <?=$dt_payroll->posisi ?? ''?></p>
                         </div>
                         <div class="col-lg-5">
                              <p style="font-size:33px;">Martial Status : TK</p>
                              <p style="font-size:33px;margin-top:-30px;">NPWP : <?=$dt_payroll->no_npwp ?? ''?></p>
                         </div>
                    </div>
               </div>
               <div class="container text-small" style="margin-top:-20px;">
                    <table id="tbdetail" class="text-small">
                         <tr>
                              <td style="width:40%;">Tanggal</td>
                              <?php

        $tgl_awal_1 = strtotime($tgl_awal_1 . ' 12:00');
        $tgl_akhir_1 = strtotime($tgl_akhir_1 . ' 12:00');
        $i = "";

        for ($i = $tgl_awal_1; $i <= $tgl_akhir_1; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            echo '<td style="width:40%;text-align:center;">' . date('d-M-Y', strtotime($thisDate)) . '</td>';
        }

        ?>

                         </tr>
                         <tr>
                              <td style="width:40%;">Jam Kerja</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_1; $i <= $tgl_akhir_1; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $jjk = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            echo '<td style="width:40%;text-align:center;">' . $jjk->jml_jam_kerja . '</td>';
        }

        ?>

                         </tr>
                         <tr>
                              <td style="width:40%;">OT. 1</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_1; $i <= $tgl_akhir_1; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ov = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            if ($ov->overtime < 29 && $ov->overtime > 0) {
                $ov1 = 1.5;
            } else {
                $ov1 = 0;
            }

            echo '<td style="width:40%;text-align:center;">' . $ov1 . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">OT. 2</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_1; $i <= $tgl_akhir_1; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ov = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            if ($ov->overtime < 29 && $ov->overtime > 0) {
                $ov1 = $ov->overtime - 1.5;
            } else {
                $ov1 = 0;
            }

            echo '<td style="width:40%;text-align:center;">' . $ov1 . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">OT. Spesial</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_1; $i <= $tgl_akhir_1; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ov = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            if ($ov->overtime >= 29) {
                $ovsp = $ov->overtime;
            } else {
                $ovsp = 0;
            }

            echo '<td style="width:40%;text-align:center;">' . $ovsp . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">Total</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_1; $i <= $tgl_akhir_1; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $stt_lmbr = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);

            echo '<td style="width:40%;text-align:center;">' . number_format($stt_lmbr->subtotal_lembur, 2) . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">Ket.</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_1; $i <= $tgl_akhir_1; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ktkrj = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);

            echo '<td style="width:40%;text-align:center;">' . $ktkrj->kt_ket_kerja . '</td>';
        }

        ?>
                         </tr>
                    </table>

                    <table id="tbdetail" class="text-small" style="margin-top:30px;">
                         <tr>
                              <td style="width:40%;">Tanggal</td>
                              <?php

        $tgl_awal_2 = strtotime($tgl_awal_2 . ' 12:00');
        $tgl_akhir_2 = strtotime($tgl_akhir_2 . ' 12:00');
        $i = "";

        for ($i = $tgl_awal_2; $i <= $tgl_akhir_2; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            echo '<td style="width:40%;text-align:center;">' . date('d-M-Y', strtotime($thisDate)) . '</td>';
        }

        ?>

                         </tr>
                         <tr>
                              <td style="width:40%;">Jam Kerja</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_2; $i <= $tgl_akhir_2; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $jjk = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            echo '<td style="width:40%;text-align:center;">' . $jjk->jml_jam_kerja . '</td>';
        }

        ?>

                         </tr>
                         <tr>
                              <td style="width:40%;">OT. 1</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_2; $i <= $tgl_akhir_2; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ov = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            if ($ov->overtime < 29 && $ov->overtime > 0) {
                $ov1 = $ov->overtime - 6;
            } else {
                $ov1 = 0;
            }

            echo '<td style="width:40%;text-align:center;">' . $ov1 . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">OT. 2</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_2; $i <= $tgl_akhir_2; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ov = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            if ($ov->overtime < 29 && $ov->overtime > 0) {
                $ov1 = $ov->overtime - 1.5;
            } else {
                $ov1 = 0;
            }

            echo '<td style="width:40%;text-align:center;">' . $ov1 . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">OT. Spesial</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_2; $i <= $tgl_akhir_2; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ov = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            if ($ov->overtime >= 29) {
                $ovsp = $ov->overtime;
            } else {
                $ovsp = 0;
            }

            echo '<td style="width:40%;text-align:center;">' . $ovsp . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">Total</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_2; $i <= $tgl_akhir_2; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $stt_lmbr = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);

            echo '<td style="width:40%;text-align:center;">' . number_format($stt_lmbr->subtotal_lembur, 2) . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">Ket.</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_2; $i <= $tgl_akhir_2; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ktkrj = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);

            echo '<td style="width:40%;text-align:center;">' . $ktkrj->kt_ket_kerja . '</td>';
        }

        ?>
                         </tr>
                    </table>




                    <table id="tbdetail" class="text-small" style="margin-top:30px;">
                         <tr>
                              <td style="width:40%;">Tanggal</td>
                              <?php

        $tgl_awal_3 = strtotime($tgl_awal_3 . ' 12:00');
        $tgl_akhir_3 = strtotime($tgl_akhir_3 . ' 12:00');
        $i = "";

        for ($i = $tgl_awal_3; $i <= $tgl_akhir_3; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            echo '<td style="width:40%;text-align:center;">' . date('d-M-Y', strtotime($thisDate)) . '</td>';
        }

        ?>
                              <td rowspan=5 style="width:40%;text-align:center;">TOTAL</td>
                         </tr>
                         <tr>
                              <td style="width:40%;">Jam Kerja</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_3; $i <= $tgl_akhir_3; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $jjk = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            echo '<td style="width:40%;text-align:center;">' . $jjk->jml_jam_kerja . '</td>';
        }

        ?>

                         </tr>
                         <tr>
                              <td style="width:40%;">OT. 1</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_3; $i <= $tgl_akhir_3; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ov = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            if ($ov->overtime < 29 && $ov->overtime > 0) {
                $ov1 = $ov->overtime - 6;
            } else {
                $ov1 = 0;
            }

            echo '<td style="width:40%;text-align:center;">' . $ov1 . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">OT. 2</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_3; $i <= $tgl_akhir_3; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ov = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            if ($ov->overtime < 29 && $ov->overtime > 0) {
                $ov1 = $ov->overtime - 1.5;
            } else {
                $ov1 = 0;
            }

            echo '<td style="width:40%;text-align:center;">' . $ov1 . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">OT. Spesial</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_3; $i <= $tgl_akhir_3; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ov = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);
            if ($ov->overtime >= 29) {
                $ovsp = $ov->overtime;
            } else {
                $ovsp = 0;
            }

            echo '<td style="width:40%;text-align:center;">' . $ovsp . '</td>';
        }

        ?>
                         </tr>
                         <tr>
                              <td style="width:40%;">Total</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_3; $i <= $tgl_akhir_3; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $stt_lmbr = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);

            echo '<td style="width:40%;text-align:center;">' . number_format($stt_lmbr->subtotal_lembur, 2) . '</td>';
        }

        ?>
                              <td style="width:40%;text-align:center;"><?=number_format($dt_payroll->total_lembur)?>
                              </td>
                         </tr>
                         <tr>
                              <td style="width:40%;">Ket.</td>
                              <?php

        $this->load->model('Payroll_model', 'payroll');
        for ($i = $tgl_awal_3; $i <= $tgl_akhir_3; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $ktkrj = $this->payroll->get_lmbr($thisDate, $dt_payroll->id_kary);

            echo '<td style="width:40%;text-align:center;">' . $ktkrj->kt_ket_kerja . '</td>';
        }

        ?>
                              <td style="width:40%;text-align:center;">-</td>
                         </tr>
                    </table>

                    <div style="margin-top:30px;">
                         <div class="col-lg-5">
                              <table id="tbdetailgaji" style="width:75%;">
                                   <tr style="font-weight:bold">
                                        <td style="width:12%;text-align:left;">Gaji Pokok</td>
                                        <td style="width:3%;text-align:left;">Rp.</td>
                                        <td style="width:10%;text-align:right;padding-right:25px;">
                                             <?=number_format($dt_payroll->gaji_pokok)?></td>
                                   </tr>
                                   <tr style="font-weight:bold">
                                        <td style="width:12%;text-align:left;">Lembur</td>
                                        <td style="width:3%;text-align:left;">Rp.</td>
                                        <td style="width:10%;text-align:right;padding-right:25px;">
                                             <?=number_format($dt_payroll->total_lembur)?></td>
                                   </tr>
                                   <tr style="font-weight:bold">
                                        <td colspan=3 style="width:12%;text-align:left;">Tunjangan Tidak Tetap :</td>
                                   </tr>
                                   <?php

        if (!empty($dt_p_detail_terima)) {
            foreach ($dt_p_detail_terima as $lstterima) {
                if ($lstterima->id_tambahan == 6 && $lstterima->nilai > 0) {
                    echo '<tr>';
                    echo '<td style="width:12%;text-align:left;">- ' . $lstterima->ket_tambahan . '</td>';
                    echo '<td style="width:3%;text-align:left;">Rp. </td>';
                    echo '<td style="width:10%;text-align:right;padding-right:25px;">' . number_format($lstterima->nilai) . '</td>';
                    echo '</tr>';
                } else if ($lstterima->id_tambahan != 6) {
                    echo '<tr>';
                    echo '<td style="width:12%;text-align:left;">- ' . $lstterima->ket_tambahan . '</td>';
                    echo '<td style="width:3%;text-align:left;">Rp. </td>';
                    echo '<td style="width:10%;text-align:right;padding-right:25px;">' . number_format($lstterima->nilai) . '</td>';
                    echo '</tr>';
                }
            }
        }

        ?>
                                   <tr>
                                        <td style="width:17%;text-align:left;"></td>
                                        <td style="width:3%;text-align:left;"></td>
                                        <td style="width:10%;text-align:right;">-------------- + </td>
                                   </tr>
                                   <tr style="font-weight:bold">
                                        <td style="width:17%;text-align:left;">Jumlah Pendapatan : </td>
                                        <td style="width:3%;text-align:left;">Rp.</td>
                                        <td style="width:10%;text-align:right;padding-right:25px;">
                                             <?=number_format($dt_payroll->total_penerimaan)?></td>
                                   </tr>
                              </table>
                         </div>
                         <div class="col-lg-5" style="margin-left:-60px;margin-top:80px;">
                              <table id="tbdetailgaji" style="width:75%;">
                                   <tr style="font-weight:bold">
                                        <td colspan=3 style="width:12%;text-align:left;">Potongan :</td>
                                   </tr>
                                   <?php

        if (!empty($dt_p_detail_potong)) {
            foreach ($dt_p_detail_potong as $lstpotong) {
                echo '<tr>';
                echo '<td style="width:12%;text-align:left;">- ' . $lstpotong->ket_tambahan . '</td>';
                echo '<td style="width:3%;text-align:left;">Rp. </td>';
                echo '<td style="width:10%;text-align:right;padding-right:25px;">' . number_format($lstpotong->nilai) . '</td>';
                echo '</tr>';
            }
        }

        ?>
                                   <tr>
                                        <td style="width:17%;text-align:left;"></td>
                                        <td style="width:3%;text-align:left;"></td>
                                        <td style="width:10%;text-align:right;">-------------- + </td>
                                   </tr>
                                   <tr style="font-weight:bold">
                                        <td style="width:12%;text-align:left;">Jumlah Potongan</td>
                                        <td style="width:3%;text-align:left;">Rp.</td>
                                        <td style="width:10%;text-align:right;padding-right:25px;">
                                             <?=number_format($dt_payroll->total_potongan)?></td>
                                   </tr>
                              </table>
                         </div>
                         <div class="col-lg-5 text-center" style="margin-top:-20px;margin-left:-50px;font-weight:bold;">
                              <p>JUMLAH DIBAYAR(Rounded)</p>
                              <p style="margin-top:-25px;">Rp. <?=number_format($dt_payroll->grand_total)?></p>
                              <p> Terbilang :</p>
                              <p style="margin-top:-25px;">
                                   <?=$terbilang?>
                              </p>
                         </div>
                    </div>
               </div>
          </div>
     </div><br>

     <?php

    }
}

?>
</body>

</html>
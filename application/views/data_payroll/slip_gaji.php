<!DOCTYPE html>
<html>

<head>
     <style>
     @page {
          margin: 0;
     }

     body {
          font-family: "source_sans_proregular", Arial, Calibri, Candara, Segoe, Segoe UI, Optima, sans-serif;
     }

     .container {
          width: 100%;
          padding: 200px 200px 200px 200px;
     }

     .text-center {
          text-align: center;
     }

     .text-small {
          font-size: 35px;
     }

     .row {
          display: flex;
          flex-wrap: wrap;
          margin-right: -15px;
          margin-left: -15px;
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

     .col-lg-12 {
          width: 100%;
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
          font-size: 30px;
          width: 85%;
          margin-top: -20px;
          margin-left: -15px;
     }

     #tbdetail td {
          border: 2px dashed black;
          height: 25px;
     }

     #tbdetail td,
     #tbdetail th {
          padding: 20px;
     }

     #tbdetail th {
          border: 2px dashed black;
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          color: black;
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
     <div id="printableArea">
          <div class="container">
               <h5>PT UNGGUL DINAMIKA UTAMA</h5>
               <h5 style="margin-top:-55px;">INDE PROJECT</h5>
               <h5 style="margin-top:-55px;">KALIORANG</h5>
          </div>

          <?php

$month = array(
    '1' => 'JANUARI',
    '2' => 'FEBRUARI',
    '3' => 'MARET',
    '4' => 'APRIL',
    '5' => 'MEI',
    '6' => 'JUNI',
    '7' => 'JULI',
    '8' => 'AGUSTUS',
    '9' => 'SEPTEMBER',
    '10' => 'OKTOBER',
    '11' => 'NOPEMBER',
    '12' => 'DESEMBER',
);

$bulan = $month[$dt_payroll->bulan];
$tahun = $dt_payroll->tahun;

?>
          <div class="text-center" style="margin-top:-200px;">
               <h4>SLIP GAJI <?=$bulan . " " . $tahun?></h4>
          </div>

          <div class="container text-small" style="margin-top:-400px;">
               <div class="row" style="margin-top:-50px;">
                    <div class="col-lg-2">
                         <p>Nama : <?=$dt_payroll->nama_lengkap ?? ''?></p>
                         <p style="margin-top:-30px;">NIK : <?=$dt_payroll->no_nik ?? ''?></p>
                    </div>
                    <div class="col-lg-4">
                         <p>Departemen : <?=$dt_payroll->depart ?? ''?></p>
                         <p style="margin-top:-30px;">Jabatan : <?=$dt_payroll->posisi ?? ''?></p>
                    </div>
                    <div class="col-lg-3">
                         <p>Martial Status : TK</p>
                         <p style="margin-top:-30px;">NPWP : <?=$dt_payroll->no_npwp ?? ''?></p>
                    </div>
               </div>
               <table id="tbdetail" class="text-small">
                    <tr>
                         <th style="width:40%;">Keterangan</th>
                         <th style="width:10%;">Tgl.</th>
                         <th style="width:5%;">Jam Kerja</th>
                         <th style="width:5%;">O.T Reg. 1</th>
                         <th style="width:5%;">O.T Reg. 2</th>
                         <th style="width:5%;">O.T Special</th>
                         <th style="width:10%;">Total lembur</th>
                         <th style="width:15%;">Keterangan</th>
                    </tr>
                    <tr>
                         <td>
                              <table id="tbketdata" class="text-small" style="margin-bottom:50px;margin-top:-120px;">
                                   <tr>
                                        <th style="width:50%;">I. Gaji Pokok :</th>
                                        <th style="width:50%;text-align:right">Rp.
                                             <?=number_format($dt_payroll->gaji_pokok) ?? 'Rp. 0'?>
                                        </th>
                                   </tr>
                                   <tr>
                                        <th style="width:50%;">II. Lembur :</th>
                                        <th style="width:50%;text-align:right">Rp.
                                             <?=number_format($dt_payroll->total_lembur) ?? 'Rp. 0'?></th>
                                   </tr>
                                   <tr>
                                        <th style="width:90%;">III. Tunjangan Tidak Tetap :</th>
                                        <th style="width:10%;text-align:right">
                                        </th>
                                   </tr>
                                   <tr>
                                        <td style="width:50%;">
                                             <?php

if (!empty($dt_p_detail_terima)) {
    echo '<div class="row" style="margin-top:-20px;">';
    echo '<table id="tbdetterima" class="text-small" style="margin-left:50px;">';
    foreach ($dt_p_detail_terima as $lstterima) {
        echo '<tr>';
        echo '<td style="width:50%;">- ' . $lstterima->ket_tambahan . '</td>';
        echo '<td style="width:45%;text-align:right;"> Rp. ' . number_format($lstterima->nilai) . '</td>';
        echo '<td style="width:5%;text-align:right;"></td>';
        echo '</tr>';
    }
    echo '<tr>';
    echo '<td style="width:50%;"></td>';
    echo '<td style="width:45%;text-align:right"> ---------------</td>';
    echo '<td style="width:5%;text-align:right"> + </td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
}

?>

                                        </td>
                                        <td style="width:50%;text-align:right"></td>
                                   </tr>
                                   <tr>
                                        <td style="width:50%;"></td>
                                        <td style="width:50%;text-align:right">Rp.
                                             <?=number_format($sub_terima->sub_terima) ?? ''?>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td style="width:50%;"></td>
                                        <td style="width:50%;text-align:right;">----------------</td>
                                   </tr>
                                   <tr>
                                        <th style="width:50%;">TOTAL PENDAPATAN :</th>
                                        <th style="width:50%;text-align:right;text-decoration: underline;">Rp.
                                             <?=number_format($dt_payroll->total_penerimaan) ?? ''?>
                                        </th>
                                   </tr>
                              </table>

                              <table id="tbketdata" class="text-small">
                                   <tr>
                                        <th style="width:50%;">IV. POTONGAN :</th>
                                        <th style="width:50%;text-align:right"></th>
                                   </tr>
                                   <tr>
                                        <td style="width:90%;">

                                             <?php

if (!empty($dt_p_detail_potong)) {
    echo '<div class="row" style="margin-top:-20px;">';
    echo '<table id="tbdetpotong" class="text-small" style="margin-left:50px;">';
    foreach ($dt_p_detail_potong as $lstpotong) {
        echo '<tr>';
        echo '<td style="width:50%;">- ' . $lstpotong->ket_tambahan . '</td>';
        echo '<td style="width:45%;text-align:right;"> Rp. (' . number_format($lstpotong->nilai) . ')</td>';
        echo '<td style="width:5%;text-align:right;"></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';
}

?>
                                             :</td>
                                        <td style="width:10%;text-align:right"></td>
                                   </tr>
                                   <tr>
                                        <th style="width:50%;">JUMLAH POTONGAN :</th>
                                        <th style="width:50%;text-align:right">Rp.
                                             (<?=number_format($dt_payroll->total_potongan) ?? 'Rp. 0'?>)
                                        </th>
                                   </tr>
                                   <tr>
                                        <th style="width:50%;"></th>
                                        <th style="width:50%;text-align:right">----------------</th>
                                   </tr>
                                   <tr>
                                        <th style="width:50%;">JUMLAH YANG DIBAYAR (ROUNDED) :</th>
                                        <th style="width:50%;text-align:right">Rp.
                                             <?=number_format($dt_payroll->grand_total) ?? 'Rp. 0'?>
                                        </th>
                                   </tr>
                              </table>
                         </td>
                         <td>
                              <?php

if (!empty($dt_p_lembur)) {
    echo '<div class="row">';
    foreach ($dt_p_lembur as $lstlembur) {
        echo '<div style="padding-left:5px;margin-bottom:10px;text-align:center">' . date('d-M-Y', strtotime($lstlembur->tgl_lembur)) . '</div>';
    }
    echo '</div>';
}

?>
                         </td>
                         <td>
                              <?php

if (!empty($dt_p_lembur)) {
    echo '<div class="row">';
    foreach ($dt_p_lembur as $lstlembur) {
        echo '<div style="padding-left:5px;margin-bottom:10px;text-align:right">' . $lstlembur->jml_jam_kerja . '</div>';
    }
    echo '</div>';
}

?>
                         </td>
                         <td>

                              <?php

if (!empty($dt_p_lembur)) {
    echo '<div class="row">';
    foreach ($dt_p_lembur as $lstlembur) {
        echo '<div style="padding-left:5px;margin-bottom:10px;text-align:right">' . ($lstlembur->overtime < 29 && $lstlembur->overtime > 0 ? $lstlembur->overtime - 6 : 0) . '</div>';
    }
    echo '</div>';
}

?>

                         </td>
                         <td>

                              <?php

if (!empty($dt_p_lembur)) {
    echo '<div class="row">';
    foreach ($dt_p_lembur as $lstlembur) {
        echo '<div style="padding-left:5px;margin-bottom:10px;text-align:right">' . ($lstlembur->overtime < 29 && $lstlembur->overtime > 0 ? $lstlembur->overtime - 1.5 : 0) . '</div>';
    }
    echo '</div>';
}

?>

                         </td>
                         <td>

                              <?php

if (!empty($dt_p_lembur)) {
    echo '<div class="row">';
    foreach ($dt_p_lembur as $lstlembur) {
        if ($lstlembur->id_ket_kerja == 26 || $lstlembur->id_ket_kerja == 27 || $lstlembur->id_ket_kerja == 28) {
            if ($lstlembur->overtime > 0) {
                echo '<div style="padding-left:5px;margin-bottom:10px;text-align:right"> 29 </div>';
            } else {
                echo '<div style="padding-left:5px;margin-bottom:10px;text-align:right"> 0 </div>';
            }
        } else {
            echo '<div style="padding-left:5px;margin-bottom:10px;text-align:right"> 0 </div>';
        }
    }
    echo '</div>';
}

?>

                         </td>
                         <td>

                              <?php

if (!empty($dt_p_lembur)) {
    echo '<div class="row">';
    foreach ($dt_p_lembur as $lstlembur) {
        echo '<div style="padding-left:5px;margin-bottom:10px;text-align:right">' . number_format($lstlembur->subtotal_lembur, 2) . '</div>';
    }
    echo '</div>';
}

?>

                         </td>
                         <td>
                              <?php

if (!empty($dt_p_lembur)) {
    echo '<div class="row">';
    foreach ($dt_p_lembur as $lstlembur) {
        echo '<div style="padding-left:20px;margin-bottom:10px;">' . $lstlembur->kt_ket_kerja . '</div>';
    }
    echo '</div>';
}

?>
                         </td>
                    </tr>
                    <tr>
                         <th colspan=6> TOTAL : </th>
                         <th style="text-align:right"><?=number_format($dt_payroll->total_lembur) ?? 'Rp. 0'?></th>
                         <th></th>
                    </tr>
                    <tr>
                         <td colspan=8> Terbilang : <?=$terbilang?></td>
                    </tr>
               </table>


               <table id="tbttd">
                    <tr>
                         <th style="width:33%;text-align:center;">PREPARED BY :</th>
                         <th style="width:33%;text-align:center;">APPROVED BY : </th>
                         <th style="width:33%;text-align:center;"> RECIEVED BY :</th>
                    </tr>
                    <tr>
                         <th style="width:33%;height:300px;text-align:center;">---------------------</th>
                         <th style="width:33%;height:300px;text-align:center;">---------------------</th>
                         <th style="width:33%;height:300px;text-align:center;">---------------------</th>
                    </tr>
               </table>
          </div>
     </div>
</body>

</html>
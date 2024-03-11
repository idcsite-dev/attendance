<!-- Table with outer spacing -->
<div class="row">
     <div class="col-lg-3">
          <div class="form-group">
               <label for="lstBulanTampilTs">Bulan</label>
               <select class="form-control" id="lstBulanTampilTs" name="lstBulanTampilTs">
                    <option value="">-- PILIH BULAN --
                    </option>
                    <option value="12|2023">DESEMBER 2023
                    </option>
                    <option value="1|2024">JANUARI 2024
                    </option>
                    <option value="2|2024">FEBRUARI
                         2024</option>
                    <option value="3|2024">MARET 2024
                    </option>
                    <option value="4|2024">APRIL 2024
                    </option>
                    <option value="5|2024">MEI 2024
                    </option>
                    <option value="6|2024">JUNI 2024
                    </option>
                    <option value="7|2024">JULI 2024
                    </option>
                    <option value="8|2024">AGUSTUS 2024
                    </option>
                    <option value="9|2024">SEPTEMBER
                         2024</option>
                    <option value="10|2024">OKTOBER
                         2024</option>
                    <option value="11|2024">NOPEMBER
                         2024</option>
                    <option value="112|2024">DESEMBER
                         2024</option>
               </select>
          </div>
     </div>
     <div class="col-lg-4 mt-4">
          <button class="btn btn-success" id="btnTampilTs" name="btnTampilTs">
               Tampilkan Data</button>
          <button class="btn btn-warning" id="btnExpDtTs" name="btnExpTs">
               Export Data</button>
     </div>
</div>
<div class="table-responsive">
     <table id="tbTimesheet" class="table table-bordered table-hover" style="width:102%">
          <thead>
               <tr>
                    <th style="width:1%;">No.</th>
                    <th style="width:10%;">NRP</th>
                    <th style="width:20%;">Nama</th>
                    <th style="width:30%;">Departemen</th>
                    <th style="width:30%;">Jabatan</th>
                    <th style="width:9%;">Shift</th>
                    <?php
if (!empty($dt_ts)) {
    $bln = sprintf("%02d", $bln);
    $tgl_start = $tahun . "-" . $bln . "-01";
    $total_tgl = date('t', strtotime($tgl_start));
    $tgl_akhir = $tahun . "-" . $bln . "-" . $total_tgl;
    $tgl_start = strtotime($tgl_start . ' 12:00');
    $tgl_akhir = strtotime($tgl_akhir . ' 12:00');
    $i = 1;
    for ($i = $tgl_start; $i <= $tgl_akhir; $i = $i + 86400) {
        $thisDate = date('Y-m-d', $i);
        echo '<th class="text-center text-nowrap" style="width:5%;">' . $thisDate . '</th>';
    }
}
?>
               </tr>
          </thead>
          <tbody>
               <?php

if (!empty($dt_ts)) {
    $n = 1;
    foreach ($dt_ts as $list) {
        $i = 1;
        echo '<tr>';
        echo '<td class="text-center text-nowrap" style="width:1%;">' . $n++ . '</td>';
        echo '<td class="text-nowrap" style="width:10%;">' . $list['no_nik'] . '</td>';
        echo '<td class="text-nowrap" style="width:20%;">' . $list['nama_lengkap'] . '</td>';
        echo '<td class="text-nowrap" style="width:25%;">' . $list['depart'] . '</td>';
        echo '<td class="text-nowrap" style="width:20%;">' . $list['posisi'] . '</td>';
        echo '<td class="text-nowrap" style="width:5%;">' . $list['tipe'] . '</td>';
        for ($i = 1; $i <= $total_tgl; $i++) {
            $tb = 't' . $i;
            echo '<td class="text-center text-nowrap" style="width:5%;">' . $list[$tb] . '</td>';
        }
        echo '</tr>';
    }
}

?>
          </tbody>
     </table>
</div>

<script>
$("#tbTimesheet").DataTable({
     paging: false,
     scrollCollapse: true,
     scrollX: true,
     scrollY: 500
});

initTooltips();

$("#btnTampilTs").click(function() {
     let bln = $("#lstBulanTampilTs").val();
     if (bln == "") {
          alert("Bulan wajib dipilih");
     } else {
          $("#tbTimesheet").LoadingOverlay("show");
          $("#tbmTimesheet").load(site_url + "timesheet/tb_timesheet?q=" + bln, function() {
               $("#tbTimesheet").DataTable()
               $("#tbTimesheet").LoadingOverlay("hide");
          });
     }
});
</script>
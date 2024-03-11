<div class="table-responsive mt-3">
     <table id="tblPayrollKary" class="table table-striped table-bordered table-hover" style="width:100%;">
          <thead>
               <tr>
                    <th>No.</th>
                    <th>NIK</th>
                    <th>Nama Karyawan</th>
                    <th>Departemen</th>
                    <th>Posisi</th>
                    <th>Tipe</th>
                    <th>Total Gaji</th>
                    <th>Aksi</th>
               </tr>
          </thead>
          <tbody>
               <?php

$this->load->model("Payroll_model", 'payroll');

if (!empty($dtprolkary)) {
    $n = 1;
    foreach ($dtprolkary as $list) {
        $id_payroll_kary = $list->id_payroll_kary;

        echo '<tr>';
        echo '<td class=" text-center align-middle text-nowrap" style="width:1%;">' . $n++ . '</td>';
        echo '<td class="align-middle text-nowrap" style="width:10%;">' . $list->no_nik . '</td>';
        echo '<td class="align-middle" style="width:15%;">' . $list->nama_lengkap . '</td>';
        echo '<td class="align-middle" style="width:25%;">' . $list->depart . '</td>';
        echo '<td class="align-middle" style="width:25%;">' . $list->posisi . '</td>';
        echo '<td class="align-middle text-nowrap" style="width:25%;">' . $list->tipe . '</td>';
        echo '<td class="text-end align-middle text-nowrap" style="width:15%;">Rp. ' . number_format($list->grand_total) . '</td>';
        echo '<td class="text-center align-middle text-nowrap" style="width:4%;">';
        echo ' <button id="' . $list->id_payroll_kary . '" class="btn btn-primary font-bold dtlkarygaji" title="Detail Gaji Karyawan"><i class="bi bi-info-circle"></i></button> ';
        echo ' <a href="' . base_url('data_payroll/cetak_slip?q=' . $list->id_payroll_kary . '&q1=' . $list->id_payroll) . '" target="_blank" class="btn btn-warning font-bold " title="Cetak Slip Gaji"><i class="bi bi-printer"></i></a> ';
        echo ' <button id="' . $list->id_payroll_kary . '" class="btn btn-success font-bold htggajikary" value="' . $list->no_nik . " | " . $list->nama_lengkap . '" title="Hitung Ulang Gaji"><i class="bi bi-card-checklist"></i></button> ';
        echo '</td>';
        echo '</tr>';
    }
}

?>
          </tbody>
     </table>
</div>

<script>
$("#tblPayrollKary").DataTable({
     lengthMenu: [5, 10, 20, 50, 100, 200, 500],
});

$.LoadingOverlay("hide");
</script>
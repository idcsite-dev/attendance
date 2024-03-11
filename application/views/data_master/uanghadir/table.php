<?php
function formatCurrency($amount)
{
    // Format the amount with the currency symbol and thousand separators
    $formattedAmount = 'Rp. ' . number_format($amount, 2, '.', ',');
    return $formattedAmount;
}
?>
<table class="table" id="table1">
     <thead>
          <tr>
               <th class="text-center align-middle">No.</th>
               <th class="align-middle">Bulan</th>
               <th class="align-middle">Tahun</th>
               <th class="align-middle">NIK</th>
               <th class="align-middle">Nama Karyawan</th>
               <th class="align-middle">Departemen</th>
               <th class="align-middle">Uang hadir</th>
               <th class="text-center align-middle">Aksi</th>
          </tr>
     </thead>
     <tbody>
          <?php

if (!empty($inst)) {
    $n = 1;
    foreach ($inst as $data) {?>
          <?php

        $dta = ['1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni',
            '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'Nopember', '12' => 'Desember'];

        $bln = $dta[$data->bulan];

        ?>
          <tr>
               <td class="text-center align-middle text-nowrap"><?=$n++ . '.'?></td>
               <td class="align-middle text-nowrap"><?=$bln?></td>
               <td class="align-middle text-nowrap"><?=$data->tahun?></td>
               <td class="align-middle text-nowrap"><?=$data->no_nik?></td>
               <td class="align-middle"><?=$data->nama_lengkap?></td>
               <td class="align-middle"><?=$data->depart?></td>
               <td class="align-middle text-nowrap"><?=formatCurrency($data->nilai)?></td>
               <td class="text-center align-middle text-nowrap">
                    <button type="button" id="<?=$data->id_payroll_detail?>"
                         class="btn btn-sm btn-danger font-bold tooltips deleteData" data-bs-placement="top"
                         title="Hapus Data"><i class="bi bi-trash"></i></button>
               </td>
          </tr>
          <?php }}?>
     </tbody>
</table>
<script>
$("#table1").DataTable();
</script>
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
               <th class="align-middle">Kode</th>
               <th class="align-middle">Tipe</th>
               <th class="align-middle">Ip Address</th>
               <th class="align-middle">Port</th>
               <th class="align-middle">Stat. Download</th>
               <th class="align-middle">Lokasi</th>
               <th class="text-center align-middle">Aksi</th>
          </tr>
     </thead>
     <tbody>
          <?php

if (!empty($mesin)) {
    $n = 1;
    foreach ($mesin as $data) {?>
          <tr>
               <td class="text-center align-middle text-nowrap"><?=$n++ . '.'?></td>
               <td class="align-middle text-nowrap"><?=$data->kd_mesin?></td>
               <td class="align-middle text-nowrap"><?=$data->tipe_mesin?></td>
               <td class="align-middle text-nowrap"><?=$data->ip_mesin?></td>
               <td class="align-middle"><?=$data->port_mesin?></td>
               <td class="align-middle"><?=$data->status_tarik?></td>
               <td class="align-middle"><?=$data->lokasi_mesin?></td>
               <td class="text-center align-middle text-nowrap">
                    <button type="button" id="<?=$data->id_mesin?>"
                         class="btn btn-sm btn-success font-bold tooltips editData" data-bs-placement="top"
                         title="Edit Data"><i class="bi bi-pencil-square"></i></button>
                    <button type="button" id="<?=$data->id_mesin?>"
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
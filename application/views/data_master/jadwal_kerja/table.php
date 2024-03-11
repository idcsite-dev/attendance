<table class="table" id="table1">
     <thead>
          <tr>
               <th class="text-center align-middle">No.</th>
               <th class="align-middle">Kode</th>
               <th class="align-middle">Jadwal Kerja</th>
               <th class="align-middle">Jam Masuk</th>
               <th class="align-middle">Jam Pulang</th>
               <th class="align-middle">Toleransi</th>
               <th class="text-center align-middle">Aksi</th>
          </tr>
     </thead>
     <tbody>
          <?php

if (!empty($jadwal_kerja)) {
    $n = 1;
    foreach ($jadwal_kerja as $data) {?>
          <tr>
               <td class="text-center align-middle text-nowrap"><?=$n++ . '.'?></td>
               <td class="align-middle text-nowrap"><?=$data['kode_jadwal_kerja']?></td>
               <td class="align-middle text-nowrap"><?=$data['jadwal_kerja']?></td>
               <td class="align-middle text-nowrap"><?=$data['jam_masuk']?></td>
               <td class="align-middle text-nowrap"><?=$data['jam_pulang']?></td>
               <td class="align-middle text-nowrap"><?=$data['waktu_toleransi'] . ' Menit'?></td>
               <td class="text-center align-middle text-nowrap">
                    <button type="button" id="<?=$data['id_jadwal_kerja']?>"
                         class="btn btn-sm btn-success font-bold tooltips updateData" data-bs-placement="top"
                         title="Edit Data"><i class="bi bi-pencil-square"></i></button>
                    <button type="button" id="<?=$data['id_jadwal_kerja']?>"
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
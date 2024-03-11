<table class="table" id="table1">
     <thead>
          <tr>
               <th class="text-center align-middle">No.</th>
               <th class="align-middle">Jam Download</th>
               <th class="text-center align-middle">Aksi</th>
          </tr>
     </thead>
     <tbody>
          <?php
if (!empty($jadwal)) {
    $n = 1;
    foreach ($jadwal as $data) {?>
          <tr>
               <td class="text-center align-middle text-nowrap" Style="width:10%;"><?=$n++ . '.'?></td>
               <td class="align-middle text-nowrap" Style="width:70%;"><?=$data['jadwal_download']?></td>
               <td class="text-center align-middle text-nowrap" Style="width:20%;">
                    <button type="button" id="<?=$data['id_jadwal_download']?>"
                         class="btn btn-warning font-bold tooltips updateData" data-bs-placement="top"
                         title="Edit Data"><i class="bi bi-pencil-square"></i></button>
                    <button type="button" id="<?=$data['id_jadwal_download']?>"
                         class="btn btn-danger font-bold tooltips deleteData" data-bs-placement="top"
                         title="Hapus Data"><i class="bi bi-trash"></i></button>
               </td>
          </tr>
          <?php }}?>
     </tbody>
</table>
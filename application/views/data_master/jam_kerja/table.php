<div class="row">
     <div class="col-lg-12">
          
     </div>
</div>
<table class="table" id="table1">
     <thead>
          <tr>
               <th class="text-center align-middle">No.</th>
               <th class="align-middle">NIK</th>
               <th class="align-middle">Nama Karyawan</th>
               <th class="align-middle">Depart</th>
               <th class="align-middle">Posisi</th>
               <th class="align-middle">Jam Kerja</th>
               <th class="align-middle">Lokasi Mesin</th>
          </tr>
     </thead>
     <tbody>
          <?php
if (!empty($att)) {
    $n = 1;
    foreach ($att as $data) {?>
          <tr>
               <td class="text-center align-middle text-nowrap"><?=$n++ . '.'?></td>
               <td class="align-middle text-nowrap"><?=$data['no_nik']?></td>
               <td class="align-middle "><?=$data['nama_lengkap']?></td>
               <td class="align-middle "><?=$data['depart']?></td>
               <td class="align-middle "><?=$data['posisi']?></td>
               <td class="align-middle text-nowrap"><?=$data['tgl_jam_att']?></td>
               <td class="align-middle text-nowrap"><?=$data['lokasi_mesin']?></td>
          </tr>
          <?php }}?>
     </tbody>
</table>
<!-- Modal Tambah Data -->
<div class="modal fade modal-borderless" id="modalAdd" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="exampleModalScrollableTitle">
                         Tambah Data Jadwal Kerja
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="addjadwal_kerja" method="POST" data-parsley-validate>
                         <div class="row">
                              <div class="col-lg-4">
                                   <div class="form-group">
                                        <label for="kodeJadwalKerja" class="form-label">Kode</label>
                                        <input id="kodeJadwalKerja" type="text" class="form-control"
                                             placeholder="Kode Jadwal Kerja" />
                                   </div>
                              </div>
                              <div class="col-lg-8">
                                   <div class="form-group">
                                        <label for="jadwalKerja" class="form-label">Jadwal Kerja</label>
                                        <input id="jadwalKerja" type="text" class="form-control"
                                             placeholder="Jadwal Kerja" />
                                   </div>
                              </div>
                              <div class="col-lg-3">
                                   <div class="form-group">
                                        <label for="jamMasuk" class="form-label">Jam Masuk</label>
                                        <input id="jamMasuk" type="text" class="form-control" placeholder="Jam Masuk" />
                                   </div>
                              </div>
                              <div class="col-lg-3">
                                   <div class="form-group">
                                        <label for="jamPulang" class="form-label">Jam Pulang</label>
                                        <input id="jamPulang" type="text" class="form-control"
                                             placeholder="Jam Pulang" />
                                   </div>
                              </div>
                              <div class="col-lg-6">
                                   <div class="form-group">
                                        <label for="waktuToleransi" class="form-label">Waktu Toleransi (Menit)</label>
                                        <input id="waktuToleransi" type="number" class="form-control"
                                             placeholder="Waktu Toleransi" />
                                   </div>
                              </div>
                         </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                         <span class="d-none d-sm-block">Kembali</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1">
                         <span class="d-none d-sm-block">Simpan</span>
                    </button>
                    </form>
               </div>
          </div>
     </div>
</div>

<!-- Modal Update/Edit Data -->
<div class="modal fade modal-borderless text-left" id="modalUpdate" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel160" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-warning">
                    <h5 class="modal-title white" id="myModalLabel160">
                         Edit Data Jadwal Kerja
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="updateJadwalKerja" method="POST" data-parsley-validate>
                         <input id="updateId" type="text" class="form-control" hidden />
                         <div class="row">
                              <div class="col-lg-4">
                                   <div class="form-group">
                                        <label for="kodeJadwalKerjaEdit" class="form-label">Kode</label>
                                        <input id="kodeJadwalKerjaEdit" type="text" class="form-control"
                                             placeholder="Kode Jadwal Kerja" />
                                   </div>
                              </div>
                              <div class="col-lg-8">
                                   <div class="form-group">
                                        <label for="jadwalKerjaEdit" class="form-label">Jadwal Kerja</label>
                                        <input id="jadwalKerjaEdit" type="text" class="form-control"
                                             placeholder="Jadwal Kerja" />
                                   </div>
                              </div>
                              <div class="col-lg-3">
                                   <div class="form-group">
                                        <label for="jamMasukEdit" class="form-label">Jam Masuk</label>
                                        <input id="jamMasukEdit" type="text" class="form-control"
                                             placeholder="Jam Masuk" />
                                   </div>
                              </div>
                              <div class="col-lg-3">
                                   <div class="form-group">
                                        <label for="jamPulangEdit" class="form-label">Jam Pulang</label>
                                        <input id="jamPulangEdit" type="text" class="form-control"
                                             placeholder="Jam Pulang" />
                                   </div>
                              </div>
                              <div class="col-lg-6">
                                   <div class="form-group">
                                        <label for="waktuToleransiEdit" class="form-label">Waktu Toleransi
                                             (Menit)</label>
                                        <input id="waktuToleransiEdit" type="number" class="form-control"
                                             placeholder="Waktu Toleransi" />
                                   </div>
                              </div>
                         </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                         <span class="d-none d-sm-block">Kembali</span>
                    </button>
                    <button type="submit" class="btn btn-warning ms-1">
                         <span class="d-none d-sm-block">Simpan</span>
                    </button>
                    </form>
               </div>
          </div>
     </div>
</div>

<!-- Modal Detail Data -->
<div class="modal fade modal-borderless text-left" id="modalDetail" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel160" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-success">
                    <h5 class="modal-title white" id="myModalLabel160">
                         Detail Data jadwal_kerja
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <div class="form-group">
                         <label for="detailNama" class="form-label">Nama User</label>
                         <input id="detailNama" type="text" class="form-control" placeholder="Nama User" readonly />
                    </div>
                    <div class="form-group">
                         <label for="detailNIK" class="form-label">NIK</label>
                         <input id="detailNIK" type="text" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                         <label for="detailDepartemen" class="form-label">Departemen</label>
                         <input id="detailDepartemen" type="text" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                         <label for="detailPosisi" class="form-label">Posisi</label>
                         <input id="detailPosisi" type="text" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                         <label for="detailNPWP" class="form-label">No NPWP</label>
                         <input id="detailNPWP" type="text" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                         <label for="detailjadwal_kerja" class="form-label">Jadwal Kerja</label>
                         <input id="detailjadwal_kerja" type="text" class="form-control" readonly />
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                         <span class="d-none d-sm-block">Tutup</span>
                    </button>
               </div>
          </div>
     </div>
</div>

// export template pph
<div class="modal fade modal-borderless" id="modalExport" tabindex="-1" role="dialog"
     aria-labelledby="titleModalImportjadwal_kerja" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="titleModalImportjadwal_kerja">
                         Export Data Jadwal Kerja
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <div class="row">
                         <div class="col-lg-6 form-group mandatory">
                              <select name="lstBulan" id="lstBulan" class="form-control">
                                   <?php
$n = 1;
$data = ['1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni',
    '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'Nopember', '12' => 'Desember'];

for ($n >= 1; $n <= 12; $n++) {
    $now = intval(date('m'));
    $bulan = $data[$n];

    if ($now == $bulan) {
        $stt = "selected";
    } else {
        $stt = "";
    }

    echo '<option value=' . $n . ' "' . $stt . '" >' . $bulan . '</option>';
}

?>
                              </select>
                         </div>
                         <div class="col-lg-6 form-group mandatory">
                              <select name="lstTahun" id="lstTahun" class="form-control">
                                   <?php

$y = 2024;
for ($y >= 2024; $y <= 2040; $y++) {
    $now = intval(date('Y'));
    if ($now == $y) {
        $stt = "selected";
    } else {
        $stt = "";
    }

    echo '<option value=' . $y . ' "' . $stt . '" >' . $y . '</option>';
}

?>
                              </select>
                         </div>
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                         <span class="d-none d-sm-block">Kembali</span>
                    </button>
                    <button type="button" class="btn btn-primary ms-1" id="exportjadwal_kerja">
                         <span class="d-none d-sm-block">Export Template</span>
                    </button>
                    </form>
               </div>
          </div>
     </div>
</div>

// hapus pph
<div class="modal fade modal-borderless" id="modalHapus" tabindex="-1" role="dialog"
     aria-labelledby="titleModalHapusjadwal_kerja" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="titleModalHapusjadwal_kerja">
                         Hapus Data Jadwal Kerja
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <div class="row">
                         <div class="col-lg-6 form-group mandatory">
                              <select name="lstBulanHapus" id="lstBulanHapus" class="form-control">
                                   <?php
$n = 1;
$data = ['1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni',
    '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'Nopember', '12' => 'Desember'];

for ($n >= 1; $n <= 12; $n++) {
    $now = intval(date('m'));
    $bulan = $data[$n];

    if ($now == $bulan) {
        $stt = "selected";
    } else {
        $stt = "";
    }

    echo '<option value=' . $n . ' "' . $stt . '" >' . $bulan . '</option>';
}

?>
                              </select>
                         </div>
                         <div class="col-lg-6 form-group mandatory">
                              <select name="lstTahunHapus" id="lstTahunHapus" class="form-control">
                                   <?php

$y = 2024;
for ($y >= 2024; $y <= 2040; $y++) {
    $now = intval(date('Y'));
    if ($now == $y) {
        $stt = "selected";
    } else {
        $stt = "";
    }

    echo '<option value=' . $y . ' "' . $stt . '" >' . $y . '</option>';
}

?>
                              </select>
                         </div>
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                         <span class="d-none d-sm-block">Kembali</span>
                    </button>
                    <button type="button" class="btn btn-primary ms-1" id="Hapusjadwal_kerja">
                         <span class="d-none d-sm-block">Hapus Jadwal Kerja</span>
                    </button>
                    </form>
               </div>
          </div>
     </div>
</div>
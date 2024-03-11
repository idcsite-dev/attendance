<!-- Modal Import Data -->
<div class="modal fade modal-borderless" id="modalImport" tabindex="-1" role="dialog"
     aria-labelledby="titleModalImportRapelanLbr" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="titleModalImportRapelanLbr">
                         Import Data Rapelan Lembur
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="importRapelanLbr" method="POST" data-parsley-validate>
                         <div class="form-group mandatory">
                              <label for="importFile" class="form-label">File Rapelan Lembur</label>
                              <input id="importFile" type="file" accept=".xlsx" class="form-control"
                                   aria-describedby="fileHelp" required />
                              <div id="fileHelp" class="form-text text-danger"><b>*Upload File Rapelan Lembur harus
                                        dalam
                                        format pdf
                                        dengan ukuran maksimal 500 kb*</b></div>
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

<!-- Modal Tambah Data -->
<div class="modal fade modal-borderless" id="modalAdd" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="exampleModalScrollableTitle">
                         Tambah Data Rapelan Lembur
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="addRapelanLbr" method="POST" data-parsley-validate>
                         <div class="form-group mandatory">
                              <label for="searchKaryawan" class="form-label">Cari Karyawan</label>
                              <input id="searchKaryawan" type="text" class="form-control"
                                   placeholder="Masukkan NIK/Nama Karyawan" />
                         </div>
                         <div class="form-group">
                              <label for="nama" class="form-label">Nama Karyawan</label>
                              <input id="nama" type="text" class="form-control" placeholder="Nama Karyawan" readonly />
                              <input type="text" id="karyawan" hidden>
                         </div>
                         <div class="row">
                              <div class="col-lg-6 form-group mandatory">
                                   <label for="lstBulanInst" class="form-label">Bulan</label>
                                   <select name="lstBulanInst" id="lstBulanInst" class="form-control">
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
                                   <label for="lstTahunInst" class="form-label">Tahun</label>
                                   <select name="lstTahunInst" id="lstTahunInst" class="form-control">
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
                         <div class="form-group mandatory">
                              <label for="txtrapelanlbr" class="form-label">Rapelan Lembur</label>
                              <input id="txtrapelanlbr" type="text" class="form-control"
                                   placeholder="Nominal Rapelan Lembur" required />
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
                         Edit Data Rapelan Lembur
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="updateRapelanLbr" method="POST" data-parsley-validate>
                         <input id="updateId" type="text" class="form-control" hidden />
                         <div class="form-group mandatory">
                              <label for="updateRapelanLbrPokok" class="form-label">Rapelan Lembur</label>
                              <input id="updateRapelanLbrPokok" type="text" class="form-control"
                                   placeholder="Nominal RapelanLbr" required />
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
                         Detail Data Rapelan Lembur
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
                         <label for="detailRapelanLbr" class="form-label">Rapelan Lembur</label>
                         <input id="detailRapelanLbr" type="text" class="form-control" readonly />
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

// export template rapelanlbr
<div class="modal fade modal-borderless" id="modalExport" tabindex="-1" role="dialog"
     aria-labelledby="titleModalImportRapelanLbr" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="titleModalImportRapelanLbr">
                         Export Data Rapelan Lembur
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
                    <button type="button" class="btn btn-primary ms-1" id="exportRapelanLbr">
                         <span class="d-none d-sm-block">Export Template</span>
                    </button>
                    </form>
               </div>
          </div>
     </div>
</div>

// hapus rapelanlbr
<div class="modal fade modal-borderless" id="modalHapus" tabindex="-1" role="dialog"
     aria-labelledby="titleModalHapusRapelanLbr" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="titleModalHapusRapelanLbr">
                         Hapus Data Rapelan Lembur
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
                    <button type="button" class="btn btn-primary ms-1" id="HapusRapelanLbr">
                         <span class="d-none d-sm-block">Hapus Rapelan Lembur</span>
                    </button>
                    </form>
               </div>
          </div>
     </div>
</div>
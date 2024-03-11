<!-- Modal Import Data -->
<div class="modal fade modal-borderless" id="modalImport" tabindex="-1" role="dialog"
     aria-labelledby="titleModalImportMesin" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="titleModalImportMesin">
                         Import Data Mesin
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="importMesin" method="POST" data-parsley-validate>
                         <div class="form-group mandatory">
                              <label for="importFile" class="form-label">File Mesin</label>
                              <input id="importFile" type="file" accept=".xlsx" class="form-control"
                                   aria-describedby="fileHelp" required />
                              <div id="fileHelp" class="form-text text-danger"><b>*Upload File Mesin harus dalam
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
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document"
          style="max-width:40%;">
          <div class="modal-content">
               <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="exampleModalScrollableTitle">
                         Tambah Data Mesin
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form autocomplete="off" action="javascript:void(0)" id="addMesin" method="POST"
                         data-parsley-validate>
                         <div class="row">
                              <div class="col-lg-6">
                                   <div class="form-group">
                                        <label for="kodemesin" class="form-label">Kode Mesin</label>
                                        <input id="kodemesin" autocomplete="false" spellcheck="off" type="text"
                                             class="form-control" placeholder="Kode Mesin" autocomplete="off">
                                   </div>
                              </div>
                              <div class="col-lg-6">
                                   <div class="form-group">
                                        <label for="tipemesin" class="form-label">Tipe Mesin</label>
                                        <input id="tipemesin" type="text" class="form-control" placeholder="Tipe Mesin"
                                             autocomplete="off">
                                   </div>
                              </div>
                              <div class="col-lg-12">
                                   <div class="form-group">
                                        <label for="lokasimesin" class="form-label">Lokasi Mesin</label>
                                        <select id="lokasimesin" type="text" class="form-control"
                                             placeholder="Status Download">
                                             <option value="">-- PILIH LOKASI --</option>
                                             <option value="OFFICE PIT 27">OFFICE PIT 27</option>
                                             <option value="OFFICE KM 14">OFFICE KM 14</option>
                                             <option value="WORKSHOP 27 INDOOR">WORKSHOP 27 INDOOR</option>
                                             <option value="WORKSHOP 27 TERAS">WORKSHOP 27 TERAS</option>
                                             <option value="WAREHOUSE 2">WAREHOUSE 2</option>
                                             <option value="Tempodo 6">Tempodo 6</option>
                                        </select>
                                   </div>
                              </div>
                              <div class="col-lg-4">
                                   <div class="form-group">
                                        <label for="ipaddress" class="form-label">IP Address</label>
                                        <input class="form-control" data-inputmask="'alias': 'ip'" name="ipaddress"
                                             id="ipaddress" value="" autocomplete="off">

                                   </div>
                              </div>
                              <div class="col-lg-3">
                                   <div class="form-group">
                                        <label for="port" class="form-label">Port</label>
                                        <input id="port" type="number" class="form-control" autocomplete="off">
                                   </div>
                              </div>
                              <div class="col-lg-5">
                                   <div class="form-group">
                                        <label for="stat_download" class="form-label">Status Download</label>
                                        <select id="stat_download" type="text" class="form-control"
                                             placeholder="Status Download">
                                             <option value="">-- PILIH STATUS --</option>
                                             <option value="AUTO">AUTO</option>
                                             <option value="MANUAL">MANUAL</option>
                                        </select>
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
                         Edit Data Mesin
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="updateMesin" method="POST" data-parsley-validate>
                         <div class="row">
                              <div class="col-lg-6">
                                   <div class="form-group">
                                        <label for="kodemesinEdit" class="form-label">Kode Mesin</label>
                                        <input id="kodemesinEdit" autocomplete="false" spellcheck="off" type="text"
                                             class="form-control" placeholder="Kode Mesin" autocomplete="off">
                                        <input type="hidden" id="UpdateId">
                                   </div>
                              </div>
                              <div class="col-lg-6">
                                   <div class="form-group">
                                        <label for="tipemesinEdit" class="form-label">Tipe Mesin</label>
                                        <input id="tipemesinEdit" type="text" class="form-control"
                                             placeholder="Tipe Mesin" autocomplete="off">
                                   </div>
                              </div>
                              <div class="col-lg-12">
                                   <div class="form-group">
                                        <label for="lokasimesinEdit" class="form-label">Lokasi Mesin</label>
                                        <select id="lokasimesinEdit" type="text" class="form-control"
                                             placeholder="Lokasi Mesin">
                                             <option value="">-- PILIH LOKASI --</option>
                                             <option value="OFFICE PIT 27">OFFICE PIT 27</option>
                                             <option value="OFFICE KM 14">OFFICE KM 14</option>
                                             <option value="WORKSHOP 27 INDOOR">WORKSHOP 27 INDOOR</option>
                                             <option value="WORKSHOP 27 TERAS">WORKSHOP 27 TERAS</option>
                                             <option value="WAREHOUSE 2">WAREHOUSE 2</option>
                                             <option value="Tempodo 6">Tempodo 6</option>
                                        </select>
                                   </div>
                              </div>
                              <div class="col-lg-4">
                                   <div class="form-group">
                                        <label for="ipaddressEdit" class="form-label">IP Address</label>
                                        <input class="form-control" data-inputmask="'alias': 'ip'" name="ipaddressEdit"
                                             id="ipaddressEdit" value="" autocomplete="off">
                                   </div>
                              </div>
                              <div class="col-lg-3">
                                   <div class="form-group">
                                        <label for="portEdit" class="form-label">Port</label>
                                        <input id="portEdit" type="number" class="form-control" autocomplete="off">
                                   </div>
                              </div>
                              <div class="col-lg-5">
                                   <div class="form-group">
                                        <label for="stat_downloadEdit" class="form-label">Status Download</label>
                                        <select id="stat_downloadEdit" type="text" class="form-control"
                                             placeholder="Status Download">
                                             <option value="">-- PILIH STATUS --</option>
                                             <option value="AUTO">AUTO</option>
                                             <option value="MANUAL">MANUAL</option>
                                        </select>
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
                         Detail Data Mesin
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
                         <label for="detailMesin" class="form-label">Mesin</label>
                         <input id="detailMesin" type="text" class="form-control" readonly />
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

// export template insentif
<div class="modal fade modal-borderless" id="modalExport" tabindex="-1" role="dialog"
     aria-labelledby="titleModalImportMesin" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="titleModalImportMesin">
                         Export Data Mesin
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
                    <button type="button" class="btn btn-primary ms-1" id="exportMesin">
                         <span class="d-none d-sm-block">Export Template</span>
                    </button>
                    </form>
               </div>
          </div>
     </div>
</div>

// hapus insentif
<div class="modal fade modal-borderless" id="modalHapus" tabindex="-1" role="dialog"
     aria-labelledby="titleModalHapusMesin" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="titleModalHapusMesin">
                         Hapus Data Mesin
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
                    <button type="button" class="btn btn-primary ms-1" id="HapusMesin">
                         <span class="d-none d-sm-block">Hapus Mesin</span>
                    </button>
                    </form>
               </div>
          </div>
     </div>
</div>
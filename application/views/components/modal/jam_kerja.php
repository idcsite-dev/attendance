<!-- Modal Import Data -->
<div class="modal fade modal-borderless" id="modalImport" tabindex="-1" role="dialog"
     aria-labelledby="titleModalImportJam Kerja" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="titleModalImportJam Kerja">
                         Import Jam Kerja
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="importJam Kerja" method="POST" data-parsley-validate>
                         <div class="form-group mandatory">
                              <label for="importFile" class="form-label">File Jam Kerja</label>
                              <input id="importFile" type="file" accept=".xlsx" class="form-control"
                                   aria-describedby="fileHelp" required />
                              <div id="fileHelp" class="form-text text-danger"><b>*Upload File Jam Kerja harus dalam
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
                         Tambah Jam Kerja
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="addJam Kerja" method="POST" data-parsley-validate>
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
                         <div class="form-group mandatory">
                              <label for="gaji" class="form-label">Jam Kerja Pokok</label>
                              <input id="gaji" type="text" class="form-control" placeholder="Nominal Jam Kerja Pokok"
                                   required />
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
                         Edit Jam Kerja
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="updateJam Kerja" method="POST" data-parsley-validate>
                         <input id="updateId" type="text" class="form-control" hidden />
                         <div class="form-group mandatory">
                              <label for="updateJam KerjaPokok" class="form-label">Jam Kerja Pokok</label>
                              <input id="updateJam KerjaPokok" type="text" class="form-control"
                                   placeholder="Nominal Jam Kerja Pokok" required />
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
                         Detail Jam Kerja
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
                         <label for="detailJam Kerja" class="form-label">Jam Kerja Pokok</label>
                         <input id="detailJam Kerja" type="text" class="form-control" readonly />
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
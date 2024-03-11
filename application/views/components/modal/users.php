<style>
.form-group[class*=has-icon-] .form-control-icon {
     padding: 2rem 0.6rem;
}

html[data-bs-theme=dark] .form-group[class*=has-icon-] .form-control-icon {
     padding: 2rem 0.6rem;
}
</style>
<!-- Modal Tambah Data -->
<div class="modal fade modal-borderless" id="modalAdd" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="exampleModalScrollableTitle">
                         Tambah Data User
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="addUsers" method="POST" data-parsley-validate>
                         <div class="form-group mandatory">
                              <label for="searchKaryawan" class="form-label">Cari Karyawan</label>
                              <input id="searchKaryawan" type="text" class="form-control"
                                   placeholder="Masukkan NIK/Nama Karyawan" />
                         </div>
                         <div class="form-group">
                              <label for="nama" class="form-label">Nama User</label>
                              <input id="nama" type="text" class="form-control" placeholder="Nama User" readonly />
                              <input type="text" id="karyawan" hidden>
                         </div>
                         <div class="row">
                              <div class="col-lg-6">
                                   <div class="form-group">
                                        <label for="depart" class="form-label">Departemen</label>
                                        <input id="depart" type="text" class="form-control" placeholder="Departemen"
                                             readonly />
                                        <input type="text" id="karyawan" hidden>
                                   </div>
                              </div>
                              <div class="col-lg-6">
                                   <div class="form-group">
                                        <label for="posisi" class="form-label">Posisi</label>
                                        <input id="posisi" type="text" class="form-control" placeholder="Posisi"
                                             readonly />
                                        <input type="text" id="karyawan" hidden>
                                   </div>
                              </div>
                         </div>
                         <div class="form-group mandatory position-relative has-icon-right">
                              <label for="sesi" class="form-label">Kata Sandi/Password</label>
                              <input type="password" id="sesi" class="form-control" placeholder="Kata Sandi" required />
                              <div class="form-control-icon">
                                   <i class="bi bi-eye" id="password_icon"></i>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-4 col-12">
                                   <div class="form-group mandatory">
                                        <label for="tglAktif" class="form-label">Tanggal Aktif</label>
                                        <input id="tglAktif" type="date" class="form-control" value="<?=date('Y-m-d')?>"
                                             required />
                                   </div>
                              </div>
                              <div class="col-md-4 col-12">
                                   <div class="form-group mandatory">
                                        <label for="tglExpired" class="form-label">Tanggal Expired</label>
                                        <input id="tglExpired" type="date" class="form-control"
                                             value="<?=date('Y-m-d', strtotime('+10 years', strtotime(date('Y-m-d'))))?>"
                                             required />
                                   </div>
                              </div>
                              <div class="col-md-4 col-12">
                                   <div class="form-group">
                                        <label for="akses" class="form-label">Akses</label>
                                        <select id="akses" class="form-control" required>
                                             <option value="">-- PILIH AKSES --</option>
                                             <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                             <option value="ADMIN">ADMIN</option>
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
                         Edit Data User
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="updateUsers" method="POST" data-parsley-validate>
                         <input id="updateId" type="text" class="form-control" hidden />
                         <div class="row">
                              <div class="col-lg-4">
                                   <div class="form-group">
                                        <label for="editNIK" class="form-label">NIK</label>
                                        <input id="editNIK" type="text" class="form-control" placeholder="NIK"
                                             disabled />
                                   </div>
                              </div>
                              <div class="col-lg-8">
                                   <div class="form-group">
                                        <label for="editNama" class="form-label">Nama User</label>
                                        <input id="editNama" type="text" class="form-control" placeholder="Nama User"
                                             disabled />
                                   </div>
                              </div>
                              <div class="col-lg-12">
                                   <div class="form-group">
                                        <label for="editDepart" class="form-label">Departemen</label>
                                        <input id="editDepart" type="text" class="form-control" placeholder="Departemen"
                                             disabled />
                                   </div>
                              </div>
                              <div class="col-lg-12">
                                   <div class="form-group">
                                        <label for="editPosisi" class="form-label">Posisi</label>
                                        <input id="editPosisi" type="text" class="form-control" placeholder="Posisi"
                                             disabled />
                                   </div>
                              </div>
                         </div>
                         <div class="form-group mandatory position-relative has-icon-right">
                              <label for="updateSesi" class="form-label">Kata Sandi/Password Baru</label>
                              <input type="password" id="updateSesi" class="form-control" placeholder="Kata Sandi">
                              <div class="form-control-icon">
                                   <i class="bi bi-eye" id="update_password_icon"></i>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-4 col-12">
                                   <div class="form-group mandatory">
                                        <label for="updateTglAktif" class="form-label">Tanggal Aktif</label>
                                        <input id="updateTglAktif" type="date" class="form-control" required />
                                   </div>
                              </div>
                              <div class="col-md-4 col-12">
                                   <div class="form-group mandatory">
                                        <label for="updateTglExpired" class="form-label">Tanggal Expired</label>
                                        <input id="updateTglExpired" type="date" class="form-control" required />
                                   </div>
                              </div>
                              <div class="col-md-4 col-12">
                                   <div class="form-group">
                                        <label for="editAkses" class="form-label">Akses</label>
                                        <select id="editAkses" class="form-control" required>
                                             <option value="">-- PILIH AKSES --</option>
                                             <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                             <option value="ADMIN">ADMIN</option>
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
                         Detail Data User
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <div class="row">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="detailNIK" class="form-label">NIK</label>
                                   <input id="detailNIK" type="text" class="form-control" placeholder="NIK" readonly />
                              </div>
                         </div>
                         <div class="col-lg-8">
                              <div class="form-group">
                                   <label for="detailNama" class="form-label">Nama User</label>
                                   <input id="detailNama" type="text" class="form-control" placeholder="Nama User"
                                        readonly />
                              </div>
                         </div>
                         <div class="col-lg-12">
                              <div class="form-group">
                                   <label for="detailDepart" class="form-label">Departemen</label>
                                   <input id="detailDepart" type="text" class="form-control" placeholder="Departemen"
                                        readonly />
                              </div>
                         </div>
                         <div class="col-lg-12">
                              <div class="form-group">
                                   <label for="detailPosisi" class="form-label">Posisi</label>
                                   <input id="detailPosisi" type="text" class="form-control" placeholder="Posisi"
                                        readonly />
                              </div>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-4 col-12">
                              <div class="form-group">
                                   <label for="detailTglAktif" class="form-label">Tanggal Aktif</label>
                                   <input id="detailTglAktif" type="text" class="form-control" readonly />
                              </div>
                         </div>
                         <div class="col-md-4 col-12">
                              <div class="form-group">
                                   <label for="detailTglExpired" class="form-label">Tanggal Expired</label>
                                   <input id="detailTglExpired" type="text" class="form-control" readonly />
                              </div>
                         </div>
                         <div class="col-md-4 col-12">
                              <div class="form-group">
                                   <label for="detailAkses" class="form-label">Akses</label>
                                   <input id="detailAkses" type="text" class="form-control" readonly />
                              </div>
                         </div>
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
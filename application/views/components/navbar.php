<style>
.form-group[class*=has-icon-] .form-control-icon {
     padding: 2rem 0.6rem;
}

html[data-bs-theme=dark] .form-group[class*=has-icon-] .form-control-icon {
     padding: 2rem 0.6rem;
}
</style>
<header>
     <nav class="navbar navbar-expand navbar-light navbar-top">
          <div class="container-fluid">
               <a href="#" class="burger-btn d-block">
                    <i class="bi bi-justify fs-3"></i>
               </a>

               <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-lg-0">

                    </ul>
                    <div class="dropdown">
                         <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                              <div class="user-menu d-flex">
                                   <div class="user-name text-end me-3">
                                        <h6 class="mb-0 text-gray-600"><?=$this->session->userdata('nama_karyawan')?> |
                                             <?=$this->session->userdata('no_nik')?>

                                        </h6>
                                        <p class="mb-0 text-sm text-gray-600">
                                             <?=$this->session->userdata('departemen')?> |
                                             <?=$this->session->userdata('akses')?>
                                        </p>
                                   </div>
                                   <div class="user-img d-flex align-items-center">
                                        <div class="avatar avatar-md">
                                             <img src="<?=base_url()?>assets/assets/compiled/jpg/1.jpg" />
                                        </div>
                                   </div>
                              </div>
                         </a>
                         <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                              style="min-width: 11rem">
                              <li>
                                   <h6 class="dropdown-header">Halo, <?=$this->session->userdata('nama_karyawan')?>!
                                   </h6>
                              </li>
                              <li>
                                   <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#modalChangePassword"><i
                                             class="icon-mid bi bi-person-lock me-2"></i>
                                        Ganti
                                        Password</button>
                              </li>
                              <li>
                                   <hr class="dropdown-divider" />
                              </li>
                              <li>
                                   <button type="button" class="dropdown-item" id="logoutProcess"><i
                                             class="icon-mid bi bi-box-arrow-left me-2"></i>
                                        Logout</button>
                              </li>
                         </ul>
                    </div>
               </div>
          </div>
     </nav>
</header>
<!-- Modal Change Password -->
<div class="modal fade modal-borderless" id="modalChangePassword" tabindex="-1" role="dialog"
     aria-labelledby="modalGantiPassword" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
               <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="modalGantiPassword">
                         Ganti Password
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="changePassword" method="POST" data-parsley-validate>
                         <div class="form-group mandatory position-relative has-icon-right">
                              <label for="oldPassword" class="form-label">Kata Sandi/Password Lama</label>
                              <input type="password" id="oldPassword" class="form-control" placeholder="Kata Sandi"
                                   required />
                              <div class="form-control-icon">
                                   <i class="bi bi-eye" id="oldPasswordIcon"></i>
                              </div>
                         </div>
                         <div class="form-group mandatory position-relative has-icon-right">
                              <label for="newPassword" class="form-label">Kata Sandi/Password Baru</label>
                              <input type="password" id="newPassword" class="form-control" placeholder="Kata Sandi"
                                   required />
                              <div class="form-control-icon">
                                   <i class="bi bi-eye" id="newPasswordIcon"></i>
                              </div>
                         </div>
                         <div class="form-group mandatory position-relative has-icon-right">
                              <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                              <input type="password" id="confirmPassword" data-parsley-match-password="newPassword"
                                   class="form-control" placeholder="Kata Sandi" required />
                              <div class="form-control-icon">
                                   <i class="bi bi-eye" id="confirmPasswordIcon"></i>
                              </div>
                         </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                         <span class="d-none d-sm-block">Kembali</span>
                    </button>
                    <button type="submit" class="btn btn-info ms-1">
                         <span class="d-none d-sm-block">Simpan</span>
                    </button>
                    </form>
               </div>
          </div>
     </div>
</div>
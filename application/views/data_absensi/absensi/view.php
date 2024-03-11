<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('components/header')?>

<body>
     <script src="<?=base_url()?>assets/assets/static/js/initTheme.js"></script>
     <div id="app">

         <?php $this->load->view('components/sidebar' . '_' . strtolower($this->session->userdata('akses')))?>

          <div id="main" class="layout-navbar navbar-fixed">

               <?php $this->load->view('components/navbar')?>

               <div id="main-content">
                    <div class="page-heading">
                         <div class="page-title">
                              <div class="row">
                                   <div class="col-12 col-md-6 order-md-1 order-last">
                                        <h3>Kehadiran</h3>
                                        <p class="text-subtitle text-muted">
                                             Aplikasi Data Kehadiran
                                        </p>
                                   </div>
                                   <div class="col-12 col-md-6 order-md-2 order-first">
                                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                             <ol class="breadcrumb">
                                                  <li class="breadcrumb-item">
                                                       <a href="javascript:void(0)">Absensi</a>
                                                  </li>
                                                  <li class="breadcrumb-item active" aria-current="page">
                                                       Data Absensi
                                                  </li>
                                             </ol>
                                        </nav>
                                   </div>
                              </div>
                         </div>
                         <section class="section">
                              <div class="row" id="basic-table">
                                   <div class="col-12">
                                        <div class="card">
                                             <div class="card-header">
                                                  <h2 class="card-title">Data Aktual Kehadiran</h2>
                                             </div>
                                             <div class="card-content">
                                                  <div class="card-body pt-0">
                                                       <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                 <a class="nav-link active" id="ts-tab"
                                                                      data-bs-toggle="tab" href="#ts" role="tab"
                                                                      aria-controls="ts" aria-selected="true">Data
                                                                      Aktual Kehadiran</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                 <a class="nav-link" id="profile-tab"
                                                                      data-bs-toggle="tab" href="#profile" role="tab"
                                                                      aria-controls="profile"
                                                                      aria-selected="false">Export Data
                                                                      Aktual Kehadiran</a>
                                                            </li>
                                                       </ul>
                                                       <div class="tab-content" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="ts"
                                                                 role="tabpanel" aria-labelledby="ts-tab">
                                                                 <div class="row mt-4">
                                                                      <div class="col-lg-4">
                                                                           <button type="button"
                                                                                class="btn btn-primary tooltips"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#modalAdd"
                                                                                data-bs-placement="top"
                                                                                title="Tambah Data"><i
                                                                                     class="bi bi-plus-circle"></i></button>
                                                                           <button type="button"
                                                                                class="btn btn-success tooltips refreshPage"
                                                                                data-bs-placement="top"
                                                                                title="Refresh Page"><i
                                                                                     class="bi bi-arrow-clockwise"></i></button>
                                                                      </div>
                                                                      <div class="col-lg-12">
                                                                           <div class="table-responsive mt-3"
                                                                                id="dataTable">
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div class="tab-pane fade" id="profile" role="tabpanel"
                                                            aria-labelledby="profile-tab">
                                                            <div class="row mt-4">
                                                                 <div class="col-lg-4">
                                                                      <label for="lstBulanGenProll">Bulan
                                                                           :</label>
                                                                      <div class="input-group">
                                                                           <select id="lstBulanGenProll"
                                                                                name="lstBulanGenProll"
                                                                                class="form-control">
                                                                                <option value="">-- PILIH
                                                                                     BULAN --</option>
                                                                                <option value="1">JANUARI
                                                                                </option>
                                                                                <option value="2">
                                                                                     FEBRUARI</option>
                                                                                <option value="3">MARET
                                                                                </option>
                                                                                <option value="4">APRIL
                                                                                </option>
                                                                                <option value="5">MEI
                                                                                </option>
                                                                                <option value="6">JUNI
                                                                                </option>
                                                                                <option value="7">JULI
                                                                                </option>
                                                                                <option value="8">AGUSTUS
                                                                                </option>
                                                                                <option value="9">
                                                                                     SEPTEMBER</option>
                                                                                <option value="10">
                                                                                     OKTOBER</option>
                                                                                <option value="11">
                                                                                     NOPEMBER</option>
                                                                                <option value="112">
                                                                                     DESEMBER</option>
                                                                           </select>
                                                                      </div>
                                                                 </div>
                                                                 <div class="col-lg-2">
                                                                      <label for="lstTahunGenProll">Tahun
                                                                           :</label>
                                                                      <div class="input-group">
                                                                           <select id="lstTahunGenProll"
                                                                                name="lstTahunGenProll"
                                                                                class="form-control">
                                                                                <option value="2023">2023
                                                                                </option>
                                                                                <option value="2024">2024
                                                                                </option>
                                                                                <option value="2025">2025
                                                                                </option>
                                                                                <option value="2026">2026
                                                                                </option>
                                                                                <option value="2027">2027
                                                                                </option>
                                                                                <option value="2028">2028
                                                                                </option>
                                                                                <option value="2029">2029
                                                                                </option>
                                                                                <option value="2030">2030
                                                                                </option>
                                                                           </select>
                                                                      </div>
                                                                 </div>
                                                                 <div class="col-lg-1 mt-4">
                                                                      <button type="button"
                                                                           class="btn btn-primary tooltips"
                                                                           data-bs-toggle="modal"
                                                                           data-bs-target="#modalAdd"
                                                                           data-bs-placement="top"
                                                                           title="Export Data Aktual Kehadiran"><i
                                                                                class="bi bi-file-earmark-arrow-down"></i></button>
                                                                 </div>
                                                            </div>
                                                            <div id="tbmTimesheet" class="data mt-3"></div>
                                                       </div>

                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </section>
                    </div>
               </div>

          </div>
     </div>
     <?php $this->load->view('components/modal/absensi')?>

     <?php $this->load->view('components/js')?>

     <script src="<?=base_url()?>assets/js/absensi/absensi.js"></script>

</body>

</html>
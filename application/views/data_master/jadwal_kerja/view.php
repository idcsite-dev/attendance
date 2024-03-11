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
                                                       <a href="javascript:void(0)">Master Data</a>
                                                  </li>
                                                  <li class="breadcrumb-item active" aria-current="page">
                                                       Data Jadwal Kerja
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
                                                  <h2 class="card-title">Data Jadwal Kerja</h2>

                                             </div>
                                             <div class="card-content">
                                                  <div class="card-body">
                                                       <div class="row">
                                                            <div class="col-lg-12">
                                                                 <button type="button" class="btn btn-primary tooltips"
                                                                      data-bs-toggle="modal" data-bs-target="#modalAdd"
                                                                      data-bs-placement="top" title="Tambah Data"><i
                                                                           class="bi bi-plus-circle"></i></button>
                                                                 <button type="button"
                                                                      class="btn btn-success tooltips refreshPage"
                                                                      data-bs-placement="top" title="Refresh Page"><i
                                                                           class="bi bi-arrow-clockwise"></i></button>
                                                                 <button type="button"
                                                                      class="btn btn-secondary tooltips"
                                                                      id="importSample" data-bs-placement="top"
                                                                      title="Template Import Data"><i
                                                                           class="bi bi-filetype-xlsx"></i></button>
                                                            </div>
                                                       </div>
                                                       <div class="col-lg-12 mt-4">
                                                            <div class="table-responsive" id="dataTable"></div>
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
     <?php $this->load->view('components/modal/jadwal_kerja')?>

     <?php $this->load->view('components/js')?>

     <script src="<?=base_url()?>assets/js/data_master/jadwal_kerja.js"></script>

</body>

</html>
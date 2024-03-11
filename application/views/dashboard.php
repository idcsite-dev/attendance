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
                                             Aplikasi Kehadiran.
                                        </p>
                                   </div>
                                   <div class="col-12 col-md-6 order-md-2 order-first">
                                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                             <ol class="breadcrumb">
                                                  <li class="breadcrumb-item">
                                                       <a href="index.html">Beranda</a>
                                                  </li>
                                                  <li class="breadcrumb-item active" aria-current="page">
                                                       Home
                                                  </li>
                                             </ol>
                                        </nav>
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-lg-4">
                                   <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                             <div class="row">
                                                  <div class="col-lg-3 d-flex justify-content-start ">
                                                       <div class="stats-icon blue mb-2">
                                                            <i class="iconly-boldProfile"></i>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-9">
                                                       <h6 class="text-muted font-semibold">Jumlah Karyawan
                                                       </h6>
                                                       <h6 class="font-extrabold mb-0">644</h6>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-lg-4">
                                   <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                             <div class="row">
                                                  <div class="col-lg-3 d-flex justify-content-start ">
                                                       <div class="stats-icon blue mb-2">
                                                            <i class="iconly-boldProfile"></i>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-9">
                                                       <h6 class="text-muted font-semibold">Onsite
                                                       </h6>
                                                       <h6 class="font-extrabold mb-0">600</h6>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-lg-4">
                                   <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                             <div class="row">
                                                  <div class="col-lg-3 d-flex justify-content-start ">
                                                       <div class="stats-icon blue mb-2">
                                                            <i class="iconly-boldProfile"></i>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-9">
                                                       <h6 class="text-muted font-semibold">Offsite
                                                       </h6>
                                                       <h6 class="font-extrabold mb-0">44</h6>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

          </div>
     </div>

     <?php $this->load->view('components/js')?>
     <script src="<?=base_url()?>assets/assets/extensions/dayjs/dayjs.min.js"></script>
     <script src="<?=base_url()?>assets/assets/extensions/apexcharts/apexcharts.min.js"></script>
     <script src="<?=base_url()?>assets/assets/compiled/js/chart.js"></script>
     <script>
     $("#tblPayrollDash").DataTable({
          searching: false,
          binfo: false,
          "dom": 'rtip'
     });
     </script>

</body>

</html>
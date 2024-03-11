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
                                                       <a href="<?=base_url()?>">Beranda</a>
                                                  </li>
                                                  <li class="breadcrumb-item active" aria-current="page">
                                                       Home
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
                                                  <h2 class="card-title">Data Plan Kehadiran</h2>
                                             </div>
                                             <div class="card-content">
                                                  <div class="card-body">
                                                       <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                 <a class="nav-link active" id="ts-tab"
                                                                      data-bs-toggle="tab" href="#ts" role="tab"
                                                                      aria-controls="ts" aria-selected="true">Upload
                                                                      Plan</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                 <a class="nav-link" id="profile-tab"
                                                                      data-bs-toggle="tab" href="#profile" role="tab"
                                                                      aria-controls="profile" aria-selected="false">Data
                                                                      Plan Kehadiran</a>
                                                            </li>
                                                       </ul>
                                                       <div class="tab-content" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="ts"
                                                                 role="tabpanel" aria-labelledby="ts-tab">
                                                                 <div class="row mt-4">
                                                                      <div class="col-lg-12">
                                                                           <h4>Download Template Plan Kehadiran</h4>
                                                                      </div>
                                                                      <div class="col-lg-6">
                                                                           <div class="row">
                                                                                <div class="col-lg-8">
                                                                                     <label for="lstBulanTS">Bulan
                                                                                          :</label>
                                                                                     <div class="input-group">
                                                                                          <select id="lstBulanTS"
                                                                                               name="lstBulanTS"
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
                                                                                <div class="col-lg-4">
                                                                                     <label for="lstTahunTS">Tahun
                                                                                          :</label>
                                                                                     <div class="input-group">
                                                                                          <select id="lstTahunTS"
                                                                                               name="lstTahunTS"
                                                                                               class="form-control">
                                                                                               <option value="">--
                                                                                                    PILIH TAHUN --
                                                                                               </option>
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
                                                                           </div>
                                                                      </div>
                                                                      <div class="col-lg-2 mt-4">
                                                                           <button
                                                                                dt-href="<?=base_url('timesheet/export_excel')?>"
                                                                                class="btn btn-success" id="btnBulanTs"
                                                                                name="btnBulanTs"
                                                                                title="Download Template Plan Kehadiran">
                                                                                <i
                                                                                     class="bi bi-file-earmark-arrow-down"></i></button>
                                                                      </div>
                                                                 </div>
                                                                 <div class="row">
                                                                      <div class="col-lg-12 mt-4">
                                                                           <hr>
                                                                      </div>
                                                                      <div class="col-lg-12 mt-3">
                                                                           <h4>Upload Data Plan Kehadiran</h4>
                                                                      </div>
                                                                      <div class="col-lg-12">
                                                                           <div class="row">
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
                                                                           </div>
                                                                      </div>
                                                                      <div class="col-lg-12 mt-3">
                                                                           <form action="<?=base_url('timesheet/import_excel');?>"
                                                                                method="post"
                                                                                enctype="multipart/form-data">
                                                                                <div class="form-group">
                                                                                     <label>Pilih File Excel</label>
                                                                                     <div class="input-group mb-3">
                                                                                          <input type="file"
                                                                                               class="form-control"
                                                                                               name="fileExcel"
                                                                                               accept=".xlsx">
                                                                                          <button
                                                                                               class="btn btn-success"
                                                                                               type="submit"
                                                                                               id="btnUlTimesheet"
                                                                                               name="btnUlTimesheet"
                                                                                               title="Upload Plan Kehadiran">
                                                                                               <i
                                                                                                    class="bi bi-file-earmark-arrow-up"></i>
                                                                                          </button>
                                                                                     </div>
                                                                                </div>
                                                                           </form>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div class="tab-pane fade" id="profile" role="tabpanel"
                                                            aria-labelledby="profile-tab">
                                                            <div id="tbmTimesheet" class="data mt-3"></div>
                                                       </div>
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

     <?php $this->load->view('components/js')?>
     <?php $this->load->view('components/timesheet_js')?>

</body>

</html>
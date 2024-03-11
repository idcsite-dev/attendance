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
                                                  <h2 class="card-title">Data Payroll</h2>
                                             </div>
                                             <div class="card-content">
                                                  <div class="card-body">
                                                       <div class="row">
                                                            <div class="col-lg-12">
                                                                 <button id="btnProsPayroll" name="btnProsPayroll"
                                                                      class="btn btn-primary"> Proses Payroll</button>
                                                                 <button id="btnProsPayrollOrang"
                                                                      name="btnProsPayrollOrang"
                                                                      class="btn btn-success"> Proses Payroll
                                                                      Per-orang</button>
                                                                 <button class="btn btn-warning" id="btnImpGajiKeExcel"
                                                                      name="btnImpGajiKeExcel">Import Gaji Ke
                                                                      Excel</button>
                                                                 </button>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                 <hr>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                 <div class="row">
                                                                      <div class="col-lg-4">
                                                                           <label for="lstBulanGenProll">Bulan :</label>
                                                                           <div class="input-group">
                                                                                <select id="lstBulanGenProll"
                                                                                     name="lstBulanGenProll"
                                                                                     class="form-control">
                                                                                     <option value="">-- PILIH BULAN --
                                                                                     </option>
                                                                                     <option value="1">JANUARI</option>
                                                                                     <option value="2">FEBRUARI</option>
                                                                                     <option value="3">MARET</option>
                                                                                     <option value="4">APRIL</option>
                                                                                     <option value="5">MEI</option>
                                                                                     <option value="6">JUNI</option>
                                                                                     <option value="7">JULI</option>
                                                                                     <option value="8">AGUSTUS</option>
                                                                                     <option value="9">SEPTEMBER
                                                                                     </option>
                                                                                     <option value="10">OKTOBER</option>
                                                                                     <option value="11">NOPEMBER
                                                                                     </option>
                                                                                     <option value="112">DESEMBER
                                                                                     </option>
                                                                                </select>
                                                                           </div>
                                                                      </div>
                                                                      <div class="col-lg-2">
                                                                           <label for="lstTahunGenProll">Tahun :</label>
                                                                           <div class="input-group">
                                                                                <select id="lstTahunGenProll"
                                                                                     name="lstTahunGenProll"
                                                                                     class="form-control">
                                                                                     <option value="2023">2023</option>
                                                                                     <option value="2024">2024</option>
                                                                                     <option value="2025">2025</option>
                                                                                     <option value="2026">2026</option>
                                                                                     <option value="2027">2027</option>
                                                                                     <option value="2028">2028</option>
                                                                                     <option value="2029">2029</option>
                                                                                     <option value="2030">2030</option>
                                                                                </select>
                                                                           </div>
                                                                      </div>
                                                                      <div class="col-lg-4" style="margin-top:24px;">
                                                                           <button id="btnTampilPayroll"
                                                                                name="btnTampilPayroll"
                                                                                class="btn btn-primary"> Tampilkan Data
                                                                                Payroll</button>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div class="table-responsive mt-3">
                                                            <table id="tblPayroll"
                                                                 class="table table-striped table-bordered table-hover"
                                                                 style="width:100%;">
                                                                 <thead>
                                                                      <tr>
                                                                           <th>No.</th>
                                                                           <th>Bulan Periode</th>
                                                                           <th>Tahun Periode</th>
                                                                           <th>Total Gaji</th>
                                                                           <th>Aksi</th>
                                                                      </tr>
                                                                 </thead>
                                                                 <tbody>
                                                                      <?php

if (!empty($dt_payroll)) {
    $n = 1;
    foreach ($dt_payroll as $list) {
        $month = array(
            '1' => 'JANUARI',
            '2' => 'FEBRUARI',
            '3' => 'MARET',
            '4' => 'APRIL',
            '5' => 'MEI',
            '6' => 'JUNI',
            '7' => 'JULI',
            '8' => 'AGUSTUS',
            '9' => 'SEPTEMBER',
            '10' => 'OKTOBER',
            '11' => 'NOPEMBER',
            '12' => 'DESEMBER',
        );

        $bulan = $month[$list->bulan];
        echo '<tr>';
        echo '<td class=" text-center align-middle text-nowrap" style="width:1%;">' . $n++ . '</td>';
        echo '<td class="align-middle text-nowrap" style="width:10%;">' . $bulan . '</td>';
        echo '<td class="align-middle text-nowrap" style="width:10%;">' . $list->tahun . '</td>';
        echo '<td class="text-end align-middle text-nowrap" style="width:10%;">Rp. ' . number_format($list->total_gaji) . '</td>';
        echo '<td class="text-center align-middle text-nowrap" style="width:4%;">';
        echo ' <button id="' . $list->id_payroll . '" class="btn btn-success font-bold dtlPayroll" title="Detail Payroll"><i class="bi bi-card-list"></i></button> ';
        echo ' <a href="' . base_url('data_payroll/hitung_ulang/' . $list->id_payroll) . '" target="_blank" class="btn btn-primary font-bold " title="Hitung Ulang Gaji"><i class="bi bi-calculator"></i></a> ';
        echo ' <button id="' . $list->id_payroll . '"  dt-href="' . base_url('data_payroll/hapus/' . $list->id_payroll) . '" class="btn btn-danger font-bold hapuspayroll" title="Hapus Data Payroll"><i class="bi bi-trash"></i></button> ';
        echo '</td>';
        echo '</tr>';
    }
}

?>
                                                                 </tbody>
                                                            </table>
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
     <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
               <div class="modal-content">
                    <div class="modal-header bg-primary">
                         <h5 class="modal-title white" id="myModalLabel160">Proses Payroll
                         </h5>
                         <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                              <i data-feather="x"></i>
                         </button>
                    </div>
                    <div class="modal-body">
                         <div class="row">
                              <div class="col-lg-12">
                                   <h4>Periode Penggajian : </h4>
                              </div>
                              <div class="col-lg-12">
                                   <div class="row">
                                        <div class="col-lg-4">
                                             <label for="lstBulanGenProll">Bulan :</label>
                                             <div class="input-group">
                                                  <select id="lstBulanGenProll" name="lstBulanGenProll"
                                                       class="form-control">
                                                       <option value="">-- PILIH BULAN --</option>
                                                       <option value="1">JANUARI</option>
                                                       <option value="2">FEBRUARI</option>
                                                       <option value="3">MARET</option>
                                                       <option value="4">APRIL</option>
                                                       <option value="5">MEI</option>
                                                       <option value="6">JUNI</option>
                                                       <option value="7">JULI</option>
                                                       <option value="8">AGUSTUS</option>
                                                       <option value="9">SEPTEMBER</option>
                                                       <option value="10">OKTOBER</option>
                                                       <option value="11">NOPEMBER</option>
                                                       <option value="112">DESEMBER</option>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="col-lg-2">
                                             <label for="lstTahunGenProll">Tahun :</label>
                                             <div class="input-group">
                                                  <select id="lstTahunGenProll" name="lstTahunGenProll"
                                                       class="form-control">
                                                       <option value="2023">2023</option>
                                                       <option value="2024">2024</option>
                                                       <option value="2025">2025</option>
                                                       <option value="2026">2026</option>
                                                       <option value="2027">2027</option>
                                                       <option value="2028">2028</option>
                                                       <option value="2029">2029</option>
                                                       <option value="2030">2030</option>
                                                  </select>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-lg-12 mt-3">
                                   <h4>Periode Lembur : </h4>
                              </div>
                              <div class="col-lg-12">
                                   <div class="row mb-4 ">
                                        <div class="col-lg-4">
                                             <label for="lstTglGenProllAwal">Dari Tanggal :</label>
                                             <input id="lstTglGenProllAwal" name="lstTglGenProllAwal" type="date"
                                                  class="form-control flatpickr-range-preloaded"
                                                  placeholder="Pilih tanggal">
                                        </div>
                                        <div class="col-lg-4">
                                             <label for="lstTglGenProllAkhir">Sampai Tanggal :</label>
                                             <input id="lstTglGenProllAkhir" name="lstTglGenProllAkhir" type="date"
                                                  class="form-control flatpickr-range-preloaded"
                                                  placeholder="Pilih tanggal">
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                              <i class="bx bx-x d-block d-sm-none"></i>
                              <span class="d-none d-sm-block">Batal</span>
                         </button>
                         <button id="btnGenPayroll" name="btnGenPayroll" class="btn btn-primary"> Proses
                              Payroll</button>
                    </div>
               </div>
          </div>
     </div>
     <div class="modal fade text-left" id="primaryOrang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
               <div class="modal-content">
                    <div class="modal-header bg-primary">
                         <h5 class="modal-title white" id="myModalLabel160">Proses Payroll Per-orang
                         </h5>
                         <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                              <i data-feather="x"></i>
                         </button>
                    </div>
                    <div class="modal-body">
                         <div class="row">
                              <div class="col-lg-4">
                                   <h4>NIK : </h4>
                                   <input type="text" id="txtnikkary" name="txtnikkary">
                              </div>
                              <div class="col-lg-8">
                                   <h4>Nama Karyawan : </h4>
                                   <input type="text" id="txtnikkary" name="txtnikkary">
                              </div>
                              <div class="col-lg-5">
                                   <h4>Departemen : </h4>
                                   <input type="text" id="txtnikkary" name="txtnikkary">
                              </div>
                              <div class="col-lg-5">
                                   <h4>Posisi : </h4>
                                   <input type="text" id="txtnikkary" name="txtnikkary">
                              </div>
                              <div class="col-lg-2">
                                   <h4>Tipe : </h4>
                                   <h2 type="text" id="txtnikkary" name="txtnikkary">
                              </div>
                              <div class="col-lg-12">
                                   <h4>Periode Penggajian : </h4>
                              </div>
                              <div class="col-lg-12">
                                   <div class="row">
                                        <div class="col-lg-4">
                                             <label for="lstBulanGenProll">Bulan :</label>
                                             <div class="input-group">
                                                  <select id="lstBulanGenProll" name="lstBulanGenProll"
                                                       class="form-control">
                                                       <option value="">-- PILIH BULAN --</option>
                                                       <option value="1">JANUARI</option>
                                                       <option value="2">FEBRUARI</option>
                                                       <option value="3">MARET</option>
                                                       <option value="4">APRIL</option>
                                                       <option value="5">MEI</option>
                                                       <option value="6">JUNI</option>
                                                       <option value="7">JULI</option>
                                                       <option value="8">AGUSTUS</option>
                                                       <option value="9">SEPTEMBER</option>
                                                       <option value="10">OKTOBER</option>
                                                       <option value="11">NOPEMBER</option>
                                                       <option value="112">DESEMBER</option>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="col-lg-2">
                                             <label for="lstTahunGenProll">Tahun :</label>
                                             <div class="input-group">
                                                  <select id="lstTahunGenProll" name="lstTahunGenProll"
                                                       class="form-control">
                                                       <option value="2023">2023</option>
                                                       <option value="2024">2024</option>
                                                       <option value="2025">2025</option>
                                                       <option value="2026">2026</option>
                                                       <option value="2027">2027</option>
                                                       <option value="2028">2028</option>
                                                       <option value="2029">2029</option>
                                                       <option value="2030">2030</option>
                                                  </select>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-lg-12 mt-3">
                                   <h4>Periode Lembur : </h4>
                              </div>
                              <div class="col-lg-12">
                                   <div class="row mb-4 ">
                                        <div class="col-lg-4">
                                             <label for="lstTglGenProllAwal">Dari Tanggal :</label>
                                             <input id="lstTglGenProllAwal" name="lstTglGenProllAwal" type="date"
                                                  class="form-control flatpickr-range-preloaded"
                                                  placeholder="Pilih tanggal">
                                        </div>
                                        <div class="col-lg-4">
                                             <label for="lstTglGenProllAkhir">Sampai Tanggal :</label>
                                             <input id="lstTglGenProllAkhir" name="lstTglGenProllAkhir" type="date"
                                                  class="form-control flatpickr-range-preloaded"
                                                  placeholder="Pilih tanggal">
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                              <i class="bx bx-x d-block d-sm-none"></i>
                              <span class="d-none d-sm-block">Batal</span>
                         </button>
                         <button id="btnGenPayroll" name="btnGenPayroll" class="btn btn-primary"> Proses
                              Payroll</button>
                    </div>
               </div>
          </div>
     </div>
     <?php $this->load->view('components/modal/payroll')?>

     <?php $this->load->view('components/js')?>
     <?php $this->load->view('components/payroll_js')?>

</body>


</html>
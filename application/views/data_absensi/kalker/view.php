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
                                                  <h2 class="card-title">Data Karyawan</h2>
                                             </div>
                                             <div class="card-content">
                                                  <div class="card-body">
                                                       <!-- <p class="card-text">
                                                Using the most basic table up, here’s how
                                                <code>.table</code>-based tables look in Bootstrap. You
                                                can use any example of below table for your tabless and it
                                                can be use with any type of bootstrap tables.
                                            </p> -->
                                                       <!-- Table with outer spacing -->
                                                       <div class="table-responsive">
                                                            <table class="table table-lg">
                                                                 <thead>
                                                                      <tr>
                                                                           <th>No.</th>
                                                                           <th>NIK</th>
                                                                           <th>Nama</th>
                                                                           <th>Departemen</th>
                                                                           <th>Jabatan</th>
                                                                           <th>Aksi</th>
                                                                      </tr>
                                                                 </thead>
                                                                 <tbody>
                                                                      <?php

if (!empty($dt_kary)) {
    $n = 1;
    foreach ($dt_kary as $lst) {
        echo '<tr>';
        echo '<td class="text-center align-middle text-nowrap" style="width:1%">' . $n++ . '</td>';
        echo '<td class="align-middle text-nowrap" style="width:5%">' . $lst->no_nik . '</td>';
        echo '<td class="align-middle" style="width:20%">' . $lst->nama_lengkap . '</td>';
        echo '<td class="align-middle" style="width:35%">' . $lst->depart . '</td>';
        echo '<td class="align-middle" style="width:35%">' . $lst->posisi . '</td>';
        echo '<td class="text-center align-middle text-nowrap" style="width:4%;">';
        echo ' <a href="' . base_url('karyawan/detail/' . $lst->id_kary) . '" class="btn btn-primary font-bold" >Detail</a> ';
        echo ' <a href="' . base_url('karyawan/edit/' . $lst->id_kary) . '" class="btn btn-warning font-bold" >Edit</a> ';
        echo ' <a href="' . base_url('karyawan/hapus/' . $lst->id_kary) . '" class="btn btn-success font-bold" >Hapus</a> ';
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

     <?php $this->load->view('components/js')?>

</body>

</html>
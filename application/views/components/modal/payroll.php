<div class="modal fade text-left" id="mdlDetailPayroll" tabindex="-1" role="dialog"
     aria-labelledby="jdlMdlDetailPayroll" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document"
          style="max-width:90%;">
          <div class="modal-content">
               <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="jdlMdlDetailPayroll">Detail Payroll
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <div class="row">
                         <div class="col-lg-12">
                              <div class="row">
                                   <div class="col-lg-4">
                                        <label for="lstDepartPRoll">Departemen :</label>
                                        <div class="input-group">
                                             <select id="lstDepartPRoll" name="lstDepartPRoll" class="form-control">
                                                  <?php

echo '<option value="">-- DEPARTEMEN --</option>';
if (!empty($depart)) {
    foreach ($depart as $lstd) {
        echo '<option value="' . $lstd->depart . '">' . $lstd->depart . '</option>';
    }
}

?>
                                             </select>
                                        </div>
                                   </div>
                                   <div class="col-lg-2">
                                        <label for="lstTipePRoll">Tipe Karyawan :</label>
                                        <div class="input-group">
                                             <select id="lstTipePRoll" name="lstTipePRoll" class="form-control">
                                                  <option value="">-- TIPE --</option>
                                                  <option value="STAFF">STAFF</option>
                                                  <option value="NONSTAFF">NONSTAFF</option>
                                             </select>
                                        </div>
                                   </div>
                                   <div class="col-lg-2 mt-4">
                                        <button type="button" id="btnTampilProll" class="btn btn-primary">
                                             <i class="bx bx-x d-block d-sm-none"></i>
                                             <span class="d-none d-sm-block">Tampilkan Data</span>
                                        </button>
                                   </div>
                              </div>
                         </div>
                         <div class="col-lg-12">
                              <input id="idpay" type="hidden" value="">
                              <div id="tblDetailPayrollKary" class="data"></div>
                         </div>
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="button" id="btnSlipGajiAll" class="btn btn-primary"
                         dt-href="<?=base_url('data_payroll/cetak_slip_all')?>">
                         <i class="bx bx-x d-block d-sm-none"></i>
                         <span class="d-none d-sm-block">Cetak Slip Gaji</span>
                    </button>
                    <button dt-href="<?=base_url('data_payroll/export_excel')?>" class="btn btn-success"
                         id="btnExpGajiKeExcel" name="btnExpGajiKeExcel">Export Gaji Ke Excel</button>
                    </button>
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                         <i class="bx bx-x d-block d-sm-none"></i>
                         <span class="d-none d-sm-block">Selesai</span>
                    </button>
               </div>
          </div>
     </div>
</div>
<div class="modal fade text-left" id="mdlDetailKaryPayroll" tabindex="-1" role="dialog"
     aria-labelledby="jdlMdlDetailKaryPayroll" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document"
          style="max-width:90%;">
          <div class="modal-content">
               <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="jdlMdlDetailPayroll">Detail Gaji Karyawan :
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <div class="row">
                         <div class="col-lg-3 col-md-6 col-sm-12">
                              <div class="form-group">
                                   <label for="txtNikKaryGaji">NIK :</label>
                                   <input id="txtNikKaryGaji" name="txtNikKaryGaji" type="text" class="form-control"
                                        disabled>
                              </div>
                         </div>
                         <div class="col-lg-9 col-md-6 col-sm-12">
                              <div class="form-group">
                                   <label for="txtNamaKaryGaji">Nama Karyawan :</label>
                                   <input id="txtNamaKaryGaji" name="txtNamaKaryGaji" type="text" class="form-control"
                                        disabled>
                              </div>
                         </div>
                         <div class="col-lg-6 col-md-12 col-sm-12">
                              <div class="form-group">
                                   <label for="txtDeptKaryGaji">Departemen :</label>
                                   <input id="txtDeptKaryGaji" name="txtDeptKaryGaji" type="text" class="form-control"
                                        disabled>
                              </div>
                         </div>
                         <div class="col-lg-6 col-md-12 col-sm-12">
                              <div class="form-group">
                                   <label for="txtSecKaryGaji">Section :</label>
                                   <input id="txtSecKaryGaji" name="txtSecKaryGaji" type="text" class="form-control"
                                        disabled>
                              </div>
                         </div>
                         <div class="col-lg-6 col-md-12 col-sm-12">
                              <div class="form-group">
                                   <label for="txtPosisiKaryGaji">Posisi :</label>
                                   <input id="txtPosisiKaryGaji" name="txtPosisiKaryGaji" type="text"
                                        class="form-control" disabled>
                              </div>
                         </div>
                         <div class="col-lg-3 col-md-4 col-sm-12">
                              <div class="form-group">
                                   <label for="txtLevelKaryGaji">Level :</label>
                                   <input id="txtLevelKaryGaji" name="txtLevelKaryGaji" type="text" class="form-control"
                                        disabled>
                              </div>
                         </div>
                         <div class="col-lg-1 col-md-4 col-sm-12">
                              <div class="form-group">
                                   <label for="txtGradeKaryGaji">Grade :</label>
                                   <input id="txtGradeKaryGaji" name="txtGradeKaryGaji" type="text" class="form-control"
                                        disabled>
                              </div>
                         </div>
                         <div class="col-lg-2 col-md-4 col-sm-12">
                              <div class="form-group">
                                   <label for="txtTipeKaryGaji">Tipe :</label>
                                   <input id="txtTipeKaryGaji" name="txtTipeKaryGaji" type="text" class="form-control"
                                        disabled>
                              </div>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="form-group">
                                   <label for="txtTipeKaryGaji">Gaji Pokok :</label>
                                   <input id="txtTipeKaryGaji" name="txtTipeKaryGaji" type="text" class="form-control"
                                        disabled>
                              </div>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="form-group">
                                   <label for="txtTipeKaryGaji">Lembur :</label>
                                   <input id="txtTipeKaryGaji" name="txtTipeKaryGaji" type="text" class="form-control"
                                        disabled>
                              </div>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="form-group">
                                   <h4>Tunjangan tidak tetap</h4>
                                   <div id="tblTunjtidaktetap" class="data"></div>
                              </div>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="form-group">
                                   <h4>Potongan</h4>
                                   <div id="tblPotongan" class="data"></div>
                              </div>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="form-group">
                                   <h4 id="txtTipeKaryGaji" name="txtTipeKaryGaji">Total Gaji : Rp. 0,-</h4>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                         <i class="bx bx-x d-block d-sm-none"></i>
                         <span class="d-none d-sm-block">Selesai</span>
                    </button>
               </div>
          </div>
     </div>
</div>
<div class="modal fade modal-borderless" id="modalImport" tabindex="-1" role="dialog"
     aria-labelledby="titleModalImportGaji" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
               <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="titleModalImportGaji">
                         Import Data Gaji
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <i data-feather="x"></i>
                    </button>
               </div>
               <div class="modal-body">
                    <form action="javascript:void(0)" id="importGaji" method="POST" data-parsley-validate>
                         <div class="row">
                              <div class="col-lg-6">
                                   <label for="lstBulanImp">Bulan :</label>
                                   <div class="input-group">
                                        <select id="lstBulanImp" name="lstBulanImp" class="form-control">
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
                              <div class="col-lg-3">
                                   <label for="lstTahunImp">Tahun :</label>
                                   <div class="input-group">
                                        <select id="lstTahunImp" name="lstTahunImp" class="form-control">
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
                         <div class="col-lg-12 mt-2">
                              <div class="form-group mandatory">
                                   <label for="importFile" class="form-label">File Gaji</label>
                                   <input id="importFile" type="file" accept=".xlsx" class="form-control"
                                        aria-describedby="fileHelp" required />
                                   <div id="fileHelp" class="form-text text-danger"><b>*Upload File Gaji harus dalam
                                             format
                                             pdf
                                             dengan ukuran maksimal 500 kb*</b></div>
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
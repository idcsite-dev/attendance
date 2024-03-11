<!-- Modal Tambah Data -->
<div class="modal fade modal-borderless text-left" id="modalAdd" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Tambah Data SPL
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addSPL" method="POST" data-parsley-validate>
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
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="tglSPL" class="form-label">Tanggal SPL</label>
                                <input id="tglSPL" type="date" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="jamMulai" class="form-label">Jam Mulai</label>
                                <input id="jamMulai" type="time" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="jamAkhir" class="form-label">Jam Akhir</label>
                                <input id="jamAkhir" type="time" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" cols="10" rows="5"></textarea>
                    </div>
                    <div class="form-group mandatory">
                        <label for="file" class="form-label">File SPL</label>
                        <input id="file" type="file" accept=".pdf" class="form-control" aria-describedby="fileHelp"
                            required />
                        <div id="fileHelp" class="form-text text-danger"><b>*Upload File SPL harus dalam format pdf
                                dengan ukuran maksimal 200 kb*</b></div>
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
                    Edit Data SPL
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="updateSPL" method="POST" data-parsley-validate>
                    <input id="updateId" type="text" class="form-control" hidden />
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="updateTglSPL" class="form-label">Tanggal SPL</label>
                                <input id="updateTglSPL" type="date" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="updateJamMulai" class="form-label">Jam Mulai</label>
                                <input id="updateJamMulai" type="time" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="updateJamAkhir" class="form-label">Jam Akhir</label>
                                <input id="updateJamAkhir" type="time" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="updateKeterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="updateKeterangan" cols="10" rows="5"s></textarea>
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
                    Detail Data SPL
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="detailNama" class="form-label">Nama Karyawan</label>
                    <input id="detailNama" type="text" class="form-control" placeholder="Nama User" readonly />
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="detailTglSPL" class="form-label">Tanggal SPL</label>
                            <input id="detailTglSPL" type="text" class="form-control" readonly />
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="detailJamMulai" class="form-label">Jam Mulai</label>
                            <input id="detailJamMulai" type="text" class="form-control" readonly />
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="detailJamAkhir" class="form-label">Jam Akhir</label>
                            <input id="detailJamAkhir" type="text" class="form-control" readonly />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="detailKeterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="detailKeterangan" cols="10" rows="5" readonly></textarea>
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

<!-- Modal Upload Data -->
<div class="modal fade modal-borderless text-left" id="modalUpload" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="myModalLabel160">
                    Upload File SPL
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="uploadSPL" method="POST" data-parsley-validate>
                    <input id="uploadId" type="text" class="form-control" hidden />
                    <input id="oldFile" type="text" class="form-control" hidden />
                    <input id="idKaryawan" type="text" class="form-control" hidden />
                    <input id="uploadTgl" type="text" class="form-control" hidden />
                    <div class="form-group mandatory">
                        <label for="uploadFile" class="form-label">File SPL</label>
                        <input id="uploadFile" type="file" accept=".pdf" class="form-control"
                            aria-describedby="fileHelp" required />
                        <div id="fileHelp" class="form-text text-danger"><b>*Upload File SPL harus dalam format pdf
                                dengan ukuran maksimal 200 kb*</b></div>
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
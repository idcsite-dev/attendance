<!-- Modal Tambah Data -->
<div class="modal fade modal-borderless text-left" id="modalAdd" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Tambah Data Hari Libur
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addHariLibur" method="POST" data-parsley-validate>
                    <div class="form-group mandatory">
                        <label for="tanggalLibur" class="form-label">Tanggal Hari Libur</label>
                        <input id="tanggalLibur" type="date" class="form-control" required />
                    </div>
                    <div class="form-group mandatory">
                        <label for="kategoriLibur" class="form-label">Kategori Hari Libur</label>
                        <select class="form-select" id="kategoriLibur" required>
                            <option value="">PILIH KATEGORI LIBUR</option>
                            <option value="PH">PUBLIC HOLIDAY</option>
                            <option value="PHH">PUBLIC HOLIDAY HALF</option>
                            <option value="PHD">PUBLIC HOLIDAY DAY</option>
                            <option value="PHN">PUBLIC HOLIDAY NIGHT</option>
                        </select>
                    </div>
                    <div class="form-group mandatory d-none" id="formJamKerja">
                        <label for="jamKerja" class="form-label">Jam Mulai Kerja</label>
                        <input id="jamKerja" type="time" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="keteranganLibur" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keteranganLibur" cols="10" rows="5"></textarea>
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
                    Edit Data Hari Libur
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="updateHariLibur" method="POST" data-parsley-validate>
                    <input id="updateId" type="text" class="form-control" hidden />
                    <div class="form-group mandatory">
                        <label for="updateTanggalLibur" class="form-label">Tanggal Hari Libur</label>
                        <input id="updateTanggalLibur" type="date" class="form-control" required />
                    </div>
                    <div class="form-group mandatory">
                        <label for="updateKategoriLibur" class="form-label">Kategori Hari Libur</label>
                        <select class="form-select" id="updateKategoriLibur" required>
                            <option value="">PILIH KATEGORI LIBUR</option>
                            <option value="PH">PUBLIC HOLIDAY</option>
                            <option value="PHH">PUBLIC HOLIDAY HALF</option>
                            <option value="PHD">PUBLIC HOLIDAY DAY</option>
                            <option value="PHN">PUBLIC HOLIDAY NIGHT</option>
                        </select>
                    </div>
                    <div class="form-group mandatory d-none" id="updateFormJamKerja">
                        <label for="updateJamKerja" class="form-label">Jam Mulai Kerja</label>
                        <input id="updateJamKerja" type="time" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="updateKeteranganLibur" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="updateKeteranganLibur" cols="10" rows="5"></textarea>
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
                    Detail Data Hari Libur
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="detailJam" class="form-label">Jam Mulai Kerja</label>
                    <input id="detailJam" type="time" class="form-control" readonly />
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
<!-- Modal Tambah Data -->
<div class="modal fade modal-borderless text-left" id="modalAdd" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Tambah Data Keterangan
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addKeterangan" method="POST" data-parsley-validate>
                    <div class="form-group mandatory">
                        <label for="kode" class="form-label">Kode Keterangan</label>
                        <input id="kode" type="text" class="form-control" required />
                    </div>
                    <div class="form-group mandatory">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" required>
                            <option value="">-- PILIH STATUS --</option>
                            <option value="TETAP">TETAP</option>
                            <option value="LEMBUR">LEMBUR</option>
                            <option value="TUNJANGAN TIDAK TETAP">TUNJANGAN TIDAK TETAP</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input id="keterangan" type="text" class="form-control" />
                    </div>
                    <div class="form-group mandatory">
                        <label for="jenis" class="form-label">Jenis Keterangan</label>
                        <select class="form-select" id="jenis" required>
                        </select>
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
                    Edit Data Keterangan
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="updateKeterangan" method="POST" data-parsley-validate>
                    <input id="updateId" type="text" class="form-control" hidden />
                    <div class="form-group mandatory">
                        <label for="updateKode" class="form-label">Kode Keterangan</label>
                        <input id="updateKode" type="text" class="form-control" required />
                    </div>
                    <div class="form-group mandatory">
                        <label for="updateStatus" class="form-label">Status</label>
                        <select class="form-select" id="updateStatus" required>
                            <option value="">-- PILIH STATUS --</option>
                            <option value="TETAP">TETAP</option>
                            <option value="LEMBUR">LEMBUR</option>
                            <option value="TUNJANGAN TIDAK TETAP">TUNJANGAN TIDAK TETAP</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="updateDataKeterangan" class="form-label">Keterangan</label>
                        <input id="updateDataKeterangan" type="text" class="form-control" />
                    </div>
                    <div class="form-group mandatory">
                        <label for="updateJenis" class="form-label">Jenis Keterangan</label>
                        <select class="form-select" id="updateJenis" required>
                            <option value="">-- PILIH JENIS KETERANGAN --</option>
                        </select>
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
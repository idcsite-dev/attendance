<!-- Modal Tambah Data -->
<div class="modal fade modal-borderless text-left" id="modalAdd" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Tambah Data Jenis
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addJenisKeterangan" method="POST" data-parsley-validate>
                    <div class="form-group mandatory">
                        <label for="jenisData" class="form-label">Nama Jenis Data</label>
                        <input id="jenisData" type="text" class="form-control" required />
                    </div>
                    <div class="form-group mandatory">
                        <label for="operatorJenis" class="form-label">Operator</label>
                        <input id="operatorJenis" type="text" class="form-control" required />
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
                    Edit Data Jenis
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="updateJenisKeterangan" method="POST" data-parsley-validate>
                    <input id="updateId" type="text" class="form-control" hidden />
                    <div class="form-group mandatory">
                        <label for="updateJenisData" class="form-label">Nama Jenis Data</label>
                        <input id="updateJenisData" type="text" class="form-control" required />
                    </div>
                    <div class="form-group mandatory">
                        <label for="updateOperatorJenis" class="form-label">Operator</label>
                        <input id="updateOperatorJenis" type="text" class="form-control" required />
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
<table class="table" id="table1">
    <thead>
        <tr>
            <th class="text-center align-middle">No.</th>
            <th class="align-middle">Jenis Data</th>
            <th class="align-middle">Operator</th>
            <th class="text-center align-middle">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($jenis_keterangan)) {
                $n = 1;
                foreach ($jenis_keterangan as $data) { ?>
        <tr>
            <td class="text-center align-middle text-nowrap"><?= $n++.'.' ?></td>
            <td class="align-middle text-nowrap"><?= $data['jenis_ket'] ?></td>
            <td class="align-middle text-nowrap"><?= $data['stat_operator'] ?></td>
            <td class="text-center align-middle text-nowrap">
                <button type="button" id="<?= $data['id_jenis_ket'] ?>" class="btn btn-warning font-bold tooltips updateData"
                    data-bs-placement="top" title="Edit Data"><i class="bi bi-pencil-square"></i></button>
                <button type="button" id="<?= $data['id_jenis_ket'] ?>"
                    class="btn btn-danger font-bold tooltips deleteData" data-bs-placement="top" title="Hapus Data"><i
                        class="bi bi-trash"></i></button>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>
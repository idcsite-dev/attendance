<table class="table" id="table1">
    <thead>
        <tr>
            <th class="text-center align-middle text-nowrap">No.</th>
            <th class="align-middle text-nowrap">NIK</th>
            <th class="align-middle text-nowrap">Nama Karyawan</th>
            <th class="align-middle text-nowrap">Departemen</th>
            <th class="text-center align-middle">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($karyawan)) {
                $n = 1;
                foreach ($karyawan as $data) { ?>
        <tr>
            <td class="text-center align-middle"><?= $n++.'.' ?></td>
            <td class="align-middle"><?= $data['no_nik'] ?></td>
            <td class="align-middle"><?= $data['nama_lengkap'] ?></td>
            <td class="align-middle"><?= $data['depart'] ?></td>
            <td class="text-center align-middle">
                <button type="button" id="<?= $data['id_kary'] ?>" class="btn btn-success font-bold tooltips detailData"
                    data-bs-placement="top" title="Detail"><i class="bi bi-info-circle"></i></button>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>
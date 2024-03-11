<?php 
function formatIndonesianDate($timestamp) {
    setlocale(LC_TIME, 'id_ID');

    $monthNames = array(
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    $formattedDate = strftime('%d %B %Y', $timestamp);

    $formattedDate = str_replace(
        array('January', 'February', 'March', 'April', 'May', 'June',
              'July', 'August', 'September', 'October', 'November', 'December'),
        $monthNames,
        $formattedDate
    );

    return $formattedDate;
}
?>
<table class="table" id="table1">
    <thead>
        <tr>
            <th class="text-center align-middle">No.</th>
            <th class="align-middle">Nama Karyawan</th>
            <th class="align-middle">Tanggal SPL</th>
            <th class="text-center align-middle">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($spl)) {
                $n = 1;
                foreach ($spl as $data) { ?>
        <tr>
            <td class="text-center align-middle text-nowrap"><?= $n++.'.' ?></td>
            <td class="align-middle text-nowrap"><?= $data['nama_lengkap'] ?></td>
            <td class="align-middle text-nowrap"><?= formatIndonesianDate(strtotime($data['tgl_spl'])) ?></td>
            <td class="text-center align-middle text-nowrap">
                <button type="button" id="<?= $data['id_spl'] ?>" class="btn btn-success font-bold tooltips detailData"
                    data-bs-placement="top" title="Detail"><i class="bi bi-info-circle"></i></button>
                <button type="button" id="<?= $data['id_spl'] ?>" class="btn btn-warning font-bold tooltips updateData"
                    data-bs-placement="top" title="Edit Data"><i class="bi bi-pencil-square"></i></button>
                <button type="button" target="_blank" id="<?= $data['id_spl'] ?>" class="btn btn-info font-bold tooltips showFile"
                    data-bs-placement="top" title="Buka File"><i class="bi bi-filetype-pdf"></i></button>
                <button type="button" id="<?= $data['id_spl'] ?>" class="btn btn-info font-bold tooltips uploadData"
                    data-bs-placement="top" title="Upload File"><i class="bi bi-upload"></i></button>
                <button type="button" id="<?= $data['id_spl'] ?>"
                    class="btn btn-danger font-bold tooltips deleteData" data-bs-placement="top" title="Hapus Data"><i
                        class="bi bi-trash"></i></button>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>
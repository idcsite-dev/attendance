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
            <th class="align-middle">Tanggal</th>
            <th class="text-center align-middle">Kategori</th>
            <th class="align-middle">Keterangan</th>
            <th class="align-middle">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($hari_libur)) {
                $n = 1;
                foreach ($hari_libur as $data) { ?>
        <tr>
            <td class="text-center align-middle text-nowrap"><?= $n++.'.' ?></td>
            <td class="align-middle text-nowrap"><?= formatIndonesianDate(strtotime($data['tgl_hari_libur'])) ?></td>
            <td class="text-center align-middle text-nowrap">
                <?php
                if ($data['stat_lembur'] == 'PH') {
                    echo '<span class="btn btn-success tooltips" data-bs-placement="top" title="PUBLIC HOLIDAY"><i class="bi bi-calendar-check"></i></span>';
                } elseif ($data['stat_lembur'] == 'PHH') {
                    echo '<span class="btn btn-danger tooltips" data-bs-placement="top" title="PUBLIC HOLIDAY HALF"><i class="bi bi-calendar-x"></i></span>';
                } elseif ($data['stat_lembur'] == 'PHD') {
                    echo '<span class="btn btn-warning tooltips" data-bs-placement="top" title="PUBLIC HOLIDAY DAY"><i class="bi bi-sun"></i></span>';
                } else {
                    echo '<span class="btn btn-secondary tooltips" data-bs-placement="top" title="PUBLIC HOLIDAY NIGHT"><i class="bi bi-moon"></i></span>';
                }
                ?>
            </td>
            <td class="align-middle text-nowrap"><?= $data['ket_hari_libur'] ?></td>
            <td class="align-middle text-nowrap">
                <button type="button" id="<?= $data['id_hari_libur'] ?>" class="btn btn-success font-bold tooltips detailData <?= $data['stat_lembur'] != 'PHH' ? 'd-none' : '' ?>"
                    data-bs-placement="top" title="Detail"><i class="bi bi-info-circle"></i></button>
                <button type="button" id="<?= $data['id_hari_libur'] ?>" class="btn btn-warning font-bold tooltips updateData"
                    data-bs-placement="top" title="Edit Data"><i class="bi bi-pencil-square"></i></button>
                <button type="button" id="<?= $data['id_hari_libur'] ?>"
                    class="btn btn-danger font-bold tooltips deleteData" data-bs-placement="top" title="Hapus Data"><i
                        class="bi bi-trash"></i></button>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>
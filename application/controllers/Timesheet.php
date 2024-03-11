<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include library PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Timesheet extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->authentication()) {
            redirect('login_view');
        }
    }

    public function index()
    {
        $this->load->view('data_master/timesheet/view');
    }

    public function tb_timesheet()
    {
        $periode = trim(htmlspecialchars($this->input->get('q', true)));

        // $periode = '12|2023';
        if ($periode != "0") {
            $periode = explode('|', $periode);
            $bln = $periode[0];
            $tahun = $periode[1];
        } else {
            $periode = "";
            $bln = 0;
            $tahun = 0;
        }

        $dt_ts = $this->ts->get_data_ts_by_bulan($bln, $tahun);

        $timesheet = $dt_ts;
        $source = 'tb_ket_kerja';
        $field = 'kode_ket_kerja';

        if (!empty($timesheet)) {
            foreach ($timesheet as &$entry) {
                if (is_object($entry)) {
                    $entry = (array) $entry;
                }

                for ($k = 1; $k <= 31; $k++) {
                    $value = $entry['t' . $k];
                    $icon = $this->scd->readSpecificData($source, $field, $value);
                    if (!empty($icon) && isset($icon[0]['icon_ket_kerja'])) {
                        $entry['t' . $k] = $icon[0]['icon_ket_kerja'];
                    } else {
                        $entry['t' . $k] = '';
                    }
                }
            }
        }

        $data['dt_ts'] = $timesheet;
        $data['bln'] = $bln;
        $data['tahun'] = $tahun;
        $data['periode'] = $periode;
        $this->load->view('data_master/timesheet/tb_timesheet', $data);
    }

    public function import_excel()
    {

        if (isset($_FILES["fileExcel"]["name"])) {
            $path = $_FILES["fileExcel"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                //check data karyawan sebelum upload timesheet

                for ($row = 6; $row <= $highestRow; $row++) {
                    $no_nik = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $nama = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $dt_kary = $this->ts->read_data_by_nik($no_nik);
                    if (empty($dt_kary)) {
                        echo json_encode(['statusCode' => 404, 'pesan' => 'Data karyawan dengan NRP : ' . $no_nik . ', Nama : ' . $nama . ',  Baris ke : ' . $highestRow . ', tidak ditemukan pada database karyawan, hubungi admin HR']);
                        die;
                    }
                }

                //upload timesheet
                for ($row = 6; $row <= $highestRow; $row++) {
                    $no_nik = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $dt_kary = $this->ts->read_data_by_nik($no_nik);
                    if (!empty($dt_kary)) {
                        $id_kary = $dt_kary->id_kary;
                        $bulan = date('t', strtotime($worksheet->getCellByColumnAndRow(6, 5)->getValue()));
                        $bln = date('m', strtotime($worksheet->getCellByColumnAndRow(6, 5)->getValue()));
                        $tahun = date('Y', strtotime($worksheet->getCellByColumnAndRow(6, 5)->getValue()));
                        $dt_att = $this->ts->read_data_in_bulan($id_kary, $bln, $tahun);
                        // hanya memproses jika timesheet karyawan belum ada
                        if (empty($dt_att)) {
                            $data = array();
                            $i = 1;
                            $data['id_kary'] = $id_kary;
                            $data['tahun'] = $tahun;

                            for ($i == 1; $i <= ($bulan); $i++) {
                                $kalker = $worksheet->getCellByColumnAndRow(($i + 5), $row)->getValue();
                                if ($kalker == "") {
                                    $data["t$i"] = 'KSG';
                                } else {
                                    $data["t$i"] = $kalker;
                                }
                            }

                            // echo json_encode([$data]);
                            // die;

                            $insert = $this->ts->insert($data, $bln);
                        }
                    }
                }
            }

            redirect($_SERVER['HTTP_REFERER']);
        } else {
            echo "Tidak ada file yang masuk";
        }
    }

    public function export_excel()
    {
        $depart = $this->session->userdata('departemen');
        $periode = trim(htmlspecialchars($this->input->get('q', true)));
        $periode = explode('|', $periode);
        $bln = $periode[0];
        $bln = sprintf("%02d", $bln);
        $tgl_start = sprintf("%02d", '1');
        $tahun = $periode[1];
        $tgl_start = $tahun . '-' . $bln . '-' . $tgl_start;
        $bth = strtoupper(date('M Y', strtotime($tgl_start)));
        $bt = date('MY', strtotime($tgl_start));
        $total_tgl = date('t', strtotime($tgl_start));
        $tgl_akhir = $tahun . '-' . $bln . '-' . $total_tgl;
        $tgl_start = strtotime($tgl_start . ' 12:00');
        $tgl_akhir = strtotime($tgl_akhir . ' 12:00');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border left dengan garis tipis
            ],
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border left dengan garis tipis
            ],
        ];
        $sheet->setCellValue('A1', "PT UNGGUL DINAMIKA UTAMA"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->setCellValue('A2', $depart); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->setCellValue('A3', "DATA PLAN KEHADIRAN " . $bth); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->setCellValue('A4', ""); // Set kolom A1 dengan tulisan "DATA SISWA"
        // $sheet->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('A2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('A3')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('A1')->getFont()->setSize(20); // Set bold kolom A1
        $sheet->getStyle('A2')->getFont()->setSize(18); // Set bold kolom A1
        $sheet->getStyle('A3')->getFont()->setSize(14); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A5', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B5', "NIK"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('C5', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('D5', "DEPARTEMEN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('E5', "POSISI"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('F5', "TIPE"); // Set kolom E3 dengan tulisan "ALAMAT"

        $col = 'G';
        for ($i = $tgl_start; $i <= $tgl_akhir; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i); // 2010-05-01, 2010-05-02, etc
            $sheet->setCellValue($col . '5', $thisDate); // Set kolom E3 dengan tulisan "ALAMAT"
            ++$col;
        }

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A5')->applyFromArray($style_col);
        $sheet->getStyle('B5')->applyFromArray($style_col);
        $sheet->getStyle('C5')->applyFromArray($style_col);
        $sheet->getStyle('D5')->applyFromArray($style_col);
        $sheet->getStyle('E5')->applyFromArray($style_col);
        $sheet->getStyle('F5')->applyFromArray($style_col);
        $col = 'G';
        for ($i = $tgl_start; $i <= $tgl_akhir; $i = $i + 86400) {
            $sheet->getStyle($col . '5')->applyFromArray($style_col);
            ++$col;
        }
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $catdata = $this->kary->read_all_data($depart);
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($catdata as $data) { // Lakukan looping pada variabel siswa
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data->no_nik);
            $sheet->setCellValue('C' . $numrow, $data->nama_lengkap);
            $sheet->setCellValue('D' . $numrow, $data->depart);
            $sheet->setCellValue('E' . $numrow, $data->posisi);
            $sheet->setCellValue('F' . $numrow, $data->tipe);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $col = 'G';
            for ($i = $tgl_start; $i <= $tgl_akhir; $i = $i + 86400) {
                $sheet->getStyle($col . $numrow)->applyFromArray($style_row);
                ++$col;
            }

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(30); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(40); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(60); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(20); // Set width kolom E
        $col = 'G';
        for ($i = $tgl_start; $i <= $tgl_akhir; $i = $i + 86400) {
            $sheet->getColumnDimension($col)->setWidth(15); // Set width kolom E
            ++$col;
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Data timesheet " . $bth);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="DataTimesheet' . $bt . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
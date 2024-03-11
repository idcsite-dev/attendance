<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include library PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Jadwal_download extends MY_Controller
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
        $this->load->view('data_master/jadwal_download/view');
    }

    public function dataTables()
    {
        $source = 'tb_jadwal_download';
        $field = 'jadwal_download';
        $orderValue = 'ASC';
        $data = $this->std->readDataOrderDelDate($source, $field, $orderValue);
        $data['jadwal'] = $data;
        $this->load->view('data_master/jadwal_download/table', $data);
    }

    public function import()
    {
        $source = 'tb_jadwal_download';
        $checkData = $this->std->readData($source);
        if (!empty($checkData)) {
            $clearData = $this->std->deleteAll($source);
            if (!$clearData) {
                echo json_encode(array('statusCode' => 400, 'pesan' => 'Gagal Import Data!'));
                return;
            }
        }
        $path = $_FILES["importFile"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        $sourceKaryawan = 'tb_kary';
        $field = 'no_nik';
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $no = 1;

            for ($row = 6; $row <= $highestRow; $row++) {
                $no_nik = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $gaji_pokok = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                if (!empty($gaji_pokok)) {
                    $dataKaryawan = $this->std->readSpecificData($sourceKaryawan, $field, $no_nik);
                    $idKaryawan = $dataKaryawan[0]['id_kary'];
                    $data = [
                        'id_jadwal_download' => $no,
                        'id_kary' => $idKaryawan,
                        'gaji_pokok' => $gaji_pokok,
                        'tgl_buat' => date('Y-m-d H:i:s'),
                        'tgl_edit' => '1970-01-01 00:00:00',
                        'tgl_hapus' => '1970-01-01 00:00:00',
                        'id_user' => $this->session->userdata('id_user'),
                    ];
                    $this->std->createData($source, $data);
                    $no++;
                }
            }
        }
        echo json_encode(array('statusCode' => 200, 'pesan' => 'Import Data Kenaikan gaji Berhasil'));
    }

    public function sample()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ];

        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ];
        $sheet->setCellValue('A1', "PT UNGGUL DINAMIKA UTAMA");
        $sheet->setCellValue('A2', "ALL DEPARTEMEN");
        $sheet->setCellValue('A3', "DATA GAJI KARYAWAN");
        $sheet->setCellValue('A4', "");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(20);
        $sheet->getStyle('A2')->getFont()->setSize(18);
        $sheet->getStyle('A3')->getFont()->setSize(14);

        $sheet->setCellValue('A5', "NO");
        $sheet->setCellValue('B5', "NIK");
        $sheet->setCellValue('C5', "NAMA");
        $sheet->setCellValue('D5', "DEPARTEMEN");
        $sheet->setCellValue('E5', "POSISI");
        $sheet->setCellValue('F5', "TIPE");
        $sheet->setCellValue('G5', "GAJI POKOK");

        $sheet->getStyle('A5')->applyFromArray($style_col);
        $sheet->getStyle('B5')->applyFromArray($style_col);
        $sheet->getStyle('C5')->applyFromArray($style_col);
        $sheet->getStyle('D5')->applyFromArray($style_col);
        $sheet->getStyle('E5')->applyFromArray($style_col);
        $sheet->getStyle('F5')->applyFromArray($style_col);
        $sheet->getStyle('G5')->applyFromArray($style_col);

        $source = 'tb_jadwal_download';
        $dataKaryawan = $this->std->readData($source);
        $no = 1;
        $numrow = 6;
        foreach ($dataKaryawan as $data) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['no_nik']);
            $sheet->setCellValue('C' . $numrow, $data['nama_lengkap']);
            $sheet->setCellValue('D' . $numrow, $data['depart']);
            $sheet->setCellValue('E' . $numrow, $data['posisi']);
            $sheet->setCellValue('F' . $numrow, $data['tipe']);
            $sheet->setCellValue('G' . $numrow, $data['gaji_pokok']);

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Sample Import Gaji");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="SampleImportGajiKaryawan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_jadwal_download';
        $field = 'id_jadwal_download';
        $result = $this->std->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id' => $result[0]['id_jadwal_download'],
                'jam' => $result[0]['jadwal_download'],
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function create()
    {
        $jam = htmlspecialchars($this->input->post("jam", true));

        $sourceJadwal = 'tb_jadwal_download';
        $checkId = 'jadwal_download';
        $dataJadwal = $this->std->readSpecificData($sourceJadwal, $checkId, $jam);
        if (!empty($dataJadwal)) {
            echo json_encode(array('statusCode' => 404, 'pesan' => 'Jam Download sudah ada!'));
            return;
        }

        $data = array(
            'jadwal_download' => $jam,
            'status_jadwal_download' => 'T',
            'tgl_buat' => date('Y-m-d H:i:s'),
            'tgl_edit' => '1970-01-01 00:00:00',
            'tgl_hapus' => '1970-01-01 00:00:00',
            'id_user' => $this->session->userdata('id_user'),
        );
        $source = 'tb_jadwal_download';
        $result = $this->std->createData($source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 201, 'pesan' => 'Jadwal download berhasil ditambahkan!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jadwal download gagal ditambahkan!'));
        }
    }

    public function update()
    {
        $id = trim(htmlspecialchars($this->input->post("id", true)));
        $jam = trim(htmlspecialchars($this->input->post("jam", true)));

        $source = 'tb_jadwal_download';
        $field = 'jadwal_download';
        $value = $jam;
        $field2 = 'id_jadwal_download !=';
        $value2 = $id;
        $dtjam = $this->std->readSpecificData2($source, $field, $value, $field2, $value2);
        if (!empty($dtjam)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jam download sudah ada!'));
            die;
        }

        $data = array(
            'jadwal_download' => $jam,
            'tgl_edit' => date('Y-m-d H:i:s'),
        );

        $source = 'tb_jadwal_download';
        $field = 'id_jadwal_download';
        $result = $this->std->updateData($field, $id, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Jadwal download berhasil diedit!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jadwal download gagal diedit!'));
        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_jadwal_download';
        $field = 'id_jadwal_download';
        $value = $id;
        $data = array(
            'tgl_hapus' => date('Y-m-d H:i:s'),
        );

        $dtJadwal = $this->std->readSpecificData($source, $field, $id);
        if (empty($dtJadwal)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
            die;
        }

        $result = $this->std->deleteDataSoft($source, $field, $value, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Jadwal download berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jadwal download gagal dihapus!'));
        }
    }
}
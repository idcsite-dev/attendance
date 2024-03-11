<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include library PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Jam_kerja extends MY_Controller
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
        $this->load->view('data_master/jam_kerja/view');
    }

    public function dataTables()
    {
        $source = 'vw_att';
        $data = $this->std->readData($source);
        $data['att'] = $data;
        $this->load->view('data_master/jam_kerja/table', $data);
    }

    public function import()
    {
        $source = 'tb_att';
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
                $jam_kerja = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                if (!empty($jam_kerja)) {
                    $dataKaryawan = $this->std->readSpecificData($sourceKaryawan, $field, $no_nik);
                    $idKaryawan = $dataKaryawan[0]['id_kary'];
                    $data = [
                        'id_att' => $no,
                        'id_kary' => $idKaryawan,
                        'jam_kerja' => $jam_kerja,
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
        echo json_encode(array('statusCode' => 200, 'pesan' => 'Import Data Jam Kerja Berhasil'));
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

        $source = 'vw_att';
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
            $sheet->setCellValue('G' . $numrow, $data['jam_kerja']);

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
        $sheet->setTitle("Sample Import Jam Kerja");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="SampleImportJamKerjaKaryawan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'vw_att';
        $field = 'id_att';
        $result = $this->std->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id' => $result[0]['id_att'],
                'nik' => $result[0]['no_nik'],
                'att' => $result[0]['jam_kerja'],
                'nama' => $result[0]['nama_lengkap'],
                'departemen' => $result[0]['depart'],
                'posisi' => $result[0]['posisi'],
                'npwp' => $result[0]['no_npwp'],
                // 'level' => $result[0]['level'],
                // 'golongan' => $result[0]['tipe'],
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function create()
    {
        $jam_kerja = htmlspecialchars(str_replace(",", "", $this->input->post("att", true)));
        $id_karyawan = htmlspecialchars($this->input->post("id_karyawan", true));

        $data = array(
            'id_kary' => $id_karyawan,
            'jam_kerja' => $jam_kerja,
            'tgl_buat' => date('Y-m-d H:i:s'),
            'tgl_edit' => '1970-01-01 00:00:00',
            'tgl_hapus' => '1970-01-01 00:00:00',
            'id_user' => $this->session->userdata('id_user'),
        );
        $source = 'tb_att';
        $result = $this->std->createData($source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 201, 'pesan' => 'Jam Kerja berhasil ditambahkan!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jam Kerja gagal ditambahkan!'));
        }
    }

    public function update()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $att = htmlspecialchars(str_replace(",", "", $this->input->post("att", true)));

        $data = array(
            'jam_kerja' => $att,
            'tgl_edit' => date('Y-m-d H:i:s'),
        );
        $source = 'tb_att';
        $field = 'id_att';
        $result = $this->std->updateData($field, $id, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Jam Kerja berhasil diedit!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jam Kerja gagal diedit!'));
        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_att';
        $field = 'id_att';
        $result = $this->std->deleteData($source, $field, $id);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Jam Kerja berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jam Kerja gagal dihapus!'));
        }
    }
}
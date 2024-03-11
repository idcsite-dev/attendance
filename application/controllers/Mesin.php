<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include library PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Mesin extends MY_Controller
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
        $this->load->view('data_master/mesin/view');
    }

    public function dataTables()
    {
        $source = 'vw_mesin';
        $data = $this->msn->read_all_data($source);
        $data['mesin'] = $data;
        $this->load->view('data_master/mesin/table', $data);
    }

    public function import()
    {
        $source = 'tb_payroll_detail';
        $path = $_FILES["importFile"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $no = 1;

            for ($row = 6; $row <= $highestRow; $row++) {
                $id_payroll_kary = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $no_nik = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $nilai = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                if (!is_numeric($nilai)) {
                    $nilai = 0;
                }

                $data = [
                    'id_payroll_kary' => $id_payroll_kary,
                    'id_tambahan' => 16,
                    'nilai' => $nilai,
                ];

                $query = $this->std->createData($source, $data);
                if ($query) {
                    $dtkary = $this->payroll->read_data_kary_payroll_mesin($id_payroll_kary);
                    $tdkttp = intval($nilai) + intval($dtkary->total_tunj_tidak_tetap);

                    $dttunj = [
                        'total_tunj_tidak_tetap' => $tdkttp,
                    ];

                    $this->payroll->update_lembur($dttunj, $id_payroll_kary);
                }

                $no++;
            }
        }

        echo json_encode(array('statusCode' => 200, 'pesan' => 'Import Data Mesin Berhasil'));
    }

    public function sample()
    {
        $bulan = htmlspecialchars($this->input->get('bln'));
        $tahun = htmlspecialchars($this->input->get('thn'));

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
        $sheet->setCellValue('A3', "DATA INSENTIF KARYAWAN");
        $sheet->setCellValue('A4', "");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(20);
        $sheet->getStyle('A2')->getFont()->setSize(18);
        $sheet->getStyle('A3')->getFont()->setSize(14);

        $sheet->setCellValue('A5', "NO");
        $sheet->setCellValue('B5', "ID");
        $sheet->setCellValue('C5', "NIK/NRP");
        $sheet->setCellValue('D5', "NAMA");
        $sheet->setCellValue('E5', "DEPARTEMEN");
        $sheet->setCellValue('F5', "POSISI");
        $sheet->setCellValue('G5', "TIPE");
        $sheet->setCellValue('H5', "BULAN");
        $sheet->setCellValue('I5', "TAHUN");
        $sheet->setCellValue('J5', "NILAI INSENTIF");

        $sheet->getStyle('A5')->applyFromArray($style_col);
        $sheet->getStyle('B5')->applyFromArray($style_col);
        $sheet->getStyle('C5')->applyFromArray($style_col);
        $sheet->getStyle('D5')->applyFromArray($style_col);
        $sheet->getStyle('E5')->applyFromArray($style_col);
        $sheet->getStyle('F5')->applyFromArray($style_col);
        $sheet->getStyle('G5')->applyFromArray($style_col);
        $sheet->getStyle('H5')->applyFromArray($style_col);
        $sheet->getStyle('I5')->applyFromArray($style_col);
        $sheet->getStyle('J5')->applyFromArray($style_col);

        $source = 'vw_payroll_kary';
        $dataKaryawan = $this->payroll->read_data_mesin($source, $bulan, $tahun);
        $no = 1;
        $numrow = 6;
        foreach ($dataKaryawan as $data) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data->id_payroll_kary);
            $sheet->setCellValue('C' . $numrow, $data->no_nik);
            $sheet->setCellValue('D' . $numrow, $data->nama_lengkap);
            $sheet->setCellValue('E' . $numrow, $data->depart);
            $sheet->setCellValue('F' . $numrow, $data->posisi);
            $sheet->setCellValue('G' . $numrow, $data->tipe);
            $sheet->setCellValue('H' . $numrow, $bulan);
            $sheet->setCellValue('I' . $numrow, $tahun);
            $sheet->setCellValue('J' . $numrow, 0);

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(60);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Sample Import Mesin");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ImportMesinKaryawan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'vw_mesin';
        $field = 'id_mesin';
        $result = $this->std->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id_mesin' => $result[0]['id_mesin'],
                'kd_mesin' => $result[0]['kd_mesin'],
                'tipe_mesin' => $result[0]['tipe_mesin'],
                'lokasi_mesin' => $result[0]['lokasi_mesin'],
                'ip_mesin' => $result[0]['ip_mesin'],
                'port_mesin' => $result[0]['port_mesin'],
                'status_mesin' => $result[0]['status_mesin'],
                'status_konek' => $result[0]['status_konek'],
                'status_tarik' => $result[0]['status_tarik'],
                'koneksike' => $result[0]['koneksike'],
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function create()
    {
        $kodemesin = trim(htmlspecialchars($this->input->post("kodemesin", true)));
        $tipemesin = trim(htmlspecialchars($this->input->post("tipemesin", true)));
        $ipaddress = trim(htmlspecialchars($this->input->post("ipaddress", true)));
        $port = trim(htmlspecialchars($this->input->post("port", true)));
        $lokasimesin = trim(htmlspecialchars($this->input->post("lokasimesin", true)));
        $stat_download = trim(htmlspecialchars($this->input->post("stat_download", true)));

        $kdmesin = $this->msn->read_data_kode_mesin($kodemesin);
        if (!empty($kdmesin)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Mesin gagal ditambahkan!, Kode mesin sudah ada'));
            die;
        }

        $ipmesin = $this->msn->read_data_id_mesin($ipaddress);
        if (!empty($ipmesin)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Mesin gagal ditambahkan!, IP Address sudah ada'));
            die;
        }

        $data = array(
            'kd_mesin' => $kodemesin,
            'tipe_mesin' => $tipemesin,
            'lokasi_mesin' => $lokasimesin,
            'ip_mesin' => $ipaddress,
            'port_mesin' => $port,
            'status_mesin' => 'T',
            'status_konek' => 'F',
            'status_tarik' => $stat_download,
            'koneksike' => 'LOKAL',
            'tgl_buat' => date('Y-m-d H:i:s'),
            'id_user' => $this->session->userdata('id_user'),
        );

        $source = 'tb_mesin';
        $result = $this->std->createData($source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 201, 'pesan' => 'Mesin berhasil ditambahkan!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Mesin gagal ditambahkan!'));
        }
    }

    public function update()
    {
        $id = trim(htmlspecialchars($this->input->post("id", true)));
        $kodemesin = trim(htmlspecialchars($this->input->post("kodemesin", true)));
        $tipemesin = trim(htmlspecialchars($this->input->post("tipemesin", true)));
        $lokasimesin = trim(htmlspecialchars($this->input->post("lokasimesin", true)));
        $port = trim(htmlspecialchars($this->input->post("port", true)));
        $ipaddress = trim(htmlspecialchars($this->input->post("ipaddress", true)));
        $stat_download = trim(htmlspecialchars($this->input->post("stat_download", true)));

        //cek kode mesin
        $source = 'tb_mesin';
        $field = 'kd_mesin';
        $value = $kodemesin;
        $field2 = 'id_mesin !=';
        $value2 = $id;
        $dtjam = $this->std->readSpecificData2($source, $field, $value, $field2, $value2);
        if (!empty($dtjam)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Kode mesin sudah ada!'));
            die;
        }

        //cek ip address
        $source = 'tb_mesin';
        $field = 'ip_mesin';
        $value = $ipaddress;
        $field2 = 'id_mesin !=';
        $value2 = $id;
        $dtjam = $this->std->readSpecificData2($source, $field, $value, $field2, $value2);
        if (!empty($dtjam)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Ip Address sudah ada!'));
            die;
        }

        // echo json_encode([$ipaddress]);
        // die;

        $data = array(
            'kd_mesin' => $kodemesin,
            'tipe_mesin' => $tipemesin,
            'lokasi_mesin' => $lokasimesin,
            'ip_mesin' => $ipaddress,
            'port_mesin' => $port,
            'status_tarik' => $stat_download,
            'tgl_edit' => date('Y-m-d H:i:s'),
        );

        $source = 'tb_mesin';
        $field = 'id_mesin';
        $result = $this->std->updateData($field, $id, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Mesin berhasil diedit!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Mesin gagal diedit!'));
        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));

        $source = 'tb_mesin';
        $field = 'id_mesin';
        $value = $id;

        $data = [
            'tgl_hapus' => date('Y-m-d H:i:S'),
        ];

        $dtdetmesin = $this->std->readSpecificData($source, $field, $value);
        if (empty($dtdetmesin)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Mesin tidak ditemukan!'));
            die;
        }

        $result = $this->std->deleteDataSoft($source, $field, $value, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Mesin berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Mesin gagal dihapus!'));
        }
    }
}
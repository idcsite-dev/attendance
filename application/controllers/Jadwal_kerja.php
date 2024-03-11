<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include library PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Jadwal_kerja extends MY_Controller
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
        $this->load->view('data_master/jadwal_kerja/view');
    }

    public function dataTables()
    {
        $source = 'tb_jadwal_kerja';
        $data = $this->std->readDataDelDate($source);
        $data['jadwal_kerja'] = $data;
        $this->load->view('data_master/jadwal_kerja/table', $data);
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
        $sheet->setCellValue('A3', "DATA PPH KARYAWAN");
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
        $sheet->setCellValue('J5', "NILAI PPH");

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
        $dataKaryawan = $this->payroll->read_data_insentif($source, $bulan, $tahun);
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
        $sheet->setTitle("Sample Import PPH");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ImportPPHKaryawan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_jadwal_kerja';
        $field = 'id_jadwal_kerja';
        $result = $this->std->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id' => $result[0]['id_jadwal_kerja'],
                'kode' => $result[0]['kode_jadwal_kerja'],
                'jadwalkerja' => $result[0]['jadwal_kerja'],
                'jammasuk' => $result[0]['jam_masuk'],
                'jampulang' => $result[0]['jam_pulang'],
                'toleransi' => $result[0]['waktu_toleransi'],
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function create()
    {
        $kodejadwalkerja = htmlspecialchars($this->input->post("kodejadwalkerja", true));
        $jadwalkerja = htmlspecialchars($this->input->post("jadwalkerja", true));
        $jammasuk = htmlspecialchars($this->input->post("jammasuk", true));
        $jampulang = htmlspecialchars($this->input->post("jampulang", true));
        $toleransi = htmlspecialchars($this->input->post("toleransi", true));

        //cek kode
        $source = 'tb_jadwal_kerja';
        $field = 'kode_jadwal_kerja';
        $value = $kodejadwalkerja;
        $dtjadwal = $this->std->readSpecificData($source, $field, $value);
        if (!empty($dtjadwal)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Kode jadwal kerja sudah ada!'));
            die;
        }

        //cek jadwal
        $source = 'tb_jadwal_kerja';
        $field = 'jadwal_kerja';
        $value = $jadwalkerja;
        $dtjadwal = $this->std->readSpecificData($source, $field, $value);
        if (!empty($dtjadwal)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jadwal kerja sudah ada!'));
            die;
        }

        $data = [
            'kode_jadwal_kerja' => $kodejadwalkerja,
            'jadwal_kerja' => $jadwalkerja,
            'jam_masuk' => $jammasuk,
            'jam_pulang' => $jampulang,
            'waktu_toleransi' => $toleransi,
            'status_jadwal_kerja' => 'T',
            'tgl_buat' => date('Y-m-d H:i:s'),
            'tgl_edit' => date('Y-m-d H:i:s'),
            'tgl_hapus' => '1970-01-01 00:00:00',
            'id_user' => $this->session->userdata('id_user'),
        ];

        $source = 'tb_jadwal_kerja';
        $result = $this->std->createData($source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 201, 'pesan' => 'Jadwal kerja berhasil ditambahkan!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jadwal kerja gagal ditambahkan!'));
        }
    }

    public function update()
    {
        $id = trim(htmlspecialchars($this->input->post("id", true)));
        $kodejadwalkerja = htmlspecialchars($this->input->post("kodejadwalkerja", true));
        $jadwalkerja = htmlspecialchars($this->input->post("jadwalkerja", true));
        $jammasuk = htmlspecialchars($this->input->post("jammasuk", true));
        $jampulang = htmlspecialchars($this->input->post("jampulang", true));
        $toleransi = htmlspecialchars($this->input->post("toleransi", true));

        //cek kode
        $source = 'tb_jadwal_kerja';
        $field = 'kode_jadwal_kerja';
        $value = $kodejadwalkerja;
        $field2 = 'id_jadwal_kerja !=';
        $value2 = $id;
        $dtjam = $this->std->readSpecificData2($source, $field, $value, $field2, $value2);
        if (!empty($dtjam)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Kode jadwal kerja sudah ada!'));
            die;
        }

        //cek kode
        $source = 'tb_jadwal_kerja';
        $field = 'jadwal_kerja';
        $value = $jadwalkerja;
        $field2 = 'id_jadwal_kerja !=';
        $value2 = $id;
        $dtjam = $this->std->readSpecificData2($source, $field, $value, $field2, $value2);
        if (!empty($dtjam)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jadwal kerja sudah ada!'));
            die;
        }

        $data = array(
            'kode_jadwal_kerja' => $kodejadwalkerja,
            'jadwal_kerja' => $jadwalkerja,
            'jam_masuk' => $jammasuk,
            'jam_pulang' => $jampulang,
            'waktu_toleransi' => $toleransi,
            'tgl_edit' => date('Y-m-d H:i:s'),
        );

        $source = 'tb_jadwal_kerja';
        $field = 'id_jadwal_kerja';
        $result = $this->std->updateData($field, $id, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Jadwal kerja berhasil diedit!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jadwal kerja gagal diedit!'));
        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_jadwal_kerja';
        $field = 'id_jadwal_kerja';
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
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Jadwal Kerja berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jadwal Kerja gagal dihapus!'));
        }
    }
}
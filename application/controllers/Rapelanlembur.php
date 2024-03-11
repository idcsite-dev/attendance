<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include library PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Rapelanlembur extends MY_Controller
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
        $this->load->view('data_master/rapelanlembur/view');
    }

    public function dataTables()
    {
        $source = 'vw_rapelan_lembur';
        $data = $this->rpll->read_all_data($source);
        $data['inst'] = $data;
        $this->load->view('data_master/rapelanlembur/table', $data);
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
                    'id_tambahan' => 18,
                    'nilai' => $nilai,
                ];

                $query = $this->std->createData($source, $data);
                if ($query) {
                    $dtkary = $this->payroll->read_data_kary_payroll_ins($id_payroll_kary);
                    $tdkttp = intval($nilai) + intval($dtkary->total_tunj_tidak_tetap);

                    $dttunj = [
                        'total_tunj_tidak_tetap' => $tdkttp,
                    ];

                    $this->payroll->update_lembur($dttunj, $id_payroll_kary);
                }

                $no++;
            }
        }

        echo json_encode(array('statusCode' => 200, 'pesan' => 'Import Data Rapelan Berhasil'));
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
        $sheet->setCellValue('A3', "DATA RAPELAN LEMBUR KARYAWAN");
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
        $sheet->setCellValue('J5', "NILAI RAPELAN LEMBUR");

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
        $sheet->setTitle("Sample Import Rapelan Lembur");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ImportRapelanLemburKaryawan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'vw_gaji';
        $field = 'id_gaji';
        $result = $this->std->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id' => $result[0]['id_gaji'],
                'nik' => $result[0]['no_nik'],
                'gaji' => $result[0]['gaji_pokok'],
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
        $rapelan = htmlspecialchars(str_replace(",", "", $this->input->post("rapelan", true)));
        $bulan = htmlspecialchars($this->input->post("bulan", true));
        $tahun = htmlspecialchars($this->input->post("tahun", true));
        $id_karyawan = htmlspecialchars($this->input->post("id_karyawan", true));
        $dtkary = $this->payroll->get_data_kary_detail($id_karyawan, $bulan, $tahun);

        if (empty($dtkary)) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Payroll belum diproses'));
        } else {
            $id_payroll_kary = $dtkary->id_payroll_kary;
            $total_tunj_tidak_tetap = $dtkary->total_tunj_tidak_tetap;
            $dtins = $this->payroll->read_data_detail_rpll($id_payroll_kary);

            if (!empty($dtins)) {
                echo json_encode(array('statusCode' => 400, 'pesan' => 'Rapelan gagal ditambahkan!, Data sudah ada'));
            } else {
                $data = array(
                    'id_payroll_kary' => $dtkary->id_payroll_kary,
                    'id_tambahan' => 18,
                    'nilai' => $rapelan,
                );

                $source = 'tb_payroll_detail';
                $result = $this->std->createData($source, $data);
                if ($result) {
                    $tdkttp = intval($total_tunj_tidak_tetap) + intval($rapelan);
                    $dttunj = [
                        'total_tunj_tidak_tetap' => $tdkttp,
                    ];

                    $this->payroll->update_lembur($dttunj, $id_payroll_kary);
                    echo json_encode(array('statusCode' => 201, 'pesan' => 'Rapelan berhasil ditambahkan!'));
                } else {
                    echo json_encode(array('statusCode' => 400, 'pesan' => 'Rapelan gagal ditambahkan!'));
                }
            }

        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));

        $source = 'tb_payroll_detail';
        $field = 'id_payroll_detail';
        $value = $id;

        $dtdetins = $this->payroll->read_data_det_rpll($id);
        if (!empty($dtdetins)) {
            $nilai = $dtdetins->nilai;
            $id_payroll_kary = $dtdetins->id_payroll_kary;
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Rapelan gagal dihapus!'));
            die;
        }

        $result = $this->std->deleteData($source, $field, $value);
        if ($result) {
            $dtdet = $this->payroll->read_data_kary_payroll_ins($id_payroll_kary);
            if (!empty($dtdet)) {
                $nakhir = intval($dtdet->total_tunj_tidak_tetap) - intval($nilai);
                $dtakhir = [
                    'total_tunj_tidak_tetap' => $nakhir,
                ];
            }
            $this->payroll->update_lembur($dtakhir, $id_payroll_kary);
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Rapelan berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Rapelan gagal dihapus!'));
        }
    }

    public function deleteRpl()
    {

        $bulan = htmlspecialchars($this->input->get('bln'));
        $tahun = htmlspecialchars($this->input->get('thn'));

        $result = $this->rpll->deleteRpl($bulan, $tahun);
        if ($result) {
            redirect(base_url('rapelanlembur'));
        } else {
            redirect(base_url('rapelanlembur'));
        }
    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends MY_Controller
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
        $this->load->view('data_absensi/absensi/view');
    }

    public function showFile()
    {
        $id = $this->input->get("auth");
        $source = 'tb_att_aktual';
        $field = 'id_att_aktual';
        $result = $this->scd->readSpecificData($source, $field, $id);
        if (empty($result)) {
            redirect('not_found');
        }
        $foldername = md5($result[0]['id_kary']);
        $urlFile = $result[0]['url_att_aktual'];
        if (is_file("berkas/absensi/" . $foldername . "/" . $urlFile)) {
            $tofile = realpath("berkas/absensi/" . $foldername . "/" . $urlFile);
            header('Content-Type: application/pdf');
            readfile($tofile);
        } else {
            redirect('not_found');
        }
    }

    public function dataTables()
    {
        $source = 'vw_att_aktual';
        $data = $this->scd->readData($source);
        $data['absensi'] = $data;
        $this->load->view('data_absensi/absensi/table', $data);
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'vw_att_aktual';
        $field = 'id_att_aktual';
        $result = $this->scd->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id' => $result[0]['id_att_aktual'],
                'karyawan' => $result[0]['nama_lengkap'],
                'no_nik' => $result[0]['no_nik'],
                'id_karyawan' => $result[0]['id_kary'],
                'departemen' => $result[0]['depart'],
                'posisi' => $result[0]['posisi'],
                'tipe' => $result[0]['tipe'],
                'tanggal_awal' => $result[0]['tgl_att_aktual_awal'],
                'tanggal_akhir' => $result[0]['tgl_att_aktual_akhir'],
                'keterangan_kerja' => $result[0]['id_ket_kerja'],
                'keteranganKerja' => $result[0]['ket_kerja'],
                'keterangan' => $result[0]['ket_att_aktual'],
                'file' => $result[0]['url_att_aktual'],
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function create()
    {
        $tgl_awal = htmlspecialchars($this->input->post("tgl_awal", true));
        $tgl_akhir = htmlspecialchars($this->input->post("tgl_akhir", true));
        $id_ket_kerja = htmlspecialchars($this->input->post("id_ket_kerja", true));
        $ket_att_aktual = htmlspecialchars($this->input->post("ket_att_aktual", true));
        $id_karyawan = htmlspecialchars($this->input->post("id_karyawan", true));
        $foldername = md5($id_karyawan);
        $sourceKaryawan = 'tb_kary';
        $fieldKaryawan = 'id_kary';
        $result = $this->scd->readSpecificData($sourceKaryawan, $fieldKaryawan, $id_karyawan);
        if (empty($result)) {
            echo json_encode(array('statusCode' => 404, 'pesan' => 'Karyawan tidak ditemukan!'));
        }

        $sourceKeterangan = 'tb_ket_kerja';
        $fieldKeterangan = 'id_ket_kerja';
        $data = $this->scd->readSpecificData($sourceKeterangan, $fieldKeterangan, $id_ket_kerja);
        if (empty($data)) {
            echo json_encode(array('statusCode' => 404, 'pesan' => 'Keterangan Kerja tidak ditemukan!'));
        }

        $kodeKeterangan = $data[0]['kode_ket_kerja'];
        $nama_file = $result[0]['no_nik'] . '-ATT-' . $tgl_awal . '-' . $kodeKeterangan . '-.pdf';

        if (isset($_FILES['file']) && !empty($_FILES['file']['tmp_name'])) {
            if (is_dir('./berkas/absensi/' . $foldername) == false) {
                mkdir('./berkas/absensi/' . $foldername, 0775, true);
            }
    
            if (!is_dir('./berkas/absensi/' . $foldername)) {
                echo json_encode(array('statusCode' => 400, 'pesan' => 'Folder tidak ditemukan!'));
                return;
            }
    
            $config['upload_path'] = './berkas/absensi/' . $foldername;
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 210;
            $config['file_name'] = $nama_file;
            $config['overwrite'] = true;
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload('file')) {
                echo json_encode(array('statusCode' => 400, 'pesan' => 'File Absensi gagal diupload!'));
                return;
            }
        } else {
            $nama_file = '';
        }

        $data = array(
            'id_kary' => $id_karyawan,
            'tgl_att_aktual_awal' => $tgl_awal,
            'tgl_att_aktual_akhir' => $tgl_akhir,
            'id_ket_kerja' => $id_ket_kerja,
            'stat_att_aktual' => 'T',
            'ket_att_aktual' => $ket_att_aktual,
            'url_att_aktual' => $nama_file,
            'tgl_buat' => date('Y-m-d H:i:s'),
            'tgl_edit' => '1970-01-01 00:00:00',
            'tgl_hapus' => '1970-01-01 00:00:00',
            'id_user' => $this->session->userdata('id_user'),
        );
        $source = 'tb_att_aktual';
        $result = $this->scd->createData($source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 201, 'pesan' => 'Absensi berhasil ditambahkan!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Absensi gagal ditambahkan!'));
        }
    }

    public function update()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $tgl_awal = htmlspecialchars($this->input->post("tgl_awal", true));
        $tgl_akhir = htmlspecialchars($this->input->post("tgl_akhir", true));
        $id_ket_kerja = htmlspecialchars($this->input->post("id_ket_kerja", true));
        $ket_att_aktual = htmlspecialchars($this->input->post("ket_att_aktual", true));

        $data = array(
            'tgl_att_aktual_awal' => $tgl_awal,
            'tgl_att_aktual_akhir' => $tgl_akhir,
            'id_ket_kerja' => $id_ket_kerja,
            'ket_att_aktual' => $ket_att_aktual,
            'tgl_edit' => date('Y-m-d H:i:s'),
        );
        $source = 'tb_att_aktual';
        $field = 'id_att_aktual';
        $result = $this->scd->updateData($field, $id, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Absensi berhasil diedit!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Absensi gagal diedit!'));
        }
    }

    public function upload()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $oldFile = htmlspecialchars($this->input->post("oldFile", true));
        $tanggal = htmlspecialchars($this->input->post("tanggal", true));
        $id_karyawan = htmlspecialchars($this->input->post("id_karyawan", true));
        $foldername = md5($id_karyawan);
        $sourceKaryawan = 'tb_kary';
        $fieldKaryawan = 'id_kary';
        $result = $this->scd->readSpecificData($sourceKaryawan, $fieldKaryawan, $id_karyawan);
        if (empty($result)) {
            echo json_encode(array('statusCode' => 404, 'pesan' => 'Karyawan tidak ditemukan!'));
        }

        if (empty($oldFile)) {
            $nama_file = $result[0]['no_nik'] . '-ATT-' . $tanggal . '.pdf';
        } else {
            $nama_file = $oldFile;
        }

        if (is_dir('./berkas/absensi/' . $foldername) == false) {
            mkdir('./berkas/absensi/' . $foldername, 0775, true);
        }

        if (is_dir('./berkas/absensi/' . $foldername)) {
            $config['upload_path'] = './berkas/absensi/' . $foldername;
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 210;
            $config['file_name'] = $nama_file;
            $config['overwrite'] = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                echo json_encode(array('statusCode' => 400, 'pesan' => 'File Absensi gagal diupload!'));
            }

            $data = array(
                'url_att_aktual' => $nama_file,
                'tgl_edit' => date('Y-m-d H:i:s'),
            );
            $source = 'tb_att_aktual';
            $field = 'id_att_aktual';
            $result = $this->scd->updateData($field, $id, $source, $data);
            if ($result) {
                if ($oldFile != $nama_file) {
                    unlink('./berkas/absensi/' . $foldername . "/" . $oldFile);
                }
                echo json_encode(array('statusCode' => 200, 'pesan' => 'File Absensi berhasil diupload!'));
            } else {
                echo json_encode(array('statusCode' => 400, 'pesan' => 'File Absensi gagal diupload!'));
            }
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Folder tidak ditemukan!'));
        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_att_aktual';
        $field = 'id_att_aktual';
        $data = $this->scd->readSpecificData($source, $field, $id);
        if (empty($data)) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Absensi berhasil dihapus!'));
        }
        $foldername = md5($data[0]['id_kary']);
        $file = $data[0]['url_att_aktual'];
        $result = $this->scd->deleteData($source, $field, $id);
        if ($result) {
            unlink('./berkas/absensi/' . $foldername . "/" . $file);
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Absensi berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Absensi gagal dihapus!'));
        }
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SPL extends MY_Controller
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
        $this->load->view('data_absensi/spl/view');
    }

    public function showFile()
    {
        $id = $this->input->get("auth");
        $source = 'tb_spl';
        $field = 'id_spl';
        $result = $this->scd->readSpecificData($source, $field, $id);
        if (empty($result)) {
            redirect('not_found');
        }
        $foldername = md5($result[0]['id_kary']);
        $urlFile = $result[0]['url_spl'];
        if (is_file("berkas/spl/" . $foldername . "/" . $urlFile)) {
            $tofile = realpath("berkas/spl/" . $foldername . "/" . $urlFile);
            header('Content-Type: application/pdf');
            readfile($tofile);
        } else {
            redirect('not_found');
        }
    }

    public function dataTables()
    {
        $source = 'vw_spl';
        $data = $this->scd->readData($source);
        $data['spl'] = $data;
        $this->load->view('data_absensi/spl/table', $data);
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'vw_spl';
        $field = 'id_spl';
        $result = $this->scd->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id' => $result[0]['id_spl'],
                'karyawan' => $result[0]['nama_lengkap'],
                'id_karyawan' => $result[0]['id_kary'],
                'tanggal' => $result[0]['tgl_spl'],
                'jam_mulai' => $result[0]['jam_mulai'],
                'jam_akhir' => $result[0]['jam_akhir'],
                'keterangan' => $result[0]['ket_spl'],
                'file' => $result[0]['url_spl'],
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function create()
    {
        $tgl_spl = htmlspecialchars($this->input->post("tgl_spl", true));
        $jam_mulai = htmlspecialchars($this->input->post("jam_mulai", true));
        $jam_akhir = htmlspecialchars($this->input->post("jam_akhir", true));
        $ket_spl = htmlspecialchars($this->input->post("ket_spl", true));
        $id_karyawan = htmlspecialchars($this->input->post("id_karyawan", true));
        $foldername = md5($id_karyawan);
        $sourceKaryawan = 'tb_kary';
        $fieldKaryawan = 'id_kary';
        $result = $this->scd->readSpecificData($sourceKaryawan, $fieldKaryawan, $id_karyawan);
        if (empty($result)) {
            echo json_encode(array('statusCode' => 404, 'pesan' => 'Karyawan tidak ditemukan!'));
        }

        $nama_file = $result[0]['no_nik'] . '-SPL-' . $tgl_spl . '.pdf';

        if (is_dir('./berkas/spl/' . $foldername) == false) {
            mkdir('./berkas/spl/' . $foldername, 0775, true);
        }

        if (is_dir('./berkas/spl/' . $foldername)) {
            $config['upload_path'] = './berkas/spl/' . $foldername;
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 210;
            $config['file_name'] = $nama_file;
            $config['overwrite'] = true;

            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload('file')) {
                echo json_encode(array('statusCode' => 400, 'pesan' => 'File SPL gagal diupload!'));
            }


            $data = array(
                'id_kary' => $id_karyawan,
                'tgl_spl' => $tgl_spl,
                'jam_mulai' => $jam_mulai,
                'jam_akhir' => $jam_akhir,
                'stat_spl' => 'T',
                'ket_spl' => $ket_spl,
                'url_spl' => $nama_file,
                'tgl_buat' => date('Y-m-d H:i:s'),
                'tgl_edit' => '1970-01-01 00:00:00',
                'tgl_hapus' => '1970-01-01 00:00:00',
                'id_user' => $this->session->userdata('id_user'),
            );
            $source = 'tb_spl';
            $result = $this->scd->createData($source, $data);
            if ($result) {
                echo json_encode(array('statusCode' => 201, 'pesan' => 'SPL berhasil ditambahkan!'));
            } else {
                echo json_encode(array('statusCode' => 400, 'pesan' => 'SPL gagal ditambahkan!'));
            }
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Folder tidak ditemukan!'));
        }
    }

    public function update()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $tgl_spl = htmlspecialchars($this->input->post("tgl_spl", true));
        $jam_mulai = htmlspecialchars($this->input->post("jam_mulai", true));
        $jam_akhir = htmlspecialchars($this->input->post("jam_akhir", true));
        $ket_spl = htmlspecialchars($this->input->post("ket_spl", true));

        $data = array(
            'tgl_spl' => $tgl_spl,
            'jam_mulai' => $jam_mulai,
            'jam_akhir' => $jam_akhir,
            'ket_spl' => $ket_spl,
            'tgl_edit' => date('Y-m-d H:i:s'),
        );
        $source = 'tb_spl';
        $field = 'id_spl';
        $result = $this->scd->updateData($field, $id, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'SPL berhasil diedit!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'SPL gagal diedit!'));
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
            $nama_file = $result[0]['no_nik'] . '-SPL-' . $tanggal . '.pdf';
        } else {
            $nama_file = $oldFile;
        }

        if (is_dir('./berkas/spl/' . $foldername) == false) {
            mkdir('./berkas/spl/' . $foldername, 0775, true);
        }

        if (is_dir('./berkas/spl/' . $foldername)) {
            $config['upload_path'] = './berkas/spl/' . $foldername;
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 210;
            $config['file_name'] = $nama_file;
            $config['overwrite'] = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                echo json_encode(array('statusCode' => 400, 'pesan' => 'File SPL gagal diupload!'));
            }

            $data = array(
                'url_spl' => $nama_file,
                'tgl_edit' => date('Y-m-d H:i:s'),
            );
            $source = 'tb_spl';
            $field = 'id_spl';
            $result = $this->scd->updateData($field, $id, $source, $data);
            if ($result) {
                if ($oldFile != $nama_file) {
                    unlink('./berkas/spl/' . $foldername . "/" . $oldFile);
                }
                echo json_encode(array('statusCode' => 200, 'pesan' => 'File SPL berhasil diupload!'));
            } else {
                echo json_encode(array('statusCode' => 400, 'pesan' => 'File SPL gagal diupload!'));
            }
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Folder tidak ditemukan!'));
        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_spl';
        $field = 'id_spl';
        $data = $this->scd->readSpecificData($source, $field, $id);
        if (empty($data)) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'SPL berhasil dihapus!'));
        }
        $foldername = md5($data[0]['id_kary']);
        $file = $data[0]['url_spl'];
        $result = $this->scd->deleteData($source, $field, $id);
        if ($result) {
            unlink('./berkas/spl/' . $foldername . "/" . $file);
            echo json_encode(array('statusCode' => 200, 'pesan' => 'SPL berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'SPL gagal dihapus!'));
        }
    }
}

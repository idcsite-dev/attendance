<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hari_libur extends MY_Controller
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
        $this->load->view('data_master/hari_libur/view');
    }

    public function dataTables()
    {
        $source = 'tb_hari_libur';
        $field = 'tgl_hapus';
        $value = '1970-01-01 00:00:00';
        $data = $this->std->readSpecificData($source, $field, $value);
        $data['hari_libur'] = $data;
        $this->load->view('data_master/hari_libur/table', $data);
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_hari_libur';
        $field = 'id_hari_libur';
        $result = $this->std->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id' => $result[0]['id_hari_libur'],
                'tanggal' => $result[0]['tgl_hari_libur'],
                'keterangan' => $result[0]['ket_hari_libur'],
                'kategori' => $result[0]['stat_lembur'],
                'jam_kerja' => $result[0]['jam_mulai_kerja'],
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function create()
    {
        $tanggalLibur = htmlspecialchars($this->input->post("tanggalLibur", true));
        $keteranganLibur = htmlspecialchars($this->input->post("keteranganLibur", true));
        $kategoriLibur = htmlspecialchars($this->input->post("kategoriLibur", true));
        $jamKerja = htmlspecialchars($this->input->post("jamKerja", true));

        $data = array(
            'tgl_hari_libur' => $tanggalLibur,
            'ket_hari_libur' => $keteranganLibur,
            'stat_hari_libur' => 'T',
            'stat_lembur' => $kategoriLibur,
            'jam_mulai_kerja' => $jamKerja,
            'tgl_buat' => date('Y-m-d H:i:s'),
            'tgl_edit' => '1970-01-01 00:00:00',
            'tgl_hapus' => '1970-01-01 00:00:00',
            'id_user' => $this->session->userdata('id_user'),
        );
        $source = 'tb_hari_libur';
        $result = $this->std->createData($source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 201, 'pesan' => 'Hari Libur berhasil ditambahkan!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Hari Libur gagal ditambahkan!'));
        }
    }

    public function update()
    {
        $idLibur = htmlspecialchars($this->input->post("idLibur", true));
        $tanggalLibur = htmlspecialchars($this->input->post("tanggalLibur", true));
        $keteranganLibur = htmlspecialchars($this->input->post("keteranganLibur", true));
        $kategoriLibur = htmlspecialchars($this->input->post("kategoriLibur", true));
        $jamKerja = htmlspecialchars($this->input->post("jamKerja", true));

        $data = array(
            'tgl_hari_libur' => $tanggalLibur,
            'ket_hari_libur' => $keteranganLibur,
            'stat_lembur' => $kategoriLibur,
            'jam_mulai_kerja' => $jamKerja,
            'tgl_edit' => date('Y-m-d H:i:s'),
        );
        $source = 'tb_hari_libur';
        $field = 'id_hari_libur';
        $result = $this->std->updateData($field, $idLibur, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Hari Libur berhasil diedit!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Hari Libur gagal diedit!'));
        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_hari_libur';
        $field = 'id_hari_libur';
        $result = $this->std->deleteData($source, $field, $id);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Hari Libur berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Hari Libur gagal dihapus!'));
        }
    }
}

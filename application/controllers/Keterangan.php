<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keterangan extends MY_Controller
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
        $this->load->view('data_master/keterangan/view');
    }

    public function dataTables()
    {
        $source = 'vw_tambahan';
        $field = 'tgl_hapus';
        $value = '1970-01-01 00:00:00';
        $data = $this->std->readSpecificData($source, $field, $value);
        $data['keterangan'] = $data;
        $this->load->view('data_master/keterangan/table', $data);
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'vw_tambahan';
        $field = 'id_tambahan';
        $result = $this->std->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id' => $result[0]['id_tambahan'],
                'kode' => $result[0]['kode_ket_tambahan'],
                'status' => $result[0]['stat_data_tambahan'],
                'keterangan' => $result[0]['ket_tambahan'],
                'id_jenis' => $result[0]['id_jenis_ket'],
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function create()
    {
        $kode = htmlspecialchars($this->input->post("kode", true));
        $status = htmlspecialchars($this->input->post("status", true));
        $keterangan = htmlspecialchars($this->input->post("keterangan", true));
        $jenis = htmlspecialchars($this->input->post("jenis", true));

        $data = array(
            'kode_ket_tambahan' => $kode,
            'stat_data_tambahan' => $status,
            'ket_tambahan' => $keterangan,
            'stat_tambahan' => 'T',
            'id_jenis_ket' => $jenis,
            'tgl_buat' => date('Y-m-d H:i:s'),
            'tgl_edit' => '1970-01-01 00:00:00',
            'tgl_hapus' => '1970-01-01 00:00:00',
            'id_user' => $this->session->userdata('id_user'),
        );
        $source = 'tb_tambahan';
        $result = $this->std->createData($source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 201, 'pesan' => 'Keterangan berhasil ditambahkan!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Keterangan gagal ditambahkan!'));
        }
    }

    public function update()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $kode = htmlspecialchars($this->input->post("kode", true));
        $status = htmlspecialchars($this->input->post("status", true));
        $keterangan = htmlspecialchars($this->input->post("keterangan", true));
        $jenis = htmlspecialchars($this->input->post("jenis", true));

        $data = array(
            'kode_ket_tambahan' => $kode,
            'stat_data_tambahan' => $status,
            'ket_tambahan' => $keterangan,
            'id_jenis_ket' => $jenis,
            'tgl_edit' => date('Y-m-d H:i:s'),
        );
        $source = 'tb_tambahan';
        $field = 'id_tambahan';
        $result = $this->std->updateData($field, $id, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Keterangan berhasil diedit!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Keterangan gagal diedit!'));
        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_tambahan';
        $field = 'id_tambahan';
        $result = $this->std->deleteData($source, $field, $id);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Keterangan berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Keterangan gagal dihapus!'));
        }
    }
}
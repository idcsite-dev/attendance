<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_keterangan extends MY_Controller
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
        $this->load->view('data_master/jenis_keterangan/view');
    }

    public function dataTables()
    {
        $source = 'tb_jenis_ket';
        $field = 'tgl_hapus';
        $value = '1970-01-01 00:00:00';
        $data = $this->std->readSpecificData($source, $field, $value);
        $data['jenis_keterangan'] = $data;
        $this->load->view('data_master/jenis_keterangan/table', $data);
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_jenis_ket';
        $field = 'id_jenis_ket';
        $result = $this->std->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id' => $result[0]['id_jenis_ket'],
                'jenis' => $result[0]['jenis_ket'],
                'operator' => $result[0]['stat_operator'],
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function option()
    {
        $source = 'tb_jenis_ket';
        $field = 'tgl_hapus';
        $value = '1970-01-01 00:00:00';
        $data = $this->std->readSpecificData($source, $field, $value);
        
        if (!empty($data)) {
            $output = "<option value=''>-- PILIH JENIS KETERANGAN --</option>";
            foreach ($data as $list) {
                $output = $output . "<option value='" . $list['id_jenis_ket'] . "'>" . $list['jenis_ket'] . "</option>";
            }
            echo json_encode(array("statusCode" => 200, "option" => $output));
        } else {
            $output = "<option value=''>-- JENIS KETERANGAN TIDAK DITEMUKAN --</option>";
            echo json_encode(array("statusCode" => 400, "option" => $output));
        }
    }

    public function create()
    {
        $jenis = htmlspecialchars($this->input->post("jenis", true));
        $operator = htmlspecialchars($this->input->post("operator", true));

        $data = array(
            'jenis_ket' => $jenis,
            'stat_operator' => $operator,
            'stat_jenis_ket' => 'T',
            'tgl_buat' => date('Y-m-d H:i:s'),
            'tgl_edit' => '1970-01-01 00:00:00',
            'tgl_hapus' => '1970-01-01 00:00:00',
            'id_user' => $this->session->userdata('id_user'),
        );
        $source = 'tb_jenis_ket';
        $result = $this->std->createData($source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 201, 'pesan' => 'Jenis Keterangan berhasil ditambahkan!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jenis Keterangan gagal ditambahkan!'));
        }
    }

    public function update()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $jenis = htmlspecialchars($this->input->post("jenis", true));
        $operator = htmlspecialchars($this->input->post("operator", true));

        $data = array(
            'jenis_ket' => $jenis,
            'stat_operator' => $operator,
            'tgl_edit' => date('Y-m-d H:i:s'),
        );
        $source = 'tb_jenis_ket';
        $field = 'id_jenis_ket';
        $result = $this->std->updateData($field, $id, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Jenis Keterangan berhasil diedit!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jenis Keterangan gagal diedit!'));
        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_jenis_ket';
        $field = 'id_jenis_ket';
        $result = $this->std->deleteData($source, $field, $id);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Jenis Keterangan berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Jenis Keterangan gagal dihapus!'));
        }
    }
}

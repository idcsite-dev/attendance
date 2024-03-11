<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authority extends MY_Controller
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
        $this->load->view('authority/users/view');
    }

    public function dataTables()
    {
        $source = 'vw_user';
        $data = $this->std->readDataDelDate($source);
        $data['users'] = $data;
        $this->load->view('authority/users/table', $data);
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'vw_user';
        $field = 'id_user';
        $result = $this->std->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'id' => $result[0]['id_user'],
                'nama' => $result[0]['nama_kary'],
                'no_nik' => $result[0]['no_nik'],
                'depart' => $result[0]['depart'],
                'posisi' => $result[0]['posisi'],
                'akses' => $result[0]['akses'],
                'tgl_aktif' => date('Y-m-d', strtotime($result[0]['tgl_aktif'])),
                'tgl_expired' => date('Y-m-d', strtotime($result[0]['tgl_kadaluarsa'])),
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function create()
    {
        $nama_user = htmlspecialchars($this->input->post("nama_user", true));
        $sesi = htmlspecialchars($this->input->post("sesi", true));
        $tgl_aktif = htmlspecialchars($this->input->post("tgl_aktif", true));
        $akses = htmlspecialchars($this->input->post("akses", true));
        $tgl_expired = htmlspecialchars($this->input->post("tgl_expired", true));
        $id_karyawan = htmlspecialchars($this->input->post("id_karyawan", true));

        $source = 'vw_user';
        $field = 'id_kary';
        $value = $id_karyawan;
        $dataJadwal = $this->std->readSpecificData($source, $field, $value);
        if (!empty($dataJadwal)) {
            echo json_encode(array('statusCode' => 404, 'pesan' => 'User ini sudah ada!'));
            return;
        }

        $data = array(
            'nama_user' => $nama_user,
            'email_login' => '',
            'sesi' => md5($sesi),
            'token' => '',
            'stat_user' => 'T',
            'akses' => $akses,
            'tgl_aktif' => $tgl_aktif,
            'tgl_kadaluarsa' => $tgl_expired,
            'tgl_buat' => date('Y-m-d H:i:s'),
            'tgl_edit' => '1970-01-01 00:00:00',
            'tgl_hapus' => '1970-01-01 00:00:00',
            'pic_user' => '',
            'id_kary' => $id_karyawan,
        );

        $source = 'tb_user';
        $result = $this->std->createData($source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 201, 'pesan' => 'User berhasil ditambahkan!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'User gagal ditambahkan!'));
        }
    }

    public function update()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $sesi = htmlspecialchars($this->input->post("sesi", true));
        $akses = htmlspecialchars($this->input->post("akses", true));
        $tgl_aktif = htmlspecialchars($this->input->post("tgl_aktif", true));
        $tgl_expired = htmlspecialchars($this->input->post("tgl_expired", true));

        $data = array(
            'sesi' => md5($sesi),
            'akses' => $akses,
            'tgl_aktif' => $tgl_aktif,
            'tgl_kadaluarsa' => $tgl_expired,
            'tgl_edit' => date('Y-m-d H:i:s'),
        );
        $source = 'tb_user';
        $field = 'id_user';
        $result = $this->std->updateData($field, $id, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'User berhasil diedit!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'User gagal diedit!'));
        }
    }

    public function delete()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_user';
        $field = 'id_user';
        $value = $id;
        $data = [
            'tgl_hapus' => date('Y-m-d H:i:s'),
        ];

        $result = $this->std->deleteDataSoft($source, $field, $value, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'User berhasil dihapus!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'User gagal dihapus!'));
        }
    }

    public function changePassword()
    {
        $oldPassword = trim(htmlspecialchars($this->input->post("oldPassword", true)));
        $newPassword = trim(htmlspecialchars($this->input->post("newPassword", true)));

        $source = 'tb_user';
        $field = 'id_user';
        $id_user = $this->session->userdata('id_user');

        $checkPassword = $this->std->readSpecificData($source, $field, $id_user);
        if (md5($oldPassword) != $checkPassword[0]['sesi']) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Password lama tidak valid!'));
            return;
        }

        $data = array(
            'sesi' => md5($newPassword),
            'tgl_edit' => date('Y-m-d H:i:s'),
        );

        $result = $this->std->updateData($field, $id_user, $source, $data);
        if ($result) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Password berhasil diubah!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Password gagal diubah!'));
        }
    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends MY_Controller
{
    public function login_view()
    {
        $this->load->view('authentication/login');
    }

    public function process()
    {
        $nik = htmlspecialchars($this->input->post("nik", true));
        $sesi = htmlspecialchars($this->input->post("sesi", true));

        $source = 'tb_kary';
        $field = 'no_nik';
        $today = date('Y-m-d H:i:s');
        $checkData = $this->std->readSpecificData($source, $field, $nik);
        if (!empty($checkData)) {
            $source2 = 'tb_user';
            $value = $checkData[0]['nama_lengkap'];
            $field2 = 'nama_user';
            $authData = $this->std->readSpecificData($source2, $field2, $value);
            if (!empty($authData)) {
                if ($authData[0]['sesi'] == md5($sesi)) {
                    if ($authData[0]['tgl_kadaluarsa'] > $today) {
                        $session_data = array(
                            'login' => true,
                            'id_user' => $authData[0]['id_user'],
                            'nama_karyawan' => $checkData[0]['nama_lengkap'],
                            'no_nik' => $checkData[0]['no_nik'],
                            'departemen' => $checkData[0]['depart'],
                            'posisi' => $checkData[0]['posisi'],
                            'akses' => $authData[0]['akses'],
                        );
                        $this->session->set_userdata($session_data);
                        echo json_encode(array('statusCode' => 200));
                    } else {
                        echo json_encode(array('statusCode' => 401));
                    }
                } else {
                    echo json_encode(array('statusCode' => 400));
                }
            } else {
                echo json_encode(array('statusCode' => 403));
            }
        } else {
            echo json_encode(array('statusCode' => 404));
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login_view');
    }
}
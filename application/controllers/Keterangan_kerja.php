<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keterangan_kerja extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->authentication()) {
            redirect('login_view');
        }
    }

    public function option()
    {
        $source = 'tb_ket_kerja';
        $field = 'tgl_hapus';
        $value = '1970-01-01 00:00:00';
        $data = $this->scd->readSpecificData($source, $field, $value);
        
        if (!empty($data)) {
            $output = "<option value=''>-- PILIH KETERANGAN KERJA --</option>";
            foreach ($data as $list) {
                $output = $output . "<option value='" . $list['id_ket_kerja'] . "'>" . $list['ket_kerja'] . "</option>";
            }
            echo json_encode(array("statusCode" => 200, "option" => $output));
        } else {
            $output = "<option value=''>-- KETERANGAN KERJA TIDAK DITEMUKAN --</option>";
            echo json_encode(array("statusCode" => 400, "option" => $output));
        }
    }
}

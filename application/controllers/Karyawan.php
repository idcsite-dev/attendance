<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends MY_Controller
{
    private $authAPI;

    public function __construct()
    {
        parent::__construct();
        if (!$this->authentication()) {
            redirect('login_view');
        }
        $this->load->library('Encryption_Data');
    }

    private function authAPI()
    {
        return $this->authAPI = [
            'auth' => $this->encryption_data->encryptData($this->session->userdata('no_nik')),
        ];
    }

    public function index()
    {
        $this->load->view('data_master/karyawan/view');
    }

    public function sync()
    {
        $tokenData = $this->api->getToken($this->authAPI());
        $authToken = $tokenData['data'];

        $sourceSync = 'tb_sinkron';
        $checkSync = $this->std->readData($sourceSync);

        if (!empty($checkSync)) {
            $tanggalSync = $checkSync[0]['tgl_jam_sink'];
            $parameter = [
                'source' => 'vw_karyawan',
                'field' => 'id_m_perusahaan',
                'value' => 3,
                'field2' => 'tgl_buat >',
                'value2' => $tanggalSync,
                'field3' => 'tgl_edit >',
                'value3' => $tanggalSync,
            ];
            $checkUpdatedData = $this->api->checkSyncData($parameter, $authToken);
            if ($checkUpdatedData['status'] == 404) {
                echo json_encode(array('statusCode' => 204, 'pesan' => 'Data Karyawan sudah yang paling terbaru!!'));
                return;
            }
        }

        $source = 'tb_kary';
        $parameter = [
            'field' => 'id_m_perusahaan',
            'value' => 3,
        ];
        $data = $this->api->syncAllData($parameter, $authToken);

        if ($data['status'] == 404) {
            echo json_encode(array('statusCode' => 404, 'pesan' => 'Data Karyawan sudah yang paling terbaru!!'));
            return;
        }
        $this->std->deleteAll($source);

        $dataToInsert = array();
        foreach ($data['data'] as $value) {
            if (empty($value['tgl_nonaktif'])) {
                $tgl_nonaktif = '1970-01-01';
            } else {
                $tgl_nonaktif = $value['tgl_nonaktif'];
            }

            $parameterKontrak = [
                'field' => 'id_kary',
                'value' => $value['id_kary'],
            ];
            $dataKontrak = $this->api->syncKontrakKaryawan($parameterKontrak, $authToken);
            if ($dataKontrak['status'] == 200) {
                if ($dataKontrak['data'][0]['id_stat_perjanjian'] == '1') {
                    $tgl_awal_kontrak = '1970-01-01';
                    $tgl_akhir_kontrak = '1970-01-01';
                    $tgl_permanen = $dataKontrak['data'][0]['tgl_mulai'];
                } else {
                    $tgl_awal_kontrak = $dataKontrak['data'][0]['tgl_mulai'];
                    $tgl_akhir_kontrak = $dataKontrak['data'][0]['tgl_akhir'];
                    $tgl_permanen = '1970-01-01';
                }
            } else {
                $tgl_awal_kontrak = '1970-01-01';
                $tgl_akhir_kontrak = '1970-01-01';
                $tgl_permanen = '1970-01-01';
            }

            $parameterAlamat = [
                'field' => 'id_personal',
                'value' => $value['id_personal'],
            ];
            $dataAlamat = $this->api->syncAlamatKaryawan($parameterAlamat, $authToken);
            if ($dataAlamat['status'] == 200) {
                $addressComponents = [];

                $data = $dataAlamat['data'][0];

                if (!empty($data['alamat_ktp'])) {
                    $addressComponents[] = $data['alamat_ktp'];
                }

                if (!empty($data['rt_ktp'])) {
                    $addressComponents[] = 'RT. ' . $data['rt_ktp'];
                }

                if (!empty($data['rw_ktp'])) {
                    $addressComponents[] = 'RW. ' . $data['rw_ktp'];
                }

                if (!empty($data['kel'])) {
                    $addressComponents[] = 'Kelurahan ' . $data['kel'];
                }

                if (!empty($data['kec'])) {
                    $addressComponents[] = 'Kecamatan ' . $data['kec'];
                }

                if (!empty($data['kab'])) {
                    $addressComponents[] = 'Kabupaten/Kota ' . $data['kab'];
                }

                if (!empty($data['prov'])) {
                    $addressComponents[] = 'Provinsi ' . $data['prov'];
                }

                $alamat = implode(', ', $addressComponents);
            } else {
                $alamat = '';
            }

            $dataToInsert[] = [
                'id_kary' => $value['id_kary'],
                'no_nik' => $value['no_nik'],
                'nama_lengkap' => $value['nama_lengkap'],
                'tmp_lahir' => $value['tmp_lahir'],
                'tgl_lahir' => $value['tgl_lahir'],
                'jk' => $value['jk'],
                'alamat' => $alamat,
                // 'alamat' => '',
                'depart' => $value['depart'],
                'section' => '',
                'posisi' => $value['posisi'],
                'grade' => '',
                'level' => $value['level'],
                'tipe' => $value['tipe'],
                'tipe_shift' => '',
                'aktifitas' => '',
                'stat_nikah' => '',
                'stat_pajak' => '',
                'stat_kontrak' => '',
                'tgl_awal_kontrak' => $tgl_awal_kontrak,
                'tgl_akhir_kontrak' => $tgl_akhir_kontrak,
                'tgl_permanen' => $tgl_permanen,
                // 'tgl_awal_kontrak' => '1970-01-01',
                // 'tgl_akhir_kontrak' => '1970-01-01',
                // 'tgl_permanen' => '1970-01-01',
                'paybase' => '',
                'no_ktp' => $value['no_ktp'],
                'no_kk' => $value['no_kk'],
                'no_npwp' => $value['no_npwp'],
                'no_bpjs_tk' => $value['no_bpjstk'],
                'no_bpjs_kes' => $value['no_bpjskes'],
                'doh' => $value['doh'],
                'tgl_aktif' => $value['tgl_aktif'],
                'tgl_nonaktif' => $tgl_nonaktif,
                'stat_tinggal' => $value['stat_tinggal'],
                'poh' => $value['poh'],
                'email' => $value['email_kantor'],
                'no_hp' => $value['hp_1'],
                'tgl_buat' => $value['tgl_buat'],
                'tgl_update' => $value['tgl_edit'],
                'tgl_hapus' => '1970-01-01',
            ];
        }

        $insertData = $this->std->createBatchData($source, $dataToInsert);
        if (!$insertData) {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Terjadi kesalahan saat insert data karyawan!!'));
            return;
        }

        $parameterLog = [
            'tgl_jam_sink' => date('Y-m-d H:i:s'),
        ];
        if (!empty($checkSync)) {
            $fieldSync = 'id_sinkron';
            $idSync = $check[0]['id_sinkron'];
            $logSync = $this->std->updateData($fieldSync, $idSync, $sourceSync, $parameterLog);
        } else {
            $logSync = $this->std->createData($sourceSync, $parameterLog);
        }

        if ($logSync) {
            echo json_encode(array('statusCode' => 200, 'pesan' => 'Sinkronisasi Data Karyawan Berhasil!!'));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Sinkronisasi Data Karyawan Gagal!!'));
        }
    }

    public function dataTables()
    {
        $source = 'tb_kary';
        $data = $this->std->readData($source);
        $data['karyawan'] = $data;
        $this->load->view('data_master/karyawan/table', $data);
    }

    public function detail()
    {
        $id = htmlspecialchars($this->input->post("id", true));
        $source = 'tb_kary';
        $field = 'id_kary';
        $result = $this->std->readSpecificData($source, $field, $id);
        if (!empty($result)) {
            echo json_encode(array(
                'statusCode' => 200,
                'nik' => $result[0]['no_nik'],
                'nama' => $result[0]['nama_lengkap'],
                'tempat_lahir' => $result[0]['tmp_lahir'],
                'tanggal_lahir' => $result[0]['tgl_lahir'],
                'jenis_kelamin' => $result[0]['jk'],
                'departemen' => $result[0]['depart'],
                'section' => $result[0]['section'],
                'posisi' => $result[0]['posisi'],
                'alamat' => $result[0]['alamat'],
                'npwp' => $result[0]['no_npwp'],
                'level' => $result[0]['level'],
                'golongan' => $result[0]['tipe'],
            ));
        } else {
            echo json_encode(array('statusCode' => 400, 'pesan' => 'Data tidak ditemukan!'));
        }
    }

    public function searchData()
    {
        $value = $this->input->post('search');
        $source = 'tb_kary';
        $field = 'no_nik';
        $field2 = 'nama_lengkap';
        $data = $this->std->searchData($source, $field, $field2, $value);
        $response = array();
        if (!empty($data)) {
            foreach ($data as $list) {
                $response[] = array(
                    "value" => $list['id_kary'],
                    "nama" => $list['nama_lengkap'],
                    "depart" => $list['depart'],
                    "posisi" => $list['posisi'],
                    "label" => $list['no_nik'] . " | " . $list['nama_lengkap'] . " | " . $list['depart'],
                );
            }
        }
        echo json_encode($response);
    }

    public function searchDataAttendance()
    {
        $value = $this->input->post('search');
        $source = 'tb_kary';
        $field = 'no_nik';
        $field2 = 'nama_lengkap';
        $data = $this->scd->searchData($source, $field, $field2, $value);
        $response = array();
        if (!empty($data)) {
            foreach ($data as $list) {
                $response[] = array(
                    "value" => $list['id_kary'],
                    "nama" => $list['nama_lengkap'],
                    "label" => $list['no_nik'] . " | " . $list['nama_lengkap'] . " | " . $list['depart'],
                );
            }
        }
        echo json_encode($response);
    }
}
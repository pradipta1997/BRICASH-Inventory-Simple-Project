<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("user_login")) {
            redirect('Auth');
        }
    }

    public function index()
    {
        cekPergroup();
        $this->header('List Vendor');
        $this->load->view('Vendor/list_vendor');
        $this->footer();
    }

    public function listVendor()
    {
        $list = $this->Serverside->_serverSide(
            'tbl_vendor',
            ['no', 'nama_vendor', 'telp_vendor', 'alamat_vendor', 'nama_pic', 'telp_pic', 'ket', 'is_active'],
            ['nama_vendor', 'telp_vendor', 'alamat_vendor', 'nama_pic', 'telp_pic', 'ket'],
            ['id_vendor' => 'desc'],
            ['id_vendor !=' => 1],
            'data'
        );
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $results) {
            $buttonDisable = $results->is_active == 1 ? '' : 'disabled';
            $buttonWarna = $results->is_active == 1 ? 'danger' : 'success';

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $results->nama_vendor;
            $row[] = $results->telp_vendor;
            $row[] = $results->alamat_vendor;
            $row[] = $results->ket;
            $row[] = statusActiveNonactive($results->is_active);
            $row[] = " <button type='button' class='btn btn-sm btn-primary' $buttonDisable onclick='Vpic($results->id_vendor)'>
                        <i class='fa fa-user-o'></i> PIC
                    </button>
                    <button type='button' class='btn btn-warning' $buttonDisable onclick='VVendor($results->id_vendor)'>
                        <i class='fa fa-pencil-square-o'></i>
                    </button>
                    <button type='button' class='btn btn-$buttonWarna' onclick='activeVendor($results->id_vendor)'>
                        <i class='fa fa-power-off' aria-hidden='true'></i>
                    </button>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('tbl_vendor'),
            "recordsFiltered" => $this->Serverside->_serverSide('tbl_vendor'),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function formVendor()
    {
        if (input('id_vendor')) {
            $this->_editVendor();
        } else {
            $this->_saveVendor();
        }
    }

    private function _saveVendor()
    {
        $data = array(
            'nama_vendor' => input('nama'),
            'telp_vendor' => input('telp'),
            'alamat_vendor' => input('alamat'),
            'nama_pic' => input('namapic'),
            'telp_pic' => input('telppic'),
            'ket' => input('ket'),
            'is_active' => 1,
            'vendor_created_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->insertRecord('tbl_vendor', $data);

        if ($response) {
            LogActivity($this->db->last_query());
            $pesan = array(
                'pesan' => 'Data berhasil di simpan!',
                'tipe' => 'success'
            );

            echo json_encode($pesan);
        } else {
            $pesan = array(
                'pesan' => 'Data gagal di simpan!',
                'tipe' => 'error'
            );

            echo json_encode($pesan);
        }
    }

    public function viewVendor($id_vendor)
    {
        $data = $this->General->fetch_records('tbl_vendor', ['id_vendor' => $id_vendor]);
        echo json_encode($data);
    }

    private function _editVendor()
    {
        $data = array(
            'nama_vendor' => input('nama'),
            'telp_vendor' => input('telp'),
            'alamat_vendor' => input('alamat'),
            'nama_pic' => input('namapic'),
            'telp_pic' => input('telppic'),
            'ket' => input('ket'),
            'vendor_updated_date' => date('Y-m-d H:i:s'),
            'vendor_updated_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->update_record($data, ['id_vendor' => input('id_vendor')], 'tbl_vendor');

        if ($response) {
            LogActivity($this->db->last_query());
            $pesan = array(
                'pesan' => 'Data berhasil di edit!',
                'tipe' => 'success'
            );

            echo json_encode($pesan);
        } else {
            $pesan = array(
                'pesan' => 'Data gagal di edit!',
                'tipe' => 'error'
            );

            echo json_encode($pesan);
        }
    }

    public function activeVendor()
    {
        $data = $this->General->fetch_records('tbl_vendor', ['id_vendor' => input('id_vendor')]);
        if ($data[0]->is_active == 1) {
            $this->General->update_record(['is_active' => 0], ['id_vendor' => input('id_vendor')], 'tbl_vendor');
            $message = "Data berhasil di non aktifkan!";
        } else {
            $this->General->update_record(['is_active' => 1], ['id_vendor' => input('id_vendor')], 'tbl_vendor');
            $message = "Data berhasil di aktifkan!";
        }
        LogActivity($this->db->last_query());

        echo json_encode($message);
    }
}

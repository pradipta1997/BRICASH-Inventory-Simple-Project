<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jtran extends MY_Controller
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
        $this->header('List Jenis Transaksi');
        $this->load->view('Jtran/list_jtran');
        $this->footer();
    }

    public function listJtran()
    {
        $list = $this->Serverside->_serverSide(
            'tbl_jtran',
            ['no', 'nama_jtran', 'is_active'],
            ['nama_jtran'],
            ['id_jtran' => 'desc'],
            null,
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
            $row[] = $results->nama_jtran;
            $row[] = statusActiveNonactive($results->is_active);
            $row[] = "<button type='button' class='btn btn-warning' $buttonDisable onclick='VJtran($results->id_jtran)'>
                        <i class='fa fa-pencil-square-o'></i>
                    </button>
                    <button type='button' class='btn btn-$buttonWarna' onclick='activeJtran($results->id_jtran)'>
                        <i class='fa fa-power-off' aria-hidden='true'></i>
                    </button>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('tbl_jtran'),
            "recordsFiltered" => $this->Serverside->_serverSide('tbl_jtran'),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function formJtran()
    {
        if (input('id_jtran')) {
            $this->_editJtran();
        } else {
            $this->_saveJtran();
        }
    }

    private function _saveJtran()
    {
        $data = array(
            'nama_jtran' => input('nama'),
            'is_active' => 1,
            'jtran_created_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->insertRecord('tbl_jtran', $data);

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

    public function viewJtran($id_jtran)
    {
        $data = $this->General->fetch_records('tbl_jtran', ['id_jtran' => $id_jtran]);
        echo json_encode($data);
    }

    private function _editJtran()
    {
        $data = array(
            'nama_jtran' => input('nama'),
            'jtran_updated_date' => date('Y-m-d H:i:s'),
            'jtran_updated_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->update_record($data, ['id_jtran' => input('id_jtran')], 'tbl_jtran');

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

    public function activeJtran()
    {
        $data = $this->General->fetch_records('tbl_jtran', ['id_jtran' => input('id_jtran')]);
        if ($data[0]->is_active == 1) {
            $this->General->update_record(['is_active' => 0], ['id_jtran' => input('id_jtran')], 'tbl_jtran');
            $message = "Data berhasil di non aktifkan!";
        } else {
            $this->General->update_record(['is_active' => 1], ['id_jtran' => input('id_jtran')], 'tbl_jtran');
            $message = "Data berhasil di aktifkan!";
        }
        LogActivity($this->db->last_query());

        echo json_encode($message);
    }
}

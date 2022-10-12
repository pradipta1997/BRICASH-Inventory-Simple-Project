<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Groupuser extends MY_Controller
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
        $this->header('List Group User');
        $this->load->view('Groupuser/list_groupuser');
        $this->footer();
    }

    public function listGroupuser()
    {
        $list = $this->Serverside->_serverSide(
            'tbl_user_group',
            ['no', 'nama_group', 'is_active'],
            ['nama_group'],
            ['id_group' => 'desc'],
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
            $row[] = $results->nama_group;
            $row[] = statusActiveNonactive($results->is_active);
            $row[] = "<button type='button' class='btn btn-warning' $buttonDisable onclick='VGroupuser($results->id_group)'>
                        <i class='fa fa-pencil-square-o'></i>
                    </button>
                    <button type='button' class='btn btn-$buttonWarna' onclick='activeGroupuser($results->id_group)'>
                        <i class='fa fa-power-off' aria-hidden='true'></i>
                    </button>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('tbl_user_group'),
            "recordsFiltered" => $this->Serverside->_serverSide('tbl_user_group'),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function formGroupuser()
    {
        if (input('id_group')) {
            $this->_editGroupuser();
        } else {
            $this->_saveGroupuser();
        }
    }

    private function _saveGroupuser()
    {
        $data = array(
            'nama_group' => input('nama'),
            'is_active' => 1,
            'group_created_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->insertRecord('tbl_user_group', $data);

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

    public function viewGroupuser($id_group)
    {
        $data = $this->General->fetch_records('tbl_user_group', ['id_group' => $id_group]);
        echo json_encode($data);
    }

    private function _editGroupuser()
    {
        $data = array(
            'nama_group' => input('nama'),
            'group_updated_date' => date('Y-m-d H:i:s'),
            'group_updated_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->update_record($data, ['id_group' => input('id_group')], 'tbl_user_group');

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

    public function activeGroupuser()
    {
        $data = $this->General->fetch_records('tbl_user_group', ['id_group' => input('id_group')]);
        if ($data[0]->is_active == 1) {
            $this->General->update_record(['is_active' => 0], ['id_group' => input('id_group')], 'tbl_user_group');
            $message = "Data berhasil di non aktifkan!";
        } else {
            $this->General->update_record(['is_active' => 1], ['id_group' => input('id_group')], 'tbl_user_group');
            $message = "Data berhasil di aktifkan!";
        }
        LogActivity($this->db->last_query());

        echo json_encode($message);
    }
}

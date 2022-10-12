<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
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
        $data['usersgroup'] = $this->General->fetch_records("v_subgroupuser", ['is_active' => 1]);
        $data['uker'] = $this->General->fetch_records("tbl_unit_kerja", ['is_active' => 1]);
        $this->header('List User');
        $this->load->view('User/list_user', $data);
        $this->footer();
    }

    public function listUser()
    {
        $list = $this->Serverside->_serverSide(
            'v_user',
            ['no', 'nama_uker', 'nama_subgroup', 'nama_user', 'username', 'is_active'],
            ['nama_uker', 'nama_subgroup', 'nama_user', 'username'],
            ['id_user' => 'desc'],
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
            $row[] = $results->nama_uker;
            $row[] = $results->nama_subgroup;
            $row[] = $results->nama_user;
            $row[] = $results->username;
            $row[] = statusActiveNonactive($results->is_active);
            $row[] = "<button type='button' class='btn btn-warning' $buttonDisable onclick='VUser($results->id_user)'>
                        <i class='fa fa-pencil-square-o'></i>
                    </button>
                    <button type='button' class='btn btn-$buttonWarna' onclick='activeUser($results->id_user)'>
                        <i class='fa fa-power-off' aria-hidden='true'></i>
                    </button>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('v_user'),
            "recordsFiltered" => $this->Serverside->_serverSide('v_user'),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function formUser()
    {
        if (input('id_user')) {
            $this->_editUser();
        } else {
            $this->_saveUser();
        }
    }

    private function _saveUser()
    {
        $data = array(
            'id_sgroup' => input('id_sgroup'),
            'id_uker' => input('id_uker'),
            'nama_user' => input('nama'),
            'username' => input('username'),
            'password' => sha1(md5(input('password'))),
            'is_active' => 1,
            'user_created_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->insertRecord('tbl_user', $data);

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

    public function viewUser($id_user)
    {
        $data = $this->General->fetch_records('v_user', ['id_user' => $id_user]);
        echo json_encode($data);
    }

    private function _editUser()
    {
        $data = array(
            'id_sgroup' => input('id_sgroup'),
            'id_uker' => input('id_uker'),
            'nama_user' => input('nama'),
            'username' => input('username'),
            'user_updated_date' => date('Y-m-d H:i:s'),
            'user_updated_by' => $this->session->userdata('user_login')['username']
        );

        if (input('password')) {
            $data['password'] = sha1(md5(input('password')));
        }

        $response = $this->General->update_record($data, ['id_user' => input('id_user')], 'tbl_user');

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

    public function activeUser()
    {
        $data = $this->General->fetch_records('tbl_user', ['id_user' => input('id_user')]);
        if ($data[0]->is_active == 1) {
            $this->General->update_record(['is_active' => 0], ['id_user' => input('id_user')], 'tbl_user');
            $message = "Data berhasil di non aktifkan!";
        } else {
            $this->General->update_record(['is_active' => 1], ['id_user' => input('id_user')], 'tbl_user');
            $message = "Data berhasil di aktifkan!";
        }
        LogActivity($this->db->last_query());

        echo json_encode($message);
    }
}

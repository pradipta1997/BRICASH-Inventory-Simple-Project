<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subgroupuser extends MY_Controller
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
        $data['groupuser'] = $this->General->fetch_records("tbl_user_group", ['is_active' => 1]);
        $this->header('List Subgroup User');
        $this->load->view('Subgroupuser/list_subgroupuser', $data);
        $this->footer();
    }

    public function listSubgroupuser()
    {
        $list = $this->Serverside->_serverSide(
            'v_subgroupuser',
            ['no', 'nama_group', 'nama_subgroup', 'is_active'],
            ['nama_group', 'nama_subgroup'],
            ['id_subgroup' => 'desc'],
            null,
            'data'
        );
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $results) {
            $buttonDisable = $results->is_active == 1 ? '' : 'disabled';
            $buttonWarna = $results->is_active == 1 ? 'danger' : 'success';
            $linkPermession = $results->is_active == 1 ? base_url('Permission/listPermission/' . $results->id_subgroup) : '#';

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $results->nama_group;
            $row[] = $results->nama_subgroup;
            $row[] = statusActiveNonactive($results->is_active);
            $row[] = "<a href='$linkPermession' $buttonDisable data-toggle='modal' class='btn btn-primary'><i class='fa fa-pencil-square-o'></i>
                        Permission
                    </a>
                    <button type='button' class='btn btn-warning' $buttonDisable onclick='VSubgroupuser($results->id_subgroup)'>
                        <i class='fa fa-pencil-square-o'></i>
                    </button>
                    <button type='button' class='btn btn-$buttonWarna' onclick='activeSubgroupuser($results->id_subgroup)'>
                        <i class='fa fa-power-off' aria-hidden='true'></i>
                    </button>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('v_subgroupuser'),
            "recordsFiltered" => $this->Serverside->_serverSide('v_subgroupuser'),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function formSubgroupuser()
    {
        if (input('id_subgroup')) {
            $this->_editSubgroupuser();
        } else {
            $this->_saveSubgroupuser();
        }
    }

    private function _saveSubgroupuser()
    {
        $data = array(
            'id_group' => input('id_group'),
            'nama_subgroup' => input('nama'),
            'is_active' => 1,
            'usubgroup_created_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->insertRecord('tbl_user_subgroup', $data);

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

    public function viewSubgroupuser($id_subgroup)
    {
        $data = $this->General->fetch_records('tbl_user_subgroup', ['id_subgroup' => $id_subgroup]);
        echo json_encode($data);
    }

    private function _editSubgroupuser()
    {
        $data = array(
            'id_group' => input('id_group'),
            'nama_subgroup' => input('nama'),
            'usubgroup_updated_date' => date('Y-m-d H:i:s'),
            'usubgroup_updated_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->update_record($data, ['id_subgroup' => input('id_subgroup')], 'tbl_user_subgroup');

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

    public function activeSubgroupuser()
    {
        $data = $this->General->fetch_records('tbl_user_subgroup', ['id_subgroup' => input('id_subgroup')]);
        if ($data[0]->is_active == 1) {
            $this->General->update_record(['is_active' => 0], ['id_subgroup' => input('id_subgroup')], 'tbl_user_subgroup');
            $message = "Data berhasil di non aktifkan!";
        } else {
            $this->General->update_record(['is_active' => 1], ['id_subgroup' => input('id_subgroup')], 'tbl_user_subgroup');
            $message = "Data berhasil di aktifkan!";
        }
        LogActivity($this->db->last_query());

        echo json_encode($message);
    }
}

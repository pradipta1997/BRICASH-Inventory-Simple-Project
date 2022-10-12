<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MY_Controller
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
        $data['pmenu'] = $this->General->fetch_records("tbl_user_menu", ['parent_id' => 0, 'url_menu' => '#']);
        $this->header('List Menu');
        $this->load->view('Menu/list_menu', $data);
        $this->footer();
    }

    public function listMenu()
    {
        $list = $this->Serverside->_serverSide(
            'tbl_user_menu',
            ['no', 'nama_menu', 'url_menu', 'sort_order', 'parent_id', 'show_in_menu', 'is_active'],
            ['nama_menu', 'url_menu'],
            ['id_menu' => 'desc'],
            null,
            'data'
        );
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $results) {
            $mn_prnt = $this->General->fetch_bysinglecol('id_menu', 'tbl_user_menu', $results->parent_id);
            if ($mn_prnt) {
                $nm_parent = $mn_prnt[0]->nama_menu;
            } else {
                $nm_parent = '-';
            }

            $buttonDisable = $results->is_active == 1 ? '' : 'disabled';
            $buttonWarna = $results->is_active == 1 ? 'danger' : 'success';

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $results->nama_menu;
            $row[] = $results->url_menu;
            $row[] = $results->sort_order;
            $row[] = $nm_parent;
            $row[] = $results->show_in_menu == 1 ? 'Show' : 'Hidden';
            $row[] = statusActiveNonactive($results->is_active);
            $row[] = "<button type='button' class='btn btn-warning' $buttonDisable onclick='Vmenu($results->id_menu)'>
                        <i class='fa fa-pencil-square-o'></i>
                    </button>
                    <button type='button' class='btn btn-$buttonWarna' onclick='activeMenu($results->id_menu)'>
                        <i class='fa fa-power-off' aria-hidden='true'></i>
                    </button>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('tbl_user_menu'),
            "recordsFiltered" => $this->Serverside->_serverSide('tbl_user_menu'),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function formMenu()
    {
        if (input('id_menu')) {
            $this->_editMenu();
        } else {
            $this->_saveMenu();
        }
    }

    private function _saveMenu()
    {
        $data = array(
            'nama_menu' => input('nama'),
            'url_menu' => input('url'),
            'parent_id' => input('parent'),
            'sort_order' => input('sort'),
            'show_in_menu' => input('show_menu') ? 1 : 0,
            'is_active' => 1,
            'menu_created_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->insertRecord('tbl_user_menu', $data);

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

    public function viewMenu($id_menu)
    {
        $data = $this->General->fetch_records('tbl_user_menu', ['id_menu' => $id_menu]);
        echo json_encode($data);
    }

    private function _editMenu()
    {
        $data = array(
            'nama_menu' => input('nama'),
            'url_menu' => input('url'),
            'parent_id' => input('parent'),
            'sort_order' => input('sort'),
            'show_in_menu' => input('show_menu') ? 1 : 0,
            'menu_updated_date' => date('Y-m-d H:i:s'),
            'menu_updated_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->update_record($data, ['id_menu' => input('id_menu')], 'tbl_user_menu');

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

    public function activeMenu()
    {
        $data = $this->General->fetch_records('tbl_user_menu', ['id_menu' => input('id_menu')]);
        if ($data[0]->is_active == 1) {
            $this->General->update_record(['is_active' => 0], ['id_menu' => input('id_menu')], 'tbl_user_menu');
            $message = "Data berhasil di non aktifkan!";
        } else {
            $this->General->update_record(['is_active' => 1], ['id_menu' => input('id_menu')], 'tbl_user_menu');
            $message = "Data berhasil di aktifkan!";
        }
        LogActivity($this->db->last_query());

        echo json_encode($message);
    }
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends MY_Controller
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
        $data = array(
            'gbarang' => $this->General->fetch_records("tbl_gbarang", ['is_active' => 1]),
            'barang' => $this->General->fetch_records("v_barang"),
        );

        cekPergroup();
        $this->header('Stock Barang');
        $this->load->view('Barang/list_barang', $data);
        $this->footer();
    }

    public function listBarang()
    {

        $list = $this->Serverside->_serverSide(
            'v_barang',
            ['no',   'nama_gbarang', 'nama_sgbarang', 'nama_merek', 'tipe_barang', 'kode_barang', 'nama_barang', 'qty', 'is_active'],
            ['nama_gbarang', 'nama_sgbarang', 'nama_merek', 'tipe_barang', 'kode_barang', 'nama_barang'],
            ['no_urut' => 'desc'],
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
            $row[] = $results->nama_gbarang;
            $row[] = $results->nama_sgbarang;
            $row[] = $results->nama_merek;
            $row[] = $results->tipe_barang;
            $row[] = $results->kode_barang;
            $row[] = $results->nama_barang;
            $row[] = statusActiveNonactive($results->is_active);
            $row[] = "<button type='button' class='btn btn-warning' " . getEditperm() . " $buttonDisable data-toggle='modal' data-target='#editBarang" . $results->no_urut . "'>
                        <i class='fa fa-pencil-square-o'></i>
                    </button>
                    <button type='button' class='btn btn-$buttonWarna' " . getActiveperm() . " onclick='activeBarang($results->no_urut)'>
                        <i class='fa fa-power-off' aria-hidden='true'></i>
                    </button>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('v_barang'),
            "recordsFiltered" => $this->Serverside->_serverSide('v_barang'),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function formBarang()
    {
        if (input('no_urut')) {
            $this->_editBarang();
        } else {
            $this->_saveBarang();
        }
    }

    private function _saveBarang()
    {
        $data = array(
            'id_tipe_barang' => input('id_tipe_barang'),
            'kode_barang' => input('kode_barang'),
            'nama_barang' => input('nama_barang'),
            'is_active' => 1,
            'barang_created_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->insertRecord('tbl_barang', $data);

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

    private function _editBarang()
    {
        $data = array(
            'id_tipe_barang' => input('id_tipe_barang'),
            'kode_barang' => input('kode_barang'),
            'nama_barang' => input('nama_barang'),
            'barang_updated_date' => date('Y-m-d'),
            'barang_updated_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->update_record($data, ['no_urut' => input('no_urut')], 'tbl_barang');

        if ($response) {
            LogActivity($this->db->last_query());
            $this->session->set_flashdata('info', 'Record Updated Successfully..!');
            redirect('Barang');
        } else {
            $this->session->set_flashdata('error', 'Record Updated Failed..!');
            redirect('Barang');
        }
    }

    public function activeBarang()
    {
        $data = $this->General->fetch_records('tbl_barang', ['no_urut' => input('no_urut')]);
        if ($data[0]->is_active == 1) {
            $this->General->update_record(['is_active' => 0], ['no_urut' => input('no_urut')], 'tbl_barang');
            $message = "Data berhasil di non aktifkan!";
        } else {
            $this->General->update_record(['is_active' => 1], ['no_urut' => input('no_urut')], 'tbl_barang');
            $message = "Data berhasil di aktifkan!";
        }
        LogActivity($this->db->last_query());

        echo json_encode($message);
    }
}

/* End of file Barang.php */

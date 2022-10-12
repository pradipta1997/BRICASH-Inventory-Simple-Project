<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penbar extends MY_Controller
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
            'barang' => $this->General->fetch_records("tbl_barang", ['is_active' => 1]),
            'vendor' => $this->General->fetch_records("tbl_vendor", ['is_active' => 1, 'id_vendor !=' => 1])
        );

        cekPergroup();
        $this->header('List Penerimaan Barang Vendor');
        $this->load->view('Penbar/list_penbar', $data);
        $this->footer();
    }

    public function listPenbar()
    {
        if ($this->session->userdata('user_login')['id_group'] == 1) {
            $where = ['id_jtran' => 2];
        } else {
            $where = ['id_uker' => $this->session->userdata('user_login')['id_uker'], 'id_jtran' => 2];
        }

        $list = $this->Serverside->_serverSide(
            'v_penbarven',
            ['no', 'nama_uker', 'nama_vendor',  'tipe_barang', 'kode_barang', 'nama_barang', 'no_sn', 'qty', 'remark', 'is_active'],
            ['nama_uker', 'nama_vendor', 'tipe_barang', 'kode_barang', 'nama_barang', 'no_sn', 'remark'],
            ['id_tran' => 'desc'],
            $where,
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
            $row[] = $results->tgl_terima_barang;
            $row[] = $results->no_referensi;
            $row[] = $results->nama_uker;
            $row[] = $results->nama_vendor;
            $row[] = $results->tipe_barang;
            $row[] = $results->kode_barang;
            $row[] = $results->nama_barang;
            $row[] = $results->no_sn;
            $row[] = $results->qty;
            $row[] = $results->harga_barang;
            $row[] = $results->remark;
            $row[] = "<button type='button' class='btn btn-warning' $buttonDisable " . getEditperm() . " onclick='VPenbar($results->id_tran)'>
                        <i class='fa fa-pencil-square-o'></i>
                    </button>
                    <button type='button' class='btn btn-$buttonWarna' " . getActiveperm() . " onclick='activePenbar($results->id_tran)'>
                        <i class='fa fa-power-off' aria-hidden='true'></i>
                    </button>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('v_penbarven'),
            "recordsFiltered" => $this->Serverside->_serverSide('v_penbarven'),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function formPenbar()
    {
        if (input('id_tran')) {
            $this->_editPenbar();
        } else {
            $this->_savePenbar();
        }
    }

    private function _savePenbar()
    {
        $cekNosn = $this->General->getJumlahData('tbl_transaksi', ['no_sn' => input('no_sn'), 'no_urut' => input('no_urut'), 'id_jtran' => 2]);

        if ($cekNosn > 0) {
            $pesan = array(
                'pesan' => 'No SN sudah di gunakan!',
                'tipe' => 'info'
            );

            echo json_encode($pesan);
        } else {
            $data = array(
                'id_vendor' => input('id_vendor'),
                'id_jtran' => 2,
                'id_uker' => $this->session->userdata('user_login')['id_uker'],
                'no_urut' => input('no_urut'),
                'no_referensi' => input('no_referensi'),
                'tgl_terima_barang' => input('tgl_terima_barang'),
                'no_sn' => input('no_sn'),
                'qty' => 1,
                'kon_barang' => 'Bagus',
                'harga_barang' => input('harga_barang'),
                'remark' => input('remark'),
                'is_active' => 1,
                'tran_created_by' => $this->session->userdata('user_login')['username']
            );

            $response = $this->General->insertRecord('tbl_transaksi', $data);

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
    }

    public function viewPenbar($id_tran)
    {
        $data = $this->General->fetch_records('v_penbarven', ['id_tran' => $id_tran]);
        echo json_encode($data);
    }

    private function _editPenbar()
    {
        $noSnOld = $this->General->getRow('tbl_transaksi', ['no_sn' => input('no_sn'), 'id_vendor' => input('id_vendor')]);
        if ($noSnOld['no_sn'] == input('no_sn')) {
            $this->_updatePenbar();
        } else {
            $cekNosn = $this->General->getJumlahData('tbl_transaksi', ['no_sn' => input('no_sn'), 'no_urut' => input('no_urut'), 'id_jtran' => 2]);

            if ($cekNosn > 0) {
                $pesan = array(
                    'pesan' => 'No SN sudah di gunakan!',
                    'tipe' => 'info'
                );

                echo json_encode($pesan);
            } else {
                $this->_updatePenbar();
            }
        }
    }

    private function _updatePenbar()
    {
        $data = array(
            'id_vendor' => input('id_vendor'),
            'no_urut' => input('no_urut'),
            'no_sn' => input('no_sn'),
            'no_referensi' => input('no_referensi'),
            'tgl_terima_barang' => input('tgl_terima_barang'),
            'harga_barang' => input('harga_barang'),
            'remark' => input('remark'),
            'tran_updated_date' => date('Y-m-d'),
            'tran_updated_by' => $this->session->userdata('user_login')['username']
        );

        $response = $this->General->update_record($data, ['id_tran' => input('id_tran')], 'tbl_transaksi');

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

    public function activePenbar()
    {
        $data = $this->General->fetch_records('tbl_transaksi', ['id_tran' => input('id_tran')]);
        if ($data[0]->is_active == 1) {
            $this->General->update_record(['is_active' => 0], ['id_tran' => input('id_tran')], 'tbl_transaksi');
            $message = "Data berhasil di non aktifkan!";
        } else {
            $this->General->update_record(['is_active' => 1], ['id_tran' => input('id_tran')], 'tbl_transaksi');
            $message = "Data berhasil di aktifkan!";
        }
        LogActivity($this->db->last_query());

        echo json_encode($message);
    }
}

/* End of file Barang.php */

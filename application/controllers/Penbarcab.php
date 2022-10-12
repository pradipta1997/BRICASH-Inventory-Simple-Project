<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penbarcab extends MY_Controller
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
        $this->header('List Penerimaan Barang Cabang');
        $this->load->view('Penbarcab/list_penbarcab');
        $this->footer();
    }

    public function listPenbarcab()
    {
        if ($this->session->userdata('user_login')['id_group'] == 1) {
            $where = ['id_jtran' => 1];
        } else {
            $where = ['id_uker' => $this->session->userdata('user_login')['id_uker'], 'id_jtran' => 1];
        }

        $list = $this->Serverside->_serverSide(
            'v_penbarcab',
            ['no', 'nama_uker', 'tipe_barang', 'kode_barang', 'nama_barang', 'no_sn', 'qty', 'remark', 'is_active'],
            ['nama_uker', 'tipe_barang', 'kode_barang', 'nama_barang', 'no_sn', 'remark'],
            ['id_tran' => 'desc'],
            $where,
            'data'
        );

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $results) {
            $buttonDisable = $results->is_active == 1  ? '' : 'disabled';
            $buttonHave = $results->is_have == 1  ? 'disabled' : '';
            $buttonWarna = $results->is_active == 1 ? 'danger' : 'success';
            $dariUker = $this->General->getRow('tbl_unit_kerja', ['id_uker' => $results->dari_uker]);

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $results->tgl_kirim_barang;
            $row[] = $results->tgl_terima_barang ? $results->tgl_terima_barang : '-';
            $row[] = $dariUker->nama_uker;
            $row[] = $results->nama_uker;
            $row[] = $results->tipe_barang;
            $row[] = $results->kode_barang;
            $row[] = $results->nama_barang;
            $row[] = $results->no_sn;
            $row[] = $results->qty;
            $row[] = $results->kon_barang;
            $row[] = $results->harga_barang;
            $row[] = $results->remark;
            $row[] = "<button type='button' class='btn btn-warning' " . getEditperm() . " $buttonDisable $buttonHave onclick='VPenbarcab($results->id_tran)'>
                        <i class='fa fa-pencil-square-o'></i>
                    </button>
                    <button type='button' class='btn btn-$buttonWarna' " . getActiveperm() . " $buttonHave onclick='activePenbarcab($results->id_tran)'>
                        <i class='fa fa-power-off' aria-hidden='true'></i>
                    </button>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('v_penbarcab'),
            "recordsFiltered" => $this->Serverside->_serverSide('v_penbarcab'),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function formPenbarcab()
    {
        if (input('id_tran')) {
            $this->_editPenbarcab();
        }
    }

    public function viewPenbarcab($id_tran)
    {
        $data = $this->General->fetch_records('v_penbarcab', ['id_tran' => $id_tran]);
        echo json_encode($data);
    }

    private function _editPenbarcab()
    {
        $cekNosn = $this->General->getJumlahData('tbl_transaksi', ['no_sn' => input('no_sn'), 'no_urut' => input('no_urut')]);

        if ($cekNosn > 0) {
            $data = array(
                'id_vendor' => 1,
                'is_have' => 1,
                'tgl_terima_barang' => input('tgl_terima_barang'),
                'remark' => input('remark'),
                'tran_updated_date' => date('Y-m-d'),
                'tran_updated_by' => $this->session->userdata('user_login')['username']
            );

            $response = $this->General->update_record($data, ['id_tran' => input('id_tran')], 'tbl_transaksi');

            if ($response) {
                LogActivity($this->db->last_query());
                $pesan = array(
                    'pesan' => 'Data berhasil di edit!',
                    'text' => '',
                    'tipe' => 'success'
                );

                echo json_encode($pesan);
            } else {
                $pesan = array(
                    'pesan' => 'Data gagal di edit!',
                    'text' => '',
                    'tipe' => 'error'
                );

                echo json_encode($pesan);
            }
        } else {
            $pesan = array(
                'pesan' => 'Data gagal di edit!',
                'text' => 'No sn tidak di ketahui!',
                'tipe' => 'error'
            );

            echo json_encode($pesan);
        }
    }
}

/* End of file Barang.php */

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pengbar extends MY_Controller
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
            'uker' => $this->General->fetch_records('tbl_unit_kerja', ['is_active' => 1, 'id_uker !=' => $this->session->userdata('user_login')['id_uker']])
        );

        cekPergroup();
        $this->header('List Pengeluaran Barang');
        $this->load->view('Pengbar/list_pengbar', $data);
        $this->footer();
    }

    public function listPengbar()
    {
        $list = $this->Serverside->_serverSide(
            'v_pengbar',
            ['no', 'nama_uker', 'tipe_barang',  'kode_barang', 'nama_barang', 'no_sn', 'harga_barang', 'qty', 'kon_barang', 'remark', 'is_active'],
            ['nama_uker', 'tipe_barang',  'kode_barang', 'nama_barang', 'no_sn', 'harga_barang', 'kon_barang'],
            ['id_tran' => 'desc'],
            ['id_jtran' => 1, 'id_uker !=' => $this->session->userdata('user_login')['id_uker']],
            'data'
        );
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $results) {
            $buttonDisable = $results->is_active == 1 ? '' : 'disabled';
            $buttonWarna = $results->is_active == 1 ? 'danger' : 'success';
            $buttonHave = $results->is_have == 1  ? 'disabled' : '';

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $results->tgl_kirim_barang;
            $row[] = $results->nama_uker;
            $row[] = $results->tipe_barang;
            $row[] = $results->kode_barang;
            $row[] = $results->nama_barang;
            $row[] = $results->no_sn;
            $row[] = $results->qty;
            $row[] = $results->kon_barang;
            $row[] = $results->harga_barang;
            $row[] = $results->remark;
            $row[] = "<button type='button' class='btn btn-warning' " . getEditperm() . " $buttonDisable $buttonHave onclick='VPengbar($results->id_tran)'>
                        <i class='fa fa-pencil-square-o'></i>
                    </button>
                    <button type='button' class='btn btn-$buttonWarna' " . getActiveperm() . " $buttonHave  onclick='activePengbar($results->id_tran)'>
                        <i class='fa fa-power-off' aria-hidden='true'></i>
                    </button>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('v_pengbar'),
            "recordsFiltered" => $this->Serverside->_serverSide('v_pengbar'),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function formPengbar()
    {
        if (input('id_tran')) {
            $this->_editPengbar();
        } else {
            $this->_savePengbar();
        }
    }

    private function _savePengbar()
    {
        $cekNosn = $this->General->getJumlahData('tbl_transaksi', ['no_sn' => input('no_sn'), 'no_urut' => input('no_urut')]);
        if ($cekNosn > 0) {
            $qtyBrg = $this->General->getRow('tbl_stock', ['no_urut' => input('no_urut'), 'id_uker' => $this->session->userdata('user_login')['id_uker']]);

            if ($qtyBrg->qty > 0) {
                $data = array(
                    'id_jtran' => 1,
                    'id_vendor' => 1,
                    'no_urut' => input('no_urut'),
                    'id_uker' => input('id_uker'),
                    'dari_uker' => $this->session->userdata('user_login')['id_uker'],
                    'tgl_kirim_barang' => input('tgl_kirim_barang'),
                    'no_sn' => input('no_sn'),
                    'kon_barang' => input('kon_barang'),
                    'harga_barang' => input('hbrg'),
                    'qty' => 1,
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
            } else {
                $pesan = array(
                    'pesan' => 'Stock barang ' . $qtyBrg->nama_barang . ' kosong!',
                    'tipe' => 'info'
                );

                echo json_encode($pesan);
            }
        } else {
            $pesan = array(
                'pesan' => 'No sn tidak di ketahui!',
                'tipe' => 'info'
            );

            echo json_encode($pesan);
        }
    }

    public function viewPengbar($id_tran)
    {
        $data = $this->General->fetch_records('v_pengbar', ['id_tran' => $id_tran]);
        echo json_encode($data);
    }

    private function _editPengbar()
    {
        $cekNosn = $this->General->getJumlahData('tbl_transaksi', ['no_sn' => input('no_sn'), 'no_urut' => input('no_urut')]);
        if ($cekNosn > 0) {
            $qtyBrg = $this->General->getRow('tbl_stock', ['no_urut' => input('no_urut'), 'id_uker' => $this->session->userdata('user_login')['id_uker']]);

            if ($qtyBrg->qty > 0) {
                $data = array(
                    'no_urut' => input('no_urut'),
                    'id_uker' => input('id_uker'),
                    'no_sn' => input('no_sn'),
                    'tgl_kirim_barang' => input('tgl_kirim_barang'),
                    'kon_barang' => input('kon_barang'),
                    'harga_barang' => input('hbrg'),
                    'qty' => 1,
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
            } else {
                $pesan = array(
                    'pesan' => 'Stock barang ' . $qtyBrg->nama_barang . ' kosong!',
                    'tipe' => 'info'
                );

                echo json_encode($pesan);
            }
        } else {
            $pesan = array(
                'pesan' => 'No sn tidak di ketahui!',
                'tipe' => 'info'
            );

            echo json_encode($pesan);
        }
    }

    public function activePengbar()
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

    public function cariNosn()
    {
        $no_sn = input('no_sn');
        $nm_brg = $this->General->fetch_records('v_nosn', ['no_sn' => $no_sn]);

        if ($nm_brg) {
            $brg = array(
                'no_urut' => $nm_brg[0]->no_urut,
                'nama_gbarang' => $nm_brg[0]->nama_gbarang,
                'nama_sgbarang' => $nm_brg[0]->nama_sgbarang,
                'nama_merek' => $nm_brg[0]->nama_merek,
                'tipe_barang' => $nm_brg[0]->tipe_barang,
                'kode_barang' => $nm_brg[0]->kode_barang,
                'nama_barang' => $nm_brg[0]->nama_barang,
                'harga_barang' => $nm_brg[0]->harga_barang,
            );

            echo json_encode($brg);
        } else {
            echo json_encode(false);
        }
    }
}

/* End of file Barang.php */

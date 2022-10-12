<?php
class Chained extends MY_Controller
{
    public function Listsubgroupbarang($id_gbarang = null)
    {
        $sgroupbarang = $this->General->select_where('tbl_sgbarang', ['id_gbarang' => $id_gbarang, 'is_active' => 1]);
        $lists = "<option value=''>Select Subgroup Barang</option>";
        if ($sgroupbarang) {
            foreach ($sgroupbarang as $data) {
                $lists .= "<option value='" . $data['id_sgbarang'] . "'>" . $data['nama_sgbarang'] . "</option>";
            }
        }
        echo json_encode($lists);
    }

    public function Listmerekbarang($id_sgbarang = null)
    {
        $mbarang = $this->General->select_where('tbl_merek', ['id_sgbarang' => $id_sgbarang, 'is_active' => 1]);
        $lists = "<option value=''>Select Merek Barang</option>";
        if ($mbarang) {
            foreach ($mbarang as $data) {
                $lists .= "<option value='" . $data['id_merek'] . "'>" . $data['nama_merek'] . "</option>";
            }
        }
        echo json_encode($lists);
    }

    public function Listtipebarang($id_merek = null)
    {
        $tbarang = $this->General->select_where('tbl_tipe_barang', ['id_merek' => $id_merek, 'is_active' => 1]);
        $lists = "<option value=''>Select Tipe Barang</option>";
        if ($tbarang) {
            foreach ($tbarang as $data) {
                $lists .= "<option value='" . $data['id_tipe_barang'] . "'>" . $data['tipe_barang'] . "</option>";
            }
        }
        echo json_encode($lists);
    }

    public function Listbarang($id_tipe_barang = null)
    {
        $barang = $this->General->select_where('tbl_barang', ['id_tipe_barang' => $id_tipe_barang, 'is_active' => 1]);
        $lists = "<option value=''>Select Nama Barang</option>";
        if ($barang) {
            foreach ($barang as $data) {
                $lists .= "<option value='" . $data['no_urut'] . "'>" . $data['kode_barang'] . " | " . $data['nama_barang'] . "</option>";
            }
        }
        echo json_encode($lists);
    }
}

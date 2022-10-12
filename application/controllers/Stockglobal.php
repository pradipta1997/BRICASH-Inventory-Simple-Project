<?php
class Stockglobal extends MY_Controller
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
        $data['stockglobal'] = $this->General->fetch_records("v_stockglobal");
        $this->header('List Barang Global');
        $this->load->view('Barang/list_stockglobal', $data);
        $this->footer();
    }

    public function detailStock()
    {
        $no_urut = input('no_urut');
        $data = $this->General->fetch_records("v_detailstock", ['no_urut' => $no_urut]);
        echo json_encode($data);
    }
}

<?php
class Stockbarang extends MY_Controller
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
        $data['stockbarang'] = $this->General->fetch_records("v_stockbarang", ['id_uker' => $this->session->userdata('user_login')['id_uker']]);
        $this->header('List Barang Global');
        $this->load->view('Barang/list_stockbarang', $data);
        $this->footer();
    }
}

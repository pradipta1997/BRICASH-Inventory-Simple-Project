<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller
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
            'all_user' => $this->General->getbyId('COUNT(*) as jumlah', 'tbl_user'),
            'active_user' => $this->General->getbyId('COUNT(*) as jumlah', 'tbl_user', ['is_active' => 1]),
            'inactive_user' => $this->General->getbyId('COUNT(*) as jumlah', 'tbl_user', ['is_active' => 0]),
        );

        $this->session->set_userdata("parent_name", "Dashboard");
        $this->header('Dashboard');
        $this->main_content($data);
        $this->footer();
    }
}

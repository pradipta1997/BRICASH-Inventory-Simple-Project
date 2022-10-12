<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function cetak_die($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}

function cetak($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function lastq()
{
    $ci = &get_instance();
    die($ci->db->last_query());
}

function lastz()
{
    $ci = &get_instance();
    $ci->db->last_query();
}

function HistoryLoginAndLogout($status)
{
    $ci = &get_instance();
    $id_user = $ci->session->userdata('user_login')['id_user'];

    $data = array(
        'id_user' => $id_user,
        'date_log' => date('Y-m-d H:i:s'),
        'status' => $status,
        'nama_pc' => php_uname(),
        'ip_address' => getHostByName(php_uname('n'))
    );

    $ci->General->insertRecord('tbl_log_login', $data);
}

function LogActivity($query)
{
    $ci = &get_instance();
    $id_user = $ci->session->userdata('user_login')['id_user'];

    $data = array(
        'id_user' => $id_user,
        'query' => $query
    );

    $ci->General->insertRecord('tbl_user_log', $data);
}

function cekPergroup()
{
    $ci = &get_instance();
    $group_id = $ci->session->userdata("user_login")['id_group'];

    if ($group_id != 1) {
        $ci->General->check_url_permission_single();
    }
}

function input($string)
{
    $ci = &get_instance();
    return trim($ci->input->post($string));
}

function statusActiveNonactive($is_active)
{
    if ($is_active == 1) {
        return '<span class="label label-success">Active</span>';
    } else {
        return '<span class="label label-danger">Non Active</span>';
    }
}

function statusHave($is_have)
{
    if ($is_have == 1) {
        return '<span class="label label-success">Sudah diterima!</span>';
    } else {
        return '<span class="label label-danger">Belum diterima!</span>';
    }
}

function getEditperm()
{
    $CI = &get_instance();

    $editPerm = "";

    $id_menu = $CI->session->userdata("id_menu");

    if (!empty($id_menu) && $CI->session->userdata("user_login")['id_group']  != 1) {
        $id_sgroup = $CI->session->userdata("user_login")['id_sgroup'];
        $permissionResult = $CI->General->fetch_CoustomQuery("SELECT * FROM `tbl_user_permission` WHERE id_sgroup = $id_sgroup AND id_menu = $id_menu");

        foreach ($permissionResult as $permissionResults) {
            if ($permissionResults->per_update == 1) {
                $editPerm = "";
            } elseif ($permissionResults->per_update == 0) {
                $editPerm = "style='display:none;'";
            }
        }
    } else {
        $editPerm = "";
    }

    return $editPerm;
}

function getActiveperm()
{
    $CI = &get_instance();

    $ActivePerm = "";

    $id_menu = $CI->session->userdata("id_menu");

    if (!empty($id_menu) && $CI->session->userdata("user_login")['id_group']  != 1) {
        $id_sgroup = $CI->session->userdata("user_login")['id_sgroup'];
        $permissionResult = $CI->General->fetch_CoustomQuery("SELECT * FROM `tbl_user_permission` WHERE id_sgroup = $id_sgroup AND id_menu = $id_menu");

        foreach ($permissionResult as $permissionResults) {
            if ($permissionResults->per_delete == 1) {
                $ActivePerm = "";
            } elseif ($permissionResults->per_delete == 0) {
                $ActivePerm = "style='display:none;'";
            }
        }
    } else {
        $ActivePerm = "";
    }

    return $ActivePerm;
}

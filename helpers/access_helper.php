<?php

function is_logged_in()
{

    $ci = get_instance();

    if (!$ci->session->userdata('email')) {
        redirect('autentikasi');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('autentikasi/blocked');
        }
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $result = $ci->db->get_where('user_access_menu', [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ]);

    if ($result->num_rows() > 0) {
        return "checked = 'checked'";
    }
}

function check_cookie($cookie, $user_agent)
{

    $ci = get_instance();

    $result = $ci->db->get_where('remember_me', ['token' => $cookie, 'user_agent' => $user_agent])->row_array();
    if ($result) {
        $user = $ci->db->get_where('user', ['email' => $result['email']])->row_array();
        $data = [
            'email' => $user['email'],
            'role_id' => $user['role_id'],
            'id_user' => $user['id']
        ];

        return $ci->session->set_userdata($data);
    }
}

function rupiah($angka){

	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;

}

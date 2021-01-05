<?php 

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('user_login')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $controller = $ci->uri->segment(1);
        $action = $ci->uri->segment(2);
        if($action){
            $menu = $controller.'/'.$action;            
        }else{
            $menu = $controller;
        }    
        $queryMenu = $ci->db->get_where('tbl_menu', ['url' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('tbl_rolexmenu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        
        
        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}
<?php 

function set_my_cookie()
{
    $ci = get_instance();
    
    $minutes_to_add = MYSESSEXP/60;
    $time = new DateTime();
    $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

    $stamp = $time->format('Y-m-d H:i');
    $forCookie="user_login=".$ci->session->userdata('user_login')."&"."ExpiredOn=".$stamp;
    set_cookie('user_data',$forCookie,MYSESSEXP); 
    
}

function get_my_cookie()
{
    $data = array("cookie" => get_cookie('user_data'));
    echo json_encode($data);
}
    
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('user_login')) {
        redirect('auth');
    } else {
        set_my_cookie();
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

        if($queryMenu){
            if ($userAccess->num_rows() < 1) {
                redirect('auth/blocked');
            }else{
                
            }
        }
        
    }
}

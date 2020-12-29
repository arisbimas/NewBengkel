<?php 


class User_model extends CI_Model
{
    public function listUsers()
    {
        return $this->db->get_where('tbl_users')->result_array();
    }
    public function insertNewUser($data)
    {                        
        return $this->db->insert('tbl_users', $data);
    }

    public function getUserByUserLogin($user_login)
    {
        return $this->db->get_where("tbl_users", ["user_login" => $user_login])->row_array();
    }

     public function getUserRoleByRoleId($user_role)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->join('tbl_role', 'tbl_role.id = tbl_users.role_id');
        $this->db->where('tbl_role.id', $user_role);
        $query = $this->db->get();
        return $query->row_array();
    }
    
}

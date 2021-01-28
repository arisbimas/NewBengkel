<?php 


class User_model extends CI_Model
{
    var $table = 'tbl_users';
    var $column_order = array(null, 'user_login','name','image','role_id','is_active', 'role_name'); //set column field database for datatable orderable
    var $column_search = array('user_login','name','image','role_id','is_active', 'role_name'); //set column field database for datatable searchable 
    var $order = array('name' => 'asc'); // default order

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

    public function listRole()
    {
        return $this->db->get_where('tbl_role')->result();
    }

    public function update_user($data)
    {
        return  $this->db->update("tbl_users", $data,array('user_login' => $data["user_login"]));
    }
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
        $this->db->join('tbl_role', 'tbl_users.role_id = tbl_role.id');
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {            
            $this->db->where('is_active', true);
            //add custom filter here
            

            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
}

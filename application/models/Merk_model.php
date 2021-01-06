<?php 


class Merk_model extends CI_Model
{
    var $table = 'tbl_merk';
    var $column_order = array(null, 'nama_merk','is_active'); //set column field database for datatable orderable
    var $column_search = array('nama_merk','is_active'); //set column field database for datatable searchable 
    var $order = array('nama_merk' => 'asc'); 
    
    public function getAllMerk()
    {                
        $this->db->from($this->table);
        $this->db->order_by('nama_merk','asc');
        $query = $this->db->get();
        $merks = $query->result();

        // $merks = array();
        // foreach ($result as $row) 
        // {
        //     $merks[] = $row->nama_merk;
        // }
        
        return $merks;
    }

    public function insert_new_merk($data)
    {
        return $this->db->insert('tbl_merk', $data);
    }

    public function delete_merk($id_merk)
    {        
        $this->db->set('is_active', "false", FALSE);
        $this->db->where('id_merk', $id_merk);
        return $this->db->update('tbl_merk');
    }

    public function get_merk_by_id($id_merk)
    {
        $this->db->select("*");
        $this->db->from("tbl_merk");
        $this->db->where("id_merk", $id_merk);
        $query = $this->db->get();
        if(count($query->result()) > 0){
            return $query->row(); 
        }
    }

    public function update_merk($data)
    {
        return  $this->db->update("tbl_merk", $data,array('id_merk' => $data["id_merk"]));
    }

    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {            
            $this->db->where('is_active', true);
            //add custom filter here
            if($this->input->post('merk_filter'))
            {
                $this->db->where('id_merk', $this->input->post('merk_filter'));
            }

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

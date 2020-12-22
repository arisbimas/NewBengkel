<?php 


class Merk_model extends CI_Model
{
    var $tablemerk = 'tbl_merk';
    public function getAllMerk()
    {                
        $this->db->from($this->tablemerk);
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
    
}

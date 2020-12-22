<?php 


class Peoples_model extends CI_Model
{
    public function getAllData()
    {
        return $this->db->get("peoples")->result_array();
    }

    public function getPeoples($limit, $start, $keyword = null)
    {
        if($keyword){
            $this->db->like('nama', $keyword);
        }
        return $this->db->get("peoples", $limit,$start)->result_array();
    }

    public function countAllPeoples()
    {
        return $this->db->get("peoples")->num_rows();
    }
}
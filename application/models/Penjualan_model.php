<?php 

class Penjualan_model extends CI_Model
{
    public function insert_new_penjualan($data)
    {
        return $this->db->insert('tbl_penjualan', $data);
    }

    public function insert_new_detail_penjualan($data)
    {
        return $this->db->insert_batch('tbl_detail_penjualan', $data);
    }
}
<?php 


class Barang_model extends CI_Model
{
    var $table = 'tbl_barang';
    var $column_order = array(null, 'nama_brg','id_merk','merk','harga_beli','harga_jual','stok','is_active'); //set column field database for datatable orderable
    var $column_search = array('nama_brg','id_merk','merk','harga_beli','harga_jual','stok','is_active'); //set column field database for datatable searchable 
    var $order = array('kode_barang' => 'asc'); // default order
    
    public function getAllBarang()
    {
        return $this->db->get("tbl_barang")->result_array();
    }

    public function getAllBarang_Count()
    {
        return $this->db->get("tbl_barang")->num_rows();
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

    public function insert_new_barang($data)
    {
        return $this->db->insert('tbl_barang', $data);
    }

    public function delete_barang($id)
    {        
        $this->db->set('is_active', "false", FALSE);
        $this->db->where('kode_barang', $id);
        return $this->db->update('tbl_barang');
    }
}

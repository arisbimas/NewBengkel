<?php 

class Penjualan_model extends CI_Model
{
    var $table = 'tbl_penjualan';
    var $column_order = array(null, 'nomor_faktur','total_harga','created_by','created_on'); //set column field database for datatable orderable
    var $column_search = array('nomor_faktur','total_harga','created_by','created_on'); //set column field database for datatable searchable 
    var $order = array('nomor_faktur' => 'asc'); // default order

    public function insert_new_penjualan($data)
    {
        return $this->db->insert('tbl_penjualan', $data);
    }

    public function insert_new_detail_penjualan($data)
    {
        return $this->db->insert_batch('tbl_detail_penjualan', $data);
    }

    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {            
            //$this->db->where('is_active', true);
            //add custom filter here
            if($this->input->post('date_filter'))
            {
                $time = strtotime($this->input->post('date_filter'));
                $newformat = date('Y-m-d',$time);

                // var_dump($newformat);
                // exit;
                //$this->db->where('tgl_transaksi', $newformat);
                $this->db->where("DATE_FORMAT(created_on,'%Y-%m-%d') >=", $newformat);
                // $this->db->select("SELECT * FROM tbl_penjualan as pnj where DATE_FORMAT(pnj.created_on, '%Y-%m-%d') >= '2021-01-07'");
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

    public function get_detail_penjualan_by_faktur($nomor_faktur)
    {        
        return $this->db->get_where("tbl_detail_penjualan", ["nomor_faktur"=> $nomor_faktur])->result_array();
    }

    public function getDataPenjualanByDay()
    {
        $now = date("Y-m-d");
        return $this->db->get_where("tbl_detail_penjualan",["DATE_FORMAT(created_on,'%Y-%m-%d') "=>$now])->result_array();
    }

    public function getDataPenjualanByWeek()
    {
        $date =  mktime(0, 0, 0, date("m"), date("d")-7, date("Y"));        
        $mingguLalu = date("Y-m-d", $date);
        $now = date("Y-m-d");

        return $this->db->get_where("tbl_detail_penjualan",["DATE_FORMAT(created_on,'%Y-%m-%d') >="=>$mingguLalu, "DATE_FORMAT(created_on,'%Y-%m-%d') <="=>$now])->result_array();
    }

    public function getDataPenjualanByMonth()
    {
        $now = date("Y-m");
        return $this->db->get_where("tbl_detail_penjualan",["DATE_FORMAT(created_on,'%Y-%m')"=>$now])->result_array();
    }
    
}
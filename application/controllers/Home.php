<?php 

class Home extends CI_Controller 
{
     public function __construct()
    {
        parent::__construct();
        $this->load->model("Barang_model", 'barang');
        $this->load->model("Merk_model", 'merk');

        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["judul"] = "Halaman Home";
        $data["barang"] = $this->barang->getAllBarang();
        $data["jumlah_barang"] = $this->barang->getAllBarang_Count();

        //create select option
        $merks = $this->merk->getAllMerk(); 
        $opt = array('' => 'Semua Merk');
        foreach ($merks as $merk) {
            $opt[$merk->id_merk] = $merk->nama_merk;
        }
        $data['form_merk'] = form_dropdown('apa',$opt,'','id="merk_filter" class="form-control"');


        $this->load->view("templates/header", $data);
        $this->load->view("home/index");
        $this->load->view("templates/footer");
    }

    function serialize_ke_string($serial)
    {
        $hasil = unserialize($serial);
        return implode(', ', $hasil);
    }

    public function ListBarang()
    {
        $list = $this->barang->get_datatables();
        // $data = array();
        // $no = $_POST['start'];
        // foreach ($list as $barang) {
        //     $no++;
        //     $row = array();
        //     $row[] = $no;
        //     $row[] = $barang->id_brg;
        //     $row[] = $barang->nama_brg;
        //     $row[] = $barang->id_merk;
        //     $row[] = $barang->merk;
        //     $row[] = $barang->kompatibilitas;
        //     $row[] = $barang->harga_beli;
        //     $row[] = $barang->harga_jual;
        //     $row[] = $barang->stok;
        //     $row[] = $barang->id_brg;
        //     $data[] = $row;
        // }
 
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->barang->count_all(),
                    "recordsFiltered" => $this->barang->count_filtered(),
                    "data" => $list,
                );
        //output to json format
        echo json_encode($output);
    }

    public function AddBarang()
    {
        
    }

    private function kd_barang() {
    $ci = &get_instance();
    $chek = $ci->db->query("select kd_barang from tbl_barang order by kd_barang DESC");
    if ($chek->num_rows() > 0) {
        $chek=$chek->row_array();
        $laskode = $chek['kd_barang'];
        $ambil = substr($laskode, 2, 3) + 1;
        $newcode = "BR" . sprintf("%03s", $ambil);
        return $newcode;
    }else{
        return 'BR001';  
    }
}
}

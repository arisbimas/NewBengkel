<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        if($this->input->is_ajax_request()){

        }else{
            is_logged_in();
        }        

        $this->load->model("Barang_model", 'barang');
        $this->load->model("Merk_model", 'merk');
        $this->load->model("User_model", 'users');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["judul"] = "Master Barang";
        $data['user'] = $this->users->getUserByUserLogin($this->session->userdata('user_login'));
        $data["barang"] = $this->barang->getAllBarang();
        // $data["jumlah_barang"] = $this->barang->getAllBarang_Count();

        //create select option
        $merks = $this->merk->getAllMerk(); 
        $opt = array('' => 'Semua Merk');
        foreach ($merks as $merk) {
            $opt[$merk->id_merk] = $merk->nama_merk;
        }
        $data['form_merk'] = form_dropdown('',$opt,'','id="merk_filter" class="form-control"');
        $data['form_merk_add'] = form_dropdown('',$opt,'','id="txt_AddBarang_Merk" class="form-control"');
        $data['form_merk_edit'] = form_dropdown('',$opt,'','id="txt_EditBarang_Merk" class="form-control"');

        $this->load->view("templates/header", $data);
        $this->load->view("barang/index");
        $this->load->view("templates/footer");
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
        //     $row[] = $barang->nama_barang;
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

    function kd_barang() {
        $ci = &get_instance();
        $chek = $ci->db->query("select kode_barang from tbl_barang order by kode_barang DESC");
        if ($chek->num_rows() > 0) {
            $chek=$chek->row_array();
            $laskode = $chek['kode_barang'];
            $ambil = substr($laskode, 2, 4) + 1;
            $newcode = "BR" . sprintf("%04s", $ambil);
            return $newcode;
        }else{
            return 'BR0001';  
        }
    }

    public function AddBarang()
    {        
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
            $this->form_validation->set_rules('id_merk', 'Merk', 'required');
            $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');
            $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
            $this->form_validation->set_rules('stok', 'Jumlah', 'required|numeric');
            $this->form_validation->set_rules('diskon', 'Diskon', 'required|numeric');

            if($this->form_validation->run() == FALSE){
                $data = array("response" => "error", "message" => validation_errors());
            }else{
                $ajax_data = $this->input->post();                
                $ajax_data["kode_barang"] = $this->kd_barang();
                $ajax_data["created_on"] = date('Y-m-d H:i:s');
                $ajax_data["modified_on"] = date('Y-m-d H:i:s');
                $ajax_data["created_by"] = $this->session->userdata('user_login');
                $ajax_data["modified_by"] = $this->session->userdata('user_login');
                                
                if($this->barang->insert_new_barang($ajax_data)){
                    $data = array("response" => "success", "message" => "Transaksi Berhasil Disimpan.");
                }else{
                    $data = array("response" => "error", "message" => "Transaksi Gagal Disimpan.");
                }
            }
        }else{
            echo("No direct script access allowed");
        }

        echo json_encode($data);
    }

    public function DeleteBarang()
    {
        if($this->input->is_ajax_request()){
            $id = $this->input->post('id_brg');
            if($this->barang->delete_barang($id)){
                $data = array("response" => "success", "message" => "Data Updated Successfully.");
            }else{
                $data = array("response" => "error", "message" => "Failed Update Data.");
            }
        }else{
            echo("No direct script access allowed");
        }
        echo json_encode($data);
    }

    public function GetBarangById()
    {
        if($this->input->is_ajax_request()){
            $id = $this->input->post('id_brg');
            if($post = $this->barang->get_barang_by_id($id)){
                $data = array("response" => "success", "message" => "Data Berhasil Didapat.", 'post'=>$post);
            }else{
                $data = array("response" => "error", "message" => "Data Gagal Didapat.");
            }
        }else{
            echo("No direct script access allowed");
        }
        echo json_encode($data);
    }
    
    public function EditBarang()
    {        
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
            $this->form_validation->set_rules('id_merk', 'Merk', 'required');
            $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');
            $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
            $this->form_validation->set_rules('stok', 'Jumlah', 'required|numeric');
            $this->form_validation->set_rules('diskon', 'Diskon', 'required|numeric');

            if($this->form_validation->run() == FALSE){
                $data = array("response" => "error", "message" => validation_errors());
            }else{
                $ajax_data = $this->input->post();                
                // $ajax_data["kode_barang"] = $this->kd_barang();
                $ajax_data["tgl_msk"] = date('Y-m-d H:i:s');
                                
                if($this->barang->update_barang($ajax_data)){
                    $data = array("response" => "success", "message" => "Data Berhasil Diubah.");
                }else{
                    $data = array("response" => "error", "message" => "Data Gagal Diubah.");
                }
            }
        }else{
            echo("No direct script access allowed");
        }

        echo json_encode($data);
    }
}

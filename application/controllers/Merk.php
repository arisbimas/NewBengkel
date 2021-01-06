<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Merk extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        if($this->input->is_ajax_request()){

        }else{
            is_logged_in();
        }        

        $this->load->model("Merk_model", 'merk');
        $this->load->model("User_model", 'users');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["judul"] = "Master Merk";
        $data['user'] = $this->users->getUserByUserLogin($this->session->userdata('user_login'));        

        $this->load->view("templates/header", $data);
        $this->load->view("merk/index");
        $this->load->view("templates/footer");
    }

    public function ListMerk()
    {
        $list = $this->merk->get_datatables();
        
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->merk->count_all(),
                    "recordsFiltered" => $this->merk->count_filtered(),
                    "data" => $list,
                );
        //output to json format
        echo json_encode($output);
    }

    function kd_merk() {
        $ci = &get_instance();
        $chek = $ci->db->query("select kode_merk from tbl_merk order by kode_merk DESC");
        if ($chek->num_rows() > 0) {
            $chek=$chek->row_array();
            $laskode = $chek['kode_merk'];
            $ambil = substr($laskode, 2, 4) + 1;
            $newcode = "BR" . sprintf("%04s", $ambil);
            return $newcode;
        }else{
            return 'BR0001';  
        }
    }

    public function AddMerk()
    {        
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules('nama_merk', 'Nama Merk', 'required|is_unique[tbl_merk.nama_merk]');

            if($this->form_validation->run() == FALSE){
                $data = array("response" => "error", "message" => validation_errors());
            }else{
                $ajax_data = $this->input->post();                
                $ajax_data["is_active"] = true;
                                
                if($this->merk->insert_new_merk($ajax_data)){
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

    public function DeleteMerk()
    {
        if($this->input->is_ajax_request()){
            $id_merk = $this->input->post('id_merk');
            if($this->merk->delete_merk($id_merk)){
                $data = array("response" => "success", "message" => "Data Updated Successfully.");
            }else{
                $data = array("response" => "error", "message" => "Failed Update Data.");
            }
        }else{
            echo("No direct script access allowed");
        }
        echo json_encode($data);
    }

    public function GetMerkById()
    {
        if($this->input->is_ajax_request()){
            $id_merk = $this->input->post('id_merk');
            if($post = $this->merk->get_merk_by_id($id_merk)){
                $data = array("response" => "success", "message" => "Data Berhasil Didapat.", 'post'=>$post);
            }else{
                $data = array("response" => "error", "message" => "Data Gagal Didapat.");
            }
        }else{
            echo("No direct script access allowed");
        }
        echo json_encode($data);
    }
    
    public function EditMerk()
    {        
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules('nama_merk', 'Nama Merk', 'required|is_unique[tbl_merk.nama_merk]');

            if($this->form_validation->run() == FALSE){
                $data = array("response" => "error", "message" => validation_errors());
            }else{
                $ajax_data = $this->input->post();                
                // $ajax_data["kode_merk"] = $this->kd_merk();
                $ajax_data["tgl_msk"] = date('Y-m-d H:i:s');
                                
                if($this->merk->update_merk($ajax_data)){
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
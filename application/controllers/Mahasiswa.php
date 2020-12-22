<?php 

class Mahasiswa extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Mahasiswa_model");    
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["judul"] = "Halaman Mahasiswa";

        $data["mahasiswa"] = $this->Mahasiswa_model->getAllMhs();
        if($this->input->post('keyword')){
            $data["mahasiswa"] = $this->Mahasiswa_model->cariDataMhs();
        }
        $this->load->view("templates/header", $data);
        $this->load->view("mahasiswa/index", $data);
        $this->load->view("templates/footer");
    }

    public function tambahMsh()
    {
        $this->form_validation->set_rules('nama', 'Name', 'required');
        $this->form_validation->set_rules('npm', 'NPM', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if($this->form_validation->run()== FALSE){
            $data["judul"] = "Tambah Mahasiswa";
            $this->load->view("templates/header", $data);
            $this->load->view("mahasiswa/tambah");
            $this->load->view("templates/footer");
        }else{
            $this->Mahasiswa_model->tambahDataMhs();
            $this->session->set_flashdata('flash', 'Berhasil Ditambahkan.');
            redirect('mahasiswa');
        }       
    }

    public function hapusMhs($id)
    {
        $this->Mahasiswa_model->hapusDataMhs($id);
        $this->session->set_flashdata('flash', 'Berhasil Dihapus.');
        redirect('mahasiswa');
    }

    public function detailMhs($id)
    {
        $data["judul"] = "Detail Mahasiswa";
        $data["mahasiswa"] = $this->Mahasiswa_model->getMhsById($id);
        $this->load->view("templates/header", $data);
        $this->load->view("mahasiswa/detail", $data);
        $this->load->view("templates/footer");
    }

    public function editMhs($id)
    {
        $data["judul"] = "Edit Mahasiswa";
        $data["mahasiswa"] = $this->Mahasiswa_model->getMhsById($id);
        $data["jurusan"] = ["TI","SI"];

        $this->form_validation->set_rules('nama', 'Name', 'required');
        $this->form_validation->set_rules('npm', 'NPM', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if($this->form_validation->run()== FALSE){            
            $this->load->view("templates/header", $data);
            $this->load->view("mahasiswa/edit", $data);
            $this->load->view("templates/footer");
        }else{
            $this->Mahasiswa_model->editDataMhs();
            $this->session->set_flashdata('flash', 'Berhasil Diedit.');
            redirect('mahasiswa');
        }       
    }
}

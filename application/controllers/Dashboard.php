<?php 

class Dashboard extends CI_Controller 
{
     public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Barang_model", 'barang');
        $this->load->model("Merk_model", 'merk');
        $this->load->model("User_model", 'users');

        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["judul"] = "Dashboard";
        $data['user'] = $this->users->getUserByUserLogin($this->session->userdata('user_login'));

        $this->load->view("templates/header", $data);
        $this->load->view("dashboard/index");
        $this->load->view("templates/footer");
    }
}

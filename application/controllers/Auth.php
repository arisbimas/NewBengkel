<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->library("form_validation");
        $this->load->model("User_model", 'users');    
	}

	public function index()
	{
		if ($this->session->userdata('user_login')) {
			redirect('user');
        }
        $data['title'] = "Login Page";

		$this->form_validation->set_rules("user_login", "User Login", "required|trim");
		$this->form_validation->set_rules("password", "Password", "required|trim");
		if ($this->form_validation->run() == false) {
			$this->load->view("templates/auth_header", $data);
			$this->load->view("auth/login");
			$this->load->view("templates/auth_footer");
		} else {
			$this->_login();
		}
	}	

	private function _login()
	{
		$user_login = $this->input->post("user_login");
		$password = $this->input->post("password");

		$user = $this->users->getUserByUserLogin($user_login);
		if ($user) {
			//jika user active
			if ($user['is_active'] == 1) {
				//cek password
				if (password_verify($password, $user['password'])) {
					$data = [
						"user_login" => $user["user_login"],
						"role_id" => $user["role_id"]
					];

					$this->session->set_userdata($data);
					set_my_cookie();

					if ($user['role_id'] == 1) {
						redirect('dashboard');
					} else {
						redirect('user');
					}
					
					
				} else {
					$this->session->set_flashdata("message", '<div class="alert alert-danger" role="alert">Invalid Password.</div>');
					redirect("auth");
				}
			} else {
				$this->session->set_flashdata("message", '<div class="alert alert-danger" role="alert">User Login is not Active.</div>');
				redirect("auth");
			}
		} else {
			$this->session->set_flashdata("message", '<div class="alert alert-danger" role="alert">User Login is not Registered.</div>');
			redirect("auth");
		}
	}

	public function registration()
	{
		if ($this->session->userdata('user_login')) {
			redirect('user');
		}

        $data['title'] = "Register Page";

		$this->form_validation->set_rules('name', "Name", 'required|trim');
		$this->form_validation->set_rules('user_login', "User Login", 'required|trim|is_unique[tbl_users.user_login]');
		$this->form_validation->set_rules('password1', "Password", 'required|trim|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', "Repeat Password", 'required|trim|matches[password1]');
		
		if ($this->form_validation->run() == false) {
			$this->load->view("templates/auth_header", $data);
			$this->load->view("auth/register");
			$this->load->view("templates/auth_footer");
		} else {
			$data = [
                'user_login' => htmlspecialchars($this->input->post("user_login", true)),
                'name' => htmlspecialchars($this->input->post("name", true)),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post("password1"), PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 1,
				'date_created' => date('Y-m-d H:i:s')
			];
			if($this->users->insertNewUser($data)){
                $this->session->set_flashdata("message", '<div class="alert alert-success" role="alert">Congratulation! your account has been created. Please Login.</div>');
                redirect("auth");
            }else{
                $this->session->set_flashdata("message", '<div class="alert alert-danger" role="alert">Error! Can`t add new user.</div>');
                redirect("auth/registration");
            }
			
		}
	}

	public function logout()
	{
		$cookie = get_cookie("user_data");
        if($cookie){
            $listCookie = explode("&",$cookie);
            $explodeUserLogin = $listCookie[0];
			$explodeUserLoginName= explode("=", $explodeUserLogin);
			if($explodeUserLoginName[1] == $this->session->userdata('user_login')){
				
				$this->session->unset_userdata("user_login");
				$this->session->unset_userdata("role_id");
				delete_cookie('user_data');
				$this->session->set_flashdata("message", '<div class="alert alert-success" role="alert">You has been logout.</div>');	
				if($this->input->is_ajax_request()){
					$data = array("response"=> "success", "message"=>"User berhasil logout.");
					echo json_encode($data);
				}else{											
					redirect("auth");
				}
			}
        }			
	}

	public function blocked()
	{
		$data['title'] = "Access Forbiden";
		$this->load->view("templates/auth_header", $data);
		$this->load->view("auth/block");
		$this->load->view("templates/auth_footer");
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
        $this->load->library("form_validation");
        $this->load->model("User_model", "users");
	}

	public function index()
	{
		$data['title'] = "My Profile";
		$data['user'] = $this->users->getUserByUserLogin($this->session->userdata('user_login'));
		$data['user_role'] = $this->users->getUserRoleByRoleId($this->session->userdata('role_id'));
		$this->load->view("templates/header", $data);
		$this->load->view("user/index", $data);
		$this->load->view("templates/footer");
    }
    
    public function listuser()
	{
        $data['title'] = "List User";
        $data['user'] = $this->users->getUserByUserLogin($this->session->userdata('user_login'));
        $data['listuser'] = $this->users->listUsers();        
		$this->load->view("templates/header", $data);
		$this->load->view("user/list-user", $data);
		$this->load->view("templates/footer");
	}

	public function edit()
	{
		$data['title'] = "Edit Profile";
		$data['user'] = $this->db->get_where('users', ['email' =>
		$this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('name', 'Name', 'required|trim');

		if ($this->form_validation->run() == false) {
			$this->load->view("template/header", $data);
			$this->load->view("template/sidebar", $data);
			$this->load->view("template/topbar", $data);
			$this->load->view("user/edit", $data);
			$this->load->view("template/footer");
		} else {
			$name = $this->input->post('name');
			$email = $this->input->post('email');

			//file 			
			$config['max_height']           = 768;

			$upload_image = $_FILES['image']['name'];
			if ($upload_image) {
				$config['upload_path']          = './assets/img/profile';
				$config['allowed_types']        = 'gif|jpg|png';
				$config['max_size']             = 2048; //2mb

				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image')) {
					//hapus foto lama di folder asset
					//ambil dari var $data
					$old_image = $data['user']['image'];
					if ($old_image != 'default.jpg') {
						unlink(FCPATH . 'assets/img/profile/' . $old_image);
					}
					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);
				} else {
					echo $this->upload->display_errors();
				}
			}


			$this->db->set('name', $name);
			$this->db->where('email', $email);
			$this->db->update('users');

			$this->session->set_flashdata("message", '<div class="alert alert-success" role="alert">Profile updated.</div>');
			redirect("user");
		}
	}

	public function changepassword()
	{
		$data['title'] = "Change Password";
		$data['user'] = $this->db->get_where('users', ['email' =>
		$this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
		$this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password2]');

		if ($this->form_validation->run() == false) {
			$this->load->view("template/header", $data);
			$this->load->view("template/sidebar", $data);
			$this->load->view("template/topbar", $data);
			$this->load->view("user/change-password", $data);
			$this->load->view("template/footer");
		} else {
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password1');

			if (!password_verify($current_password, $data['user']['password'])) {
				$this->session->set_flashdata("message", '<div class="alert alert-danger" role="alert">Wrong Current Password.</div>');
				redirect("user/changepassword");
			} else {
				if ($current_password == $new_password) {
					$this->session->set_flashdata("message", '<div class="alert alert-danger" role="alert">New Password can`t be same with Current Password.</div>');
					redirect("user/changepassword");
				} else {
					$password_hash = password_hash($new_password, PASSWORD_DEFAULT);

					$this->db->set('password', $password_hash);
					$this->db->where('email', $this->session->userdata('email'));
					$this->db->update('users');

					$this->session->set_flashdata("message", '<div class="alert alert-success" role="alert">Password Changed.</div>');
					redirect("user/changepassword");
				}
			}
		}
	}
}

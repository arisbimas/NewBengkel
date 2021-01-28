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

	#region Views
	public function index()
	{
		$data['judul'] = "My Profile";
		$data['user'] = $this->users->getUserByUserLogin($this->session->userdata('user_login'));
		$data['user_role'] = $this->users->getUserRoleByRoleId($this->session->userdata('role_id'));
		$this->load->view("templates/header", $data);
		$this->load->view("user/index", $data);
		$this->load->view("templates/footer");
    }
    
    public function listuser()
	{
        $data['judul'] = "List User";
		$data['user'] = $this->users->getUserByUserLogin($this->session->userdata('user_login'));
		//create select option
        $role = $this->users->listRole(); 
        $opt = array('' => 'Semua Role');
        foreach ($role as $r) {
            $opt[$r->id] =  $r->role_name;
		}
		$data['form_role'] = form_dropdown('',$opt,'','id="txt_AddUser_Role" name="role" class="form-control"');
		$data['form_role_edit'] = form_dropdown('',$opt,'','id="txt_EditUser_Role" name="role_id" class="form-control"');
		
        // $data['listuser'] = $this->users->listUsers();        
		$this->load->view("templates/header", $data);
		$this->load->view("user/list-user", $data);
		$this->load->view("templates/footer");
	}

	#endregion Views

	#region Services
	public function listdatauser()
	{
		$list = $this->users->get_datatables();
		
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->users->count_all(),
                    "recordsFiltered" => $this->users->count_filtered(),
                    "data" => $list,
                );
        //output to json format
        echo json_encode($output);
	}

	public function GetUsersById()
    {
        if($this->input->is_ajax_request()){
            $id = $this->input->post('user_login');
            if($post = $this->users->getUserByUserLogin($id)){
                $data = array("response" => "success", "message" => "Data Berhasil Didapat.", 'user_data'=>$post);
            }else{
                $data = array("response" => "error", "message" => "Data Gagal Didapat.");
            }
        }else{
            echo("No direct script access allowed");
        }
        echo json_encode($data);
	}
	
	public function edit()
	{
		$data['judul'] = "Edit Profile";
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
		$data['judul'] = "Change Password";
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

	public function AddUser()
	{
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules('name', "Name", 'required|trim');
			$this->form_validation->set_rules('role', "Role", 'required');
			$this->form_validation->set_rules('user_login', "User Login", 'required|trim|is_unique[tbl_users.user_login]',array('is_unique' => '%s sudah ada.'));
			$this->form_validation->set_rules('password', "Password", 'required|trim|min_length[3]');

            if($this->form_validation->run() == FALSE){
                $data = array("response" => "error", "message" => validation_errors());
            }else{                          
				$ajax_data = [
					'user_login' => htmlspecialchars($this->input->post("user_login", true)),
					'name' => htmlspecialchars($this->input->post("name", true)),
					'image' => 'default.jpg',
					'password' => password_hash($this->input->post("password"), PASSWORD_DEFAULT),
					'role_id' => $this->input->post("role", true),
					'is_active' => 1,
					'date_created' => date('Y-m-d H:i:s')
				];
								
                if($this->users->insertNewUser($ajax_data)){
                    $data = array("response" => "success", "message" => "Data Berhasil Disimpan.");
                }else{
                    $data = array("response" => "error", "message" => "Data Gagal Disimpan.");
                }
            }
        }else{
            echo("No direct script access allowed");
        }

        echo json_encode($data);
	}

	public function EditUser()
    {        
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules('name', "Name", 'required|trim');
			$this->form_validation->set_rules('role_id', "Role", 'required');

            if($this->form_validation->run() == FALSE){
                $data = array("response" => "error", "message" => validation_errors());
            }else{
                $ajax_data = $this->input->post();                
                $ajax_data["date_modified"] = date('Y-m-d H:i:s');
                                
                if($this->users->update_user($ajax_data)){
					$reset = false;
					if( $ajax_data['user_login'] == $this->session->userdata('user_login')){
						$reset = true;
					}
                    $data = array("response" => "success", "message" => "Data Berhasil Diubah.", "reset_session" => $reset);
                }else{
                    $data = array("response" => "error", "message" => "Data Gagal Diubah.");
                }
            }
        }else{
            echo("No direct script access allowed");
        }

        echo json_encode($data);
    }

	#endregion Services
}

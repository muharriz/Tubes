<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Main_Model');
		$this->load->model('Login_Model');
	}

	public function index(){
		$this->load->view('Pages/loginpage');
	}
	public function loginpage(){
		$this->load->view('Pages/loginpage');
	}
	public function login(){
		$nip = $this->input->post("nip");
		$password = $this->input->post("password");

		$data = array(
						'pegawai_id' => $nip,
						'pegawai_password' => $password
		);
		$result = $this->Login_Model->cekuser($data);

		if($result->banyak){
			$user = $this->Login_Model->login($data,"pegawai");
		}
		else{

			$this->session->set_flashdata('eror_no_user','Maaf, NIP atau Password anda salah!');
			redirect(base_url('index.php/Main_Controller'));
		}

		
	}
}

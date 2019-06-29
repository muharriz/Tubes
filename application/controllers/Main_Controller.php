<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Main_Model');
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

		if($this->Main_Model->cekuser($data)){
			$user = $this->Main_Model->login($data,"pegawai");
			var_dump($user);
		}
		else{

		}

		
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function index(){
		$this->load->view('Pages/Main');
	}
	public function loginpage(){
		$this->load->view('Pages/Main');
	}
	public function login(){
		$nip = $this->input->post("nip");
		$password = $this->input->post("password");

		$data = array(
						'nama' => $nip,
						'password' => $password
		);

		if($this->Main_Model->cekuser($data))

		$this->Main_Model->login($data,"sistem_bendahara");
	}
}

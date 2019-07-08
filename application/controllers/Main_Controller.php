<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');	
		$this->load->model('Main_Model');
		$this->load->model('Pegawai_Model');
		$this->load->model('Login_Model');
	}
	//Fungsi untuk langsung ke halaman login
	public function index(){
		$this->load->view('Pages/loginpage');
	}
	//Fungsi untuk login
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
			$this->session->set_userdata('pegawai_id',$user->pegawai_id);
			$this->session->set_userdata('nama_depan',$user->nama_depan);
			$this->session->set_userdata('level',$user->level);
			$this->session->set_flashdata('greet','Selamat Datang, ' .$this->session->userdata('nama_depan'). '!');

			$this->session->set_userdata('halaman','dashboard');
			redirect(base_url('index.php/Pegawai_Controller/dashboard'));
		}
		else{
			$this->session->set_flashdata('error','Maaf, NIP atau Password anda salah!');
			redirect(base_url('index.php/Main_Controller'));
		}

		
	}

	//fungsi untuk logout
	public function logout(){
			$this->session->unset_userdata('pegawai_id',$user->pegawai_id);
			$this->session->unset_userdata('nama_depan',$user->nama_depan);
			$this->session->unset_userdata('level',$user->level);
			redirect(base_url());
	}

	//fungsi untuk cek apakah user telah login
	public function cek_login(){
		if(is_null($this->session->userdata('pegawai_id'))){
			$this->session->set_flashdata('error','Maaf, Anda harus login terlebih dahulu!');
			redirect(base_url());
		}
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Main_Model');
		$this->load->model('Pegawai_Model');
		$this->load->model('Login_Model');
	}

	public function uang_spp(){
		$this->session->set_userdata('halaman','uang_spp');

		$data['data'] = $this->Pegawai_Model->pembayaran_spp();
		
		$this->load->view('Pages/main',$data);
	}
	public function uang_pondok(){
		$this->session->set_userdata('halaman','uang_pondok');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_pembayaran_pondok();
		$page = $this->uri->segment(3);

		$config['base_url'] = 'url';
		$config['total_rows'] = $jumlah_baris->total;
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		echo $config['per_page']."<br>";
		echo $page."<br>";

		$data['data'] = $this->Pegawai_Model->pembayaran_pondok($config['per_page'],$page);
		var_dump($data);

		$this->load->view('Pages/main',$data);
	}
	public function uang_buku(){
		$this->session->set_userdata('halaman','uang_buku');
	}
	public function uang_pembangunan(){
		$this->session->set_userdata('halaman','uang_pembangunan');
		
	}
	public function uang_bimbel(){
		$this->session->set_userdata('halaman','uang_bimbel');
	}
	public function input_pengeluaran(){
		$this->session->set_userdata('halaman','isi_pengeluaran');
	}
	public function lihat_pengeluaran(){
		$this->session->set_userdata('halaman','data_pengeluaran');
	}
	public function dashboard(){
		$this->session->set_userdata('halaman','dashboard');
		$this->load->view('Pages/main');	
	}
}

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
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/uang_pondok';
		$config['total_rows'] = $jumlah_baris->total;
		$config['per_page'] = 2;
		$config["uri_segment"] = 3;
		
		//custom pagination
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
             
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
             
            $config['first_link'] = 'First Page';
            $config['first_tag_open'] = '<span class="firstlink"></span>&nbsp <span>';
            $config['first_tag_close'] = '</span>';
             
            $config['last_link'] = 'Last Page';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
             
            $config['next_link'] = 'Next Page';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
 
            $config['prev_link'] = 'Prev Page';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';
 
            $config['cur_tag_open'] = '<span class="curlink">';
            $config['cur_tag_close'] = '</span>';
 
            $config['num_tag_open'] = '<span class="numlink">';
            $config['num_tag_close'] = '</span>';		
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$data['data'] = $this->Pegawai_Model->pembayaran_pondok($config['per_page'],$page);

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

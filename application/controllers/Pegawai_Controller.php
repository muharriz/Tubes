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
	//KUMPULAN FUNGSI UNTUK FITUR UANG PONDOK

	//fungsi untuk membuka halaman pondok
	public function uang_pondok(){
		$this->session->set_userdata('halaman','uang_pondok');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_pembayaran_pondok();
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/uang_pondok';
		$config['total_rows'] = $jumlah_baris->total;
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		
		//custom pagination
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
             
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
             
            $config['first_link'] = '&nbspHalaman Pertama&nbsp';
            $config['first_tag_open'] = '<span class="firstlink"></span>&nbsp <span>';
            $config['first_tag_close'] = '</span>';
             
            $config['last_link'] = '&nbspHalaman Terakhir&nbsp';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
             
            $config['next_link'] = '&nbspHalaman Selanjutnya&nbsp';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
 
            $config['prev_link'] = '&nbspHalaman Sebelumnya&nbsp';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';
 
            $config['cur_tag_open'] = '&nbsp<span class="curlink">&nbsp';
            $config['cur_tag_close'] = '</span>';
 
            $config['num_tag_open'] = '&nbsp<span class="numlink">&nbsp';
            $config['num_tag_close'] = '</span>';		
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$data['data'] = $this->Pegawai_Model->pembayaran_pondok($config['per_page'],$page);

		$this->load->view('Pages/main',$data);
	}

	// Fungsi untuk menghapus salah satu data uang pondok
	public function hapus_uang_pondok($id){
		if($this->Pegawai_Model->hapus_uang_pondok($id)){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus !');
			redirect(base_url('index.php/Pegawai_Controller/uang_pondok'));
		}
	}

	// Fungsi untuk menambah data uang pondok
	public function tambah_uang_pondok(){

		$this->form_validation->set_rules(
											'nis','NIS','required|min_length[7]|max_length[7]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		$this->form_validation->set_rules(
											'tahun','Tahun','required|min_length[4]|max_length[4]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/uang_pondok'));
		}
		else{

			$data = array(
							'NIS' => $this->input->post('nis'),
							'tahun' => $this->input->post('tahun'),
							'bulan' => $this->input->post('bulan')
			);

			$status = $this->Pegawai_Model->tambah_uang_pondok($data,'uang_pondok');

			if($status){
				$this->session->set_flashdata('success','Data berhasil ditambah!');
				redirect(base_url('index.php/Pegawai_Controller/uang_pondok'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/uang_pondok'));
			}

		}
	}

	// Fungsi untuk membuka halaman bayar uang pondok
	public function halaman_bayar_uang_pondok($id){
		$this->session->set_flashdata('halaman','pembayaran_pondok');
		$data['id'] = $id;
		$this->load->view('Pages/main',$data);
	}

	//Fungsi untuk membayar uang pondok
	public function bayar_uang_pondok($id){
		$this->session->set_flashdata('halaman','pembayaran_pondok');


		$data = array(
						'pembayaran_id' => $id,
						'jumlah' => $this->input->post('jumlah'),
						'tgl_pembayaran' => $this->input->post('tanggal'),
						'pegawai_id' => $this->session->userdata('pegawai_id'),
						'potongan' => $this->input->post('potongan')
		);

		$status = $this->Pegawai_Model->bayar_uang_pondok($data,'pembayaran_pondok');

		if($status){
			$this->session->set_flashdata('success','Pembayaran Berhasil!');
			redirect(base_url('index.php/Pegawai_Controller/uang_pondok'));
		}
		else{
			$this->session->set_flashdata('error','Pembayaran gagal, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/pembayaran_pondok'));
		}

	}

	// Fungsi untuk membuka halaman edit uang pondok
	public function edit_uang_pondok($id){
		$this->session->set_flashdata('halaman','edit_pembayaran_pondok');
		$ambil = array(
						'pembayaran_id' => $id
		);

		$data_uang_pondok = $this->Pegawai_Model->ambil_data_pondok($ambil);
		$data['id'] = $id;
		$data['data'] = $data_uang_pondok;

		$this->load->view('Pages/main',$data);
	}

	// Fungsi untuk menyimpan update uang pondok
	public function update_uang_pondok($id){
		$this->form_validation->set_rules(
											'tahun','Tahun','required|min_length[4]|max_length[4]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/edit_uang_pondok/').$id);
		}
		else{

			$data = array(
							'id' => $id,
							'tahun' => $this->input->post('tahun'),
							'bulan' => $this->input->post('bulan'),
							'status' => $this->input->post('status')
			);

			$status = $this->Pegawai_Model->update_uang_pondok($data);

			if($status){
				$this->session->set_flashdata('success','Data berhasil diubah!');
				redirect(base_url('index.php/Pegawai_Controller/uang_pondok'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/uang_pondok'));
			}

		}

	}

	// KUMPULAN FUNGSI UNTUK FITUR UANG BUKU
	public function uang_buku(){
		$this->session->set_userdata('halaman','uang_buku');
		$this->load->view('Pages/main');
	}

	// KUMPULAN FUNGSI UNTUK FITUR UANG PEMBANGUNAN
	public function uang_pembangunan(){
		$this->session->set_userdata('halaman','uang_pembangunan');
		$this->load->view('Pages/main');
		
	}
	
	// KUMPULAN FUNGSI UNTUK FITUR UANG BIMBEL
	public function uang_bimbel(){
		$this->session->set_userdata('halaman','uang_bimbel');
		$this->load->view('Pages/main');
	}

	// KUMPULAN FUNGSI UNTUK FITUR UANG BUKU
	public function input_pengeluaran(){
		$this->session->set_userdata('halaman','isi_pengeluaran');
		$this->load->view('Pages/main');
	}
	public function lihat_pengeluaran(){
		$this->session->set_userdata('halaman','data_pengeluaran');
		$this->load->view('Pages/main');
	}
	public function dashboard(){
		$this->session->set_userdata('halaman','dashboard');
		$this->load->view('Pages/main');	
	}
	public function daftar_siswa(){
		$this->session->set_userdata('halaman','daftar_siswa');
		$this->load->view('Pages/main');	
	}
}

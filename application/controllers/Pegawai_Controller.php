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

	//FUNGSI UNTUK MEMBUKA HALAMAN DASHBOARD
	public function dashboard(){
		$this->session->set_userdata('halaman','dashboard');
		$data['siswa'] = $this->Pegawai_Model->ambil_jumlah_siswa();
		$data['pegawai'] = $this->Pegawai_Model->ambil_jumlah_pegawai();

		$this->load->view('Pages/main',$data);	
	}

	// KUMPULAN FUNGSI UNTUK FITUR UANG SPP
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

		$page = ($page * $config['per_page']);
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
	//Fungsi untuk ke halaman cari nama siswa di pembayaran pondok
	public function cari_pondok(){
		$nama = $this->input->post('nama');
		redirect(base_url('index.php/Pegawai_Controller/cari_uang_pondok/'.$nama));
	}
	//Fungsi menampilkan hasil pencarian data pondok sesuai nama siswa yang diberikan
	public function cari_uang_pondok($nama){
		$this->session->set_userdata('halaman','cari_uang_pondok');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_cari_uang_pondok($nama);
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/cari_uang_pondok/'.$nama;
		$config['total_rows'] = $jumlah_baris->total;
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		$config["cur_page"] = ($this->uri->segment(4)) ? ($this->uri->segment(4)) : 1;
		
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->cari_siswa($nama,'v_lihatpembayaranpondok','nama',$config['per_page'],$page);
		$data['nama'] = $nama;

		$this->load->view('Pages/main',$data);
	}







	// KUMPULAN FUNGSI UNTUK FITUR UANG PEMBANGUNAN

	//fungsi untuk halaman uang pembangunan
	public function uang_pembangunan(){
		$this->session->set_userdata('halaman','uang_pembangunan');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_pembayaran_pembangunan();
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/uang_pembangunan';
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->pembayaran_pembangunan($config['per_page'],$page);

		$this->load->view('Pages/main',$data);
	}

	// fungsi untuk menghapus salah satu data pembangunan
	public function hapus_uang_pembangunan($id){
		if($this->Pegawai_Model->hapus_uang_pembangunan($id)){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus !');
			redirect(base_url('index.php/Pegawai_Controller/uang_pembangunan'));
		}
	}

	//fungsi untuk menambah data pembangunan
	public function tambah_uang_pembangunan(){

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
			redirect(base_url('index.php/Pegawai_Controller/uang_pembangunan'));
		}
		else{

			$data = array(
							'NIS' => $this->input->post('nis'),
							'tahun' => $this->input->post('tahun'),
							'bulan' => $this->input->post('bulan')
			);

			$status = $this->Pegawai_Model->tambah_uang_pembangunan($data,'uang_pembangunan');

			if($status){
				$this->session->set_flashdata('success','Data berhasil ditambah!');
				redirect(base_url('index.php/Pegawai_Controller/uang_pembangunan'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/uang_pembangunan'));
			}

		}
	}

	//fungsi untuk ke halaman pembayaran pembangunan
	public function halaman_bayar_uang_pembangunan($id){
		$this->session->set_flashdata('halaman','pembayaran_pembangunan');
		$data['id'] = $id;
		$this->load->view('Pages/main',$data);
	}

	//fungsi untuk membayar uang pembangunan
	public function bayar_uang_pembangunan($id){
		$this->session->set_flashdata('halaman','pembayaran_pembangunan');


		$data = array(
						'pembayaran_id' => $id,
						'jumlah' => $this->input->post('jumlah'),
						'tgl_pembayaran' => $this->input->post('tanggal'),
						'pegawai_id' => $this->session->userdata('pegawai_id'),
						'potongan' => $this->input->post('potongan')
		);

		$status = $this->Pegawai_Model->bayar_uang_pembangunan($data,'pembayaran_pembangunan');

		if($status){
			$this->session->set_flashdata('success','Pembayaran Berhasil!');
			redirect(base_url('index.php/Pegawai_Controller/uang_pembangunan'));
		}
		else{
			$this->session->set_flashdata('error','Pembayaran gagal, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/pembayaran_pembangunan'));
		}

	}

	// Fungsi untuk membuka halaman update uang pembangunan
	public function halaman_edit_uang_pembangunan($id){
		$data = array(
						'pembayaran_id' => $id
		);

		$data_buku['data'] =  $this->Pegawai_Model->ambil_data_pembangunan($data);
		$data_buku['id'] = $id;

		$this->session->set_userdata('halaman','edit_pembayaran_pembangunan');

		$this->load->view('Pages/main',$data_buku);
	}

	//Fungsi untuk menyimpan update uang pembangunan
	public function update_uang_pembangunan($id){
		$this->form_validation->set_rules(
											'tahunajaran','Tahun Ajaran','required|min_length[9]|max_length[9]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/halaman_edit_uang_pembangunan/').$id);
		}
		else{

			$data = array(
							'pembayaran_id' => $id,
							'tahun_ajaran' => $this->input->post('tahunajaran'),
							'status' => $this->input->post('status'),
			);

			$status = $this->Pegawai_Model->update_uang_pembangunan($data);

			if($status){
				$this->session->set_flashdata('success','Data berhasil diubah!');
				redirect(base_url('index.php/Pegawai_Controller/uang_pembangunan'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/uang_pembangunan'));
			}

		}

	}
	//Fungsi untuk ke halaman pencarian pembayaran pembangunan sesuai nama siswa yang diberikan
	public function cari_pembangunan(){
		$nama = $this->input->post('nama');
		redirect(base_url('index.php/Pegawai_Controller/cari_uang_pembangunan/'.$nama));
	}
	// Menampilkan hasil pencarian pembayaran pembangunan
	public function cari_uang_pembangunan($nama){
		$this->session->set_userdata('halaman','cari_uang_pembangunan');

		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		$jumlah_baris = $this->Pegawai_Model->jumlah_data_cari_uang_pembangunan($nama);
		

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/cari_uang_pembangunan/'.$nama;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $jumlah_baris->total;
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		$config["cur_page"] = ($this->uri->segment(4)) ? ($this->uri->segment(4)) : 1;
		
		//custom pagination
            $config['num_links'] = 3;
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->cari_siswa($nama,'v_cicilanpembangunan','nama',$config['per_page'],$page);
		$data['nama'] = $nama;
		$data['page'] = $page;

		$this->load->view('Pages/main',$data);
	}








	
	// KUMPULAN FUNGSI UNTUK FITUR UANG BIMBEL

	//fungsi untuk halaman uang bimbel
	public function uang_bimbel(){
		$this->session->set_userdata('halaman','uang_bimbel');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_pembayaran_bimbel();
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/uang_bimbel';
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->pembayaran_bimbel($config['per_page'],$page);

		$this->load->view('Pages/main',$data);
	}

	//fungsi untuk menghapus data uang bimbel
	public function hapus_uang_bimbel($id){
		if($this->Pegawai_Model->hapus_uang_bimbel($id)){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus !');
			redirect(base_url('index.php/Pegawai_Controller/uang_bimbel'));
		}
	}

	//fungsi untuk menambah uang bimbel
	public function tambah_uang_bimbel(){

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
			redirect(base_url('index.php/Pegawai_Controller/uang_bimbel'));
		}
		else{

			$data = array(
							'NIS' => $this->input->post('nis'),
							'tahun' => $this->input->post('tahun'),
							'bulan' => $this->input->post('bulan')
			);

			$status = $this->Pegawai_Model->tambah_uang_bimbel($data,'uang_bimbel');

			if($status){
				$this->session->set_flashdata('success','Data berhasil ditambah!');
				redirect(base_url('index.php/Pegawai_Controller/uang_bimbel'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/uang_bimbel'));
			}

		}
	}

	// Fungsi untuk membuka halaman update uang bimbel
	public function halaman_edit_uang_bimbel($id){
		$data = array(
						'pembayaran_id' => $id
		);

		$data_buku['data'] =  $this->Pegawai_Model->ambil_data_bimbel($data);
		$data_buku['id'] = $id;

		$this->session->set_userdata('halaman','edit_pembayaran_bimbel');

		$this->load->view('Pages/main',$data_buku);
	}

	//Fungsi untuk menyimpan update uang bimbel
	public function update_uang_bimbel($id){
		$this->form_validation->set_rules(
											'tahunajaran','Tahun Ajaran','required|min_length[9]|max_length[9]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/halaman_edit_uang_bimbel/').$id);
		}
		else{

			$data = array(
							'pembayaran_id' => $id,
							'tahun_ajaran' => $this->input->post('tahunajaran'),
							'semester' => $this->input->post('semester'),
							'status' => $this->input->post('status'),
			);

			$status = $this->Pegawai_Model->update_uang_bimbel($data);

			if($status){
				$this->session->set_flashdata('success','Data berhasil diubah!');
				redirect(base_url('index.php/Pegawai_Controller/uang_bimbel'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/uang_bimbel'));
			}

		}

	}

	//fungsi untuk membuka halaman pembayaran uang bimbel
	public function halaman_bayar_uang_bimbel($id){
		$this->session->set_flashdata('halaman','pembayaran_bimbel');
		$data['id'] = $id;
		$this->load->view('Pages/main',$data);
	}
	//fungsi untuk pembayaran uang bimbel
	public function bayar_uang_bimbel($id){
		$this->session->set_flashdata('halaman','pembayaran_bimbel');


		$data = array(
						'pembayaran_id' => $id,
						'jumlah' => $this->input->post('jumlah'),
						'tgl_pembayaran' => $this->input->post('tanggal'),
						'pegawai_id' => $this->session->userdata('pegawai_id'),
						'potongan' => $this->input->post('potongan')
		);

		$status = $this->Pegawai_Model->bayar_uang_bimbel($data,'pembayaran_bimbel');

		if($status){
			$this->session->set_flashdata('success','Pembayaran Berhasil!');
			redirect(base_url('index.php/Pegawai_Controller/uang_bimbel'));
		}
		else{
			$this->session->set_flashdata('error','Pembayaran gagal, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/pembayaran_bimbel'));
		}

	}
	public function cari_bimbel(){
		$nama = $this->input->post('nama');
		redirect(base_url('index.php/Pegawai_Controller/cari_uang_bimbel/'.$nama));
	}

	public function cari_uang_bimbel($nama){
		$this->session->set_userdata('halaman','cari_uang_bimbel');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_cari_uang_bimbel($nama);
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/cari_uang_bimbel/'.$nama;
		$config['total_rows'] = $jumlah_baris->total;
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		$config["cur_page"] = ($this->uri->segment(4)) ? ($this->uri->segment(4)) : 1;
		
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->cari_siswa($nama,'v_cicilanbimbel','nama',$config['per_page'],$page);
		$data['nama'] = $nama;

		$this->load->view('Pages/main',$data);
	}









	// KUMPULAN FUNGSI UNTUK FITUR UANG BUKU

	//fungsi untuk ke halaman uang buku
	public function uang_buku(){
		$this->session->set_userdata('halaman','uang_buku');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_pembayaran_buku();
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/uang_buku';
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->pembayaran_buku($config['per_page'],$page);

		$this->load->view('Pages/main',$data);
	}

	// Fungsi untuk menghapus salah satu data uang buku
	public function hapus_uang_buku($id){
		if($this->Pegawai_Model->hapus_uang_buku($id)){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus !');
			redirect(base_url('index.php/Pegawai_Controller/uang_buku'));
		}
	}

	// Fungsi untuk menambah data uang buku
	public function tambah_uang_buku(){

		$this->form_validation->set_rules(
											'nis','NIS','required|min_length[7]|max_length[7]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		$this->form_validation->set_rules(
											'tahunajaran','Tahun Ajaran','required|min_length[9]|max_length[9]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/uang_buku'));
		}
		else{

			$data = array(
							'NIS' => $this->input->post('nis'),
							'tahun_ajaran' => $this->input->post('tahunajaran'),
							'semester' => $this->input->post('semester'),
							'jumlah' => $this->input->post('jumlah'),
			);

			$status = $this->Pegawai_Model->tambah_uang_buku($data,'uang_buku');

			if($status){
				$this->session->set_flashdata('success','Data berhasil ditambah!');
				redirect(base_url('index.php/Pegawai_Controller/uang_buku'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/uang_buku'));
			}

		}
	}

	// Fungsi untuk membuka halaman bayar uang pondok
	public function halaman_bayar_uang_buku($id){
		$this->session->set_flashdata('halaman','pembayaran_buku');
		$data['id'] = $id;
		$this->load->view('Pages/main',$data);
	}

	//Fungsi untuk membayar uang pondok
	public function bayar_uang_buku($id){
		$this->session->set_flashdata('halaman','pembayaran_buku');


		$data = array(
						'pembayaran_id' => $id,
						'jumlah' => $this->input->post('jumlah'),
						'tgl_pembayaran' => $this->input->post('tanggal'),
						'pegawai_id' => $this->session->userdata('pegawai_id')
		);

		$status = $this->Pegawai_Model->bayar_uang_buku($data,'pembayaran_buku');

		if($status){
			$this->session->set_flashdata('success','Pembayaran Berhasil!');
			redirect(base_url('index.php/Pegawai_Controller/uang_buku'));
		}
		else{
			$this->session->set_flashdata('error','Pembayaran gagal, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/pembayaran_buku'));
		}

	}

	// Fungsi untuk membuka halaman update uang buku
	public function halaman_edit_uang_buku($id){
		$data = array(
						'pembayaran_id' => $id
		);

		$data_buku['data'] =  $this->Pegawai_Model->ambil_data_buku($data);
		$data_buku['id'] = $id;

		$this->session->set_userdata('halaman','edit_pembayaran_buku');

		$this->load->view('Pages/main',$data_buku);
	}

	//Fungsi untuk menyimpan update uang buku
	public function update_uang_buku($id){
		$this->form_validation->set_rules(
											'tahunajaran','Tahun Ajaran','required|min_length[9]|max_length[9]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		$this->form_validation->set_rules(
											'jumlah','Jumlah','required|min_length[1]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/halaman_edit_uang_buku/').$id);
		}
		else{

			$data = array(
							'pembayaran_id' => $id,
							'tahun_ajaran' => $this->input->post('tahunajaran'),
							'semester' => $this->input->post('semester'),
							'jumlah' => $this->input->post('jumlah'),
							'status' => $this->input->post('status'),
			);

			$status = $this->Pegawai_Model->update_uang_buku($data);

			if($status){
				$this->session->set_flashdata('success','Data berhasil diubah!');
				redirect(base_url('index.php/Pegawai_Controller/uang_buku'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/uang_buku'));
			}

		}

	}
	public function cari_buku(){
		$nama = $this->input->post('nama');
		redirect(base_url('index.php/Pegawai_Controller/cari_uang_buku/'.$nama));
	}

	public function cari_uang_buku($nama){
		$this->session->set_userdata('halaman','cari_uang_buku');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_cari_uang_buku($nama);
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/cari_uang_buku/'.$nama;
		$config['total_rows'] = $jumlah_baris->total;
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		$config["cur_page"] = ($this->uri->segment(4)) ? ($this->uri->segment(4)) : 1;
		
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->cari_siswa($nama,'v_cicilanbuku','nama',$config['per_page'],$page);
		$data['nama'] = $nama;

		$this->load->view('Pages/main',$data);
	}













	// KUMPULAN FUNGSI UNTUK FITUR UANG INFAQ

	//fungsi untuk ke halaman uang infaq
	public function uang_infaq(){
		$this->session->set_userdata('halaman','uang_infaq');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_infaq();
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/uang_infaq';
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->uang_infaq($config['per_page'],$page);

		$this->load->view('Pages/main',$data);
	}

	

	// Fungsi untuk menghapus salah satu data uang infaq
	public function hapus_uang_infaq($id){
		if($this->Pegawai_Model->hapus_uang_infaq($id)){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus !');
			redirect(base_url('index.php/Pegawai_Controller/uang_infaq'));
		}
	}

	// Fungsi untuk menambah data uang infaq
	public function tambah_uang_infaq(){

		$this->form_validation->set_rules(
											'namalengkap','Nama Lengkap','required|min_length[3]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		$this->form_validation->set_rules(
											'keterangan','Keterangan','required|min_length[4]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/uang_infaq'));
		}
		else{

			$data = array(
							'nama_lengkap' => $this->input->post('namalengkap'),
							'jumlah' => $this->input->post('jumlah'),
							'tanggal_diterima' => $this->input->post('tanggalditerima'),
							'pegawai_id' => $this->session->userdata('pegawai_id'),
							'keterangan' => $this->input->post('keterangan'),
			);

			$status = $this->Pegawai_Model->tambah_uang_infaq($data,'uang_infaq');

			if($status){
				$this->session->set_flashdata('success','Data berhasil ditambah!');
				redirect(base_url('index.php/Pegawai_Controller/uang_infaq'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/uang_infaq'));
			}

		}
	}

	

	// Fungsi untuk membuka halaman update uang infaq
	public function halaman_edit_uang_infaq($id){
		$data = array(
						'donatur_id' => $id
		);

		$data_infaq['data'] =  $this->Pegawai_Model->ambil_data_infaq($data);
		$data_infaq['id'] = $id;

		$this->session->set_userdata('halaman','edit_infaq');

		$this->load->view('Pages/main',$data_infaq);
	}


	//Fungsi untuk menyimpan update uang infaq
	public function update_uang_infaq($id){
		$this->form_validation->set_rules(
											'namalengkap','Nama Lengkap','required|min_length[3]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		$this->form_validation->set_rules(
											'keterangan','Keterangan','required|min_length[4]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/halaman_edit_uang_infaq/').$id);
		}
		else{

			$data = array(
							'donatur_id' => $id,
							'nama_lengkap' => $this->input->post('namalengkap'),
							'jumlah' => $this->input->post('jumlah'),
							'tanggal_diterima' => $this->input->post('tanggalditerima'),
							'pegawai_id' => $this->session->userdata('pegawai_id'),
							'keterangan' => $this->input->post('keterangan'),
			);

			$status = $this->Pegawai_Model->update_uang_infaq($data);

			if($status){
				$this->session->set_flashdata('success','Data berhasil diubah!');
				redirect(base_url('index.php/Pegawai_Controller/uang_infaq'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/uang_infaq'));
			}

		}

	}
	public function cari_infaq(){
		$nama = $this->input->post('nama');
		redirect(base_url('index.php/Pegawai_Controller/cari_uang_infaq/'.$nama));
	}

	public function cari_uang_infaq($nama){
		$this->session->set_userdata('halaman','cari_uang_infaq');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_cari_uang_infaq($nama);
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/cari_uang_infaq/'.$nama;
		$config['total_rows'] = $jumlah_baris->total;
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		$config["cur_page"] = ($this->uri->segment(4)) ? ($this->uri->segment(4)) : 1;
		
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->cari_siswa($nama,'v_lihatinfaq','nama_lengkap',$config['per_page'],$page);
		$data['nama'] = $nama;

		$this->load->view('Pages/main',$data);
	}








	//KUMPULAN FUNGSI UNTUK FITUR PENGELUARAN

	//fungsi untuk membuka halaman pengeluaran
	public function lihat_pengeluaran(){
		$this->session->set_userdata('halaman','data_pengeluaran');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_pengeluaran();
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/lihat_pengeluaran';
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->pembayaran_pengeluaran($config['per_page'],$page);

		$this->load->view('Pages/main',$data);
	}


	//fungsi untuk membuka halaman tambah data pengeluaran
	public function input_pengeluaran(){
		$this->session->set_userdata('halaman','isi_pengeluaran');
		$this->load->view('Pages/main');
	}

	//fungsi untuk menambah data pengeluaran
	public function tambah_pengeluaran(){

			$data = array(
							'jumlah' => $this->input->post('jumlah'),
							'tgl_dipakai' => $this->input->post('tgl_dipakai'),
							'keterangan' => $this->input->post('keterangan')
			);

			$status = $this->Pegawai_Model->tambah_pengeluaran($data,'pengeluaran');

			if($status){
				$this->session->set_flashdata('success','Data berhasil ditambah!');
				redirect(base_url('index.php/Pegawai_Controller/input_pengeluaran'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/input_pengeluaran'));
			}

		
	}

	// Fungsi untuk menghapus salah satu data pengeluaran
	public function hapus_pengeluaran($id){
		
		if($this->Pegawai_Model->hapus_pengeluaran($id)){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus !');
			redirect(base_url('index.php/Pegawai_Controller/lihat_pengeluaran'));
		}
	}
	// Fungsi untuk membuka halaman update uang buku
	public function halaman_edit_pengeluaran($id){
		$data = array(
						'pengeluaran_id' => $id
		);

		$data_pengeluaran['data'] =  $this->Pegawai_Model->ambil_data_pengeluaran($data);
		$data_pengeluaran['id'] = $id;

		$this->session->set_userdata('halaman','edit_pengeluaran');

		$this->load->view('Pages/main',$data_pengeluaran);
	}

	//Fungsi untuk menyimpan update uang buku
	public function update_pengeluaran($id){
		$this->form_validation->set_rules(
											'keterangan','Keterangan','required|min_length[5]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		$this->form_validation->set_rules(
											'jumlah','Jumlah','required|min_length[1]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/halaman_edit_pengeluaran/').$id);
		}
		else{

			$data = array(
							'pengeluaran_id' => $id,
							'tanggaldipakai' => $this->input->post('tanggaldipakai'),
							'jumlah' => $this->input->post('jumlah'),
							'keterangan' => $this->input->post('keterangan')
			);

			$status = $this->Pegawai_Model->update_pengeluaran($data);

			if($status){
				$this->session->set_flashdata('success','Data berhasil diubah!');
				redirect(base_url('index.php/Pegawai_Controller/lihat_pengeluaran'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/lihat_pengeluaran'));
			}

		}

	}
	





	//KUMPULAN FUNGSI UNTUK  FITUR MANAJEMEN

	//fungsi untuk membuka halaman pengeluaran
	public function lihat_siswa(){
		$this->session->set_userdata('halaman','lihat_siswa');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_siswa();
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/lihat_siswa';
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->lihat_siswa($config['per_page'],$page);

		$this->load->view('Pages/main',$data);
	}
	//fitur untuk membuka halaman tambah data siswa
	public function daftar_siswa(){
		$this->session->set_userdata('halaman','daftar_siswa');
		$this->load->view('Pages/main');	
	}
	//fitur untuk menambah data siswa
	public function tambah_siswa(){

		$this->form_validation->set_rules(
											'nis','NIS','required|min_length[7]|max_length[7]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/daftar_siswa'));
		}
		else{

			$data = array(
							'NIS' => $this->input->post('nis'),
							'nama' => $this->input->post('nama'),
							'jenis_kelamin' => $this->input->post('jenis_kelamin'),
							'alamat' => $this->input->post('alamat'),
							'tgl_masuk' => $this->input->post('tanggal'),
							'status' => $this->input->post('status')
							
			);

			$status = $this->Pegawai_Model->tambah_siswa($data,'siswa');

			if($status){
				$this->session->set_flashdata('success','Data berhasil ditambah!');
				redirect(base_url('index.php/Pegawai_Controller/daftar_siswa'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/daftar_siswa'));
			}

		}
	}

	// Fungsi untuk menghapus salah satu data siswa
	public function hapus_siswa($id){
		
		if($this->Pegawai_Model->hapus_siswa($id)){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus !');
			redirect(base_url('index.php/Pegawai_Controller/lihat_siswa'));
		}
	}
	public function nonaktifkan_siswa($id){
		
		if($this->Pegawai_Model->nonaktifkan_siswa($id)){
			$this->session->set_flashdata('success', 'Siswa Berhasil Dinonaktifkan !');
			redirect(base_url('index.php/Pegawai_Controller/lihat_siswa'));
		}
	}
	public function aktifkan_siswa($id){
		
		if($this->Pegawai_Model->aktifkan_siswa($id)){
			$this->session->set_flashdata('success', 'Siswa Berhasil Diaktifkan !');
			redirect(base_url('index.php/Pegawai_Controller/lihat_siswa'));
		}
	}
	public function nonaktifkan_pegawai($id){
		
		if($this->Pegawai_Model->nonaktifkan_pegawai($id)){
			$this->session->set_flashdata('success', 'Pegawai Berhasil Dinonaktifkan !');
			redirect(base_url('index.php/Pegawai_Controller/lihat_pegawai'));
		}
	}
	public function aktifkan_pegawai($id){
		
		if($this->Pegawai_Model->aktifkan_pegawai($id)){
			$this->session->set_flashdata('success', 'Pegawai Berhasil Diaktifkan !');
			redirect(base_url('index.php/Pegawai_Controller/lihat_pegawai'));
		}
	}

	// Fungsi untuk membuka halaman update uang siswa
	public function halaman_edit_siswa($nis){
		$data = array(
						'NIS' => $nis
		);

		$data_siswa['data'] =  $this->Pegawai_Model->ambil_data_siswa($data);
		$data_siswa['NIS'] = $nis;

		$this->session->set_userdata('halaman','edit_data_siswa');

		$this->load->view('Pages/main',$data_siswa);
	}
	public function halaman_edit_pegawai($pegawai_id){
		$data = array(
						'pegawai_id' => $pegawai_id
		);

		$data_pegawai['data'] =  $this->Pegawai_Model->ambil_data_pegawai($data);
		$data_pegawai['pegawai_id'] = $pegawai_id;

		$this->session->set_userdata('halaman','edit_data_pegawai');

		$this->load->view('Pages/main',$data_pegawai);
	}

	//Fungsi untuk menyimpan update uang siswa
	public function update_data_siswa($NIS){
		$this->form_validation->set_rules(
											'nama','Nama','required|min_length[3]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		$this->form_validation->set_rules(
											'alamat','Alamat','required|min_length[5]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/halaman_edit_siswa/').$id);
		}
		else{

			$data = array(
							'NIS' => $NIS,
							'nama' => $this->input->post('nama'),
							'jenis_kelamin' => $this->input->post('jenis_kelamin'),
							'alamat' => $this->input->post('alamat'),
							'tgl_masuk' => $this->input->post('tanggal'),
							'status' => $this->input->post('status')
			);

			$status = $this->Pegawai_Model->update_data_siswa($data);

			if($status){
				$this->session->set_flashdata('success','Data berhasil diubah!');
				redirect(base_url('index.php/Pegawai_Controller/lihat_siswa'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/lihat_siswa'));
			}

		}

	}
	//Fungsi ke halaman cari siswa
	public function cari_siswa(){
		$nama = $this->input->post('nama');
		redirect(base_url('index.php/Pegawai_Controller/cari_nama_siswa/'.$nama));
	}
	//Fungsi menampilkan halaman sesuai nama yang diberikan
	public function cari_nama_siswa($nama){
		$this->session->set_userdata('halaman','cari_siswa');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_cari_siswa($nama);
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/cari_nama_siswa/'.$nama;
		$config['total_rows'] = $jumlah_baris->total;
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		$config["cur_page"] = ($this->uri->segment(4)) ? ($this->uri->segment(4)) : 1;
		
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->cari_siswa($nama,'siswa','nama',$config['per_page'],$page);
		$data['nama'] = $nama;

		$this->load->view('Pages/main',$data);
	}
	// fungsi untuk membuka halaman daftar pegawai
	public function daftar_pegawai(){
		$this->session->set_userdata('halaman','daftar_pegawai');
		$this->load->view('Pages/main');	
	}
	//fitur untuk menambah data pegawai
	public function tambah_pegawai(){

			$data = array(
							'nama_depan' => $this->input->post('nama_depan'),
							'nama_belakang' => $this->input->post('nama_belakang'),
							'no_handphone' => $this->input->post('no_handphone'),
							'alamat' => $this->input->post('alamat'),
							'level' => $this->input->post('level'),
							'status' => $this->input->post('status'),
							'pegawai_password' => $this->input->post('pegawai_password')
							
			);

			$status = $this->Pegawai_Model->tambah_pegawai($data,'pegawai');

			if($status){
				$this->session->set_flashdata('success','Data berhasil ditambah!');
				redirect(base_url('index.php/Pegawai_Controller/daftar_pegawai'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal dimasukkan, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/daftar_pegawai'));
			}

		}
		//Fungsi ke halaman cari pegawai
	public function cari_pegawai(){
		$nama = $this->input->post('nama');
		redirect(base_url('index.php/Pegawai_Controller/cari_nama_pegawai/'.$nama));
	}
	//Fungsi menampilkan halaman sesuai nama yang diberikan
	public function cari_nama_pegawai($nama){
		$this->session->set_userdata('halaman','cari_pegawai');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_cari_pegawai($nama);
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/cari_nama_pegawai/'.$nama;
		$config['total_rows'] = $jumlah_baris->total;
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		$config["cur_page"] = ($this->uri->segment(4)) ? ($this->uri->segment(4)) : 1;
		
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->cari_pegawai($nama,'pegawai','nama',$config['per_page'],$page);
		$data['nama'] = $nama;

		$this->load->view('Pages/main',$data);
	}
	public function lihat_pegawai(){
		$this->session->set_userdata('halaman','lihat_pegawai');

		$jumlah_baris = $this->Pegawai_Model->jumlah_data_pegawai();
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

		// ngambil record sekarang
		$config['base_url'] = base_url().'index.php/Pegawai_Controller/lihat_pegawai';
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

		$page = ($page * $config['per_page']);
		$data['data'] = $this->Pegawai_Model->lihat_pegawai($config['per_page'],$page);

		$this->load->view('Pages/main',$data);
	}
	//fungsi untuk edit pegawai
	public function update_data_pegawai($pegawai_id){
		$this->form_validation->set_rules(
											'alamat','Alamat','required|min_length[5]',
											array(
													'required' => 'Anda belum mengisi %s, harap periksa kembali!'
											)

		);
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
			redirect(base_url('index.php/Pegawai_Controller/halaman_edit_pegawai/').$id);
		}
		else{

			$data = array(
							'pegawai_id' => $pegawai_id,
							'nama_depan' => $this->input->post('nama_depan'),
							'nama_belakang' => $this->input->post('nama_belakang'),
							'no_handphone' => $this->input->post('no_handphone'),
							'alamat' => $this->input->post('alamat'),
							'level' => $this->input->post('level'),
							'status' => $this->input->post('status')
			);

			$status = $this->Pegawai_Model->update_data_pegawai($data);

			if($status){
				$this->session->set_flashdata('success','Data berhasil diubah!');
				redirect(base_url('index.php/Pegawai_Controller/lihat_pegawai'));
			}
			else{
				$this->session->set_flashdata('error','Data gagal diubah, harap periksa kembali data anda!');
				redirect(base_url('index.php/Pegawai_Controller/lihat_pegawai'));
			}

		}

	}
	//fungsi untuk membuka halaman tagihan
	public function tagihan(){
		$this->session->set_userdata('halaman','tagihan');

		$data['data'] = $this->Pegawai_Model->lihat_tagihan();

		$this->load->view('Pages/main',$data);
	}
}

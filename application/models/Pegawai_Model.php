<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_Model extends CI_Model {

	public function pembayaran_spp(){
		$result = $this->db->query("Select * from siswa");
		return $result->result();
	}
	public function pembayaran_pondok($number,$offset){
		$result = $this->db->get("v_lihatpembayaranpondok",$number,$offset);
		return $result->result();
	}
	public function jumlah_data_pembayaran_pondok(){
		$result = $this->db->query("Select jumlah_data_pembayaran_pondok() as total");
		return $result->row();
	}
	public function hapus_uang_pondok($id){
		$result = $this->db->query("call hapus_uang_pondok('".$id."')");
		return $result;
	}
	public function tambah_uang_pondok($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}
	public function bayar_uang_pondok($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}

	public function ambil_data_pondok($data){
		$result = $this->db->get_where('v_lihatpembayaranpondok',$data);
		return $result->row();
	}
	public function update_uang_pondok($data){
		$result = $this->db->query("update uang_pondok set tahun='".$data['tahun']."',bulan='".$data['bulan']."',status='".$data['status']."' where pembayaran_id = '".$data['id']."'");
		return $result;
	}
	public function pembayaran_pembangunan($number,$offset){
		$result = $this->db->get("v_cicilanpembangunan",$number,$offset);
		return $result->result();
	}
	public function jumlah_data_pembayaran_pembangunan(){
		$result = $this->db->query("Select jumlah_data_pembayaran_pembangunan() as total");
		return $result->row();
	}
	public function hapus_uang_pembangunan($id){
		$result = $this->db->query("call hapus_uang_pembangunan('".$id."')");
		return $result;
	}
	public function tambah_uang_pembangunan($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}
	public function bayar_uang_pembangunan($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}
	public function update_uang_pembangunan($data){
		$result = $this->db->query("update uang_pembangunan set tahun_ajaran='".$data['tahun_ajaran']."',status='".$data['status']."' where pembayaran_id = '".$data['pembayaran_id']."'");
		return $result;
	}
	public function ambil_data_pembangunan($data){
		$result = $this->db->get_where('v_lihatpembayaranpembangunan',$data);
		return $result->row();
	}
	public function pembayaran_bimbel($number,$offset){
		$result = $this->db->get("v_cicilanbimbel",$number,$offset);
		return $result->result();
	}
	public function jumlah_data_pembayaran_bimbel(){
		$result = $this->db->query("Select jumlah_data_pembayaran_bimbel() as total");
		return $result->row();
	}
	public function hapus_uang_bimbel($id){
		$result = $this->db->query("call hapus_uang_bimbel('".$id."')");
		return $result;
	}
	public function tambah_uang_bimbel($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}
	public function bayar_uang_bimbel($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}
	public function update_uang_bimbel($data){
		$result = $this->db->query("update uang_bimbel set tahun_ajaran='".$data['tahun_ajaran']."',semester='".$data['semester']."',status='".$data['status']."' where pembayaran_id = '".$data['pembayaran_id']."'");
		return $result;
	}
	public function ambil_data_bimbel($data){
		$result = $this->db->get_where('v_lihatpembayaranbimbel',$data);
		return $result->row();
	}
	public function tambah_siswa($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}
	public function tambah_pengeluaran($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}
	public function jumlah_data_pengeluaran(){
		$result = $this->db->query("Select jumlah_data_pengeluaran() as total");
		return $result->row();
	}

	public function pembayaran_buku($number,$offset){
		$result = $this->db->get("v_cicilanbuku",$number,$offset);
		return $result->result();
	}
	public function jumlah_data_pembayaran_buku(){
		$result = $this->db->query("Select jumlah_data_pembayaran_buku() as total");
		return $result->row();
	}
	public function hapus_uang_buku($id){
		$result = $this->db->query("call hapus_uang_buku('".$id."')");
		return $result;
	}
	public function tambah_uang_buku($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}
	public function bayar_uang_buku($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}
	public function ambil_data_buku($data){
		$result = $this->db->get_where('v_lihatpembayaranbuku',$data);
		return $result->row();
	}
	public function update_uang_buku($data){
		$result = $this->db->query("update uang_buku set tahun_ajaran='".$data['tahun_ajaran']."',semester='".$data['semester']."',jumlah='".$data['jumlah']."',status='".$data['status']."' where pembayaran_id = '".$data['pembayaran_id']."'");
		return $result;
	}
	public function pembayaran_pengeluaran($number,$offset){
		$result = $this->db->get("v_lihatpengeluaran",$number,$offset);
		return $result->result();
	}
	public function ambil_jumlah_siswa(){
		$result = $this->db->query('select jumlah_siswa() as jumlah');
		return $result->result();
	}
	public function ambil_jumlah_pegawai(){
		$result = $this->db->query('select jumlah_pegawai() as jumlah');
		return $result->result();
	}

	public function lihat_tagihan(){
		$result = $result = $this->db->get('jenis_tagihan');
		return $result->result();
	}
	public function hapus_pengeluaran($id){
		$result = $this->db->query("delete from pengeluaran where pengeluaran_id = '".$id."'");
		return $result;
	}
	public function ambil_data_pengeluaran($data){
		$result = $this->db->get_where('v_lihatpengeluaran',$data);
		return $result->row();
	}
	public function update_pengeluaran($data){
		$result = $this->db->query("update pengeluaran set tgl_dipakai='".$data['tanggaldipakai']."',jumlah='".$data['jumlah']."',keterangan='".$data['keterangan']."' where pengeluaran_id = '".$data['pengeluaran_id']."'");
		return $result;
	}
	public function jumlah_data_infaq(){
		$result = $this->db->query("Select jumlah_data_infaq() as total");
		return $result->row();
	}
	public function uang_infaq($number,$offset){
		$result = $this->db->get("v_lihatinfaq",$number,$offset);
		return $result->result();
	}
	public function hapus_uang_infaq($id){
		$result = $this->db->query("delete from uang_infaq where donatur_id = '".$id."'");
		return $result;
	}
	public function tambah_uang_infaq($data,$table){
		$result = $this->db->insert($table,$data);
		return $result;
	}
	public function ambil_data_infaq($data){
		$result = $this->db->get_where('v_lihatinfaq',$data);
		return $result->row();
	}
	public function update_uang_infaq($data){
		$result = $this->db->query("update uang_infaq set nama_lengkap='".$data['nama_lengkap']."',jumlah='".$data['jumlah']."',tanggal_diterima='".$data['tanggal_diterima']."',keterangan='".$data['keterangan']."' where donatur_id = '".$data['donatur_id']."'");
		return $result;
	}
	public function jumlah_data_siswa(){
		$result = $this->db->query("Select jumlah_data_siswa() as total");
		return $result->row();
	}
	public function lihat_siswa($number,$offset){
		$result = $this->db->query("select * from siswa order by status ASC,tgl_masuk ASC,NIS ASC limit ".$number." offset ".$offset."");
		return $result->result();
	}
	public function hapus_siswa($id){
		$result = $this->db->query("call hapus_siswa('".$id."')");
		return $result;
	}
	public function nonaktifkan_siswa($id){
		$result = $this->db->query("update siswa set status = 'Tidak Aktif' where NIS like '".$id."'");
		return $result;
	}
	public function aktifkan_siswa($id){
		$result = $this->db->query("update siswa set status = 'Aktif' where NIS like '".$id."'");
		return $result;
	}
	public function ambil_data_siswa($data){
		$result = $this->db->get_where('siswa',$data);
		return $result->row();
	}
	public function update_data_siswa($data){
		$result = $this->db->query("update siswa set nama='".$data['nama']."',jenis_kelamin='".$data['jenis_kelamin']."',alamat='".$data['alamat']."',tgl_masuk='".$data['tgl_masuk']."',status='".$data['status']."' where NIS= '".$data['NIS']."'");
		return $result;
	}
	public function cari_siswa($nama,$table,$namakolom,$number,$offset){
		$result = $this->db->query("select * from ".$table." where ".$namakolom." like '%".$nama."%' limit ".$number." offset ".$offset);
		return $result->result();
	}

	public function jumlah_data_cari_uang_pondok($nama){
		$result = $this->db->query("Select count(*) as total from v_lihatpembayaranpondok where nama like '%".$nama."%'");
		return $result->row();
	}
	public function jumlah_data_cari_uang_buku($nama){
		$result = $this->db->query("Select count(*) as total from v_cicilanbuku where nama like '%".$nama."%'");
		return $result->row();
	}
	public function jumlah_data_cari_uang_pembangunan($nama){
		$result = $this->db->query("Select count(*) as total from v_cicilanpembangunan where nama like '%".$nama."%'");
		return $result->row();
	}
	public function jumlah_data_cari_uang_bimbel($nama){
		$result = $this->db->query("Select count(*) as total from v_cicilanbimbel where nama like '%".$nama."%'");
		return $result->row();
	}
	public function jumlah_data_cari_uang_infaq($nama){
		$result = $this->db->query("Select count(*) as total from v_lihatinfaq where nama_lengkap like '%".$nama."%'");
		return $result->row();
	}
	public function jumlah_data_cari_siswa($nama){
		$result = $this->db->query("Select count(*) as total from siswa where nama like '%".$nama."%'");
		return $result->row();
	}

}

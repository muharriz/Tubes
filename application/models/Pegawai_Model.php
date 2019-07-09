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
	public function pembayaran_pembangunan($number,$offset){
		$result = $this->db->get("v_lihatpembayaranpembangunan",$number,$offset);
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
	public function pembayaran_bimbel($number,$offset){
		$result = $this->db->get("v_lihatpembayaranbimbel",$number,$offset);
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
}

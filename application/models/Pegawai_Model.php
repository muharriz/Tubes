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
}

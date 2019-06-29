<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Model extends CI_Model {

	//Fungsi Cek User
	public function cekuser($data){
		$result = $this->db->query("select cek_user('".$data['pegawai_id']."','".$data['pegawai_password']."')");
		return $result;
	}
	//Fungsi Login
	public function login($data,$table){
		return $this->db->where($data)->get($table)->row();
	}
}

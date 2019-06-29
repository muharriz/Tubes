<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Controller extends CI_Model {

	//Fungsi Cek User
	public function cekuser($data){
		$result = $this->db->query("select cek_user('"+$data->nip+"','"+$data->password+"')");
		return $result;
	}
	//Fungsi Login
	public function login($data,$db){
		$this->db->where($data);
	}
}

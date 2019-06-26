<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Controller extends CI_Model {

	//Fungsi Login
	public function login($data,$db){
		$this->db->where($data);
	}
}

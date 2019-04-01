<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
		Mohon tidak mengganti informasi penulis script dibawah ini :
		Nama	: Agung wicaksono
		Email	: gantawisata@yahoo.co.id 
		Website : www.aikensoftware.net
		Blog	: https://codeigniterpraktis.wordpress.com/
		Call/SMS/Whatsapp : 085 334 158 713
		
		Hargailah karya orang lain, dengan membeli produk yang asli.
	 **/

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Table');
		$this->load->library('Pagination');
		$this->load->library('DX_Auth');
		
		$this->load->helper('form');
		$this->load->helper('url');
		
		$this->load->model('umum');
		$this->dx_auth->check_uri_permissions();
	}
	
	public function index()
	{
		$d['ada']	= '';
		
		$this->load->view('global/head', $d);
		$this->load->view('global/menu');
		$this->load->view('global/page');
		$this->load->view('global/foot');
	}
	
}

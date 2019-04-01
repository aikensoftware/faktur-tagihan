<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


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
	
	public function proses_cari_rekanan()
	{
		
		$json = [];
		if($this->input->get("q") <> ''){
			$kata = $this->input->get("q");
			$query = $this->db->query("select
								id_patner as id, 
								kode, 
								nama, 
								alamat
								from tag_patner 
								where nama like '%$kata%' or kode like '%$kata%' 
								");
			$json = $query->result();
		}
		echo json_encode($json);
		
	}
	
	public function proses_cari()
	{
		$json = [];
		if($this->input->get("q") <> ''){
			$kata = $this->input->get("q");
			
			$query = $this->db->query("
					select id_barang as id,nama_barang,kode
					from brg_nama
					where nama_barang like '%$kata%' or kode like '%$kata%' ");
			
			$json = $query->result();
		}
		echo json_encode($json);
		
	}
	
	public function cari_barang($kata=NULL)
	{
		$base = site_url();
		$tmp = '';
		if($kata <> ''){
			$kata = urldecode($kata);
			
			$cari_barang = $this->db->get_where('brg_nama',array('nama_barang like ' => '%'.$kata.'%'));
							
			if($cari_barang->num_rows()>0){
				$tmp .= '<div class="table-responsive">';
				$tmp .= '<table class="table table-striped">';
					foreach($cari_barang->result() as $b){
						/*
						# mencari stok barang
						$id_barang = $b->id_barang;
						$jumlah_stok = 0;
						$cari_stok = $this->db->query("SELECT SUM( stok_b ) AS jumlah_stok
														FROM brg_stok
														WHERE id_barang = $id_barang ");
						if($cari_stok->num_rows()>0){
							$ttt = $cari_stok->row();
							$jumlah_stok = $ttt->jumlah_stok;
						}
						*/
						$jumlah_stok = 0;
							
						$bar = '';
						if($b->barcode <> 0){
							$bar = '<br/>-'.$b->barcode;							
						}	
						$tmp .='<tr>
									<td>-'.$b->kode.''.$bar.'</td>
									<td><a href="'.$base.'kasir/pilih_barang/'.$b->id_barang.'">'.$b->nama_barang.'</a></td>
									<td>'.$jumlah_stok.'</td>
									<td><a class="btn btn-default btn-xs" href="'.$base.'kasir/pilih_barang/'.$b->id_barang.'" role="button">Pilih</a></td>
								</tr>';
					}
				$tmp .= '</table>';	
				$tmp .= '<div>';
			}
		}else{
			$tmp .='Data tidak ditemukan';
		}
		die($tmp);
	}
	
	
}

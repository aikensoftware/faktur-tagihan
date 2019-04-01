<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tag_pelanggan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->library('DX_Auth');
		$this->load->library('pagination');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->dx_auth->check_uri_permissions();
		
		$this->load->model('umum');
        $this->load->model('Tag_pelanggan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
		$sess_data['kode']  	= '';
		$sess_data['nama']		= '';
		$sess_data['alamat']	= '';
		$sess_data['id_patner']	= '';
		$sess_data['limit']		= '';
		$sess_data['id_status']	= 1;
		
		$this->session->set_userdata($sess_data);
		
		redirect('tag_pelanggan/cari_data');
		
		
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        $limit = 10;
		$id_patner = $this->input->get('id_patner',true);
	
		$sess_data['id_patner'] = $id_patner;
		$sess_data['limit']	= $limit;
		$sess_data['start']	= $start;
		$sess_data['kata']		= $q;
		$this->session->set_userdata($sess_data);
		
        if ($q <> '') {
            $config['base_url'] = site_url() . '/tag_pelanggan/index?q=' . urlencode($q);
            $config['first_url'] = site_url() . '/tag_pelanggan/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = site_url() . '/tag_pelanggan/index';
            $config['first_url'] = site_url() . '/tag_pelanggan/index';
        }

        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tag_pelanggan_model->total_rows($q,'id_patner', $id_patner);
        $tag_pelanggan = $this->Tag_pelanggan_model->get_limit_data($config['per_page'], $start, $q,'id_patner', $id_patner);

       
        $this->pagination->initialize($config);

        $data = array(
            'tag_pelanggan_data' => $tag_pelanggan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
			'pilih_patner'	=> $id_patner
        );
		$this->load->view('global/head');
		$this->load->view('global/menu');
        $this->load->view('admin/tag_pelanggan/tag_pelanggan_list', $data);
		$this->load->view('global/foot');
    }

	
	
	public function create_qrcode()
	{
		# kode update jika qrcode kosong
		$cari_data = $this->db->query("select * from tag_tagihan where qrcode ='' ");
		if($cari_data->num_rows() >0){
			$ada = 0;
			foreach($cari_data->result() as $b){
				
				$acak = $this->umum->acak_qrcode(10);
				
				$id_tagihan = $b->id_tagihan;
				//$up = array('qrcode' => $acak );
				//$this->db->where('id_tagihan', $id_tagihan);
				//$this->db->update('tag_tagihan', $up);
				$ada = 1;
				$updateArray[] = array(
					'id_tagihan'	=> $id_tagihan,
					'qrcode' 		=> $acak
				);
			}
			if($ada == 1){
				$this->db->update_batch('tag_tagihan',$updateArray, 'id_tagihan'); 
			}
			
			$this->session->set_flashdata('message', 'Sukses membuat QR code');
            redirect(site_url('tag_pelanggan/cari_data'));
		}else{
			$this->session->set_flashdata('message', 'GAGAL membuat QR code');
            redirect(site_url('tag_pelanggan/cari_data'));
		}
		
	}
	
	public function expo_excel()
	{
		$bulan = $this->input->post('bulan_beli',true);
		$tahun = $this->input->post('tahun_beli',true);
		$id_patner = $this->input->post('id_patner',true);
		$v_patner = '';
		if($id_patner <> 100000){
			$v_patner = " and b.id_patner = $id_patner ";
		}
		$d['data'] = $this->db->query("select a.no_transaksi, a.pokok, a.pajak, b.nama as nama_pelanggan, 
								c.nama as nama_patner, month(a.tanggal ) as bulan_tagihan
									
								from tag_tagihan as a
								left join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
								left join tag_patner 	as c on b.id_patner = c.id_patner
								
								where month(a.tanggal) = $bulan and year(a.tanggal) = $tahun  $v_patner
								order by a.id_tagihan asc ");
								
		$this->load->view('admin/tag_pelanggan/expo',$d);
	}
	
	public function simpan_faktur()
	{
		# cek bulan ini_get
		$bulan_ini = date('m');
		$tahun_ini = date('Y');
		
		$dt_cek = $this->db->query("select * from tag_tagihan where month(tanggal) = $bulan_ini and year(tanggal) = $tahun_ini ");
		if($dt_cek->num_rows() > 0)
		{
			$this->session->set_flashdata('message', 'Bulan ini sudah dibuat tagihan.');
			//redirect('tag_pelanggan/cari_data');
		}
		
		$awal = $this->input->post('nomor_faktur_awal',true);
		if($awal > 0){
			$dt_layanan = $this->db->query("select * from tag_layanan ");
			if($dt_layanan->num_rows() >0){
				foreach($dt_layanan->result() as $b){
					$jenis[$b->id_layanan] = $b->harga;
				}
			}
			
			/* yang lama
			$dt_pelanggan = $this->db->query("select a.* 
												from tag_pelanggan as a
												left join tag_tagihan as b on a.id_pelanggan = b.id_pelanggan
												where a.status = 1 and b.id_pelanggan is null 
												
												");
			*/
			
			$dt_pelanggan = $this->db->query("
												SELECT * 
												FROM `tag_pelanggan`
												where id_pelanggan not in (SELECT b.id_pelanggan
												from tag_tagihan as a
												right join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
												where  month(tanggal) = $bulan_ini and year(tanggal) = $tahun_ini
												group by a.id_pelanggan) and status = 1
											");
			$jml_aktif = $dt_pelanggan->num_rows();
			$nomor = 'BITS';			
			if($jml_aktif > 0){
				$in = array();
				foreach($dt_pelanggan->result() as $p){
					/*
						rumuse lek include ppn ya
						 Pokok 	: 100/110x100.000 = 90.909
						 PPN 	: 90.909x10/100 = 9.909
						 Total 	: 90.909+9.909 = 99.999

						rumuse lek exclude ppn
						 Pokok	: 100.000
						 PPN	: 100.000x10/100 =10.000
						 Total	: 100.000+10.000 = 110.000
						 
					*/
					$harga = $jenis[$p->id_layanan];
					$pokok = 0;
					$pajak = 0;
					$prosen_pajak = 10;
					
					$in_pajak = $p->in_pajak;
					
					if($in_pajak == 1){
						$pokok = (100/110)* $harga;
						$pajak = ($prosen_pajak/100) * $pokok;
					}else{
						$pokok = $harga;
						$pajak = ($prosen_pajak/100) * $harga;
					}
					//tanggal, periode, no_transaksi, id_pelanggan, 
					//total_tagihan, pajak, status, user_buat
					# update utk kode barang pada brg_nama
					
						
					switch (strlen($awal)) 
					{     
						case 1 : $kode = "000".$awal; 
						break;     
						case 2 : $kode = "00".$awal; 
						break;  
						case 3 : $kode = "0".$awal; 
						break;
						default: $kode = $awal;    
					}  
							
					$v_no_transaksi = $nomor.''.$kode;
					
					$in[] = array(
								'no_transaksi'	=> $v_no_transaksi,
								'id_pelanggan'	=> $p->id_pelanggan,
								'total_tagihan'	=> $harga,
								'pokok'			=> $pokok,
								'pajak'			=> $pajak,
								'tanggal'		=> date('Y-m-d H:i:s', time()),
								'user_buat'		=> $this->session->userdata('DX_user_id')
								);
					$awal++;
					
				}
				$this->db->insert_batch('tag_tagihan', $in); 
			}
			$this->session->set_flashdata('message', '<strong>Sukses !</strong> Bulan ini sudah dibuat tagihan.');
			redirect('tag_pelanggan/cari_data');
		}else{
			$this->session->set_flashdata('message', 'Nomor Faktur Awal Tidak Boleh Kosong');
			redirect('tag_pelanggan/cari_data');
		}
	}
	
	public function cetak_faktur()
	{
		$level = $this->session->userdata('DX_role_id');
		if($level == 2){
		$bulan_ini = date('m');
		$tahun_ini = date('Y');

		$id_tagihan = $this->uri->segment(3);
		if($id_tagihan > 0){
			$tagihan_bulan_ini = $this->db->query("select a.qrcode, a.id_tagihan, date(a.tanggal) as tanggal, month(a.tanggal) as bulan,
												year(a.tanggal) as tahun, a.no_transaksi, a.total_tagihan, a.pokok, a.pajak,
												b.kode, b.nama, b.alamat
												
												from tag_tagihan as a
												left join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
												
												where 
												a.id_tagihan 		= $id_tagihan and 
												month(a.tanggal) 	= '$bulan_ini' and 
												year(a.tanggal)		= '$tahun_ini' ");
												
			if($tagihan_bulan_ini->num_rows() >0){
				$b_ini = $tagihan_bulan_ini->row();
				$d['id_tagihan'] 		= $b_ini->id_tagihan;
				$d['bulan_tagihan']		= $this->umum->nama_bulan($b_ini->bulan).' '.$b_ini->tahun;
				$d['nomor_tagihan']		= $b_ini->no_transaksi;
				$d['tanggal_bayar']		= $this->umum->ubah_ke_garis($b_ini->tanggal);
				$d['nama_pelanggan']	= '['.$b_ini->kode.'] '.$b_ini->nama;
				$d['alamat_pelanggan']	= $b_ini->alamat;

				$d['abonemen']			= $b_ini->pokok;
				$d['pajak']				= $b_ini->pajak;
				$d['total']				= $b_ini->pokok + $b_ini->pajak;
				$d['qrcode']			= $b_ini->qrcode;
				
				$this->load->view('admin/tag_pelanggan/print_faktur', $d);
			}else{
				$this->session->set_flashdata('message', 'Halaman anda cari tidak ditemukan');
				redirect('tag_pelanggan/cari_data');
			}
			
		}else{
			$this->session->set_flashdata('message', 'Halaman anda cari tidak ditemukan');
			redirect('tag_pelanggan/cari_data');
		}
		
		}else{
			redirect('tag_pelanggan/index');
		}
	}
	
	
	public function cetak_faktur_ulang()
	{
		$level = $this->session->userdata('DX_role_id');
		if($level == 2){
		$bulan_ini = date('m');
		$tahun_ini = date('Y');

		$id_tagihan = $this->uri->segment(3);
		if($id_tagihan > 0){
			$tagihan_bulan_ini = $this->db->query("select a.qrcode, a.id_tagihan, date(a.tanggal) as tanggal, month(a.tanggal) as bulan,
												year(a.tanggal) as tahun, a.no_transaksi, a.total_tagihan, a.pokok, a.pajak,
												b.kode, b.nama, b.alamat
												
												from tag_tagihan as a
												left join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
												
												where 
												a.id_tagihan 		= $id_tagihan ");
												
			if($tagihan_bulan_ini->num_rows() >0){
				$b_ini = $tagihan_bulan_ini->row();
				$d['id_tagihan'] 		= $b_ini->id_tagihan;
				$d['bulan_tagihan']		= $this->umum->nama_bulan($b_ini->bulan).' '.$b_ini->tahun;
				$d['nomor_tagihan']		= $b_ini->no_transaksi;
				$d['tanggal_bayar']		= $this->umum->ubah_ke_garis($b_ini->tanggal);
				$d['nama_pelanggan']	= '['.$b_ini->kode.'] '.$b_ini->nama;
				$d['alamat_pelanggan']	= $b_ini->alamat;

				$d['abonemen']			= $b_ini->pokok;
				$d['pajak']				= $b_ini->pajak;
				$d['total']				= $b_ini->pokok + $b_ini->pajak;
				$d['qrcode']			= $b_ini->qrcode;
				
				$this->load->view('admin/tag_pelanggan/print_faktur', $d);
			}else{
				$this->session->set_flashdata('message', 'Halaman anda cari tidak ditemukan');
				redirect('tag_pelanggan/cari_data');
			}
			
		}else{
			$this->session->set_flashdata('message', 'Halaman anda cari tidak ditemukan');
			redirect('tag_pelanggan/cari_data');
		}
		
		}else{
			redirect('tag_pelanggan/index');
		}
	}
	
	public function print_semua()
	{
		$bulan_ini = date('m');
		$tahun_ini = date('Y');
		$pilihan = array();
		$ada = 0;
		
		$dt_tagihan = $this->db->query("select a.qrcode, a.id_tagihan, date(a.tanggal) as tanggal, month(a.tanggal) as bulan,
											year(a.tanggal) as tahun, a.no_transaksi, a.total_tagihan, a.pokok, a.pajak,
											b.id_pelanggan, b.kode, b.nama, b.alamat
											
											from tag_tagihan as a
											left join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
											
											where 
											month(a.tanggal) 	= '$bulan_ini' and 
											year(a.tanggal)		= '$tahun_ini' ");
											
		foreach($dt_tagihan->result() as $p){
			$nama = "tagihan_in_".$p->id_pelanggan;
			if($this->input->post($nama) > 0){
				$pilihan[] = $p->id_pelanggan;
				$ada = 1;
			}
		}
		$v_id_pelanggan = '';
		if($ada == 1){
			$gabungan = join(',', $pilihan);
			$v_id_pelanggan = " and b.id_pelanggan in (".$gabungan.")";
		}
		
		$tagihan_bulan_ini = $this->db->query("select a.qrcode, a.id_tagihan, date(a.tanggal) as tanggal, month(a.tanggal) as bulan,
											year(a.tanggal) as tahun, a.no_transaksi, a.total_tagihan, a.pokok, a.pajak,
											b.kode, b.nama, b.alamat
											
											from tag_tagihan as a
											left join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
											
											where 
											month(a.tanggal) 	= '$bulan_ini' and 
											year(a.tanggal)		= '$tahun_ini' $v_id_pelanggan
											
											");
											
		if($tagihan_bulan_ini->num_rows() >0){
			$b_ini = $tagihan_bulan_ini->row();
			
			$d['id_tagihan'] 		= $b_ini->id_tagihan;
			$d['data_faktur_all']	= $tagihan_bulan_ini;
			
			$this->load->view('admin/tag_pelanggan/print_faktur', $d);
		}else{
			$this->session->set_flashdata('message', 'Halaman anda cari tidak ditemukan');
			redirect('tag_pelanggan/cari_data');
	
		}
		
	}
	
	
	public function cari_data()
	{
		if($this->input->post("sort",TRUE)=="")
		{
			$sort = $this->session->userdata('sort');
		}else{
			$sess_data['sort']  = $this->input->post('sort',true);
			$this->session->set_userdata($sess_data);
			$sort = $this->session->userdata('sort');
		}
		$f = 'a.id_pelanggan';
		$u = 'desc';
		if($sort != NULL){
			$options[1] = ' Kode Asc'; 
			$options[2] = ' Kode Desc'; 
			$options[3] = ' Nama barang Asc'; 
			$options[4] = ' Nama barang Desc'; 
			$options[5] = ' Sedia Asc'; 
			$options[6] = ' Sedia Desc'; 
			
			if($sort == 1){
				$f = 'a.id_pelanggan';
				$u = 'asc';
			}else if($sort == 2){
				$f = 'a.id_pelanggan';
				$u = 'desc';
			}else if($sort == 3){
				$f = 'a.nama';
				$u = 'asc';
			}else if($sort == 4){
				$f = 'a.nama';
				$u = 'desc';
			}else if($sort == 5){
				$f = 'a.id_patner';
				$u = 'asc';
			}else if($sort == 6){
				$f = 'a.id_patner';
				$u = 'desc';
			}
		}
		
		if($this->input->post("kode",TRUE)=="")
		{
			$kode = $this->session->userdata('kode');
		}else{
			$sess_data['kode']  = $this->input->post('kode',true);
			$this->session->set_userdata($sess_data);
			$kode = $this->session->userdata('kode');
		}
		
		if($this->input->post("nama",TRUE)=="")
		{
			$nama = $this->session->userdata('nama');
		}else{
			$sess_data['nama']  = $this->input->post('nama',true);
			$this->session->set_userdata($sess_data);
			$nama = $this->session->userdata('nama');
		}
		
		if($this->input->post("alamat",TRUE)=="")
		{
			$alamat = $this->session->userdata('alamat');
		}else{
			$sess_data['alamat']  = $this->input->post('alamat',true);
			$this->session->set_userdata($sess_data);
			$alamat = $this->session->userdata('alamat');
		}
		
		if($this->input->post("id_patner",TRUE)=="")
		{
			$id_patner = $this->session->userdata('id_patner');
		}else{
			$sess_data['id_patner']  = $this->input->post('id_patner',true);
			$this->session->set_userdata($sess_data);
			$id_patner = $this->session->userdata('id_patner');
		}
		
		if($this->input->post("id_status",TRUE)=="")
		{
			$id_status = $this->session->userdata('id_status');
		}else{
			$sess_data['id_status']  = $this->input->post('id_status',true);
			$this->session->set_userdata($sess_data);
			$id_status = $this->session->userdata('id_status');
		}
		
		if($this->input->post("limit",TRUE)=="")
		{
			$limit = $this->session->userdata('limit');
		}else{
			$sess_data['limit']  = $this->input->post('limit',true);
			$this->session->set_userdata($sess_data);
			$limit = $this->session->userdata('limit');
		}
		
		
		$page = $this->uri->segment(3);
		if($limit <= 0){
			$limit = $this->config->item('limit_data');
		}
	
		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;
		
		$d['tot'] = $offset;
		
		$v_kode = '';
		if($kode <> ''){
			$v_kode = " and a.kode like '%$kode%' ";
		}
		$v_nama = '';
		if($nama <> ''){
			$v_nama = " and a.nama like '%$nama%' ";
		}
		$v_alamat = '';
		if($alamat <> ''){
			$v_alamat = " and a.alamat like '%$alamat%' ";
		}
			# pengecualinan
			$level = $this->session->userdata('DX_role_id');
			if($level <> 2){
				$id_patner = $this->session->userdata('DX_id_patner');
			}
		$v_id_patner = '';
		if($id_patner > 0){
			$v_id_patner = " and a.id_patner = $id_patner ";
		}
		
		
		
		$v_id_status = '';
		if($id_status == 1){
			$v_id_status = " and a.status = 1 ";
		}else if($id_status == 2){
			$v_id_status = " and a.status = 2 ";
		}
		
		$tot_hal = $this->db->query("
									select a.*, b.nama as nama_layanan, b.harga, c.nama as nama_patner  , c.prosen
									from tag_pelanggan 		as a
									left join tag_layanan 	as b on a.id_layanan = b.id_layanan 
									left join tag_patner 	as c on a.id_patner = c.id_patner
																		
									where a.id_pelanggan > 0 $v_kode $v_nama $v_alamat $v_id_patner $v_id_status
									order by $f $u
									");
		# jumlah data
		if($tot_hal->num_rows() >0){
			$d['total_data'] = $tot_hal->num_rows();
		}
		$d['jml_data'] = $tot_hal->num_rows();
		$config['base_url'] = site_url() . '/tag_pelanggan/cari_data/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['first_link'] = 'Awal';
		$config['last_link'] = 'Akhir';
		$config['next_link'] = 'Selanjutnya';
		$config['prev_link'] = 'Sebelumnya';
		
		$this->pagination->initialize($config);
		$d["paginator"] = $this->pagination->create_links();
	
		$d['tag_pelanggan_data'] = $this->db->query("
										select a.*, b.nama as nama_layanan, b.harga, c.nama as nama_patner , c.prosen
										from tag_pelanggan 		as a
										left join tag_layanan 	as b on a.id_layanan = b.id_layanan 
										left join tag_patner 	as c on a.id_patner = c.id_patner
										
										where a.id_pelanggan > 0 $v_kode $v_nama $v_alamat $v_id_patner $v_id_status
										order by $f $u 
										limit $offset, $limit
										")->result();
		
		$d['sort'] 			= $sort;
		$d['limit'] 		= $limit;
		$d['kode'] 			= $kode;
		$d['nama'] 			= $nama;
		$d['alamat'] 		= $alamat;
		$d['id_patner'] 	= $id_patner;
		if($id_patner > 0){
			$dt_pat = $this->db->query("select * from tag_patner where id_patner = $id_patner ")->row();
			$d['nama_rekanan'] = $dt_pat->nama;
		}
		$d['total_rows']	= $tot_hal->num_rows();
		$d['id_status']		= $id_status;
		
		$this->load->view('global/head');
		$this->load->view('global/menu');
		$this->load->view('admin/tag_pelanggan/tag_pelanggan_list', $d);
		$this->load->view('global/foot');
		
	}
	
	
    public function read($id) 
    {
        $row = $this->Tag_pelanggan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_pelanggan' => $row->id_pelanggan,
		'kode' => $row->kode,
		'nama' => $row->nama,
		'alamat' => $row->alamat,
		'telp' => $row->telp,
		'id_layanan' => $row->id_layanan,
		'id_patner' => $row->id_patner,
		'in_pajak' => $row->in_pajak,
		'tanggal_pasang' => $row->tanggal_pasang,
		'status' => $row->status,
	    );
			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_pelanggan/tag_pelanggan_read', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_pelanggan'));
        }
    }

    public function create() 
    {
		//$daftar_hari_boleh = array(1,2,3,4,5);
		//$hari_ini = date('d');
		
		$daftar_hari_boleh[1] =1;
		$daftar_hari_boleh[2] =25;
		$daftar_hari_boleh[3] =26;
		$daftar_hari_boleh[4] =27;
		$daftar_hari_boleh[5] =28;
		$daftar_hari_boleh[6] =29;
		$daftar_hari_boleh[7] =30;
		$daftar_hari_boleh[8] =31;
		
		$hari_ini = date('j');
		
		$cek = array_search($hari_ini,$daftar_hari_boleh);
		if($cek > 0){
			$oke = 'boleh';
		}else{
			$this->session->set_flashdata('message', 'Tidak boleh diakses ');
            redirect(site_url('tag_pelanggan'));
		}
		
        $data = array(
            'button' => 'Create',
            'action' => site_url('tag_pelanggan/create_action'),
	    'id_pelanggan' => set_value('id_pelanggan'),
	    'kode' => set_value('kode'),
	    'nama' => set_value('nama'),
	    'alamat' => set_value('alamat'),
	    'telp' => set_value('telp'),
	    'id_layanan' => set_value('id_layanan'),
	    'id_patner' => set_value('id_patner'),
	    'in_pajak' => set_value('in_pajak'),
	    'tanggal_pasang' => set_value('tanggal_pasang'),
	    'status' => set_value('status'),
	);
		$this->load->view('global/head');
		$this->load->view('global/menu');
        $this->load->view('admin/tag_pelanggan/tag_pelanggan_form', $data);
		$this->load->view('global/foot');
    }
    
    public function create_action() 
    {
		
		//$daftar_hari_boleh = array(1,2,3,4,5);
		//$hari_ini = date('d');
		
		$daftar_hari_boleh[1] =1;
		$daftar_hari_boleh[2] =25;
		$daftar_hari_boleh[3] =26;
		$daftar_hari_boleh[4] =27;
		$daftar_hari_boleh[5] =28;
		$daftar_hari_boleh[6] =29;
		$daftar_hari_boleh[7] =30;
		$daftar_hari_boleh[8] =31;
		
		$hari_ini = date('j');
		
		$cek = array_search($hari_ini,$daftar_hari_boleh);
		if($cek > 0){
			$oke = 'boleh';
		}else{
			$this->session->set_flashdata('message', 'Tidak boleh diakses ');
            redirect(site_url('tag_pelanggan'));
		}
		
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
			# tanggal masuk 
			$tanggal_masuk 	= $this->input->post('tanggal_masuk',true);
			$bulan_masuk 	= $this->input->post('bulan_masuk',true);
			$tahun_masuk 	= $this->input->post('tahun_masuk',true);
			$tgl_masuk = $tahun_masuk.'-'.$bulan_masuk.'-'.$tanggal_masuk;
			
			$acak = $this->umum->acak(40).''.date('Y-m-d');
			
            $data = array(
						'kode' => $this->input->post('kode',TRUE),
						'nama' => $this->input->post('nama',TRUE),
						'alamat' => $this->input->post('alamat',TRUE),
						'telp' => $this->input->post('telp',TRUE),
						'id_layanan' => $this->input->post('id_layanan',TRUE),
						'id_patner' => $this->input->post('id_patner',TRUE),
						'in_pajak' => $this->input->post('in_pajak',TRUE),
						'tanggal_pasang' => $tgl_masuk,
						'status' => $this->input->post('status',TRUE),
						'acak'		=> $acak
					);

            $this->Tag_pelanggan_model->insert($data);
			
			# update kode pelanggan
			$cek = $this->db->query("select * from tag_pelanggan where acak = '$acak' ");	
			if($cek->num_rows()>0){
				foreach($cek->result() as $b){
					$id_pelanggan = $b->id_pelanggan;
					
					switch (strlen($id_pelanggan)) 
					{     
						case 1 : $kode = "000".$id_pelanggan; 
						break;     
						case 2 : $kode = "00".$id_pelanggan; 
						break;  
						case 3 : $kode = "0".$id_pelanggan; 
						break;  
						default: $kode = $id_pelanggan;    
					}  
					
					$kode = 'P'.$kode;
				}	
			
			}else{
				$kode = 'P0001';
			}
			if($id_pelanggan >0){
				# proses update
				$up = array('kode' => $kode,'acak' =>'');
				$this->db->where('id_pelanggan', $id_pelanggan);
				$this->db->update('tag_pelanggan',$up);
			}
			
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tag_pelanggan'));
        }
    }
    
    public function update($id) 
    {
		//$daftar_hari_boleh = array(1,2,3,4,5);
		//$hari_ini = date('d');
		
		$daftar_hari_boleh[1] =1;
		$daftar_hari_boleh[2] =25;
		$daftar_hari_boleh[3] =26;
		$daftar_hari_boleh[4] =27;
		$daftar_hari_boleh[5] =28;
		$daftar_hari_boleh[6] =29;
		$daftar_hari_boleh[7] =30;
		$daftar_hari_boleh[8] =31;
		
		$hari_ini = date('j');
		
		$cek = array_search($hari_ini,$daftar_hari_boleh);
		if($cek > 0){
			$oke = 'boleh';
		}else{
			$this->session->set_flashdata('message', 'Tidak boleh diakses ');
            redirect(site_url('tag_pelanggan'));
		}
		
        $row = $this->Tag_pelanggan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tag_pelanggan/update_action'),
				'id_pelanggan' => set_value('id_pelanggan', $row->id_pelanggan),
				'kode' => set_value('kode', $row->kode),
				'nama' => set_value('nama', $row->nama),
				'alamat' => set_value('alamat', $row->alamat),
				'telp' => set_value('telp', $row->telp),
				'id_layanan' => set_value('id_layanan', $row->id_layanan),
				'id_patner' => set_value('id_patner', $row->id_patner),
				'in_pajak' => set_value('in_pajak', $row->in_pajak),
				'tanggal_pasang' => set_value('tanggal_pasang', $row->tanggal_pasang),
				'status' => set_value('status', $row->status),
				);

			$exp = explode('-',$row->tanggal_pasang);
			if(count($exp) == 3) {
				$data['tanggal_masuk'] = $exp[2];
				$data['bulan_masuk'] = $exp[1];
				$data['tahun_masuk'] = $exp[0];
			}
			
			
			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_pelanggan/tag_pelanggan_form', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_pelanggan'));
        }
    }
    
    public function update_action() 
    {
		//$daftar_hari_boleh = array(1,2,3,4,5);
		//$hari_ini = date('d');
		
		$daftar_hari_boleh[1] =1;
		$daftar_hari_boleh[2] =25;
		$daftar_hari_boleh[3] =26;
		$daftar_hari_boleh[4] =27;
		$daftar_hari_boleh[5] =28;
		$daftar_hari_boleh[6] =29;
		$daftar_hari_boleh[7] =30;
		$daftar_hari_boleh[8] =31;
		
		$hari_ini = date('j');
		
		
		$cek = array_search($hari_ini,$daftar_hari_boleh);
		if($cek > 0){
			$oke = 'boleh';
		}else{
			$this->session->set_flashdata('message', 'Tidak boleh diakses ');
            redirect(site_url('tag_pelanggan'));
		}
		
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pelanggan', TRUE));
        } else {
			# tanggal masuk 
			$tanggal_masuk 	= $this->input->post('tanggal_masuk',true);
			$bulan_masuk 	= $this->input->post('bulan_masuk',true);
			$tahun_masuk 	= $this->input->post('tahun_masuk',true);
			$tgl_masuk = $tahun_masuk.'-'.$bulan_masuk.'-'.$tanggal_masuk;
			
            $data = array(
				
				'nama' => $this->input->post('nama',TRUE),
				'alamat' => $this->input->post('alamat',TRUE),
				'telp' => $this->input->post('telp',TRUE),
				'id_layanan' => $this->input->post('id_layanan',TRUE),
				'id_patner' => $this->input->post('id_patner',TRUE),
				'in_pajak' => $this->input->post('in_pajak',TRUE),
				'tanggal_pasang' => $tgl_masuk,
				'status' => $this->input->post('status',TRUE),
				);

            $this->Tag_pelanggan_model->update($this->input->post('id_pelanggan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tag_pelanggan'));
        }
    }
    
    public function delete($id) 
    {
		//$daftar_hari_boleh = array(1,2,3,4,5);
		//$hari_ini = date('d');
		
		$daftar_hari_boleh[1] =1;
		$daftar_hari_boleh[2] =25;
		$daftar_hari_boleh[3] =26;
		$daftar_hari_boleh[4] =27;
		$daftar_hari_boleh[5] =28;
		$daftar_hari_boleh[6] =29;
		$daftar_hari_boleh[7] =30;
		$daftar_hari_boleh[8] =31;
		
		$hari_ini = date('j');
		
		$cek = array_search($hari_ini,$daftar_hari_boleh);
		if($cek > 0){
			$oke = 'boleh';
			
		}else{
			
			$this->session->set_flashdata('message', 'Tidak boleh diakses ');
            redirect(site_url('tag_pelanggan'));
		}
		
        $row = $this->Tag_pelanggan_model->get_by_id($id);
		$this->session->set_flashdata('message', 'Record Not Found');
        redirect(site_url('tag_pelanggan'));
        if ($row) {
            $this->Tag_pelanggan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tag_pelanggan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_pelanggan'));
        }
    }

    public function _rules() 
    {
	//$this->form_validation->set_rules('kode', 'kode', 'trim|required');
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
	$this->form_validation->set_rules('id_layanan', 'id layanan', 'trim|required');
	$this->form_validation->set_rules('id_patner', 'id patner', 'trim|required');
	$this->form_validation->set_rules('in_pajak', 'in pajak', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id_pelanggan', 'id_pelanggan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tag_pelanggan.xls";
        $judul = "tag_pelanggan";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Kode");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
	xlsWriteLabel($tablehead, $kolomhead++, "Telp");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Layanan");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Patner");
	xlsWriteLabel($tablehead, $kolomhead++, "In Pajak");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Pasang");
	xlsWriteLabel($tablehead, $kolomhead++, "Status");
				$limit = $this->session->userdata('limit');
				$start = $this->session->userdata('start');
				$q = $this->session->userdata('kata');
				
				

	foreach ($this->Tag_pelanggan_model->get_limit_data($limit, $start, $q) as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kode);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->telp);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_layanan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_patner);
	    xlsWriteNumber($tablebody, $kolombody++, $data->in_pajak);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_pasang);
	    xlsWriteNumber($tablebody, $kolombody++, $data->status);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tag_pelanggan.doc");

		$limit = $this->session->userdata('limit');
		$start = $this->session->userdata('start');
		$q = $this->session->userdata('kata');
		
        $data = array(
            'tag_pelanggan_data' => $this->Tag_pelanggan_model->get_limit_data($limit, $start, $q),
            'start' => 0
        );
        
        $this->load->view('admin/tag_pelanggan/tag_pelanggan_doc',$data);
    }
	
	public function detail_faktur($id) 
    {
        $row = $this->Tag_pelanggan_model->get_by_id($id);
        if ($row) {
            $data = array(
						'id_pelanggan' => $row->id_pelanggan,
						'kode' => $row->kode,
						'nama' => $row->nama,
						'alamat' => $row->alamat,
						'telp' => $row->telp,
						'id_layanan' => $row->id_layanan,
						'id_patner' => $row->id_patner,
						'in_pajak' => $row->in_pajak,
						'tanggal_pasang' => $row->tanggal_pasang,
						'status' => $row->status,
						);
			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_pelanggan/detail_tagihan', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_pelanggan'));
        }
    }
	

}

/* End of file Tag_pelanggan.php */
/* Location: ./application/controllers/Tag_pelanggan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-14 05:28:11 */
/* http://harviacode.com */
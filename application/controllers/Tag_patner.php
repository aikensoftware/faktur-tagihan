<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tag_patner extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->library('DX_Auth');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->dx_auth->check_uri_permissions();
		
		$this->load->model('umum');
        $this->load->model('Tag_patner_model');
        $this->load->library('form_validation');
    }

	public function reset_password()
	{
		$id = $this->uri->segment(3);
		if($id >0){
			$dt_patner = $this->db->query("select * from tag_patner where id_patner = $id ");
			if($dt_patner->num_rows() > 0){
				$r = $dt_patner->row();
				$id_patner = $r->id_patner;
				
				$pass = '$1$0s1.HA1.$LbpaUHzFOUA86f3C/h5vl.';
				//reset ke 1234567
				$update_user = $this->db->query("update users set password = '$pass' where id_patner = $id_patner ");
				
				$this->session->set_flashdata('message', 'Reset password berhasil menjadi default  1234567 ');
				redirect('tag_patner');
			}
		}
	}
	
    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        $limit = 10;
		
		$sess_data['limit']	= $limit;
		$sess_data['start']	= $start;
		$sess_data['kata']		= $q;
		$this->session->set_userdata($sess_data);
		
        if ($q <> '') {
            $config['base_url'] = site_url() . '/tag_patner/index?q=' . urlencode($q);
            $config['first_url'] = site_url() . '/tag_patner/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = site_url() . '/tag_patner/index';
            $config['first_url'] = site_url() . '/tag_patner/index';
        }

        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tag_patner_model->total_rows($q);
        $tag_patner = $this->Tag_patner_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tag_patner_data' => $tag_patner,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
		$this->load->view('global/head');
		$this->load->view('global/menu');
        $this->load->view('admin/tag_patner/tag_patner_list', $data);
		$this->load->view('global/foot');
    }

    public function read($id) 
    {
        $row = $this->Tag_patner_model->get_by_id($id);
        if ($row) {
            $data = array(
						'id_patner' => $row->id_patner,
						'kode' => $row->kode,
						'nama' => $row->nama,
						'alamat' => $row->alamat,
						'telp' => $row->telp,
						'prosen'	=> $row->prosen
						);
			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_patner/tag_patner_read', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_patner'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tag_patner/create_action'),
			'id_patner' => set_value('id_patner'),
			'kode' => set_value('kode'),
			'nama' => set_value('nama'),
			'alamat' => set_value('alamat'),
			'telp' => set_value('telp'),
			'prosen'	=> set_value('prosen')
		);
		$this->load->view('global/head');
		$this->load->view('global/menu');
        $this->load->view('admin/tag_patner/tag_patner_form', $data);
		$this->load->view('global/foot');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
			$acak = $this->umum->acak(60);
			
            $data = array(
				'nama' 		=> $this->input->post('nama',TRUE),
				'alamat'	=> $this->input->post('alamat',TRUE),
				'telp'		=> $this->input->post('telp',TRUE),
				'acak'		=> $acak,
				'prosen'	=> $this->input->post('prosen',true)
				);

            $this->Tag_patner_model->insert($data);
			
			$cek_data = $this->db->query("select * from tag_patner where acak = '$acak' ");
			if($cek_data->num_rows() > 0){
				$r = $cek_data->row();
				$id_patner = $r->id_patner;
				
				switch (strlen($id_patner)) 
				{     
					case 1 : $kode = "000".$id_patner; 
					break;     
					case 2 : $kode = "00".$id_patner; 
					break;  
					case 3 : $kode = "0".$id_patner; 
					break;
					default: $kode = $id_patner;    
				}  
				
				$password = '1234567';
				$kode = 'R'.$kode;
				#=== input user === #
				$user = $kode;
				$email = $kode.'@localhost.com';
				$pass_std = $password;
				
				if($email <> ''){
					$this->dx_auth->register($user, $pass_std, $email);
				}
				$update_user = $this->db->query("update users set id_patner = $id_patner where username='$user'");
				$update_tb_siswa = $this->db->query("update tag_patner set acak = '', kode = '$kode' where id_patner = $id_patner ");
			}
			
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tag_patner'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tag_patner_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tag_patner/update_action'),
				'id_patner' => set_value('id_patner', $row->id_patner),
				'kode' => set_value('kode', $row->kode),
				'nama' => set_value('nama', $row->nama),
				'alamat' => set_value('alamat', $row->alamat),
				'telp' => set_value('telp', $row->telp),
				'prosen' => set_value('prosen', $row->prosen)
				);

			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_patner/tag_patner_form', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_patner'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_patner', TRUE));
        } else {
            $data = array(
				'nama' => $this->input->post('nama',TRUE),
				'alamat' => $this->input->post('alamat',TRUE),
				'telp' => $this->input->post('telp',TRUE),
				'prosen'	=> $this->input->post('prosen',true)
			);

            $this->Tag_patner_model->update($this->input->post('id_patner', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tag_patner'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tag_patner_model->get_by_id($id);

        if ($row) {
            $this->Tag_patner_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tag_patner'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_patner'));
        }
    }

    public function _rules() 
    {
	
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
	$this->form_validation->set_rules('prosen', 'prosen', 'trim|required');

	$this->form_validation->set_rules('id_patner', 'id_patner', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tag_patner.xls";
        $judul = "tag_patner";
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
				$limit = $this->session->userdata('limit');
				$start = $this->session->userdata('start');
				$q = $this->session->userdata('kata');
				
				

	foreach ($this->Tag_patner_model->get_limit_data($limit, $start, $q) as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kode);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->telp);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tag_patner.doc");

		$limit = $this->session->userdata('limit');
		$start = $this->session->userdata('start');
		$q = $this->session->userdata('kata');
		
        $data = array(
            'tag_patner_data' => $this->Tag_patner_model->get_limit_data($limit, $start, $q),
            'start' => 0
        );
        
        $this->load->view('admin/tag_patner/tag_patner_doc',$data);
    }

}

/* End of file Tag_patner.php */
/* Location: ./application/controllers/Tag_patner.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-14 05:26:08 */
/* http://harviacode.com */
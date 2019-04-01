<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tag_layanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('customers_model');
		$this->load->library('DX_Auth');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->dx_auth->check_uri_permissions();
		
		$this->load->model('umum');
        $this->load->model('Tag_layanan_model');
        $this->load->library('form_validation');
    }

	public function coba()
	{
		
		$this->load->view("customers_view");
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
            $config['base_url'] = site_url() . '/tag_layanan/index?q=' . urlencode($q);
            $config['first_url'] = site_url() . '/tag_layanan/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = site_url() . '/tag_layanan/index';
            $config['first_url'] = site_url() . '/tag_layanan/index';
        }

        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tag_layanan_model->total_rows($q);
        $tag_layanan = $this->Tag_layanan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tag_layanan_data' => $tag_layanan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
		$this->load->view('global/head');
		$this->load->view('global/menu');
        $this->load->view('admin/tag_layanan/tag_layanan_list', $data);
		$this->load->view('global/foot');
    }

    public function read($id) 
    {
        $row = $this->Tag_layanan_model->get_by_id($id);
        if ($row) {
            $data = array(
				'id_layanan' => $row->id_layanan,
				'nama' => $row->nama,
				'ket' => $row->ket,
				'harga'	=> $row->harga,
				'urutan' => $row->urutan,
				);
			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_layanan/tag_layanan_read', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_layanan'));
        }
    }

    public function create() 
    {
        $data = array(
						'button' => 'Create',
						'action' => site_url('tag_layanan/create_action'),
						'id_layanan' => set_value('id_layanan'),
						'nama' => set_value('nama'),
						'harga'	=> set_value('harga'),
						'ket' => set_value('ket'),
						'urutan' => set_value('urutan'),
					);
		$this->load->view('global/head');
		$this->load->view('global/menu');
        $this->load->view('admin/tag_layanan/tag_layanan_form', $data);
		$this->load->view('global/foot');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
							'nama' => $this->input->post('nama',TRUE),
							'ket' => $this->input->post('ket',TRUE),
							'harga' => $this->input->post('harga',TRUE),
							'urutan' => $this->input->post('urutan',TRUE),
							);

            $this->Tag_layanan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tag_layanan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tag_layanan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tag_layanan/update_action'),
				'id_layanan' => set_value('id_layanan', $row->id_layanan),
				'nama' => set_value('nama', $row->nama),
				'ket' => set_value('ket', $row->ket),
				'harga' => set_value('harga', $row->harga),
				'urutan' => set_value('urutan', $row->urutan),
				);

			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_layanan/tag_layanan_form', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_layanan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_layanan', TRUE));
        } else {
            $data = array(
						'nama' => $this->input->post('nama',TRUE),
						'ket' => $this->input->post('ket',TRUE),
						'harga' => $this->input->post('harga',TRUE),
						'urutan' => $this->input->post('urutan',TRUE),
						);

            $this->Tag_layanan_model->update($this->input->post('id_layanan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tag_layanan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tag_layanan_model->get_by_id($id);

        if ($row) {
            $this->Tag_layanan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tag_layanan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_layanan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('ket', 'ket', 'trim|required');
	$this->form_validation->set_rules('urutan', 'urutan', 'trim|required');

	$this->form_validation->set_rules('id_layanan', 'id_layanan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tag_layanan.xls";
        $judul = "tag_layanan";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama");
	xlsWriteLabel($tablehead, $kolomhead++, "Ket");
	xlsWriteLabel($tablehead, $kolomhead++, "Urutan");
				$limit = $this->session->userdata('limit');
				$start = $this->session->userdata('start');
				$q = $this->session->userdata('kata');
				
				

	foreach ($this->Tag_layanan_model->get_limit_data($limit, $start, $q) as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->ket);
	    xlsWriteNumber($tablebody, $kolombody++, $data->urutan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tag_layanan.doc");

		$limit = $this->session->userdata('limit');
		$start = $this->session->userdata('start');
		$q = $this->session->userdata('kata');
		
        $data = array(
            'tag_layanan_data' => $this->Tag_layanan_model->get_limit_data($limit, $start, $q),
            'start' => 0
        );
        
        $this->load->view('admin/tag_layanan/tag_layanan_doc',$data);
    }

}

/* End of file Tag_layanan.php */
/* Location: ./application/controllers/Tag_layanan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-14 05:24:10 */
/* http://harviacode.com */
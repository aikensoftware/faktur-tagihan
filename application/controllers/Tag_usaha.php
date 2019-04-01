<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tag_usaha extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->library('DX_Auth');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->dx_auth->check_uri_permissions();
		
		$this->load->model('umum');
        $this->load->model('Tag_usaha_model');
        $this->load->library('form_validation');
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
            $config['base_url'] = site_url() . '/tag_usaha/index?q=' . urlencode($q);
            $config['first_url'] = site_url() . '/tag_usaha/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = site_url() . '/tag_usaha/index';
            $config['first_url'] = site_url() . '/tag_usaha/index';
        }

        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tag_usaha_model->total_rows($q);
        $tag_usaha = $this->Tag_usaha_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tag_usaha_data' => $tag_usaha,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
		$this->load->view('global/head');
		$this->load->view('global/menu');
        $this->load->view('admin/tag_usaha/tag_usaha_list', $data);
		$this->load->view('global/foot');
    }

    public function read($id) 
    {
        $row = $this->Tag_usaha_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_usaha' => $row->id_usaha,
		'nama' => $row->nama,
		'alamat' => $row->alamat,
		'telp' => $row->telp,
		'ket' => $row->ket,
	    );
			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_usaha/tag_usaha_read', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_usaha'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tag_usaha/create_action'),
	    'id_usaha' => set_value('id_usaha'),
	    'nama' => set_value('nama'),
	    'alamat' => set_value('alamat'),
	    'telp' => set_value('telp'),
	    'ket' => set_value('ket'),
	);
		$this->load->view('global/head');
		$this->load->view('global/menu');
        $this->load->view('admin/tag_usaha/tag_usaha_form', $data);
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
		'alamat' => $this->input->post('alamat',TRUE),
		'telp' => $this->input->post('telp',TRUE),
		'ket' => $this->input->post('ket',TRUE),
	    );

            $this->Tag_usaha_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tag_usaha'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tag_usaha_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tag_usaha/update_action'),
		'id_usaha' => set_value('id_usaha', $row->id_usaha),
		'nama' => set_value('nama', $row->nama),
		'alamat' => set_value('alamat', $row->alamat),
		'telp' => set_value('telp', $row->telp),
		'ket' => set_value('ket', $row->ket),
	    );

			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_usaha/tag_usaha_form', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_usaha'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_usaha', TRUE));
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'telp' => $this->input->post('telp',TRUE),
		'ket' => $this->input->post('ket',TRUE),
	    );

            $this->Tag_usaha_model->update($this->input->post('id_usaha', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tag_usaha'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tag_usaha_model->get_by_id($id);

        if ($row) {
            $this->Tag_usaha_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tag_usaha'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_usaha'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
	$this->form_validation->set_rules('ket', 'ket', 'trim|required');

	$this->form_validation->set_rules('id_usaha', 'id_usaha', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tag_usaha.xls";
        $judul = "tag_usaha";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
	xlsWriteLabel($tablehead, $kolomhead++, "Telp");
	xlsWriteLabel($tablehead, $kolomhead++, "Ket");
				$limit = $this->session->userdata('limit');
				$start = $this->session->userdata('start');
				$q = $this->session->userdata('kata');
				
				

	foreach ($this->Tag_usaha_model->get_limit_data($limit, $start, $q) as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->telp);
	    xlsWriteLabel($tablebody, $kolombody++, $data->ket);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tag_usaha.doc");

		$limit = $this->session->userdata('limit');
		$start = $this->session->userdata('start');
		$q = $this->session->userdata('kata');
		
        $data = array(
            'tag_usaha_data' => $this->Tag_usaha_model->get_limit_data($limit, $start, $q),
            'start' => 0
        );
        
        $this->load->view('admin/tag_usaha/tag_usaha_doc',$data);
    }

}

/* End of file Tag_usaha.php */
/* Location: ./application/controllers/Tag_usaha.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-14 05:29:00 */
/* http://harviacode.com */
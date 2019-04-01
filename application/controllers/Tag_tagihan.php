<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tag_tagihan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->library('DX_Auth');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->dx_auth->check_uri_permissions();
		
		$this->load->model('umum');
        $this->load->model('Tag_tagihan_model');
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
            $config['base_url'] = site_url() . '/tag_tagihan/index?q=' . urlencode($q);
            $config['first_url'] = site_url() . '/tag_tagihan/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = site_url() . '/tag_tagihan/index';
            $config['first_url'] = site_url() . '/tag_tagihan/index';
        }

        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tag_tagihan_model->total_rows($q);
        $tag_tagihan = $this->Tag_tagihan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tag_tagihan_data' => $tag_tagihan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
		$this->load->view('global/head');
		$this->load->view('global/menu');
        $this->load->view('admin/tag_tagihan/tag_tagihan_list', $data);
		$this->load->view('global/foot');
    }

    public function read($id) 
    {
        $row = $this->Tag_tagihan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_tagihan' => $row->id_tagihan,
		'tanggal' => $row->tanggal,
		'periode' => $row->periode,
		'no_transaksi' => $row->no_transaksi,
		'id_pelanggan' => $row->id_pelanggan,
		'total_tagihan' => $row->total_tagihan,
		'pajak' => $row->pajak,
		'status' => $row->status,
		'user_buat' => $row->user_buat,
	    );
			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_tagihan/tag_tagihan_read', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_tagihan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tag_tagihan/create_action'),
	    'id_tagihan' => set_value('id_tagihan'),
	    'tanggal' => set_value('tanggal'),
	    'periode' => set_value('periode'),
	    'no_transaksi' => set_value('no_transaksi'),
	    'id_pelanggan' => set_value('id_pelanggan'),
	    'total_tagihan' => set_value('total_tagihan'),
	    'pajak' => set_value('pajak'),
	    'status' => set_value('status'),
	    'user_buat' => set_value('user_buat'),
	);
		$this->load->view('global/head');
		$this->load->view('global/menu');
        $this->load->view('admin/tag_tagihan/tag_tagihan_form', $data);
		$this->load->view('global/foot');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'tanggal' => $this->input->post('tanggal',TRUE),
		'periode' => $this->input->post('periode',TRUE),
		'no_transaksi' => $this->input->post('no_transaksi',TRUE),
		'id_pelanggan' => $this->input->post('id_pelanggan',TRUE),
		'total_tagihan' => $this->input->post('total_tagihan',TRUE),
		'pajak' => $this->input->post('pajak',TRUE),
		'status' => $this->input->post('status',TRUE),
		'user_buat' => $this->input->post('user_buat',TRUE),
	    );

            $this->Tag_tagihan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tag_tagihan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tag_tagihan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tag_tagihan/update_action'),
		'id_tagihan' => set_value('id_tagihan', $row->id_tagihan),
		'tanggal' => set_value('tanggal', $row->tanggal),
		'periode' => set_value('periode', $row->periode),
		'no_transaksi' => set_value('no_transaksi', $row->no_transaksi),
		'id_pelanggan' => set_value('id_pelanggan', $row->id_pelanggan),
		'total_tagihan' => set_value('total_tagihan', $row->total_tagihan),
		'pajak' => set_value('pajak', $row->pajak),
		'status' => set_value('status', $row->status),
		'user_buat' => set_value('user_buat', $row->user_buat),
	    );

			$this->load->view('global/head');
			$this->load->view('global/menu');
            $this->load->view('admin/tag_tagihan/tag_tagihan_form', $data);
			$this->load->view('global/foot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_tagihan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_tagihan', TRUE));
        } else {
            $data = array(
		'tanggal' => $this->input->post('tanggal',TRUE),
		'periode' => $this->input->post('periode',TRUE),
		'no_transaksi' => $this->input->post('no_transaksi',TRUE),
		'id_pelanggan' => $this->input->post('id_pelanggan',TRUE),
		'total_tagihan' => $this->input->post('total_tagihan',TRUE),
		'pajak' => $this->input->post('pajak',TRUE),
		'status' => $this->input->post('status',TRUE),
		'user_buat' => $this->input->post('user_buat',TRUE),
	    );

            $this->Tag_tagihan_model->update($this->input->post('id_tagihan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tag_tagihan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tag_tagihan_model->get_by_id($id);

        if ($row) {
            $this->Tag_tagihan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tag_tagihan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tag_tagihan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
	$this->form_validation->set_rules('periode', 'periode', 'trim|required');
	$this->form_validation->set_rules('no_transaksi', 'no transaksi', 'trim|required');
	$this->form_validation->set_rules('id_pelanggan', 'id pelanggan', 'trim|required');
	$this->form_validation->set_rules('total_tagihan', 'total tagihan', 'trim|required');
	$this->form_validation->set_rules('pajak', 'pajak', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');
	$this->form_validation->set_rules('user_buat', 'user buat', 'trim|required');

	$this->form_validation->set_rules('id_tagihan', 'id_tagihan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tag_tagihan.xls";
        $judul = "tag_tagihan";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
	xlsWriteLabel($tablehead, $kolomhead++, "Periode");
	xlsWriteLabel($tablehead, $kolomhead++, "No Transaksi");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Pelanggan");
	xlsWriteLabel($tablehead, $kolomhead++, "Total Tagihan");
	xlsWriteLabel($tablehead, $kolomhead++, "Pajak");
	xlsWriteLabel($tablehead, $kolomhead++, "Status");
	xlsWriteLabel($tablehead, $kolomhead++, "User Buat");
				$limit = $this->session->userdata('limit');
				$start = $this->session->userdata('start');
				$q = $this->session->userdata('kata');
				
				

	foreach ($this->Tag_tagihan_model->get_limit_data($limit, $start, $q) as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal);
	    xlsWriteLabel($tablebody, $kolombody++, $data->periode);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_transaksi);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_pelanggan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->total_tagihan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->pajak);
	    xlsWriteNumber($tablebody, $kolombody++, $data->status);
	    xlsWriteNumber($tablebody, $kolombody++, $data->user_buat);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tag_tagihan.doc");

		$limit = $this->session->userdata('limit');
		$start = $this->session->userdata('start');
		$q = $this->session->userdata('kata');
		
        $data = array(
            'tag_tagihan_data' => $this->Tag_tagihan_model->get_limit_data($limit, $start, $q),
            'start' => 0
        );
        
        $this->load->view('admin/tag_tagihan/tag_tagihan_doc',$data);
    }

}

/* End of file Tag_tagihan.php */
/* Location: ./application/controllers/Tag_tagihan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-14 05:28:30 */
/* http://harviacode.com */
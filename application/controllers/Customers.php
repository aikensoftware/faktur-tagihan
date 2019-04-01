<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Customers extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customers_model');
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
		
        $this->load->helper('url');
        $this->load->view('customers_view');
    }
 
    public function ajax_list()
    {
        $list = $this->customers_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
		$base = site_url();
        foreach ($list as $customers) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $customers->FirstName;
            $row[] = $customers->LastName;
            $row[] = $customers->phone;
            $row[] = $customers->address;
            $row[] = $customers->city;
            $row[] = $customers->country;
			$row[] = '<a class="btn btn-warning" href="'.$base.'/edit/'.$customers->id.'" role="button">Update</a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->customers_model->count_all(),
                        "recordsFiltered" => $this->customers_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
 
}
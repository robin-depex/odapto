<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class client_list extends MY_Controller  { 
 
		 
	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->library('Pdf_Library');
		$this->load->library('Excel_Library');
        if (!$this->session->userdata('logged_in'))
	    { 
	        redirect('login');
	    }
	    else
	    {
	    	if($this->session->userdata('userid') != 1)
	    	{
		    	$rights = $this->check_rights();
		    	$url = $this->uri->segment(1).'/'.$this->uri->segment(2);
		    	if(!in_array($url, $rights))
		    	{
		    		$this->load->view('admin/not_access');
		    	}
		    }
	    }

        $this->load->helper('form');
        $this->load->model('client_list_model');
    }
 		
	// index method
	public function index()
	{
		$data['recored'] = $this->client_list_model->findAll();
		$data['message'] = $this->get_msg();
		$this->load->view('admin/client_list/client_list-list',$data);
	}
 	
	public function get_company_data()
	{
		return $this->db->get('company')->result();
	}
 		
	// pdf method
	public function pdf()
	{
		$data['recored'] = $this->client_list_model->findAll();
		$this->load->view('admin/client_list/client_list-pdf',$data);
	}
 		
	// excel method
	public function excel()
	{
		$data['recored'] = $this->client_list_model->findAll();
		$this->load->view('admin/client_list/client_list-excel',$data);
	}
		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');


		$this->form_validation->set_rules('txt_client_list_first_name', 'client_list first name', 'required');
		$this->form_validation->set_rules('txt_client_list_email', 'client_list email', 'required');
		$this->form_validation->set_rules('txt_client_list_email', 'Valid email', 'valid_email');
		$this->form_validation->set_rules('txt_client_list_address', 'client_list address', 'required');
		$this->form_validation->set_rules('txt_client_list_city', 'client_list city', 'required');
		$this->form_validation->set_rules('txt_client_list_zipcode', 'client_list zipcode', 'required');
		$this->form_validation->set_rules('txt_client_list_phone', 'client_list phone', 'required');
		$this->form_validation->set_rules('txt_client_list_is_active', 'Active', 'required');
		
        
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/client_list/client_list-add');
		}
		else
		{
			$this->client_list_model->insert();
			$this->session->set_flashdata('msg','Successfully Insert Data !');
			$this->index();
		}
	}
		
	// update method
	public function update($id)
	{
		$this->client_list_model->update($id);
		$this->session->set_flashdata('msg','Successfully Update Data !');
		$this->index();
	}
		
	// edit method
	public function edit($id)
	{
		$data['recored'] = $this->client_list_model->findOne($id);
		$data['message'] = $this->get_msg();
		$this->load->view('admin/client_list/client_list-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{
		
		if($this->session->userdata('userid') != 1)
	    {

			$rights = $this->check_rights();
			if(!in_array('cutomer/delete', $rights))
	    	{
	    		return redirect('access');
	    	}
	    	else
	    	{
	    		$this->client_list_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				return redirect('client_list');
			}
		}
		else
		{
				$this->client_list_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				return redirect('client_list');
		}
		
	}

	public function active_inactive($id,$mode)
	{
		$this->client_list_model->change_status($id,$mode);
		return redirect('client_list');
	}

 } 
 

?>
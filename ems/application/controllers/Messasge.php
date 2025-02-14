<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends MY_Controller  { 
 
		 
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
        
    }
 		
	// index method
	public function index()
	{
		//$data['recored'] = $this->calendar_model->findAll();
		$data['message'] = $this->get_msg();
		$this->load->view('admin/message/message-list',$data);
	}
 	
 	public function delete($id)
	{
		$this->db->where('m_id',$id);
		$this->db->delete('message');

		return redirect('message');
	}

 } 
 

?>
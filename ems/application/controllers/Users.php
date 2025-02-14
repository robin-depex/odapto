<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Users extends MY_Controller  { 
 
		
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

		    	if($url != 'users/change_password'){
		    		if($url != 'users/c_password')
		    		{
				    	if(!in_array($url, $rights))
				    	{
				    		$this->load->view('admin/not_access');
				    	}
				    }
			    }
		    }
	    }
	    
        $this->load->helper('form');
        $this->load->model('users_model');
    }
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	

	public function change_password()
	{
		$this->load->view('admin/users/user-password');
	}

	public function c_password()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('old_password', 'Old Password', 'required');
		$this->form_validation->set_rules('txt_password', 'New Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[txt_password]');
        
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/users/user-password');
		}
		else
		{
			$check = $this->users_model->change_password();

			if($check)
			{
				$this->session->set_flashdata('msg','Successfully Update password !');
			}
			else
			{
				$this->session->set_flashdata('msg','Not Change password Please Enter Correct Old Password !');
			}
			$this->load->view('admin/users/user-password');
		}

		
		
	}

 } 
 

?>
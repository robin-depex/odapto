<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Webpage extends MY_Controller  { 
 
		
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
	
	public function index()
	{
		$data['message'] = $this->get_msg();
		$data['recored'] = $this->db->get('host')->row_array();
		$this->load->view('admin/webpage/list',$data);
	}

	public function update_email()
	{

		$this->load->library('form_validation');


		$this->form_validation->set_rules('txt_name', 'Host name', 'required');
		$this->form_validation->set_rules('txt_user_name', 'Host user name email', 'required|valid_email');
		$this->form_validation->set_rules('txt_user_pass', 'Host Password', 'required');
		
        if ($this->form_validation->run() === FALSE)
        {
        	$data['message'] = $this->get_msg();
			$this->load->view('admin/webpage/list',$data);
		}
		else
		{
			
			$data = array(
			'host_name' => $this->input->post('txt_name'),
			'host_user_name' => $this->input->post('txt_user_name'),
			'host_user_pass' => $this->input->post('txt_user_pass'),
			);
            $this->db->where('host_id', 1);
            $this->db->update('host', $data);

			redirect('webpage');
		}
	}

	
	
 } 
 

?>
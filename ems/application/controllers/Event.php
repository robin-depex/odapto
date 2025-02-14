<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Event extends CI_Controller  { 
 
		
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
        $this->load->model('event_model');
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
	
	
 		
	// index method
	public function index()
	{
		$data['recored'] = $this->event_model->findAll();
		$this->load->view('admin/event/event-list',$data);
	}
 		
	// pdf method
	public function pdf()
	{
		$data['recored'] = $this->event_model->findAll();
		$this->load->view('admin/event/event-pdf',$data);
	}
 		
	// excel method
	public function excel()
	{
		$data['recored'] = $this->event_model->findAll();
		$this->load->view('admin/event/event-excel',$data);
	}
		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');


		$this->form_validation->set_rules('txt_event_name', 'Event name', 'required');
		$this->form_validation->set_rules('txt_event_add', 'Event add', 'required');
		$this->form_validation->set_rules('txt_event_date', 'Event date', 'required');
		
		$this->form_validation->set_rules('txt_event_person', 'Event person', 'required');
		$this->form_validation->set_rules('txt_event_is_active', 'Event is active', 'required');

        if (empty($_FILES['fl_event_image']['name'])) {
        	$this->form_validation->set_rules('fl_event_image', 'Event image', 'required');
        }

        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/event/event-add');
		}
		else
		{
			
			$this->event_model->insert();
			$e_id = $this->db->insert_id();
			$file_info = $this->file_upload_m('fl_event_image',$e_id);
			$data_c = array(
				"event_id" => $e_id
			);
			$this->db->insert('config',$data_c);

			if(is_array($file_info))
			{
				$file_name = $file_info['file_name'];
				if($file_name != ''){
					$this->event_model->update_image_f($e_id,$file_name);
				}
				$this->session->set_flashdata('msg','Successfully Update Data !');
			    redirect(site_url('event'));
			}
			else
			{
				$error = $file_info;
				$data['error'] = $error;
				$this->load->view('admin/event/event-add',$data);
			}
			
			
			
			
		}
	}
		
	// update method
	public function update($id)
	{
		$this->event_model->update($id);

		if(!empty($_FILES['fl_event_image']['name']))
		{

			$file_info = $this->file_upload_m('fl_event_image',$id);
			if(is_array($file_info))
			{
				$file_name = $file_info['file_name'];
				if($file_name != ''){
					$this->event_model->update_image_f($id,$file_name);
				}
				$this->session->set_flashdata('msg','Successfully Update Data !');
			    redirect(site_url('event'));
			}
			else
			{
				$error = $file_info;
				$data['error'] = $error;
				$this->load->view('admin/event/event-add',$data);
			}
		}
		else
		{
			redirect(site_url('event'));
		}
		
		
		
		
		
	}
		
	// edit method
	public function edit($id)
	{
		$data['recored'] = $this->event_model->findOne($id);
		$this->load->view('admin/event/event-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{
		$this->event_model->remove($id);
		$this->session->set_flashdata('msg','Successfully Delete Data !');
		
		redirect(site_url('event'));
	}
		
	public function active_inactive($id,$mode)
	{
		$this->event_model->change_status($id,$mode);
		redirect(site_url('event'));
	}
		
	public function file_upload_m($file_name,$new_name)
    {
        $config['upload_path']          = './file/event/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name'] 			= $new_name;
        $config['overwrite'] 		= TRUE;
        
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($file_name))
        {
            return  $data = $this->upload->display_errors();
		}
		else
		{
			return  $data = $this->upload->data();
		}
        
	}
 } 
 

?>
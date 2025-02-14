<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Config extends MY_Controller  { 
 
		
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
        $this->load->model('config_model');
        $data['objconfig'] = $this->config_model->findOne(1);
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
		$data['recored'] = $this->config_model->findAll();
		$data['message'] = $this->get_msg();
		$this->load->view('admin/config/config-list',$data);
	}

	public function update_profile($id)
	{

		//print_r($_SESSION['my_files']);
		//unset($_SESSION['my_files']);
		//exit;

		$this->db->where('event_id',$id);
		$this->db->delete('person');

		$lenght = count($_POST['txt_p_name']);

		for ($i=0; $i < $lenght; $i++) { 

			if($_FILES['fl_p']['name'][$i] == '')
			{
				$img = $_SESSION['my_files'][$i];
			}
			else
			{
				$img = $_FILES['fl_p']['name'][$i];
			}

			$data = array(
				'p_name' => $_POST['txt_p_name'][$i],
				'event_id' =>$id,
				'p_desc' => $_POST['txt_p_desc'][$i],
				'p_image'=> $img
			);

			$this->db->insert('person', $data);
			//$id = $this->db->insert_id();

		}


			$files = array();

		    if(empty($config))
		    {
		        $config['upload_path'] = './file/person';
		        $config['allowed_types'] = 'gif|jpg|jpeg|jpe|png';
		       
		    }

		        $this->load->library('upload', $config);

		        $files        = $_FILES;
				$file_count    = count($_FILES['fl_p']['name']);
		        // Iterate over the $files array
				for($i = 0; $i < $file_count; $i++)
				{
				    // Overwrite the default $_FILES array with a single file's data
				    // to make the $_FILES array consumable by the upload library
				    if ($files['fl_p']['name'][$i] != '') {
				    	
					    $_FILES['upload_field_name']['name']        = $files['fl_p']['name'][$i];
					    $_FILES['upload_field_name']['type']        = $files['fl_p']['type'][$i];
					    $_FILES['upload_field_name']['tmp_name']    = $files['fl_p']['tmp_name'][$i];
					    $_FILES['upload_field_name']['error']        = $files['fl_p']['error'][$i];
					    $_FILES['upload_field_name']['size']        = $files['fl_p']['size'][$i];

					    if ( ! $this->upload->do_upload('upload_field_name'))
				        {
				            $data = $this->upload->display_errors();
				            $this->session->set_flashdata('error','person Image Please <br />'.$data);
						}
						else
						{
							$data = $this->upload->data();
						}
					}
				    
				} 
			unset($_SESSION['my_files']);

		redirect('config/edit/'.$id);
	}


	public function update_photos($id)
	{
		$this->db->where('event_id',$id);
		$this->db->delete('photos');

		$lenght = count($_POST['txt_pp_name']);

		for ($i=0; $i < $lenght; $i++) { 

			if($_FILES['fl_pp']['name'][$i] == '')
			{
				$img = $_SESSION['my_photos'][$i];
			}
			else
			{
				$img = $_FILES['fl_pp']['name'][$i];
			}

			$data = array(
				'pp_name' => $_POST['txt_pp_name'][$i],
				'event_id' =>$id,
				'pp_image'=> $img
			);

			$this->db->insert('photos', $data);
		}


			$files = array();

		    if(empty($config))
		    {
		        $config['upload_path'] = './file/photos';
		        $config['allowed_types'] = 'gif|jpg|jpeg|jpe|png';
		       
		    }

		        $this->load->library('upload', $config);

		        $files        = $_FILES;
				$file_count    = count($_FILES['fl_pp']['name']);
		        // Iterate over the $files array
				for($i = 0; $i < $file_count; $i++)
				{
				    // Overwrite the default $_FILES array with a single file's data
				    // to make the $_FILES array consumable by the upload library
				    if ($files['fl_pp']['name'][$i] != '') {
				    	
					    $_FILES['upload_field_name']['name']        = $files['fl_pp']['name'][$i];
					    $_FILES['upload_field_name']['type']        = $files['fl_pp']['type'][$i];
					    $_FILES['upload_field_name']['tmp_name']    = $files['fl_pp']['tmp_name'][$i];
					    $_FILES['upload_field_name']['error']       = $files['fl_pp']['error'][$i];
					    $_FILES['upload_field_name']['size']        = $files['fl_pp']['size'][$i];

					    if ( ! $this->upload->do_upload('upload_field_name'))
				        {
				            $data = $this->upload->display_errors();
				            $this->session->set_flashdata('error','Photos Image Please <br />'.$data);
						}
						else
						{
							$data = $this->upload->data();
						}
					}
				    
				} 
			unset($_SESSION['my_photos']);

		redirect('config/edit/'.$id);
	}

	// update method
	public function update($id) 
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('txt_mobile', 'Mobile', 'required');
		$this->form_validation->set_rules('txt_url', 'Website Url', 'required');
		$this->form_validation->set_rules('txt_hours', 'Open Hours', 'required');


		if ($this->form_validation->run() === FALSE)
        {
        	redirect('config/edit');
        }
        else
        {
        	$this->config_model->update($id);
			$this->session->set_flashdata('msg','Successfully Update Data !');

			if(!empty($_FILES['fl_logo']['name']))
			{
				$file_info =$this->file_upload_l('fl_logo',$id);
				if(is_array($file_info))
				{
					$file_name = $file_info['file_name'];
					if($file_name != ''){
						$this->config_model->update_image_l($id,$file_name);
					}
				}
				else
				{
					$this->session->set_flashdata('error','Logo Image Please <br />'.$file_info);
				}
			}

			if(!empty($_FILES['fl_header']['name']))
			{
				$file_info =$this->file_upload_h('fl_header',$id);
				if(is_array($file_info))
				{
					$file_name = $file_info['file_name'];
					if($file_name != ''){
						$this->config_model->update_image_h($id,$file_name);
					}
				}
				else
				{
					$this->session->set_flashdata('error','Header Image Please <br />'.$file_info);
				}
			}

			
			redirect('config/edit/'.$id);
        }


		
		
	}
		
	// edit method
	public function edit($id)
	{
		$data['objconfig'] = $this->config_model->findOne($id);
		$data['person'] = $this->config_model->findper($id);
		$data['photos'] = $this->db->where('event_id',$id)->get('photos')->result();
		$data['message'] = $this->get_msg();
		$this->load->view('admin/config/config-edit',$data);
	}
	
	public function file_upload_l($file_name,$new_name)
    {
        $config['upload_path']          = './file/config/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['file_name'] 			= $new_name;
        $config['overwrite'] 	    	= TRUE;
        $config['max_width'] 			= '140';
        $config['max_height']  			= '140';
        $config['min_width'] 			= '140';
        $config['min_height']  			= '140';
        
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

	public function file_upload_h($file_name,$new_name)
    {
        $config['upload_path']          = './file/header/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['file_name'] 			= $new_name;
        $config['overwrite'] 		= TRUE;
        $config['max_width'] 			= '1200';
        $config['max_height']  			= '512';
        $config['min_width'] 			= '1200';
        $config['min_height']  			= '512';
        
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

	public function file_upload_p($file_name,$new_name)
    {
        $config['upload_path']          = './file/person/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['file_name'] 			= $new_name;
        $config['overwrite'] 		= TRUE;
        $config['width']                =  1200;
        $config['height']               =  500;
        
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
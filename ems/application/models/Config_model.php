<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Config_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		return $this->db->join('event','event.event_id = config.event_id')->get('config')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('co_id',$id);
		return $this->db->get('config')->row_array();
	}
	
	public function findper($id)
	{
		return $this->db->where('event_id',$id)->get('person')->result();
	}

	public function change_status($id,$mode)
	{
		$data=array('customer_is_active'=>$mode);
		$this->db->where('config_id',$id);
		$this->db->update('config',$data);
	}
		
		
	public function update($id)
	{
		if($this->input->post('chkdelete_logo') == 'yes')
		{
			$data=array('co_logo'=>'');
			$this->db->where('co_id',$id);
			$this->db->update('config',$data);
		}
		 
		if($this->input->post('chkdelete_image') == 'yes')
		{
			$data=array('co_image'=>'');
			$this->db->where('co_id',$id);
			$this->db->update('config',$data);
		}
		

		$data = array(

		'co_mobile' => $this->input->post('txt_mobile'),
		'co_website' => $this->input->post('txt_url'),
		'co_direction' => $this->input->post('txt_direction'),
		'co_open_hours' => $this->input->post('txt_hours'),
		'co_about' => $this->input->post('txt_about'),
		'co_general' => $this->input->post('txt_general'),
		'fb_link' => $this->input->post('txt_fb'),
		'gg_link' => $this->input->post('txt_gg'),
		'tw_link' => $this->input->post('txt_tw'),
		'meta_title' => $this->input->post('txt_meta_title'),
		'meta_keyword' => $this->input->post('txt_meta_keyword'),
		'meta_desc' => $this->input->post('txt_meta_desc'),

		);
        
        
            $this->db->where('co_id', $id);
            return $this->db->update('config', $data);
        
	}
	
	public function update_image_l($id,$file_name)
	{
		$data=array('co_logo'=>$file_name);
		$this->db->where('co_id',$id);
		$this->db->update('config',$data);
	}

	public function update_image_h($id,$file_name)
	{
		$data=array('co_image'=>$file_name);
		$this->db->where('co_id',$id);
		$this->db->update('config',$data);
	}

	public function update_image_p($id,$file_name)
	{
		$data=array('p_image'=>$file_name);
		$this->db->where('p_id',$id);
		$this->db->update('person',$data);
	}

	
 } 
 

?>
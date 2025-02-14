<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Event_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		return $this->db->get('event')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('event_id',$id);
		return $this->db->get('event')->row_array();
	}
		
	public function change_status($id,$mode)
	{
		$data=array('event_is_active'=>$mode);
		$this->db->where('event_id',$id);
		$this->db->update('event',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'event_name' => $this->input->post('txt_event_name'),
		'event_add' => $this->input->post('txt_event_add'),
		'event_date' => date('Y-m-d',strtotime($this->input->post('txt_event_date'))),
		'event_person' => $this->input->post('txt_event_person'),
		'event_is_active' => $this->input->post('txt_event_is_active'),

        );
        
        if ($id == 0) {
            return $this->db->insert('event', $data);
        } else {
            $this->db->where('event_id', $id);
            return $this->db->update('event', $data);
        }
	}
		
	public function update_image_f($id,$file_name)
	{
		$data=array('event_image'=>$file_name);
		$this->db->where('event_id',$id);
		$this->db->update('event',$data);
	}
		
	public function update($id)
	{
		if($this->input->post('chkdelete_image') == 'yes')
		{
			$data=array('event_image'=>'');
			$this->db->where('event_id',$id);
			$this->db->update('event',$data);
		}
		
		$data = array(

		'event_name' => $this->input->post('txt_event_name'),
		'event_add' => $this->input->post('txt_event_add'),
		'event_date' => date('Y-m-d',strtotime($this->input->post('txt_event_date'))),
		'event_person' => $this->input->post('txt_event_person'),
		'event_is_active' => $this->input->post('txt_event_is_active'),

        );
        
        if ($id == 0) {
            return $this->db->insert('event', $data);
        } else {
            $this->db->where('event_id', $id);
            return $this->db->update('event', $data);
        }
	}
		
	public function remove($ids)
	{
		$this->db->where('event_id',$ids);
		$this->db->delete('event');
	}
 } 
 

?>
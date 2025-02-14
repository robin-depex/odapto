<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Report_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		$this->db->select('booking_date'); 
   		$this->db->group_by('booking_date');
		$this->db->join('customer', 'customer.customer_id = booking.user_id');
		return $this->db->get('booking')->result();

	}
		
	public function findOne($id)
	{
		$this->db->where('booking_id',$id);
		$this->db->join('customer', 'customer.customer_id = booking.user_id');
		return $this->db->get('booking')->result();
	}
		
	
 } 
 

?>
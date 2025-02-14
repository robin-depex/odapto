<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Calendar_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function get_events($start, $end)
	{
	    return $this->db->join('customer', 'customer.customer_id = booking.user_id')->join('event', 'event.event_id = booking.event_id')->join('avai_date', 'avai_date.event_id = booking.event_id')->get("booking");
	}

	public function get_event($id)
	{
	    return $this->db->where("booking_id", $id)->get("booking");
	}

	public function update_event($id, $data)
	{
	    $this->db->where("booking_id", $id)->update("booking", $data);
	}

	public function delete_event($id)
	{
	    $this->db->where("booking_id", $id)->delete("booking");
	}
	
	public function add_event($data)
	{
		$this->db->insert('booking', $data);
	}

	
} 
 

?>
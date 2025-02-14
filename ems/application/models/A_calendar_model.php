<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class A_calendar_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function get_events($start, $end)
	{
	    return $this->db->where("ava_start_time >=", $start)->where("ava_end_time <=", $end)->get("avai_date");
	}

	public function get_event($id)
	{
	    return $this->db->where("ava_id", $id)->get("avai_date");
	}

	public function update_event($id, $data)
	{
	    $this->db->where("ava_id", $id)->update("avai_date", $data);
	}

	public function delete_event($id)
	{
	    $this->db->where("ava_id", $id)->delete("avai_date");
	}
	
	public function add_event($data)
	{
		$this->db->insert('avai_date', $data);
	}

	
} 
 

?>
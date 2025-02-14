<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class A_calendar extends MY_Controller  { 
 
		 
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
        $this->load->model('a_calendar_model');
    }
 		
	// index method
	public function index()
	{
		//$data['recored'] = $this->a_calendar_model->findAll();
		$data['message'] = $this->get_msg();
		$this->load->view('admin/a_calendar/calendar-list',$data);
	}
 	
 	public function all_event($id = '')
 	{
 		
 		$data = $this->db->get('event')->result();
 		$return = '';
 		$chk = '';
 		foreach ($data as $value) {
 			if($value->event_id == $id)
 			{
 				$chk = 'selected';
 			}
 			$return .= '<option value="'.$value->event_id.'" '.$chk.'>'.$value->event_name.'</option>';
 		}
 		echo $return;
 	}

 	public function add_event() 
	{
	    /* Our calendar data */ 
	    
		$start_date = $this->input->post("start_date", TRUE);
	    $end_date = $this->input->post("end_date", TRUE);
	    $meeting_time = $this->input->post("time_duration", TRUE);
	    
	    $start_date =  date ("Y-m-d H:i:s",strtotime($start_date));
	    $end_date =  date ("Y-m-d H:i:s",strtotime($end_date));
	    
	    $date = date("Y-m-d",strtotime($start_date));


	    $this->a_calendar_model->add_event(array(
	       "event_id" => $this->input->post("event_id"),
	       "ava_start_time" => $start_date,
	       "ava_end_time" => $end_date,
	       )
	    );

	    redirect(site_url("a_calendar"));
	}
		
	 public function get_events()
	 {
	     // Our Start and End Dates
	    $start = $this->input->get("start");
	    $end = $this->input->get("end");

	     $startdt = new DateTime('now'); // setup a local datetime
	     $startdt->setTimestamp($start); // Set the date based on timestamp
	     $start_format = $startdt->format('Y-m-d H:i:s');

	     $enddt = new DateTime('now'); // setup a local datetime
	     $enddt->setTimestamp($end); // Set the date based on timestamp
	     $end_format = $enddt->format('Y-m-d H:i:s');


	     $events = $this->a_calendar_model->get_events($start_format, $end_format);

	     $data_events = array();

	     foreach($events->result() as $r) {

	         $data_events[] = array(
	             "id" => $r->ava_id,
	             "event_id" => $r->event_id,
	             "start" => $r->ava_start_time,
	             "end" => $r->ava_end_time,
	             "allDay"=> false
	         );
	     }

	     echo json_encode(array("events" => $data_events));
	     exit();
	 }


	 public function edit_event()
     {
          $eventid = intval($this->input->post("avi_id"));
          $event = $this->a_calendar_model->get_event($eventid);
          if($event->num_rows() == 0) {
               echo"Invalid Event";
             //  exit();
          }

          $event->row();

          /* Our calendar data */
        
		$start_date = $this->input->post("start_date", TRUE);
	    $end_date = $this->input->post("end_date", TRUE);
	   

		$delete = intval($this->input->post("delete"));

          if(!$delete) {

            $start_date =  date ("Y-m-d H:i:s",strtotime($start_date));
	    	$end_date =  date ("Y-m-d H:i:s",strtotime($end_date));

               $this->a_calendar_model->update_event($eventid, array(
                   "event_id" => $this->input->post("event_id"),
			       "ava_start_time" => $start_date,
			       "ava_end_time" => $end_date,
                    )
               );

          } else {
               $this->a_calendar_model->delete_event($eventid);
          }

          redirect(site_url("a_calendar"));
     }

 } 
 

?>
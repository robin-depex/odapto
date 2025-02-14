<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends MY_Controller  { 
 
		 
	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->library('email');
        $this->load->library('ciqrcode');
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
        $this->load->model('calendar_model');
    }
 		
	// index method
	public function index()
	{
		$data['message'] = $this->get_msg();
		$this->load->view('admin/calendar/calendar-list',$data);
	}
 	
 	public function get_services($id)
 	{
 		$data = $this->db->where("services_is_active", 'yes')->get("services")->result();
 		$return = '';
 		$seleted = '';
 		foreach ($data as $value) {
 			if($value->services_id == $id)
 			{
 				$seleted = 'selected';
 			}

 			$return .= '<option value="'.$value->services_id.'" '.$seleted.'>'.$value->services_name.'</option>';
 		}
 		echo  $return;
 	}

 	public function get_customer($id)
 	{
 		$data = $this->db->where("customer_is_active", 'yes')->get("customer")->result();
 		$return = '';
 		$seleted = '';
 		foreach ($data as $value) {

 			if($value->customer_id == $id)
 			{
 				$seleted = 'selected';
 			}

 			$return .= '<option value="'.$value->customer_id.'" '.$seleted.'>'.$value->customer_first_name.'</option>';
 		}
 		echo  $return;
 	}

 	public function get_event($id = '')
 	{

 		$this->db->join('avai_date','avai_date.event_id = event.event_id');
 		$this->db->where("event_is_active", 'yes');
 		$this->db->group_by('avai_date.event_id');
 		$data = $this->db->get("event")->result();
 		$return = '';
 		$seleted = '';
 		foreach ($data as $value) {

 			if($value->event_id == $id)
 			{
 				$seleted = 'selected';
 			}

 			$return .= '<option value="'.$value->event_id.'" '.$seleted.'>'.$value->event_name.'</option>';
 		}
 		echo  $return;
 	}

 	public function get_person($id = '')
 	{
 		$data = $this->db->where("event_is_active", 'yes')->where('event_id',$id)->get("event")->row_array();

 		$b_s = $this->db->where('event_id',$id)->select_sum('person')->get('booking')->row_array();
 		$lenght = $data['event_person'] - $b_s['person'];

 		$return = '';
 		$seleted = ''; 
 		
 		for ($i=1; $i <= $lenght; $i++) { 
 			$return .= '<option value="'.$i.'">'.$i.'</option>';
 		}
 		echo  $return;
 	}
 
 	public function add_event() 
	{
	    /* Our calendar data */
	    $user_name = $this->input->post('user_name',TRUE);
	    $event_id = $this->input->post('event_id',TRUE);
	    
	    $person = $this->input->post('person',TRUE);
	    
	    /*$this->calendar_model->add_event(array(
	       "user_id" => $user_name,
	       "event_id" =>$event_id,
	       "person" =>$person,
	       "booking_date" => date('Y-m-d')
	       )
	    );*/


	    $this->db->where('customer_id',$user_name);
	    $c_data = $this->db->get('customer');

	    if ($c_data->num_rows()) {
	    	$cust = $c_data->row_array();
			$user_id = $cust['customer_id'];	    	
	        $email = $cust['customer_email'];
	    } 
		$data_b = array(
			'user_id'=>$user_id,
			'event_id'=>$event_id,
			'person' =>$person,
			'booking_date'=> date('Y-m-d')
		);

		$this->db->insert('booking',$data_b);
		$book_id = $this->db->insert_id();
		
		$my_mail = $this->db->get('host')->row_array();

		//SMTP & mail configuration
			$config = Array(
				  'protocol' => 'smtp',
				  'smtp_host' => $my_mail['host_name'],
				  'smtp_port' => 25,
				  'smtp_user' => $my_mail['host_user_name'], // change it to yours
				  'smtp_pass' => $my_mail['host_user_pass'], // change it to yours
				  'mailtype' => 'html',
				  'charset' => 'iso-8859-1',
				  'wordwrap' => TRUE
			);

			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			//$this->email->set_newline("\r\n");
			
			$this->db->where('booking_id',$book_id);
			$this->db->join('customer', 'customer.customer_id = booking.user_id','LEFT');
			$this->db->join('event', 'event.event_id = booking.event_id','LEFT');

			$data['order'] = $this->db->get('booking')->result();

			// QR CODE
			$params['data'] = 'Event Name :'.$data['order'][0]->event_name .' Date : '.date('d-m-Y',strtotime($data['order'][0]->event_date)).' Person Name : '.$data['order'][0]->customer_first_name.' E-Mail :'.$data['order'][0]->customer_email .' Seats :'.$data['order'][0]->person.' Venue : '.$data['order'][0]->event_add;
			$params['level'] = 'H';
			$params['size'] = 10;
			$params['savename'] = FCPATH.'/file/qr/'.$book_id.'.png';
			$this->ciqrcode->generate($params);
			// QR CODE

			//Email content
			$htmlContent = $this->load->view('admin/email/test',$data,TRUE);
			
			$this->email->to($email);
			$this->email->from($my_mail['host_user_name'],'EeventSYS');
			$this->email->subject($data['order'][0]->event_name);
			$this->email->message($htmlContent);
			
			$this->email->send();
			
			$this->email->to($my_mail['host_user_name']);
			$this->email->from($my_mail['host_user_name'],'EeventSYS');
			$this->email->subject($data['order'][0]->event_name);
			$this->email->message($htmlContent);
			
			$this->email->send();


	    redirect(site_url("calendar"));
	}
		
	 public function get_events()
	 {

	     $events = $this->calendar_model->get_events();

	     $data_events = array();

	     foreach($events->result() as $r) {

	         $data_events[] = array(
	             "id" => $r->booking_id,
	             "event_id" => $r->event_id,
	             "user_id" => $r->user_id,
	             "title" => $r->event_name,
	             "start" => $r->ava_start_time,
	             "allDay"=> false
	         );
	     }

	     echo json_encode(array("events" => $data_events));
	     exit();
	 }


	 public function edit_event()
     {
          $eventid = intval($this->input->post("eventid"));
          $event = $this->calendar_model->get_event($eventid);
          if($event->num_rows() == 0) {
               echo"Invalid Event";
             //  exit();
          }

          $event->row();

          /* Our calendar data */
        $user_name = $this->input->post('user_name',TRUE);
	    $services = $this->input->post('services',TRUE);
	    $event_name = $this->input->post('event_name',TRUE);
	    $event_description = $this->input->post('event_description',TRUE);

		$start_date = $this->input->post("start_date", TRUE);
	    $end_date = $this->input->post("end_date", TRUE);
        $delete = intval($this->input->post("delete"));

          if(!$delete) {

            $start_date =  date ("Y-m-d H:i:s",strtotime($start_date));
	    	$end_date =  date ("Y-m-d H:i:s",strtotime($end_date));

               $this->calendar_model->update_event($eventid, array(
                   "user_id" => $user_name,
			       "service_id" =>$services,
			       "booking_title" => $event_name,
			       "booking_desc" => $event_description,
			       "booking_start_time" => $start_date,
			       "booking_end_time" => $end_date,
			       "booking_date" => date('Y-m-d')
                    )
               );

          } else {
               $this->calendar_model->delete_event($eventid);
          }

          redirect(site_url("calendar"));
     }

 } 
 

?>
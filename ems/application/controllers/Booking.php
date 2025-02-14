<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MY_Controller  { 
 
		 
	public function __construct()
    { 
        parent::__construct();
        $this->load->library('session');
		$this->load->library('Pdf_Library');
		$this->load->library('email');
		$this->load->library('ciqrcode');
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
 		
	// index method
	public function index()
	{
		$data['message'] = $this->get_msg();
		$this->load->view('admin/booking/list',$data);
	}
 	
 	public function get_event_name()
 	{
 		$data = $this->db->where('event_is_active','yes')->get('event')->result();
 		$return = '';
 		foreach ($data as $value) {
 			$return .= '<option value="'.$value->event_id.'">'.$value->event_name.'</option>';
 		}
 		echo $return;
 	}

 	public function get_booking($id = 0)
 	{
 		//$data = $this->db->join('customer','customer.customer_id = booking.user_id','LEFT')->join('event','event.event_id = booking.event_id','LEFT')->where('booking.event_id',$id)->get('booking')->result();

 		$this->db->select('booking.booking_id,booking.person,customer.customer_first_name,customer.customer_email,customer.customer_phone,event.event_name');    
		$this->db->where('booking.event_id',$id);
		$this->db->from('booking');
		$this->db->join('customer', 'booking.user_id = customer.customer_id');
		$this->db->join('event', 'booking.event_id = event.event_id');

		$data = $this->db->get()->result();

		$output = array(
		"sEcho" => intval(1),
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData" => array()
		);

		foreach ($data as $value) {
			$row = array();
			$row[] = $value->customer_first_name;
			$row[] = $value->customer_email;
			$row[] = $value->customer_phone;
			$row[] = $value->person;
			$row[] = $value->event_name;
			$row[] = '<img src="'.base_url().'file/qr/'.$value->booking_id.'.png" height="75" width="75">';
			$output['aaData'][] = $row;
		}
		echo json_encode( $output );
 		
 	}


 	public function create()
	{
		$this->load->library('form_validation');


		$this->form_validation->set_rules('event', 'Event', 'required');
		$this->form_validation->set_rules('person', 'Person', 'required');
		$this->form_validation->set_rules('user_email', 'Valid email', 'valid_email');
		$this->form_validation->set_rules('user_phone', 'Phone', 'required');
		$this->form_validation->set_rules('user_name', 'Name', 'required');
		
        if ($this->form_validation->run() === FALSE)
        {
        	$data['message'] = $this->get_msg();
			$this->load->view('admin/booking/add',$data);
		}
		else
		{

			$event = $this->input->post('event');
		    $person = $this->input->post('person');
			$phone = $this->input->post('user_phone');
			$email = $this->input->post('user_email');
			$user_name = $this->input->post('user_name');

			
		    $this->db->where('customer_email',$email);
		    $c_data = $this->db->get('customer');

		    if ($c_data->num_rows()) {
		    	$cust = $c_data->row_array();
				$user_id = $cust['customer_id'];	    	
		        
		    } else {
		        
		    	$data = array(
				'customer_first_name'=>$user_name,
				'customer_email'=>$email,
				'customer_phone'=>$phone
				);

				$this->db->insert('customer',$data);
				$user_id = $this->db->insert_id();

		    }

			
			
			$data_b = array(
				'user_id'=>$user_id,
				'event_id'=>$event,
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

			$this->session->set_flashdata('msg','Successfully Insert Data !');
			redirect(site_url('booking'));
		}
	}


	public function get_event($id = 0)
 	{
 		$data = $this->db->where("event_is_active", 'yes')->where('event_date >=',date('Y-m-d'))->get("event")->result();
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
 } 
 

?>
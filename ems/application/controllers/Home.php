<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('ciqrcode');
        $this->load->database(); 
    }


	public function index()
	{
		$this->load->view('home');
	}

	public function add_event_client()
	{
		
	    $event = $this->input->post('event');
	    $person = $this->input->post('person');
		$phone = $this->input->post('txt_phone');
		$email = $this->input->post('txt_email');
		$user_name = $this->input->post('txt_name');

		
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


		redirect(site_url("front/index/".$event));

	}


	public function get_event_client()
	{
		//$data = $this->db->get('avai_date')->result();
		$s_date = $this->input->get('s_date');
		$date_o = date ("Y-m-d",strtotime($s_date));
		//$date_m = $date;
		$this->db->where('ava_date',$date_o);
		$data = $this->db->get('avai_date')->result();

		$e_hours = array();
		$steping = 1;
		$e_hours[]= '';

		foreach ($data as $value) {
			$steping = $value->ava_meeting_time;
			$start_time = date ("H:i",strtotime($value->ava_start_time));
			$end_time = date ("H:i",strtotime($value->ava_end_time));

			$period = new DatePeriod(
			    new DateTime($start_time),
			    new DateInterval('PT1H'),
			    new DateTime($end_time)
			);
			foreach ($period as $date) {
			    $e_hours[] = ltrim($date->format("H"),'0');
			}
		}
		
		$this->db->select('booking_start_time');
		$this->db->where('booking_date',$date_o);
		$booked = $this->db->get('booking')->result();

		foreach ($booked as $value) {
			$hh = ltrim(date("H",strtotime($value->booking_start_time)),'0');

			if(($key = array_search($hh, $e_hours)) !== false) {
				unset($e_hours[$key]);
			}
		}

		$e_h = implode($e_hours,',');
		echo $steping.'|'.$e_h;

	}

	public function get_event($id)
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

 	public function get_event_name($id)
 	{
 		$data = $this->db->where('event_id',$id)->get('event')->row_array();

 		echo $data['event_name'];
 	}
}

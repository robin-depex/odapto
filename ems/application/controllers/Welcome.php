<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

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
        $this->load->database(); 
        if (!$this->session->userdata('logged_in'))
	    { 
	        redirect('login');
	    }
		$this->load->helper('form');
        $this->load->model('login_model');
    }


	public function index()
	{
		$data['message'] = $this->get_msg();

		$c = $this->db->get('customer')->result();
		$data['customer'] = count($c);
		$e = $this->db->get('event')->result();
		$data['event'] = count($e);

		$u_e = $this->db->where('event_date >',date('Y-m-d'))->get('event')->result();
		$data['upcoming_eve'] = count($u_e);

		$o_e = $this->db->where('event_date <',date('Y-m-d'))->get('event')->result();
		$data['outgoing_eve'] = count($o_e);

		

		$ch = array();
		for ($i=0; $i < 8 ; $i++) { 

			$date1=date('Y-m-d',strtotime(date("Y-m-d")."".$i." day"));
			
			$this->db->where('event_date =', $date1);
			$t = $this->db->get('event')->result();
			$t = count($t);

			$abc = '[gd('.date('Y').', '.ltrim(date('m'),0).', '.ltrim(date('d',strtotime($date1)),0).'), '.$t.']';

			$ch[] = $abc;
		}

		$data['chart'] = $ch;

		$date1 =date('Y-m-01'); // Month Starting Date
		$date2 =date('Y-m-t'); 

		$this->db->where('booking_date >=', $date1);
		$this->db->where('booking_date <=', $date2);
		$m_a = $this->db->get('booking')->result();
		$data['month'] = count($m_a);

		$date1=date('Y-01-d'); // year Starting Date
		$date2=date('Y-12-d');  // year Ending Date

		$this->db->where('booking_date >=', $date1);
		$this->db->where('booking_date <=', $date2);
		$y_a = $this->db->get('booking')->result();
		$data['year'] = count($y_a);

		$this->db->join('customer', 'customer.customer_id = booking.user_id');
		$this->db->order_by("booking_id", "desc");
		$this->db->limit(7);
		$data['book'] = $this->db->get("booking")->result();


		$date1=date('Y-m-d',strtotime(date("Y-m-d")."6 day"));
		$date2=date('Y-m-d');
		$this->db->where('booking_date <=', $date1);
		$this->db->where('booking_date >=', $date2);
		$this->db->join('customer', 'customer.customer_id = booking.user_id');
		$this->db->order_by("booking_id", "desc");
		$data['book_up'] = $this->db->get("booking")->result();


		$this->db->where('event_date =', date('Y-m-d'));
		$data['today_eve'] = $this->db->get("event")->result();

		$this->load->view('admin/index',$data);
	}

	public function remove_message()
	{
		$id = $this->input->get('m_i');
		$this->db->where('m_id',$id);
		$this->db->delete('message');
	}
}

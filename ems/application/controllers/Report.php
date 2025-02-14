<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Report extends MY_Controller  { 
 
		
	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->library('Pdf_Library');
		$this->load->library('Excel_Library');
		$this->load->database();
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
        $this->load->model('report_model');

    }
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	
	// index method
	public function index()
	{
		$query = $this->db->query("select DISTINCT(b.event_id) , e.event_name,e.event_id FROM ".$this->db->dbprefix('booking')." b INNER JOIN ".$this->db->dbprefix('event')." e ON e.event_id = b.event_id");

		$data['recored'] = $query->result();
		
		$data['message'] = $this->get_msg();
		$this->load->view('admin/report/report',$data);
	}

	// pdf method
	public function pdf()
	{
		$query = $this->db->query("select DISTINCT(b.event_id) , e.event_name,e.event_id FROM ".$this->db->dbprefix('booking')." b LEFT JOIN ".$this->db->dbprefix('event')." e ON e.event_id = b.event_id");

		$data['recored'] = $query->result();
		$this->load->view('admin/report/report_pdf',$data);
	}

	public function booking_list($id = 0,$mode = '',$date1 = '',$date2 = '')
	{

		$data['message'] = $this->get_msg();

		if($mode == 'today')
		{
			$this->db->where('booking_date',date('Y-m-d'));
		}
		else if($mode == 'weekly')
		{
			$date1=date('Y-m-d',strtotime(date("Y-m-d")."-6 day"));
			$date2=date('Y-m-d');
			$this->db->where('booking_date >=', $date1);
			$this->db->where('booking_date <=', $date2);
   		}
   		else if($mode == 'monthly')
   		{
   			$start_date=date('Y-m-01'); // Month Starting Date
			$end_date=date('Y-m-t');  // Month Ending Date

			$this->db->where('booking_date >=', $start_date);
			$this->db->where('booking_date <=', $end_date);
   		}
   		else if($mode == 'yearly')
   		{
   			$start_date=date('Y-01-d'); // year Starting Date
			$end_date=date('Y-12-d');  // year Ending Date

			$this->db->where('booking_date >=', $start_date);
			$this->db->where('booking_date <=', $end_date);
   		}
   		else if($mode == 'search')
   		{
   			$date1 = date("Y-m-d", strtotime($date1));
			$date2 = date("Y-m-d", strtotime($date2));

			$this->db->where('booking_date >=', $date1);
			$this->db->where('booking_date <=', $date2);
   		}

		$this->db->where('booking.event_id',$id);
		$this->db->join('event','event.event_id = booking.event_id');
		$this->db->group_by('booking.booking_date');
		$data['recored'] = $this->db->get('booking')->result();

		$this->load->view('admin/report/report-booking',$data);
	}

	public function pdf_list($id = 0,$mode = '',$date1 = '',$date2 = '')
	{
		if($mode == 'today')
		{
			$this->db->where('booking_date',date('Y-m-d'));
		}
		else if($mode == 'weekly')
		{
			$date1=date('Y-m-d',strtotime(date("Y-m-d")."-6 day"));
			$date2=date('Y-m-d');
			$this->db->where('booking_date >=', $date1);
			$this->db->where('booking_date <=', $date2);
   		}
   		else if($mode == 'monthly')
   		{
   			$start_date=date('Y-m-01'); // Month Starting Date
			$end_date=date('Y-m-t');  // Month Ending Date

			$this->db->where('booking_date >=', $start_date);
			$this->db->where('booking_date <=', $end_date);
   		}
   		else if($mode == 'yearly')
   		{
   			$start_date=date('Y-01-d'); // year Starting Date
			$end_date=date('Y-12-d');  // year Ending Date

			$this->db->where('booking_date >=', $start_date);
			$this->db->where('booking_date <=', $end_date);
   		}
   		else if($mode == 'search')
   		{
   			$date1 = date("Y-m-d", strtotime($date1));
			$date2 = date("Y-m-d", strtotime($date2));

			$this->db->where('booking_date >=', $date1);
			$this->db->where('booking_date <=', $date2);
   		}

		$this->db->where('booking.event_id',$id);
		$this->db->join('event','event.event_id = booking.event_id');
		$this->db->group_by('booking.booking_date');
		$data['recored'] = $this->db->get('booking')->result();	

		$this->load->view('admin/report/report_pdf_list',$data);
	}

	public function get_event_name($id = '')
 	{

 		$data = $this->db->where('event_is_active','yes')->get('event')->result();
 		$return = '';

 		foreach ($data as $value) {
			$chk = '';
 			if ($value->event_id == $id) {
 				$chk = 'selected';
 			}

 			$return .= '<option value="'.$value->event_id.'" '.$chk.'>'.$value->event_name.'</option>';
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

	public function today()
	{
		$this->db->select('booking_date'); 
		$this->db->where('booking_date',date('Y-m-d'));
		$this->db->group_by('booking_date');
		$this->db->join('customer', 'customer.customer_id = booking.user_id');
		$data['recored'] = $this->db->get('booking')->result();
		$this->load->view('admin/report/report',$data);	
	}

	public function weekly()
	{
		$date1=date('Y-m-d',strtotime(date("Y-m-d")."-6 day"));
		$date2=date('Y-m-d');

		$this->db->select('booking_date'); 
		$this->db->where('booking_date >=', $date1);
		$this->db->where('booking_date <=', $date2);
   		$this->db->group_by('booking_date');
		$this->db->join('customer', 'customer.customer_id = booking.user_id');
		$data['recored'] = $this->db->get('booking')->result();
		$this->load->view('admin/report/report',$data);	
	}

	public function monthly()
	{
		$date1 =date('Y-m-01'); // Month Starting Date
		$date2 =date('Y-m-t');  // Month Ending Date

		$this->db->select('booking_date'); 
		$this->db->where('booking_date >=', $date1);
		$this->db->where('booking_date <=', $date2);
   		$this->db->group_by('booking_date');
		$this->db->join('customer', 'customer.customer_id = booking.user_id');
		$data['recored'] = $this->db->get('booking')->result();
		$this->load->view('admin/report/report',$data);	
	}

	public function yearly()
	{
		$date1=date('Y-01-d'); // year Starting Date
		$date2=date('Y-12-d');  // year Ending Date

		$this->db->select('booking_date'); 
		$this->db->where('booking_date >=', $date1);
		$this->db->where('booking_date <=', $date2);
   		$this->db->group_by('booking_date');
		$this->db->join('customer', 'customer.customer_id = booking.user_id');
		$data['recored'] = $this->db->get('booking')->result();
		
		$this->load->view('admin/report/report',$data);	
	}

	public function search($datefrom = '',$dateto = '')
	{

		$date1 = date("Y-m-d", strtotime($datefrom));
		$date2 = date("Y-m-d", strtotime($dateto));

		$this->db->select('booking_date'); 
		$this->db->where('booking_date >=', $date1);
		$this->db->where('booking_date <=', $date2);
   		$this->db->group_by('booking_date');
		$this->db->join('customer', 'customer.customer_id = booking.user_id');
		$data['recored'] = $this->db->get('booking')->result();
		$this->load->view('admin/report/report',$data);	
	}
 	

 	

	public function get_total_order($id,$date = '')
	{
		if($date == '')
		{
			$query = $this->db->query("SELECT sum(person) as total_order FROM ".$this->db->dbprefix('booking')." WHERE event_id = '".$id."'");
		}
		else
		{
			$query = $this->db->query("SELECT sum(person) as total_order FROM ".$this->db->dbprefix('booking')." WHERE event_id = '".$id."' AND booking_date = '".$date."'");
		}
		
		$data =  $query->row_array();
		return $data['total_order'];
	}

	public function get_all_order($id,$date = '')
	{
		if ($date != '') {
			$this->db->where('booking.booking_date',$date);
		}
		$this->db->where('booking.event_id',$id);
		$this->db->join('customer','customer.customer_id = booking.user_id');
		$data = $this->db->get('booking')->result();
		
		return $data;
	}

	

	public function order_info($id)
	{
		$this->db->join('customer','customer.customer_id = booking.user_id');
		$this->db->join('event','event.event_id = booking.event_id');
		$this->db->where('booking.booking_id',$id);
		$data['order'] = $this->db->get('booking')->result();
		$this->load->view('admin/report/order_info',$data);
	}

	
	
 		
	// excel method
	public function excel()
	{
		$data['recored'] = $this->report_model->findAll();
		$this->load->view('admin/report/report_excel',$data);
	}
	
	
 } 
 

?>
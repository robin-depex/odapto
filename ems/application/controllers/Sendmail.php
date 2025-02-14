<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* send mail example
	*/
	class Sendmail extends MY_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			//Load email library
			$this->load->library('email');
		}



		public function index()
		{
			//SMTP & mail configuration
			  $config = Array(
				  'protocol' => 'smtp',
				  'smtp_host' => 'mail.rudleobulksms.in',
				  'smtp_port' => 465,
				  'smtp_user' => 'test@rudleobulksms.in', // change it to yours
				  'smtp_pass' => 'test@123', // change it to yours
				  'mailtype' => 'html',
				  'charset' => 'iso-8859-1',
				  'wordwrap' => TRUE
			);

			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			
			$this->db->where('booking_id',7);
			$this->db->join('customer', 'customer.customer_id = booking.user_id');
			$data['order'] = $this->db->get('booking')->result();
			//Email content
			$htmlContent = $this->load->view('admin/report/order_info',$data,TRUE);
			

			$this->email->to('mehulthummar@gmail.com');
			$this->email->from('mehulthummar@gmail.com','MyWebsite');
			$this->email->subject('How to send email via SMTP server in CodeIgniter');
			$this->email->message($htmlContent);

			if($this->email->send())
		    {
		      echo 'Email sent.';
		    }
		    else
		    {
		     show_error($this->email->print_debugger());
		    }

		}
	}
?>
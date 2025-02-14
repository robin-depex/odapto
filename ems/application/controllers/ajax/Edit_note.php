<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// add customer
class Edit_note extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){

		$id = $_GET['book_id'];
	    $note = $this->input->get('note');
	    
    if($id != '')
		{
			
      $data = array(
        "booking_note" => $note,
      );

      $this->db->where('booking_id',$id);
      $this->db->update('booking',$data);

		}
		else
		{
			echo "Some Process Error !!";
		}
	}

}
?>
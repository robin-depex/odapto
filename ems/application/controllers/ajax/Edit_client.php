<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// add customer
class Edit_client extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){

		$id = $_GET['user_id'];
    $name = $this->input->get('name');
    $phone = $this->input->get('phone');
		$email = $this->input->get('email');

    if($id != '')
		{
			
      $data = array(
        "customer_first_name" => $name,
        "customer_phone" => $phone,
        "customer_email" => $email
      );

      $this->db->where('customer_id',$id);
      $this->db->update('customer',$data);

		}
		else
		{
			echo "Some Process Error !!";
		}
	}

}
?>
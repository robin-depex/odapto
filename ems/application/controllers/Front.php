<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

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
        $this->load->database();
    }


	public function index($id = 1)
	{
		$data['recored'] = $this->db->where('config.event_id',$id)->join('event','event.event_id = config.event_id')->get('config')->row_array(); 

		$data['person'] = $this->db->where('event_id',$data['recored']['co_id'])->get('person')->result(); 
		$data['photos'] = $this->db->where('event_id',$data['recored']['co_id'])->get('photos')->result(); 
		$this->load->view('index',$data);
	}

	public function add_msg()
	{
		$data = array(
			'm_message'=>$this->input->get('msg')
		);
		$this->db->insert('message',$data);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// add customer
class Getclientedit extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){

		$id = $_GET['id'];
		$now =date('Y-m-d H:i:s');
		$past_appo = '';
		$come_appo = '';
    $client_note = '';
		$total_upcoming = 0;
		$total_past = 0;
		if($id != '')
		{
			$this->db->where('booking_id',$id);
			$this->db->join('customer','customer.customer_id = booking.user_id');
			$data = $this->db->get("booking")->result();

			foreach ($data as $value) {
				
				$datetime1 = strtotime($value->booking_start_time);
				$datetime2 = strtotime($value->booking_end_time);
				$interval  = abs($datetime2 - $datetime1);
				$minutes   = round($interval / 60);
				$minutes   = $minutes.' Min'; 

        $client_note = $value->booking_note;

				$name_info = '
				<!-- View Appo -->
                        <div class="col-md-12">
                          <input type="text" id="e_edit_name" class="form-control" value="'.$value->customer_first_name.'" />
                        </div>
                        <br /><br />
                        <div class=" col-md-3"> 
                          <label>Phone</label>
                        </div>
                        <div class=" col-md-9" >
                          <input type="text" id="e_edit_phone" class="form-control" value="'.$value->customer_phone.'" />
                        </div>  
                        <div class=" col-md-3">
                          <label>E-mail</label>
                        </div>
                        <div class=" col-md-9">
                          <input type="text" id="e_edit_email" class="form-control" value="'.$value->customer_email.'" />
                        </div>

                        <br /><br />
                        <button type="button" class="btn btn-success btn-flat" onclick="edit_client(\''.$id.'\',\''.$value->user_id.'\')" >Save </button>
                    <!-- view appo -->';

				if($value->booking_start_time >= $now)
				{
					$total_upcoming++;
					$come_appo .= '
				        <p>
                          <div class="col-md-6">'.strtoupper(date("l F d, Y", strtotime($value->booking_start_time))).'</div>
                          <div class="col-md-6">'.$minutes.'</div>
                        </p>
                        <p>
                          <div class="col-md-6">
                            <h5>
                              <label class="control-label col-md-6">'.date('h:i A',strtotime($value->booking_start_time)).'</label>
                              <label class="control-label col-md-6">'.$value->customer_first_name.'</label>
                            </h5>
                          </div>
                          <div class="col-md-12">
                            <p>CONSULTATION — '.strtoupper($value->customer_first_name).' FROM '.date('h:i A',strtotime($value->booking_start_time)).'-'.date('h:i A',strtotime($value->booking_end_time)).'</p>
                          </div>
                        </p> <br><br>';
				}
				else
				{
					$total_past++;
					$past_appo .= '
				        <p>
                          <div class="col-md-8">'.strtoupper(date("l F d, Y", strtotime($value->booking_start_time))).'</div>
                          <div class="col-md-4">'.$minutes.'</div>
                        </p>
                        <p>
                          <div class="col-md-6">
                            <h5>
                              <label class="control-label col-md-6">'.date('h:i A',strtotime($value->booking_start_time)).'</label>
                              <label class="control-label col-md-6">'.$value->customer_first_name.'</label>
                            </h5>
                          </div>
                          <div class="col-md-12">
                            <p>CONSULTATION — '.strtoupper($value->customer_first_name).' FROM '.date('h:i A',strtotime($value->booking_start_time)).'-'.date('h:i A',strtotime($value->booking_end_time)).'</p>
                          </div>
                        </p> <br><br>';
				}
			}

			echo '
				<div class="x_panel">
                  <div class="x_title">
                     <div class="btn-group  btn-group-sm">
                        <button class="btn btn-default" onclick="hide_data()" type="button"><i class="fa fa-angle-left"></i> Close</button>
                        <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i> Schedual</button>
                        <button class="btn btn-default" onclick="edit_mode('.$id.')" type="button"><i class="fa fa-edit"></i> Edit</button>
                        <button class="btn btn-default" type="button"><i class="fa fa-minus-square"></i> Ban</button>
                        <button class="btn btn-default" type="button"><i class="fa fa-print"></i> Print</button>
                      </div>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                  	<!-- start accordion -->
                    <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                      <div class="panel">
                        <a class="panel-heading" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                          <h4 class="panel-title">User Information</h4>
                        </a>
                        <div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body">
                            '.$name_info.'
                          </div>
                        </div>
                      </div>

                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingTwo1" data-toggle="collapse" data-parent="#accordion1" href="#collapsenote" aria-expanded="false" aria-controls="collapseTwo">
                          <h4 class="panel-title">Note About Client </h4>
                        </a>
                        <div id="collapsenote" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="panel-body">
                            <textarea class="form-control" id="e_edit_note">'.$client_note.'</textarea>
                            <br />
                            <button type="button" class="btn btn-success btn-flat" onclick="add_note(\''.$id.'\')" >Save</button>
                          </div>
                        </div>
                      </div>

                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingTwo1" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo">
                          <h4 class="panel-title">Upcoming Appointments</h4>
                        </a>
                        <div id="collapseTwo1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="panel-body">
                            '.$come_appo.'
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingThree1" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree1" aria-expanded="false" aria-controls="collapseThree">
                          <h4 class="panel-title">Past Appointments</h4>
                        </a>
                        <div id="collapseThree1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                          <div class="panel-body">
                            '.$past_appo.'
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end of accordion -->

                  </div>

                  
                </div>
			';

		}
		else
		{
			echo "Some Process Error !!";
		}
	}

}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// add customer
class Get_print_data extends CI_Controller {

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

				$name_info = '<tr><td height="20"></td></tr>
                          <tr>
                            <td align="left">
                              <h2 >'.$value->customer_first_name.'</h2>
                            </td>
                          </tr>
              
              <tr>
                            <td align="left">
                              <p><b>Phone :</b> '.$value->customer_phone.'</p>
                              <p><b>Email :</b>'.$value->customer_email.'</p>
              </td>
                          </tr>';

				if($value->booking_start_time >= $now)
				{
					$total_upcoming++;
					$come_appo .= '
              <tr><td height="20"></td></tr>
              <tr>
                            <td>
                              <table>
                <tr>
                  <td colspan="2">'.strtoupper(date("l F d, Y", strtotime($value->booking_start_time))).'</td>
                  <td>'.$minutes.'</td>
                </tr>
                <tr>
                  <td>
                    <b>'.date('h:i A',strtotime($value->booking_start_time)).'</b>
                  </td>
                  <td>
                    <b>'.$value->customer_first_name.'</b>
                  </td>
                  <td></td>
                </tr>
                
                <tr>
                  <td colspan="3">
                    <p>CONSULTATION — '.strtoupper($value->customer_first_name).' FROM '.date('h:i A',strtotime($value->booking_start_time)).'-'.date('h:i A',strtotime($value->booking_end_time)).'</p>
                  </td>
                </tr>
                
                </table>
              </td>
              </tr>
              <tr><td height="20"></td></tr>
              ';
				}
				else
				{
					$total_past++;
					$past_appo .= '
				        <tr><td height="20"></td></tr>
              <tr>
                            <td>
                              <table>
                <tr>
                  <td colspan="2">'.strtoupper(date("l F d, Y", strtotime($value->booking_start_time))).'</td>
                  <td>'.$minutes.'</td>
                </tr>
                <tr>
                  <td>
                    <b>'.date('h:i A',strtotime($value->booking_start_time)).'</b>
                  </td>
                  <td>
                    <b>'.$value->customer_first_name.'</b>
                  </td>
                  <td></td>
                </tr>
                
                <tr>
                  <td colspan="3">
                    <p>CONSULTATION — '.strtoupper($value->customer_first_name).' FROM '.date('h:i A',strtotime($value->booking_start_time)).'-'.date('h:i A',strtotime($value->booking_end_time)).'</p>
                  </td>
                </tr>
                
                </table>
              </td>
              </tr>
              <tr><td height="20"></td></tr>';
				}
			}

			echo '
      <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Room Book</title>
      <style type="text/css">
      body {
       padding-top: 0 !important;
       padding-bottom: 0 !important;
       padding-top: 0 !important;
       padding-bottom: 0 !important;
       margin:0 !important;
       width: 100% !important;
       -webkit-text-size-adjust: 100% !important;
       -ms-text-size-adjust: 100% !important;
       -webkit-font-smoothing: antialiased !important;
     }
     .tableContent img {
       border: 0 !important;
       display: block !important;
       outline: none !important;
     }
     a{
      color:#382F2E;
    }

    p, h1{
      color:#382F2E;
      margin:0;
    }
 p{
      text-align:left;
      color:#999999;
      font-size:14px;
      font-weight:normal;
      line-height:19px;
    }

    a.link1{
      color:#382F2E;
    }
    a.link2{
      font-size:16px;
      text-decoration:none;
      color:#ffffff;
    }

    h2{
      text-align:left;
       color:#222222; 
       font-size:19px;
      font-weight:normal;
    }
    div,p,ul,h1{
      margin:0;
    }

    .bgBody{
      background: #ffffff;
    }
    .bgItem{
      background: #ffffff;
    }
  
@media only screen and (max-width:480px)
    
{
    
table[class="MainContainer"], td[class="cell"] 
  {
    width: 100% !important;
    height:auto !important; 
  }
td[class="specbundle"] 
  {
    width:100% !important;
    float:left !important;
    font-size:13px !important;
    line-height:17px !important;
    display:block !important;
    padding-bottom:15px !important;
  }
    
td[class="spechide"] 
  {
    display:none !important;
  }
      img[class="banner"] 
  {
            width: 100% !important;
            height: auto !important;
  }
    td[class="left_pad"] 
  {
      padding-left:15px !important;
      padding-right:15px !important;
  }
     
}
  
@media only screen and (max-width:540px) 

{
    
table[class="MainContainer"], td[class="cell"] 
  {
    width: 100% !important;
    height:auto !important; 
  }
td[class="specbundle"] 
  {
    width:100% !important;
    float:left !important;
    font-size:13px !important;
    line-height:17px !important;
    display:block !important;
    padding-bottom:15px !important;
  }
    
td[class="spechide"] 
  {
    display:none !important;
  }
      img[class="banner"] 
  {
            width: 100% !important;
            height: auto !important;
  }
  .font {
    font-size:18px !important;
    line-height:22px !important;
    
    }
    .font1 {
    font-size:18px !important;
    line-height:22px !important;
    
    }
}

    </style>
<script type="colorScheme" class="swatch active">
{
    "name":"Default",
    "bgBody":"ffffff",
    "link":"382F2E",
    "color":"999999",
    "bgItem":"ffffff",
    "title":"222222"
}
</script>
  </head>
  <body paddingwidth="0" paddingheight="0"   style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">
    <table bgcolor="#ffffff" width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent" align="center"  style="font-family:Helvetica, Arial,serif;">
  <tbody>
    <tr>
      <td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff" class="MainContainer">
  <tbody>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td valign="top" width="40">&nbsp;</td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <!-- =============================== Header ====================================== -->   
    
    <tr>
      <td class="movableContentContainer " valign="top">
        <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td height="35"></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td valign="top" align="center" class="specbundle"><div class="contentEditableContainer contentTextEditable">
                                <div class="contentEditable">
                                  <p style="text-align:right;margin:0;font-family:Georgia,Time,sans-serif;font-size:26px;color:#222222;"><span class="specbundle2"><span class="font1"></span></span></p>
                                </div>
                              </div></td>
      <td valign="top" class="specbundle"><div class="contentEditableContainer contentTextEditable">
                                <div class="contentEditable">
                                  <p style="text-align:left;margin:0;font-family:Georgia,Time,sans-serif;font-size:26px;font-weight:900;"><span class="font">User Information</span> </p>
                                </div>
                              </div></td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
        </div>
        
        <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                         '.$name_info.'
               
              <tr><td height="20"></td></tr>
                          <tr>
                            <td align="left">
                              <p style="text-align:left;margin:0;font-family:Georgia,Time,sans-serif;font-size:26px;font-weight:900;"><span class="font">Note About Client</span> </p>
                            </td>
                          </tr>
              <tr><td height="20"></td></tr>
              <tr>
                            <td align="left">
                              <p>'.$client_note.'</p>
              </td>
                          </tr>
              
              <tr><td height="20"></td></tr>
                          <tr>
                            <td align="left">
                              <p style="text-align:left;margin:0;font-family:Georgia,Time,sans-serif;font-size:26px;font-weight:900;"><span class="font">Upcoming Appointment</span> </p>
                            </td>
                          </tr>
                          '.$come_appo.'
                          <tr><td height="15"> </td></tr>
                           <tr>
                            <td align="left">
                              <p style="text-align:left;margin:0;font-family:Georgia,Time,sans-serif;font-size:26px;font-weight:900;"><span class="font">Past Appointment</span> </p>
                            </td>
                          </tr>
                          '.$past_appo.'

        </table>
        </div>
        
        
        <!-- =============================== footer ====================================== -->
      
      </td>
    </tr>
  </tbody>
</table>
</td>
      
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>



      </body>
      </html>



      ';

		}
		else
		{
			echo "Some Process Error !!";
		}
	}

}
?>
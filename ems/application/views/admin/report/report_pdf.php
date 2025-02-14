<?php
$CI =& get_instance();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rudleo Web Development');
$pdf->SetTitle('Rudleo PDF Report');
$pdf->SetSubject('TCPDF Tutorial');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont("Arial", "B",8);

// add a page
$pdf->AddPage();
$output = '';
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content

	$output .= '
				
				<table width="100%" style="">
						<tr style="color:#000;font-weight:900;">
								<td width="20%" style="">
								<img src="'.base_url().'_template/images/appoint.png" height="80" width="110" />
								</td>
								<td width="80%" style="" colspan="6">
									<h2 style="background-color:#FFF;">Event Management System</h2>
    								<p style="background-color:#DEDEDE;"><br />&nbsp;Mobile :</p>
								</td>
								
							</tr><tr><td colspan="7"><hr /><br /></td></tr>
						<tr align="center" style=" background-color:#DEDEDE;color:#000;font-size:12px;font-weight:900;">
							<td width="7%">No</td>
							<td width="23%">Event Name</td>
							<td width="20%">No of Booking Person</td>
							<td width="50%">Booking List</td>	
						</tr>';
							
							$i = 0;
						foreach ($recored as $_date) {
						$i++;
                           $output .='<tr>
                           	 <td align="center">'.$i.'</td>
                              <td align="center">'. $_date->event_name.'</td>
                              <td align="center">
                               '. $total_order = $CI->get_total_order($_date->event_id)
                                .'
                              </td>';
                              $all_order = $CI->get_all_order($_date->event_id);
                              $output .='<td>';
                              foreach ($all_order as $_order) {
                                   $output .= $_order->customer_first_name .':'. $_order->person.', ';
                                    
                                  }  
                              $output .= '</td>';
                              $output .='</tr>';
                            
					}	
						
				$output .='</table>';
				
			

// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('Report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
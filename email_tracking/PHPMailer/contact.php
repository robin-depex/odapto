<?php 
  include('layout/header.php');

  if(isset($_REQUEST['submit']))
  {
      $name    = $_POST['name'];
      $email   = $_POST['email'];
      $inquiry = nl2br($_POST['message']);
      $date    = date('Y-m-d H:i:s');
      $query = mysql_query("insert into tbl_contact set name='".$name."', email='".$email."', message='".$inquiry."', date='".$date."'");

      $to   = 'kapil.sharma@adarshinfosolutions.com';
      $subject = 'User Conatct Information';
      //$message = 'User Name = "'.$name.'"'.' <br/>'.'User Email = "'.$email.'"'.'<br/>'.'Message = "'.$inquiry.'"';
      
      $message  = '<html><body>';
      $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
      $message .= "<tr style='background: #eee;'><td><strong>User name:</strong> </td><td>" .$name. "</td></tr>";     
      $message .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>" .$email. "</td></tr>";
      $message .= "<tr style='background: #eee;'><td><strong>Message:</strong> </td><td>" .$inquiry. "</td></tr>";
      $message .= "</table>";
      $message .= "</body></html>";

      require_once("PHPMailer/PHPMailerAutoload.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = "ssl"; 
        $mail->IsHTML(true);
        $mail->Host = "plus.smtp.mail.yahoo.com";//smtp.gmail.com
        $mail->Port = 465; // set the SMTP port
        $mail->Username = "amanarya909@yahoo.com";
        $mail->Password = "pa123456";
        $mail->From = "amanarya909@yahoo.com";
        $mail->FromName = "boia";
        $mail->AddAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $message;
        if(!$mail->Send()) {
            echo "Error in mail";
        } else{
           echo "Successfully Send";
        }
  }
?>
    <section class="section-inner">
    	<h1>Contact Us</h1>
        <div class="left-sec">
        	<div class="address">
            	<ul>
                	<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                  <li>infomy@boia.com</li>
                  <li>856 632 255</li>
              </ul>            	
            </div>
            <div class="contact-frm">
            	<form id="contact_form" action="#" method="POST" enctype="multipart/form-data">
                  <input id="name" class="input" name="name" type="text" placeholder="name" value="" size="30" required/><br />
                  <input id="email" class="input" name="email" type="text" placeholder="e-mail address" value="" size="30" required/><br />
                  <textarea id="message" class="msg" name="message" placeholder="message" rows="8" cols="30" required></textarea><br />
                  <input id="submit_button" type="submit" name="submit" class="button" value="Send Now" />
              </form>
            </div>
        </div>
        <div class="right-sec">
        	<div style="width: 100%"><iframe width="100%" height="392" src="http://www.maps.ie/create-google-map/map.php?width=100%&amp;height=392&amp;hl=en&amp;q=33%20Ubi%20Avenue%203%20%20Vertex%20Tower%20A%20%20Unit%2005-58%20%20Singapore%20408868+(BOIA%20Pte.%20Ltd.)&amp;ie=UTF8&amp;t=&amp;z=10&amp;iwloc=A&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="http://www.mapsdirections.info/fr/creez-une-carte-google/">Créer une carte google maps</a> by <a href="http://www.mapsdirections.info/fr/">Carte Google Maps</a></iframe></div>
        </div>
    </section>
    
<?php 
  include('layout/footer.php'); 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Apposys Sheduling</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
    <font style="display:none!important;font-size:1px;color:#eaeaea">Booking Information.</font>
    
    <table width="100%" cellspacing="0" cellpadding="20" border="0" bgcolor="#ebebeb">
        <tbody><tr>
            <td bgcolor="#f5f5f5" align="center">
                <br><br>
                <table style="font-size:13px" width="600" cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr>
                        <td style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#3b3b3b;line-height:22px;padding:50px 75px 50px 75px;border:1px solid #d2d2d2;border-radius:3px" bgcolor="#ffffff" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr>
                                    <td>
                                        <h3 style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:26px;color:#192637;font-weight:300;margin:0;padding:0 0 5px 0">Booking Information  <?php echo date('d-m-Y',strtotime($order[0]->booking_date)); ?></h3>
                                        <br>
                                        <h3 style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:26px;color:#192637;font-weight:300;margin:0;padding:0 0 5px 0"><?php echo $order[0]->event_name; ?></h3>
                                        <br>
                                        <div style="padding:2.5px 0 2.5px 10px;border-left:5px solid #1ABB9C"><div style="padding-bottom:5px"><a href="#" style="font-size:18px;color:#192637;text-decoration:none" ><span ></span> &nbsp; &nbsp; <?php echo $order[0]->customer_first_name; ?></a></div><div style="color:#686868;font-size:12px">Event   — <?php echo $order[0]->person; ?> Seat Booked By you. &nbsp; </div></div><br>
                                        <br>
                                        
                                        <br>
                                        
                                        <div style="font-size:13px">
                                        <br>
                                         </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <h3 style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:26px;color:#192637;font-weight:300;margin:0;padding:0 0 5px 0">User Information </h3>
                                        <br>
                                        <div style="padding:2.5px 0 2.5px 10px;border-left:5px solid #1ABB9C"><div style="padding-bottom:5px"><a href="#" style="font-size:18px;color:#192637;text-decoration:none" >
                                        <span><?php echo $order[0]->customer_first_name; ?></span><br />
                                        <span><span><?php echo $order[0]->customer_phone; ?><br><?php echo $order[0]->customer_email; ?></span></span> &nbsp; &nbsp; </a></div></div><br>
                                        <br>
                                        
                                        <br>
                                        
                                        <div style="font-size:13px">
                                        <br>
                                         </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <h3 style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:26px;color:#192637;font-weight:300;margin:0;padding:0 0 5px 0">QR Code </h3>
                                        <br>
                                        <div style="padding:2.5px 0 2.5px 10px;border-left:5px solid #1ABB9C"><div style="padding-bottom:5px"><a href="#" style="font-size:18px;color:#192637;text-decoration:none" >
                                        <span>
                                            <img src="<?php echo base_url(); ?>file/qr/<?php echo $order[0]->booking_id; ?>.png" height="200" width="200">
                                        </span><br />
                                        </a>
                                        </div></div><br>
                                        <br>
                                        
                                        <br>
                                        
                                        <div style="font-size:13px">
                                        <br>
                                         </div>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
                <br>
                <table width="600" cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr bgcolor="#f5f5f5">
                        <td><p style="font-size:11px;color:#7d7d7d;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif" align="center">
                        <a href="#" style="color:#344351;text-decoration:none" ><strong>EventSYS Scheduling</strong></a> 
                        <br>
                         </p></td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table>

    </body>
</html>

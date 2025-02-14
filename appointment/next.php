<!DOCTYPE html>
<html lang="en">
<head>
<title>Date</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet"  href="css/lightslider.css"/>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,300i,400,500,600,700,800" rel="stylesheet">
<link rel="stylesheet"  href="css/style.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="headDate">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
			<div class="backArrow">
				<a style="text-decoration: none;" href="index.php"<i class="fa fa-long-arrow-left fa-3x" aria-hidden="true"></i></a>
			</div>
				<h4><?php echo $_REQUEST['day']; ?> </h4>
                <p><?php echo $_REQUEST['month']; ?> <?php echo $_REQUEST['date']; ?>, <?php echo $_REQUEST['year']; ?><br>
Time zone is <?php echo date_default_timezone_get(); ?></p>
			</div>
		</div>
	</div>
  </div>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="timeSection">
			<div class="col3of5 mbs mobile-centered" style="float: left;"><h4 style="margin-bottom: 30px">Choose a time</h4></div>
<div class="col2of5 mbs mobile-centered text-right">
	<label class="switch" style="padding: 0 10px;"><input type="radio" name="time_notation" value="notation_date_24" style="margin: 7px 5px;position: relative;top: 4px;"><span class="on">24 hr</span></label>
	<label class="switch"><input type="radio" checked="checked" name="time_notation" value="notation_date_12" style="margin: 7px 5px;position: relative;top: 4px;"><span class="on">12 hr</span></label>
    </div>
    <div class="clearfix"></div>
    	<div class="notation_date_12" style="display: block;">
			<div class="Btns">
				<button type="button" class="timeBtn">1:30pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('1:30pm');">Confirm</button>
			</div>
			<div class="Btns">
				<button type="button" class="timeBtn">2:00pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('2:00pm');">Confirm</button>
			</div>
			<div class="Btns">
				<button type="button" class="timeBtn">2:30pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('2:30pm');">Confirm</button>
			</div>	
			<div class="Btns">
				<button type="button" class="timeBtn">3:00pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('3:00pm');">Confirm</button>
			</div>	
			<div class="Btns">
				<button type="button" class="timeBtn">3:30pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('3:30pm');">Confirm</button>
			</div>
			<div class="Btns">
				<button type="button" class="timeBtn">5:00pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('5:00pm');">Confirm</button>
			</div>	
			<div class="Btns">
				<button type="button" class="timeBtn">5:30pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('5:30pm');">Confirm</button>
			</div>
			<div class="Btns">
				<button type="button" class="timeBtn">6:00pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('6:00pm');">Confirm</button>
			</div>		
			<div class="Btns">
				<button type="button" class="timeBtn">6:30pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('6:30pm');">Confirm</button>
			</div>	
			<div class="Btns">
				<button type="button" class="timeBtn">7:00pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('7:00pm');">Confirm</button>
			</div>	
			<div class="Btns">
				<button type="button" class="timeBtn">7:30pm</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('7:30pm');">Confirm</button>
			</div>	
		</div>
		<div class="notation_date_24" style="display: none;">
			<div class="Btns">
				<button type="button" class="timeBtn">13:30</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('13:30');">Confirm</button>
			</div>
			<div class="Btns">
				<button type="button" class="timeBtn">14:00</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('14:00');">Confirm</button>
			</div>
			<div class="Btns">
				<button type="button" class="timeBtn">14:30</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('14:30');">Confirm</button>
			</div>	
			<div class="Btns">
				<button type="button" class="timeBtn">15:00</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('15:00');">Confirm</button>
			</div>	
			<div class="Btns">
				<button type="button" class="timeBtn">15:30</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('15:30');">Confirm</button>
			</div>
			<div class="Btns">
				<button type="button" class="timeBtn">17:00</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('17:00');">Confirm</button>
			</div>	
			<div class="Btns">
				<button type="button" class="timeBtn">17:30</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('17:30');">Confirm</button>
			</div>
			<div class="Btns">
				<button type="button" class="timeBtn">18:00</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('18:00');">Confirm</button>
			</div>		
			<div class="Btns">
				<button type="button" class="timeBtn">18:30</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('18:30');">Confirm</button>
			</div>	
			<div class="Btns">
				<button type="button" class="timeBtn">19:00</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('19:00');">Confirm</button>
			</div>	
			<div class="Btns">
				<button type="button" class="timeBtn">19:30</button>
				<button type="button" class="ConfirmBtn" onclick="return onclickitem('19:30');">Confirm</button>
			</div>	
		</div>
			</div>
		</div>
	</div>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/lightslider.js"></script> 

<script type="text/javascript">
$(document).ready(function(){

$(".timeBtn").click(function(){
	$(".timeBtn").css("width" , "100%");
	$(".ConfirmBtn").css("display" , "none");
	$(this).next().css("display" , "inline-block");
	$(this).css("width" , "49%");
});	

// 12 hrs and 24 hrs Time Notation changer..

$('input[name="time_notation"]').click(function() {
   var hrtime = this.value;

   if(hrtime == 'notation_date_12'){
   	$('.notation_date_24').hide();
   	$('.notation_date_12').show();
   }
   
   if(hrtime == 'notation_date_24'){
   	$('.notation_date_12').hide();
   	$('.notation_date_24').show();	
   }

});

});
</script>
<script type="text/javascript">
	function onclickitem(time){

var day = '<?php echo $_REQUEST['day']; ?>';
var date = '<?php echo $_REQUEST['date']; ?>';
var month = '<?php echo $_REQUEST['month']; ?>';
var year = '<?php echo $_REQUEST['year']; ?>';

window.location.href='appointment.php?day='+day+'&date='+date+'&month='+month+'&year='+year+'&time='+time;
//alert("hello testing..");
}
</script>
</body>
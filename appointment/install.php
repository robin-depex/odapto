<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}
.column label{float: left;line-height: 40px;text-align: right;width: 33%;margin-top: 6px;margin-bottom: 16px;}
input[type=text], select, textarea {width: 60%;padding: 12px;margin-left: 20px;border: 1px solid #ccc;margin-top: 6px;margin-bottom: 16px;resize: vertical;}
input[type=submit] {background-color: #4CAF50;color: white;padding: 12px 20px;border: none;cursor: pointer;}
input[type=submit]:hover {background-color: #45a049;}
.container {border-radius: 5px;background-color: #f2f2f2;padding: 10px;}
.column {width: 50%;margin-top: 6px;padding: 20px;margin: 0 auto;}
.row:after {content: "";display: table;clear: both;}
@media screen and (max-width: 600px) {.column, input[type=submit] {width: 100%;margin-top: 0;}}
</style>
</head>
<body>
<div class="container">
<?php
if(isset($_POST['active'])){
// Connect Database	
$con = mysqli_connect($_POST['dbhost'],$_POST['dbuser'],$_POST['dbpass'],$_POST['dbname']);
if(mysqli_connect_errno()){
  $error_msg =  "Failed to connect to MySQL: " . mysqli_connect_error();
}else{

//Create Tables.
mysqli_query($con, "TRUNCATE TABLE appinstall");
mysqli_query($con, "TRUNCATE TABLE appointment");
mysqli_query($con, "TRUNCATE TABLE currency");
mysqli_query($con, "TRUNCATE TABLE users");

mysqli_query($con, "CREATE TABLE IF NOT EXISTS `appinstall` (`dbhost` varchar(100) NOT NULL,`dbuser` varchar(100) NOT NULL,`dbpass` varchar(100) NOT NULL,`dbname` varchar(100) NOT NULL)");

mysqli_query($con, "CREATE TABLE IF NOT EXISTS `appointment` (`id` int(11) AUTO_INCREMENT PRIMARY KEY,`name` varchar(255) NOT NULL,`email` varchar(255) NOT NULL,`mobile` varchar(255) NOT NULL,`comment` varchar(255) NOT NULL,`subject` varchar(255) NOT NULL,`message` varchar(255) NOT NULL,`price` varchar(255) NOT NULL,`currency` varchar(255) NOT NULL,`payment_status` varchar(255) NOT NULL,`order_id` varchar(255) NOT NULL,`status` int(1) NOT NULL)");

mysqli_query($con, "CREATE TABLE IF NOT EXISTS `currency` (`id` int(11) AUTO_INCREMENT PRIMARY KEY,`code` varchar(6) NOT NULL)");

mysqli_query($con, "CREATE TABLE IF NOT EXISTS `users` (`id` int(11) AUTO_INCREMENT PRIMARY KEY,`email` varchar(255) NOT NULL,`password` varchar(255) NOT NULL,`admin_title` varchar(255) NOT NULL,`appointment_desc` varchar(255) NOT NULL,`contactor_name` varchar(255) NOT NULL,`contactor_email` varchar(255) NOT NULL,`mobile` varchar(255) NOT NULL,`image` varchar(255) NOT NULL,`city` varchar(255) NOT NULL,`state` varchar(255) NOT NULL,`country` varchar(255) NOT NULL,`contactor_currency` varchar(6) NOT NULL,`contactor_price` varchar(255) NOT NULL,`time_schedule_12` longtext NOT NULL,`time_schedule_24` longtext NOT NULL,`status` int(1) NOT NULL)");

// Insert Data

$install_sql = "INSERT IGNORE INTO appinstall SET dbhost='".$_POST['dbhost']."', dbuser='".$_POST['dbuser']."', dbpass='".$_POST['dbpass']."', dbname='".$_POST['dbname']."'";
mysqli_query($con, $install_sql);

$user_sql = "INSERT IGNORE INTO users SET email='admin@domain.com',password='e10adc3949ba59abbe56e057f20f883e',admin_title='Appointment',appointment_desc='Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy ever since the 1500s an unknown printer took a galley of type and scrambled it to make a type specimen book.',contactor_name='John',contactor_email='john@domail.com',mobile='0123456789',image='logo-1.jpg',city='Noida',state='Utter Pradesh',country='India',contactor_currency='USD',contactor_price='10.00',status='1'";
mysqli_query($con, $user_sql);

$sql_ins = "INSERT IGNORE INTO currency (code) VALUES('AFN'),('ALL'),('DZD'),('USD'),('EUR'),('AOA'),('XCD'),('ARS'),('AMD'),('AWG'),('AUD'),('AZN'),('BSD'),('BHD'),('BDT'),('BBD'),('BYR'),('BZD'),('XOF'),('BMD'),('BTN'),('BOB'),('BAM'),('BWP'),('NOK'),('BRL'),('BND'),('BGN'),('BIF'),('CVE'),('KHR'),('XAF'),('CAD'),('KYD'),('CLP'),('CNY'),('COP'),('KMF'),('CDF'),('NZD'),('CRC'),('HRK'),('CUP'),('CZK'),('DKK'),('DJF'),('DOP'),('ECS'),('EGP'),('SVC'),('ERN'),('ETB'),('FKP'),('FJD'),('GMD'),('GEL'),('GHS'),('GIP'),('GBP'),('QTQ'),('GGP'),('GNF'),('GWP'),('GYD'),('HTG'),('HNL'),('HKD'),('HUF'),('ISK'),('INR'),('IDR'),('IRR'),('IQD'),('ILS'),('JMD'),('JPY'),('JOD'),('KZT'),('KES'),('KPW'),('KRW'),('KWD'),('KGS'),('LAK'),('LVL'),('LBP'),('LSL'),('LRD'),('LYD'),('CHF'),('LTL'),('MOP'),('MKD'),('MGF'),('MWK'),('MYR'),('MVR'),('MRO'),('MUR'),('MXN'),('MDL'),('MNT'),('MAD'),('MZN'),('MMK'),('NAD'),('PR'),('ANG'),('NIO'),('NGN'),('OMR'),('PKR'),('PAB'),('PGK'),('PYG'),('PEN'),('PHP'),('PLN'),('XPF'),('QAR'),('RON'),('RUB'),('RWF'),('SHP'),('WST'),('STD'),('SAR'),('RSD'),('SCR'),('SLL'),('SGD'),('SBD'),('SOS'),('ZAR'),('SSP'),('LKR'),('SDG'),('SRD'),('SZL'),('SEK'),('SYP'),('TWD'),('TJS'),('TZS'),('THB'),('TOP'),('TTD'),('TND'),('TRY'),('TMT'),('UGX'),('UAH'),('AED'),('UYU'),('UZS'),('VUV'),('VEF'),('VND'),('YER'),('ZMW'),('ZWD')";
mysqli_query($con, $sql_ins);
?>
<div style="padding:20px; color: #2e5014;background: #d5efc2;">Thank you for Setup. <br /> Setup user Email: admin@domail.com Password : 123456,  Please Login <a href="/appointment/auth.php">Click here </a> Reset the email and password for security reason.</div>
<?php
}
}else{ ?>
  <div style="text-align:center">
    <h2>Install And Connect with Admin</h2>
    <p>Please Enter Correct Database Name, User Name And Password :- </p>
  </div>
  <div class="row">
    <div class="column">
      <form method="post">
        <label for="fname">Database Host Name</label>
        <input type="text" name="dbhost" placeholder="localhost" value="localhost">
        <label for="lname">Database User Name</label>
        <input type="text" name="dbuser" placeholder="User Name.">
        <label for="lname">Database User Password</label>
        <input type="text" name="dbpass" placeholder="Password.">
        <label for="lname">Database Name</label>
        <input type="text" name="dbname" placeholder="Database Name.">
        <br clear="all" />
        <div style="float: right;width: 30%;margin-right: 30px;"><input type="submit" name="active" style="width: 100%;" value="Install And Active"></div>
      </form>
    </div>
  </div>
<?php } ?>
</div>
</body>
</html>
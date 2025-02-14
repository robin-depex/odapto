<div class="clearfix"></div>
<div class="atglance">
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-6">
                  <div class="Flexinner  wow fadeInDown">
                     <h1>Information At A Glance</h1>
                     <p>Dive into the details by adding comments, attachments, and more directly to Odapto cards. Collaborate on projects from beginning to end.</p> 
                  </div>
               </div>
       </div>
     </div>
  </div>
  <div class="clearfix"></div>
<div class="cirMove">
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="proPlate">
         <div class='a'><img class="img-responsive" src="img-new/crcl2.png"></div>
          
         <div class="proPlate-text wow fadeInLeft">
             <h1>A productivity Platform</h1>
             <p>A simple platform even executives, entrepreneurs should use Integrations turns Odapto into a time saving stress free environment</p>
         </div>
         <div class="proPlate-img wow fadeInRight">
            <img src="img-new/team-work.png" class="img-responsive">
         </div>
      </div>
  </div>
</div>
</div>
<div class="clearfix"></div>
<div class="alwaysSync wow fadeInDown">
<div class="syncuppr text-center">
<h1>Always In Sync</h1>
<p>No matter where you are, Odapto stays in sync across all 
of your devices. Collaborate with your team anywhere, from sitting on the bus to sitting on the beach.</p>
<ul class="list-inline">
<li><a href="#"><img src="img-new/play-store.png" class="img-responsive"></a></li>
<li><a href="#"><img src="img-new/app-store.png" class="img-responsive"></a></li>
</ul>
</div>
</div>

<div class="clearfix"></div>
<div class="container">
  <div class="row">
    <div class="d-block">
      <div class="col-sm-8 wow fadeInLeft">
        <img src="img-new/b.jpg" class="img-responive">
      </div>
      <div class="col-sm-4">
        <div class="anyTeam wow fadeInRight">
        <!--  <h3>Work With Any Team.</h3> -->
        <h3>Odapto helps you to get successful.</h3>
    <p>Whether it’s for work, a side project or even the next family vacation, Odapto helps your team stay organized.</p>
   
      </div>
    </div>
    </div>
  </div>
</div>


<div class="clearfix"></div>
<div class="whatWait wow fadeInDown">
<div class="syncuppr col-sm-offset-3 col-sm-6 text-center">
    <h1>What are you waiting for?</h1>
    <p>Sign up for free and become one of the millions of people around the world who have fallen in love with Odapto.</p>
    <a style="margin-top:0" href="signup.php" class="newObtn">Sign Up - It's Free</a>
    <h3>Already Use Odapto? <a style="color:#fb6f4b" href="login.php">Log in</a></h3>
    <br>
    <h3>JOIN OUR NEWSLETTER</h3>
    <form method="post" action="">
 <label>Subscribe our newsletter to recieve the latest news</label>
    <div class="form-group">       
        <label class="text-success" id="subs_msg"></label>
        <div class="row">
        <div class="col-sm-9" style="margin-top: 10px">
          <input type="email" id="user_email" class="form-control input-lg" placeholder="abc@gmail.com" >
        </div>
        <label class="control-label col-sm-3" for="email" style="margin-top: 10px">
          <input type="button" class="newObtn btn-lg" id="subscribe" style="margin-top:0" value="Subscribe">
        </label>
        </div>
  </div>
  </form>
</div>
</div>

<script type="text/javascript">
    //HIDE SUCCESS ALERT
    function hide_msg()
    {
        $("#subs_msg").fadeTo(5000, 500).slideUp(500, function(){
                    $("#subs_msg").slideUp(500);
                });
    }
   
    function isValidEmailAddress(emailAddress) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            return expr.test(emailAddress);
    }
    
    $("#subscribe").click(function(){
        var mail = $("#user_email").val();
        if(mail=='')
        {
             $("#subs_msg").text('Please Enter email id').css({'color':'red'});
             hide_msg();
              
        }else if(!isValidEmailAddress(mail)){
            $("#subs_msg").text('Please Enter valid email id').css({'color':'red'});
            hide_msg();
        }
        else{
        //alert(mail);
        $.ajax({
        url: "resend-email.php",
        type: "POST",
        data: {'action':'Subscription','subs_email':mail},
        success: function(rel){
         // alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
  
            $("#subs_msg").text(obj.message).css({'color':'green'});
            hide_msg();
            
          }else if(obj.result=="FALSE"){ 
            $("#subs_msg").text(obj.message).css({'color':'red'});
            hide_msg();
            
          }
        }
      }); 
      return false;
    }
      
        
    });
</script>

<style type="text/css">
.banner-txt p {
    font-size: 18px;
    color: #506478;
    line-height: 30px;
    margin: 0;
    font-weight: 500;
}
.footerNew ul li > a{
  color: #fff;
}
.footerNew ul li > a:hover, .footerNew ul li > a:active{
  text-decoration: none;
}
.st-todat li{
  margin-right: 25px;
  text-transform: capitalize;
  font-weight: 600;
}
</style>
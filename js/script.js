$(document).ready(function(){

$("#fullname").keypress(function(event){
  var inputValue = event.charCode;
  if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
    $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
    $(".yes,.No").hide();
    $(".message").html("Enter Only Character").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
    setTimeout(function() {
      $('.confirmBox').fadeOut('fast');
    }, 2000);
    event.preventDefault();
  }
});

function isValidEmailAddress(emailAddress) {
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(emailAddress);
}

// user registration 
$("#register").click(function(){
        
        var fullname = $("#fullname").val();
        var emailadd = $("#emailadd").val();
        var pass = $("#pass").val();
        var cmpass = $("#confirmpass").val();
        if(fullname == ""){
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html("Enter Full Name").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
            setTimeout(function() {
              $('.confirmBox').fadeOut('fast');
            }, 2000);
            event.preventDefault();
        }else if(emailadd == ""){
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html("Enter Email Address").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
            setTimeout(function() {
              $('.confirmBox').fadeOut('fast');
            }, 2000);
            event.preventDefault();
        }else if(!isValidEmailAddress(emailadd)){
          $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Valid Email Id").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          setTimeout(function() {
            $('.confirmBox').fadeOut('fast');
          }, 2000);
          event.preventDefault();
      }else if(pass == ""){
         $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Password").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          setTimeout(function() {
            $('.confirmBox').fadeOut('fast');
          }, 2000);
          event.preventDefault();
        }else if(cmpass == ""){
          $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Confirm Password").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          setTimeout(function() {
            $('.confirmBox').fadeOut('fast');
          }, 2000);
          event.preventDefault();
        }else if(cmpass != pass){
          $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
          $(".yes,.No").hide();
          $(".message").html("Please Enter Correct Password").delay(3000).css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
          setTimeout(function() {
          $('.confirmBox').fadeOut('fast');
          }, 2000);
          event.preventDefault();
        }else{
        
        var data = $("#registerForm").serialize();
          //alert(data);  
          $.ajax({
        url: "./userRegister.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            window.location.href = obj.url;    
          }else if(obj.result=="FALSE"){ 
            $(".confirmBox").css({'display':'block',"position":'fixed','top':'10px','height':'50px'});
            $(".yes,.No").hide();
            $(".message").html(obj.message).delay(10000).fadeOut("slow").css({'fontSize':'16px','textAlign':'left','marginLeft':'15px','marginTop':'15px','fontWeight':'normal'});
            setTimeout(function() {
              $('.confirmBox').fadeOut('fast');
            }, 2000);
          }
        }
      });        
    return false; 

        }
});































});
$(document).ready(function() {

  var owl = $('.owl-carousel');
  owl.owlCarousel({
    margin: 10,
    nav: true,
    loop: false,
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 3
      },
      1000: {
        items: 7
      }
    }
  })
  $(".owl-next span, .owl-prev span").empty();   
      $(".goNext").click(function(){
      $("#confirmSection").hide();
      $("#final-pay").show();
    });
})







$(".item").click(function(){
var day = $(this).children().contents().first().text();
var year = $(this).children().contents().last().text();
var ids = $(this).attr('id');
if(!$(this).hasClass("active-circle")){
var fulldate = $(this).children().text();
$(this).toggleClass("active-circle");
 

$('#confirmSection').css('display', 'block');
$tuesday = '<div class="viewdds" id="viewdds_'+ids+'"><div class="fulldateN"><span class="dayclass">'+day+'</span><span class="yearclass">'+year+'</span></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">9:30 - 10:00</button><button type="button" value="9:30 - 10:00" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">14:00-16:00</button><button type="button" value="14:00-16:00" class="ConfirmBtn">Confirm</button></div></div>';
$friday = '<div class="viewdds" id="viewdds_'+ids+'"><div class="fulldateN"><span class="dayclass">'+day+'</span><span class="yearclass">'+year+'</span></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">10:00 To 13:00</button><button type="button" value="10:00 To 13:00" class="ConfirmBtn">Confirm</button></div></div>';
$everyday = '<div class="viewdds" id="viewdds_'+ids+'"><div class="fulldateN"><span class="dayclass">'+day+'</span><span class="yearclass">'+year+'</span></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">09:30 To 10:00</button><button type="button" value="09:30 To 10:00" class="ConfirmBtn">Confirm</button></div></div>';
$('#final-pay').css('display', 'none');


if(day == 'Tuesday'){$('.notation_date_12').append($tuesday);}else if(day == 'Friday'){$('.notation_date_12').append($friday);}else{$('.notation_date_12').append($everyday);}
 } else{

$("#viewdd_"+ids).remove('');
$("#viewdds_"+ids).remove('');
$(this).removeClass("active-circle");
 }

$(".ConfirmBtn").click(function(){
 var finaltime =  $(this).siblings().contents().last().text();
$('.finalData').append('<div id="viewdd_'+ids+'"> '+finaltime+' '+fulldate+'<br></div>');
});

});


/*$(document).on('click','.onclickitemtime', function (event) {  
  var i_time = $(this).attr('value');
  $('.sel_time').html(' '+ i_time);
});*/


$.getJSON("http://freegeoip.net/json/", function(data) {
  var ip = data.ip;
  var country = data.country_name;
  $(".country_name").html(country);
});




$(document).on('mouseenter','.timeBtn', function (event) {  
  $(".timeBtn").css({"width" : "99%", "background" : "#fff", "color" : "#00a2ff", "margin" : "0 0.5%"});
  $(".ConfirmBtn").css("display" , "none");
  $(this).next().css("display" , "inline-block");
  $(this).css({"width" : "49%", "background" : "green", "color" : "#fff", "margin" : "0 0.5%"});
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
$('#submit').click(function(){
  $("form#contact").submit(function(){return false;});
          //get the values
      var name = $('#name').val();
      var email = $('#email').val();
      var mobile = $('#mobile').val();
      var comment = $('#comment').val();
      if(name ==''){$('.error_name').text('Please Enter Your Name.');return;}
      if(email ==''){$('.error_email').text('Please Enter Your Email Id.!');return;}
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if(! email.match(mailformat)){$('.error_email').text('Please Enter Correct Email Id.!');}
      if(mobile ==''){$('.error_mobile').text('Mobile Number is Required.!');return;}
      if(comment ==''){$('.error_comment').text('Please Enter Your comment.');return;}
      //validate the form
      if(name != '' && email != '' && mobile != '' && comment !=''){
          $.post('ajax.php', {name:name, email:email, mobile:mobile, comment:comment}, function(resp){
            //console.log(resp);
            var obj = JSON.parse(resp);
            if(obj.checkout_url != ''){
              window.location.replace(obj.checkout_url);
            }
          }); 
      } 
});
$('#name').keypress(function(){if(this.value.length > 0){$('.error_name').hide();}else{$('.error_name').show();}});
$('#email').keypress(function(){if(this.value.length > 0){$('.error_email').hide();}else{$('.error_email').show();}});
$('#mobile').keypress(function(){if(this.value.length > 0){$('.error_mobile').hide();}else{$('.error_mobile').show();}});
$('#comment').keypress(function(){if(this.value.length > 0){$('.error_comment').hide();}else{$('.error_comment').show();}});


$(document).ready(function(){
    $("#new").click(function(){
        $(".new-task").fadeIn();
    });
});

$(document).ready(function(){
    $("#addo").click(function(){
        $(".comp").fadeIn();
    });
});

//first

$(document).ready(function() {
    $("#login").click(function(e) {
        $("#login-panel").toggle();
        e.stopPropagation();
    });

    $(document).click(function(e) {
        if (!$(e.target).is('#login-panel, #login-panel *')) {
            $("#login-panel").hide();
        }
    });
});

//first

//second

$(document).ready(function() {
    $("#login1").click(function(e) {
        $("#login-panel1").toggle();
        e.stopPropagation();
    });

    $(document).click(function(e) {
        if ($(e.target).is('#login-panel1, #login-panel1 *')) {
            $("#login-panel1").hide();
        }
    });
});

//second


//third

$(document).ready(function() {
    $("#login2").click(function(e) {
        $("#login-panel2").toggle();
        e.stopPropagation();
    });

    $(document).click(function(e) {
        if ($(e.target).is('#login-panel2, #login-panel2 *')) {
            $("#login-panel2").hide();
        }
    });
});

//third

//third

$(document).ready(function() {
    $("#login3").click(function(e) {
        $("#login-panel3").toggle();
        e.stopPropagation();
    });

    $(document).click(function(e) {
        if (!$(e.target).is('#login-panel3, #login-panel3 *')) {
            $("#login-panel3").hide();
        }
    });
});

//third

//third

$(document).ready(function() {
    $("#login4").click(function(e) {
        $("#login-panel4").toggle();
        e.stopPropagation();
    });

    $(document).click(function(e) {
        if (!$(e.target).is('#login-panel4, #login-panel4 *')) {
            $("#login-panel4").hide();
        }
    });
});

//third

//third

$(document).ready(function() {
    $("#login5").click(function(e) {
        $("#login-panel5").toggle();
        e.stopPropagation();
    });

    $(document).click(function(e) {
        if (!$(e.target).is('#login-panel5, #login-panel5 *')) {
            $("#login-panel5").hide();
        }
    });
});

//third









//for drag and drop

function allowDrop(ev) {
ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
}


//for drag and drop
function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("login-panel");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}

<!--for edit function-->
function edit(){
	 document.getElementById("profile").style.display="none";
	  document.getElementById("edit-pro").style.display="block";
	}

<!--for edit function-->



//change baackground



function bodyChange1() {
    
    var color = $("#color").val();
    document.body.style.backgroundColor = color;
    var id = $("#userid").val();

    var data = "color="+color+"&id="+id;
    $.ajax({
        url: "./changeBgColor.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
        }
      }); 
    
}
function bodyChange2() {
    
    var color = $("#color2").val();
    document.body.style.backgroundColor = color;
    var id = $("#userid").val();

    var data = "color="+color+"&id="+id;
    $.ajax({
        url: "./changeBgColor.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
        }
      }); 
    
}

function bodyChange3() {
    var color = $("#color3").val();
    document.body.style.backgroundColor = color;
    var id = $("#userid").val();

    var data = "color="+color+"&id="+id;
    $.ajax({
        url: "./changeBgColor.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
        }
      }); 
    
}

function bodyChange4() {
    var color = $("#color4").val();
    document.body.style.backgroundColor = color;
    var id = $("#userid").val();

    var data = "color="+color+"&id="+id;
    $.ajax({
        url: "./changeBgColor.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
        }
      }); 
    
}

function bodyChange5() {
    var color = $("#color5").val();
    document.body.style.backgroundColor = color;
    var id = $("#userid").val();

    var data = "color="+color+"&id="+id;
    $.ajax({
        url: "./changeBgColor.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
        }
      }); 
    
}

function bodyChange6() {
    var color = $("#color6").val();
    document.body.style.backgroundColor = color;
    var id = $("#userid").val();

    var data = "color="+color+"&id="+id;
    $.ajax({
        url: "./changeBgColor.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
        }
      }); 
    
}

function bodyChange7() {
    var color = $("#color7").val();
    document.body.style.backgroundColor = color;
    var id = $("#userid").val();

    var data = "color="+color+"&id="+id;
    $.ajax({
        url: "./changeBgColor.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
        }
      }); 
    
}

function bodyChange8() {
    var color = $("#color8").val();
    document.body.style.backgroundColor = color;
    var id = $("#userid").val();

    var data = "color="+color+"&id="+id;
    $.ajax({
        url: "./changeBgColor.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
        }
      }); 
    
}

$("#cancel").click(function(event) {
  /* Act on the event */
  $("#edit-pro").css('display', 'none');

});

function cross(){
	document.getElementById("new-task").style.display="none";
}
	
$(document).ready(function(){
    
    $("#add-list").click(function(){
      
      
    });

});


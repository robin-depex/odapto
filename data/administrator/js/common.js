
// JavaScript Document
$(document).ready(function() {
  //$("#errorbox").hide();
});


function raiseError(errArr) {
	str = "";
	for(i=0;i<errArr.length;i++) {
		str += errArr[i]+"<br>";
	}
	$("#errorboxcontent").html(str);
	
	if(document.getElementById('errorbox').style.display=='none') {
	$("#errorbox").show("slow");
	}
	return false;
}

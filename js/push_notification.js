$(document).ready(function() {
		checknotif();
	setInterval(function(){ checknotif(); }, 10000);
});
function checknotif() {
	if (!Notification) {
		$('body').append('<h4 style="color:red">*Browser does not support Web Notification</h4>');
		return;
	}
	if (Notification.permission !== "granted")
		Notification.requestPermission();
	else {
		$.ajax(
		{
			url : "ajax_push_notification.php",
			type: "POST",
			success: function(data, textStatus, jqXHR)
			{
			    //console.log(data);
				var data = jQuery.parseJSON(data);
				if(data.result == true){
					var data_notif = data.notif;
					
					for (var i = data_notif.length - 1; i >= 0; i--) {
						var theurl = data_notif[i]['url'];
						var notifikasi = new Notification(data_notif[i]['title'], {
							icon: data_notif[i]['icon'],
							body: data_notif[i]['msg'],
						});
						notifikasi.onclick = function () {
							window.open(theurl); 
							notifikasi.close();     
						};
						setTimeout(function(){
							notifikasi.close();
						}, 10000);
					};
				}else{

				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{

			}
		});	

	}
};
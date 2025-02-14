$(document).ready(function(){

	var active_navlayer = '';
	var quicknav_active = false;

	$('a.shownavlayer').mouseover(function(){
		
		if (active_navlayer != '') {
			$('div#' + active_navlayer + '-layer').hide();
		}

		$('div#' + this.id + '-layer').show();
		active_navlayer = this.id;

	});	

	$('.hidenavlayer').mouseover(function(){
		$('div#' + active_navlayer + '-layer').hide();
		active_navlayer = '';
	});	

	$('a.content-bar-top-quicknav').click(function(){
		
		if (quicknav_active == false) {
			$('div#quicknav-layer').fadeIn();
			$('a.content-bar-top-quicknav').addClass('active');
			quicknav_active = true;
		} else {
			$('div#quicknav-layer').hide();
			$('a.content-bar-top-quicknav').removeClass('active');
			quicknav_active = false;
		}

	});

	$('li.arrow[id*=nav-]').click(function(){

		$('li#' + this.id + '-list').toggle();

		return false;

	});

	$('a.premiumlink').cluetip({clickThrough: true, width: '200px', splitTitle: '|'});
	$('a.awardlink').cluetip({clickThrough: true, width: '200px', splitTitle: '|'});
	$('a.umfrageergebnis').cluetip({clickThrough: false, width: '200px', splitTitle: '|'});
	$('a.onlineuser').cluetip({activation: 'click', clickThrough: false, width: '200px'});
	$('a.show_tooltip').cluetip({clickThrough: false, width: '300px', splitTitle: '|'});
	$('a.show_tooltip_link').cluetip({clickThrough: true, width: '300px', splitTitle: '|'});
	$('a.show_image').cluetip({clickThrough: true, width: '400px', showTitle: false});
});
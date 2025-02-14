<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
?>
<div class="content">
<div class="container-fluid">
<div class="row">

<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header" data-background-color="orange">
    <i class="material-icons">content_copy</i>
</div>
<div class="card-content">
    <p class="category">Template Category</p>
    <h3 class="title"><?php echo $db->count_all('tbl_tmp_category'); ?></h3>
</div>
<div class="card-footer">
    <div class="stats">
        <i class="material-icons text-danger"></i>
    </div>
</div>
</div>
</div>



<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header" data-background-color="green">
    <i class="material-icons">content_copy</i>
</div>
<div class="card-content">
    <p class="category">Templates</p>
    <h3 class="title"><?php echo $db->count_all('tbl_templates'); ?></h3>
</div>
<!--<div class="card-footer">
    <div class="stats">
        <i class="material-icons">date_range</i> Last 24 Hours
    </div>
</div>-->
</div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header" data-background-color="orange">
    <i class="material-icons">content_copy</i>
</div>
<div class="card-content">
    <p class="category">Template Boards</p>
    <h3 class="title"><?php echo $db->count_all('tbl_tmp_board'); ?></h3>
</div>
<div class="card-footer">
    <div class="stats">
        <i class="material-icons text-danger"></i>
    </div>
</div>
</div>
</div>


<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header" data-background-color="green">
    <i class="material-icons">content_copy</i>
</div>
<div class="card-content">
    <p class="category">Template Board List</p>
    <h3 class="title"><?php echo $db->count_all('tbl_tmp_board_list'); ?></h3>
</div>
<!--<div class="card-footer">
    <div class="stats">
        <i class="material-icons">date_range</i> Last 24 Hours
    </div>
</div>-->
</div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header" data-background-color="green">
    <i class="material-icons">content_copy</i>
</div>
<div class="card-content">
    <p class="category">Template Board List Card</p>
    <h3 class="title"><?php echo $db->count_all('tbl_tmp_board_list_card'); ?></h3>
</div>
<!--<div class="card-footer">
    <div class="stats">
        <i class="material-icons">date_range</i> Last 24 Hours
    </div>
</div>-->
</div>
</div>


<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header" data-background-color="orange">
    <i class="material-icons">content_copy</i>
</div>
<div class="card-content">
    <p class="category"> Users</p>
    <h3 class="title"><?php echo $db->count_all('tbl_users'); ?></h3>
</div>
<div class="card-footer">
    <div class="stats">
        <i class="material-icons text-danger"></i>
    </div>
</div>
</div>
</div>


</div>

<div class="row">
<!--
<div class="col-md-6">
<div class="card">
<div class="card-header card-chart" data-background-color="orange">
    <div class="ct-chart" id="emailsSubscriptionChart"></div>
</div>
<div class="card-content">
    <h4 class="title">Email Subscriptions</h4>
    <p class="category">Last Campaign Performance</p>
</div>
<div class="card-footer">
    <div class="stats">
        <i class="material-icons">access_time</i> campaign sent 2 days ago
    </div>
</div>

</div>
</div>
-->


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T8T3J3B"
height="200px" width="200px" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->



<!--<div class="col-md-12">
<div class="card">
<div class="card-header card-chart" data-background-color="red">
    <div class="ct-chart" id="emailsSubscriptionChart"></div>
</div>
<div class="card-content">
    <h4 class="title">Registered Users</h4>
    <p class="category">Users Monthly Counting Performance</p>
</div>
<div class="card-footer">
    <div class="stats">
        <i class="material-icons">&nbsp;</i></div>
</div>
</div>
</div>-->
</div>

</div>
</div>
<script>
type = ['','info','success','warning','danger'];


demo = {
    initPickColor: function(){
        $('.pick-class-label').click(function(){
            var new_class = $(this).attr('new-class');
            var old_class = $('#display-buttons').attr('data-class');
            var display_div = $('#display-buttons');
            if(display_div.length) {
            var display_buttons = display_div.find('.btn');
            display_buttons.removeClass(old_class);
            display_buttons.addClass(new_class);
            display_div.attr('data-class', new_class);
            }
        });
    },

    initFormExtendedDatetimepickers: function(){
        $('.datetimepicker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
         });
    },

    initDocumentationCharts: function(){
        /* ----------==========     Daily Sales Chart initialization For Documentation    ==========---------- */

        dataDailySalesChart = {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            series: [
                [12, 17, 7, 17, 23, 18, 38]
            ]
        };

        optionsDailySalesChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
        }

        var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

        md.startAnimationForLineChart(dailySalesChart);
    },

    initDashboardPageCharts: function(){

        /* ----------==========     Daily Sales Chart initialization    ==========---------- */

        dataDailySalesChart = {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            series: [
                [12, 17, 7, 17, 23, 18, 38]
            ]
        };

        optionsDailySalesChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
        }

        var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

        md.startAnimationForLineChart(dailySalesChart);



        /* ----------==========     Completed Tasks Chart initialization    ==========---------- */

        dataCompletedTasksChart = {
            labels: ['12am', '3pm', '6pm', '9pm', '12pm', '3am', '6am', '9am'],
            series: [
                [230, 750, 450, 300, 280, 240, 200, 190]
            ]
        };

        optionsCompletedTasksChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 1000, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0}
        }

        var completedTasksChart = new Chartist.Line('#completedTasksChart', dataCompletedTasksChart, optionsCompletedTasksChart);

        // start animation for the Completed Tasks Chart - Line Chart
        md.startAnimationForLineChart(completedTasksChart);



        /* ----------==========     Emails Subscription Chart initialization    ==========---------- */

        var dataEmailsSubscriptionChart = {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          series: [
            [<?php $db->getuserbymonth('tbl_users'); ?>]

          ]
        };
        var optionsEmailsSubscriptionChart = {
            axisX: {
                showGrid: false
            },
            low: 0,
            high: 200,
            chartPadding: {top: 0, right: 0, bottom: 0, left: 0}
        };
        var responsiveOptions = [
          ['screen and (max-width: 640px)', {
            seriesBarDistance: 1,
            axisX: {
              labelInterpolationFnc: function (value) {
                return value[0];
              }
            }
          }]
        ];
        var emailsSubscriptionChart = Chartist.Bar('#emailsSubscriptionChart', dataEmailsSubscriptionChart, optionsEmailsSubscriptionChart, responsiveOptions);

        //start animation for the Emails Subscription Chart
        md.startAnimationForBarChart(emailsSubscriptionChart);

    },

    initGoogleMaps: function(){
        var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
        var mapOptions = {
          zoom: 13,
          center: myLatlng,
          scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
          styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]

        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            title:"Hello World!"
        });

        // To add the marker to the map, call setMap();
        marker.setMap(map);
    },

    showNotification: function(from, align){
        color = Math.floor((Math.random() * 4) + 1);

        $.notify({
            icon: "notifications",
            message: "Welcome to <b>Material Dashboard</b> - a beautiful freebie for every web developer."

        },{
            type: type[color],
            timer: 4000,
            placement: {
                from: from,
                align: align
            }
        });
    }



}

</script>


<!-- Global Site Tag (gtag.js) - Google Analytics -->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-T8T3J3B');</script>
<!-- End Google Tag Manager -->
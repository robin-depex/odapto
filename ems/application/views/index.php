<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $recored['meta_title']; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="keyword" content="<?php echo $recored['meta_keyword']; ?>">
        <meta name="description" content="<?php echo $recored['meta_desc']; ?>">

        <link rel="stylesheet" href="<?php echo base_url(); ?>_template/front/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>_template/front/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>_template/front/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>_template/front/css/font-awesome.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>_template/front/css/font-awesome.min.css">

        
    </head>
    <body>
        
      <header class="py-5 bg-image-full" style="background-image: url('<?php echo base_url(); ?>/file/header/<?php echo $recored['co_image']; ?>');">
        <div class="container target">
            <div class="row">
                <div class="col-sm-10">
                    <h1><?php echo ucfirst($recored['event_name']); ?></h1>
                    <p><b> Manage Your Shedules Easily</b></p>
                          <button type="button" onclick="javascript:window.location.href='<?php echo base_url().'index.php/home' ?>'" class="btn btn-success">Book me!</button>  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Send me a message</button>
                    <br>
                </div>
                <div class="col-sm-2">
                    <a href="/users" class="pull-right">
                        <img class="img-responsive center-block" title="profile image"  src="<?php echo base_url(); ?>file/config/<?php echo $recored['co_logo']; ?>"></a>
                </div>
            </div>
      </header>
  <br>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Message</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <textarea class="form-control" id="mmm">
                
            </textarea>
          </div>
          <div class="form-group">
              <button type="button" class="btn btn-sm btn-success" onclick="add_messge();">Send</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="ccc" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



        <div class="container target">
            <div class="row">
                <div class="col-sm-3">
            <!--left col-->
            
                   
                    <ul class="list-group">
                        <li class="list-group-item text-left" ><i style="color:green" class="fa fa-phone fa-1x" aria-hidden="true"></i>
                        <strong><?php echo $recored['co_mobile']; ?></strong></li>
                        <li class="list-group-item text-left"><i style="color:green" class="fa fa-check-square fa-1x" aria-hidden="true"></i><strong><a href="<?php echo $recored['co_website']; ?>"> Visit our Website</a></strong></li>
                        <li class="list-group-item text-left"><i style="color:green" class="fa fa-arrow-right fa-1x" aria-hidden="true"></i><strong class=""><a href="<?php echo $recored['co_direction']; ?>"> Get Direction</a></strong></li>

                        <li class="list-group-item justify-content-between"><i  style="color:green ;float:left;" class="fa fa-bullhorn" aria-hidden="true"></i><strong><a>Share</a></strong>

                        <span class="badge badge-default badge-pill">
                            <a href="http://twitter.com/share?text=An%20intersting%20blog&url=<?php echo base_url();?>index.php/front/index/<?php echo $recored['event_id']; ?>"
                                target="_blank" class="twitter ">
                                <i style="color: #FFF;" class="fa fa-twitter"></i>
                            </a>
                        </span>
                        <span class="badge badge-default badge-pill">
                            <a  href="http://www.facebook.com/sharer.php?u=<?php echo base_url();?>index.php/front/index/<?php echo $recored['event_id']; ?>"
                                target="_blank" class="facebook">
                                <i style="color: #FFF;" class="fa fa-facebook"></i>
                            </a>
                        </span>
                        <span class="badge badge-default badge-pill">
                            <a href="https://plus.google.com/share?url=<?php echo base_url();?>index.php/front/index/<?php echo $recored['event_id']; ?>"
                                target="_blank" class="google">
                                <i style="color: #FFF;" class="fa fa-google-plus"></i>
                            </a>
                        </span>

                        </li>
                    </ul>
            
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Open Hours? </strong></div>
                        <div class="panel-body"><i style="color:green" class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $recored['co_open_hours']; ?></div>
                    </div>
            
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Website </strong><i class="fa fa-link fa-1x"></i>

                        </div>
                        <div class="panel-body"><a href="<?php echo $recored['co_website']; ?>" class=""><?php echo $recored['co_website']; ?></a>

                        </div>
                    </div>

            
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Person Detail</strong></div>
                <div class="list-group">

                <?php
                //print_r($person);
                    foreach ($person as  $value) {
                        ?>
                        <div class="list-group-item">
                            <div class="media">
                                <div class="media-left">
                                    <img src="<?php echo base_url(); ?>file/person/<?php echo $value->p_image ?>" style="width:80px;height:80px"/>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $value->p_name ?><small></small></h4>
                                    <h5><?php echo $value->p_desc ?></h5>
                                    <hr style="margin:8px auto">
                                </div>
                            </div>   
                        </div>
                        <?php
                    }
                ?>
                </div>
                
            </div>
        </div>
        <!--/col-3-->
        <div class="col-sm-9" style="" contenteditable="false">
            <div class="panel panel-default">
                <div class="panel-heading"><i style="color:green" class="fa fa-users" aria-hidden="true"></i><strong> About Us</strong></div>
                <div class="panel-body"><p><?php echo $recored['co_about']; ?></p></div>
            </div>
            <div class="panel panel-default target">
                <div class="panel-heading" contenteditable="false"><i style="color:green" class="fa fa-users" aria-hidden="true"></i><strong> Our Primisses Photos</strong></div>
                <div class="panel-body">
                  <div class="row">

                  <?php
                    foreach ($photos as $value) {
                    ?>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <img alt="300x300" src="<?php echo base_url(); ?>file/photos/<?php echo $value->pp_image ?> " style="height:130px;width:240px;">
                                <div class="caption">
                                    <p>
                                        <?php echo $value->pp_name; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                  ?>
                     
            </div>
                 
        </div>
              
    </div>
           <div class="panel panel-default">
               <div class="panel-heading"><i style="color:green" class="fa fa-users" aria-hidden="true"></i><strong> Other Information of Services</strong></div>
                <div class="panel-body"><?php echo $recored['co_general']; ?></div>
</div></div>


            
        </div></div>
        <footer id="myFooter">
        <div class="second-bar">
           <div class="container">
                <h1 class="logo"><a href="#"> <?php echo ucfirst($recored['event_name']); ?>  </a></h1>
                <div class="social-icons"> 
                    <a href="<?php echo $recored['tw_link']; ?>" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a>
                    <a href="<?php echo $recored['fb_link']; ?>" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a>
                    <a href="<?php echo $recored['gg_link']; ?>" target="_blank" class="google"><i class="fa fa-google-plus"></i></a>
                </div>
            </div>
        </div>
    </footer>
        
    <script src="<?php echo base_url(); ?>_template/front/js/vendor/jquery-1.11.2.js"></script>
      <script src="<?php echo base_url(); ?>_template/front/js/vendor/bootstrap.min.js"></script>


    <script type="text/javascript">
        function add_messge()
        {
            var msg = $("#mmm").val();
            var m = msg.replace(/\s/g, ''); 
            if(!String(m) == false)
            {
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>index.php/front/add_msg",
                    data:{'msg':msg}
                }).done(function( msg ) {
                    $("#ccc").click();
                    alert('Successfully Add message !!');
                });
            }
            else
            {
                $("#mmm").focus();
            }
        }
    </script>  
    </body>
</html>

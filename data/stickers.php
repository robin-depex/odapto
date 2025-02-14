<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header" data-background-color="purple">
<h4 class="title">Add  Stickers</h4>
<p class="category">Add Stickers</p>
</div>

<div class="card-content">

<div class="row">
<div class="col-sm-12">
    <div class="col-sm-12">
	<div class="card-content">
	
	
	<div style="margin-top:30px" class="col-sm-6">

<input type="file" id="file" name="file" class="btn btn-primary" />
<button type="button" class="btn btn-primary pull-right" id="register">upload</button>
</div>
	
	</div>
	
	</div>
	
	</div>
</div>



<!-- add user form ends -->

</div>

</div>
</div>

</div>
</div> 
</div>


<script type="text/javascript">

$(document).ready(function (e) {
    alert('vinay');
    $('#register').on('click', function () {
       
                    var file_data = $('#file').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    
                      $.ajax({
                        url: 'temp/stickersupload.php', // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
                            
                            $('#msg').html(response); // display success response from the PHP script
                        },
                        error: function (response) {
                            $('#msg').html(response); // display error response from the PHP script
                        }
                    });


    });

});
</script>
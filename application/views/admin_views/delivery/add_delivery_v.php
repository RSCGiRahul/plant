<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Delivery
        <small>Manage Delivery</small>
    </h1>
    <ol class="breadcrumb woo-breadcrumb">
        <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		 <li><a class="active" href="<?php echo base_url('admin/delivery'); ?>"><i class="fa fa-cogs"></i> Manage Delivery</a></li> 
		 <li><a class="active" href="<?php echo base_url('admin/products'); ?>"><i class="fa fa-file-text-o"></i> Manage Products</a></li> 
    </ol>
</section>


<!-- Main content -->
<section class="content">
   <div class="box box-success">
      <div class="box-header with-border">
         <h3 class="box-title">Add Delivery</h3>
         <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
         </div>
      </div>
      <!-- form start -->
      <form role="form" name="add_form" action="<?php echo base_url('admin/delivery/create_delivery'); ?>" method="post" class="form-validation">
         <!--- Product Details  -->
         <div class="box-body">
             
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="delivery_name">Name</label>  
                     <input  type="text" name="delivery_name" value="" class="form-control required" id="delivery_name" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('delivery_name'); ?></span>
                  </div>
               </div>
			  </div> 
				
			 
				
				
			<div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="phone">Phone</label>  
                     <input  type="text" name="phone" value="" class="form-control required" id="phone" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('phone'); ?></span>
                  </div>
               </div>
			  </div> 



			<div class="row">
			   <div class="col-md-6">
				  <div class="form-group">
					 <label for="address">Address</label>  
					 <input  type="text" name="address" value="" class="form-control required geo-address2" id="address" placeholder=""> 
					 <span class="help-block error-message"><?php echo form_error('address'); ?></span>
				  </div>
			   </div>
			  </div> 		  


			<div class="row">
			   <div class="col-md-6">
				  <div class="form-group">
					 <label for="city">City</label>  
					 <input  type="text" name="city" value="" class="form-control required" id="assigned_city" placeholder=""> 
					 <span class="help-block error-message"><?php echo form_error('city'); ?></span>
				  </div>
			   </div>
			  </div> 		


			<div class="row">
			   <div class="col-md-6">
				  <div class="form-group">
					 <label for="zipcode">Zipcode</label>  
					 <input  type="text" name="zipcode" value="" class="form-control required" id="zipcode" placeholder=""> 
					 <span class="help-block error-message"><?php echo form_error('zipcode'); ?></span>
				  </div>
			   </div>
			  </div>			  
			 
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="publication_status">Publication Status</label>
						<select name="publication_status" class="form-control required" id="publication_status">
							<option value="" selected="" disabled="">Select one</option>
							<option value="1">Published</option>
							<option value="0">Unpublished</option>
						</select>
						<span class="help-block error-message"><?php echo form_error('publication_status'); ?></span>
					</div>
				</div>
			
			</div>
			
			
         </div>
         <!--- Product Details  -->
	 
         <div class="box-body">
            <div class="box-footer">
               <a href="<?php echo base_url('admin/delivery'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
               <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Info</button>
            </div>
         </div>
      </form>
      <!-- /.form -->
   </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/custom.js"></script>


<script type="text/javascript"> 
/*image upload*/

$(function() { 
        $(document).on("change", '.sortpicture14,.sortpicture2', function() {
          var id=this.id;
          var attrlisting=$("#"+id+"").attr("attr-listing");
          var fieldname=$("#"+id+"").attr("attr-name"); 
		  var singleImg=$("#"+id+"").attr("attr-singleImg"); 
		  
		  
          var file_data = $("#"+id+"").prop('files')[0];   
          var form_data = new FormData();      
		  
          form_data.append('file', file_data);
          form_data.append('attr-number', attrlisting);
          form_data.append('type', 'delivery');
          form_data.append('fieldname', ''+fieldname+'');
		  form_data.append('singleImg', ''+singleImg+'');
         
        $('#imgsr_error'+attrlisting+'').html('<p class="error">Uploading please wait..</p>');
		
        $.ajax({
            url: '<?php echo base_url('ajax/upload_image'); ?>', 
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(php_script_response){  
               var data = jQuery.parseJSON(php_script_response);  
               if(php_script_response!=""){ 
			   
				$("#sortpicture_"+attrlisting+"").val(''); 
			    $('#imgsr_error'+attrlisting+'').html('');
				
				 if(data['success']=='true'){ 
					var html = data['list']; 
					 $('#imagedata_'+attrlisting+'').html(html);
				 }else{
					$('#imgsr_error'+attrlisting+'').html(data['msg']);
				 }
				
            }
        }
    }); 
    });
    });

/*image upload*/
	 
</script>
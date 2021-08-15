<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Outlets
        <small>Manage Outlets</small>
    </h1>
    <ol class="breadcrumb woo-breadcrumb">
        <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		 <li><a class="active" href="<?php echo base_url('admin/outlet'); ?>"><i class="fa fa-cogs"></i> Manage Outlet</a></li> 
		 <li><a class="active" href="<?php echo base_url('admin/products'); ?>"><i class="fa fa-file-text-o"></i> Manage Products</a></li> 
    </ol>
</section>


<!-- Main content -->
<section class="content">
   <div class="box box-success">
      <div class="box-header with-border">
         <h3 class="box-title">Add Outlet</h3>
         <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
         </div>
      </div>
      <!-- form start -->
      <form role="form" name="add_form" action="<?php echo base_url('admin/outlet/create_outlet'); ?>" method="post" class="form-validation">
         <!--- Product Details  -->
         <div class="box-body">
             
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="product_name">Outlet Name</label>  
                     <input  type="text" name="outlet_name" value="" class="form-control required" id="outlet_name" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('outlet_name'); ?></span>
                  </div>
               </div>
			  </div>

				<div class="row">
				<div class="col-md-6">
				  <div class="form-group">
					 <label for="associated_delivery_id">Associated Delivery</label>   
					 <select name="associated_delivery_id" value="" class="form-control " id="associated_delivery_id" placeholder=""  > 		
								<option value=""> -Select Delivery- </option>
							
								<?php 
							   foreach ($associated_delivery as $v_associated_delivery){ 
								$opt=explode(",",$outlet_info['associated_delivery_id']);   
								$selected=''; 
								if (in_array($v_associated_delivery['delivery_id'], $opt)){
								  $selected='selected'; 
								}              
								?>
								<option <?php echo $selected; ?> value="<?php echo $v_associated_delivery['delivery_id']; ?>"><?php echo $v_associated_delivery['delivery_name']." (".$v_associated_delivery['city']." ".$v_associated_delivery['zipcode']." )"; ?></option> 
							  <?php } ?>   
								 
							 </select>
					 <span class="help-block error-message"><?php echo form_error('associated_delivery_id'); ?></span>
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
					 <input  type="text" name="address" value="" class="form-control required geo-address" id="address" placeholder=""> 
					 <span class="help-block error-message"><?php echo form_error('address'); ?></span>
				  </div>
			   </div>
			  </div> 		  


			<div class="row">
			   <div class="col-md-6">
				  <div class="form-group">
					 <label for="assigned_city">Assigned city</label>  
					 <input  type="text" name="assigned_city" value="" class="form-control required" id="assigned_city" placeholder=""> 
					 <span class="help-block error-message"><?php echo form_error('assigned_city'); ?></span>
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
				<div class="col-sm-3">
				<div class="form-group">
					<label for="lat">Latitude</label>
					<input type="text" class="form-control m-t-xxs" id="lat" name="lat" placeholder="" value="">
				</div>
				</div>
				
				<div class="col-sm-3">
				<div class="form-group">
					<label for="lng">Longitude</label>
					<input type="text" class="form-control m-t-xxs" id="lng" name="lng" placeholder="" value="">
				</div>
				</div>
				
				<div class="col-sm-2">
				<div class="form-group">
				 <label class="col-sm-12">&nbsp;</label>
				<a onclick="getLon();" href="javascript:;" class="btn btn-primary btn-Auto-Fetch">Auto Fetch</a>
				</div>
				</div> 
				
			</div>	
			
			<div class="row">
				<div class="col-sm-12">
					<p id="lat_long_msg"></p>
				</div>	
				
				<div id="map_canvas" class="col-sm-6" style="height:300px;">
				</div>
				
				
			</div>	
			
			
			

			<div class="row">
			   <div class="col-md-6">
				  <div class="form-group">
					 <label for="rating">Rating</label>  
					 <input  type="text" name="rating" value="" class="form-control " id="rating" placeholder=""> 
					 <span class="help-block error-message"><?php echo form_error('rating'); ?></span>
				  </div>
			   </div>
			  </div> 		  
				
			<div class="row">
			   <div class="col-md-6">
				  <div class="form-group">
					 <label for="reviews">Reviews</label>  
					 <input  type="text" name="reviews" value="" class="form-control " id="reviews" placeholder=""> 
					 <span class="help-block error-message"><?php echo form_error('reviews'); ?></span>
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
               <a href="<?php echo base_url('admin/outlet'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
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
          form_data.append('type', 'outlet');
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
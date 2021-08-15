<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Setting
        <small>General Setting</small>
    </h1>
    <ol class="breadcrumb woo-breadcrumb">
         <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		 <li><a class="active" href="<?php echo base_url('admin/setting'); ?>"><i class="fa fa-cogs"></i> General Setting</a></li> 
		 <li><a class="active" href="<?php echo base_url('admin/setting/homesetting'); ?>"><i class="fa fa-file-text-o"></i> Home page</a></li> 
    </ol>
</section>

 
 
 
<section class="content">
   <div class="box box-success">
      <div class="box-header with-border">
         <h3 class="box-title">General Setting</h3>
         <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
         </div>
      </div>
      <!-- form start -->
      
		<form role="form" name="add_form" action="<?php echo base_url('admin/setting/update_setting'); ?>" method="post" class="form-validation">
         <!--- Product Details  -->
         <div class="box-body">
             
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="site_name">Site Name</label>  
                     <input  type="text" name="site_name" value="<?php echo $general_info['site_name']; ?>" class="form-control required" id="site_name" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('site_name'); ?></span>
                  </div>
               </div> 
			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label for="email_address">Email Address</label>  
                     <input  type="email" name="email_address" value="<?php echo $general_info['email_address']; ?>" class="form-control required" id="email_address" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('email_address'); ?></span>
                  </div>
               </div>  
			   
			</div> 
			
			
			  
			  
			  <div  class="row" >
			  
				  <?php $imgid = 14; ?>
				  <div class="col-md-6">
					<div class="form-group">
					  <label for="sortpicture_<?php echo $imgid; ?>">Site Logo</label>
					  <input  id="sortpicture_<?php echo $imgid; ?>" type="file" name="sortpic<?php echo $imgid; ?>" class=" sortpicture<?php echo $imgid; ?> inputfile " attr-listing="<?php echo $imgid; ?>" attr-name="site_logo"  attr-singleImg="true"   />
					  <span id="imagedata_<?php echo $imgid; ?>"> 
						<?php
						$site_logo=$general_info['site_logo'];
						if($site_logo){
							$target_dir = "assets/uploads/";
							?>
							<div class="ajaximg"> <img src="<?php echo base_url()."/".$target_dir."".$general_info['site_logo']; ?>"><a href="javascript:;" class="delete delete-img " ><i class="fa fa-times-circle" aria-hidden="true"></i></a> <input type="hidden" value="<?php echo $general_info['site_logo']; ?>" name="site_logo"> </div>
						<?php } ?>
					  </span> 
					  <span id="imgsr_error<?php echo $imgid; ?>"> </span>
					  </span>  
				  </div>
				</div> 
				
				
				<?php $imgid = 2; ?>
				  <div class="col-md-6">
					<div class="form-group">
					  <label for="sortpicture_<?php echo $imgid; ?>">Favicon</label>
					  <input  id="sortpicture_<?php echo $imgid; ?>" type="file" name="sortpic<?php echo $imgid; ?>" class=" sortpicture<?php echo $imgid; ?> inputfile " attr-listing="<?php echo $imgid; ?>" attr-name="site_favicon"  attr-singleImg="true"   />
					  <span id="imagedata_<?php echo $imgid; ?>"> 
						<?php
						$site_favicon=$general_info['site_favicon'];
						if($site_favicon){
							$target_dir = "assets/uploads/";
							?>
							<div class="ajaximg"> <img src="<?php echo base_url()."/".$target_dir."".$general_info['site_favicon']; ?>"><a href="javascript:;" class="delete delete-img " ><i class="fa fa-times-circle" aria-hidden="true"></i></a> <input type="hidden" value="<?php echo $general_info['site_favicon']; ?>" name="site_favicon"> </div>
						<?php } ?>
					  </span> 
					  <span id="imgsr_error<?php echo $imgid; ?>"> </span>
					  </span>  
				  </div>
				</div>  
			  </div>
			
			<h3>Admin Setting</h3>
			<div class="row">
				<div class="col-md-6">
                  <div class="form-group">
                     <label for="to_email">Admin Email Address</label>  
                     <input  type="email" name="to_email" value="<?php echo $general_info['to_email']; ?>" class="form-control " id="to_email" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('to_email'); ?></span>
                  </div>
               </div>
			
			 </div>
			

			<h3>Contact details</h3>
			<div class="row">
				
				<div class="col-md-6">
                  <div class="form-group">
                     <label for="contact_email_address">Email Address</label>  
                     <input  type="email" name="contact_email_address" value="<?php echo $general_info['contact_email_address']; ?>" class="form-control " id="contact_email_address" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('contact_email_address'); ?></span>
                  </div>
               </div>
			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label for="phone_number">Phone number</label>  
                     <input  type="text" name="phone_number" value="<?php echo $general_info['phone_number']; ?>" class="form-control " id="phone_number" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('phone_number'); ?></span>
                  </div>
               </div>
			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label for="contact_address">Address</label>  
                     <input  type="text" name="contact_address" value="<?php echo $general_info['contact_address']; ?>" class="form-control " id="contact_address" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('contact_address'); ?></span>
                  </div>
               </div>
			
				<div class="col-md-6">
                  <div class="form-group">
                     <label for="copyright">Copyright</label>  
                     <input  type="text" name="copyright" value="<?php echo $general_info['copyright']; ?>" class="form-control " id="copyright" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('copyright'); ?></span>
                  </div>
               </div>
 
			
			</div>			
				
				
			<h3>Social Links</h3>
			<div class="row">
			
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="facebook">Facebook</label>  
                     <input  type="text" name="facebook" value="<?php echo $general_info['facebook']; ?>" class="form-control " id="facebook" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('facebook'); ?></span>
                  </div>
               </div> 
			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label for="twitter">Twitter</label>  
                     <input  type="text" name="twitter" value="<?php echo $general_info['twitter']; ?>" class="form-control " id="twitter" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('twitter'); ?></span>
                  </div>
               </div> 
			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label for="linkedin">Linkedin</label>  
                     <input  type="text" name="linkedin" value="<?php echo $general_info['linkedin']; ?>" class="form-control " id="linkedin" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('linkedin'); ?></span>
                  </div>
               </div>
			    
			</div> 	
			 
 
			<!------------------------------------>
			
			<h3>Product</h3>
			<div class="row">
			
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="delivery_radius">Delivery Radius (Distance)</label>  
                     <input  type="text" name="delivery_radius" value="<?php echo $general_info['delivery_radius']; ?>" class="form-control " id="delivery_radius" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('delivery_radius'); ?></span>
                  </div>
               </div> 
			   
			   <div class="col-md-4">
                  <div class="form-group">
                     <label for="delivery_price">Delivery Price</label>  
                     <input  type="text" name="delivery_price" value="<?php echo $general_info['delivery_price']; ?>" class="form-control " id="delivery_price" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('delivery_price'); ?></span>
                  </div>
               </div> 
			   
			   <div class="col-md-4">
                  <div class="form-group">
                     <label for="minimum_order">Minimum Order Price</label>  
                     <input  type="text" name="minimum_order" value="<?php echo $general_info['minimum_order']; ?>" class="form-control " id="minimum_order" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('minimum_order'); ?></span>
                  </div>
               </div> 
			    
			    
			</div> 	
			
			
			<!------------------------------------>
 
 
			
			
         </div>
         <!--- Product Details  -->
	 
         <div class="box-body">
            <div class="box-footer"> 
               <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
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
          /* form_data.append('type', 'price'); */
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
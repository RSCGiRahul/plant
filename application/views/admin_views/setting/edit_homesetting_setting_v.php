<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Home Setting
        <small>Manage Home Setting</small>
    </h1>
    <ol class="breadcrumb woo-breadcrumb">
         <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		 <li><a class="active" href="<?php echo base_url('admin/setting'); ?>"><i class="fa fa-cogs"></i> General Setting</a></li> 
		 <li><a class="active" href="<?php echo base_url('admin/setting/homesetting'); ?>"><i class="fa fa-file-text-o"></i> Home page</a></li> 
    </ol>
</section>


<!-- Main content -->
<section class="content">
   <div class="box box-success">
      <div class="box-header with-border">
         <h3 class="box-title">Add Home Content</h3>
         <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
         </div>
      </div>
      <!-- form start -->
      <form role="form" name="add_form" action="<?php echo base_url('admin/setting/update_homesetting/' . $setting_info['setting_id'] . ''); ?>" method="post" class="form-validation">
         <!--- Product Details  -->
         <div class="box-body">
             
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="type">Type</label>  
                     <select name="type"   class="form-control required" id="type" placeholder=""> 
						<option <?php if($setting_info['type']=='Slider'){ echo 'selected'; } ?> value="Slider">Slider</option>
						<option <?php if($setting_info['type']=='Content'){ echo 'selected'; } ?> value="Content">Content</option>
						<option <?php if($setting_info['type']=='Category'){ echo 'selected'; } ?> value="Category">Category</option>
						<option <?php if($setting_info['type']=='Product'){ echo 'selected'; } ?> value="Product">Product</option> 
					 </select>
                     <span class="help-block error-message"><?php echo form_error('type'); ?></span>
                  </div>
               </div>
			  </div> 
				
				
			<div class="row setting-div-1 ">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="category_type">Category Style Type</label>  
                     <select name="category_type" value="" class="form-control " id="category_type" placeholder=""> 
						<option value="" >Select one</option>
						<option <?php if($setting_info['category_type']=='Style-1'){ echo 'selected'; } ?> value="Style-1">Style 1</option>
						<option <?php if($setting_info['category_type']=='Style-2'){ echo 'selected'; } ?>  value="Style-2">Style 2</option>
						<option <?php if($setting_info['category_type']=='Style-3'){ echo 'selected'; } ?>  value="Style-3">Style 3</option>
						<option <?php if($setting_info['category_type']=='Style-4'){ echo 'selected'; } ?>  value="Style-4">Style 4</option> 
					 </select>
                     <span class="help-block error-message"><?php echo form_error('type'); ?></span>
                  </div>
               </div>
			  </div>
			  
			  
			  <div class="row setting-div-2">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="product_type">Product Type</label>  
                     <select name="product_type" value="" class="form-control " id="product_type" placeholder=""> 
						<option value="" >Select one</option>
						<option <?php if($setting_info['product_type']=='latest'){ echo 'selected'; } ?>   value="latest">Latest</option>
						<option  <?php if($setting_info['product_type']=='most_seller'){ echo 'selected'; } ?>  value="most_seller">Most Seller</option>
						<option  <?php if($setting_info['product_type']=='featured'){ echo 'selected'; } ?>  value="featured">Featured</option>
						<option  <?php if($setting_info['product_type']=='selected_category'){ echo 'selected'; } ?>  value="selected_category">Selected Category</option>
					 </select>
                     <span class="help-block error-message"><?php echo form_error('product_type'); ?></span>
                  </div>
               </div>
			  </div>
			  
			 
			  <div class="row setting-div-3">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="special_category">Select Category</label>  
                     <select name="special_category[]" value="" class="form-control select2" id="special_category" placeholder="" multiple="multiple"> 
					 <?php 
						$opt=json_decode($setting_info['special_category']);    
					   foreach ($categories_info as $v_category_info){  
						$selected=''; 
						if (in_array($v_category_info['category_id'], $opt)){
						  $selected='selected'; 
						}               
						?>
						<option <?php echo $selected; ?> value="<?php echo $v_category_info['category_id']; ?>"><?php echo $v_category_info['category_name']; ?></option> 
					  <?php } ?>   
						 
					 </select>
                     <span class="help-block error-message"><?php echo form_error('special_category'); ?></span>
                  </div>
               </div>
			  </div>
				
			<div class="row setting-div-4">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="title">Title</label>  
                     <input  type="text" name="title" value="<?php echo $setting_info['title']; ?>" class="form-control required" id="title" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('site_name'); ?></span>
                  </div>
               </div> 	
			</div>
				
			<div class="row setting-div-5">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="sort_order">Sort order</label>  
                     <input  type="text" name="sort_order" value="<?php echo $setting_info['sort_order']; ?>" class="form-control required" id="sort_order" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('sort_order'); ?></span>
                  </div>
               </div> 	
			</div>	
				
				
			
			<div class="row setting-div-6">
				<div class="col-md-12">
				  <div class="form-group">
					 <label for="seo_url">Description</label>  
					 <textarea id="content_message" rows="10" cols="100" class="form-control textarea required" name="description"><?php echo $setting_info['description']; ?></textarea>
					 <span class="help-block error-message"><?php echo form_error('description'); ?></span>
				  </div>
				</div>			
			</div>			
				
				
			<!------------ img -------------------->
				<div class="row setting-div-7">
				   <div class="">
					  <h4 class="box-header with-border">Slider Images</h4>
				   </div>
				</div>
				<div class="row setting-div-7">
					
					  <?php $imgid = 2; ?>
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="sortpicture_<?php echo $imgid; ?>">Slider Images</label>
						  <input  id="sortpicture_<?php echo $imgid; ?>" type="file" name="sortpic<?php echo $imgid; ?>" class=" sortpicture<?php echo $imgid; ?> inputfile " attr-listing="<?php echo $imgid; ?>" attr-name="slider_images"  attr-singleImg="false"   />
						  <span id="imagedata_<?php echo $imgid; ?>"> 
							
							<?php  
							$slider_images=json_decode($setting_info['slider_images']);
							foreach($slider_images as $slider_image){
								if($slider_image==""){ continue; }
							
							  
							
							?>
							<div class="ajaximg"> 
								<img src="/assets/uploads/<?php echo $slider_image; ?>"><a href="javascript:;" class="delete delete-img "  ><i class="fa fa-times-circle" aria-hidden="true"></i></a> <input type="hidden" value="<?php echo $slider_image; ?>" name="slider_images[]"> 
								 
							</div>
							<?php } ?>
							
						  </span> 
						  <span id="imgsr_error<?php echo $imgid; ?>"> </span>
						  </span>  
					  </div>
					</div> 
					
					
					
				</div>
			<!------------ img -------------------->	
				
			<div class="row">
				<div class="col-md-6">
				 <p><br></p>
				</div>
			</div>	
			
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="publication_status">Publication Status</label>
						<select name="publication_status" class="form-control required" id="publication_status">
							<option value="" selected="" disabled="">Select one</option>
							<option <?php if($setting_info['publication_status']=='1'){ echo 'selected'; } ?>  value="1">Published</option>
							<option <?php if($setting_info['publication_status']=='0'){ echo 'selected'; } ?>  value="0">Unpublished</option>
						</select>
						<span class="help-block error-message"><?php echo form_error('publication_status'); ?></span>
					</div>
				</div>
			
			</div>
			
			
         </div>
         <!--- Product Details  -->
	 
         <div class="box-body">
            <div class="box-footer">
               <a href="<?php echo base_url('admin/setting/homesetting'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
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

$(function() { 
	$(document).on("change", '#type', function() {
		
		var type = $(this).val();
		$(".setting-div-1,.setting-div-2,.setting-div-3,.setting-div-6,.setting-div-7").hide();
		
		if(type=='Slider'){
			$(".setting-div-7").show();
		}else if(type=='Content'){
			$(".setting-div-6").show();
			
		}else if(type=='Category'){	
			$(".setting-div-1,.setting-div-3").show();
		
		}else if(type=='Product'){	
			$(".setting-div-2,.setting-div-3").show();
		}else{
			
		}
		
		
	});
});
	 
setTimeout(function(){ $("#type").trigger('change'); }, 200);


$(function() { 
	$(".select2").select2();
});


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
					 $('#imagedata_'+attrlisting+'').append(html);
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
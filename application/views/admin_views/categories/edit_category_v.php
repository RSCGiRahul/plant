<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       <?php if ($category_id ) echo 'Sub'  ?>   Categories
        <small>Edit <?php if ($category_id ) echo 'Sub'  ?>  Category </small>
    </h1>
    <ol class="breadcrumb woo-breadcrumb">
        <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		 <li><a class="active" href="<?php echo base_url('admin/categories'); ?>"><i class="fa fa-cogs"></i> Manage  <?php if ($category_id ) echo 'Sub'  ?>  Categories</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit  <?php if ($category_id ) echo 'Sub'  ?>  Category </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>

        <!-- form start -->
        <form role="form" name="category_edit_form" action="<?php echo base_url('admin/categories/update_category/' . $category_info['category_id'] . ''); ?>" method="post" class="form-validation">
            <!-- /.box-header -->
			
			
		 <div class="box-body">	
		 
		<div class="row">
			<div class="col-md-12">
				<h3 class="box-title">Banner </h3>
			</div>
		</div>
				
		 
		<div class="row"> 
				
			  <?php $imgid = 14; ?>
			  <div class="col-md-12">
				<div class="form-group">
				  <label for="sortpicture_<?php echo $imgid; ?>">Background Banner Image</label>
				  <input  id="sortpicture_<?php echo $imgid; ?>" type="file" name="sortpic<?php echo $imgid; ?>" class=" sortpicture<?php echo $imgid; ?> inputfile " attr-listing="<?php echo $imgid; ?>" attr-name="category_banner"  attr-singleImg="true"   />
				  <span id="imagedata_<?php echo $imgid; ?>"> 
					<?php
					$category_banner=$category_info['category_banner'];
					if($category_banner){
						$target_dir = "assets/uploads/category/";
						?>
						<div class="ajaximg"> <img src="<?php echo base_url()."/".$target_dir."".$category_info['category_banner']; ?>"><a href="javascript:;" class="delete delete-img " ><i class="fa fa-times-circle" aria-hidden="true"></i></a> <input type="hidden" value="<?php echo $category_info['category_banner']; ?>" name="category_banner"> </div>
					<?php } ?>
				  </span> 
				  <span id="imgsr_error<?php echo $imgid; ?>"> </span>
				  </span>  
			  </div>
			</div> 
		
		
		
		<div class="col-md-12">
		  <div class="form-group">
			<label for="category_banner_heading">Heading</label>
			<textarea name="category_banner_heading" class="form-control" id="category_banner_heading" placeholder="Enter Heading"><?php echo $category_info['category_banner_heading']; ?></textarea>
			<span class="help-block error-message"></span>
		</div>
		</div>
		
		<div class="col-md-12">
			<div class="form-group">
			<label for="category_banner_desc">Banner Description</label>
			<textarea rows="6" name="category_banner_desc" class="form-control" id="category_banner_desc" placeholder="Enter Description"><?php echo $category_info['category_banner_desc']; ?></textarea>
			<span class="help-block error-message"></span>
			</div>
		</div> 

		</div>	
		</div>	
			
			<!-- category -->
		<hr>	
		
		<div class="box-body">
		<div class="row">
		<div class="col-md-12">
		<h3 class="box-title"> <?php if ($category_id ) echo 'Sub'  ?> Categories Details </h3>
		</div>
		</div>
		</div>
			<p>
			<br>
			</p>
			
               <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_name"> <?php if ($category_id ) echo 'Sub'  ?> Category Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input onblur="easyFriendlyUrl(this.value, 'seo_url');"  type="text" name="category_name" value="<?php echo $category_info['category_name']; ?>" class="form-control required" id="category_name" placeholder="Enter category name">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('category_name'); ?></span>
                        </div>
                    </div>
					
					<!-- /.col -->
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
					
					<input type="hidden" value="<?php echo $category_info['parent_id']; ?>" name="parent_id">
                    
					
					
					<?php $imgid = 2; ?>
					  <div class="col-md-12">
						<div class="form-group">
						  <label for="sortpicture_<?php echo $imgid; ?>">Image</label>
						  <input  id="sortpicture_<?php echo $imgid; ?>" type="file" name="sortpic<?php echo $imgid; ?>" class=" sortpicture<?php echo $imgid; ?> inputfile " attr-listing="<?php echo $imgid; ?>" attr-name="category_image"  attr-singleImg="true"   />
						  <span id="imagedata_<?php echo $imgid; ?>"> 
							<?php
							$category_image=$category_info['category_image'];
							if($category_image){
								$target_dir = "assets/uploads/category/";
								?>
								<div class="ajaximg"> <img src="<?php echo base_url()."/".$target_dir."".$category_info['category_image']; ?>"><a href="javascript:;" class="delete delete-img " ><i class="fa fa-times-circle" aria-hidden="true"></i></a> <input type="hidden" value="<?php echo $category_info['category_image']; ?>" name="category_image"> </div>
							<?php } ?>
						  </span> 
						  <span id="imgsr_error<?php echo $imgid; ?>"> </span>
						  </span>  
					  </div>
					</div> 
					
					 
					 
					 
					
					<?php if($category_info['parent_id']=="0"){ ?>
					
					 <div class="col-md-6">
                        <div class="form-group">
                            <label for="featured">Featured</label>
                            <div class="input-group">                               
                                <input type="checkbox" name="featured" value="1" <?php if($category_info['featured']==1){ echo 'checked'; } ?>  id="featured">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('featured'); ?></span>
                        </div>
                    </div>
					
					<?php }else{ ?>
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="featured">Father Category</label>
                            <div class="input-group">     
								   <?php echo $parent_category_info['category_name'] ; ?>

                            </div>
                             
                        </div>
                    </div>
					
					<?php } ?>
					
					 <div class="clearfix"></div> 
					
                    <!-- /.col -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Enter category description" rows="4"><?php echo $category_info['description']; ?></textarea>
                            <span class="help-block error-message"><?php echo form_error('description'); ?></span>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
				
				
				<div class="row">
					<h4 class="col-md-12">SEO Center</h4> 
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="seo_title">Page Title</label>  
                                <input type="text" name="seo_title" value="<?php echo $category_info['seo_title']; ?>" class="form-control required" id="seo_title" placeholder=""> 
								<span class="help-block error-message"><?php echo form_error('seo_title'); ?></span>
                        </div>
                    </div> 
					 
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="seo_url">Friendly Title</label>  
                                <input onblur="easyFriendlyUrl(this.value, 'seo_url');"  type="text" name="seo_url" value="<?php echo $category_info['seo_url']; ?>" class="form-control required" id="seo_url" placeholder=""> 
								<span class="help-block error-message"><?php echo form_error('seo_url'); ?></span>
                        </div>
                    </div>
					
					<div class="col-md-6">
                        <div class="form-group c-p-related">
                            <label for="seo_meta_keywords">Meta Keywords</label>  
                                <input type="text" name="seo_meta_keywords" value="<?php echo $category_info['seo_meta_keywords']; ?>" class="form-control tagsinput" id="seo_meta_keywords" placeholder="" data-role="tagsinput" > 
								<div class="tags-btn"></div>
								<span class="help-block error-message"><?php echo form_error('seo_meta_keywords'); ?></span>
                        </div>
                    </div>
					
					<!-- /.col -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="seo_meta_description">Meta Description <small>(250 characters)</small></label>
                            <textarea name="seo_meta_description" class="form-control" id="seo_meta_description"  maxlength="250" rows="4"><?php echo $category_info['seo_meta_description']; ?></textarea>
                            <span class="help-block error-message"><?php echo form_error('seo_meta_description'); ?></span>
                        </div>
                    </div> 
				
				</div> 
				
            </div>
           
			
			
			<div class="box-footer">
                <a href="<?php echo base_url('directory/categories'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                 <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
            </div>
        </form>
        <!-- /.form -->
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    document.forms['category_edit_form'].elements['publication_status'].value = '<?php echo $category_info['publication_status']; ?>'; 
	 	

		
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
          form_data.append('type', 'category');
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
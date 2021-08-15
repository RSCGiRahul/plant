<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Categories
        <small>Edit Category </small>
    </h1>
    <ol class="breadcrumb woo-breadcrumb">
        <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		 <li><a class="active" href="<?php echo base_url('admin/categories'); ?>"><i class="fa fa-cogs"></i> Manage Categories</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Category </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>

        <!-- form start -->
        <form role="form" name="category_edit_form" action="<?php echo base_url('admin/catfilter/update_filter/' . $category_info['category_id'] . ''); ?>" method="post" class="form-validation">
            <!-- /.box-header -->
			
		 
               <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text"   value="<?php echo $category_info['category_name']; ?>" class="form-control required" id="category_name"  readonly>
                            </div>
                            <span class="help-block error-message"><?php echo form_error('category_name'); ?></span>
                        </div>
                    </div>
					
					<!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="publication_status">Publication Status</label>
                            <select   class="form-control required" id="publication_status" readonly >
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
						  <br><div class="clearfix"></div>
						  
						  <span id="imagedata_<?php echo $imgid; ?>"> 
							<?php
							$category_image=$category_info['category_image'];
							if($category_image){
								$target_dir = "assets/uploads/category/";
								?>
								<div class="ajaximg"> <img src="<?php echo base_url()."/".$target_dir."".$category_info['category_image']; ?>">  <input type="hidden" value="<?php echo $category_info['category_image']; ?>" name="category_image"> </div>
							<?php } ?>
						  </span> 
						  <span id="imgsr_error<?php echo $imgid; ?>"> </span>
						  </span>  
					  </div>
					</div>  
					
					 <div class="clearfix"></div>  
                </div>
                <!-- /.row -->
				
				
				<div class="row">
					<h4 class="col-md-12">Filter</h4> 
					
				  
					
					<!-- /.col -->
                    <div class="col-md-12">
                        <div class="form-group">
                            
							<label for="product_category">Select Brand</label>  
							 <select name="filter_brand[]" value="" class="form-control select2" id="filter_brand" placeholder="" multiple="multiple"> <?php 
							   foreach ($brand_info as $v_brand_info){ 
								$opt=explode(",",$category_info['filter_brand']);   
								$selected=''; 
								if (in_array($v_brand_info['brand_id'], $opt)){
								  $selected='selected'; 
								}              
								?>
								<option <?php echo $selected; ?> value="<?php echo $v_brand_info['brand_id']; ?>"><?php echo $v_brand_info['brand_name']; ?></option> 
							  <?php } ?>   
								 
							 </select>
							
							
							
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
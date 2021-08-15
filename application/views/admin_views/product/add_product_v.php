<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Product
      <small>Add Product</small>
   </h1>
   <ol class="breadcrumb woo-breadcrumb">
      <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a class="active" href="<?php echo base_url('admin/categories'); ?>"><i class="fa fa-cogs"></i> Manage Categories</a></li>
      <li><a class="active" href="<?php echo base_url('admin/products'); ?>"><i class="fa fa-file-text-o"></i> Manage Products</a></li>
   </ol>
</section>


<?php 
$Product_Attribute_Option = '';
foreach($Product_Attribute as $Product_Attribute_v){
	$Product_Attribute_Option .= '<option value="'.$Product_Attribute_v['attribute_id'].'">'.$Product_Attribute_v['attribute_name'].'</option>';  
}


$Price_Option_Option = '';
foreach($Price_Option as $Price_Option_v){
	$Price_Option_Option .= '<option value="'.$Price_Option_v['price_id'].'">'.$Price_Option_v['price_name'].'</option>';  
}
?>

<!-- Main content -->
<section class="content">
   <div class="box box-success">
      <div class="box-header with-border">
         <h3 class="box-title">Add Product</h3>
         <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
         </div>
      </div>
      <!-- form start -->
      <form role="form" name="add_form" action="<?php echo base_url('admin/products/create_product'); ?>" method="post" class="form-validation">
         <!--- Product Details  -->
         <div class="box-body">
            <div class="row">
               <div class="">
                  <h4 class="box-header with-border">Basic Information</h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="product_name">Product Name</label>  
                     <input onblur="easyFriendlyUrl(this.value, 'seo_url');" type="text" name="product_name" value="" class="form-control required" id="product_name" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('product_name'); ?></span>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="seo_url">Friendly Title (SEO URL)</label>  
                     <input onblur="easyFriendlyUrl(this.value, 'seo_url');" type="text" name="seo_url" value="" class="form-control required valid" id="seo_url" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('seo_url'); ?></span>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <label for="seo_url">Description</label>  
                     <textarea id="content_message" rows="10" cols="100" class="form-control textarea required" name="description"></textarea>
                     <span class="help-block error-message"><?php echo form_error('description'); ?></span>
                  </div>
               </div>
            </div>
			
			<div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="product_category">Select Category</label>  
                     <select name="product_category[]" value="" class="form-control select2" id="product_category" placeholder="" multiple="multiple"> <?php 
					  foreach (array_filter($categories_info, function ($value) {
					   		return $value['parent_id'] == 0;
					   	})  as $v_category_info){ 
						$opt=explode(",",set_value('product_category'));   
						$selected=''; 
						/* if (in_array($v_category_info['category_id'], $opt)){
						  $selected='selected'; 
						}  */               
						?>
						<option <?php echo $selected; ?> value="<?php echo $v_category_info['category_id']; ?>"><?php echo $v_category_info['category_name']; ?></option> 
					  <?php } ?>   
						 
					 </select>
                     <span class="help-block error-message"><?php echo form_error('special_category'); ?></span>
                  </div>
               </div>

              <?php include('vendor/_subcategory.php'); ?>

			  </div>
			  
			  <div class="row">
               <div class="col-md-12">
                  <div class="form-group">
                     <label for="product_category">Select Brand</label>  
                     <select name="brand_id" value="" class="form-control " id="brand_id" placeholder="" > 
					 <option value="">Select one</option>
					 <?php 
					   foreach ($brand_info as $v_brand_info){ 
						$opt=explode(",",$product_info['brand_id']);   
						$selected=''; 
						/* if (in_array($v_brand_info['brand_id'], $opt)){
						  $selected='selected'; 
						} */              
						?>
						<option <?php echo $selected; ?> value="<?php echo $v_brand_info['brand_id']; ?>"><?php echo $v_brand_info['brand_name']; ?></option> 
					  <?php } ?>   
						 
					 </select>
                     <span class="help-block error-message"><?php echo form_error('brand_id'); ?></span>
                  </div>
               </div>
			  </div>
			  
			  
			  <div class="row">
				<div class="col-md-12">
				 <label for="Dimensions">Dimensions (L x W x H)</label>  
				 </div>
                <div class="col-md-4">
                  <div class="form-group">
                     <input   type="text" name="dimensions_length" value="" class="form-control " id="dimensions_length" placeholder="Dimensions Length"> 
                     <span class="help-block error-message"><?php echo form_error('dimensions_length'); ?></span>
                  </div>
               </div>
			   
			   <div class="col-md-4">
                  <div class="form-group">
                     <input   type="text" name="dimensions_width" value="" class="form-control " id="dimensions_width" placeholder="Dimensions Width"> 
                     <span class="help-block error-message"><?php echo form_error('dimensions_width'); ?></span>
                  </div>
               </div>
			   
			   <div class="col-md-4">
                  <div class="form-group">
                     <input   type="text" name="dimensions_height" value="" class="form-control " id="dimensions_height" placeholder="Dimensions Height"> 
                     <span class="help-block error-message"><?php echo form_error('dimensions_height'); ?></span>
                  </div>
               </div>
			  </div>
			  
			  <div class="row">
				<div class="col-md-4">
				  <div class="form-group">
					  <label for="weight">Weight</label>  
					 <input   type="text" name="weight" value="" class="form-control " id="weight" placeholder="Weight"> 
					 <span class="help-block error-message"><?php echo form_error('weight'); ?></span>
				  </div>
			   </div>
			  </div>
			
			
         </div>
         <!--- Product Details  -->
		 
		 
		<!--- Product Gallery  -->
		<div class="box-body">
            <div class="row">
               <div class="">
                  <h4 class="box-header with-border">Product Images</h4>
               </div>
            </div>
            <div class="row">
				
				  <?php $imgid = 1; ?>
				  <div class="col-md-12 product-img-listing">
					<div class="form-group">
					  <label for="sortpicture_<?php echo $imgid; ?>">Product Images</label>
					  <input  id="sortpicture_<?php echo $imgid; ?>" type="file" name="sortpic<?php echo $imgid; ?>" class="product-images  inputfile " attr-listing="<?php echo $imgid; ?>" attr-name="product_images"  attr-singleImg="true"   />
					  <span id="imagedata_<?php echo $imgid; ?>"> 
					  </span> 
					  <span id="imgsr_error<?php echo $imgid; ?>"> </span>
							
					  </span>  
				  </div>
				</div> 
				
				
				
			</div>
		</div>
		<!--- Product Gallery  -->
		 
		 
		 <!------ Product Attribute -------->
		 <div class="box-body">
            <div class="row">
               <div class="">
                  <h4 class="box-header with-border">Product Attribute</h4>
               </div>
            </div>
            <div class="row">
			<div class="col-sm-12">
			
					<!------ table ---->  
				<div class="table-responsive">
					<table id="attribute" class="table table-striped table-bordered table-hover">
					  <thead>
						<tr>
						  <td class="text-left">Attribute</td>
						  <td class="text-left">Text</td>
						  <td></td>
						</tr>
					  </thead>
					  <tbody>
							
							<tr id="attribute-row0" data-row="0" >
								<td class="text-left" style="width: 40%;"> 
									<select  name="product_attribute[0][product_attribute_name]" value="" placeholder="Attribute" class="form-control" autocomplete="off">
									  <?php 
									  echo $Product_Attribute_Option;
									  ?>
									</select>
									
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="product_attribute[0][sorting]" rows="5" placeholder="Sorting" class="form-control" value="">
									</div>
								</td>
							
								<td class="text-left">
									<div class=""><textarea name="product_attribute[0][product_attribute_description]" rows="5" placeholder="Text" class="form-control"></textarea>
									</div>
								</td>
								
								<td class="text-right"><button type="button" onclick="$('#attribute-row0').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
							</tr>

						</tbody>

					  <tfoot>
						<tr>
						  <td colspan="2"></td>
						  <td class="text-right"><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Attribute"><i class="fa fa-plus-circle"></i></button></td>
						</tr>
					  </tfoot>
					</table>
				  </div>
				
					<!------ table ---->
			</div>
			</div>
		</div>	
		 
		 <!------ Product Attribute -------->
		 
		 
		 <!------ Retail Price -------->
		 
		 <div class="box-body">
		 
            <div class="row">
               <div class="">
                  <h4 class="box-header with-border">Retail Price</h4>
               </div>
            </div>
            <div class="row">
			
               <div class="col-md-4">	
				  <div class="form-group">
                     <label for="price">Price</label>  
                     <input type="text" name="price" value="<?php echo set_value('price'); ?>" class="form-control " id="price" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('price'); ?></span>
                  </div> 
			   </div>
			   
			   <div class="col-md-4">	
				  <div class="form-group">
                     <label for="discount">Discount(%)</label>  
                     <input type="text" name="discount" value="<?php echo set_value('discount'); ?>" class="form-control " id="discount" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('discount'); ?></span>
                  </div> 
			   </div>
			   
			   <div class="col-md-4">	
				  <div class="form-group">
                     <label for="discount_price">New Price</label>  
                     <input type="text" name="discount_price" value="<?php echo set_value('discount_price'); ?>" class="form-control " id="new_price" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('discount_price'); ?></span>
                  </div> 
			   </div>
			</div>
			
			<!------ Price option -------->
			
			<div class="row">
               <div class="">
                  <h4 class="box-header with-border">Retail Price Option</h4>
               </div>
            </div>
			
			<div class="row">
			<div class="col-sm-12">
				
				<div class="table-responsive">
					<table id="WholeSalePriceOption" class="table table-striped table-bordered table-hover">
					  <thead>
						<tr>
						  <td class="text-left">Option Value</td>
						  <td class="text-left">Sorting</td>
						  <td class="text-left">Price</td>
						  <td class="text-left">Discount %</td>
						  <td>Discount Price</td>
						</tr>
					  </thead>
					  <tbody>
							
							<tr id="priceoption-row0" data-row="0" >
								<td class="text-left" style="width: 40%;">  
									<input type="text" name="price_option[0][name]" rows="5" placeholder="Name" class="form-control" value="">
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="wholesale_price_option[0][sorting]"   placeholder="Sorting" class="form-control" value="">
									</div>
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="wholesale_price_option[0][price]"   placeholder="Price" class="form-control wholesale_changePr" value="">
									</div>
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="wholesale_price_option[0][discount]" rows="5" placeholder="Discount" class="form-control wholesale_changePr"   value="">
									</div>
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="wholesale_price_option[0][discount_price]"   placeholder="Discount Price" class="form-control wholesale_changePr" value="">
									</div>
								</td>
								
								<td class="text-right"><button type="button" onclick="$('#priceoption-row0').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
							</tr>

						</tbody>

					  <tfoot>
						<tr>
						  <td colspan="4"></td>
						  <td class="text-right"><button type="button" onclick="addWholeSalePriceOption();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Price Option"><i class="fa fa-plus-circle"></i></button></td>
						</tr>
					  </tfoot>
					</table>
				  </div>
				
			</div>
			</div>
			
			<!------ Price option-------->
				

		</div>	
		 <!------ Retails Price ENd  -------->
		


		 <!------Whoel Sale Price -------->
		 
		 <div class="box-body">
		 
            <div class="row">
               <div class="">
                  <h4 class="box-header with-border">Whole Sale Price <span style="margin-left:20px"> <input type ="checkbox" name ="is_whole_sale" onclick="toggleWholeSaleClass(this)" /></span></h4>

               </div>
            </div>
            <div class="wholesale_price_row hidden">
            <div class="row " >
			
               <div class="col-md-4">	
				  <div class="form-group">
                     <label for="wholesale_price">Price</label>  
                     <input type="text" name="wholesale_price" value="<?php echo set_value('wholesale_price'); ?>" class="form-control " id="wholesale_price" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('wholesale_price'); ?></span>
                  </div> 
			   </div>
			   
			   <div class="col-md-4">	
				  <div class="form-group">
                     <label for="wholesale_discount">Discount(%)</label>  
                     <input type="text" name="wholesale_discount" value="<?php echo set_value('wholesale_discount'); ?>" class="form-control " id="wholesale_discount" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('wholesale_discount'); ?></span>
                  </div> 
			   </div>
			   
			   <div class="col-md-4">	
				  <div class="form-group">
                     <label for="wholesale_discount_price">New Price</label>  
                     <input type="text" name="wholesale_discount_price" value="<?php echo set_value('wholesale_discount_price'); ?>" class="form-control " id="wholesale_new_price" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('wholesale_discount_price'); ?></span>
                  </div> 
			   </div>
			</div>
			
			<!------ Price option -------->
			
			<div class="row">
               <div class="">
                  <h4 class="box-header with-border">Price Option</h4>
               </div>
            </div>
			
			<div class="row">
			<div class="col-sm-12">
				
				<div class="table-responsive">
					<table id="PriceOption" class="table table-striped table-bordered table-hover">
					  <thead>
						<tr>
						  <td class="text-left">Option Value</td>
						  <td class="text-left">Sorting</td>
						  <td class="text-left">Price</td>
						  <td class="text-left">Discount %</td>
						  <td>Discount Price</td>
						</tr>
					  </thead>
					  <tbody>
							
							<tr id="wholesale_priceoption-row0" data-row="0" >
								<td class="text-left" style="width: 40%;">  
									<input type="text" name="wholesale_price_option[0][name]" rows="5" placeholder="Name" class="form-control" value="">
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="wholesale_price_option[0][sorting]"   placeholder="Sorting" class="form-control" value="">
									</div>
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="wholesale_price_option[0][price]"   placeholder="Price" class="form-control changePr" value="">
									</div>
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="wholesale_price_option[0][discount]" rows="5" placeholder="Discount" class="form-control changePr"   value="">
									</div>
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="wholesale_price_option[0][discount_price]"   placeholder="Discount Price" class="form-control changePr" value="">
									</div>
								</td>
								
								<td class="text-right"><button type="button" onclick="$('#priceoption-row0').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
							</tr>

						</tbody>

					  <tfoot>
						<tr>
						  <td colspan="4"></td>
						  <td class="text-right"><button type="button" onclick="addPriceOption();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Price Option"><i class="fa fa-plus-circle"></i></button></td>
						</tr>
					  </tfoot>
					</table>
				  </div>
				
			</div>
			</div>
			</div> 	<!------ wholesale_price_row-------->
			<!------ Price option-------->
				

		</div>	
		 <!------ End of Whole salePrice -------->

          <!------ SEO Center -------->
         <div class="box-body">
            <div class="row">
               <div class="">
                  <h4 class="box-header with-border">SEO Center</h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="seo_title">Page Title</label>  
                     <input type="text" name="seo_title" value="<?php echo set_value('seo_title'); ?>" class="form-control " id="seo_title" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('seo_title'); ?></span>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group c-p-related">
                     <label for="seo_meta_keywords">Meta Keywords</label>  
                     <input type="text" name="seo_meta_keywords" value="<?php echo set_value('seo_meta_keywords'); ?>" class="form-control tagsinput" id="seo_meta_keywords" placeholder="" data-role="tagsinput" > 
                     <div class="tags-btn"></div>
                     <span class="help-block error-message"><?php echo form_error('seo_meta_keywords'); ?></span>
                  </div>
               </div>
               <!-- /.col -->
               <div class="col-md-12">
                  <div class="form-group">
                     <label for="seo_meta_description">Meta Description <small>(250 characters)</small></label>
                     <textarea name="seo_meta_description" class="form-control" id="seo_meta_description"  maxlength="250" rows="4"><?php echo set_value('seo_meta_description'); ?></textarea>
                     <span class="help-block error-message"><?php echo form_error('seo_meta_description'); ?></span>
                  </div>
               </div>
            </div>
         </div>
         <!------ SEO Center -------->
         <div class="box-body">
            <div class="box-footer">
               <a href="<?php echo base_url('directory/categories'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
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

  /*Attribute*/
  
  function addAttribute() {
	   
	  var attribute_row = $("#attribute  tbody tr:last-child").attr('data-row');
	      
		  
		if(isNaN(attribute_row)) {
		  attribute_row = 1;
		}
		attribute_row++;

	  
		html = '<tr id="attribute-row' + attribute_row + '"   data-row="' + attribute_row + '"  >';
			html += '<td class="text-left" style="width: 40%;">';
				
				/* html += '<input type="text" name="product_attribute[' + attribute_row + '][product_attribute_name]" value="" placeholder="Attribute" class="form-control" autocomplete="off">'; */
				html += '<select  name="product_attribute[' + attribute_row + '][product_attribute_name]" value="" placeholder="Attribute" class="form-control" autocomplete="off" ><?php echo $Product_Attribute_Option;  ?></select>'; 
				
				
			html += '</td>';

	
			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="product_attribute[' + attribute_row + '][sorting]" rows="5" placeholder="Sorting" class="form-control">';
			html += '</td>';
	
			html += '<td class="text-left">';
				html += '<div class=""><textarea name="product_attribute[' + attribute_row + '][product_attribute_description]" rows="5" placeholder="Text" class="form-control"></textarea>';
			html += '</td>';
		
			html += '<td class="text-right">';
				html += '<button type="button" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>';
			html += '</td>';


		html += '</tr>';

	  $('#attribute tbody').append(html); 

	  /* attributeautocomplete(attribute_row); */

	  
  }
  
  /*Attribute*/
  
  /*Attribute price option*/
  function toggleWholeSaleClass (e) {
		// e.checked
		$('.wholesale_price_row').toggleClass('hidden');
	}

  function addPriceOption() {
	   
	  var attribute_row = $("#PriceOption  tbody tr:last-child").attr('data-row');  
		  if(isNaN(attribute_row)) {
			attribute_row = 1;
		}
		attribute_row++;
		 
	  
		html = '<tr id="priceoption-row' + attribute_row + '"  data-row="' + attribute_row + '" >';
			html += '<td class="text-left" style="width: 40%;">';
				html += '<input type="text" name="price_option[' + attribute_row + '][name]" value="" placeholder="Price Option Value" class="form-control" autocomplete="off">'; 
				
				/* html += '<select  name="price_option[' + attribute_row + '][name]" value="" placeholder="Attribute" class="form-control" autocomplete="off" ><?php echo $Price_Option_Option;  ?></select>';  */ 
				
			html += '</td>';
			
			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="price_option[' + attribute_row + '][sorting]" rows="5" placeholder="Sorting" class="form-control">';
			html += '</td>';

			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="price_option[' + attribute_row + '][price]" rows="5" placeholder="Price" class="form-control changePr">';
			html += '</td>';
			
			
			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="price_option[' + attribute_row + '][discount]" rows="5" placeholder="Discount" class="form-control changePr">';
			html += '</td>';
			
			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="price_option[' + attribute_row + '][discount_price]" rows="5" placeholder="Discount Price" class="form-control changePr">';
			html += '</td>';
			
		
			html += '<td class="text-right">';
				html += '<button type="button" onclick="$(\'#priceoption-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>';
			html += '</td>';


		html += '</tr>';

	  $('#PriceOption tbody').append(html); 
	  
  }

   function addWholeSalePriceOption() {
	   
	  var attribute_row = $("#PriceOption  tbody tr:last-child").attr('data-row');  
		  if(isNaN(attribute_row)) {
			attribute_row = 1;
		}
		attribute_row++;
		 
	  
		html = '<tr id="priceoption-row' + attribute_row + '"  data-row="' + attribute_row + '" >';
			html += '<td class="text-left" style="width: 40%;">';
				html += '<input type="text" name="wholesale_price_option[' + attribute_row + '][name]" value="" placeholder="Price Option Value" class="form-control" autocomplete="off">'; 
				
				/* html += '<select  name="wholesale_price_option[' + attribute_row + '][name]" value="" placeholder="Attribute" class="form-control" autocomplete="off" ><?php echo $wholesale_Price_Option_Option;  ?></select>';  */ 
				
			html += '</td>';
			
			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="wholesale_price_option[' + attribute_row + '][sorting]" rows="5" placeholder="Sorting" class="form-control">';
			html += '</td>';

			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="wholesale_price_option[' + attribute_row + '][price]" rows="5" placeholder="Price" class="form-control changePr">';
			html += '</td>';
			
			
			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="wholesale_price_option[' + attribute_row + '][discount]" rows="5" placeholder="Discount" class="form-control changePr">';
			html += '</td>';
			
			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="wholesale_price_option[' + attribute_row + '][discount_price]" rows="5" placeholder="Discount Price" class="form-control changePr">';
			html += '</td>';
			
		
			html += '<td class="text-right">';
				html += '<button type="button" onclick="$(\'#wholesale_priceoption-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>';
			html += '</td>';


		html += '</tr>';

	  $('#WholeSalePriceOption tbody').append(html); 
	  
  }
  
  /*Attribute price option*/
  

/*image upload*/

$(function() { 
	$(document).ready( function() {
		$(".select2").select2();		
	});

	

	$("#product_category").on('select2:select', function(e) {
		$(".category_"+ e.params.data.id).toggleClass('hidden');
	});

	$("#product_category").on('select2:unselect', function(e) {
		$(".category_"+ e.params.data.id).toggleClass('hidden');
	});

        $(document).on("change", '.product-images', function() {
          var id=this.id;
          var attrlisting=$("#"+id+"").attr("attr-listing");
          var fieldname=$("#"+id+"").attr("attr-name"); 
		  var singleImg=$("#"+id+"").attr("attr-singleImg"); 
		  
		  
          var file_data = $("#"+id+"").prop('files')[0];   
          var form_data = new FormData();      
		  
          form_data.append('file', file_data);
          form_data.append('attr-number', attrlisting);
          form_data.append('type', 'product');
          form_data.append('fieldname', ''+fieldname+'');
		  form_data.append('singleImg', ''+singleImg+'');
         
        $('#imgsr_error'+attrlisting+'').html('<p class="error">Uploading please wait..</p>');
		
        $.ajax({
            url: '<?php echo base_url('ajax/upload_product_image'); ?>', 
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


 $(function() { 
  $(document).on("change", '.col-is-featured', function() {
    var variable = $('input[name=gallery_featured]:checked').val(); 
    if (typeof variable  != 'undefined') {
      $('.col-is-featured').prop('checked', false);
      $(this).prop('checked', true);
    }
  })
  
  $(document).on("change", '.col-is-featured-mobile', function() {
    var variable = $('input[name=gallery_featured_mobile]:checked').val(); 
    if (typeof variable  != 'undefined') {
      $('.col-is-featured-mobile').prop('checked', false);
      $(this).prop('checked', true);
    }
  }) 
  
});


 $(function() { 
  $(document).on("change", '#price,#discount', function() {
	  var original_price = $("#price").val();
	  var discount = $("#discount").val();
	  var new_price = $("#new_price").val();
	  
	  var discounted_price = original_price - (original_price * discount / 100)
	  $("#new_price").val(discounted_price);
	  
  })
  

  $(document).on("change", '#PriceOption input.changePr', function() {
	  var name =   $(this).attr('name');
	 name =  name.match(/\d+/); 
	 
	  var original_price = $("input[name='price_option["+name+"][price]']").val(); 
	  var discount = $("input[name='price_option["+name+"][discount]']").val();
	  var new_price = $("input[name='price_option["+name+"][discount_price]']").val();
	  
	  var discounted_price = original_price - (original_price * discount / 100);
	  var discounted_price = discounted_price.toFixed(2);
	  $("input[name='price_option["+name+"][discount_price]']").val(discounted_price);
	  
	  
  })
  
  
});	



	 
</script>
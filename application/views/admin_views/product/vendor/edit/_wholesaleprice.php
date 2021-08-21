


            <div class="row">
               <div class="">
                   <h4 class="box-header with-border">Whole Sale Price <span style="margin-left:20px"> <input type ="checkbox" name ="is_whole_sale" checked="<?php echo $product_info['is_whole_sale']; ?>" onclick="toggleWholeSaleClass(this)" /></span></h4>
               </div>
            </div>

        <div class="wholesale_price_row <?php $product_info['is_whole_sale']? ' ' : ' hidden' ?>">
        	<?php
	foreach($wholesale_price['wholesale_price_attribute'] ?? [] as $key =>  $wholesale_price_){
		$key;
								$wholesale_price  = (array) $wholesale_price_;
						
        	?>
            <div class="row">
			<div class="col-md-1">	
                     <input type="checkbox" name="wholesale_price[<?php echo $key; ?>]" checked> 
			   </div>

               <div class="col-md-3">	
				  <div class="form-group">
                     <label for="price">MRP</label>  
                     <input type="text" 
                     	name="wholesale_price[<?php echo $key; ?>][mrp]" 
                     	value="<?php echo $wholesale_price['mrp']; ?>" class="form-control wholesale_changePr" id="wholesale_mrp_<?php echo $i; ?>" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('wholesale_mrp'); ?></span>
                  </div> 
			   </div>

               <div class="col-md-3">	
				  <div class="form-group">
                     <label for="price">DP</label>  
                     <input type="text" name="wholesale_price[<?php echo $key; ?>][dp]" value="<?php echo $wholesale_price['dp']; ?>" class="form-control wholesale_changePr" id="price" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('price'); ?></span>
                  </div> 
			   </div>
			   
			   <div class="col-md-3">	
				  <div class="form-group">
                     <label for="discount">Discount(%)</label>  
                     <input type="text" name="wholesale_price[<?php echo $key; ?>][discount]" value="<?php echo $wholesale_price['discount']; ?>" class="form-control wholesale_changePr" id="discount" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('discount'); ?></span>
                  </div> 
			   </div>
			   
			   <div class="col-md-2">	
				  <div class="form-group">
                     <label for="discount_price">New Price</label>  
                     <input type="text" name="wholesale_price[<?php echo $key; ?>][price]" value="<?php echo $wholesale_price['price']; ?>" class="form-control wholesale_changePr" id="new_price" placeholder=""> 
                     <span class="help-block error-message"><?php echo form_error('discount_price'); ?></span>
                  </div> 
			   </div>
			</div>
			<?php } ?>
			<!------ Price option -------->
			
	
			
		
		</div>	

			
<script type="text/javascript">
	
  /*Attribute price option*/
  function toggleWholeSaleClass (e) {
		// e.checked
		$('.wholesale_price_row').toggleClass('hidden');
	}


   function addWholeSalePriceOption() {
	  var attribute_row = $("#wholesale_PriceOption  tbody tr:last-child").attr('data-row');  
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
				html += '<div class=""><input type="text" name="wholesale_price_option[' + attribute_row + '][price]" rows="5" placeholder="Price" class="form-control wholesale_changePr">';
			html += '</td>';
			
			
			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="wholesale_price_option[' + attribute_row + '][discount]" rows="5" placeholder="Discount" class="form-control wholesale_changePr">';
			html += '</td>';
			
			html += '<td class="text-left">';
				html += '<div class=""><input type="text" name="wholesale_price_option[' + attribute_row + '][discount_price]" rows="5" placeholder="Discount Price" class="form-control wholesale_changePr">';
			html += '</td>';
			
		
			html += '<td class="text-right">';
				html += '<button type="button" onclick="$(\'#wholesale_priceoption-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>';
			html += '</td>';


		html += '</tr>';

	  $('#wholesale_PriceOption tbody').append(html); 
	  
  }


</script>
		
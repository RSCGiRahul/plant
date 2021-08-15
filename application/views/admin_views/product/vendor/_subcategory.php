
 <div class="col-md-6">
                  <div class="form-group">
                     <label for="product_category">Select Sub Category</label>  
                     <select name="product_subcategory[]" value="" class="form-control " id="product_subcategory" placeholder="" multiple="multiple"> 
                     	<?php 
                   
					   foreach (array_filter($categories_info, function ($value) {
					   		return $value['parent_id'] > 0;
					   	}) as $v_category_info){ 
							$opt=explode(",",set_value('product_category'));   
						$selected='';               
						?>
						<option class="hidden category_<?php echo $v_category_info['parent_id']?>" <?php echo $selected; ?> value="<?php echo $v_category_info['category_id']; ?>"><?php echo $v_category_info['category_name']; ?></option> 
					  <?php } ?>   
						 
					 </select>
                     <span class="help-block error-message"><?php echo form_error('special_category'); ?></span>
                  </div>
               </div>
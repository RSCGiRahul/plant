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
					  
									<?php /*
									<select  name="price_option[<?php echo $i; ?>][name]" value="" placeholder="Attribute" class="form-control" autocomplete="off">
									<?php
									$selected='';
									foreach($Price_Option as $Price_Option_v){
										
										$selected = '';
										if($Price_Option_v['price_id']==$json_price_option_v->name){
											$selected = 'selected';
										}
										echo '<option '.$selected.' value="'.$Price_Option_v['price_id'].'">'.$Price_Option_v['price_name'].'</option>';  
									}
									?>
									</select>
									*/ ?>
									
							<?php 
							
							/* $json_price_option=json_decode($product_info['price_option']);	 */				  
							$i = 1;
							
							
							foreach($dir_product_price_option as $price_option_v){
							?>
							<tr id="priceoption-row<?php echo $i; ?>" data-row="<?php echo $i; ?>" >
								<td class="text-left" style="width: 40%;"> 
									
									<input type="text" name="price_option[<?php echo $i; ?>][name]" rows="5" placeholder="Name" class="form-control" value="<?php echo $price_option_v['name']; ?>">
								</td>
							
								<td class="text-left">
									<div class=""><input type="text" name="price_option[<?php echo $i; ?>][sorting]" rows="5" placeholder="Sorting" class="form-control" value="<?php echo $price_option_v['sorting']; ?>">
									</div>
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="price_option[<?php echo $i; ?>][price]" rows="5" placeholder="Price" class="form-control changePr" value="<?php echo $price_option_v['price']; ?>">
									</div>
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="price_option[<?php echo $i; ?>][discount]" rows="5" placeholder="Discount" class="form-control changePr" value="<?php echo $price_option_v['discount']; ?>">
									</div>
								</td>
								
								<td class="text-left">
									<div class=""><input type="text" name="price_option[<?php echo $i; ?>][discount_price]" rows="5" placeholder="Discount Price" class="form-control changePr" value="<?php echo $price_option_v['discount_price']; ?>">
									</div>
								</td>
								
								<td class="text-right"><button type="button" onclick="$('#priceoption-row<?php echo $i; ?>').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
							</tr>
							<?php $i++; } ?>
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
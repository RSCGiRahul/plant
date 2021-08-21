<div class="map-container">
                		<div class="inner-basic division-details">
                		  <div class="retailprice_<?php echo $v_product_list['product_id']; ?> hide">
                			<?php if($result_price_option!=""){ ?>
                						<select class="form-control form-control-sm sm-price_option" name="price_option" product_id="<?php echo $product_id; ?>" >
                						  <?php foreach($result_price_option as $v_price_option){ 
                						  if($v_price_option->discount>0){
                							  $v_price_option->price = $v_price_option->discount_price;
                						  }
                						  ?>	
                						  <option value="<?php echo $v_price_option->price_id; ?>"><?php echo $v_price_option->name." - ".CURRENCY_OPTION.$v_price_option->price; ?></option>
                						  <?php } ?>
                						</select>
                						<?php }else{
                							if($v_product_list['weight']){ echo "<p>".$v_product_list['weight']."</p>"; }
                						} ?>
                
                                    <?php echo $price_box; ?>
                		  </div>
                	
                		  <div class="wholesaleprice_<?php echo $v_product_list['product_id']; ?> hide">
                			<div class="wholesale_price">
                                  <?php foreach ($wholesaleArr as $key => $val) { ?>
                        		  <div class="packking_size_price">
                        			<label>
                                      
                        				<input class="wholesale_input" type="checkbox" data-discount = "<?php echo $val->discount; ?>" class="radio" value="1" name=""/>Pack of <?php echo (++$key) * 10; ?> -MRP ₹
                                        <span class="product_wholesale_price"><?php echo $val->mrp; ?></span>
                                          <span class="product_wholesale_price"><?php echo $val->dp; ?></span>	
                        				<offerprice>₹ <?php echo $val->price; ?> </offerprice>
                                   
                        			</label>
                        		  </div>
                            <?php } ?>
                        		<!--   <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 20 -MRP ₹<span class="product_wholesale_price">220</span>	
                        				<offerprice>₹120</offerprice>
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 50 -MRP ₹<span class="product_wholesale_price">800</span>	
                        				<offerprice>₹100</offerprice>
                        			</label>
                        		  </div> -->
                        	  </div>
                		  </div>




                		</div>
                	  </div>
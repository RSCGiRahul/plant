<div class="col-6 col-md-4">  
								<form action="javascript:;" class="product-listing-frm" id="product-<?php echo $product_id; ?>">
                                <div class="product-default">
                                    <figure>
                                        <a href="<?php echo $seo_url; ?>">
                                            <img src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" alt="<?php echo $v_product_list['product_name']; ?>">
                                        </a>
                                        
										<a href="<?php echo $seo_url; ?>"><?php echo $discount_box; ?></a>
										
                                    </figure>
                                    <div class="product-details">
										
                                        <h2 class="product-title">
                                            <?php echo $product_name; ?>
                                        </h2>
										
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
										
                                        <div class="product-action">
                                            <div class="row no-gutters w-100">
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label for="inputPassword" class="">Qty:</label>
                                                          <input type="number" class="form-control" id="quantity" name="quantity" placeholder="1" max="500" min="1" value="1">
                                                      </div>
                                                </div>
                                                <div class="col-md-6"> <!-- addCartModal -->
													<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
                                                    <button class="btn-icon btn-add-cart" ><i class="icon-bag"></i>ADD</button>
                                                </div>
                                            </div> 
                                        </div>
										
                                        <?php   include('_wholesale.php'); ?> 

                                    </div><!-- End .product-details -->
                                </div>

                        
								</form>
                            </div>
                            
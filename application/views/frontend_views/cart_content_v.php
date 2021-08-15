 <main class="main"> 
			
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb mt-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="icon-home"></i></a></li>
                        <!--<li class="breadcrumb-item"><a href="category.html">Categories</a></li>-->
                        
						<li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
						
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="toolbox custom-toolbox"> 
                            <div class="toolbox-item toolbox-show">
                                <label>Shopping Cart</label>
                            </div> 
                         </nav>
						
						<div  class="row row-sm">
							<div class="col-lg-12">			
								<!-------------- cart content -------------->
								 	

								<div class="table-responsive cart-content">
								   <table class="table table-bordered">
									  <thead>
										 <tr>
											<td class="text-center">Image</td>
											<td class="text-left">Product Name</td>
											<td class="text-left">Quantity</td>
											<td class="text-right">Unit Price</td>
											<td class="text-right">Total</td>
										 </tr>
									  </thead>
									  <tbody>
										
										<?php if(count($cart_info)>0){ 
											
											 foreach($cart_info as $v_cart_info){

												$regular_price = $v_cart_info['quantity']*$v_cart_info['regular_price'];
												$price =$v_cart_info['quantity']*$v_cart_info['price'];
												$discount_price = ($price-$regular_price);


												$total= $total+$regular_price;
												$total_discount_price= $total_discount_price+$discount_price;


												$product_id = $v_cart_info['product_id'];
												$product_info = $this->CC_Model->get_product_info($product_id);

												$gallery_featured = $product_info['gallery_featured'];
												if($gallery_featured==""){
												$product_images = json_decode($product_info['product_images']);
												$gallery_featured = $product_images[0];
												}

												$productImg=base_url('assets/uploads/product/'.$gallery_featured.'');
												
												$seo_url=base_url('/product/details/'.$product_info['seo_url'].'');
														
											?>
										 <tr>
											<td class="text-center"> 
											   <a href="<?php echo $seo_url; ?>">
												<img src="<?php echo $productImg; ?>" width="80px" alt="iMac" title="iMac" class="img-thumbnail"></a>
											</td>
											<td class="text-left"><a href="<?php echo $seo_url; ?>"><?php echo $v_cart_info['product_title']; ?></a> </td>
											
											
											
											<td class="text-left">
											   <div class="input-group btn-block" style="max-width: 200px;">
												  <input type="text" name="quantity" value="<?php echo $v_cart_info['quantity']; ?>" size="1" class="form-control input-quantity" id="input-quantity-<?php echo $v_cart_info['cart_id']; ?>">
												  <span class="input-group-btn">
												  <button type="button"  title="" class="btn btn-primary btn-cart-icon btn-refresh-cart-2" cart_id="<?php echo $v_cart_info['cart_id']; ?>" ><i class="fa fa-sync"></i></button>
												  <button type="button"    class="btn btn-danger btn-cart-icon btn-remove-cart-2" cart_id="<?php echo $v_cart_info['cart_id']; ?>" ><i class="fa fa-times-circle"></i></button>
												  </span>
											   </div>
											</td>
											<td class="text-right"><?php echo CURRENCY.$v_cart_info['regular_price']; ?></td>
											<td class="text-right"><?php echo CURRENCY.$regular_price; ?></td>
										 </tr>
										<?php 
											 }
											 
										}else{
											echo '<tr><td colspan="6" class="text-center">No product found.</td></tr>';
										} ?>
										 
									  </tbody>
								   </table>
								</div> 
								
								
								<!-------------- cart content --------------> 
								
								
								
								<!-------------- cart total --------------> 
								<?php
								if(!empty($cart_info)){
								?>
									<div class="row">
									<div class="col-sm-4 offset-sm-8">
									  <table class="table table-bordered">
													<tbody><tr>
										  <td class="text-right"><strong>Sub-Total:</strong></td>
										  <td class="text-right"><?php echo CURRENCY.$total; ?></td>
										</tr>
										
										
										<?php 
												if(!empty($delivery_charge)){
													
													$total= ($total+$delivery_charge);
												?>													
												 <tr>
                                                    <td class="text-right" ><strong>Delivery charge:</strong></td>
                                                    <td class="text-right">
                                                        <?php echo CURRENCY.$delivery_charge; ?>
                                                    </td>
                                                </tr>
												<?php } ?>

													 
													 
										<tr>
										  <td class="text-right"><strong>Total:</strong></td>
										  <td class="text-right"><?php echo CURRENCY.$total; ?></td>
										</tr>
										</tbody></table>
									</div>
									</div>
									
									<!-------------- cart total -------------->  
								
									<div class="buttons clearfix">
										<div class="pull-right"><a href="<?php echo base_url('/checkout'); ?>" class="btn btn-default btn-checkout">Checkout</a></div>
									</div>
									
								<?php }else{
									?>
									
									<div class="buttons clearfix">
										<div class="text-center"><a href="<?php echo base_url('/'); ?>" class="btn btn-default btn-checkout">Continue shopping</a></div>
									</div>
									<?php
								} ?>
									
								
								
								
								
							</div>									
						</div>  
						
                    </div> 
					
				 
				
				</div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-5"></div><!-- margin -->
        </main><!-- End .main -->

<?php $ver='1001'; ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/steps-style.css?ver=<?php echo $ver; ?>">

    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb mt-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </div>
            <!-- End .container -->
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="toolbox custom-toolbox">
                        <div class="toolbox-item toolbox-show">
                            <label>Checkout</label>
                        </div>
                    </nav>
                    <div class="row ">
                        <div class="col-lg-12">
                            <!-------------- Checkout content -------------->

                            <div class="row " style="">

                                <!-------------- col-sm-7 -------------->
                                <div class="col-sm-6">

                                    <form class="form-validation" id="checkoutForm" action="javascript:;" method="post" autocomplete="off">

                                        <?php 
							$customer_id      = $this->session->userdata('customer_id'); 
							if($customer_id==""){	
							?>
                                            <ul class="stepper stepper-vertical focused">

                                                <li class="active">
                                                    <a href="javascript:;">
                                                        <span class="circle">1</span>
                                                        <span class="label">Phone Number Verification</span>
                                                    </a>

                                                    <div class="step-content grey lighten-3">
                                                        <p>We need your phone number so that we can update you about your order.</p>
                                                        <div class="loginStep">
                                                            <div class="form-group">
                                                                <label for="phone">Your 10 digit mobile number</label>
                                                                <input type="tel" id="phone" name="phone" class="form-control" placeholder="Phone number" autofocus="off">
                                                            </div>
                                                            <button class="btn btn-lg btn-default btn-checkout-login pull-right" type="submit">Next</button>

                                                        </div>
                                                        <div class="loginMsg"></div>
                                                    </div>

                                                </li>

                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="circle">2</span>
                                                        <span class="label">Delivery Address</span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="circle">3</span>
                                                        <span class="label">Payment</span>
                                                    </a>
                                                </li>

                                            </ul>
                                            <?php }else{ ?>

                                                <ul class="stepper stepper-vertical focused">

                                                    <li class="completed">
                                                        <a href="javascript:;">
                                                            <span class="circle">1</span>
                                                            <span class="label">Phone Number Verification</span>
                                                        </a>
                                                    </li>

                                                    <li class="active">
                                                        <a href="javascript:;">
                                                            <span class="circle">2</span>
                                                            <span class="label">Delivery Address</span>
                                                        </a>

                                                        <div class="step-content grey lighten-3 step-2-content">
															
															<!--------- Delivery Address ----------->
															
															<?php 
															$css='';
															if($shipping_address_info){
																$css='display:none;';
																echo '<div class="row">';
																foreach($shipping_address_info as $v_shipping_address_info){  
																	?>
																	
																	<div class="col-sm-6">
																		<p>
																		<?php echo $v_shipping_address_info['firstname']." ".$v_shipping_address_info['firstname']; ?> <br>
																		
																		<?php echo $v_shipping_address_info['address']."<br> ".$v_shipping_address_info['city']."<br>".$v_shipping_address_info['postcode']; ?>
																		</p> 
																		<input type="button" class="btn btn-default btn-deliver-here" value="Deliver here" data-shipping_id="<?php echo $v_shipping_address_info['shipping_id']; ?>"> 
																		
																		<div class="label-loginMsg loginMsg_<?php echo $v_shipping_address_info['shipping_id']; ?>"></div>
																	</div> 
																	<?php	 
																}
																
																echo '</div>
																	
																	<br>
																	
																	<p><a href="javascript:;" class="btn-new-place"><i class="fa fa-plus">&nbsp; New new delivery Place</i></a></p>';
																
															}
															?>
															
															
															<div class="row" id="newaddress" style="<?php echo $css; ?>">
															
															<div class="col-sm-6 form-group ">
															   <label class="control-label" for="input-payment-firstname">First Name</label>
															   <input type="text" name="firstname" value="" placeholder="First Name" id="input-payment-firstname" class="form-control ">
															   <span class="error"><?php echo form_error('firstname'); ?></span>
															</div>
															
															<div class="col-sm-6 form-group ">
															   <label class="control-label" for="input-payment-lastname">Last Name</label>
															   <input type="text" name="lastname" value="" placeholder="Last Name" id="input-payment-lastname" class="form-control">
															   <span class="error"><?php echo form_error('lastname'); ?></span>
															</div>
															
															<div class="col-sm-12 form-group ">
															   <label class="control-label" for="input-payment-email">E-Mail</label>
															   <input type="text" name="email" value="" placeholder="E-Mail" id="input-payment-email" class="form-control form-control2">
															   <span class="error"><?php echo form_error('email'); ?></span>
															</div>
															
															
															<div class="col-sm-12 form-group ">
															   <label class="control-label" for="input-payment-address">Address</label>
															   <input type="text" name="address" value="" placeholder="Address" id="input-payment-address" class="form-control form-control2">
															   <span class="error"><?php echo form_error('address'); ?></span>
															</div>
															 
															<div class="col-sm-6 form-group ">
															   <label class="control-label" for="input-payment-city">City</label>
															   <input type="text" name="city" value="" placeholder="City" id="input-payment-city" class="form-control">
															   <span class="error"><?php echo form_error('city'); ?></span>
															</div>
															
															<div class="col-sm-6 form-group ">
															   <label class="control-label" for="input-payment-postcode">Post Code</label>
															   <input type="text" name="postcode" value="" placeholder="Post Code" id="input-payment-postcode" class="form-control">
															   <span class="error"><?php echo form_error('postcode'); ?></span>
															</div>
															
															
															<button class="btn btn-lg btn-default btn-checkout-step-3 pull-right" type="submit">Next</button>	
															
															</div>
															
															
															
															<!--------- Delivery Address ----------->
															
															
															
															
															 <div class="loginMsg"></div>
															 
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <a href="javascript:;">
                                                            <span class="circle">3</span>
                                                            <span class="label">Payment</span>
                                                        </a>
                                                    </li>

                                                </ul>

                                                <?php } ?>

                                    </form>

                                </div>
                                <!-------------- col-sm-7 -------------->

                                <!-------------- col-sm-5 -------------->
                                <div class="col-sm-6">

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
                                                        <td class="text-left">
                                                            <?php echo $v_cart_info['product_title']; ?>
                                                        </td>

                                                        <td class="text-left">
                                                            <?php echo $v_cart_info['quantity']; ?>
                                                        </td>

                                                        <td class="text-right">
                                                            <?php echo CURRENCY.$v_cart_info['regular_price']; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php echo CURRENCY.$regular_price; ?>
                                                        </td>
                                                    </tr>
                                                    <?php 
									 }

								} 
								
								?>

                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td class="text-right" colspan="4"><strong>Sub-Total:</strong></td>
                                                    <td class="text-right">
                                                        <?php echo CURRENCY.$total; ?>
                                                    </td>
                                                </tr>
												
												<?php 
												$sub_total = $total;
												if(!empty($delivery_charge)){
													
													$total = ($total+$delivery_charge);
												?>													
												 <tr>
                                                    <td class="text-right" colspan="4"><strong>Delivery charge:</strong></td>
                                                    <td class="text-right">
                                                        <?php echo CURRENCY.$delivery_charge; ?>
                                                    </td>
                                                </tr>
												<?php } ?>

                                                <tr>
                                                    <td class="text-right" colspan="4"><strong>Total:</strong></td>
                                                    <td class="text-right">
                                                        <?php echo CURRENCY.$total; ?>
                                                    </td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>

                                </div>
                                <!-------------- col-sm-5 -------------->

                                <!-------------- Checkout content -------------->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>
            <!-- End .container -->
            <div class="mb-5"></div>
            <!-- margin -->
    </main>
    <!-- End .main -->
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

						<?php 
						$customer_id      = $this->session->userdata('customer_id'); 
						if($customer_id==""){	
						?>
						
						 <div  class="row " style="" > 
						
													
							<div class="col-sm-7">
								<form class="form-validation" action="<?php echo base_url('checkout/register'); ?>" method="post">

							   <div  class="row " style="" > 
								  <div class="col-sm-6">
									 <fieldset id="account">
										<legend>Your Personal Details</legend>
										
										<div class="form-group required">
										   <label class="control-label" for="input-payment-firstname">First Name</label>
										   <input type="text" name="firstname" value="<?php  if($_POST['firstname']){ echo $_POST['firstname'];  }else{ echo $customer_info['firstname']; } ?>" placeholder="First Name" id="input-payment-firstname" class="form-control ">
										   <span class="error"><?php echo form_error('firstname'); ?></span>
										</div>
										<div class="form-group required">
										   <label class="control-label" for="input-payment-lastname">Last Name</label>
										   <input type="text" name="lastname" value="<?php  if($_POST['lastname']){ echo $_POST['lastname'];  }else{ echo $customer_info['lastname']; } ?>" placeholder="Last Name" id="input-payment-lastname" class="form-control">
										   <span class="error"><?php echo form_error('lastname'); ?></span>
										</div>
										<div class="form-group required">
										   <label class="control-label" for="input-payment-email">E-Mail</label>
										   <input type="text" name="email" value="<?php  if($_POST['email']){ echo $_POST['email'];  }else{ echo $customer_info['email']; } ?>" placeholder="E-Mail" id="input-payment-email" class="form-control">
										   <span class="error"><?php echo form_error('email'); ?></span>
										</div>
										<div class="form-group required">
										   <label class="control-label" for="input-payment-Phone">Phone</label>
										   <input type="text" name="phone" value="<?php  if($_POST['phone']){ echo $_POST['phone'];  }else{ echo $customer_info['phone']; } ?>" placeholder="Phone" id="input-payment-phone" class="form-control">
										   <span class="error"><?php echo form_error('phone'); ?></span>
										</div>
									 </fieldset>
									 
									 <?php if($customer_id==""){ ?>	
									 <fieldset>
									  <legend>Your Password</legend>
									  <div class="form-group required">
										<label class="control-label" for="input-payment-password">Password</label>
										<input type="password" name="password" value="" placeholder="Password" id="input-payment-password" class="form-control">
										<span class="error"><?php echo form_error('password'); ?></span>
									  </div>
									  <div class="form-group required">
										<label class="control-label" for="input-payment-confirm">Password Confirm</label>
										<input type="password" name="confirm" value="" placeholder="Password Confirm" id="input-payment-confirm" class="form-control">
										<span class="error"><?php echo form_error('confirm'); ?></span>
									  </div>
									</fieldset>
									 <?php } ?>
								  </div>
								  
								  
								  <div class="col-sm-6">
									 <fieldset id="address" class="">
										<legend>Your Address</legend>
									 
										<div class="form-group required">
										   <label class="control-label" for="input-payment-address">Address</label>
										   <input type="text" name="address" value="<?php  if($_POST['address']){ echo $_POST['address'];  }else{ echo $customer_info['address']; } ?>" placeholder="Address" id="input-payment-address" class="form-control">
										   <span class="error"><?php echo form_error('address'); ?></span>
										</div>
										 
										<div class="form-group required">
										   <label class="control-label" for="input-payment-city">City</label>
										   <input type="text" name="city" value="<?php  if($_POST['city']){ echo $_POST['city'];  }else{ echo $customer_info['city']; } ?>" placeholder="City" id="input-payment-city" class="form-control">
										   <span class="error"><?php echo form_error('city'); ?></span>
										</div>
										
										<div class="form-group required">
										   <label class="control-label" for="input-payment-postcode">Post Code</label>
										   <input type="text" name="postcode" value="<?php  if($_POST['postcode']){ echo $_POST['postcode'];  }else{ echo $customer_info['postcode']; } ?>" placeholder="Post Code" id="input-payment-postcode" class="form-control">
										   <span class="error"><?php echo form_error('postcode'); ?></span>
										</div>
										
										
										<div class="form-group required">
										   <label class="control-label" for="input-payment-state"> State</label>
										   <select name="state_id" id="input-payment-state" class="form-control">
											  <option   value=""> --- Please Select --- </option>
											   <option selected value="1"> Delhi </option>
										   </select>
										   <span class="error"><?php echo form_error('state_id'); ?></span>
										</div>
									 </fieldset>
								  </div>
								
								<?php if($customer_id==""){ ?>	
								<input type="submit" value="Register" id="button-login" data-loading-text="Loading..." class="btn btn-default btn-checkout">
								<?php } ?>
								
							   </div> 
							   
							   </form>
							   
							</div>

							
							<div class=" col-sm-5">
									<form  class="form-validation" action="<?php echo base_url('checkout/login'); ?>" method="post">
										<p>If you have shopped with us before, please enter your details below. </p>
										<div class="form-group">
											<label class="control-label" for="input-email">E-Mail</label>
											<input type="text" name="email" value="" placeholder="E-Mail" id="input-email" class="form-control">
										</div>
										<div class="form-group">
											<label class="control-label" for="input-password">Password</label>
											<input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control">
											<a href="javascript:;">Forgotten Password</a>
										</div>
										<input type="submit" value="Login" id="button-login" data-loading-text="Loading..." class="btn btn-default btn-checkout">
									</form>
									
								</div>
						
						</div>	

						<?php
						}else{
						?>
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

								} ?>

								</tbody>

								<tfoot>
									<tr>
										<td class="text-right" colspan="4"><strong>Sub-Total:</strong></td>
										<td class="text-right">
											<?php echo CURRENCY.$total; ?>
										</td>
									</tr>

									<tr>
										<td class="text-right" colspan="4"><strong>Total:</strong></td>
										<td class="text-right">
											<?php echo CURRENCY.$total; ?>
										</td>
									</tr>
								</tfoot>

							</table>
						</div>
						
						<p></p>
						
						<div class="pull-right">
							<form action="<?php echo base_url('/order'); ?>" method="post">
								<input type="submit" value="Confirm Order" id="button-confirm" data-loading-text="Loading..." class="btn btn-default btn-checkout">
							</form>
						</div>
						
                      <?php } ?>

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
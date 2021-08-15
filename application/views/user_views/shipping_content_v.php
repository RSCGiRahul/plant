

<main class="main">
   <nav aria-label="breadcrumb" class="breadcrumb-nav">
      <div class="container">
         <ol class="breadcrumb mt-0">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="icon-home"></i></a></li>
            <!--<li class="breadcrumb-item"><a href="category.html">Categories</a></li>-->
            <li class="breadcrumb-item active" aria-current="page">My Account</li>
         </ol>
      </div>
      <!-- End .container -->
   </nav>
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <nav class="toolbox custom-toolbox">
               <div class="toolbox-item toolbox-show">
                  <label></label>
               </div>
            </nav>
            <div  class="row ">
               <div class="col-lg-12">
                  <!-------------- content -------------->
                  <div  class="row ">
                     <?php echo $sidebar_content; ?>
                     <div id="column-right" class="col-sm-9 hidden-xs">
                       
					   
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
																		<?php echo $v_shipping_address_info['firstname']." ".$v_shipping_address_info['lastname']; ?> <br>
																		
																		<?php echo $v_shipping_address_info['address']."<br> ".$v_shipping_address_info['city']."<br>".$v_shipping_address_info['postcode']; ?>
																		</p> 
																		<a href="<?php echo base_url('/user/shipping/edit/'.$v_shipping_address_info['shipping_id'].''); ?>" class="btn btn-default btn-deliver-here"  data-shipping_id="<?php echo $v_shipping_address_info['shipping_id']; ?>">Edit </a>
																		
																		<a href="<?php echo base_url('/user/shipping/remove/'.$v_shipping_address_info['shipping_id'].''); ?>" class="btn btn-default btn-deliver-here"  data-shipping_id="<?php echo $v_shipping_address_info['shipping_id']; ?>">Remove </a>
																		
																		
																	</div> 
																	<?php	 
																}
																
																echo '</div>
																	
																	<br>
																	
																	<p><a href="javascript:;" class="btn-new-place"><i class="fa fa-plus">&nbsp; New new delivery Place</i></a></p>';
																
															}
															?>
															
															<form action="javascript:;" id="shippingForm">
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
															
															
															<button class="btn btn-lg btn-default btn-add-shipping pull-right" type="submit">Submit</button>	
															
															
															<div class="shippingMsg"></div>
															
															</div>
															</form>
															
															
															<!--------- Delivery Address ----------->
					   
					   
                     
					 </div>
					 
                  </div>
                  <!--------------  content -------------->  
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


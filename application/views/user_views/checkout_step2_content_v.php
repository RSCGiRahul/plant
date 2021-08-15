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
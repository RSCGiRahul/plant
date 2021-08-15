<ul class="stepper stepper-vertical focused">

			<li class="completed">
				<a href="javascript:;">
					<span class="circle">1</span>
					<span class="label">Phone Number Verification</span>
				</a>
			</li>

			<li class="completed">
				<a href="javascript:;">
					<span class="circle">2</span>
					<span class="label">Delivery Address</span>
				</a> 
			</li>

			
			<li class="active">
				<a href="javascript:;">
					<span class="circle">3</span>
					<span class="label">Payment</span>
				</a>
				
				<div class="step-content grey lighten-3 step-3-content">
				
						<div class="row">
							<div class="col-sm-12">
								
								<div class="form-group">
								<input checked type="radio" name="payment_type" value="COD"> <label>Cash on delivery</label>
								</div> 
								
								<div class="form-group">
								<input type="radio" name="payment_type" value="ROZERPAY"> <label>Rozerpay</label>
								</div> 
								 
							</div>
						</div>
						<div class="clearfix"></div>
						
						
						
					    <div class="pull-right">
								<input type="hidden" value="<?php echo $shipping_outlet->outlet_id; ?>" name="outlet_id" >
								<input type="hidden" value="<?php echo $shipping_id; ?>" name="shipping_id" >
								<input type="submit" value="Confirm Order" id="button-confirm" data-loading-text="Loading..." class="btn btn-default btn-checkout">
							
						</div>
					
						<div class="loginMsg"></div>
					 
				</div>
			</li>
			
			

		</ul>
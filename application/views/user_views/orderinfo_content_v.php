

<main class="main">
   <nav aria-label="breadcrumb" class="breadcrumb-nav">
      <div class="container">
         <ol class="breadcrumb mt-0">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('/user/account/order'); ?>">My Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order History</li>
         </ol>
      </div>
      <!-- End .container -->
   </nav>
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div  class="row "> 
				
			
               <div class="col-lg-12">
                  <!-------------- content -------------->
                  <div  class="row ">
                     <?php echo $sidebar_content; ?>
                     <div id="column-right" class="col-sm-9 hidden-xs">
						 <div class="">
							<nav class="toolbox custom-toolbox">
							   <div class="toolbox-item toolbox-show">
								  <h4>Order History</h4>
							   </div>
							</nav>
						</div>	
						
                        
						<!------------------------------>
						
						<table class="table table-bordered table-hover">
							<thead>
							  <tr>
								<td class="text-left" style="width: 50%; vertical-align: top;">User Contact</td>
								<td class="text-left" style="width: 50%; vertical-align: top;">Shipping Address</td>
								</tr>
							</thead>
							<tbody>
							  <tr>
								<td class="text-left">
									<?php echo $order_info['firstname']." ".$order_info['lastname']; ?><br>
									<?php echo $order_info['email']; ?> <br>
									<?php echo $order_info['phone']; ?>
								</td>
											
											
								<td class="text-left">
									<?php echo $order_info['address']; ?><br>
									<?php echo $order_info['city']; ?> <br>
									<?php echo $order_info['postcode']; ?><br>
								</td>
								 </tr>
							</tbody>
						  </table>
						
						
						<!------------------------------>
						
						
						<!---------------------------------------------> 
						<div class="table-responsive">
								<table class="table table-bordered table-hover">
								  <thead>
									<tr>
									  <td class="text-left">Product Name</td>
									  <td class="text-right">Quantity</td>
									  <td class="text-right">Unit Price</td>
									  <td class="text-right">Total</td>
									  <td style="width: 20px;"></td>
									  </tr>
								  </thead>
								  <tbody>
									<?php 
										$total = 0;
										foreach($order_product as $orderproduct){ 
										
										$total = $total+($orderproduct['quantity']*$orderproduct['regular_price']);
										?>
										
										<tr> 
											<td class="text-left"><?php echo $orderproduct['product_title']; ?></td>
											<td class="text-right"><?php echo $orderproduct['quantity']; ?></td>
											<td class="text-right"><?php echo CURRENCY.$orderproduct['regular_price']; ?></td>
											<td class="text-right"><?php echo CURRENCY.($orderproduct['quantity']*$orderproduct['regular_price']); ?>
											</td>
											<td class="text-right" style="white-space: nowrap;"> 
												<form action="javascript:;" class="col-order_product"  id="product-<?php echo $orderproduct['product_id']; ?>">
												<input type="hidden" class="" id="quantity" name="quantity"  max="500" min="1" value="<?php echo $orderproduct['quantity']; ?>">
												<input type="hidden" name="product_id" value="<?php echo $orderproduct['product_id']; ?>">
												<?php if($orderproduct['price_id']){ ?>												
												<input type="hidden"  class="" name="price_option" product_id="<?php echo $orderproduct['product_id']; ?>" value="<?php echo $orderproduct['price_id']; ?>">
												<?php } ?>
												<a href="javascript:;" data-toggle="tooltip" title="" class="btn btn-primary btn-add-cart" data-original-title="Reorder"><i class="fa fa-shopping-cart"></i>
												</a> 
												</form>
												 
											</td>
										  </tr>
								  
									
										
									<?php } ?>
								  
								  </tbody>
								  
								  
								  
									<tfoot>
									
									<tr>
										<td colspan="2"></td>
										<td class="text-right"><b>Sub Total</b></td>
										<td class="text-right"><?php echo CURRENCY.$total; ?></td>
										<td></td>
									</tr>
									 
								 
									<tr>
										<td colspan="2"></td>
										<td class="text-right"><b>Delivery charge</b></td>
										<td class="text-right"><?php echo CURRENCY.$order_info['delivery_charge']; ?></td>
										<td></td>
									</tr>
									 
									  
									<tr>
										<td colspan="2"></td>
										<td class="text-right"><b>Total</b></td>
										<td class="text-right"><?php echo CURRENCY.$order_info['amount']; ?></td>
										<td></td>
									</tr>
									</tfoot>
								  
								  
								 </table>
						 </div>
						
						
						<!-------------------------------------------->
						
						<!---------------------- Order History ---------------->
					 
						
						<br>
						<h3>Order History</h3>
						<table class="table table-bordered table-hover">
								<thead>
								  <tr>
									<td class="text-left">Date Added</td>
									<td class="text-left">Status</td>
									<td class="text-left">Comment</td>
								  </tr>
								</thead>
								<tbody>
								<?php foreach($order_history as $orderhistory){ ?>
								<tr>
								  <td class="text-left"><?php echo DATE("d/m/Y",strtotime($orderhistory['date_added'])); ?></td>
								  <td class="text-left"><?php echo ucwords($orderhistory['order_status']); ?></td>
								  <td class="text-left"><?php echo $orderhistory['comment']; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						 </table>
						<!---------------------- Order History ---------------->
						
						
                     
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


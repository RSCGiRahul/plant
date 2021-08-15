<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Orders
        <small>Manage Orders</small>
    </h1>
    <ol class="breadcrumb woo-breadcrumb">
         <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		 <li><a class="active" href="<?php echo base_url('admin/order'); ?>"><i class="fa fa-cogs"></i> Manage Order</a></li> 
		 <li><a class="active" href="<?php echo base_url('admin/products'); ?>"><i class="fa fa-file-text-o"></i> Manage Products</a></li> 
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">View Order</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>

        <!-- form start -->
		
		 	
		
		
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12" >  
					 
                </div>
                <div class="col-md-12" style="margin-top: 25px;"> 
					
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
									Delhi
								</td>
								 </tr>
							</tbody>
						  </table>
						
					
					
					
					<!------------------------------>
					
					
					<?php
					
					if($outlet_info){
					
					echo '<table class="table table-bordered table-hover">
							<thead>
							  <tr>
								<td class="text-left" style="width: 100%; vertical-align: top;">Outlet Details</td>
		
								</tr>
							</thead>
							<tbody>
							  <tr>
								<td class="text-left">
									'.$outlet_info['outlet_name'].' <br>
									'.$outlet_info['address'].' <br>
									'.$outlet_info['assigned_city'].' <br>
									'.$outlet_info['zipcode'].' <br>
									'.$outlet_info['phone'].'
								</td> 
								 </tr>
							</tbody>
						  </table>';
						  
					}
					?>
					
					
					<!------------------------------>
					
					<div class="table-responsive">
								<table class="table table-bordered table-hover">
								  <thead>
									<tr>
									  <td class="text-left">Product Name</td>
									  <td class="text-right">Quantity</td>
									  <td class="text-right">Unit Price</td>
									  <td class="text-right">Total</td>
							 
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
					
					<!------------------------------>
					
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
					
					
					<!-------------------------------------------------->
					
					<fieldset>
              <legend>Add Order History</legend>
              <form class="form-horizontal" action="<?php echo base_url('admin/order/update_order/' . $order_info['order_id'] . ''); ?>" method="post">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-order-status">Order Status</label>
                  <div class="col-sm-10">
                    <select name="order_status" id="input-order-status" class="form-control">
                      <?php foreach($order_status as $orderstatus){ ?>
						<option  value="<?php echo strtolower($orderstatus['status']); ?>"><?php echo $orderstatus['status']; ?></option>
						<?php } ?> 
                                                                
                    
                    </select>
                  </div>
                </div>
                
                
				<div class="form-group">
                  <label class="col-sm-2 control-label" for="input-notify">Notify Customer</label>
                  <div class="col-sm-10">
                    <div class="checkbox">
                      <input type="checkbox" name="notify" value="1" id="input-notify">
                    </div>
                  </div>
                </div>
				
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-comment">Comment</label>
                  <div class="col-sm-10">
                    <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>
                  </div>
                </div>
				
				<div class="text-right">
					  <button id="button-history" type="submit" data-loading-text="Loading..." class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add History</button>
					</div>
					
              </form>
            </fieldset>
					
					
					
					<!-- /.table -->
                </div>
            </div>
			
 	
			
        </div>
        <!-- /.box-body -->
    </div>
</section>
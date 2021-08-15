

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
                       
					    <div class="table-responsive">
						<table class="table table-bordered table-hover">
						  <thead>
							<tr>
							  <td class="text-right">Order ID</td>
							  <td class="text-left">Customer</td>
							  <td class="text-right">No. of Products</td>
							  <td class="text-left">Payment Status</td>
							  <td class="text-left">Order Status</td>
							  <td class="text-right">Total</td>
							  <td class="text-left">Date Added</td>
							  <td></td>
							</tr>
						  </thead>
						  <tbody>
					   
					   <?php
					   foreach($orders as $order){
						  $order_id = $order['order_id'];
						  
						  $this->db->select('order_product.*')
									->from('tbl_order_product as order_product')  
									->where('order_product.order_id',$order_id) 
									->order_by('order_product.order_product_id', 'asc');	 
									 
									$query_result = $this->db->get();
									$result = $query_result->result_array();
									
									$no_of_product = count($result);
								?>
							<tr>
							  <td class="text-right">#<?php echo $order['order_id']; ?></td>
							  <td class="text-left"><?php echo $order['firstname']." ".$order['lastname']; ?></td>
							  <td class="text-right"><?php echo $no_of_product; ?></td>
							  <td class="text-left"><?php echo ucwords($order['payment_status']); ?></td>
							  <td class="text-left"><?php echo ucwords($order['order_status']); ?></td>
							  <td class="text-right"><?php echo CURRENCY.($order['amount']); ?></td>
							  <td class="text-left"><?php echo $order['date_added']; ?></td>
							  <td class="text-right"><a href="<?php echo base_url('/user/order/info/'.$order['order_id'].''); ?>" data-toggle="tooltip" title="" class="btn btn-info" ><i class="fa fa-eye"></i></a></td>
							</tr>
					   <?php
					   }
					   ?>
							</tbody>
						</table>
					  </div>
					   
                     
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


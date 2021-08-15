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
            <h3 class="box-title">Order</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>

        <!-- form start -->
		
		
		
			    
<?php /* search */ ?>					
					
					
<form name="manageALevels" method="GET" class="form-inline"  > 
<input type="hidden" value="1" name="currentpage">
 
 
<div class="col-sm-12"> 
<div class="panel panel-white"> 
<div class="panel-body">	  
<div class=" col-sm-12 text-center">
 

<div class="form-group"> 
	<label for="email">Status </label> 
	<select   class="form-control m-t-xxs required" id="status" name="status"  >
	<option value="">-Select-</option>
	
	<?php foreach($order_status as $orderstatus){ ?>
	<option <?php if($_GET['status']==''.strtolower($orderstatus['status']).''){ echo "selected"; } ?> value="<?php echo strtolower($orderstatus['status']); ?>"><?php echo $orderstatus['status']; ?></option>
	<?php } ?>
	  
	</select>
	
	<?php /* <label for="email">Product.</label> */ ?> 
    <input type="text" class="form-control" id="search" name="search" placeholder="Search by customer name" value="<?php echo $_REQUEST['search']; ?>" style="min-width:220px;">
	
	&nbsp;&nbsp;
	<label for="payment1">Payment:</label>
	Success <input type="radio" <?php if($_GET['payment']=='success' || $_GET['payment']==''){ echo 'checked'; } ?> class="" id="payment1" name="payment" value="success" >
	Failed <input type="radio" <?php if($_GET['payment']=='failed'){ echo 'checked'; } ?>  class="" id="payment2" name="payment"   value="failed" >
	Pending<input type="radio"  <?php if($_GET['payment']=='pending'){ echo 'checked'; } ?> class="" id="payment3" name="payment"  value="pending" >
	
</div>
 
<button type="submit" class="btn btn-success btn-sm" name="frmAction">Search</button>
 

</div> 

</div>
</div>
</div>
			
</form> 			
<?php /* search */ ?>			
		
		
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12" > 
					
						 
					 
                </div>
                <div class="col-md-12" style="margin-top: 25px;"> 
						
                    <table  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th> 
								<th>Customer</th> 
                                <th>No. of Products	</th>  
                                <th>Payment Status</th>
								<th>Payment Method</th>
                                <th>Order Status</th>
                                <th>Total</th>
								<th>Date Added	</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1;

							$range = RANGE;  
							$totalpages = ceil($order_count / PAGINATION);

							if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {

							$currentpage = (int) $_GET['currentpage'];
							} else {

							$currentpage = 1;
							}

							?>
                            <?php foreach ($order_info as $order) { 
							
									
							
									$order_id = $order['order_id'];
						  
									$this->db->select('order_product.*')
									->from('tbl_order_product as order_product')  
									->where('order_product.order_id',$order_id) 
									->order_by('order_product.order_product_id', 'asc');	 
									 
									$query_result = $this->db->get();
									$result = $query_result->result_array();
									
									$no_of_product = count($result);
									
									
									if($order['payment_type']=='COD'){
									$payment_type='Cash on delivery';	
									}else{
									$payment_type='Rozerpay';		
									}
									
									
								?>
									<tr>
									  <td class="text-right">#<?php echo $order['order_id']; ?></td>
									  <td class="text-left"><?php echo $order['firstname']." ".$order['lastname']; ?></td>
									  <td class="text-right"><?php echo $no_of_product; ?></td>
									  <td class="text-left"><?php echo ucwords($order['payment_status']); ?></td>
									  <td class="text-left"><?php echo ucwords($payment_type); ?></td>
									  <td class="text-left"><?php echo ucwords($order['order_status']); ?></td>
									  <td class="text-right"><?php echo CURRENCY.($order['amount']); ?></td>
									  <td class="text-left"><?php echo $order['date_added']; ?></td>
									  <td class="text-right"><a href="<?php echo base_url('/admin/order/info/'.$order['order_id'].''); ?>" data-toggle="tooltip" title="" class="btn btn-info" ><i class="fa fa-eye"></i></a></td>
									</tr>
								
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
            </div>
			
			
	
<div class="row"> 
<div class="col-sm-7 pull-right">
	<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"> 
	<ul class="pagination"> 
	 <?php   
	 
	$search='';
	 if($_GET['search']){
		 
		 $search .= '&search='.$_GET['search'].'';
	 } 
	 
	 if($_GET['payment']){
		 
		 $search .= '&payment='.$_GET['payment'].'';
	 }
	 
	  if($_GET['status']){
		 
		 $search .= '&status='.$_GET['status'].'';
	 }
	 
	 
	if ($currentpage > $totalpages) { 
	$currentpage = $totalpages;
	} 

	if ($currentpage < 1) { 
	$currentpage = 1;
	}   
	if($brand_count>PAGINATION){  
	  
	if ($currentpage > 1) { 
	echo "<li> <a href='{$_SERVER['SCRIPT_URI']}?currentpage=1".$search."'><<</a></li> "; 
	$prevpage = $currentpage - 1; 
	echo "<li> <a href='{$_SERVER['SCRIPT_URI']}?currentpage=$prevpage".$search."'><</a> </li>";
	}   
	
	for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) { 
	if (($x > 0) && ($x <= $totalpages)) { 
	if ($x == $currentpage) { 
	echo "<li class='active'> <a href='javascript:;' class='paginate_button'>$x</a> </li>"; 
	} else { 
	echo "<li> <a href='{$_SERVER['SCRIPT_URI']}?currentpage=$x".$search."'>$x</a> </li>";
	} 
	} 
	}  


	if ($currentpage != $totalpages) {

	$nextpage = $currentpage + 1;

	echo "<li> <a href='{$_SERVER['SCRIPT_URI']}?currentpage=$nextpage".$search."'>></a> </li>";

	echo "<li> <a href='{$_SERVER['SCRIPT_URI']}?currentpage=$totalpages".$search."'>>></a> </li>";
	} 

	} 
   ?> 
	</ul>
	</div>
</div>
</div>
	
			
			
        </div>
        <!-- /.box-body -->
    </div>
</section>
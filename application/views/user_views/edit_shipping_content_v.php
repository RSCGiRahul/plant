

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
															
															
															
															<form action="<?php echo base_url('/user/shipping/update/' . $shipping_info['shipping_id'] . ''); ?>" id="shippingForm" method="post">
															<div class="row" id="newaddress" style="">
															
															<div class="col-sm-6 form-group ">
															   <label class="control-label" for="input-payment-firstname">First Name</label>
															   <input type="text" name="firstname" value="<?php if($_POST['firstname']){ echo $_POST['firstname']; }else{ echo $shipping_info['firstname']; } ?>" placeholder="First Name" id="input-payment-firstname" class="form-control ">
															   <span class="error"><?php echo form_error('firstname'); ?></span>
															</div>
															
															<div class="col-sm-6 form-group ">
															   <label class="control-label" for="input-payment-lastname">Last Name</label>
															   <input type="text" name="lastname" value="<?php if($_POST['lastname']){ echo $_POST['lastname']; }else{ echo $shipping_info['lastname']; } ?>" placeholder="Last Name" id="input-payment-lastname" class="form-control">
															   <span class="error"><?php echo form_error('lastname'); ?></span>
															</div>
															
															<div class="col-sm-12 form-group ">
															   <label class="control-label" for="input-payment-email">E-Mail</label>
															   <input type="text" name="email" value="<?php if($_POST['email']){ echo $_POST['email']; }else{ echo $shipping_info['email']; } ?>" placeholder="E-Mail" id="input-payment-email" class="form-control form-control2">
															   <span class="error"><?php echo form_error('email'); ?></span>
															</div>
															
															
															<div class="col-sm-12 form-group ">
															   <label class="control-label" for="input-payment-address">Address</label>
															   <input type="text" name="address" value="<?php if($_POST['address']){ echo $_POST['address']; }else{ echo $shipping_info['address']; } ?>" placeholder="Address" id="input-payment-address" class="form-control form-control2">
															   <span class="error"><?php echo form_error('address'); ?></span>
															</div>
															 
															<div class="col-sm-6 form-group ">
															   <label class="control-label" for="input-payment-city">City</label>
															   <input type="text" name="city" value="<?php if($_POST['city']){ echo $_POST['city']; }else{ echo $shipping_info['city']; } ?>" placeholder="City" id="input-payment-city" class="form-control">
															   <span class="error"><?php echo form_error('city'); ?></span>
															</div>
															
															<div class="col-sm-6 form-group ">
															   <label class="control-label" for="input-payment-postcode">Post Code</label>
															   <input type="text" name="postcode" value="<?php if($_POST['postcode']){ echo $_POST['postcode']; }else{ echo $shipping_info['postcode']; } ?>" placeholder="Post Code" id="input-payment-postcode" class="form-control">
															   <span class="error"><?php echo form_error('postcode'); ?></span>
															</div>
															
															
															<button class="btn btn-lg btn-default  pull-right" type="submit">Update</button>	
															
															
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


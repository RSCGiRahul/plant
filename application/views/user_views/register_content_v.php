

<main class="main">
   <nav aria-label="breadcrumb" class="breadcrumb-nav">
      <div class="container">
         <ol class="breadcrumb mt-0">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="icon-home"></i></a></li>
            <!--<li class="breadcrumb-item"><a href="category.html">Categories</a></li>-->
            <li class="breadcrumb-item active" aria-current="page">Register</li>
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
        
					 
				<?php
					$exception = $this->session->userdata('exception');
					$success = $this->session->userdata('success');
					if (!empty($success)) {		 
					echo "<div class='container'><div class='response-msg alert alert-success alert-dismissible text-center'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
							<p> " . $success . "</p>
						</div></div>"; 
					$this->session->unset_userdata('success'); 		
					} else if (!empty($exception)) {
					echo "<div class='container'><div class=' response-msg alert alert-danger alert-dismissible text-center'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
							<p> " . $exception . "</p>
						</div></div>"; 
					$this->session->unset_userdata('exception'); 		
					}
				?>	
			 
				 
							<div class=" col-sm-8 offset-2">
<form class="form-validation" action="<?php echo base_url('/user/register/check'); ?>" method="post">

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
	  
	<input type="submit" value="Register" id="button-login" data-loading-text="Loading..." class="btn btn-default btn-checkout">
 
	
   </div> 
   
   </form>
								
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


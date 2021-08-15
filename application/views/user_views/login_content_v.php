

<main class="main">
   <nav aria-label="breadcrumb" class="breadcrumb-nav">
      <div class="container">
         <ol class="breadcrumb mt-0">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="icon-home"></i></a></li>
            <!--<li class="breadcrumb-item"><a href="category.html">Categories</a></li>-->
            <li class="breadcrumb-item active" aria-current="page">Login</li>
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
        
					 
					
			 
				 
							<div class=" col-sm-6 offset-3">
								<form  class="form-validation" action="<?php echo base_url('user/login/check'); ?>" method="post">
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


<?php
$ver = '1.1.57';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php  if($seo_title){ echo $seo_title; }else{ echo $settings_info['seo_title']; } ?></title>
	<meta name="description" content="<?php  if($seo_description){ echo $seo_description; }else{ echo $settings_info['seo_description']; } ?>"/>
	<meta name="keywords" content="<?php  if($seo_keywords){ echo $seo_keywords; }else{ echo $settings_info['seo_tags']; } ?>"/>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/uploads/<?php echo $settings_info['site_favicon']; ?>">

	<link href="<?php echo base_url(); ?>assets/frontend/css/bootstrap.min.css?ver=<?php echo $ver; ?>" rel="stylesheet">	
	<link href="<?php echo base_url(); ?>assets/frontend/css/style.min.css?ver=<?php echo $ver; ?>" rel="stylesheet">	
	<link href="<?php echo base_url(); ?>assets/frontend/vendor/fontawesome-free/css/all.min.css?ver=<?php echo $ver; ?>" rel="stylesheet"> 
		
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
	
	<?php
	if( $this->router->fetch_class()=='products' and $this->router->fetch_method()=='details'){
	?>
	<!----------- gallery code ----------->  
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/slider/jquery.fancybox.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/slider/jquery.fancybox-thumbs.css" />
	<link href="<?php echo base_url(); ?>assets/frontend/css/zoom.css?ver=<?php echo $ver; ?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/css/custom-style.css?ver=<?php echo $ver; ?>" rel="stylesheet">
	<script src="<?php echo base_url(); ?>assets/frontend/slider/jquery-1.8.3.min.js"></script>
	<!----------------- gallery code ----------->
	<?php }else{
		?>
		<link href="<?php echo base_url(); ?>assets/frontend/css/custom-style.css?ver=<?php echo $ver; ?>" rel="stylesheet">
		<?php
	} ?>
	<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.min.js"></script>
	
	
</head>
	<body class="<?php if($class!=''){ echo $class; }else if($this->router->fetch_class()=='home'){  echo 'home';  }else{ echo 'page job-post no-back'; } ?>">  
	
	
  <div class="page-wrapper">
        <header class="header">
            <div class="header-top">
                <div class="container">

                    <div class="header-right">

                        <div class="header-dropdown dropdown-expanded">
                            <a href="#">Account</a>
                            <div class="header-menu">
                                <ul>
									<?php if($settings_info['phone_number']){ ?>
                                        <li><a href="tel:<?php echo $settings_info['phone_number']; ?>"><i class="fas fa-phone fa-rotate-90"></i> &nbsp; <?php echo $settings_info['phone_number']; ?> </a></li>
                                        <?php } ?> 
										<!--
										<li><a href="javascript:;"><i class="fas fa-map-marker-alt"></i><select class="form-control form-control-sm">
                                                <option>Select Your City</option>0
                                                <option>Haryana</option>
                                                <option>Chandigarh</option>
                                                <option>Punjab</option>

                                              </select></a>
										</li>
										-->
									<?php
									$customer_id = $this->session->userdata('customer_id');
									if ($customer_id == NULL) {
									?>									
                                    <li><a href="<?php echo base_url('/user/login'); ?>"   data-toggle="modal" data-target="#loginModal">Login/Sign up </a></li>
									<!--login-link-->
									<?php }else{ ?>
									
									<?php
									$account_name = $this->session->userdata('phone');
									if($this->session->userdata('firstname')){
									 $account_name = $this->session->userdata('firstname');
									}
									?>
									
									<li><a href="<?php echo base_url('/user/account'); ?>"><?php echo $account_name; ?> </a></li>
									<li><a href="<?php echo base_url('/user/logout'); ?>" class="">Log Out</a></li>
									
									<?php } ?>
                                </ul>
                            </div><!-- End .header-menu -->
                        </div><!-- End .header-dropown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-top -->

            <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <a href="<?php echo base_url(); ?>" class="logo">
                            <img src="<?php echo base_url(); ?>assets/uploads/<?php echo $settings_info['site_logo']; ?>" alt="">
                        </a>
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <div class="header-search">
                            <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                            <form action="/category" method="get">
                                <div class="header-search-wrapper">
                                    <input type="search" class="form-control" name="s" id="s" placeholder="Search Product Here...." value="<?php echo $_GET['s']; ?>" required>
                                    <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                    </div><!-- End .headeer-center -->

                    <div class="header-right">
                        <button class="mobile-menu-toggler" type="button">
                            <i class="icon-menu"></i>
                        </button>

                        <div class="dropdown cart-dropdown" id="car-dropdown">
							
                            <?php 
							
							echo $common_data_info['car_popup'];
							
							?>		
							
                        </div>

                    </div>
                </div>
                
                 <?php echo $nav_content; ?> 
                 
            </div>
            
        </header><!-- End .header -->	
	
			
		<?php
			$exception = $this->session->userdata('exception');
			$success = $this->session->userdata('success');
			
			
			if (!empty($success)) {		 
			echo "<div id='response_popup_msg' class='container'><div class='response-msg alert alert-success alert-dismissible text-center'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
					<p><i class='fa fa-check-circle'></i> " . $success . "</p>
				</div></div>"; 
			$this->session->unset_userdata('success'); 		
			} else if (!empty($exception)) {
			echo "<div  id='response_popup_msg' class='container'><div class=' response-msg alert alert-danger alert-dismissible text-center'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
					<p> " . $exception . "</p>
				</div></div>"; 
			$this->session->unset_userdata('exception'); 		
			}
		?>
	
	
	
	
	<?php echo $main_content; ?>   



        <footer class="footer">
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="widget widget-newsletter">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="widget-title">Subscribe newsletter</h4>
                                        <p>Get all the latest information on Events,Sales and Offers. Sign up for newsletter today</p>
                                    </div><!-- End .col-lg-6 -->

                                    <div class="col-lg-6">
                                        <form action="javascript:;">
                                            <input type="email" name="newslatter_email" id="newslatter_email" class="form-control" placeholder="Email address" >
                                            <input type="submit" class="btn btn-newslatter_email" value="Subscribe" >
											<div class="sms-newslatter_email"></div>
                                        </form>
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-md-9 -->

                        <div class="col-md-3 widget-social">
                            <div class="social-icons">
								<?php if($settings_info['facebook']){ ?>
                                <a href="<?php echo $settings_info['facebook']; ?>" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
								<?php } ?>
								
								<?php if($settings_info['twitter']){ ?>
                                <a href="<?php echo $settings_info['twitter']; ?>" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
								<?php } ?>
								
								<?php if($settings_info['linkedin']){ ?>
                                <a href="<?php echo $settings_info['linkedin']; ?>" class="social-icon" target="_blank"><i class="icon-linkedin"></i></a>
								<?php } ?>
								
                            </div><!-- End .social-icons -->
                        </div><!-- End .col-md-3 -->
                    </div><!-- End .row -->
                </div><!-- End .footer-top -->
            </div><!-- End .container -->

            <div class="footer-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Contact Us</h4>
                                <ul class="contact-info">
									<?php if($settings_info['contact_address']){ ?>
                                    <li>
                                        <span class="contact-info-label">Address:</span><?php echo $settings_info['contact_address']; ?>
                                    </li>
									<?php } ?>
									
									<?php if($settings_info['phone_number']){ ?>
                                    <li>
                                        <span class="contact-info-label">Phone:</span>Toll Free <a href="tel:<?php echo $settings_info['phone_number']; ?>"><?php echo $settings_info['phone_number']; ?></a>
                                    </li>
									<?php } ?>
									
									<?php if($settings_info['contact_email_address']){ ?>
                                    <li>
                                        <span class="contact-info-label">Email:</span> <a href="mailto:<?php echo $settings_info['contact_email_address']; ?>"><?php echo $settings_info['contact_email_address']; ?></a>
                                    </li>
									<?php } ?>
                                </ul>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-9">
                            <div class="row"> 
                                
								<?php echo $common_data_info['categories_footer_menu']; ?>	
								
                            </div><!-- End .row -->

                            <div class="footer-bottom">
							<?php if($settings_info['copyright']){ ?>
                                <p class="footer-copyright"><?php echo $settings_info['copyright']; ?></p>
							<?php } ?>
                                <img src="<?php echo base_url(); ?>assets/frontend/images/payments.png" alt="payment methods" class="footer-payments">
                            </div><!-- End .footer-bottom -->
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->

	<?php echo $nav_mobile_content; ?> 
	
	
	<!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="addCartModal" aria-hidden="true" >
      <div class="modal-dialog" role="document"  style="max-width: 524px;"  >
		
		<div class="modal-content">
		  <div class="modal-header text-center">
			<h4 class="modal-title w-100 font-weight-bold">Phone Number Verification</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
		  </div>
		  <div class="modal-body text-center"> 
			
			<div class="login__body">
				<form action="javascript:;" id="loginForm" >
				<div class="form-group">
				<label for="phone">Enter your phone number to </label>
				<input type="tel" id="phone" name="phone" class="form-control" placeholder="Phone number" required="" autofocus="">
				</div> 
				<button class="btn btn-lg btn-default btn-login btn-block" type="submit">Next</button>	
				</form>
				
				<div class="loginMsg"></div>
				
			</div>
			
		  </div>
		</div>
		
      </div>
    </div>
 
    <!-- Add Cart Modal -->
    <div class="modal fade" id="addCartModal" tabindex="-1" role="dialog" aria-labelledby="addCartModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body add-cart-box text-center">
              
			  
			  
          </div>
        </div>
      </div>
    </div>
	

    <div class="modal fade" id="modelMessage" tabindex="-1" role="dialog" aria-labelledby="addCartModal" aria-hidden="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body add-cart-box text-center"> 
            <div class="modal-msg"></div>
			<div class="btn-actions">
				<a href="#"><button class="btn-primary" data-dismiss="modal">Close</button></a>
			</div>
          </div>
        </div>
      </div>
    </div>


	<a id="scroll-top" href="#top" role="button"><i class="icon-angle-up"></i></a>

	<!-- Plugins JS File -->
	
	<script src="<?php echo base_url(); ?>assets/frontend/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/frontend/js/plugins.min.js"></script>

	<!-- Main JS File -->
	<script src="<?php echo base_url(); ?>assets/frontend/js/main.min.js"></script>

	<script>
	$(document).on('click', '.number-spinner button', function () {    
	var btn = $(this),
	oldValue = btn.closest('.number-spinner').find('input').val().trim(),
	newVal = 0;

	if (btn.attr('data-dir') == 'up') {
	newVal = parseInt(oldValue) + 1;
	} else {
	if (oldValue > 1) {
		newVal = parseInt(oldValue) - 1;
	} else {
		newVal = 1;
	}
	}
	btn.closest('.number-spinner').find('input').val(newVal);
	});
	</script>

 
	
	<script src="<?php echo base_url(); ?>assets/frontend/js/script.js?ver=<?php echo $ver; ?>"></script>
	
	
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo MAP_KEY; ?>&libraries=places&callback=initMap"
	async defer></script>
	<input type="hidden" id="googleidsearch" value="">
	<script src="<?php echo base_url(); ?>assets/frontend/js/map.js"></script>

	<?php
	if( $this->router->fetch_class()=='products' and $this->router->fetch_method()=='details'){
	?>
	<!-- gallery code --->
	<script src="<?php echo base_url(); ?>assets/frontend/slider/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/frontend/slider/jquery.fancybox.js"></script>
	<script src="<?php echo base_url(); ?>assets/frontend/slider/jquery.elevatezoom.js"></script>
	<script src="<?php echo base_url(); ?>assets/frontend/slider/panZoom.js"></script>
	<script src="<?php echo base_url(); ?>assets/frontend/slider/ui-carousel.js"></script>
	<script src="<?php echo base_url(); ?>assets/frontend/slider/zoom.js"></script>
	<!-- gallery code --->
	<?php } ?>

	
  </body>
</html>


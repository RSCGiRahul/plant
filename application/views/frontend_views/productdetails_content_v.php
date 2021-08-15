        <main class="main">

            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb mt-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="icon-home"></i></a></li>
                        <!--<li class="breadcrumb-item"><a href="category.html">Categories</a></li>-->
                        <li class="breadcrumb-item active" aria-current="page"><?php echo  $product_details['product_name']; ?></li>
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <div class="row">
					<!---------------->
					
                    <div class="col-lg-9">
                        <div class="product-single-container product-single-default custom-product-single-default">
                            <div class="row">
							
                                <div class="col-lg-6 col-md-6 product-single-gallery">
									
									
<!---------------- gallery -------------------->



 

	<div class="pdp-image-gallery-block">
		<!-- Gallery -->
				<!-- gallery Viewer -->
				<div class="gallery-viewer">
			
			<?php 
			/* echo  $product_details['product_name']; */ 
			$product_images = json_decode($product_details['product_images']);
			
			$gallery_featured = $v_product_list['gallery_featured'];
			if($gallery_featured==""){
				$gallery_featured = $product_images[0];
			}
			?>
			<img id="zoom_10" src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" data-zoom-image="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" />
			
			<!--<p class="hint-pdp-img">Roll over the image to zoom in</p>-->
		</div>

		<!-- gallery Viewer -->
		<div class="gallery_pdp_container">
			<div id="gallery_pdp">
			<div class="wrapper">
			
				
				<a href="javascript:;" data-image="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" data-zoom-image="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>">
					<img id="" src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" />
				</a>
			
				<?php
				foreach($product_images as $v_product_images){
					 
					if($v_product_images==$gallery_featured){ continue; }
				?> 
				
					
					<a href="javascript:;" data-image="<?php echo base_url('assets/uploads/product/'.$v_product_images.''); ?>" data-zoom-image="<?php echo base_url('assets/uploads/product/'.$v_product_images.''); ?>"  >
					<img id="" src="<?php echo base_url('assets/uploads/product/'.$v_product_images.''); ?>" />
				</a>
				<?php } ?> 
				 
			  
					</div>
				
				
			</div>
			<!-- Up and down button for vertical carousel -->
			<a href="javascript:;" id="ui-carousel-next" style="display: inline;"></a>
			<a href="javascript:;" id="ui-carousel-prev" style="display: inline;"></a>
		</div>
		<!-- Gallery -->


	</div>

 



 
	<div id="enlarge_gallery_pdp">
		<div class="enl_butt">
			<a class="enl_but enl_fclose" title="Close"></a>
			<a class="enl_but enl_fright" title="Next"></a>
			<a class="enl_but enl_fleft" title="Prev"></a>
		</div>
		<div class="mega_enl"></div>
	</div>




<!---------------- gallery -------------------->
									
									
									<?php /*
									
                                    <div class="product-slider-container product-item">
                                        <div class="product-single-carousel owl-carousel owl-theme">
											
											<?php  
											$product_images = json_decode($product_details['product_images']);
											
											$gallery_featured = $v_product_list['gallery_featured'];
											if($gallery_featured==""){
												$gallery_featured = $product_images[0];
											}
											?>
											
											<div class="product-item">
                                                <img class="product-single-image" src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" data-zoom-image="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>"/>
                                            </div>
											
											<?php
											foreach($product_images as $v_product_images){
												 
												if($v_product_images==$gallery_featured){ continue; }
											?> 
                                            <div class="product-item">
                                                <img class="product-single-image" src="<?php echo base_url('assets/uploads/product/'.$v_product_images.''); ?>" data-zoom-image="<?php echo base_url('assets/uploads/product/'.$v_product_images.''); ?>"/>
                                            </div>
											<?php } ?> 
                                        </div>
                                        <!-- End .product-single-carousel -->
                                        <span class="prod-full-screen">
                                            <i class="icon-plus"></i>
                                        </span>
                                    </div>
                                    <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
									
                                        <div class="col-3 owl-dot">
                                            <img src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>"/>
                                        </div>
										<?php
										foreach($product_images as $v_product_images){
												 
											if($v_product_images==$gallery_featured){ continue; }
											?>
											 <div class="col-3 owl-dot">
												<img src="<?php echo base_url('assets/uploads/product/'.$v_product_images.''); ?>"/>
											</div>
											<?php
										}
										?>    
                                    </div>
									
									*/ ?>
									
									
                                </div><!-- End .col-lg-7 -->

                                <div class="col-lg-6 col-md-6">
                                    <div class="product-single-details">
                                        <h1 class="product-title"><?php echo  $product_details['product_name']; ?></h1>
										
										<?php
										
										$price = $product_details['price']; 
										$price_id = '0'; 
										$discount = '0';
										$discount_price = '0';
										
										if($price>0){
											$discount = $product_details['discount']; 
											$discount_price = $product_details['discount_price']; 
										}else{ 
											$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$product_details['product_id']."' order by price ";
											$query_price_option = $this->db->query($sql_price_option);
											$result_price_option = $query_price_option->result();
											
											$price_id = $result_price_option[0]->price_id; 
											
											$price = $result_price_option[0]->price; 
											$discount = $result_price_option[0]->discount;
											$discount_price = $result_price_option[0]->discount_price;  
										}
										
										if($discount>0){
										?>
										<div class="price-box">
										<span class="old-price">
										MRP: <?php echo CURRENCY.$price; ?></span>
										<span class="product-price">
										Price: <?php echo CURRENCY.$discount_price; ?></span>
										<span class="discount-price">
										You Save: <?php echo $discount; ?>% 
										</span>
										</div>
										<?php
										}else{
										?>
										
										<div class="price-box">
										<span class="product-price">
										Price: <?php echo CURRENCY.$price; ?></span>
										</div>
										
										<?php } ?>


	
										<form action="javascript:;" class="details-product-listing-frm" id="product-<?php echo $product_details['product_id']; ?>"> 
                                        <div class="product-action product-all-icons">
											
												 
												<input type="hidden" name="product_id" value="<?php echo $product_details['product_id']; ?>">
												
												 												
												<input type="hidden"  class="hidden_price_option" name="price_option" product_id="<?php echo $product_details['product_id']; ?>" value="<?php echo $price_id; ?>">
												 
											
												<div class="product-single-qty">
													<input class="horizontal-quantity form-control" type="text"  id="quantity" name="quantity"  max="500" min="1" >
												</div> 

												<a href="javascript:;" class="paction add-cart btn-add-cart" title="Add to Cart">
													<span>Add to Basket</span>
												</a>
												<!--
												<a href="javascript:;" class="paction add-wishlist btn-add-wishlist" title="Add to Wishlist">
													<span>SAVE</span>
												</a>
												-->
												
											
                                        </div>
										</form>

										<?php 
										if($result_price_option!=""){  
										?>
                                        <div class="pack-sizes">
                                            <span>Pack Sizes</span>
                                            <ul>
												<?php 
												$i=0;
												foreach($result_price_option as $v_price_option){  
												$i++;
												?>
												
                                                <li class="btn-select-size <?php if($i==1){ echo 'active'; } ?>" price_id="<?php echo $v_price_option->price_id; ?>" json_data='<?php echo json_encode($v_price_option); ?>' >
												
													<span><?php echo $v_price_option->name; ?></span> 
													
													<?php 
													if($v_price_option->discount>0){ ?>
													
													 
													<span>
													<span style="color:#000000;"> <?php echo CURRENCY.$v_price_option->discount_price; ?></span> 
													
													MRP: <strike><?php echo CURRENCY.$v_price_option->price; ?></strike>  
													
													<span style="color:#f28058;"><?php echo $v_price_option->discount; ?>% Off</span> </span> 
													
													<span class="check-check"><i class="fas fa-check"></i></span>
													
													<?php }else{ ?>
													
													
													<span>
													<span style="color:#000000;"> <?php echo CURRENCY.$v_price_option->price; ?></span> 
													  </span> 
													
													<span class="check-check"><i class="fas fa-check"></i></span>
														
													<?php } ?>
												</li>
												<?php } ?>
												
												
												 
												 
                                            </ul>
                                        </div>
										<?php  
										}
										?>

                                    </div><!-- End .product-single-details -->
                                </div><!-- End .col-lg-5 -->
                            </div><!-- End .row -->


                            <div class="detail-prod">
                                <h3><?php echo  $product_details['product_name']; ?></h3>
                                <ul>
									<?php foreach($product_attributes as $v_product_attributes){ ?>
                                    <li><span><?php echo $v_product_attributes['attribute_name']; ?></span>
                                    <p><?php echo $v_product_attributes['product_attribute_description']; ?></p></li>
									<?php } ?> 
									
                                </ul>
                            </div>
                        </div><!-- End .product-single-container -->
                    </div><!-- End .col-lg-9 -->
					
					<!---------------->
					
                    <aside class="sidebar-shop custom-sidebar-shop col-lg-3 order-lg-first">
                        <div class="sidebar-wrapper">
                            <div class="widget">
                                <h3 class="widget-title">
                                    Category
                                </h3>

                                <div class="" id="">
                                    <div class="widget-body">
                                        <ul class="cat-list">
                                            <?php 
											foreach($categories as $category){
											?>
                                            <li><a href="<?php echo base_url().'category/'.$category['seo_url']; ?>"><?php echo $category['category_name']; ?></a></li>
											<?php } ?> 
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                        

                        </div><!-- End .sidebar-wrapper -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->

                <nav class="toolbox custom-toolbox">
                        <div class="toolbox-item toolbox-show">
                            <label>Related Product</label>
                        </div><!-- End .toolbox-item -->
                    </nav>
		
                    <div class="row row-sm">
							
							<?php  
							foreach($product_list as $v_product_list){
									
									$product_id = $v_product_list['product_id'];
									
									$product_images = json_decode($v_product_list['product_images']);
									
									$gallery_featured = $v_product_list['gallery_featured'];
									if($gallery_featured==""){
										$gallery_featured = $product_images[0];
									}
									
									$product_name = $v_product_list['product_name']; 
								
								 
									$result_price_option = '';
									$discount_box = '';
									$price = $v_product_list['price']; 
									$discount = '0';
									$discount_price = '0';
									
									if($price>0){
										$discount = $v_product_list['discount']; 
										$discount_price = $v_product_list['discount_price']; 
									}else{ 
										$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$v_product_list['product_id']."' order by price ";
										$query_price_option = $this->db->query($sql_price_option);
										$result_price_option = $query_price_option->result();
										$price = $result_price_option[0]->price; 
										$discount = $result_price_option[0]->discount;
										$discount_price = $result_price_option[0]->discount_price;  
									}
									
									
									 
									if($discount>0){
									
									$price_box='<div class="price-box sm-price-box-'.$product_id.'"> 
                                            <span class="product-price">MRP: <strike> '.CURRENCY.$price.'</strike> 
                                            <strong>'.CURRENCY.$discount_price.'</strong></span>
                                        </div>';
										
									$discount_box = '<span class="off-dis">Get '.$discount.'% Off</span>';	
									
									}else{
										
										$price_box='<div class="price-box sm-price-box-'.$product_id.' ">
                                            <span class="product-price">MRP:  
                                            <strong>'.CURRENCY.$price.'</strong></span>
                                        </div>';
										
									}
									
									
									
								$seo_url=base_url('/product/details/'.$v_product_list['seo_url'].'');
									
								?>
								<div class="col-6 col-md-3"> 
								<form action="javascript:;" class="product-listing-frm" id="product-<?php echo $product_id; ?>">
                                <div class="product-default">
                                    <figure>
                                        <a href="<?php echo $seo_url; ?>">
                                            <img src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" alt="<?php echo $v_product_list['product_name']; ?>">
                                        </a>
                                        
										<a href="<?php echo $seo_url; ?>"><?php echo $discount_box; ?></a>
										
                                    </figure>
                                    <div class="product-details">
										
                                        <h2 class="product-title">
                                            <?php echo $product_name; ?>
                                        </h2>
										
										<?php if($result_price_option!=""){ ?>
                                        <select class="form-control form-control-sm sm-price_option" name="price_option" product_id="<?php echo $product_id; ?>" >
										  <?php foreach($result_price_option as $v_price_option){ 
										  if($v_price_option->discount>0){
											  $v_price_option->price = $v_price_option->discount_price;
										  }
										  ?>	
                                          <option value="<?php echo $v_price_option->price_id; ?>"><?php echo $v_price_option->name." - ".CURRENCY_OPTION.$v_price_option->price; ?></option>
										  <?php } ?>
                                        </select>
										<?php }else{
											if($v_product_list['weight']){ echo "<p>".$v_product_list['weight']."</p>"; }
										} ?>
										
										<?php echo $price_box; ?>
										
                                        <div class="product-action">
                                            <div class="row no-gutters w-100">
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label for="inputPassword" class="">Qty:</label>
                                                          <input type="number" class="form-control" id="quantity" name="quantity" placeholder="1" max="500" min="1" value="1">
                                                      </div>
                                                </div>
                                                <div class="col-md-6"> <!-- addCartModal -->
													<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
                                                    <button class="btn-icon btn-add-cart" ><i class="icon-bag"></i>ADD</button>
                                                </div>
                                            </div> 
                                        </div>
										
                                    </div><!-- End .product-details -->
                                </div>
								</form>
                            </div>
                            
								
								<?php
								 
							}
							?>		         
						
					</div> 

            </div><!-- End .container -->

            <div class="mb-5"></div><!-- margin -->
        </main><!-- End .main -->

 
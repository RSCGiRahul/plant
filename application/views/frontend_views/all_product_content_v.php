 <main class="main">

             <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb mt-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="icon-home"></i></a></li>
                        <!--<li class="breadcrumb-item"><a href="category.html">Categories</a></li>-->
                        
						<li class="breadcrumb-item active" aria-current="page">Categories</li>
						
                    </ol>
                </div><!-- End .container -->
            </nav>

            
			    <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <nav class="toolbox custom-toolbox">

                            <div class="toolbox-item toolbox-show">
                                <label><?php echo $main_title; ?></label>
                            </div><!-- End .toolbox-item -->

                            <div class="toolbox-left">
                                <div class="toolbox-item toolbox-sort">
                                    <div class="select-custom">
                                        <select name="orderby" id="orderby" class="form-control">
                                            <option value="date" selected="">Sort by newness</option>
											<option value="date-desc" >Sort by old</option>
                                            <option value="popularity">Sort by popularity</option>
                                            <option value="price">Sort by price: low to high</option>
                                            <option value="price-desc">Sort by price: high to low</option>
                                        </select>
                                    </div><!-- End .select-custom -->

                                    
                                </div><!-- End .toolbox-item -->
                            </div><!-- End .toolbox-left -->
                        </nav>
						
						
						<div id="product_list" class="row row-sm">
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
								 <div class="col-6 col-md-4">  
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
								
								<?php
								$PAGINATION = PAGINATION_FRONT;
								$search='';
								$sl = 1;  
								$range = RANGE;  
								$totalpages = ceil($product_list_count / $PAGINATION); 
								if (isset($currentpage) && is_numeric($currentpage)) {
								$currentpage = (int) $currentpage;
								} else {
								$currentpage = 1;
								} 

								
								 
								if($currentpage > $totalpages) { 
								  $currentpage = $totalpages;
								} 

								if ($currentpage < 1) { 
									$currentpage = 1;
								}  
								
								if($product_list_count>$PAGINATION){  
									$nextpage = $currentpage + 1;
									?>
								 <div class="col-sm-12">
								  <button class="btn show-more" currentpage="<?php echo $nextpage; ?>" id="btn-show-more">Show More</button>
								</div>
								<?php  } ?>								
						
						
                       
						
						
                    </div><!-- End .col-lg-9 -->
					
					
                    <aside class="sidebar-shop custom-sidebar-shop col-lg-3 order-lg-first">
					    <form method="post" id="filter-search" action="javascript:;">
						<input type="hidden" value="<?php echo $_REQUEST['t']; ?>" name="t" id="t">
						<input type="hidden" value="<?php echo $_REQUEST['s']; ?>" name="s" id="s">
						
						
                        <div class="sidebar-wrapper">
						
                            <div class="widget">
								<input type="hidden" value="<?php echo $category_id; ?>" name="category_id">
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

                             <div class="widget">
                                <h3 class="widget-title">
                                    Brand
                                </h3>

                                <div class="" id="">
                                    <div class="widget-body">
                                            <input type="text" class="form-control" id="filter_Brand" aria-describedby="emailHelp" placeholder="Search By Brand">
                                        <ul class=" cat-list" id="filter_Brand_ul">
											<?php 
											foreach($brand_list as $v_brand_list){
											?>
                                            <li>  <div class="form-check">
                                                    <input type="checkbox" name="brand_search" class="form-check-input" value="<?php echo $v_brand_list['brand_id']; ?>" id="brand_name_<?php echo $v_brand_list['brand_id']; ?>">
                                                    <label class="form-check-label" for="brand_name_<?php echo $v_brand_list['brand_id']; ?>"><?php echo $v_brand_list['brand_name']; ?></label>
                                                  </div>
											</li>
											<?php } ?>
												 
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->


				
					
							<div class="widget">
                                        <h3 class="widget-title">
                                                Price
                                        </h3>
        
                                        <div class="" id="">
                                            <div class="widget-body">
                                                <ul class="cat-list">
													
													<?php
													$price_arr = array();
													$price_arr['0-20'] = 'Less than Rs  20';
													$price_arr['21-50'] = 'Rs 21 to Rs 50';
													$price_arr['51-100'] = 'Rs 51 to Rs 100';
													$price_arr['101-200'] = 'Rs 101 to Rs 200';
													$price_arr['201-500'] = 'Rs 201 to Rs 500';
													$price_arr['501-900000'] = 'More than Rs 501 ';
													$i=0;
													foreach($price_arr as $key=>$price_arr_v){
													$i++;
													?>
													<li>  
														<div class="form-check">
                                                            <input type="checkbox"  name="price_search"  class="form-check-input" id="price_<?php echo $i; ?>" value="<?php echo $key; ?>" >
                                                            <label class="form-check-label" for="price_<?php echo $i; ?>">
																<?php echo $price_arr_v; ?>
															</label>
                                                         </div>
													</li>
													<?php } ?>	
														
														
                                                </ul>
                                            </div> 
                                        </div> 
                                    </div> 
									
									
									<div class="widget">
                                        <h3 class="widget-title">
                                                Discount
                                        </h3>
        
                                        <div class="" id="">
                                            <div class="widget-body">
                                                <ul class="cat-list">
													
													<?php
													$discount_arr = array();
													$discount_arr['1-5'] = 'Upto 5% ';
													$discount_arr['5-10'] = '5% - 10%';
													$discount_arr['10-15'] = '10% - 15%';
													$discount_arr['15-20'] = '15% - 20%';
													$discount_arr['25-100'] = 'More than 25%';
											 
													$i=0;
													foreach($discount_arr as $key=>$discount_arr_v){
													$i++;
													?>
													<li>  
														<div class="form-check">
                                                            <input type="checkbox"  name="discount_search"  class="form-check-input" id="discount_<?php echo $i; ?>" value="<?php echo $key; ?>" >
                                                            <label class="form-check-label" for="discount_<?php echo $i; ?>">
																<?php echo $discount_arr_v; ?>
															</label>
                                                         </div>
													</li>
													<?php } ?>	
														
														
                                                </ul>
                                            </div> 
                                        </div> 
                                    </div> 
							
						

                            
                                         
                        </div><!-- End .sidebar-wrapper -->
						
						
						</form>
                    </aside><!-- End .col-lg-3 -->
                
				
				</div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-5"></div><!-- margin -->
        </main><!-- End .main -->

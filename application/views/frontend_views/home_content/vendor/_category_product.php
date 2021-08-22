

        
		
		
            <div class="product-default">
				<form action="javascript:;" class="product-listing-frm" id="product-<?php echo $category['product_id']; ?>">
                <figure>
					
					<a href="<?php echo base_url('/product/details/'.$category['seo_url']); ?>">
					<img src="<?php echo base_url('assets/uploads/product/'.$category['gallery_featured'].''); ?>" alt="">
					</a>
                   <?php // echo $discount_box; ?>
                </figure>
				
                <div class="product-details product-details-pd">
                    <h2 class="product-title"><?php echo $category['product_name']; ?></h2>
                    
					<div class="product-pr-option">
					    
					    <div class="map-container">
                    		<div class="inner-basic division-map div-toggle" data-target=".division-details" id="">
                    		  <button class="map-point-sm" data-show=".retailprice_<?php echo $category['product_id']; ?>">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for retail price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		  <?php  if ($category['is_whole_sale'] == 1 ) { ?>
								
	                    		  <button class="map-point-sm" data-show=".wholesaleprice_<?php echo $category['category_id'].'_'.$category['product_id'];  ?>">
	                    			<div class="content">
	                    			  <div class="centered-y">
	                    				<p>Click for wholesale price</p>
	                    			  </div>
	                    			</div>
								
	                    		  </button>
                    		<?php } ?>
                    		</div><!-- end inner basic -->
                	  </div>
	  
	  
                	  <?php
					  
					  $wholesaleArr = (array)json_decode($category['wholesale_price']);

					  usort($wholesaleArr, function ($a, $b) {
						  return $a->price - $b->price;
					  });


 include('category_product_wholesale_price.php'); 

					 ?>
	 
					</div>
					
					

                   
                    <div class="product-action">
						<div class="row no-gutters w-100">
							<div class="col-md-6">
								  <div class="form-group">
									<label for="inputPassword" class="">Qty:</label>
									  <input type="number" class="form-control" id="quantity" name="quantity" placeholder="1" max="500" min="1" value="1">
								  </div>
							</div>
							<div class="col-md-6"> <!-- addCartModal -->
								<input type="hidden" name="product_id" value="<?php echo $category['product_id']; ?>" >
								<button class="btn-icon btn-add-cart" ><i class="icon-bag"></i>ADD</button>
							</div>
						</div> 
					</div>
					
					
                </div>
                </form>
            </div>
            
	

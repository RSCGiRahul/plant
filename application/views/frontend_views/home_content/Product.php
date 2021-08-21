<?php
$product_type =$v_home_content['product_type']; 
$special_category = json_decode($v_home_content['special_category']); 

$product_type = $v_home_content['product_type']; 
if($product_type=='most_seller'){
	
	/*most_seller*/
	include 'application/views/frontend_views/home_content/Product-style-1.php'; 
	/*most_seller*/
	
	
}else{ 

		$order='product.product_id';
		$orderby='desc';

		$this->db->select('product.*')
		->from('dir_product as product')  
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->order_by(''.$order.'', ''.$orderby.'')
		->limit(10);	 
		
		$where = ' 1=1';
		
		if($special_category){
		  $where .= '   and( ';  
		   $i=0;
			foreach($special_category as $v_special_category){
				 $i=$i+1;
				 if($i!=1){ $where .= ' OR '; }
				 $where .= '  FIND_IN_SET("'.$v_special_category.'", product.product_category)  ';  
			}
			$where .= '   ) ';  
			
		}
		
		$this->db->where( $where ); 		
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		

		

if($result){
?>

<div class="featured-products-section carousel-section">
    <div class="container">
        <h2 class="h3 title mb-4 text-center custom-heading"><?php echo $v_home_content['title']; ?></h2>

        <div class="featured-products owl-carousel owl-theme">
			<?php 
			foreach($result as $v_product_list){ 
					$product_id = $v_product_list['product_id'];
					
					$product_images = json_decode($v_product_list['product_images']);
					
					$gallery_featured = $v_product_list['gallery_featured'];
					if($gallery_featured==""){
						$gallery_featured = $product_images[0];
					}
					
					$product_name = $v_product_list['product_name']; 
				
				 
					$result_price_option = '';
					$result_wholesale_price_option = '';
					$discount_box = '';
					$price = $v_product_list['price']; 
					$discount = '0';
					$discount_price = '0';
					
					$ws_price = '0';
					$ws_discount ='0';
					$ws_discount_price ='0';
$wholesaleArr =[];

						$result_wholesale_price_query = "SELECT * FROM dir_product_wholesale where `product_id`= '".$v_product_list['product_id']."' ";
						$result_wholesale_price_query_price_option = $this->db->query($result_wholesale_price_query);
						$result_wholesale_price_option = $result_wholesale_price_query_price_option->row_array();
$wholesaleArr = (array)json_decode($result_wholesale_price_option['wholesale_price']);

							usort($wholesaleArr, function ($a, $b) {
								return $a->price - $b->price;
							});
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


// dump(json_decode($wholesale_price->wholesale_price));
						


					}
					
			
						
					if($discount>0){
									
						$price_box='<div class="price-box sm-price-box-'.$product_id.'"> 
								<span class="product-price">MRP: <strike> '.CURRENCY.$price.'</strike> 
								<strong>'.CURRENCY.$discount_price.'</strong></span>
							</div>';
							
						$discount_box = '<div class="sale-new">
                                <h6 class="text">Get '.$discount.'% Off</h6>
                        </div>';	
						
						}else{
							
							$price_box='<div class="price-box sm-price-box-'.$product_id.' ">
								<span class="product-price">MRP:  
								<strong>'.CURRENCY.$price.'</strong></span>
							</div>';
							
						}
				$seo_url=base_url('/product/details/'.$v_product_list['seo_url'].'');
			?>
		
            <div class="product-default">
				<form action="javascript:;" class="product-listing-frm" id="product-<?php echo $product_id; ?>">
                <figure>
					<a href="<?php echo $seo_url; ?>">
					<img src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" alt="">
					</a>
                   <?php echo $discount_box; ?>
                </figure>
				
                <div class="product-details product-details-pd">
                    <h2 class="product-title"><?php echo $product_name; ?></h2>
                    
					<div class="product-pr-option">
					    
					    <div class="map-container">
                    		<div class="inner-basic division-map div-toggle" data-target=".division-details" id="">
                    		  <button class="map-point-sm" data-show=".retailprice_<?php echo $v_product_list['product_id']; ?>">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for retail price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		  <?php  if ($v_product_list['is_whole_sale'] ) { ?>
	                    		  <button class="map-point-sm" data-show=".wholesaleprice_<?php echo $v_product_list['product_id']; ?>">
	                    			<div class="content">
	                    			  <div class="centered-y">
	                    				<p>Click for wholesale price dsfsdfd</p>
	                    			  </div>
	                    			</div>
	                    		  </button>
                    		<?php } ?>
                    		</div><!-- end inner basic -->
                	  </div>
	  
	  
                	  <?php include('vendor/_whole_sale_price.php'); ?>
	 
					</div>
					
<style>
    .hide {
        display: none;
    }
    .map-container {
         text-align: center;
    }
    button.map-point-sm {
        border: 1px solid #dc9a19;
        margin-bottom: 5px;
        border-radius: 21px;
        background: #ffffff;
        font-weight: 600;
        padding: 0px 10px;
        cursor: pointer;
        color: #429612;
    }button.map-point-sm:focus {
        background: #dc9a19;
        color: white;
        outline: none;
    }
    button.map-point-sm p {
        margin: 0;
        padding: 5px;
        font-size: 12px;
    }input.wholesale_input {
        margin-right: 5px;
    }
</style>
					
<script>
      $(document).on('click', '.map-point-sm', function() {
        var show = $(this).data('show');
        $(show).removeClass("hide").siblings().addClass("hide");
      });
      
      
      
      
      //checkbox single
      $("input:checkbox").on('click', function() {
        var $box = $(this);
        if ($box.is(":checked")) {
          var group = "input:checkbox[name='" + $box.attr("name") + "']";
          $(group).prop("checked", false);
          $box.prop("checked", true);
        } else {
          $box.prop("checked", false);
        }
      });
</script>
                   
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
					
					
                </div>
                </form>
            </div>
            
			<?php } ?> 

	   </div>
        <!-- End .featured-proucts -->
    </div>
    <!-- End .container -->
</div>

<div class="mb-5"></div>


<!--indoor plants-->
<div class="featured-products-section carousel-section">
    <div class="container">
        <h2 class="h3 title mb-4 text-center custom-heading">Indoor Plants</h2>

        <div class="featured-products owl-carousel owl-theme">
			<?php 
			foreach($result as $v_product_list){ 
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
							
						$discount_box = '<div class="sale-new">
                                <h6 class="text">Get '.$discount.'% Off</h6>
                        </div>';	
						
						}else{
							
							$price_box='<div class="price-box sm-price-box-'.$product_id.' ">
								<span class="product-price">MRP:  
								<strong>'.CURRENCY.$price.'</strong></span>
							</div>';
							
						}
				$seo_url=base_url('/product/details/'.$v_product_list['seo_url'].'');
			?>
		
            <div class="product-default">
				<form action="javascript:;" class="product-listing-frm" id="product-<?php echo $product_id; ?>">
                <figure>
					<a href="<?php echo $seo_url; ?>">
					<img src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" alt="">
					</a>
                   <?php echo $discount_box; ?>
                </figure>
				
                <div class="product-details product-details-pd">
                    <h2 class="product-title"><?php echo $product_name; ?></h2>
                    
					<div class="product-pr-option">
					    
					    <div class="map-container">
                    		<div class="inner-basic division-map div-toggle" data-target=".division-details" id="">
                    		  <button class="map-point-sm" data-show=".retailprice">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for retail price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		  <button class="map-point-sm" data-show=".wholesaleprice">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for wholesale price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		</div><!-- end inner basic -->
                	  </div>
	  
	  
                	  <div class="map-container">
                		<div class="inner-basic division-details">
                		  <div class="retailprice hide">
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
                		  </div>
                		  
                		  <div class="wholesaleprice hide">
                			<div class="wholesale_price">
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 10 -MRP ₹<span class="product_wholesale_price">2200</span>	
                        				<offerprice>₹1100</offerprice>		
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 20 -MRP ₹<span class="product_wholesale_price">1200</span>	
                        				<offerprice>₹1000</offerprice>	
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 50 -MRP ₹<span class="product_wholesale_price">2000</span>	
                        				<offerprice>₹1000</offerprice>		
                        			</label>
                        		  </div>
                        	  </div>
                		  </div>
                		</div>
                	  </div>
	 
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
								<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
								<button class="btn-icon btn-add-cart" ><i class="icon-bag"></i>ADD</button>
							</div>
						</div> 
					</div>
					
					
                </div>
                </form>
            </div>
            
			<?php } ?> 

	   </div>
        <!-- End .featured-proucts -->
    </div>
    <!-- End .container -->
</div>

<div class="mb-5"></div>


<!--outdoor plants-->

<div class="featured-products-section carousel-section">
    <div class="container">
        <h2 class="h3 title mb-4 text-center custom-heading">Outdoor Plants</h2>

        <div class="featured-products owl-carousel owl-theme">
			<?php 
			foreach($result as $v_product_list){ 
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
							
						$discount_box = '<div class="sale-new">
                                <h6 class="text">Get '.$discount.'% Off</h6>
                        </div>';	
						
						}else{
							
							$price_box='<div class="price-box sm-price-box-'.$product_id.' ">
								<span class="product-price">MRP:  
								<strong>'.CURRENCY.$price.'</strong></span>
							</div>';
							
						}
				$seo_url=base_url('/product/details/'.$v_product_list['seo_url'].'');
			?>
		
            <div class="product-default">
				<form action="javascript:;" class="product-listing-frm" id="product-<?php echo $product_id; ?>">
                <figure>
					<a href="<?php echo $seo_url; ?>">
					<img src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" alt="">
					</a>
                   <?php echo $discount_box; ?>
                </figure>
				
                <div class="product-details product-details-pd">
                    <h2 class="product-title"><?php echo $product_name; ?></h2>
                    
					<div class="product-pr-option">
					    
					    <div class="map-container">
                    		<div class="inner-basic division-map div-toggle" data-target=".division-details" id="">
                    		  <button class="map-point-sm" data-show=".retailprice">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for retail price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		  <button class="map-point-sm" data-show=".wholesaleprice">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for wholesale price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		</div><!-- end inner basic -->
                	  </div>
	  
	  
                	  <div class="map-container">
                		<div class="inner-basic division-details">
                		  <div class="retailprice hide">
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
                		  </div>
                		  
                		  <div class="wholesaleprice hide">
                			<div class="wholesale_price">
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 10 -MRP ₹<span class="product_wholesale_price">200</span>	
                        				<offerprice>₹100</offerprice>		
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 20 -MRP ₹<span class="product_wholesale_price">200</span>	
                        				<offerprice>₹100</offerprice>	
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 50 -MRP ₹<span class="product_wholesale_price">200</span>	
                        				<offerprice>₹100</offerprice>	
                        			</label>
                        		  </div>
                        	  </div>
                		  </div>
                		</div>
                	  </div>
	 
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
								<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
								<button class="btn-icon btn-add-cart" ><i class="icon-bag"></i>ADD</button>
							</div>
						</div> 
					</div>
					
					
                </div>
                </form>
            </div>
            
			<?php } ?> 

	   </div>
        <!-- End .featured-proucts -->
    </div>
    <!-- End .container -->
</div>

<div class="mb-5"></div>

<!--combo pack-->

<div class="featured-products-section carousel-section">
    <div class="container">
        <h2 class="h3 title mb-4 text-center custom-heading">Combo Pack</h2>

        <div class="featured-products owl-carousel owl-theme">
			<?php 
			foreach($result as $v_product_list){ 
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
							
						$discount_box = '<div class="sale-new">
                                <h6 class="text">Get '.$discount.'% Off</h6>
                        </div>';	
						
						}else{
							
							$price_box='<div class="price-box sm-price-box-'.$product_id.' ">
								<span class="product-price">MRP:  
								<strong>'.CURRENCY.$price.'</strong></span>
							</div>';
							
						}
				$seo_url=base_url('/product/details/'.$v_product_list['seo_url'].'');
			?>
		
            <div class="product-default">
				<form action="javascript:;" class="product-listing-frm" id="product-<?php echo $product_id; ?>">
                <figure>
					<a href="<?php echo $seo_url; ?>">
					<img src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" alt="">
					</a>
                   <?php echo $discount_box; ?>
                </figure>
				
                <div class="product-details product-details-pd">
                    <h2 class="product-title"><?php echo $product_name; ?></h2>
                    
					<div class="product-pr-option">
					    
					    <div class="map-container">
                    		<div class="inner-basic division-map div-toggle" data-target=".division-details" id="">
                    		  <button class="map-point-sm" data-show=".retailprice">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for retail price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		  <button class="map-point-sm" data-show=".wholesaleprice">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for wholesale price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		</div><!-- end inner basic -->
                	  </div>
	  
	  
                	  <div class="map-container">
                		<div class="inner-basic division-details">
                		  <div class="retailprice hide">
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
                		  </div>
                		  
                		  <div class="wholesaleprice hide">
                			<div class="wholesale_price">
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 10 -MRP ₹<span class="product_wholesale_price">200</span>	
                        				<offerprice>₹100</offerprice>		
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 20 -MRP ₹<span class="product_wholesale_price">200</span>	
                        				<offerprice>₹100</offerprice>	
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 50 -MRP ₹<span class="product_wholesale_price">200</span>	
                        				<offerprice>₹100</offerprice>	
                        			</label>
                        		  </div>
                        	  </div>
                		  </div>
                		</div>
                	  </div>
	 
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
								<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
								<button class="btn-icon btn-add-cart" ><i class="icon-bag"></i>ADD</button>
							</div>
						</div> 
					</div>
					
					
                </div>
                </form>
            </div>
            
			<?php } ?> 

	   </div>
        <!-- End .featured-proucts -->
    </div>
    <!-- End .container -->
</div>

<div class="mb-5"></div>




<!--air purifier-->

<div class="featured-products-section carousel-section">
    <div class="container">
        <h2 class="h3 title mb-4 text-center custom-heading">Air Purifier</h2>

        <div class="featured-products owl-carousel owl-theme">
			<?php 
			foreach($result as $v_product_list){ 
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
							
						$discount_box = '<div class="sale-new">
                                <h6 class="text">Get '.$discount.'% Off</h6>
                        </div>';	
						
						}else{
							
							$price_box='<div class="price-box sm-price-box-'.$product_id.' ">
								<span class="product-price">MRP:  
								<strong>'.CURRENCY.$price.'</strong></span>
							</div>';
							
						}
				$seo_url=base_url('/product/details/'.$v_product_list['seo_url'].'');
			?>
		
            <div class="product-default">
				<form action="javascript:;" class="product-listing-frm" id="product-<?php echo $product_id; ?>">
                <figure>
					<a href="<?php echo $seo_url; ?>">
					<img src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" alt="">
					</a>
                   <?php echo $discount_box; ?>
                </figure>
				
                <div class="product-details product-details-pd">
                    <h2 class="product-title"><?php echo $product_name; ?></h2>
                    
					<div class="product-pr-option">
					    
					    <div class="map-container">
                    		<div class="inner-basic division-map div-toggle" data-target=".division-details" id="">
                    		  <button class="map-point-sm" data-show=".retailprice">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for retail price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		  <button class="map-point-sm" data-show=".wholesaleprice">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for wholesale price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		</div><!-- end inner basic -->
                	  </div>
	  
	  
                	  <div class="map-container">
                		<div class="inner-basic division-details">
                		  <div class="retailprice hide">
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
                		  </div>
                		  
                		  <div class="wholesaleprice hide">
                			<div class="wholesale_price">
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 10 -MRP ₹<span class="product_wholesale_price">200</span>	
                        				<offerprice>₹100</offerprice>		
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 20 -MRP ₹<span class="product_wholesale_price">200</span>	
                        				<offerprice>₹100</offerprice>		
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 50 -MRP ₹<span class="product_wholesale_price">200</span>	
                        				<offerprice>₹100</offerprice>		
                        			</label>
                        		  </div>
                        	  </div>
                		  </div>
                		</div>
                	  </div>
	 
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
								<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
								<button class="btn-icon btn-add-cart" ><i class="icon-bag"></i>ADD</button>
							</div>
						</div> 
					</div>
					
					
                </div>
                </form>
            </div>
            
			<?php } ?> 

	   </div>
        <!-- End .featured-proucts -->
    </div>
    <!-- End .container -->
</div>

<div class="mb-5"></div>




<!--flower-->

<div class="featured-products-section carousel-section">
    <div class="container">
        <h2 class="h3 title mb-4 text-center custom-heading">Flower</h2>

        <div class="featured-products owl-carousel owl-theme">
			<?php 
			foreach($result as $v_product_list){ 
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
							
						$discount_box = '<div class="sale-new">
                                <h6 class="text">Get '.$discount.'% Off</h6>
                        </div>';	
						
						}else{
							
							$price_box='<div class="price-box sm-price-box-'.$product_id.' ">
								<span class="product-price">MRP:  
								<strong>'.CURRENCY.$price.'</strong></span>
							</div>';
							
						}
				$seo_url=base_url('/product/details/'.$v_product_list['seo_url'].'');
			?>
		
            <div class="product-default">
				<form action="javascript:;" class="product-listing-frm" id="product-<?php echo $product_id; ?>">
                <figure>
					<a href="<?php echo $seo_url; ?>">
					<img src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" alt="">
					</a>
                   <?php echo $discount_box; ?>
                </figure>
				
                <div class="product-details product-details-pd">
                    <h2 class="product-title"><?php echo $product_name; ?></h2>
                    
					<div class="product-pr-option">
					    
					    <div class="map-container">
                    		<div class="inner-basic division-map div-toggle" data-target=".division-details" id="">
                    		  <button class="map-point-sm" data-show=".retailprice">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for retail price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		  <button class="map-point-sm" data-show=".wholesaleprice">
                    			<div class="content">
                    			  <div class="centered-y">
                    				<p>Click for wholesale price</p>
                    			  </div>
                    			</div>
                    		  </button>
                    		</div><!-- end inner basic -->
                	  </div>
	  
	  
                	  <div class="map-container">
                		<div class="inner-basic division-details">
                		  <div class="retailprice hide">
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
                		  </div>
                		  
                		  <div class="wholesaleprice hide">
                			<div class="wholesale_price">
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 10 -MRP ₹<span class="product_wholesale_price">200</span>	
                        				<offerprice>₹100</offerprice>		
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 20 -MRP ₹<span class="product_wholesale_price">800</span>	
                        				<offerprice>₹500</offerprice>		
                        			</label>
                        		  </div>
                        
                        		  <div class="packking_size_price">
                        			<label>
                        				<input class="wholesale_input" type="checkbox" class="radio" value="1" name=""/>Pack of 50 -MRP ₹<span class="product_wholesale_price">2000</span>	
                        				<offerprice>₹800</offerprice>		
                        			</label>
                        		  </div>
                        	  </div>
                		  </div>
                		</div>
                	  </div>
	 
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
								<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
								<button class="btn-icon btn-add-cart" ><i class="icon-bag"></i>ADD</button>
							</div>
						</div> 
					</div>
					
					
                </div>
                </form>
            </div>
            
			<?php } ?> 

	   </div>
        <!-- End .featured-proucts -->
    </div>
    <!-- End .container -->
</div>

<div class="mb-5"></div>

<section class="scroll-first section-margin section-padding" id="about-sec">
		<div class="container">
			<div class="row">
			</div>
			<div class="row about-sec align-items-center">
					<div class="col-md-6">
					 <iframe src="https://www.youtube.com/embed/iC58ZKcmu3A" allowfullscreen="" width="100%" height="400" frameborder="0"></iframe>
					</div>
					<div class="col-md-6">
					  <div class="content-box">
						<h3 class="title-head"><span>About </span>Nainileaf</h3>
						<p class="title"></p><p style="text-align: justify;">Plants are been used regularly as a defence against many diseases since centuries in India. As a matter of fact many medicinal compounds used in modern pharmaceutical drugs are either derived from the plants or have their sources coming from plants. The use of medicinal plants in any way either oral or application is the best way to enhance immunity and become stronger internally. Therefore it is the time for humans to take medicinal plants seriously and involve them into their lifestyle.</p>
  <p style="text-align: justify;">&nbsp;</p>
					  </div>
					</div>
			  </div>
		</div>
	</section>
	
	
	<div class="footer_top_section" style="background-image: url(assets/frontend/images/Circles-Rule-1.gif);">
    <div class="container">
    		<div class="col-md-12 no-gutter">
    			<div class="row">
        		  <div class="col-md-3 overlay-box image-full-width">
        			  <a href="">
        				<img src="assets/frontend/images/Peace-lily-indoor-plants-for-the-office-1024x768.jpg" alt="Airpurifier" class="img-responsive image-sec">
        
        				<div class="hover-overlay width-95">
        				  <h5 class="text_img">Airpurifier</h5>
        				</div>
        
        			  </a>
        		  </div>
        
          
        		  <div class="col-md-3 overlay-box image-full-width">
        			  <a href="">
        				<img src="assets/frontend/images/download_1.jpg" alt="Aromatic" class="img-responsive image-sec">
        
        				<div class="hover-overlay width-95">
        				  <h5 class="text_img">Aromatic</h5>
        				</div>
        
        			  </a>
        		  </div>
        
        		  <div class="col-md-3 overlay-box image-full-width">
        			  <a href="">
        				<img src="assets/frontend/images/il_430xN.53043192.jpg" alt="Bonsai" class="img-responsive image-sec">
        
        				<div class="hover-overlay width-95">
        				  <h5 class="text_img">Bonsai</h5>
        				</div>
        
        			  </a>
        		  </div>
        
        		  <div class="col-md-3 overlay-box image-full-width">
        			  <a href="">
        				<img src="assets/frontend/images/money-tree-wooden-box-013.jpg" alt="Money Tree" class="img-responsive image-sec">
        
        				<div class="hover-overlay width-95">
        				  <h5 class="text_img">Money Tree</h5>
        				</div>
        
        			  </a>
        		  </div>
    
    		</div>
    		</div>
        </div>
	</div>

<?php } 


}?>
<?php 
if($product_list){

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
					<img src="<?php echo base_url('assets/uploads/product/'.$gallery_featured.''); ?>" alt="product">
				</a>
				
				<?php echo $discount_box; ?>
				
			</figure>
			<div class="product-details">
				
				<h2 class="product-title">
					<a href="<?php echo $seo_url; ?>"><?php echo $product_name; ?></a>
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
}else{
	?>
	 <div class="col-12 col-md-12">  
		<p class="text-center">No Product found.</p>	
	</div>
	<?php
}
?>
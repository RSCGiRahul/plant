<!-- _wholesale.php -->
  <div class="wholesaleprice_<?php echo $v_product_list['product_id']; ?> hide">
		<div class="wholesale_price">
              <?php foreach ($wholesaleArr as $key => $val) { ?>
    		  <div class="packking_size_price">
    			<label>
                  
    				<input class="wholesale_input" type="checkbox" data-discount = "<?php echo $val->discount; ?>" class="radio" value="1" name=""/>Pack of <?php echo (++$key) * 10; ?> -MRP ₹
                    <span class="product_wholesale_price"><?php echo $val->mrp; ?></span>
                      <span class="product_wholesale_price"><?php echo $val->dp; ?></span>	
    				<offerprice>₹ <?php echo $val->price; ?> </offerprice>
               
    			</label>
    		  </div>


        <?php } ?>
            <div class="col-md-8"> <!-- addCartModal -->
                          <button class="btn-icon  map-point-sm-retails" data-product ="<?php echo $v_product_list['product_id']; ?>" >

                                      <div class="content">
                                        <div class="centered-y">
                                        <p> Retail price</p>
                                        </div>
                                      </div>
                                </button>
                                        </div>
    </div>
</div>


<aside id="column-left" class="col-sm-3 hidden-xs <?php echo "class-".$this->router->class; ?> <?php echo "method-".$this->router->method; ?>">

	<div class="list-group">
	   <a href="<?php echo base_url('/user/account'); ?>" class="list-group-item <?php if($this->router->class=='account' and $this->router->method=='index'){ echo 'active'; } ?>">My Account</a>
	   
	   <a href="<?php echo base_url('/user/shipping'); ?>" class="list-group-item <?php if($this->router->class=='account' and $this->router->method=='shipping'){ echo 'active'; } ?>">Shipping address</a>  
	   
	   <a href="<?php echo base_url('/user/account/order'); ?>" class="list-group-item  <?php if($this->router->class=='account' and ($this->router->method=='order' || $this->router->method=='info')){ echo 'active'; } ?>">Order History</a> 
	   <a href="<?php echo base_url('/user/logout'); ?>" class="list-group-item">Logout</a>
	</div>
 </aside>
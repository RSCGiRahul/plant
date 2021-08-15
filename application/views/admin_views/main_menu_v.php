<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<li class="header">MAIN NAVIGATION</li>
<li class="<?php if ($active_menu == 'dashboard') {  echo 'active'; } ?>">
	<a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <span> Dashboard</span></a>
</li>

 

<li class="treeview <?php if ($active_menu == 'categories') { echo 'active'; } ?>">
    <a href="#"><i class="fa fa-file-text-o"></i> <span> Categories</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php
        if ($active_sub_menu == 'categories') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/categories'); ?>"><i class="fa fa-circle-o"></i> Manage Categories</a></li>
		
		
		<li class="<?php
        if ($active_sub_menu == 'add_category') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/categories/add_category'); ?>"><i class="fa fa-circle-o"></i> Add Category</a></li>
		
		
		
		 <li class="<?php
        if ($active_sub_menu == 'catfilter' || $active_sub_menu == 'edit_filter') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/catfilter'); ?>"><i class="fa fa-circle-o"></i> Manage Categories Filter</a></li>
		
    </ul>
</li>

 

<li class="treeview <?php
	if ($active_menu == 'product') {
		echo 'active';
	}
	?>">
    <a href="#"><i class="fa fa-file-text-o"></i> <span> Product</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
      
        <li class="<?php
        if ($active_sub_menu == 'product') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/products'); ?>"><i class="fa fa-circle-o"></i> Manage Products</a></li>
		
		
		<li class="<?php
        if ($active_sub_menu == 'add_product') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/products/add_product'); ?>"><i class="fa fa-circle-o"></i> Add Product</a></li>
    </ul>
</li>


<li class="treeview <?php
	if ($active_menu == 'brand') {
		echo 'active';
	}
	?>">
    <a href="#"><i class="fa fa-file-text-o"></i> <span> Brand</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
      
        <li class="<?php
        if ($active_sub_menu == 'brand') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/brand'); ?>"><i class="fa fa-circle-o"></i> Manage Brand</a></li>
		
		
		<li class="<?php
        if ($active_sub_menu == 'add_brand') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/brand/add_brand'); ?>"><i class="fa fa-circle-o"></i> Add Brand</a></li>
    </ul>
</li>




<li class="treeview <?php
	if ($active_menu == 'attribute') {
		echo 'active';
	}
	?>">
    <a href="#"><i class="fa fa-file-text-o"></i> <span> Attributes</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
      
        <li class="<?php
        if ($active_sub_menu == 'attribute') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/attribute'); ?>"><i class="fa fa-circle-o"></i> Manage Attributes</a></li>
		
		
		<li class="<?php
        if ($active_sub_menu == 'add_attribute') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/attribute/add_attribute'); ?>"><i class="fa fa-circle-o"></i> Add Attribute</a></li>
    </ul>
</li>



<li class="treeview <?php
	if ($active_menu == 'price') {
		echo 'active';
	}
	?>">
    <a href="#"><i class="fa fa-file-text-o"></i> <span> Price Option</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
      
        <li class="<?php
        if ($active_sub_menu == 'price') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/price'); ?>"><i class="fa fa-circle-o"></i> Manage Price Option</a></li>
		
		
		<li class="<?php
        if ($active_sub_menu == 'add_price') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/price/add_price'); ?>"><i class="fa fa-circle-o"></i> Add Price Option</a></li>
    </ul>
</li>


<li class="<?php if ($active_menu == 'order') {  echo 'active'; } ?>">
	<a href="<?php echo base_url('admin/order'); ?>"><i class="fa fa-file-text-o"></i> <span> Order</span></a>
</li>


<li class="treeview <?php
	if ($active_menu == 'outlet') {
		echo 'active';
	}
	?>">
    <a href="#"><i class="fa fa-file-text-o"></i> <span> Outlet</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
      
        <li class="<?php
        if ($active_sub_menu == 'outlet') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/outlet'); ?>"><i class="fa fa-circle-o"></i> Manage Outlet</a></li>
		
		
		<li class="<?php
        if ($active_sub_menu == 'add_outlet') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/outlet/add_outlet'); ?>"><i class="fa fa-circle-o"></i> Add Outlet</a></li>
    </ul>
</li>




<li class="treeview <?php
	if ($active_menu == 'delivery') {
		echo 'active';
	}
	?>">
    <a href="#"><i class="fa fa-file-text-o"></i> <span> Delivery</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
      
        <li class="<?php
        if ($active_sub_menu == 'delivery') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/delivery'); ?>"><i class="fa fa-circle-o"></i> Manage Delivery</a></li>
		
		
		<li class="<?php
        if ($active_sub_menu == 'add_delivery') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/delivery/add_delivery'); ?>"><i class="fa fa-circle-o"></i> Add Delivery</a></li>
    </ul>
</li>	


<li class="treeview <?php
	if ($active_menu == 'setting') {
		echo 'active';
	}
	?>">
    <a href="#"><i class="fa fa-file-text-o"></i> <span> Setting</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
      
        <li class="<?php
        if ($active_sub_menu == 'general') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/setting'); ?>"><i class="fa fa-circle-o"></i> General</a></li>
		
		
		<li class="<?php
        if ($active_sub_menu == 'homesetting') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/setting/homesetting'); ?>"><i class="fa fa-circle-o"></i>Desktop Home page</a></li>
		
		<li class="<?php
        if ($active_sub_menu == 'mobilesetting') {
            echo 'active';
        }
        ?>"><a href="<?php echo base_url('admin/setting/mobilesetting'); ?>"><i class="fa fa-circle-o"></i>Mobile Home page</a></li>
		
		
    </ul>
</li>

</ul>
</li>
</ul>
</li> 
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Price
        <small>Manage Price</small>
    </h1>
    <ol class="breadcrumb woo-breadcrumb">
         <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		 <li><a class="active" href="<?php echo base_url('admin/price'); ?>"><i class="fa fa-cogs"></i> Manage Price</a></li> 
		 <li><a class="active" href="<?php echo base_url('admin/products'); ?>"><i class="fa fa-file-text-o"></i> Manage Products</a></li> 
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Price</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>

        <!-- form start -->
		
		
		
			    
<?php /* search */ ?>					
					
					
<form name="manageALevels" method="GET" class="form-inline"  > 
<input type="hidden" value="1" name="currentpage">
 
 
<div class="col-sm-12"> 
<div class="panel panel-white"> 
<div class="panel-body">	  
<div class=" col-sm-12 text-center">
 

<div class="form-group"> 
	<label for="email">Status </label> 
	<select   class="form-control m-t-xxs required" id="status" name="status"  >
	<option value="">-Select-</option>
	<option <?php if($_GET['status']==1){ echo "selected"; } ?> value="1">Active</option>
	<option <?php if($_GET['status']==2){ echo "selected"; } ?> value="2">Inactive</option> 
	<option <?php if($_GET['status']==5){ echo "selected"; } ?> value="5">Featured</option>   
	</select>
	
	<?php /* <label for="email">Product.</label> */ ?> 
    <input type="text" class="form-control" id="search" name="search" placeholder="Search by Price Option Name" value="<?php echo $_REQUEST['search']; ?>" style="min-width:260px;">
	
</div>
 
<button type="submit" class="btn btn-success btn-sm" name="frmAction">Search</button>
 

</div> 

</div>
</div>
</div>
			
</form> 			
<?php /* search */ ?>			
		
		
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12" > 
					
						<a href="<?php echo base_url('admin/price/add_price'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Price </a> 
					 
                </div>
                <div class="col-md-12" style="margin-top: 25px;">
				 
				
                    <table  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th> 
                                <th>Price Option Name</th>  
                                <th>Date Added</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1;

							$range = RANGE;  
							$totalpages = ceil($price_count / PAGINATION);

							if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {

							$currentpage = (int) $_GET['currentpage'];
							} else {

							$currentpage = 1;
							}

							?>
                            <?php foreach ($price_info as $v_price_info) { ?>
                                <tr>
                                    <td><?php echo $v_price_info['price_id']; ?></td>
									 
									<td><?php echo $v_price_info['price_name']; ?></td> 
									
                                    <td><?php echo date("d F Y", strtotime($v_price_info['date_added'])); ?></td>
                                    <td>
                                        <?php
                                        $status = $v_price_info['publication_status'];										
										$action='';
                                        if ($status == 1) {
                                            echo "<a href='" . base_url('admin/price/unpublished_price/' . $v_price_info['price_id'] . ''.$action.'?currentpage='.$currentpage.'') . "' class='btn btn-block btn-success btn-xs' data-toggle='tooltip' title='Click to unpublished'><i class='fa fa-arrow-down'></i> Published</a>";
                                        } else {
                                            echo "<a href='" . base_url('admin/price/published_price/' . $v_price_info['price_id'] . ''.$action.'?currentpage='.$currentpage.'') . "' class='btn btn-block btn-warning btn-xs' data-toggle='tooltip' title='Click to published'><i class='fa fa-arrow-up'></i> Unpublished</a>";
                                        }
                                        ?>
                                    </td>
									
                                    <td> 									
                                        <a href="<?php echo base_url('admin/price/edit_price/' . $v_price_info['price_id'] . ''); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> 
										
                                        <a href="<?php echo base_url('admin/price/remove_price/' . $v_price_info['price_id'] . '') ?>" class="btn btn-danger btn-xs check_delete" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
            </div>
			
			
	
<div class="row"> 
<div class="col-sm-7 pull-right">
	<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"> 
	<ul class="pagination"> 
	 <?php   
	 
	$search='';
	 if($_GET['search']){
		 
		 $search .= '&search='.$_GET['search'].'';
	 } 
	 
	 if($_GET['price_id']){
		 
		 $search .= '&price_id='.$_GET['price_id'].'';
	 }
	 
	  if($_GET['status']){
		 
		 $search .= '&status='.$_GET['status'].'';
	 }
	 
	 
	if ($currentpage > $totalpages) { 
	$currentpage = $totalpages;
	} 

	if ($currentpage < 1) { 
	$currentpage = 1;
	}   
	if($price_count>PAGINATION){  
	  
	if ($currentpage > 1) { 
	echo "<li> <a href='{$_SERVER['SCRIPT_URI']}?currentpage=1".$search."'><<</a></li> "; 
	$prevpage = $currentpage - 1; 
	echo "<li> <a href='{$_SERVER['SCRIPT_URI']}?currentpage=$prevpage".$search."'><</a> </li>";
	}   
	
	for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) { 
	if (($x > 0) && ($x <= $totalpages)) { 
	if ($x == $currentpage) { 
	echo "<li class='active'> <a href='javascript:;' class='paginate_button'>$x</a> </li>"; 
	} else { 
	echo "<li> <a href='{$_SERVER['SCRIPT_URI']}?currentpage=$x".$search."'>$x</a> </li>";
	} 
	} 
	}  


	if ($currentpage != $totalpages) {

	$nextpage = $currentpage + 1;

	echo "<li> <a href='{$_SERVER['SCRIPT_URI']}?currentpage=$nextpage".$search."'>></a> </li>";

	echo "<li> <a href='{$_SERVER['SCRIPT_URI']}?currentpage=$totalpages".$search."'>>></a> </li>";
	} 

	} 
   ?> 
	</ul>
	</div>
</div>
</div>
	
			
			
        </div>
        <!-- /.box-body -->
    </div>
</section>
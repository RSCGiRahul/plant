<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Outlets
        <small>Manage Outlets</small>
    </h1>
    <ol class="breadcrumb woo-breadcrumb">
         <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		 <li><a class="active" href="<?php echo base_url('admin/outlet'); ?>"><i class="fa fa-cogs"></i> Manage Outlet</a></li> 
		 <li><a class="active" href="<?php echo base_url('admin/products'); ?>"><i class="fa fa-file-text-o"></i> Manage Products</a></li> 
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Outlets</h3>

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
    <input type="text" class="form-control" id="search" name="search" placeholder="Search by outlet name" value="<?php echo $_REQUEST['search']; ?>" style="min-width:260px;">
	
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
					
						<a href="<?php echo base_url('admin/outlet/add_outlet'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Outlet </a> 
					 
                </div>
                <div class="col-md-12" style="margin-top: 25px;">
				 
				
                    <table  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th> 
                                <th>Outlet Name</th>  
								<th>Delivery Name</th> 
								
								<th style="width:260px;">Address</th>  
								<th>Zipcode</th>  
								<th>Lat - Long</th>  
						 
                                <th>Date Added</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1;

							$range = RANGE;  
							$totalpages = ceil($outlet_count / PAGINATION);

							if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {

							$currentpage = (int) $_GET['currentpage'];
							} else {

							$currentpage = 1;
							}
							
							
							?>
                            <?php foreach ($outlet_info as $v_outlet_info) { ?>
                                <tr>
                                    <td><?php echo $v_outlet_info['outlet_id']; ?></td>
								
									<td><?php echo $v_outlet_info['outlet_name']; ?></td> 
									
									
									<td> 
									<?php 
									$delivery_info = $this->delivery_mdl->get_delivery_by_delivery_id($v_outlet_info['associated_delivery_id']); 
									 
									echo $delivery_info['delivery_name']; 
									echo "<br>";
									echo $delivery_info['phone'];
									echo "<br>";
									
									echo $delivery_info['city'];
									echo "<br>";
									echo $delivery_info['zipcode'];
									 
									?>
						 
									</td> 
									
									<td><?php echo $v_outlet_info['address']; ?></td> 
									
									<td><?php echo $v_outlet_info['zipcode']; ?></td> 
									<td><?php echo $v_outlet_info['lat']."<br>-<br>".$v_outlet_info['lng']; ?></td> 
									 
									
                                    <td><?php echo date("d F Y", strtotime($v_outlet_info['date_added'])); ?></td>
                                    <td>
                                        <?php
                                        $status = $v_outlet_info['publication_status'];										
										$action='';
                                        if ($status == 1) {
                                            echo "<a href='" . base_url('admin/outlet/unpublished_outlet/' . $v_outlet_info['outlet_id'] . ''.$action.'?currentpage='.$currentpage.'') . "' class='btn btn-block btn-success btn-xs' data-toggle='tooltip' title='Click to unpublished'><i class='fa fa-arrow-down'></i> Published</a>";
                                        } else {
                                            echo "<a href='" . base_url('admin/outlet/published_outlet/' . $v_outlet_info['outlet_id'] . ''.$action.'?currentpage='.$currentpage.'') . "' class='btn btn-block btn-warning btn-xs' data-toggle='tooltip' title='Click to published'><i class='fa fa-arrow-up'></i> Unpublished</a>";
                                        }
                                        ?>
                                    </td>
									
                                    <td> 									
                                        <a href="<?php echo base_url('admin/outlet/edit_outlet/' . $v_outlet_info['outlet_id'] . ''); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> 
										
                                        <a href="<?php echo base_url('admin/outlet/remove_outlet/' . $v_outlet_info['outlet_id'] . '') ?>" class="btn btn-danger btn-xs check_delete" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i></a>
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
	 
	 if($_GET['outlet_id']){
		 
		 $search .= '&outlet_id='.$_GET['outlet_id'].'';
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
	if($outlet_count>PAGINATION){  
	  
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
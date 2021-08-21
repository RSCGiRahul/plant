<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       <?php echo $main_sub_catory_text; ?>  Categories
        <small>Manage <?php echo $main_sub_catory_text; ?>  Categories</small>
    </h1>
    <ol class="breadcrumb woo-breadcrumb">
         <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		 <li><a class="active" href="<?php echo base_url('admin/categories'); ?>"><i class="fa fa-cogs"></i> Manage <?php echo $main_sub_catory_text; ?>  Categories</a></li> 
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $main_sub_catory_text; ?>  Categories</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>

        <!-- form start -->
		
		
		
			    
<?php /* search */ ?>					
					
					
<form name="manageALevels" method="GET" class="form-inline"  >

<input type="hidden" value="1" name="currentpage">

<?php
if($_GET['category_id']){
?>
<input type="hidden" value="<?php echo $_GET['category_id']; ?>" name="category_id">
<?PHP } ?>
 
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
    <input type="text" class="form-control" id="search" name="search" placeholder="Search by Title" value="<?php echo $_REQUEST['search']; ?>" style="min-width:260px;">
	
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
					<?php if($sub_category_status==0){ ?>
					
						<a href="<?php echo base_url('admin/categories/add_category'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Category </a>
					
					<?php }else{
						?>
						
						<a href="<?php echo base_url('admin/categories/add_category?category_id=' . $parent_id . ''); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Sub Category </a>
						
						<?php
					} ?>
                </div>
                <div class="col-md-12" style="margin-top: 25px;">
				
					<?php /*
					<div class="dataTables_wrapper form-inline dt-bootstrap no-footer" >
						<div class="row">
					
							<div class="col-sm-6 pull-right">
								<div  class="dataTables_filter">
									<form method="get" action="">
									
									
									
									<label>Search:<input type="search" class="form-control input-sm" placeholder=""  name="search" value="<?php echo $_GET['search']; ?>"></label>
									</form>
								</div>
							</div>
					
						</div> 
					</div>
					*/ ?>
				
                    <table  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
								 
								<th><?php echo $main_sub_catory_text; ?>  Category Image</th>
								 
								
                                <th><?php echo $main_sub_catory_text; ?> Category Name</th> 
                                <!--
								<th>Description</th>
								-->
                                <th>Added By</th>
                                <th>Date Added</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1;

							$range = RANGE;  
							$totalpages = ceil($categories_count / PAGINATION);

							if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {

							$currentpage = (int) $_GET['currentpage'];
							} else {

							$currentpage = 1;
							}

							?>
                            <?php foreach ($categories_info as $v_category_info) { ?>
                                <tr>
                                    <td><?php echo $v_category_info['category_id']; ?></td>
									
									<?php /* if($sub_category_status==0){ */ ?>
									 <td>
									 <?php 
									 $imageurl=$v_category_info['category_image'];
									 
									 if($imageurl){
									  
									  $target_dir = "assets/uploads/category/";
									  $uploaded_file_path= base_url()."/".$target_dir."".$v_category_info['category_image'];

									 echo '<a  href="'.$uploaded_file_path.'" target="_blank"><img src="'.$uploaded_file_path.'" class="ic-img"></a>';	

									 }		
									 ?>
									 
									 
									 </td>
									<?php /* }  */?>
									
                                    <td><?php echo $v_category_info['category_name']; ?></td>
                                   
									
									<!--
                                    <td><?php echo $v_category_info['description']; ?></td>
									-->
									
                                    <td><?php echo $v_category_info['first_name'] . " " . $v_category_info['last_name']; ?></td>
                                    <td><?php echo date("d F Y", strtotime($v_category_info['date_added'])); ?></td>
                                    <td>
                                        <?php
                                        $status = $v_category_info['publication_status'];
										
										$action='';
										if(isset($parent_id)){
											
											$action='?category_id='.$parent_id.'';
										}
										
                                        if ($status == 1) {
                                            echo "<a href='" . base_url('admin/categories/unpublished_category/' . $v_category_info['category_id'] . ''.$action.'?currentpage='.$currentpage.'') . "' class='btn btn-block btn-success btn-xs' data-toggle='tooltip' title='Click to unpublished'><i class='fa fa-arrow-down'></i> Published</a>";
                                        } else {
                                            echo "<a href='" . base_url('admin/categories/published_category/' . $v_category_info['category_id'] . ''.$action.'?currentpage='.$currentpage.'') . "' class='btn btn-block btn-warning btn-xs' data-toggle='tooltip' title='Click to published'><i class='fa fa-arrow-up'></i> Unpublished</a>";
                                        }
                                        ?>
                                    </td>
                                    <td>
									<?php if ($sub_category_status == 0 ){ ?>
										<a href="<?php echo base_url('admin/categories?category_id=' . $v_category_info['category_id'] . ''); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Manage Subcategory">
											 Subcategory
										</a>	
									
									
										<a href="<?php echo base_url('admin/categories/add_category?category_id=' . $v_category_info['category_id'] . ''); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Add Subcategory">
											Add Subcategory
										</a>
 									<?php } ?>
                                        <a href="<?php echo base_url('admin/categories/edit_category/' . $v_category_info['category_id'] . ''); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
										
										
                                        <a href="<?php echo base_url('admin/categories/remove_category/' . $v_category_info['category_id'] . '') ?>" class="btn btn-danger btn-xs check_delete" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i></a>
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
	 
	 if($_GET['category_id']){
		 
		 $search .= '&category_id='.$_GET['category_id'].'';
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
	if($categories_count>PAGINATION){  
	  
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
<?php
$product_type =$v_home_content['product_type']; 
$special_category = json_decode($v_home_content['special_category']); 


$order='product.product_id';
$orderby='desc';


/* $sql_data_1 ="SELECT product_id, count(product_id) AS num_pr FROM tbl_order_product GROUP BY product_id ORDER BY `num_pr` DESC limit 6"; */
$sql_data_1 ="SELECT tbl_order_product.product_id, count(tbl_order_product.product_id) AS num_pr,dir_product.product_name,dir_product.deletion_status,dir_product.publication_status 
	FROM tbl_order_product 
	
	LEFT JOIN dir_product
ON tbl_order_product.product_id = dir_product.product_id

 where dir_product.publication_status=1 and dir_product.deletion_status=0
	
	GROUP BY tbl_order_product.product_id ORDER BY num_pr DESC limit 6";



$sql_data_1 = $this->db->query($sql_data_1);	
$data_1 = $sql_data_1->result(); 


		
$data_array = array();
foreach($data_1 as $data1 ){ 
	$data_array[] = $data1->product_id;
}

if(implode(",",$data_array)){		
 
$this->db->select('product.*')
		->from('dir_product as product')  
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->limit(6);
		$where = '  product_id IN ('.implode(",",$data_array).')';

		$this->db->where( $where ); 		

		$query_result = $this->db->get();
		$result = $query_result->result_array()	;	
		/* 
		echo "<pre>";
		 print_R($this->db->last_query());
		echo "</pre>"; 
		 */
		
		
if(count($result)>=6){
	/*design*/
	
$v_product_list_0 = $result[0];  

	


$v_product_list_1 = $result[1];
$v_product_list_2 = $result[2];
$v_product_list_3 = $result[3];
$v_product_list_4 = $result[4];
$v_product_list_5 = $result[5];	 


$target_dir ='/assets/uploads/product/';
?>


<!-- margin -->
<div class="categeories-divide 1">
    <div class="container">
        <h2 class="h3 title mb-4 text-center custom-heading"><?php echo $v_home_content['title']; ?></h2>
        <div class="row">
		
            <div class="col-md-4">
                
				<?php
				$product_images = json_decode($v_product_list_0['product_images']); 
				$gallery_featured = $v_product_list_0['gallery_featured'];
				if($gallery_featured==""){
				$gallery_featured = $product_images[0];
				} 
				 $uploaded_file_path= base_url()."/".$target_dir."".$gallery_featured; 
				 if($gallery_featured==""){
					 $uploaded_file_path= "https://via.placeholder.com/370x300.png?text=".$v_product_list_0['product_name'];
				 }
				 
				?>
				<div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_product_list_0['product_name']; ?>">
                    <span><?php echo $v_product_list_0['category_name']; ?></span>
                    <a href="<?php echo base_url('/product/details/')."/".$v_product_list_0['seo_url']; ?>"></a>
                </div>
				
				<div class="w-100"></div>
                
				<?php
				$product_images = json_decode($v_product_list_1['product_images']); 
				$gallery_featured = $v_product_list_1['gallery_featured'];
				if($gallery_featured==""){
				$gallery_featured = $product_images[0];
				} 
				 $uploaded_file_path= base_url()."/".$target_dir."".$gallery_featured; 
				 if($gallery_featured==""){
					 $uploaded_file_path= "https://via.placeholder.com/370x300.png?text=".$v_product_list_1['product_name'];
				 }
				   
				?>
				<div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_product_list_1['product_name']; ?>">
                    <span><?php echo $v_product_list_1['product_name']; ?></span>
                    <a href="<?php echo base_url('/product/details/')."/".$v_product_list_1['seo_url']; ?>"></a>
                </div>
            </div>
			
			<?php
				$product_images = json_decode($v_product_list_2['product_images']); 
				$gallery_featured = $v_product_list_2['gallery_featured'];
				if($gallery_featured==""){
				$gallery_featured = $product_images[0];
				} 
				 $uploaded_file_path= base_url()."/".$target_dir."".$gallery_featured; 
				 if($gallery_featured==""){
					 $uploaded_file_path= "https://via.placeholder.com/400x630.png?text=".$v_product_list_2['product_name'];
				 }
				   
				?>
            <div class="col-md-4">
                <div class="outer-div bigger-img1">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_product_list_2['product_name']; ?>">
                    <span><?php echo $v_product_list_2['product_name']; ?></span>
                    <a href="<?php echo base_url('/product/details/')."/".$v_product_list_2['seo_url']; ?>"></a>
                </div>
				
				<div class="w-100"></div>
				<?php
				$product_images = json_decode($v_product_list_5['product_images']); 
				$gallery_featured = $v_product_list_5['gallery_featured'];
				if($gallery_featured==""){
				$gallery_featured = $product_images[0];
				} 
				 $uploaded_file_path= base_url()."/".$target_dir."".$gallery_featured; 
				 if($gallery_featured==""){
					 $uploaded_file_path= "https://via.placeholder.com/400x630.png?text=".$v_product_list_5['product_name'];
				 }
				   
				?>
                <div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_product_list_5['product_name']; ?>">
                    <span><?php echo $v_product_list_5['product_name']; ?></span>
                    <a href="<?php echo base_url('/product/details/')."/".$v_product_list_5['seo_url']; ?>"></a>
                </div>
				
            </div>
			
			
			
			
			
            <div class="col-md-4">
				<?php
				$product_images = json_decode($v_product_list_3['product_images']); 
				$gallery_featured = $v_product_list_3['gallery_featured'];
				if($gallery_featured==""){
				$gallery_featured = $product_images[0];
				} 
				 $uploaded_file_path= base_url()."/".$target_dir."".$gallery_featured; 
				 if($gallery_featured==""){
					 $uploaded_file_path= "https://via.placeholder.com/400x630.png?text=".$v_product_list_3['product_name'];
				 }
				   
				?>
                <div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_product_list_3['product_name']; ?>">
                    <span><?php echo $v_product_list_3['product_name']; ?></span>
                    <a href="<?php echo base_url('/product/details/')."/".$v_product_list_3['seo_url']; ?>"></a>
                </div>
                <div class="w-100"></div>
				
				<?php
				$product_images = json_decode($v_product_list_4['product_images']); 
				$gallery_featured = $v_product_list_4['gallery_featured'];
				if($gallery_featured==""){
				$gallery_featured = $product_images[0];
				} 
				 $uploaded_file_path= base_url()."/".$target_dir."".$gallery_featured; 
				 if($gallery_featured==""){
					 $uploaded_file_path= "https://via.placeholder.com/400x630.png?text=".$v_product_list_4['product_name'];
				 }
				   
				?>
                <div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_product_list_4['product_name']; ?>">
                    <span><?php echo $v_product_list_4['product_name']; ?></span>
                    <a href="<?php echo base_url('/product/details/')."/".$v_product_list_4['seo_url']; ?>"></a>
                </div>
            </div>
			
			
        </div>
    </div>
</div> 
<div class="mb-5"></div>
<!-- margin -->

<?php	
	
	

	
	
	
	/*design*/
	
}
		
		
		
}
?>
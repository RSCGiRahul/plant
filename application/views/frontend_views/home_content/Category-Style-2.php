<?php
$special_category = json_decode($v_home_content['special_category']); 




$order='cat.category_id';
$orderby='DESC';

$this->db->select('cat.*')
		->from('dir_categories as cat')  
		->where('cat.publication_status', 1) 
		/* ->where('cat.category_image!=',"")  */
		->where('cat.deletion_status',0) 
		->order_by(''.$order.'', ''.$orderby.'')  
		->limit(4);	 

 

$where = ' 1=1';
if($special_category){
  $where .= '   and( ';  
   $i=0;
	foreach($special_category as $v_special_category){
		 $i=$i+1;
		 if($i!=1){ $where .= ' OR '; }
		 $where .= ' cat.category_id="'.$v_special_category.'"';  
	}
	$where .= ' ) ';  
	
}
$this->db->where( $where ); 
$query_result = $this->db->get();
$result = $query_result->result_array();

/* echo "<pre>";
 print_R($result);
echo "</pre>"; */

if(count($result)==4){ 
 
$target_dir = "assets/uploads/category/";


?>

<div class="categeories-divide 2">
    <div class="container">
        <h2 class="h3 title mb-4 text-center custom-heading"><?php echo $v_home_content['title']; ?></h2>
        <div class="row">
			
				<?php 
				foreach ($result as $v_category_info) { 
				
				$uploaded_file_path= base_url()."/".$target_dir."".$v_category_info['category_image'];
				
				
				if($v_category_info['category_image']==""){
					 $uploaded_file_path= "https://via.placeholder.com/370x370.png?text=".$v_category_info['category_name'];
				 }

				
				?>
				<div class="col-md-3">
					<div class="outer-div">
						<img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_category_info['category_name']; ?>">
						<span><?php echo $v_category_info['category_name']; ?></span>
						<a href="<?php echo base_url('category')."/".$v_category_info['seo_url']; ?>"></a>
					</div>
				</div>
            <?php } ?>
			
		
		</div>
    </div>
</div>
 <div class="mb-5"></div>
 
<?php } ?>
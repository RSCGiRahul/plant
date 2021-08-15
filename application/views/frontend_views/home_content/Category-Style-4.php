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
		->limit(6);	

 

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




if(count($result)==6){ 
 
$target_dir = "assets/uploads/category/";

$v_category_info_0 = $result[0];
$v_category_info_1 = $result[1];
$v_category_info_2 = $result[2];
$v_category_info_3 = $result[3];
$v_category_info_4 = $result[4];
$v_category_info_5 = $result[5];


?>

<div class="categeories-divide 4">
    <div class="container">
        <h2 class="h3 title mb-4 text-center custom-heading"><?php echo $v_home_content['title']; ?></h2>
        <div class="row">
            <div class="col-md-4">
			
				<?php
				 $uploaded_file_path= base_url()."/".$target_dir."".$v_category_info_0['category_image']; 
				 
				 if($v_category_info_0['category_image']==""){
					 $uploaded_file_path= "https://via.placeholder.com/370x300.png?text=".$v_category_info_0['category_name'];
				 }


				?>
                <div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_category_info_0['category_name']; ?>">
                    <span><?php echo $v_category_info_0['category_name']; ?></span>
                    <a href="<?php echo base_url('category')."/".$v_category_info_0['seo_url']; ?>"></a>
                </div>
                <div class="w-100"></div>
                
				<?php
				 $uploaded_file_path= base_url()."/".$target_dir."".$v_category_info_1['category_image'];
				 if($v_category_info_1['category_image']==""){
					 $uploaded_file_path= "https://via.placeholder.com/370x300.png?text=".$v_category_info_1['category_name'];
				 }
				?>
				<div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_category_info_1['category_name']; ?>" >
                    <span><?php echo $v_category_info_1['category_name']; ?></span>
                    <a href="<?php echo base_url('category')."/".$v_category_info_1['seo_url']; ?>"></a>
                </div>
            </div>

            <div class="col-md-4">
                
				<?php
				 $uploaded_file_path= base_url()."/".$target_dir."".$v_category_info_2['category_image'];
				 if($v_category_info_2['category_image']==""){
					 $uploaded_file_path= "https://via.placeholder.com/370x300.png?text=".$v_category_info_2['category_name'];
				 }
				?>
				<div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_category_info_2['category_name']; ?>" >
                    <span><?php echo $v_category_info_2['category_name']; ?></span>
                    <a href="<?php echo base_url('category')."/".$v_category_info_2['seo_url']; ?>"></a>
                </div>
                <div class="w-100"></div>
                
				<?php
				 $uploaded_file_path= base_url()."/".$target_dir."".$v_category_info_3['category_image'];
				 if($v_category_info_3['category_image']==""){
					 $uploaded_file_path= "https://via.placeholder.com/370x300.png?text=".$v_category_info_3['category_name'];
				 }
				?>
				<div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_category_info_3['category_name']; ?>" >
                    <span><?php echo $v_category_info_3['category_name']; ?></span>
                    <a href="<?php echo base_url('category')."/".$v_category_info_3['seo_url']; ?>"></a>
                </div>
            </div>

            <div class="col-md-4">
                
				<?php
				 $uploaded_file_path= base_url()."/".$target_dir."".$v_category_info_4['category_image'];
				 
				 if($v_category_info_4['category_image']==""){
					 $uploaded_file_path= "https://via.placeholder.com/370x300.png?text=".$v_category_info_4['category_name'];
				 }
				?>
				<div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_category_info_4['category_name']; ?>" >
                    <span><?php echo $v_category_info_4['category_name']; ?></span>
                    <a href="<?php echo base_url('category')."/".$v_category_info_4['seo_url']; ?>"></a>
                </div>
                <div class="w-100"></div>
                
				<?php
				 $uploaded_file_path= base_url()."/".$target_dir."".$v_category_info_5['category_image'];
				 if($v_category_info_5['category_image']==""){
					 $uploaded_file_path= "https://via.placeholder.com/370x300.png?text=".$v_category_info_5['category_name'];
				 }
				?>
				<div class="outer-div">
                    <img src="<?php echo $uploaded_file_path; ?>" alt="<?php echo $v_category_info_5['category_name']; ?>">
                    <span><?php echo $v_category_info_5['category_name']; ?></span>
                    <a href="<?php echo base_url('category')."/".$v_category_info_5['seo_url']; ?>"></a>
                </div>
            </div>
        </div>
    </div>
</div> 
<div class="mb-5"></div>

<?php } ?>
<main class="main">		
	<?php
	foreach($home_content as $v_home_content){
		
		$type = $v_home_content['type'];
		if($type=='Slider'){
			include 'application/views/frontend_views/home_content/Slider.php'; 
		}
		
		//modal of index page was coded in slider.php
		
		if($type=='Content'){
			include 'application/views/frontend_views/home_content/Content.php'; 
		}
		
		
		if($type=='Category'){
			if($v_home_content['category_type']){
			 include 'application/views/frontend_views/home_content/Category-'.$v_home_content['category_type'].'.php'; 
			}
		}
		
		if($type=='Product'){
			include 'application/views/frontend_views/home_content/Product.php'; 
		}
		
	}
	?>	 
</main>
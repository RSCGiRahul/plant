<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CC_Controller {
    
    public function __construct() {
    	parent::__construct();
    	$this->load->model('frontend_models/Common_model', 'common_mdl'); 
		$this->load->model('frontend_models/Product_model', 'product_mdl'); 
		$this->load->model('frontend_models/Cart_model', 'cart_mdl');  
    }
    
    public function index() {		 	 
    	 
		$data = array();
    	$data['title'] = 'Category'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = ''; 
		  
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 		
		$data['categories'] = $this->product_mdl->dir_main_categories();
		
		$data['brand_list'] = $this->product_mdl->get_brand_list(); 
		
		
		$search = array();
		$currentpage = 1;
		
		if($_REQUEST['t']=="offer"){
			$search['t'] = 'offer';
		}
		
		$search['s'] ='';
		if($_REQUEST['s']!=""){
			$search['s'] = $_REQUEST['s'];
		}
		
		$data['product_list'] = $this->product_mdl->get_filter_products($search,$currentpage);	
		$data['product_list_count'] = $product_list_count = $this->product_mdl->get_filter_products_count($search);			
		
		/*main_title*/		
		if($_REQUEST['t']=="offer"){
			$data['main_title'] = 'All Offers ('.$product_list_count.')';
		}else if($_REQUEST['s']!=""){	
			$data['main_title'] = $_REQUEST['s'].' ('.$product_list_count.')';
		}else{
			$data['main_title'] = 'All Products ('.$product_list_count.')';
		}
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
    	$data['main_content'] = $this->load->view('frontend_views/all_product_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
		 
		 
    }
	
	/**/
	public function get_cat_menu($items,$id,$class,$active_category) { 
		
		$html = " <ul id='".$id."' class='".$class."  ' >";
		foreach($items as $key=>$listing_in) {
			
			$class = '';
			if($active_category==$listing_in['category_id']){ $class='active'; }
					
			 $html .= '<li class="'.$class.'" ><a class="'.$class.'" href="'.base_url().'category/'.$listing_in['seo_url'].'">'.$listing_in['category_name'].'</a>';
			 
			 if(array_key_exists('child',$listing_in)) {
				 
					/* if($active_category==$listing_in['category_id']){ continue; } */
				 
					$html .= $this->get_cat_menu($listing_in['child'],'category_ul_'.$listing_in['category_id'].'','',$active_category);
			 }   
			 
			 $html .= "</li>";
		}
        $html .= "</ul>";
		
		
        return $html;
    }
    public function findKey($array, $keySearch) {
        foreach ($array as $key => $item) {
            if ($key == $keySearch) { 
                return true;
            } elseif (is_array($item) && $this->findKey($item, $keySearch)) {
                return true;
            }
        }
        return false;
    }
	/**/
	
	public function category($seo_url) {
		$data = array();
    	$data['title'] = 'Category'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = '';
		
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
		
		$data['category_info'] = $category_info = $this->product_mdl->get_category_by_id($seo_url);
		
		
		$parent_cat = $this->product_mdl->get_parent_category_by_id($category_info['category_id']);
		$categories = $this->product_mdl->dir_side_categories($category_info['category_id']);
		
		$data['categories_menu'] = array();
		if($categories[''.$parent_cat.'']){
			$categories_list[] = $data['categories'] =  $categories[''.$parent_cat.''];
			
			
			
			$data['categories_menu'] = $categories_menu=$this->get_cat_menu($categories_list,'','cat-list',$category_info['category_id']);
		}
		
		
		
		/* $data['categories'] = $this->product_mdl->dir_categories_by_parent_id($category_info['category_id']); */
		 
		$filter_brand = ""; 
		if(empty($category_info['filter_brand'])  and (!empty($parent_cat)) ){
			 $category_info_parent = $this->product_mdl->get_category_by_id($parent_cat);
			 $filter_brand=$category_info_parent['filter_brand'];
		}else if(!empty($category_info['filter_brand'])){	
			$filter_brand=$category_info['filter_brand'];
		}
		
		
		
		$data['product_list'] = $this->product_mdl->dir_products_by_category_id($category_info['category_id']);
		$data['product_list_count'] = $this->product_mdl->dir_products_by_category_id_count($category_info['category_id']);
		
		if(!empty($filter_brand)){
		$data['brand_list'] = $this->product_mdl->get_brand_list_in($filter_brand); 
		}else{
		$data['brand_list'] = $this->product_mdl->get_brand_list($filter_brand); 
		}
		
		$data['category_id'] = $category_info['category_id'];
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
    	$data['main_content'] = $this->load->view('frontend_views/category_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
		
    }
	
	
	public function details($seo_url) {
		
		$data = array();
		
		$data['product_details'] = $product_details = $this->product_mdl->product_details_by_slug($seo_url);
		 
		
    	$data['title'] = $product_details['seo_title']; 
		$data['seo_title'] = $product_details['seo_title']; 
		$data['seo_keywords'] = $product_details['seo_meta_keywords']; 
		$data['seo_description'] = $product_details['seo_meta_description']; 
		
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
		$data['categories'] = $this->product_mdl->dir_main_categories();
		
		$data['product_attributes'] = $this->product_mdl->get_dir_product_attribute($product_details['product_id']);
		
		$data['product_list'] = $this->product_mdl->related_products_by_category_id($product_details['product_category']);
		
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
    	$data['main_content'] = $this->load->view('frontend_views/productdetails_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
		
    }
	
	public function filter_product() { 
	
		$data = array();
		$data['title'] = 'Product'; 
		$setting_info = $this->common_mdl->get_settings_info();
		$data['settings_info'] = $setting_info;  		
		
		$search = array();
		$search['category_id'] =  $this->input->post('category_id', TRUE);
		$search['brand_search'] =  $this->input->post('brand_search', TRUE);
		$search['price_search'] =  $this->input->post('price_search', TRUE);
		$search['discount_search'] =  $this->input->post('discount_search', TRUE);
		
		$search['orderby'] =  $this->input->post('orderby', TRUE); 	
		
		if($_REQUEST['t']=="offer"){
			$search['t'] = 'offer';
		}
		$search['s'] ='';
		if($_REQUEST['s']!=""){
			$search['s'] = $_REQUEST['s'];
		}
		
		$data['search'] = $search;
		
		$currentpage = $this->input->post('currentpage', TRUE);
		$data['currentpage'] = $currentpage;
		
		
		
		$data['product_list'] = $this->product_mdl->get_filter_products($search,$currentpage);	
		$data['product_list_count'] = $this->product_mdl->get_filter_products_count($search);	
		
		$main_content = $this->load->view('frontend_views/ajax_product_content_v', $data, TRUE);  
		
		$success ='true';
		$msg ='';
		
		if(empty($data['product_list'])){
			$currentpage = 0;
		}else{
			$currentpage = ($currentpage+1);
		}
		$output['success']= $success;
		$output['message']=$msg;
		$output['main_content']= $main_content;
		$output['currentpage']= $currentpage;
		echo json_encode($output);
		die(); 
	}
	
	
	
	public function add_to_cart() {  
		$success='false';
		$msg='';
		
	
		$form = $this->input->post('productFrm', TRUE);
		parse_str($form, $formData); 
		$this->form_validation->set_data($formData);  
		$config = array(
			array(
    			'field' => 'product_id',
    			'label' => 'Product',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'quantity',
    			'label' => 'Quantity',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$product_info = $this->product_mdl->get_product_by_product_id($formData['product_id']);
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "<p>Error: Product not found.</p>";
		}else{
			$success='true';	
			$gallery_featured = $product_info['gallery_featured'];
			if($gallery_featured==""){
				$product_images = json_decode($product_info['product_images']);
				$gallery_featured = $product_images[0];
			}
			
			$productImg=base_url('assets/uploads/product/'.$gallery_featured.'');
			
			
			/* $msg = '
            <p>You have just added this product to the<br>cart:</p>
            <h4 id="productTitle">'.$product_info['product_name'].'</h4>
            <img src="'.$productImg.'" id="productImage" width="100" height="100" alt="adding cart">
            <div class="btn-actions">
                <a href="'.base_url('/cart').'"><button class="btn-primary">Go to cart page</button></a>
                <a href="#"><button class="btn-primary product-close" data-dismiss="modal">Continue</button></a>
            </div>'; */
			
			$msg=" <div id='response_popup_msg' class='container'><div class='response-msg alert alert-success alert-dismissible text-center'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
					<p><i class='fa fa-check-circle'></i> Success: You have added <a href='javascript:;'>".$product_info['product_name']."</a> to your <a href='".base_url('/cart')."'>shopping cart</a>!</p>
				</div></div>
			";

		 
			
			
			
			
			$product_id = 	$product_info['product_id'];
			$quantity = 	$formData['quantity'];
			$price_option = 	$formData['price_option'];
			
			$price = $product_info['price'];
			$discount = '0';
			$discount_price = '0';
			$price_id = '0';
			
			if($price>0){
				$discount = $product_info['discount']; 
				$discount_price = $product_info['discount_price']; 
				$product_title = $product_info['product_name'];
			}else{ 
			
				if($price_option==""){
					$success ='false';
					$msg =  "<p>Please select product option</p>";
					
				}else{
					$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$product_info['product_id']."' and `price_id`='".$price_option."' order by price ";
					$query_price_option = $this->db->query($sql_price_option);
					$result_price_option = $query_price_option->result();
					$price = $result_price_option[0]->price; 
					$discount = $result_price_option[0]->discount;
					$discount_price = $result_price_option[0]->discount_price; 
					$price_option_name = $result_price_option[0]->name;	
					
					$price_id = $result_price_option[0]->price_id;	
					
					$product_title = $product_info['product_name']." - ".$price_option_name;
				}
				
			}
			
			if($success !='false'){
			
				if($discount>0){
					$regular_price = $discount_price;
					$discount = $discount; 
				}else{
					$regular_price = $price;
					$discount = 0;
				}
				
				$car_data = array();
				
				$session_id = $this->session->userdata('session_id');
				if($session_id==""){
					$sdata = array();
					$sdata['session_id'] = session_id();
					$this->session->set_userdata($sdata);
				}
				$car_data['session_id'] = $this->session->userdata('session_id');
				$car_data['customer_id'] = $this->session->userdata('customer_id');
				$car_data['quantity'] = $formData['quantity']; 
				$car_data['product_id'] = $product_info['product_id']; 
				$car_data['price_id'] =  $price_id;			
				$car_data['product_title'] = $product_title;
				$car_data['price'] = $price;
				$car_data['regular_price'] = $regular_price;
				$car_data['discount'] = $discount;
				
				$cart_info = $this->cart_mdl->store_cart($car_data);
			}
			
		} 
		
		
		
		$common_data_info = $this->get_common_data_info();
		
		$output['success']= $success;
		$output['message']=$msg; 
		$output['cart_popup']=$common_data_info['car_popup']; 
		echo json_encode($output);
		die(); 
	}
	
	
	public function remove_to_cart() {  
		$success='false';
		$msg='';
		
	 
		$config = array(
			array(
    			'field' => 'cart_id',
    			'label' => 'Cart id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$cart_id = $this->input->post('cart_id', TRUE);
		$product_info = $this->product_mdl->get_product_by_cart_id($cart_id);
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "<p>Error: Product not found.</p>";
		}else{
			$success='true';	
			$this->cart_mdl->remove_cart($cart_id);
		} 
		
		$common_data_info = $this->get_common_data_info();
		
		$output['success']= $success;
		$output['cart_popup']=$common_data_info['car_popup'];  
		echo json_encode($output);
		die(); 
	}
	
	
	public function minus_to_cart() {  
		$success='false';
		$msg='';
		
	 
		$config = array(
			array(
    			'field' => 'cart_id',
    			'label' => 'Cart id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$cart_id = $this->input->post('cart_id', TRUE);
		$product_info = $this->product_mdl->get_product_by_cart_id($cart_id);
		
		
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "<p>Error: Product not found.</p>";
		}else{
			$success='true';	
			$this->cart_mdl->minus_to_cart($cart_id);
		} 
		
		$common_data_info = $this->get_common_data_info();
		
		$output['success']= $success;
		$output['cart_popup']=$common_data_info['car_popup'];  
		echo json_encode($output);
		die(); 
	}
	
	public function adding_to_cart() {  
		$success='false';
		$msg='';
		
	 
		$config = array(
			array(
    			'field' => 'cart_id',
    			'label' => 'Cart id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$cart_id = $this->input->post('cart_id', TRUE);
		$product_info = $this->product_mdl->get_product_by_cart_id($cart_id);
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "<p>Error: Product not found.</p>";
		}else{
			$success='true';	
			$this->cart_mdl->adding_to_cart($cart_id);
		} 
		
		$common_data_info = $this->get_common_data_info();
		
		$output['success']= $success;
		$output['cart_popup']=$common_data_info['car_popup'];  
		echo json_encode($output);
		die(); 
	}
	
	
	public function refresh_to_cart() {  
		$success='false';
		$msg='';
		
	 
		$config = array(
			array(
    			'field' => 'cart_id',
    			'label' => 'Cart id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$cart_id = $this->input->post('cart_id', TRUE);
		$quantity = $this->input->post('quantity', TRUE);
		$product_info = $this->product_mdl->get_product_by_cart_id($cart_id);
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "<p>Error: Product not found.</p>";
		}else{
			$success='true';	
			$this->cart_mdl->refresh_to_cart($cart_id,$quantity);
		} 
		
		$common_data_info = $this->get_common_data_info();
		
		$output['success']= $success;
		$output['cart_popup']=$common_data_info['car_popup'];  
		echo json_encode($output);
		die(); 
	}
	
}

<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Products extends CC_Controller { 
    public function __construct() {
        parent::__construct(); 
        $this->user_login_authentication(); 
        $this->load->model('admin_models/products_model', 'product_mdl');
		$this->load->model('admin_models/attribute_model', 'attribute_mdl');
		$this->load->model('admin_models/price_model', 'price_mdl');
		$this->load->model('admin_models/categories_model', 'cat_mdl');
		$this->load->model('admin_models/brand_model', 'brand_mdl');
		$this->load->model('admin_models/productWholeSale_model', 'productWholeSale_model');
    }

    public function index() {
		
        $data = array();
        $data['title'] = 'Manage Product';
        $data['active_menu'] = 'product';
        $data['active_sub_menu'] = 'product';
        $data['active_sub_sub_menu'] = '';
		
		
		 		 
		$page = $_REQUEST['currentpage']; 
		$search = $_REQUEST['search'];  
		$status = $_REQUEST['status'];
		
		$data['products_count'] = $this->product_mdl->get_product_count($search,$status);
    	$data['products_info'] = $this->product_mdl->get_product_info($page,$search,$status); 
		
		
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/product/manage_product_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
	
	
	public function add_product() {
        $data = array();
        $data['title'] = 'Add Product';
        $data['active_menu'] = 'product';
        $data['active_sub_menu'] = 'add_product';
        $data['active_sub_sub_menu'] = '';
		
		$data['Product_Attribute'] = $this->attribute_mdl->get_product_attribute();
		$data['Price_Option'] = $this->price_mdl->get_price_option();
		$data['categories_info'] = $this->cat_mdl->get_category_list();
		$data['brand_info'] = $this->brand_mdl->get_brand_list();
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/product/add_product_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }


	
	public function create_product() {
	
		$config = array(

    		array(

    			'field' => 'product_name',

    			'label' => 'Product Name',

    			'rules' => 'trim|required|max_length[250]'

    		),

    		array(

    			'field' => 'seo_url',

    			'label' => 'Seo url',

    			'rules' => 'trim|required|max_length[250]'

    		),
    		

    	);

    	$this->form_validation->set_rules($config);

    	if ($this->form_validation->run() == FALSE) {

    		$this->add_product();

    	} else {
		$post = $this->input->post();
		$product_attribute = $this->input->post('product_attribute', TRUE);
		$data['user_id'] = $this->session->userdata('admin_id'); 
		@$data['product_category']=implode(",",$_POST['product_category']);
		$data['brand_id'] = $this->input->post('brand_id', TRUE);
		
		$data['dimensions_length'] = $this->input->post('dimensions_length', TRUE);
		$data['dimensions_width'] = $this->input->post('dimensions_width', TRUE);
		$data['dimensions_height'] = $this->input->post('dimensions_height', TRUE);
		$data['weight'] = $this->input->post('weight', TRUE);
		
		
		$data['product_name'] = $this->input->post('product_name', TRUE);
		$data['seo_url'] = $this->input->post('seo_url', TRUE);
		$data['description'] = $this->input->post('description', TRUE);
		
		/* @$product_images=implode(",",$_POST['product_images']);  */
		$data['product_images'] = json_encode($_POST['product_images']);
		$data['gallery_featured'] = $this->input->post('gallery_featured', TRUE);
		$data['gallery_featured_mobile'] = $this->input->post('gallery_featured_mobile', TRUE);
		
	// dd($this->input->post(), json_encode($this->input->post('product_attribute')));
		$postProductAttribute = [];
		if ( $post['product_attribute']  )
		{
			$postProductAttribute = count($post['product_attribute']) > 1 ? $post['product_attribute'] : $post['product_attribute'][0];
		}
		$data['product_attribute'] = json_encode($postProductAttribute );
		// $data['product_attribute'] = json_encode($this->input->post('product_attribute', TRUE));
		
		
		$data['price'] = $this->input->post('price', TRUE);
		$data['discount'] = $this->input->post('discount', TRUE);
		$data['discount_price'] = $this->input->post('discount_price', TRUE);	
		$postPriceOption = [];
		if ( $post['price_option']  )
		{
			$postPriceOption = count($post['price_option']) > 1 ? $post['price_option'] : $post['price_option'][0];
		}
		$data['price_option'] = json_encode($postPriceOption);	
		// $data['price_option'] = json_encode($this->input->post('price_option', TRUE));
		
		
		$data['seo_title'] = $this->input->post('seo_title', TRUE);
		$data['seo_meta_keywords'] = $this->input->post('seo_meta_keywords', TRUE);
		$data['seo_meta_description'] = $this->input->post('seo_meta_description', TRUE);
		
		$data['date_added'] = date('Y-m-d H:i:s'); 
		
	
		
		$insert_id = $this->product_mdl->store_product($data);
						
				/* whole sale price */
		 if ( $post['is_whole_sale'])
		 {
			$this->productWholeSale_model->store([
				'ws_price' =>  $post['wholesale_price'],
				'ws_discount' => $post['wholesale_discount'],
				'product_id' => $insert_id,
				'ws_discount_price' => $post['wholesale_discount_price']
		 	]);
		 	$data['is_whole_sale'] = 1;
		 }
				/* end whole sale price */
		$product_attribute = $this->input->post('product_attribute', TRUE);
				// dd($postProductAttribute);
		$attribute_id = $this->product_mdl->store_product_attribute($insert_id,json_encode($postProductAttribute ));
		
		
		
		// $product_price_option = $this->input->post('price_option', TRUE);
		$price_id = $this->product_mdl->store_product_price_option($insert_id,json_encode($postPriceOption));
		
		
		/*price*/
			
			$price =  $this->input->post('price', TRUE);
			$discount = $this->input->post('discount', TRUE);
			$discount_price = $this->input->post('discount_price', TRUE);	
		
		if($price>0){
			$discount = $this->input->post('discount', TRUE);
			$discount_price = $this->input->post('discount_price', TRUE);	
		}else{ 
			$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$insert_id."' order by price ";
			$query_price_option = $this->db->query($sql_price_option);
			$result_price_option = $query_price_option->result();
			$price = $result_price_option[0]->price; 
			$discount = $result_price_option[0]->discount;
			$discount_price = $result_price_option[0]->discount_price;  
		}
		
		if($discount>0){
			$pri= $discount_price;
		}else{
			$pri= $price;
		}
		$data['sort_price'] = $pri;
		$data['sort_discount'] = $discount;
		$this->product_mdl->update_product($insert_id,$data);
		/*price*/


		
		if (!empty($insert_id)) {
    			$sdata['success'] = 'Add successfully . ';
    			$this->session->set_userdata($sdata);
    			redirect('admin/products', 'refresh');
    		} else {
    			$sdata['exception'] = 'Operation failed !';
    			$this->session->set_userdata($sdata);
    			redirect('admin/products', 'refresh');
    		} 
		}  
	}
	
	
	public function edit_product($product_id) {
		
        $data = array();
        $data['title'] = 'Edit Product';
        $data['active_menu'] = 'product';
        $data['active_sub_menu'] = 'add_product';
        $data['active_sub_sub_menu'] = '';
		
		$data['Product_Attribute'] = $this->attribute_mdl->get_product_attribute();
		$data['Price_Option'] = $this->price_mdl->get_price_option();
		
		$data['product_info'] = $this->product_mdl->get_product_by_product_id($product_id);
		$data['categories_info'] = $this->cat_mdl->get_category_list();
		$data['brand_info'] = $this->brand_mdl->get_brand_list();
		
		$data['dir_product_price_option'] = $this->product_mdl->get_dir_product_price_option($product_id);
		$data['dir_product_attribute'] = $this->product_mdl->get_dir_product_attribute($product_id);
		
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/product/edit_product_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
	
	public function update_product($product_id) {
		
		
		$product_info = $this->product_mdl->get_product_by_product_id($product_id);

    	if (!empty($product_info)) {
	
		$config = array(

    		array(

    			'field' => 'product_name',

    			'label' => 'Product Name',

    			'rules' => 'trim|required|max_length[250]'

    		),

    		array(

    			'field' => 'seo_url',

    			'label' => 'Seo url',

    			'rules' => 'trim|required|max_length[250]'

    		),
    		

    	);

    	$this->form_validation->set_rules($config);

    	if ($this->form_validation->run() == FALSE) {

    		$this->edit_product($product_id);

    	} else {
	
	
		$data['user_id'] = $this->session->userdata('admin_id'); 
		@$data['product_category']=implode(",",$_POST['product_category']);
		 
		$data['brand_id'] = $this->input->post('brand_id', TRUE);
		$data['dimensions_length'] = $this->input->post('dimensions_length', TRUE);
		$data['dimensions_width'] = $this->input->post('dimensions_width', TRUE);
		$data['dimensions_height'] = $this->input->post('dimensions_height', TRUE);
		$data['weight'] = $this->input->post('weight', TRUE);
		
		
		$data['product_name'] = $this->input->post('product_name', TRUE);
		$data['seo_url'] = $this->input->post('seo_url', TRUE);
		$data['description'] = $this->input->post('description', TRUE);
		
		$data['product_images'] = json_encode($_POST['product_images']);
		$data['gallery_featured'] = $this->input->post('gallery_featured', TRUE);
		$data['gallery_featured_mobile'] = $this->input->post('gallery_featured_mobile', TRUE);
		
		$data['product_attribute'] = json_encode($this->input->post('product_attribute', TRUE));
		
		
		$data['price'] = $this->input->post('price', TRUE);
		$data['discount'] = $this->input->post('discount', TRUE);
		$data['discount_price'] = $this->input->post('discount_price', TRUE);		
		$data['price_option'] = json_encode($this->input->post('price_option', TRUE));
		
		
		$data['seo_title'] = $this->input->post('seo_title', TRUE);
		$data['seo_meta_keywords'] = $this->input->post('seo_meta_keywords', TRUE);
		$data['seo_meta_description'] = $this->input->post('seo_meta_description', TRUE);
		
		$data['last_updated'] = date('Y-m-d H:i:s'); 
		 
		
		$result = $this->product_mdl->update_product($product_id,$data);
		
		
		$product_attribute = $this->input->post('product_attribute', TRUE);	
		$price_option = $this->input->post('price_option', TRUE);
		
		
		$attribute_id = $this->product_mdl->update_product_attribute($product_id,$product_attribute); 
		$price_id = $this->product_mdl->update_product_price_option($product_id,$price_option); 
		
		
		
		/*price*/
		
		$price =  $this->input->post('price', TRUE);
		$discount = $this->input->post('discount', TRUE);
		$discount_price = $this->input->post('discount_price', TRUE);	
		
		if($price>0){
			$discount = $this->input->post('discount', TRUE);
			$discount_price = $this->input->post('discount_price', TRUE);	
		}else{ 
			$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$product_id."' order by price ";
			$query_price_option = $this->db->query($sql_price_option);
			$result_price_option = $query_price_option->result();
			$price = $result_price_option[0]->price; 
			$discount = $result_price_option[0]->discount;
			$discount_price = $result_price_option[0]->discount_price;  
		}
		
		if($discount>0){
			$pri= $discount_price;
		}else{
			$pri= $price;
		}
		$data['sort_price'] = $pri;
		$data['sort_discount'] = $discount;
		$this->product_mdl->update_product($product_id,$data);
		/*price*/
		
		
		/* 
		echo "<pre>";
		 print_R($data);
		echo "</pre>"; 
		
		echo "<pre>";
		 print_R($product_attribute);
		echo "</pre>"; 
		
		echo "<pre>";
		 print_R($price_option);
		echo "</pre>"; 
		die(); */
		
		if (!empty($result)) {
    			$sdata['success'] = 'Update successfully. ';
    			$this->session->set_userdata($sdata);
    			redirect('admin/products', 'refresh');
    		} else {
    			$sdata['exception'] = 'Operation failed !';
    			$this->session->set_userdata($sdata);
    			redirect('admin/products', 'refresh');
    		} 
		}  
		
		
		} else {

    		$sdata['exception'] = 'Content not found !';

    		$this->session->set_userdata($sdata);

    		redirect('directory/listing', 'refresh');

    	}
		
	}
	
	
	public function unpublished_product($product_id) {
    	$product_info = $this->product_mdl->get_product_by_product_id($product_id); 
    	if (!empty($product_info)) {
    		$result = $this->product_mdl->unpublished_product_by_id($product_id);
    		if (!empty($result)) {
    			$sdata['success'] = 'Unublished successfully .';
    			$this->session->set_userdata($sdata);
    			redirect('admin/products?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
    		} else {
    			$sdata['exception'] = 'Operation failed !';
    			$this->session->set_userdata($sdata);
    			redirect('admin/products?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
    		}
    	} else {
    		$sdata['exception'] = 'Content not found !';
    		$this->session->set_userdata($sdata);
    		redirect('admin/products?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
    	}
    }
	
	public function published_product($product_id) {
    	$product_info = $this->product_mdl->get_product_by_product_id($product_id);
    	if (!empty($product_info)) {
    		$result = $this->product_mdl->published_product_by_id($product_id);
    		if (!empty($result)) {
    			$sdata['success'] = 'Unublished successfully .';
    			$this->session->set_userdata($sdata);
    			redirect('admin/products?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
    		} else {
    			$sdata['exception'] = 'Operation failed !';
    			$this->session->set_userdata($sdata);
    			redirect('admin/products?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
    		}
    	} else {
    		$sdata['exception'] = 'Content not found !';
    		$this->session->set_userdata($sdata);
    		redirect('admin/products?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
    	}
    }
	
	public function remove_product($product_id) {
    	$product_info = $this->product_mdl->get_product_by_product_id($product_id);
    	if (!empty($product_info)) {
    		$result = $this->product_mdl->remove_product_by_id($product_id);
    		if (!empty($result)) {
    			$sdata['success'] = 'Remove successfully .';
    			$this->session->set_userdata($sdata);
    			redirect('admin/products?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
    		} else {
    			$sdata['exception'] = 'Operation failed !';
    			$this->session->set_userdata($sdata);
    			redirect('admin/products?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
    		}
    	} else {
    		$sdata['exception'] = 'Content not found !';
    		$this->session->set_userdata($sdata);
    		redirect('admin/products?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
    	}
    }
 

}
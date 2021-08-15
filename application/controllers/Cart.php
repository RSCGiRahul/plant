<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends CC_Controller {
    
    public function __construct() {
    	parent::__construct();
    	$this->load->model('frontend_models/Common_model', 'common_mdl'); 
		$this->load->model('frontend_models/Product_model', 'product_mdl'); 
		$this->load->model('frontend_models/Cart_model', 'cart_mdl');  
    }
    
    public function index() {
		
		$data = array();
    	$data['title'] = 'Cart'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = ''; 
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
		
		$data['delivery_charge'] = $settings_info['delivery_price'];
		$data['cart_info'] = $this->cart_mdl->get_cart_info();
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
    	$data['main_content'] = $this->load->view('frontend_views/cart_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
		 
		 
    }
}
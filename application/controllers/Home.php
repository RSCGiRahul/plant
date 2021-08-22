<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CC_Controller {
    
    public function __construct() {
    	parent::__construct();
    	$this->load->model('frontend_models/Common_model', 'common_mdl'); 
		$this->load->model('ModelProduct'); 
		$this->load->model('ModelCategory'); 
    }
    
    public function index() {	
    	$data = array();
    	$data['title'] = 'Home';  
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;  
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
		
		
		$data['home_content'] = $this->common_mdl->get_home_content(); 

		//rahul

		$data['category_product'] = $category_product = $this->ModelCategory->getCategoryProductArray();

	
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
    	$data['main_content'] = $this->load->view('frontend_views/home_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
    }
}
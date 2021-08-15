<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Offers extends CC_Controller {
    
    public function __construct() {
    	parent::__construct();
    	$this->load->model('frontend_models/Common_model', 'common_mdl'); 
		$this->load->model('frontend_models/Product_model', 'product_mdl'); 
		$this->load->model('frontend_models/Cart_model', 'cart_mdl');  
    }
    
    public function index() {		 	 
    	 
		$data = array();
    	$data['title'] = 'Offers'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = '';
		
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
		
		
		$data['categories_menu'] = array();
		
		
		$data['product_list'] = $this->product_mdl->dir_products_offeres();
		$data['product_list_count'] = $this->product_mdl->dir_products_offeres_count();
		
		
		$data['brand_list'] = $this->product_mdl->get_brand_list(); 
		 
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
    	$data['main_content'] = $this->load->view('frontend_views/offere_content_v', $data, TRUE); 
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
	
	 
	
	public function filter_product() { 
	
		$data = array();
		$data['title'] = 'Product'; 
		$setting_info = $this->common_mdl->get_settings_info();
		$data['settings_info'] = $setting_info;  		
		
		$search = array();
		$search['category_id'] =  $this->input->post('category_id', TRUE);
		$search['brand_search'] =  $this->input->post('brand_search', TRUE);
		$search['orderby'] =  $this->input->post('orderby', TRUE); 	
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
	
	 
	
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Catfilter extends CC_Controller {
 
	  
    public function __construct() {
        parent::__construct();
        // Check Login Status
        $this->user_login_authentication();
        // Load Model
        $this->load->model('admin_models/categories_model', 'cat_mdl');
		$this->load->model('admin_models/brand_model', 'brand_mdl');
    }

    public function index() {
		
		
        $data = array();
        $data['title'] = 'Manage Categories Filter';
        $data['active_menu'] = 'categories';
        $data['active_sub_menu'] = 'catfilter';
        $data['active_sub_sub_menu'] = '';
		
		$data['sub_category_status'] = '0';
		@$category_id=$_REQUEST['category_id'];	
		
		if($category_id){
			$data['sub_category_status'] = '1';
			$data['parent_id'] = $category_id;
			
			 $page = $_REQUEST['currentpage']; 
			 $search = $_REQUEST['search'];			$status = $_REQUEST['status'];
			
			$data['categories_info'] = $this->cat_mdl->get_sub_categories_info($category_id,$page,$search,$status);
			$data['categories_count'] = $this->cat_mdl->get_sub_categories_info_count($category_id,$search,$status);
			
			$data['parent_category'] = $this->cat_mdl->get_category_by_category_id($category_id);
		
		}else{
			 
			 $page = $_REQUEST['currentpage']; 
			 $search = $_REQUEST['search'];
			 $status = $_REQUEST['status'];
			 
			 $data['categories_info'] = $this->cat_mdl->get_categories_info($page,$search,$status);
			 $data['categories_count'] = $this->cat_mdl->get_categories_count($search,$status);
		}
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/categories/manage_categories_filter_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
   
   
    public function edit_filter($category_id) {
        $data = array();
        $data['category_info'] = $this->cat_mdl->get_category_by_category_id($category_id); 
        if (!empty($data['category_info'])) {
            $data['title'] = 'Edit Category Filter';
			$data['active_menu'] = 'categories';
			$data['active_sub_menu'] = 'edit_filter';
            $data['active_sub_sub_menu'] = ''; 
			 
			
			
			$data['brand_info'] = $this->brand_mdl->get_brand_list();
			
			@$category_id=$data['category_info']['parent_id'];	
			if($category_id){ 
			$data['category_id'] = $category_id;
			$data['parent_category_info'] = $this->cat_mdl->get_category_by_category_id($category_id);
			}else{
			$data['category_id'] = '';
			}  
			
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/categories/edit_category_filter_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data);
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/categories', 'refresh');
        }
    }
	
	
	public function update_filter($category_id) {
		$category_info = $this->cat_mdl->get_category_by_category_id($category_id);
		if (!empty($category_info)) {
				
			@$data['filter_brand']=implode(",",$_POST['filter_brand']);
			$result = $this->cat_mdl->update_category($category_id, $data);
			
			if (!empty($result)) {
				$sdata['success'] = 'Update successfully .';
				$this->session->set_userdata($sdata);
				
				if($data['parent_id']){ 
					redirect('admin/catfilter?category_id='.$data['parent_id'].'', 'refresh');
				}else{
					redirect('admin/catfilter', 'refresh');
				}
				
				
			} else {
				$sdata['exception'] = 'Operation failed !';
				$this->session->set_userdata($sdata);
				redirect('admin/catfilter', 'refresh');
			}
			
			
		} else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/catfilter', 'refresh');
        }
		
		
	}
	
	
 

}

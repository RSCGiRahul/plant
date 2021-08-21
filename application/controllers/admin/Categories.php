<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CC_Controller {
 
	  
    public function __construct() {
        parent::__construct();
        // Check Login Status
        $this->user_login_authentication();
        // Load Model
        $this->load->model('admin_models/categories_model', 'cat_mdl');
    }

    public function index() {
		
		
        $data = array();
        $data['title'] = 'Manage Categories';
        $data['active_menu'] = 'categories';
        $data['active_sub_menu'] = 'categories';
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
			$data['main_sub_catory_text'] = 'Sub';
		
		}else{
			 
			 $page = $_REQUEST['currentpage']; 
			 $search = $_REQUEST['search'];
			 $status = $_REQUEST['status'];
			 
			 $data['categories_info'] = $this->cat_mdl->get_categories_info($page,$search,$status);
			 $data['categories_count'] = $this->cat_mdl->get_categories_count($search,$status);
			$data['main_sub_catory_text'] = 'Main';

		}
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/categories/manage_categories_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function add_category() {
        $data = array();
        $data['title'] = 'Add Category';
        $data['active_menu'] = 'categories';
        $data['active_sub_menu'] = 'add_category';
        $data['active_sub_sub_menu'] = '';
		
		if(set_value('parent_id')){
			$_REQUEST['category_id']=set_value('parent_id');
		}
		
		@$category_id=$_REQUEST['category_id'];	
		if($category_id){	
		$data['category_id'] = $category_id;
		$data['parent_category_info'] = $this->cat_mdl->get_category_by_category_id($category_id);
		}else{
		$data['category_id'] = '';
		}		 
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/categories/add_category_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function create_category() {
 
		
        $config = array(
            array(
                'field' => 'category_name',
                'label' => 'category name',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'seo_title',
                'label' => 'seo title',
                'rules' => 'trim|required|max_length[250]'
            ), 
			
			array(
                'field' => 'seo_url',
                'label' => 'seo url',
                'rules' => 'trim|required|max_length[250]'
            ), 
			
			
			array(
                'field' => 'seo_url',
                'label' => 'seo url',
                'rules' => 'trim|required|max_length[250]'
            ), 
            array(
                'field' => 'publication_status',
                'label' => 'publication status',
                'rules' => 'trim|required'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            
			 
			$this->add_category();
			
        } else {
            $data['category_name'] = $this->input->post('category_name', TRUE); 
			$data['category_image'] = $this->input->post('category_image', TRUE);  
			
			$data['keywords'] = $this->input->post('keywords', TRUE);
			@$data['featured'] = $this->input->post('featured', TRUE);
			$data['description'] = $this->input->post('description', TRUE);
			
			$data['seo_title'] = $this->input->post('seo_title', TRUE);
			$data['seo_keywords'] = $this->input->post('seo_keywords', TRUE);
			$data['seo_meta_keywords'] = $this->input->post('seo_meta_keywords', TRUE);
			$data['seo_meta_description'] = $this->input->post('seo_meta_description', TRUE);  
			
			$data['seo_url'] = $this->input->post('seo_url', TRUE);  
			
			@$data['bucket'] = $this->input->post('bucket', TRUE);  
			
			$data['parent_id'] = $this->input->post('parent_id', TRUE);
			
            $data['publication_status'] = $this->input->post('publication_status', TRUE);
            $data['user_id'] = $this->session->userdata('admin_id');
            $data['date_added'] = date('Y-m-d H:i:s');
			
			
			
			/*banner*/
				
			$data['category_banner'] = $this->input->post('category_banner', TRUE); 
			$data['category_banner_heading'] = $this->input->post('category_banner_heading', TRUE);
			$data['category_banner_desc'] = $this->input->post('category_banner_desc', TRUE);  
			
			/*banner*/
			
			
			
            $insert_id = $this->cat_mdl->store_category($data); 
			
			$data_id= $this->cat_mdl->categories_relation($insert_id,$data['parent_id']); 
			
			
			
            if (!empty($insert_id)) {
                $sdata['success'] = 'Add successfully . ';
                $this->session->set_userdata($sdata);
				
				
				if($data['parent_id']){ 
						redirect('admin/categories?category_id='.$data['parent_id'].'', 'refresh');
					}else{
						redirect('admin/categories', 'refresh');
					}
				
                
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/categories', 'refresh');
            }
        }
    }

    public function published_category($category_id) {
		
		 @$parent_id=$_REQUEST['category_id'];		 
		 $action='';
		 if(isset($_REQUEST['category_id'])){			
			$action='?category_id='.$_REQUEST['category_id'].'';
		}
		
        $category_info = $this->cat_mdl->get_category_by_category_id($category_id);
		
		
        if (!empty($category_info)) {
            $result = $this->cat_mdl->published_category_by_id($category_id);
			 
            if (!empty($result)) {
                $sdata['success'] = 'Published successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/categories'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/categories'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/categories'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
		
		
    }

    public function unpublished_category($category_id) {
		
		 @$parent_id=$_REQUEST['category_id'];
		 
		 $action='';
		 if(isset($_REQUEST['category_id'])){			
			$action='?category_id='.$_REQUEST['category_id'].'';
		}
		
        $category_info = $this->cat_mdl->get_category_by_category_id($category_id);
        if (!empty($category_info)) {
            $result = $this->cat_mdl->unpublished_category_by_id($category_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/categories'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/categories'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/categories'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function edit_category($category_id) {
        $data = array();
        $data['category_info'] = $this->cat_mdl->get_category_by_category_id($category_id); 
        if (!empty($data['category_info'])) {
            $data['title'] = 'Edit Category';
			$data['active_menu'] = 'categories';
			$data['active_sub_menu'] = 'add_category';
            $data['active_sub_sub_menu'] = ''; 
			 
			
			@$category_id=$data['category_info']['parent_id'];	
			if($category_id){ 
			$data['category_id'] = $category_id;
			$data['parent_category_info'] = $this->cat_mdl->get_category_by_category_id($category_id);
			// dd($data['parent_category_info']['category_name']);
			}else{
			$data['category_id'] = '';
			}  
			
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/categories/edit_category_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data);
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/categories', 'refresh');
        }
    }

    public function update_category($category_id) {
        $category_info = $this->cat_mdl->get_category_by_category_id($category_id);
        if (!empty($category_info)) {
				$config = array(
				array(
					'field' => 'category_name',
					'label' => 'category name',
					'rules' => 'trim|required|max_length[250]'
				),
				array(
					'field' => 'seo_title',
					'label' => 'seo title',
					'rules' => 'trim|required|max_length[250]'
				), 
				array(
					'field' => 'seo_url',
					'label' => 'seo url',
					'rules' => 'trim|required|max_length[250]'
				), 
				 
				array(
					'field' => 'publication_status',
					'label' => 'publication status',
					'rules' => 'trim|required'
				)
			);
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $this->edit_category($category_id);
            } else {
                $data['category_name'] = $this->input->post('category_name', TRUE); 
				$data['category_image'] = $this->input->post('category_image', TRUE);  
				
				$data['keywords'] = $this->input->post('keywords', TRUE);
				$data['featured'] = $this->input->post('featured', TRUE);
				$data['description'] = $this->input->post('description', TRUE);
				
				$data['seo_title'] = $this->input->post('seo_title', TRUE);
				$data['seo_keywords'] = $this->input->post('seo_keywords', TRUE);
				$data['seo_meta_keywords'] = $this->input->post('seo_meta_keywords', TRUE);
				$data['seo_meta_description'] = $this->input->post('seo_meta_description', TRUE);  
				$data['seo_url'] = $this->input->post('seo_url', TRUE);  
				
				$data['parent_id'] = $this->input->post('parent_id', TRUE);
				
								
								
                $data['publication_status'] = $this->input->post('publication_status', TRUE);
				
				
				/*banner*/
				
				$data['category_banner'] = $this->input->post('category_banner', TRUE); 
				
				$data['category_banner_heading'] = $this->input->post('category_banner_heading', TRUE);
				$data['category_banner_desc'] = $this->input->post('category_banner_desc', TRUE);  
				/*banner*/
				
				
                $data['last_updated'] = date('Y-m-d H:i:s');

                $result = $this->cat_mdl->update_category($category_id, $data);
				
				$data_id= $this->cat_mdl->categories_relation($category_id,$data['parent_id']);  
				
				
                if (!empty($result)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
					
					if($data['parent_id']){ 
						redirect('admin/categories?category_id='.$data['parent_id'].'', 'refresh');
					}else{
						redirect('admin/categories', 'refresh');
					}
					
                    
                } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('admin/categories', 'refresh');
                }
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/categories', 'refresh');
        }
    }

    public function remove_category($category_id) {
        $category_info = $this->cat_mdl->get_category_by_category_id($category_id);
        if (!empty($category_info)) {
            $result = $this->cat_mdl->remove_category_by_id($category_id);
            if (!empty($result)) {
                $sdata['success'] = 'Remove successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/categories?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/categories?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/categories?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

}

<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Setting extends CC_Controller { 
	  
    public function __construct() {
        parent::__construct(); 
        $this->user_login_authentication(); 
        $this->load->model('admin_models/Setting_model', 'setting_mdl');
		$this->load->model('admin_models/categories_model', 'cat_mdl');
    }

    public function index() { 		
        $data = array();
        $data['title'] = 'General Setting';
        $data['active_menu'] = 'general';
        $data['active_sub_menu'] = 'general';
        $data['active_sub_sub_menu'] = ''; 
		
		$data['general_info'] = $this->setting_mdl->get_general_info();
		
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/setting/general_setting_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
	
	
	public function homesetting() { 		
        $data = array();
        $data['title'] = 'Home Setting';
        $data['active_menu'] = 'setting';
        $data['active_sub_menu'] = 'homesetting';
        $data['active_sub_sub_menu'] = ''; 
		
		$data['homesetting_data'] = $this->setting_mdl->get_homesetting_info();
		$data['homesetting_count'] = $this->setting_mdl->get_homesetting_count();
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/setting/homesetting_setting_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
	
	public function mobilesetting() { 		
        $data = array();
        $data['title'] = 'Home Setting';
        $data['active_menu'] = 'setting';
        $data['active_sub_menu'] = 'mobilesetting';
        $data['active_sub_sub_menu'] = ''; 
		
		$data['homesetting_data'] = $this->setting_mdl->get_mobilesetting_info();
		$data['homesetting_count'] = $this->setting_mdl->get_mobilesetting_count();
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/mobilesetting/homesetting_setting_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
	
	
	public function add_homesetting() { 		
        $data = array();
        $data['title'] = 'Add Home Content';
        $data['active_menu'] = 'setting';
        $data['active_sub_menu'] = 'homesetting';
        $data['active_sub_sub_menu'] = ''; 

		$data['categories_info'] = $this->cat_mdl->get_category_list();
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/setting/add_homesetting_setting_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
	
	
	public function add_mobilesetting() { 		
        $data = array();
        $data['title'] = 'Add Home Content';
        $data['active_menu'] = 'setting';
        $data['active_sub_menu'] = 'mobilesetting';
        $data['active_sub_sub_menu'] = ''; 

		$data['categories_info'] = $this->cat_mdl->get_category_list();
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/mobilesetting/add_homesetting_setting_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
	
	 public function edit_homesetting($setting_id) {
        $data = array();
        $data['setting_info'] = $this->setting_mdl->get_homesetting_by_setting_id($setting_id); 
		 
        if (!empty($data['setting_info'])) {
             $data['title'] = 'Edit Home Content';
			 $data['active_menu'] = 'setting';
			 $data['active_sub_menu'] = 'homesetting';
			 $data['active_sub_sub_menu'] = ''; 
			 
			 $data['categories_info'] = $this->cat_mdl->get_category_list();
			
			$data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
			$data['main_content'] = $this->load->view('admin_views/setting/edit_homesetting_setting_v', $data, TRUE);
			$this->load->view('admin_views/admin_master_v', $data);
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/setting/homesetting', 'refresh');
        }
    }
	
	
	public function edit_mobilesetting($setting_id) {
        $data = array();
        $data['setting_info'] = $this->setting_mdl->get_mobilesetting_by_setting_id($setting_id); 
		 
        if (!empty($data['setting_info'])) {
             $data['title'] = 'Edit Home Content';
			 $data['active_menu'] = 'setting';
			 $data['active_sub_menu'] = 'mobilesetting';
			 $data['active_sub_sub_menu'] = ''; 
			 
			 $data['categories_info'] = $this->cat_mdl->get_category_list();
			
			$data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
			$data['main_content'] = $this->load->view('admin_views/mobilesetting/edit_homesetting_setting_v', $data, TRUE);
			$this->load->view('admin_views/admin_master_v', $data);
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/setting/mobilesetting', 'refresh');
        }
    }
	 
	
	public function create_homesetting() {
 
		
        $config = array(
            array(
                'field' => 'type',
                'label' => 'Type',
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
			$this->add_homesetting(); 
        } else {			
			
            $data['type'] = $this->input->post('type', TRUE); 
			$data['category_type'] = $this->input->post('category_type', TRUE); 
			$data['product_type'] = $this->input->post('product_type', TRUE); 
			
			$data['special_category'] = json_encode($this->input->post('special_category', TRUE)); 
			
			
			$data['title'] = $this->input->post('title', TRUE);  
			$data['sort_order'] = $this->input->post('sort_order', TRUE); 
			$data['description'] = $this->input->post('description', TRUE); 
			$data['slider_images'] = json_encode($this->input->post('slider_images', TRUE));   
            $data['publication_status'] = $this->input->post('publication_status', TRUE);
            $data['date_added'] = date('Y-m-d H:i:s');
			
			$insert_id = $this->setting_mdl->store_homesetting($data); 
            if (!empty($insert_id)) {
                $sdata['success'] = 'Add successfully . ';
                $this->session->set_userdata($sdata);
				redirect('admin/setting/homesetting', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/homesetting', 'refresh');
            }
			
        }
		
    }
	
	
	public function create_mobilesetting() {
 
		
        $config = array(
            array(
                'field' => 'type',
                'label' => 'Type',
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
			$this->add_homesetting(); 
        } else {			
			
            $data['type'] = $this->input->post('type', TRUE); 
			$data['category_type'] = $this->input->post('category_type', TRUE); 
			$data['product_type'] = $this->input->post('product_type', TRUE); 
			
			$data['special_category'] = json_encode($this->input->post('special_category', TRUE)); 
			
			
			$data['title'] = $this->input->post('title', TRUE);  
			$data['sort_order'] = $this->input->post('sort_order', TRUE); 
			$data['description'] = $this->input->post('description', TRUE); 
			$data['slider_images'] = json_encode($this->input->post('slider_images', TRUE));   
            $data['publication_status'] = $this->input->post('publication_status', TRUE);
            $data['date_added'] = date('Y-m-d H:i:s');
			
			$insert_id = $this->setting_mdl->store_mobilesetting($data); 
            if (!empty($insert_id)) {
                $sdata['success'] = 'Add successfully . ';
                $this->session->set_userdata($sdata);
				redirect('admin/setting/mobilesetting', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/mobilesetting', 'refresh');
            }
			
        }
		
    }

	
	public function update_homesetting($setting_id) {
        $data = array();
        $setting_info = $this->setting_mdl->get_homesetting_by_setting_id($setting_id); 
		 
        if (!empty($setting_info)) { 
				
				$config = array(
					array(
						'field' => 'type',
						'label' => 'Type',
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
                $this->edit_homesetting($setting_id);
            } else {				
				
                $data['type'] = $type = $this->input->post('type', TRUE); 
				$data['title'] = $this->input->post('title', TRUE);  
				$data['sort_order'] = $this->input->post('sort_order', TRUE); 
				$data['publication_status'] = $this->input->post('publication_status', TRUE);
                $data['last_updated'] = date('Y-m-d H:i:s');
				
				if($type=='Slider'){
					$data['slider_images'] = json_encode($this->input->post('slider_images', TRUE)); 
				}
				if($type=='Content'){
					$data['description'] = $this->input->post('description', TRUE); 
				}
				
				if($type=='Category'){
					$data['category_type'] = $this->input->post('category_type', TRUE); 
					$data['special_category'] = json_encode($this->input->post('special_category', TRUE)); 
				}
				
				if($type=='Product'){
					
					$data['product_type'] = $this->input->post('product_type', TRUE); 
					$data['special_category'] = json_encode($this->input->post('special_category', TRUE)); 
				}
				
				
				
				
				
				  
				
                $result = $this->setting_mdl->update_homesetting($setting_id, $data); 	
				
                if (!empty($result)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
					redirect('admin/setting/homesetting', 'refresh');  
                } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('admin/setting/homesetting', 'refresh');
                }
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/setting/homesetting', 'refresh');
        }
    }
	
	
	
	public function update_mobilesetting($setting_id) {
        $data = array();
        $setting_info = $this->setting_mdl->get_mobilesetting_by_setting_id($setting_id); 
		 
        if (!empty($setting_info)) { 
				
				$config = array(
					array(
						'field' => 'type',
						'label' => 'Type',
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
                $this->edit_homesetting($setting_id);
            } else {				
				
                $data['type'] = $type = $this->input->post('type', TRUE); 
				$data['title'] = $this->input->post('title', TRUE);  
				$data['sort_order'] = $this->input->post('sort_order', TRUE); 
				$data['publication_status'] = $this->input->post('publication_status', TRUE);
                $data['last_updated'] = date('Y-m-d H:i:s');
				
				if($type=='Slider'){
					$data['slider_images'] = json_encode($this->input->post('slider_images', TRUE)); 
				}
				if($type=='Content'){
					$data['description'] = $this->input->post('description', TRUE); 
				}
				
				if($type=='Category'){
					$data['category_type'] = $this->input->post('category_type', TRUE); 
					$data['special_category'] = json_encode($this->input->post('special_category', TRUE)); 
				}
				
				if($type=='Product'){
					
					$data['product_type'] = $this->input->post('product_type', TRUE); 
					$data['special_category'] = json_encode($this->input->post('special_category', TRUE)); 
				}
				
				
				
				
				
				  
				
                $result = $this->setting_mdl->update_mobilesetting($setting_id, $data); 	
				
                if (!empty($result)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
					redirect('admin/setting/mobilesetting', 'refresh');  
                } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('admin/setting/mobilesetting', 'refresh');
                }
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/setting/mobilesetting', 'refresh');
        }
    }
	
	public function update_setting() {
		
		$config = array(
					array(
						'field' => 'site_name',
						'label' => 'Site name',
						'rules' => 'trim|required|max_length[250]'
					),
					
					array(
						'field' => 'site_logo',
						'label' => 'Site Logo',
						'rules' => 'trim|required|max_length[250]'
					),
				   
					
				);
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $this->index();
            } else {
				
				$data['site_name'] = $this->input->post('site_name', TRUE); 
				$data['email_address'] = $this->input->post('email_address', TRUE); 
				
				
				$data['facebook'] = $this->input->post('facebook', TRUE); 
				$data['twitter'] = $this->input->post('twitter', TRUE); 
				$data['linkedin'] = $this->input->post('linkedin', TRUE); 
				
				$data['to_email'] = $this->input->post('to_email', TRUE); 
				
				
				
				$data['contact_email_address'] = $this->input->post('contact_email_address', TRUE); 
				$data['phone_number'] = $this->input->post('phone_number', TRUE); 
				$data['contact_address'] = $this->input->post('contact_address', TRUE); 
				$data['copyright'] = $this->input->post('copyright', TRUE); 
				
				
				$data['site_logo'] = $this->input->post('site_logo', TRUE); 
				$data['site_favicon'] = $this->input->post('site_favicon', TRUE); 
				
				
				$data['delivery_radius'] = $this->input->post('delivery_radius', TRUE); 
				$data['delivery_price'] = $this->input->post('delivery_price', TRUE); 
				$data['minimum_order'] = $this->input->post('minimum_order', TRUE); 
				
				
                $data['last_updated'] = date('Y-m-d H:i:s');
				$result = $this->setting_mdl->update_setting($data); 
				
				if (!empty($result)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
					redirect('admin/setting', 'refresh');  
                } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('admin/setting', 'refresh');
                }
			
			
			}
	}
	
	
	
	public function unpublished_homesetting($setting_id) { 
        $data_info = $this->setting_mdl->get_homesetting_by_setting_id($setting_id);
        if (!empty($data_info)) {
            $result = $this->setting_mdl->unpublished_homesetting_by_id($setting_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/homesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/homesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/setting/homesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }


	public function published_homesetting($setting_id) { 
        $data_info = $this->setting_mdl->get_homesetting_by_setting_id($setting_id);
        if (!empty($data_info)) {
            $result = $this->setting_mdl->published_homesetting_by_id($setting_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/homesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/homesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/setting/homesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }
	
	public function remove_homesetting($setting_id) { 
        $data_info = $this->setting_mdl->get_homesetting_by_setting_id($setting_id);
        if (!empty($data_info)) {
            $result = $this->setting_mdl->remove_homesetting_by_id($setting_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/homesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/homesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/setting/homesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }
    
	
	
	public function unpublished_mobilesetting($setting_id) { 
        $data_info = $this->setting_mdl->get_mobilesetting_by_setting_id($setting_id);
        if (!empty($data_info)) {
            $result = $this->setting_mdl->unpublished_mobilesetting_by_id($setting_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/mobilesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/mobilesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/setting/mobilesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }


	public function published_mobilesetting($setting_id) { 
        $data_info = $this->setting_mdl->get_mobilesetting_by_setting_id($setting_id);
        if (!empty($data_info)) {
            $result = $this->setting_mdl->published_mobilesetting_by_id($setting_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/mobilesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/mobilesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/setting/mobilesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }
	
	public function remove_mobilesetting($setting_id) { 
        $data_info = $this->setting_mdl->get_mobilesetting_by_setting_id($setting_id);
        if (!empty($data_info)) {
            $result = $this->setting_mdl->remove_mobilesetting_by_id($setting_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/mobilesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/setting/mobilesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/setting/mobilesetting'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

}

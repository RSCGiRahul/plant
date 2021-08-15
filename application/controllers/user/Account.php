<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Account extends CC_Controller {
    
    public function __construct() {
      header('Access-Control-Allow-Origin: *');
      parent::__construct();
		$customer_id = $this->session->userdata('customer_id');
		if ($customer_id == NULL) {
			redirect('/', 'refresh');
		}
      $this->load->model('frontend_models/Common_model', 'common_mdl'); 
	  $this->load->model('frontend_models/Register_model', 'register_mdl');
	  $this->load->model('frontend_models/Order_model', 'order_mdl');  
    }
    public function index() {
		
		
		$data = array();
    	$data['title'] = 'My Account'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = ''; 
		
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
	
		$customer_id = $this->session->userdata('customer_id');
		
		$data['customer_info'] = $customer_info = $this->register_mdl->get_customer_info($customer_id);
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
		$data['sidebar_content'] = $this->load->view('user_views/sidebar_content_v', $data, TRUE);
		
    	$data['main_content'] = $this->load->view('user_views/myaccount_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
			
    }
	
	public function update_customer($customer_id) {
		 
		 $customer_id = $this->session->userdata('customer_id');
		
        $data = array();
        $customer_info = $this->register_mdl->get_customer_info($customer_id);
        if (!empty($customer_info)) { 
								 
				$config = array(
						array(
							'field' => 'firstname',
							'label' => 'First name',
							'rules' => 'trim|required|max_length[250]'
						),           
						array(
							'field' => 'lastname',
							'label' => 'Last name',
							'rules' => 'trim|required|max_length[250]'
						),           
						array(
							'field' => 'email',
							'label' => 'Email',
							'rules' => 'trim|required|max_length[250]|valid_email'
						),  
						array(
							'field' => 'address',
							'label' => 'Address',
							'rules' => 'trim|required|max_length[250]'
						),
					);

					$this->form_validation->set_rules($config);
					if ($this->form_validation->run() == FALSE) {
						$this->index();
					} else {	
		
							
							$data['firstname'] = $_POST['firstname'];
							$data['lastname'] = $_POST['lastname'];
							$data['email'] = $_POST['email'];
							$data['address'] = $_POST['address'];
							/* $data['city'] = $_POST['city'];
							$data['postcode'] = $_POST['postcode']; */
							$data['last_updated'] = date('Y-m-d H:i:s');
							$result = $this->register_mdl->update_user($customer_id,$data); 

								
							if (!empty($result)) {
								$sdata['success'] = 'Update successfully .';
								$this->session->set_userdata($sdata);
								redirect('user/account', 'refresh');  
							} else {
								$sdata['exception'] = 'Operation failed !';
								$this->session->set_userdata($sdata);
								redirect('user/account', 'refresh');
							}
						
					
					}
		
		
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('user/shipping', 'refresh');
        }
		 
	 }
	
	
	public function order() { 
		$data = array();
    	$data['title'] = 'My orders'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = '';  
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info;  
		
		$customer_id = $this->session->userdata('customer_id');
		$data['orders'] = $this->order_mdl->get_order_by_customer_id($customer_id);
		
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
		$data['sidebar_content'] = $this->load->view('user_views/sidebar_content_v', $data, TRUE);
		
    	$data['main_content'] = $this->load->view('user_views/order_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
			
			
    }
	
	
	public function info($order_id) { 
		$data = array();
    	$data['title'] = 'Order Details'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = '';  
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info;  
		
		$customer_id = $this->session->userdata('customer_id');
		$data['order_info'] = $this->order_mdl->get_order_by_customer_order_id($customer_id,$order_id);
		
		$data['order_product'] = $this->order_mdl->get_order_product_by_customer_order_id($customer_id,$order_id);
		
		$data['order_history'] = $this->order_mdl->get_order_history_by_customer_order_id($customer_id,$order_id);
		
		$customer_info = $this->register_mdl->get_customer_info($customer_id);
		$data['customer_info'] = $customer_info;
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
		$data['sidebar_content'] = $this->load->view('user_views/sidebar_content_v', $data, TRUE);
		
    	$data['main_content'] = $this->load->view('user_views/orderinfo_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
			
    }
	
} 
?>
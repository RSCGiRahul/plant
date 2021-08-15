<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Register extends CC_Controller {
    
    public function __construct() {
      header('Access-Control-Allow-Origin: *');
      parent::__construct();
	  $customer_id = $this->session->userdata('customer_id');
		if ($customer_id != NULL) {
			redirect('user/account', 'refresh');
		}
		
      $this->load->model('frontend_models/Common_model', 'common_mdl'); 
	  $this->load->model('frontend_models/Register_model', 'register_mdl');
	  $this->load->model('frontend_models/Order_model', 'order_mdl');  
    }
    public function index() {
		
		
		$data = array();
    	$data['title'] = 'Register'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = ''; 
		
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
		
		
		
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
		/* $data['sidebar_content'] = $this->load->view('user_views/sidebar_content_v', $data, TRUE); */
		
    	$data['main_content'] = $this->load->view('user_views/register_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
			
    }
	
	
	public function check() { 
		 
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
                'rules' => 'trim|required|max_length[250]|valid_email|is_unique[tbl_customer.email]'
            ),           
            array(
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'trim|required|max_length[250]|is_unique[tbl_customer.phone]'
            ),           
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|max_length[250]'
            ),           
            array(
                'field' => 'confirm',
                'label' => 'Confirm Password',
                'rules' => 'trim|required|max_length[250]|matches[password]'
            ),
			array(
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'trim|required|max_length[250]'
            ),
			array(
                'field' => 'city',
                'label' => 'City',
                'rules' => 'trim|required|max_length[250]'
            ),
			array(
                'field' => 'postcode',
                'label' => 'Postcode',
                'rules' => 'trim|required|max_length[250]'
            ),
			array(
                'field' => 'state_id',
                'label' => 'State',
                'rules' => 'trim|required|max_length[250]'
            ),
			
        );
		
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {  

				$sdata['exception'] = 'Please check your fields details.';
				$this->session->set_userdata($sdata);
				
				$this->index(); 
			}else{ 
				
				$data['firstname'] = $this->input->post('firstname', TRUE);
				$data['lastname'] = $this->input->post('lastname', TRUE);
				$data['phone'] = $this->input->post('phone', TRUE);
				$data['email'] = $this->input->post('email', TRUE);
				$data['password'] = md5($this->input->post('password', TRUE));
				$data['address'] = $this->input->post('address', TRUE);
				$data['city'] = $this->input->post('city', TRUE);
				$data['postcode'] = $this->input->post('postcode', TRUE);
				$data['state_id'] = $this->input->post('state_id', TRUE);
				$data['activation_status'] = 1;
				$data['date_added'] = date('Y-m-d H:i:s');

				$customer_id = $this->register_mdl->store_user_registration_info($data);
				 
				
				$setting_info = $this->common_mdl->get_settings_info(); 
				
				$sdata['customer_id'] = $data['customer_id']; 
				$sdata['firstname'] = $data['firstname']; 
				$sdata['lastname'] = $data['lastname'];   
				$sdata['email'] = $data['email']; 
				$sdata['phone'] = $data['phone'];
				$sdata['city'] = $data['city'];
				$this->session->set_userdata($sdata);
				
				if (!empty($customer_id)) {
					$sdata['success'] = 'Register successfully . ';
					$this->session->set_userdata($sdata);
					redirect('user/register', 'refresh');
				} else {
					$sdata['exception'] = 'Something went wrong please try again.';
					$this->session->set_userdata($sdata);
					redirect('user/register', 'refresh');
				}
					 
				
			}
	}
	 
	
} 
?>
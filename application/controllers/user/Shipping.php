<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shipping extends CC_Controller {
    
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
    	$data['title'] = 'Shipping address'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = ''; 
		
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
		
		
		$customer_id = $this->session->userdata('customer_id');
		$customer_info = $this->register_mdl->get_customer_info($customer_id);
		$shipping_address_info = $this->register_mdl->get_shipping_address_info($customer_id);
		
		$data['customer_id'] = $customer_id;
		$data['customer_info'] = $customer_info;
		$data['shipping_address_info'] = $shipping_address_info;

		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
		$data['sidebar_content'] = $this->load->view('user_views/sidebar_content_v', $data, TRUE);
		
    	$data['main_content'] = $this->load->view('user_views/shipping_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
			
    }
	
	
	public function edit($shipping_id) {
		
		$customer_id = $this->session->userdata('customer_id');
		
        $data = array();
        $data['shipping_info'] = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id); 
        if (!empty($data['shipping_info'])) {
					
			$data['seo_title'] = '';  
			$data['seo_keywords'] = '';  
			$data['seo_description'] = ''; 		
			
	
		
 			
            $data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
			$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
			$data['sidebar_content'] = $this->load->view('user_views/sidebar_content_v', $data, TRUE);
			
			$data['main_content'] = $this->load->view('user_views/edit_shipping_content_v', $data, TRUE); 
			$this->load->view('frontend_views/user_master_v', $data);
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('user/shipping', 'refresh');
        }
    }
	
	
	
	 public function update($shipping_id) {
		 
		 $customer_id = $this->session->userdata('customer_id');
		
        $data = array();
        $shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id); 
        if (!empty($shipping_info)) { 
								 
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
							'rules' => 'trim|required|valid_email'
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
					);

					$this->form_validation->set_rules($config);
					if ($this->form_validation->run() == FALSE) {
						$this->edit($shipping_id);
					} else {	
		
							
							$data['firstname'] = $this->input->post('firstname', TRUE); 
							$data['lastname'] = $this->input->post('lastname', TRUE); 
							$data['email'] = $this->input->post('email', TRUE); 
							$data['address'] = $this->input->post('address', TRUE); 
							$data['city'] = $this->input->post('city', TRUE); 
							$data['postcode'] = $this->input->post('postcode', TRUE); 
							$data['last_updated'] = date('Y-m-d H:i:s');
							$result = $this->register_mdl->update_shipping_info($shipping_id, $data); 	

								
							if (!empty($result)) {
								$sdata['success'] = 'Update successfully .';
								$this->session->set_userdata($sdata);
								redirect('user/shipping', 'refresh');  
							} else {
								$sdata['exception'] = 'Operation failed !';
								$this->session->set_userdata($sdata);
								redirect('user/shipping', 'refresh');
							}
						
					
					}
		
		
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('user/shipping', 'refresh');
        }
		 
	 }
	
	
	public function ajax_shipping_address() { 
			
			$content = '';
			$form = $this->input->post('LoginFrm', TRUE);
			parse_str($form, $formData); 
			$this->form_validation->set_data($formData); 
			
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
								'rules' => 'trim|max_length[250]|valid_email'
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
						);
						
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) { 
					$success ='false';
					$msg =  validation_errors(); 
				}else{ 
					$success ='true';
				
					$data['customer_id'] = $customer_id = $this->session->userdata('customer_id');
					$data['firstname'] = $formData['firstname'];
					$data['lastname'] = $formData['lastname'];
					$data['email'] = $formData['email'];
					$data['address'] = $formData['address'];
					$data['city'] = $formData['city'];
					$data['postcode'] = $formData['postcode'];
					$data['date_added'] = date('Y-m-d H:i:s');
					
					
					$shipping_id = $this->register_mdl->store_shipping_info($data);
					
					
					$customer_info = $this->register_mdl->get_customer_info($customer_id);  
					if($customer_info['firstname']==""){
						$data_usr = array();
						$data_usr['firstname'] = $formData['firstname'];
						$data_usr['lastname'] = $formData['lastname'];
						$data_usr['email'] = $formData['email'];
						$data_usr['last_updated'] = date('Y-m-d H:i:s');
						$this->register_mdl->update_user($customer_id,$data_usr);
						
						$sdata['firstname'] = $data_usr['firstname']; 
						$this->session->set_userdata($sdata);
					}
					
					if($shipping_id==false){ 
						
						$success ='false';
						$msg =  "Error: Something went wrong. Please check your zipcode and try again."; 
						 
					}else{
						
						$data['shipping_id'] = $shipping_id;
						$content=$this->load->view('user_views/checkout_step3_content_v',$data, TRUE);
						
					}
				
				}
			
			$output['success']= $success;
			$output['message']=$msg;  
			$output['content']=$content;  
			echo json_encode($output);
			die(); 
			
		}
	 
	 
	 
	 public function remove($shipping_id) {
		 
		 
		$customer_id =  $customer_id = $this->session->userdata('customer_id');
        $shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
        if (!empty($shipping_info)) {
			
            $result = $this->register_mdl->remove_shipping($shipping_id);
            if (!empty($result)) {
                $sdata['success'] = 'Remove successfully .';
                $this->session->set_userdata($sdata);
                redirect('user/shipping', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
               redirect('user/shipping', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('user/shipping', 'refresh');
        }
    }
	 
	 
	
} 
?>
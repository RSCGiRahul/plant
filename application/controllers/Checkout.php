<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Checkout extends CC_Controller {
    
    public function __construct() {
    	parent::__construct();
    	$this->load->model('frontend_models/Common_model', 'common_mdl'); 
		$this->load->model('frontend_models/Product_model', 'product_mdl'); 
		$this->load->model('frontend_models/Cart_model', 'cart_mdl');  
		$this->load->model('frontend_models/Register_model', 'register_mdl');
    }
    
    public function index() {
		$data = array();
    	$data['title'] = 'Checkout'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = ''; 
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
		
		$data['cart_info'] = $this->cart_mdl->get_cart_info(); 
		
		$customer_id      = $this->session->userdata('customer_id'); 
		
		$data['customer_info'] = $this->register_mdl->get_customer_info($customer_id);  
		
		
		if(empty($data['cart_info'])){
			redirect('cart', 'refresh');
		}else{
			$total=0;
			foreach($data['cart_info'] as $v_cart_info){	
				$regular_price = $v_cart_info['quantity']*$v_cart_info['regular_price'];
				$total= $total+$regular_price;
			}
			
			if($total<$settings_info['minimum_order']){
				$sdata['exception'] = 'Please order minimum  '.CURRENCY.$settings_info['minimum_order'].'.';
				$this->session->set_userdata($sdata);
				redirect('cart', 'refresh');
			}
		}
		
		$data_content = array();
		$customer_id = $this->session->userdata('customer_id');
		if($customer_id!=""){
			$customer_info = $this->register_mdl->get_customer_info($customer_id);
			$shipping_address_info = $this->register_mdl->get_shipping_address_info($customer_id);
			
			$data['customer_id'] = $customer_id;
			$data['customer_info'] = $customer_info;
			$data['shipping_address_info'] = $shipping_address_info;
		}
		
		
		$data['delivery_charge'] = $settings_info['delivery_price'];
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
    	$data['main_content'] = $this->load->view('frontend_views/checkout_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
		
	}
	
	
	public function place_order() {
		
		$customer_id      = $this->session->userdata('customer_id'); 
		if($customer_id!=""){
			
			
			
			
		}else{
			$sdata['exception'] = 'Something went wrong please try again.';
			$this->session->set_userdata($sdata);
			redirect('checkout', 'refresh');
		}
		
	}
	
	
	public function login() { 
		 
			 $config = array(
				array(
					'field' => 'email',
					'label' => 'Email Or Phone number',
					'rules' => 'trim|required|max_length[250]'
				),       
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|max_length[250]'
				),   
			);
			
			
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {  
			
				$this->index(); 
			}else{ 
				$result = $this->register_mdl->check_user_login();  
				
				
				
				if (!empty($result)) {
					
					if($result->activation_status==0){
						$sdata['exception'] = 'Your account has been disabled by the administrator.';
						$this->session->set_userdata($sdata);
						redirect('checkout', 'refresh');
					}else{
					
						
						$data_last['lastlogin'] = date('Y-m-d H:i:s');  
						$this->register_mdl->update_user($result->customer_id,$data_last);
						
						$sdata['customer_id'] = $result->customer_id; 
						$sdata['firstname'] = $result->firstname; 
						$sdata['lastname'] = $result->lastname;   
						$sdata['email'] = $result->email; 
						$sdata['phone'] = $result->phone;

						$this->session->set_userdata($sdata);
						
						$sdata['success'] = 'Login successfully.';
						$this->session->set_userdata($sdata);
						redirect('checkout', 'refresh');
					} 
				}else{
					
					$sdata['exception'] = 'Your account details is not found.';
					$this->session->set_userdata($sdata);
					redirect('checkout', 'refresh');
				}
			}
		
	}
	
	
	public function register() { 
		 
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
					redirect('checkout', 'refresh');
				} else {
					$sdata['exception'] = 'Something went wrong please try again.';
					$this->session->set_userdata($sdata);
					redirect('checkout', 'refresh');
				}
					 
				
			}
	}
	
	
		/*checkout shipping address*/
		
		public function ajax_checkout_shipping_address() { 
			
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
					
					
					
					$data['shipping_outlet'] = $this->get_shipping_outlet($shipping_id); 
					
					
					if($shipping_id==false){
						$success ='false';
						$msg =  "Error: Something went wrong. Please check your zipcode and try again."; 
					
					}else if( empty($data['shipping_outlet']) ){	
							
							$success = 'false';
							$msg = 'Error: We can not ship in this Location';
					
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
		
		
		public function ajax_checkout_select_shipping() { 
			
			$content = '';
			$shipping_id = $this->input->post('shipping_id', TRUE);
			$customer_id = $this->session->userdata('customer_id');
			$shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
			
			$success = 'true';
			$output['outlet_error'] = 'false';
			
			if($shipping_info['lat']=="" || $shipping_info['lng']=="" ){
			 $excution = $this->register_mdl->update_shipping_info($shipping_id,$shipping_info);
			 if($excution==false){ $success = 'false'; }
			}
				
			
			
			 $data['shipping_outlet'] = $this->get_shipping_outlet($shipping_id); 
			 
			
				
			if(empty($data['shipping_outlet']) and $success=='true'){
				
				$success = 'false';
				$msg = 'Error: We can not ship in this Location';
			  
				$output['outlet_error'] = 'true';
				$output['shipping_id'] = $shipping_id;
			
			}else  if (!empty($shipping_info) and $success=='true') {
				 
				 $success = 'true';
				 $data['shipping_id'] = $shipping_id;
				 $content=$this->load->view('user_views/checkout_step3_content_v',$data, TRUE);  
				 
			 }else if($success=='false') {
					$msg='Error: Something went wrong. Please check your zipcode and try again.';
				 
			 }else{
				 $success = 'false';
				 $msg='Error: Something went wrong. Refresh page and try again.';
			 }
			
			$output['success']= $success;
			$output['message']=$msg;  
			$output['content']=$content;  
			echo json_encode($output);
			die(); 
		}
	
	/*checkout shipping address*/
	
	/*get_shipping_outlet*/
	
	function get_shipping_outlet($shipping_id){
			
			$customer_id = $this->session->userdata('customer_id');
			$shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
			
			$lat=$shipping_info['lat'];
			$lng=$shipping_info['lng'];
			
			
			$setting_info = $this->get_settings_info(); 
			if($setting_info['delivery_radius']){
			$distance = $setting_info['delivery_radius'];
			}else{
			$distance=50;
			}
			
			
			$sql = "SELECT *, ( 6371 * acos( cos( radians('".$lat."') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('".$lng."') ) + sin( radians('".$lat."') ) * sin( radians( lat ) ) ) ) AS distance
FROM dir_outlet HAVING distance < '".$distance."' and associated_delivery_id!='' and publication_status=1 and deletion_status=0 ORDER BY distance LIMIT 0,1"; 
			
				file_put_contents('array_data.txt',print_r($sql,true));
			 
			$query = $this->db->query($sql);
			$fetch_data = $query->result();
			
			if($fetch_data){
				
				return $fetch_data[0];
			}else{
				return false;
			} 
	}
	
	/*get_shipping_outlet*/
	
	
}
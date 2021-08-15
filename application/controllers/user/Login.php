<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CC_Controller {
    
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
	  $this->load->model('mailer_models/mailer_model', 'mail_mdl');
    }
    public function index() {
		
		
		$data = array();
    	$data['title'] = 'Login'; 
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
		
    	$data['main_content'] = $this->load->view('user_views/login_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
			
    }
	
	
	public function check() { 
		 
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
						redirect('user/login', 'refresh');
					} 
				}else{
					
					$sdata['exception'] = 'Your account details is not found.';
					$this->session->set_userdata($sdata);
					redirect('user/login', 'refresh');
				}
			}
		
	}
	
	
	public function ajax_popup_login() { 
			
			$content = '';
			
			$form = $this->input->post('LoginFrm', TRUE);
			parse_str($form, $formData); 
			$this->form_validation->set_data($formData); 
			 $config = array(
				array(
					'field' => 'phone',
					'label' => 'Phone number',
					'rules' => 'trim|required|regex_match[/^[0-9]{10}$/]'
				),  
			);
			
			
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {
								
				$success ='false';
				$msg =  validation_errors();
				
			}else{ 
			
				$phone = $formData['phone'];
				$verify_number = mt_rand(1000, 9999); 
				$result = $this->register_mdl->get_user_data_by_phone($phone); 
				if(empty($result)){
					$success ='true';
					$data = array();
					$data['verify_number'] = $verify_number;
					$data['activation_status'] = 1;
					$data['phone'] = $phone;
					$data['date_added'] = date('Y-m-d H:i:s');
					$data['last_updated'] = date('Y-m-d H:i:s');
					$customer_id = $this->register_mdl->store_user_registration_info($data);
	
				}else{		
					if($result['activation_status']==0){
						$success ='false';
						$msg = '<p>Your account is inactive by admin.</p>';
					}else{
						$customer_id = $result['customer_id'];
						$success ='true';
						$data = array();
						$data['verify_number'] = $verify_number;
						$data['last_updated'] = date('Y-m-d H:i:s');
						$result = $this->register_mdl->update_user($customer_id,$data); 
					} 
				}   
			}
			
			
			if($success=='true'){   
				$this->send_verify_number($phone,$verify_number); 
				
				$data_content['verify_number'] = $verify_number;
				$data_content['phone'] = $phone;
			    $content = $this->load->view('user_views/verify_content_v',$data_content, TRUE);    
			}
		$output['success']= $success;
		$output['message']=$msg; 
		$output['content']=$content;  
		echo json_encode($output);
		die(); 
	} 
	
	public function ajax_login_verify() { 
			
			$content = '';
			
			$form = $this->input->post('LoginFrm', TRUE);
			parse_str($form, $formData); 
			$this->form_validation->set_data($formData);  
			
			 $config = array(
				array(
					'field' => 'otp-1',
					'label' => 'OTP',
					'rules' => 'trim|required'
				),  
				array(
					'field' => 'otp-2',
					'label' => 'OTP',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'otp-3',
					'label' => 'OTP',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'otp-4',
					'label' => 'OTP',
					'rules' => 'trim|required'
				),
			); 
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else{ 
			
				$phone = $formData['phone'];
				$verify_number = $formData['otp-1'].$formData['otp-2'].$formData['otp-3'].$formData['otp-4'];				
				$result = $this->register_mdl->verify_user($phone,$verify_number); 
				
				if(!empty($result)){
					$success ='true'; 
					
					
					$data_last['lastlogin'] = date('Y-m-d H:i:s');  
					$this->register_mdl->update_user($result['customer_id'],$data_last); 
					$sdata['customer_id'] = $result['customer_id']; 
					$sdata['firstname'] = $result['firstname']; 
					$sdata['lastname'] = $result['lastname'];   
					$sdata['email'] = $result['email']; 
					$sdata['phone'] = $result['phone'];

					$this->session->set_userdata($sdata);
					
					$sdata['success'] = 'Login successfully.';
					$this->session->set_userdata($sdata);
					
					
				}else{		
					$success ='false';
					$msg = '<p>Verify code is not correct.</p>';
				}   
			}
			
		$output['success']= $success;
		$output['message']=$msg;  
		echo json_encode($output);
		die(); 
	}
	
	
	public function ajax_resend_otp() { 
			
			$content = '';
			$form = $this->input->post('LoginFrm', TRUE);
			parse_str($form, $formData); 
			$this->form_validation->set_data($formData); 
			
			 /* |max_length[10]|min_length[10] */
			
			 $config = array(
				array(
					'field' => 'phone',
					'label' => 'Phone number',
					'rules' => 'trim|required|regex_match[/^[0-9]{10}$/]'
				),  
			);
			
			
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else{ 
			
				$phone = $formData['phone'];
				$verify_number = mt_rand(1000, 9999); 
				$result = $this->register_mdl->get_user_data_by_phone($phone); 
				if(empty($result)){ 
					$success ='false';
					$msg = '<p>Something went wrong please try again.</p>';
				}else{ 
					if($result['activation_status']==0){
						$success ='false';
						$msg = '<p>Your account is inactive by admin.</p>';
					}else{
						$customer_id = $result['customer_id'];
						$success ='true';
						$data = array();
						$data['verify_number'] = $verify_number;
						$data['last_updated'] = date('Y-m-d H:i:s');
						$result = $this->register_mdl->update_user($customer_id,$data); 
					}  
				} 
			}
			
			
			if($success=='true'){   
				$verify_number = $this->send_verify_number($phone,$verify_number); 
				if($verify_number['success']=='true'){
					$data_content['verify_number'] = $verify_number;
					$data_content['phone'] = $phone;
					$content = $this->load->view('user_views/verify_content_v',$data_content, TRUE);    
				}else{
					$success ='false';
					$msg = '<p>'.$verify_number['message'].'</p>';
				}
			}
			
		$output['success']= $success;
		$output['message']=$msg; 
		$output['content']=$content;  
		echo json_encode($output);
		die(); 
	}
	
	/*checkout login*/
	
	public function ajax_checkout_login() { 
			
			$content = '';
			
			$form = $this->input->post('LoginFrm', TRUE);
			parse_str($form, $formData); 
			$this->form_validation->set_data($formData); 
			 $config = array(
				array(
					'field' => 'phone',
					'label' => 'Phone number',
					'rules' => 'trim|required|regex_match[/^[0-9]{10}$/]'
				),  
			);
			
			
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {
								
				$success ='false';
				$msg =  validation_errors();
				
			}else{ 
			
				$phone = $formData['phone'];
				$verify_number = mt_rand(1000, 9999); 
				$result = $this->register_mdl->get_user_data_by_phone($phone); 
				if(empty($result)){
					$success ='true';
					$data = array();
					$data['verify_number'] = $verify_number;
					$data['phone'] = $phone;
					$data['activation_status'] = 1;
					$data['date_added'] = date('Y-m-d H:i:s');
					$data['last_updated'] = date('Y-m-d H:i:s');
					$customer_id = $this->register_mdl->store_user_registration_info($data);
	
				}else{		
					if($result['activation_status']==0){
						$success ='false';
						$msg = '<p>Your account is inactive by admin.</p>';
					}else{
						$customer_id = $result['customer_id'];
						$success ='true';
						$data = array();
						$data['verify_number'] = $verify_number;
						$data['last_updated'] = date('Y-m-d H:i:s');
						$result = $this->register_mdl->update_user($customer_id,$data); 
					} 
				}   
			}
			
			
			if($success=='true'){   
				$this->send_verify_number($phone,$verify_number); 
				
				$data_content['verify_number'] = $verify_number;
				$data_content['phone'] = $phone;
			    $content = $this->load->view('user_views/verify_checkout_content_v',$data_content, TRUE);    
			}
		$output['success']= $success;
		$output['message']=$msg; 
		$output['content']=$content;  
		echo json_encode($output);
		die(); 
	}
	
	
	
	public function ajax_checkout_login_verify() { 
			
			$content = '';
			
			$form = $this->input->post('LoginFrm', TRUE);
			parse_str($form, $formData); 
			$this->form_validation->set_data($formData);  
			
			 $config = array(
				array(
					'field' => 'otp-checkout-1',
					'label' => 'OTP',
					'rules' => 'trim|required'
				),  
				array(
					'field' => 'otp-checkout-2',
					'label' => 'OTP',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'otp-checkout-3',
					'label' => 'OTP',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'otp-checkout-4',
					'label' => 'OTP',
					'rules' => 'trim|required'
				),
			); 
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else{ 
			
				$phone = $formData['phone'];
				$verify_number = $formData['otp-checkout-1'].$formData['otp-checkout-2'].$formData['otp-checkout-3'].$formData['otp-checkout-4'];				
				$result = $this->register_mdl->verify_user($phone,$verify_number); 
				
				if(!empty($result)){
					$success ='true'; 
					
					
					$data_last['lastlogin'] = date('Y-m-d H:i:s');  
					$this->register_mdl->update_user($result['customer_id'],$data_last); 
					$sdata['customer_id'] = $result['customer_id']; 
					$sdata['firstname'] = $result['firstname']; 
					$sdata['lastname'] = $result['lastname'];   
					$sdata['email'] = $result['email']; 
					$sdata['phone'] = $result['phone'];

					$this->session->set_userdata($sdata);
					
					$sdata['success'] = 'Login successfully.';
					$this->session->set_userdata($sdata);
					
					$data_content = array();
					$customer_id = $this->session->userdata('customer_id');
					$customer_info = $this->register_mdl->get_customer_info($customer_id);
					$shipping_address_info = $this->register_mdl->get_shipping_address_info($customer_id);
					
					/* $data['customer_id'] = $customer_id;
					$data['customer_info'] = $customer_info;
					$data['shipping_address_info'] = $shipping_address_info; */

					$data_content['customer_id'] = $customer_id;
					$data_content['customer_info'] = $customer_info;
					$data_content['shipping_address_info'] = $shipping_address_info;
					
					
					$content=$this->load->view('user_views/checkout_step2_content_v',$data_content, TRUE);    
					
				}else{		
					$success ='false';
					$msg = '<p>Verify code is not correct.</p>';
				}   
			}
			
		$output['success']= $success;
		$output['message']=$msg;  
		$output['content']=$content;  
		echo json_encode($output);
		die(); 
	}
	
	
	
	public function ajax_checkout_resend_otp() { 
			
			$content = '';
			$form = $this->input->post('LoginFrm', TRUE);
			parse_str($form, $formData); 
			$this->form_validation->set_data($formData); 
			
			 /* |max_length[10]|min_length[10] */
			
			 $config = array(
				array(
					'field' => 'phone',
					'label' => 'Phone number',
					'rules' => 'trim|required|regex_match[/^[0-9]{10}$/]'
				),  
			);
			
			
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else{ 
			
				$phone = $formData['phone'];
				$verify_number = mt_rand(1000, 9999); 
				$result = $this->register_mdl->get_user_data_by_phone($phone); 
				if(empty($result)){ 
					$success ='false';
					$msg = '<p>Something went wrong please try again.</p>';
				}else{ 
					if($result['activation_status']==0){
						$success ='false';
						$msg = '<p>Your account is inactive by admin.</p>';
					}else{
						$customer_id = $result['customer_id'];
						$success ='true';
						$data = array();
						$data['verify_number'] = $verify_number;
						$data['last_updated'] = date('Y-m-d H:i:s');
						$result = $this->register_mdl->update_user($customer_id,$data); 
					}  
				} 
			}
			
			
			if($success=='true'){   
				$verify_number = $this->send_verify_number($phone,$verify_number); 
				if($verify_number['success']=='true'){
					$data_content['verify_number'] = $verify_number;
					$data_content['phone'] = $phone;
					$content = $this->load->view('user_views/verify_checkout_content_v',$data_content, TRUE);    
				}else{
					$success ='false';
					$msg = '<p>'.$verify_number['message'].'</p>';
				}
			}
			
		$output['success']= $success;
		$output['message']=$msg; 
		$output['content']=$content;  
		echo json_encode($output);
		die(); 
	}
	/*checkout login*/
	
	
	
	
	
	 public function send_verify_number($phone,$verify_number) {
	
		file_put_contents('verify_number.txt',print_r($verify_number,true));
		
		$curl = curl_init();
				
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://2factor.in/API/V1/4917de67-4756-11ea-9fa5-0200cd936042/SMS/".$phone."/".$verify_number."",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  $success = 'false';
		   $msg =  "cURL Error #:" . $err;
		} else {
		  $success = 'true';	
		  $msg =  $response;
		}
		$output['success']= $success;
		$output['message']=$msg;
		return ($output);
		die(); 
	 }
	
} 
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define("CURRENCY_API",'Rs ');
require_once (BASEPATH .'/razorpay/razorpay-php/Razorpay.php');
use Razorpay\Api\Api as RazorpayApi;
use Razorpay\Api\Errors\SignatureVerificationError as SignatureVerificationError;

class ApiData extends CC_Controller {
    
    public function __construct() {
      header('Access-Control-Allow-Origin: *');
      parent::__construct();
      $this->load->model('frontend_models/ApiData_model', 'api_mdl');
	  $this->load->model('frontend_models/Register_model', 'register_mdl');	
	  $this->load->model('frontend_models/Common_model', 'common_mdl'); 
	  $this->load->model('frontend_models/Product_model', 'product_mdl'); 
	  $this->load->model('frontend_models/Cart_model', 'cart_mdl'); 
	  $this->load->model('frontend_models/Wishlist_model', 'wishlist_mdl'); 
	  
	  $this->load->model('frontend_models/Order_model', 'order_mdl');  
	  $this->load->model('mailer_models/mailer_model', 'mail_mdl');
    }
    public function index() {
    }
	
	
	/*sms*/	
	public function SendOtp() {
		$success = false; 
		$msg = "";  
		
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
				
				$phone = $_POST['phone']; 
				$verify_number = '1234';//mt_rand(1000, 9999);
				if($_POST['user_type']==""){ $_POST['user_type']=1; }
				$user_type = $_POST['user_type'];
				
				/*customer*/
				if($user_type==1){
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
								$msg = 'Your account is inactive by admin.\n';
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
			/*customer*/
			
			/*delevery boy*/
			if($user_type==2){
			
				$result = $this->register_mdl->get_delivery_data_by_phone($phone); 
				if(empty($result)){
					
					$success ='false';
					$msg = 'Your phone number not found.\n';
					
					/* 
					$data = array();
					$data['verify_number'] = $verify_number;
					$data['publication_status'] = 1;
					$data['phone'] = $phone;
					$data['date_added'] = date('Y-m-d H:i:s');
					$data['last_updated'] = date('Y-m-d H:i:s');
					$customer_id = $this->register_mdl->store_delivery_registration_info($data); */
					
					
					
				}else{	
				
					if($result['publication_status']==0){
						$success ='false';
						$msg = 'Your account is inactive by admin.\n';
					}else{
						$delivery_id = $result['delivery_id'];
						$success ='true'; 
						$data = array();
						$data['verify_number'] = $verify_number;
						$data['last_updated'] = date('Y-m-d H:i:s');
						$result = $this->register_mdl->update_delivery($delivery_id,$data); 
					}
				
				} 
				
				
			}
			/*delevery boy*/
			
			
			
			/*outlet*/
			
			if($user_type==3){
			
				$result = $this->register_mdl->get_outlet_data_by_phone($phone); 	
				if(empty($result)){
		
					$success ='false';
					$msg = 'Your phone number not found.\n';	
					
				}else{	
				
					
					if($result['publication_status']==0){
						$success ='false';
						$msg = 'Your account is inactive by admin.\n';
					}else{
						$outlet_id = $result['outlet_id'];
						$success ='true'; 
						$data = array();
						$data['verify_number'] = $verify_number;
						$data['last_updated'] = date('Y-m-d H:i:s');
						$result = $this->register_mdl->update_outlet($outlet_id,$data); 
					}
				
				}
				
			
			}
			
			/*outlet*/
				
				
				
			}			
		
		
		if($success=='true'){  
			$this->send_verify_number($phone,$verify_number); 
			$msg = 'Otp sent on your mobile number.\n';
		}
		
		$output['status'] = $success; 
		
		
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; 
		echo json_encode($output);
		die(); 
	}
	
	
	
	public function VerifyOtp() {
		
		$success = false; 
		$msg = ""; 
		$user='';
		
		$config = array(
				array(
					'field' => 'phone',
					'label' => 'Phone number',
					'rules' => 'trim|required|regex_match[/^[0-9]{10}$/]'
				), 

				array(
					'field' => 'otp',
					'label' => 'OTP',
					'rules' => 'trim|required'
				), 				
			);
		
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else{ 
		
				$phone = $_POST['phone'];
				$verify_number = $_POST['otp'];
				if($_POST['user_type']==""){ $_POST['user_type']=1; }
				$user_type = $_POST['user_type'];
				
				/*user_type = customer*/
				if($user_type==1){
				
					$result = $this->register_mdl->verify_user($phone,$verify_number); 
					
					if(!empty($result)){
						$success ='true'; 
						$data_last['lastlogin'] = date('Y-m-d H:i:s');  
						$this->register_mdl->update_user($result['customer_id'],$data_last); 
						$customer_id = $result['customer_id']; 
						
						$customer_info = $this->register_mdl->get_customer_info($customer_id);
						$user = array(
									'customer_id' => $customer_info['customer_id'],
									'firstname' => $customer_info['firstname'],
									'lastname' => $customer_info['lastname'],
									'phone' => $customer_info['phone'],
									'email' => $customer_info['email'],
									'address' => $customer_info['address'],
								);
								
						
						
					}else{		
						$success ='false';
						$msg = 'Verify code is not correct.\n';
					}
				}
				
				/*user_type = customer*/
				
				
				
				/*user_type = delivery*/
				
				if($user_type==2){
					$result = $this->register_mdl->verify_delivery($phone,$verify_number); 
					if(!empty($result)){
						$success ='true'; 
						$data_last['lastlogin'] = date('Y-m-d H:i:s');  
						$this->register_mdl->update_delivery($result['delivery_id'],$data_last); 
						$delivery_id = $result['delivery_id']; 
						
						$delivery_info = $this->register_mdl->get_delivery_info($delivery_id);
						$user = array(
									'delivery_id' => $delivery_info['delivery_id'],
									'delivery_name' => $delivery_info['delivery_name'],
									'address' => $delivery_info['address'],
									'city' => $delivery_info['city'],
									'zipcode' => $delivery_info['zipcode'],
								);
						
					}else{		
						$success ='false';
						$msg = 'Verify code is not correct.\n';
					}
					
				
				}
				
				/*user_type = delivery*/
				
				
				/*user_type = outlet*/
				
				if($user_type==3){
					$result = $this->register_mdl->verify_outlet($phone,$verify_number); 
					if(!empty($result)){
						$success ='true'; 
						$data_last['lastlogin'] = date('Y-m-d H:i:s');  
						$this->register_mdl->update_outlet($result['outlet_id'],$data_last); 
						$outlet_id = $result['outlet_id']; 
						
						$outlet_info = $this->register_mdl->get_outlet_info($outlet_id);
						$user = array(
									'outlet_id' => $outlet_info['outlet_id'],
									'outlet_name' => $outlet_info['outlet_name'],
									'phone' => $outlet_info['phone'],
									'address' => $outlet_info['address'],
									'assigned_city' => $outlet_info['assigned_city'],
									'zipcode' => $outlet_info['zipcode'],
								);
						
					}else{		
						$success ='false';
						$msg = 'Verify code is not correct.\n';
					}
					
				
				}
				
				/*user_type = outlet*/
				
				
				
			}
		
		
		
		$output['status'] = $success; 
		if($user!=""){ $output['user'] = $user; }
		if($msg!=""){ 
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; }
		echo json_encode($output);
		die();
	}
	
	/*sms*/
	
	
	/*update user*/
	
	public function UpdateCustomer() {
		$success = false; 
		$msg = ""; 
		
		$customer_id= $_POST['customer_id'];
		
		$customer_info = $this->register_mdl->get_customer_info($customer_id);
		if(empty($customer_info)){
			
			$msg = "No Customer data found.\n";
			
		}else{
		
		
		$config = array(
				array(
					'field' => 'customer_id',
					'label' => 'Customer id',
					'rules' => 'trim|required'
				), 

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
				/* array(
					'field' => 'city',
					'label' => 'City',
					'rules' => 'trim|required|max_length[250]'
				),
				array(
					'field' => 'postcode',
					'label' => 'Postcode',
					'rules' => 'trim|required|max_length[250]'
				), */
				
			);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else{  
			
					$success ='true';
					$data = array();
					$data['firstname'] = $_POST['firstname'];
					$data['lastname'] = $_POST['lastname'];
					$data['email'] = $_POST['email'];
					$data['address'] = $_POST['address'];
					/* $data['city'] = $_POST['city'];
					$data['postcode'] = $_POST['postcode']; */
					$data['last_updated'] = date('Y-m-d H:i:s');
					$result = $this->register_mdl->update_user($customer_id,$data); 	

					$customer_info = $this->register_mdl->get_customer_info($customer_id);
					$user = array(
								'customer_id' => $customer_info['customer_id'],
								'firstname' => $customer_info['firstname'],
								'lastname' => $customer_info['lastname'],
								'phone' => $customer_info['phone'],
								'email' => $customer_info['email'],
								'address' => $customer_info['address'],
							);
					
				
			}
		}
		
		$output['status'] = $success; 
		if($user!=""){ $output['user'] = $user; }
		if($msg!=""){ 
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; }
		echo json_encode($output);
		die();	
	}
	
	/*update user*/
	
	
	/*update FCM token */
	
	public function FCMToken () {
		
		$success = false; 
		$msg = ""; 
		
		$customer_id= $_POST['customer_id'];
		
		$customer_info = $this->register_mdl->get_customer_info($customer_id);
		if(empty($customer_info)){
			
			$msg = "No Customer data found.\n";
			
		}else{
		
		
		$config = array(
				array(
					'field' => 'customer_id',
					'label' => 'Customer id',
					'rules' => 'trim|required'
				), 

				array(
					'field' => 'fcm_token',
					'label' => 'FCM Token',
					'rules' => 'trim|required|max_length[250]'
				),           
				 
				
			);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else{  
			
					$success ='true';
					$data = array();
					$data['fcm_token'] = $_POST['fcm_token']; 
					/* $data['last_updated'] = date('Y-m-d H:i:s'); */
					$data['token_updatetime'] = date('Y-m-d H:i:s');
					
					
					$result = $this->register_mdl->update_user($customer_id,$data); 	

					$customer_info = $this->register_mdl->get_customer_info($customer_id);
					$user = array(
								'customer_id' => $customer_info['customer_id'],
								'firstname' => $customer_info['firstname'],
								'lastname' => $customer_info['lastname'],
								'phone' => $customer_info['phone'],
								'email' => $customer_info['email'],
								'address' => $customer_info['address'],
								'token_updatetime' => $customer_info['token_updatetime'],
							);
					
				
			}
		}
		
		$output['status'] = $success; 
		if($user!=""){ $output['user'] = $user; }
		if($msg!=""){ 
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; }
		echo json_encode($output);
		die();	
	}
	
	/*update FCM token */
	
	
	
	/*get Customer info*/
	
	public function getCustomer() {
		
		$success = false; 
		$msg = ""; 
		
		$customer_id= $_POST['customer_id'];
		
		$customer_info = $this->register_mdl->get_customer_info($customer_id);
		if(empty($customer_info)){
			
			$msg = "No Customer data found.";
			
		}else{
			
			$config = array(
				array(
					'field' => 'customer_id',
					'label' => 'Customer id',
					'rules' => 'trim|required'
				), 
			);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else{  
					
					
					$success ='true';
					$user = array(
								'customer_id' => $customer_info['customer_id'],
								'firstname' => $customer_info['firstname'],
								'lastname' => $customer_info['lastname'],
								'phone' => $customer_info['phone'],
								'email' => $customer_info['email'],
								'address' => $customer_info['address'],
							);
					
				
			}
		}
			
		$output['status'] = $success; 
		if($user!=""){ $output['user'] = $user; }
		if($msg!=""){ 
		
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; }
		echo json_encode($output);
		die();
	}
	
	/*get Customer info*/
	
	
	
	
	/*get Delivery info*/
	
	public function getDelivery() {
		
		$success = false; 
		$msg = ""; 
		
		$delivery_id= $_POST['delivery_id'];
		
		$delivery_info = $this->register_mdl->get_delivery_info($delivery_id);
		if(empty($delivery_info)){
			
			$msg = "No User data found.";
			
		}else{
			
			$config = array(
				array(
					'field' => 'delivery_id',
					'label' => 'Delivery id',
					'rules' => 'trim|required'
				), 
			);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else{  
					
					
					$success ='true';
					$user = array(
								'delivery_id' => $delivery_info['delivery_id'],
								'delivery_name' => $delivery_info['delivery_name'],
								'address' => $delivery_info['address'],
								'city' => $delivery_info['city'],
								'zipcode' => $delivery_info['zipcode'],
							);
					
				
			}
		}
			
		$output['status'] = $success; 
		if($user!=""){ $output['info'] = $user; }
		if($msg!=""){ 
		
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; }
		echo json_encode($output);
		die();
	}
	
	/*get Delivery info*/
	
	
	
	/*get Outlet info*/
	
	public function getOutlet() {
		
		$success = false; 
		$msg = ""; 
		
		$outlet_id= $_POST['outlet_id'];
		
		$outlet_info = $this->register_mdl->get_outlet_info($outlet_id);
		if(empty($outlet_info)){
			
			$msg = "No User data found.";
			
		}else{
			
			$config = array(
				array(
					'field' => 'outlet_id',
					'label' => 'Outlet id',
					'rules' => 'trim|required'
				), 
			);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else{  
					
					
					$success ='true';
					$user = array(
								'outlet_id' => $outlet_info['outlet_id'],
								'outlet_name' => $outlet_info['outlet_name'],
								'phone' => $outlet_info['phone'],
								'address' => $outlet_info['address'],
								'assigned_city' => $outlet_info['assigned_city'],
								'zipcode' => $outlet_info['zipcode'],
								'lat' => $outlet_info['lat'],
								'lng' => $outlet_info['lng'],
							);
					
				
			}
		}
			
		$output['status'] = $success; 
		if($user!=""){ $output['info'] = $user; }
		if($msg!=""){ 
		
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; }
		echo json_encode($output);
		die();
	}
	
	/*get Outlet info*/
	
	
	
	
	/*get homepage data*/
	public function getHomepageData() {
		$success = true; 
		$msg = ""; 
		$response = array();
		
		$home_content = $this->api_mdl->get_home_content();
		$k__i=0;	
		foreach($home_content as $content){
			$k__i++;	
			$i = $content['setting_id'];
			
			$response[$k__i]['id'] = (int)$content['setting_id'];
			$response[$k__i]['sort_order'] = (int)$content['sort_order'];
			$response[$k__i]['type'] = $type = $content['type'];
			$response[$k__i]['title'] = $content['title'];
			
			if($type=='Slider'){
				
				$slider_images = json_decode($content['slider_images']);
				$slider_images_array= array();
				foreach($slider_images as $v_slider_images){
					
					$slider_images_array[] = base_url('assets/uploads/').$v_slider_images;
				}
				
				$response[$k__i]['slider_images'] = $slider_images_array;
			}
			
			if($type=='Content'){
				$response[$k__i]['description'] = $content['description'];
			}
			
			if($type=='Category'){
				$response[$k__i]['style'] = $content['category_type'];
				
				$special_category = json_decode($content['special_category']); 
				$order='cat.category_image';
				$orderby='DESC';

				$this->db->select('cat.*')
						->from('dir_categories as cat')  
						->where('cat.publication_status', 1) 
						/* ->where('cat.category_image!=',"")  */
						->where('cat.deletion_status',0) 
						->order_by(''.$order.'', ''.$orderby.'')
						->limit(6);	 

				 

				$where = ' 1=1';
				if($special_category){
				  $where .= '   and( ';  
				   $i=0;
					foreach($special_category as $v_special_category){
						 $i=$i+1;
						 if($i!=1){ $where .= ' OR '; }
						 $where .= ' cat.category_id="'.$v_special_category.'"';  
					}
					$where .= ' ) ';  
					
				}
				$this->db->where( $where ); 
				$query_result = $this->db->get();
				$results = $query_result->result_array();
				
				$result = array();
				foreach($results as $v_results){
					
					$v_results['category_id'] = (int)$v_results['category_id'];  
					$v_results['parent_id'] = (int)$v_results['parent_id'];  
					$v_results['user_id'] = (int)$v_results['user_id'];  
					
					if($v_results['category_image']){
							 $v_results['category_image'] =  base_url('assets/uploads/category/')."".$v_results['category_image'];
					}
					
					if($v_results['category_banner']){
						$v_results['category_banner'] =  base_url('assets/uploads/category/')."".$v_results['category_banner'];
					}
							
					
					$result[] = $v_results;
				} 
				$response[$k__i]['category_listing'] = $result;
			}
			
			
			if($type=='Product'){
				$response[$k__i]['product_type'] = $content['product_type'];
				
				/*product data*/
				$product_type =$content['product_type']; 
				$special_category = json_decode($content['special_category']);

				$order='product.product_id';
				$orderby='desc';

				$this->db->select('product.*')
				->from('dir_product as product')  
				->where('product.product_category!=', "") 
				->where('product.publication_status', 1) 
				->where('product.deletion_status',0) 
				->order_by(''.$order.'', ''.$orderby.'')
				->limit(10);	 
				
				$where = ' 1=1';
				
				if($special_category){
				  $where .= '   and( ';  
				   $i=0;
					foreach($special_category as $v_special_category){
						 $i=$i+1;
						 if($i!=1){ $where .= ' OR '; }
						 $where .= '  FIND_IN_SET("'.$v_special_category.'", product.product_category)  ';  
					}
					$where .= '   ) ';  
					
				}
				
				$this->db->where( $where ); 		
				 
				$query_result = $this->db->get();
				$result = $query_result->result_array();	
				/*product data*/
				$product_data = array();
				foreach($result as $v_result){
					
					$v_result['product_id'] = (int)$v_result['product_id']; 
					
					
					$v_result['user_id'] = (int)$v_result['user_id']; 
					$v_result['brand_id'] = (int)$v_result['brand_id']; 
				
					
					$v_result['price'] = (float)$v_result['price']; 
					$v_result['discount'] = (float)$v_result['discount']; 
					$v_result['discount_price'] = (float)$v_result['discount_price']; 
					
					
					$product_images = json_decode($v_result['product_images']); 
					
					if($v_result['gallery_featured_mobile']){
					$v_result['gallery_featured'] = base_url('assets/uploads/product/').$v_result['gallery_featured_mobile']; 
					}
					
					$product_images_array =  array();
					foreach($product_images as $v_product_images){
						$product_images_array[] = base_url('assets/uploads/product/').$v_product_images;
					}
					$v_result['product_images'] = $product_images_array;
				
					
					
					/* $product_attribute = json_decode($v_result['product_attribute']);  */
					
					
					/*attribute*/
					$product_attribute = $this->product_mdl->get_dir_product_attribute($v_result['product_id']); 
					$product_attribute_array = array();
					foreach($product_attribute as $attribute){
						
						if($attribute['attribute_name']!="" and $attribute['product_attribute_description']!=""){
							$_product_attribute_array['attribute_name'] = $attribute['attribute_name'];
							$_product_attribute_array['sorting'] = (int)$attribute['sorting'];
							$_product_attribute_array['product_attribute_description'] = $attribute['product_attribute_description'];
							$product_attribute_array[] = $_product_attribute_array; 
						}
					}		
					$v_result['product_attribute'] = $product_attribute_array;
					/*attribute*/
					
					/*price option*/
					$price_option_array = array();
					$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$v_result['product_id']."' order by price ";
					$query_price_option = $this->db->query($sql_price_option);
					$result_price_option = $query_price_option->result();
					foreach($result_price_option as $v_result_price_option){
						
						
						$_price_option_array['price_id'] = (int)$v_result_price_option->price_id;
						$_price_option_array['product_id'] = (int)$v_result_price_option->product_id;
						$_price_option_array['name'] = $v_result_price_option->name;
						$_price_option_array['sorting'] = (int)$v_result_price_option->sorting;
						
						$_price_option_array['price'] = (float)$v_result_price_option->price;
						$_price_option_array['discount'] = (float)$v_result_price_option->discount;
						$_price_option_array['discount_price'] = (float)$v_result_price_option->discount_price;
						
						$price_option_array[] = $_price_option_array; 
					} 
					/*price option*/ 
					 
					$v_result['price_option'] = $price_option_array;  
					$product_data[] = $v_result;
				} 
				
				$response[$k__i]['product_listing'] = $product_data; 
				
			}
			
			
					
		}
		
		
		
		$output['status'] = $success; 
		$output['response'] = $response; 
		echo json_encode($output);
		die();	
	}
	/*get homepage data*/
	
	
	/*category*/
	
	public function MainCategory() {
		$output['status'] = true; 
		$output['message'] = ""; 
		$categories = $this->api_mdl->get_main_categories();
		$output['categories'] = $categories;
		echo json_encode($output);
		die(); 
	}
	
	/* 
	public function getAllCategories() {
		$output['status'] = true; 
		$output['message'] = ""; 
		$categories = $this->api_mdl->get_all_categories();
		$output['categories'] = $categories;
		echo json_encode($output);
		die(); 
	} 
	*/
	
	public function getAllCategories() {
		$output['status'] = true; 
		$categories = $this->api_mdl->get_all_categories();
		$output['categories'] = $categories;
		echo json_encode($output);
		die(); 
	}
	
	public function getCategoriesByParentId($parent_id) {
		$output['status'] = true; 
		$output['message'] = ""; 
		
		
		$home_content = $this->api_mdl->get_home_content();
		$k__i=0;	
		foreach($home_content as $content){
			$k__i++;	
			$i = $content['setting_id'];
			$type = $content['type'];
			
			if($type=='Slider'){
				$slider_images = json_decode($content['slider_images']);
				$slider_images_array= array();
				foreach($slider_images as $v_slider_images){
					
					$slider_images_array[] = base_url('assets/uploads/').$v_slider_images;
				}
				
				$output['slider_images'] = $slider_images_array;
			}
		}
		
		
		// $categories_data = $this->api_mdl->getCategoriesByParentId($parent_id);
		$categories_data = $this->api_mdl->getCategoryProduct($parent_id);
		$categories = array();
		foreach($categories_data as $v_categories){
			
			$v_categories['category_id'] = (int)$v_categories['category_id'];
			$v_categories['parent_id'] = (int)$v_categories['parent_id'];
			$v_categories['category_id'] = (int)$v_categories['category_id'];
			
			if($v_categories['category_image']){
			 $v_categories['category_image'] =  base_url('assets/uploads/category/')."".$v_categories['category_image'];
			}
			
			if($v_categories['category_banner']){
					$v_categories['category_banner'] =  base_url('assets/uploads/category/')."".$v_categories['category_banner'];
			}

			$wholesaleArr = (array)json_decode($v_categories['wholesale_price']);
			if ( 	$wholesaleArr )
			{
				usort($wholesaleArr, function ($a, $b) {
					return $a->price - $b->price;
				});
			}
		$v_categories['wholesale_price'] =  $wholesaleArr;
				
	
			unset($v_categories['publication_status']);
			unset($v_categories['deletion_status']);
			unset($v_categories['featured']);
			unset($v_categories['bucket']);
			unset($v_categories['type']);
			unset($v_categories['category_banner']);
			unset($v_categories['category_banner_heading']);
			unset($v_categories['category_banner_desc']);
						
			$categories[] = $v_categories; 
		}
		$output['categories'] = $categories;
		
		if(empty($categories)){ $output['status'] = false; $output['message'] = "No category found."; }
		$output['categories'] = $categories;
		echo json_encode($output);
		die(); 
	}
	
	public function getHomepageCategoryData() {
		$output['status'] = true; 
		
		$home_content = $this->api_mdl->get_home_content();
		$k__i=0;	
		foreach($home_content as $content){
			$k__i++;	
			$i = $content['setting_id'];
			$type = $content['type'];
			
			if($type=='Slider'){
				$slider_images = json_decode($content['slider_images']);
				$slider_images_array= array();
				foreach($slider_images as $v_slider_images){
					
					$slider_images_array[] = base_url('assets/uploads/').$v_slider_images;
				}
				
				$output['slider_images'] = $slider_images_array;
			}
		}
		
		$categories_data = $this->api_mdl->get_main_categories();
		
		$categories = array();
		foreach($categories_data as $v_categories){
			
			$v_categories['category_id'] = (int)$v_categories['category_id'];
			$v_categories['parent_id'] = (int)$v_categories['parent_id'];
			$v_categories['category_id'] = (int)$v_categories['category_id'];
			
			if($v_categories['category_image']){
			 $v_categories['category_image'] =  base_url('assets/uploads/category/')."".$v_categories['category_image'];
			}
			
			if($v_categories['category_banner']){
			$v_categories['category_banner'] =  base_url('assets/uploads/category/')."".$v_categories['category_banner'];
			}
			
			unset($v_categories['publication_status']);
			unset($v_categories['deletion_status']);
			unset($v_categories['featured']);
			unset($v_categories['bucket']);
			unset($v_categories['type']);
			unset($v_categories['category_banner']);
			unset($v_categories['category_banner_heading']);
			unset($v_categories['category_banner_desc']);
						
			$categories[] = $v_categories; 
		}
		$output['categories'] = $categories;
		
		
		$child_categories = array();
		foreach($categories as $v_categories){
			$parent_id = (int)$v_categories['category_id'];
			$seo_url = $v_categories['seo_url']; 
			$Categories_child = $this->api_mdl->getCategoriesByParentId($parent_id);
			if(!empty($Categories_child)){  
					$categories_data = array();
					foreach($Categories_child as $v_v_categories){
						
						$v_v_categories['category_id'] = (int)$v_v_categories['category_id'];
						$v_v_categories['parent_id'] = (int)$v_v_categories['parent_id'];
						$v_v_categories['category_id'] = (int)$v_v_categories['category_id'];
						
							if($v_v_categories['category_image']){
							 $v_v_categories['category_image'] =  base_url('assets/uploads/category/')."".$v_v_categories['category_image'];
							}
							
							if($v_v_categories['category_banner']){
							$v_v_categories['category_banner'] =  base_url('assets/uploads/category/')."".$v_v_categories['category_banner'];
							}

						unset($v_v_categories['publication_status']);
						unset($v_v_categories['deletion_status']);
						unset($v_v_categories['featured']);
						unset($v_v_categories['bucket']);
						unset($v_v_categories['type']);
						unset($v_v_categories['category_banner']);
						unset($v_v_categories['category_banner_heading']);
						unset($v_v_categories['category_banner_desc']);
									
						$categories_data[] = $v_v_categories; 
					}
					$output[''.$seo_url.''] = $categories_data; 
			}
		}
		
		
		
		echo json_encode($output);
		die(); 
	}
	
	
	/*category*/
	
	
	
	/*cart*/
	
	public function addToCart() {
		$success = false; 
		$msg = ""; 
		$quantity = 0;
		
		$config = array(
			array(
    			'field' => 'customer_id',
    			'label' => 'Customer Id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'product_id',
    			'label' => 'Product',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'quantity',
    			'label' => 'Quantity',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$product_info = $this->product_mdl->get_product_by_product_id($_POST['product_id']);
		$customer_info = $this->register_mdl->get_customer_info($_POST['customer_id']);
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "Error: Product not found.\n";
		}else if (empty($customer_info)) {	
			 $msg =  "Error: Customer not found.\n";
		}else{
			
			$success='true';	
			$gallery_featured = $product_info['gallery_featured_mobile'];
			if($gallery_featured==""){
				$product_images = json_decode($product_info['product_images']);
				$gallery_featured = $product_images[0];
			} 
			$productImg=base_url('assets/uploads/product/'.$gallery_featured.'');
			
			
			$product_id = 	$product_info['product_id'];
			$quantity = 	$_POST['quantity'];
			$price_option = 	$_POST['price_option'];
			
			$price = $product_info['price'];
			$discount = '0';
			$discount_price = '0';
			$price_id = '0';
			
			if($price>0){
				$discount = $product_info['discount']; 
				$discount_price = $product_info['discount_price']; 
				$product_title = $product_info['product_name'];
			}else{ 
			
				if($price_option==""){
					$success ='false';
					$msg =  "Please select product option\n";
					
				}else{
					$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$product_info['product_id']."' and `price_id`='".$price_option."' order by price ";
					$query_price_option = $this->db->query($sql_price_option);
					$result_price_option = $query_price_option->result();
					$price = number_format((float)$result_price_option[0]->price, 2, '.', ''); 
					$discount = number_format((float)$result_price_option[0]->discount, 2, '.', '');
					$discount_price = number_format((float)$result_price_option[0]->discount_price, 2, '.', ''); 
					$price_option_name =  $result_price_option[0]->name;	
					
					$price_id = (int)$result_price_option[0]->price_id;	
					
					$product_title = $product_info['product_name']." - ".$price_option_name;
					
					if($price_id==""){
						$success ='false';
						$msg =  "Please Select valid price option value.\n";
					
					}
					
				}
				
			}
			
			if($success !='false'){
			
				if($discount>0){
					$regular_price = $discount_price;
					$discount = $discount; 
				}else{
					$regular_price = $price;
					$discount = 0;
				}
				
				$car_data = array();
				
				
				$car_data['customer_id'] = (int)$_POST['customer_id'];
				$car_data['quantity'] = (int)$_POST['quantity']; 
				$car_data['product_id'] = (int)$product_info['product_id']; 
				$car_data['price_id'] =  (int)$price_id;			
				$car_data['product_title'] = $product_title;
				$car_data['price'] = number_format((float)$price, 2, '.', '');
				$car_data['regular_price'] = number_format((float)$regular_price, 2, '.', '');
				$car_data['discount'] = number_format((float)$discount, 2, '.', '');
				
				$cart_info = $this->cart_mdl->store_cart($car_data);
				$cart_info = array();
				$get_cart_info = $this->api_mdl->get_cart_info($_POST['customer_id']); 
				
				$quantity = 0;
				$total=0;	
				$total_discount_price=0;
				
				$get_cart_info_array = array();

				foreach($get_cart_info as $cart_info){	
					
					$get_cart_info_array['cart_id'] = (int)$cart_info['cart_id'];	
					$get_cart_info_array['customer_id'] = (int)$cart_info['customer_id'];	
					$get_cart_info_array['product_id'] = (int)$cart_info['product_id'];	
					$get_cart_info_array['price_id'] = (int)$cart_info['price_id'];	
					$get_cart_info_array['product_title'] = $cart_info['product_title'];	
					
					$get_cart_info_array['price'] = number_format((float)$cart_info['price'], 2, '.', '');	
					$get_cart_info_array['regular_price'] = number_format((float)$cart_info['regular_price'], 2, '.', '');	
					$get_cart_info_array['discount'] = number_format((float)$cart_info['discount'], 2, '.', '');	
					
					$get_cart_info_array['quantity'] = (int)$cart_info['quantity'];
					$get_cart_info_array['date_added'] = $cart_info['date_added'];	
				
				
					$quantity = $quantity  + $cart_info['quantity'];			  
				  
					$regular_price = number_format($cart_info['quantity']*$cart_info['regular_price'], 2, '.', '');
					$price =number_format($cart_info['quantity']*$cart_info['price'], 2, '.', '');
					$discount_price = number_format(($price-$regular_price), 2, '.', '');  
					$total= number_format($total+$regular_price, 2, '.', '');
					$total_discount_price= number_format($total_discount_price+$discount_price, 2, '.', ''); 
				} 
				
			}
		}
		
		
		$output['status'] = $success; 
		if($msg){ $msg = strip_tags($msg); $msg = str_replace(array("\n", "\r"), '', $msg); $output['message']=$msg; }
		if($get_cart_info){ $output['cart_info']=$get_cart_info_array; }	
		if($quantity!=0){ $output['quantity']=(int)$quantity; }		
		if($total){ $output['total_price']=(float)$total; }		
		if($total){ $output['discount_price']=(float)$total_discount_price; }		
		echo json_encode($output);
		die();
	}
	
	
	public function updateCart() {
		$success = false; 
		$msg = ""; 
		$quantity = 0;
		
		$config = array(
			array(
    			'field' => 'customer_id',
    			'label' => 'Customer Id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'product_id',
    			'label' => 'Product',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'quantity',
    			'label' => 'Quantity',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$product_info = $this->product_mdl->get_product_by_product_id($_POST['product_id']);
		$customer_info = $this->register_mdl->get_customer_info($_POST['customer_id']);
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "Error: Product not found.\n";
		}else if (empty($customer_info)) {	
			 $msg =  "Error: Customer not found.\n";
		}else{
			
			$success='true';	
			$gallery_featured = $product_info['gallery_featured_mobile'];
			if($gallery_featured==""){
				$product_images = json_decode($product_info['product_images']);
				$gallery_featured = $product_images[0];
			} 
			$productImg=base_url('assets/uploads/product/'.$gallery_featured.'');
			
			
			$product_id = 	$product_info['product_id'];
			$quantity = 	$_POST['quantity'];
			$price_option = 	$_POST['price_option'];
			
			$price = $product_info['price'];
			$discount = '0';
			$discount_price = '0';
			$price_id = '0';
			
			if($price>0){
				$discount = $product_info['discount']; 
				$discount_price = $product_info['discount_price']; 
				$product_title = $product_info['product_name'];
			}else{ 
			
				if($price_option==""){
					$success ='false';
					$msg =  "Please select product option\n";
					
				}else{
					$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$product_info['product_id']."' and `price_id`='".$price_option."' order by price ";
					$query_price_option = $this->db->query($sql_price_option);
					$result_price_option = $query_price_option->result();
					$price = number_format((float)$result_price_option[0]->price, 2, '.', ''); 
					$discount = number_format((float)$result_price_option[0]->discount, 2, '.', '');
					$discount_price = number_format((float)$result_price_option[0]->discount_price, 2, '.', ''); 
					$price_option_name = $result_price_option[0]->name;	
					
					$price_id = (int)$result_price_option[0]->price_id;	
					
					$product_title = $product_info['product_name']." - ".$price_option_name;
					
					if($price_id==""){
						$success ='false';
						$msg =  "Please Select valid price option value.\n";
					
					}
					
				}
				
			}
			
			if($success !='false'){
			
				if($discount>0){
					$regular_price = $discount_price;
					$discount = $discount; 
				}else{
					$regular_price = $price;
					$discount = 0;
				}
				
				$car_data = array();
				
				
				$customer_id = (int)$_POST['customer_id'];
				$quantity = (int)$_POST['quantity']; 
				$product_id = (int)$product_info['product_id']; 
				$price_id =  $price_id;	
				
				$cart_info = $this->cart_mdl->update_cart_by_customer($customer_id,$product_id,$price_id,$quantity);
				$cart_info = array();
				$get_cart_info = $this->api_mdl->get_cart_info($_POST['customer_id']); 
				
				$quantity = 0;
				$total=0;	
				$total_discount_price=0;
				
				$get_cart_info_array = array();
				foreach($get_cart_info as $cart_info){

					$get_cart_info_array['cart_id'] = (int)$cart_info['cart_id'];	
					$get_cart_info_array['customer_id'] = (int)$cart_info['customer_id'];	
					$get_cart_info_array['product_id'] = (int)$cart_info['product_id'];	
					$get_cart_info_array['price_id'] = (int)$cart_info['price_id'];	
					$get_cart_info_array['product_title'] = $cart_info['product_title'];	
					
					$get_cart_info_array['price'] = number_format((float)$cart_info['price'], 2, '.', '');	
					$get_cart_info_array['regular_price'] = number_format((float)$cart_info['regular_price'], 2, '.', '');	
					$get_cart_info_array['discount'] = number_format((float)$cart_info['discount'], 2, '.', '');	
					
					$get_cart_info_array['quantity'] = (int)$cart_info['quantity'];
					$get_cart_info_array['date_added'] = $cart_info['date_added'];	
					
					$quantity = $quantity  + $cart_info['quantity'];			  
				  
					$regular_price = $cart_info['quantity']*$cart_info['regular_price'];
					$price =$cart_info['quantity']*$cart_info['price'];
					$discount_price = ($price-$regular_price);  
					$total= number_format($total+$regular_price, 2, '.', '');
					$total_discount_price= number_format($total_discount_price+$discount_price, 2, '.', ''); 
				} 
				
			}
		}
		
		
		$output['status'] = $success; 
		if($msg){ $msg = strip_tags($msg); $msg = str_replace(array("\n", "\r"), '', $msg); $output['message']=$msg; }
		if($get_cart_info){ $output['cart_info']=$get_cart_info_array; }	
		if($quantity!=0){ $output['quantity']=(int)$quantity; }		
		if($total){ $output['total_price']=number_format((float)$total, 2, '.', ''); }		
		if($total){ $output['discount_price']=number_format((float)$total_discount_price, 2, '.', ''); }		
		echo json_encode($output);
		die();
	}
	
	public function removeFromCart(){
		$success = false; 
		$msg = ""; 
		
		$config = array(
			array(
    			'field' => 'cart_id',
    			'label' => 'Cart id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'product_id',
    			'label' => 'Product id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'customer_id',
    			'label' => 'Customer id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$cart_id = $this->input->post('cart_id', TRUE);
		$product_id = $this->input->post('product_id', TRUE);
		$customer_id = $this->input->post('customer_id', TRUE);
		$product_info = $this->product_mdl->get_product_by_cart_id($cart_id);
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "Error: Product not found.\n";
		}else{
			$success='true';	
			$this->cart_mdl->remove_cart_by_customer($cart_id,$product_id,$customer_id);
		} 
		
		
		
		$output['status'] = $success; 
		if($msg){ $msg = strip_tags($msg); $msg = str_replace(array("\n", "\r"), '', $msg); $output['message']=$msg;  }
		echo json_encode($output);
		die();
	}
	
	public function getCart(){
		$success = false; 
		$msg = ""; 
		
		$config = array(
			
			array(
    			'field' => 'customer_id',
    			'label' => 'Customer id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$customer_info = $this->register_mdl->get_customer_info($_POST['customer_id']);
		
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE) { 
			$success ='false';
			$msg =  validation_errors(); 
		}else if (empty($customer_info)) {	
			 $msg =  "Error: Customer not found.\n";	 
		}else{ 
			
			$success = true;
			$cart_info = array();
			$get_cart_info = $this->api_mdl->get_cart_info($_POST['customer_id']); 
			
			$quantity = 0;
			$total=0;	
			$total_discount_price=0;
			$get_cart_info_array = array();
			
			foreach($get_cart_info as $cart_info){	
			
				$get_cart_info_array_data['cart_id'] = (int)$cart_info['cart_id'];	
				$get_cart_info_array_data['customer_id'] = (int)$cart_info['customer_id'];	
				$get_cart_info_array_data['product_id'] = (int)$cart_info['product_id'];	
				$get_cart_info_array_data['price_id'] = (int)$cart_info['price_id'];	
				$get_cart_info_array_data['product_title'] = $cart_info['product_title'];	
				
				$get_cart_info_array_data['price'] = number_format((float)$cart_info['price'], 2, '.', '');	
				$get_cart_info_array_data['regular_price'] = number_format((float)$cart_info['regular_price'], 2, '.', '');	
				$get_cart_info_array_data['discount'] = number_format((float)$cart_info['discount'], 2, '.', '');	
				
				$get_cart_info_array_data['quantity'] = (int)$cart_info['quantity'];
				$get_cart_info_array_data['date_added'] = $cart_info['date_added'];	
				
				/**/
				$product_id = $cart_info['product_id'];	
				$product_info = $this->product_mdl->get_product_by_product_id($product_id);
				$categories = $product_info['product_category'];	
				$category_data = array();
				if($categories){
					$category_info = $this->product_mdl->get_categories_list_in($categories);
					$category_data['category_id'] = $category_info[0]['category_id'];
					$category_data['category_name'] = $category_info[0]['category_name'];
					if($category_info[0]['category_image']){
					$category_data['category_image'] = base_url('assets/uploads/category/')."".$category_info[0]['category_image'];
					}else{
					$category_data['category_image'] = "";	
					}
				}
				$get_cart_info_array_data['category_info'] = $category_data;
				
				
				$gallery_featured = $product_info['gallery_featured_mobile'];
				if($gallery_featured==""){
					$product_images = json_decode($product_info['product_images']);
					$gallery_featured = $product_images[0];
				} 
				$productImg=base_url('assets/uploads/product/'.$gallery_featured.'');
				$get_cart_info_array_data['productImg'] = $productImg;
				
				/**/
				
				
				/**/
				$price_id = $get_cart_info_array_data['price_id'];
				
				$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$cart_info['product_id']."' and `price_id`='".$price_id."' order by price ";
				$query_price_option = $this->db->query($sql_price_option);
				$result_price_option = $query_price_option->result();
				
				
				$price_option_data = array();
				
				$price_option_data['price_id'] = (int)0;
				$price_option_data['name'] = NULL;
				
				if($result_price_option){
					
					$name = $result_price_option[0]->name; 
					$price = number_format((float)$result_price_option[0]->price, 2, '.', ''); 
					$discount = number_format((float)$result_price_option[0]->discount, 2, '.', '');
					$discount_price = number_format((float)$result_price_option[0]->discount_price, 2, '.', ''); 
					$price_option_name =  $result_price_option[0]->name;	
					
					$price_id =  $result_price_option[0]->price_id;
					
					$price_option_data['price_id'] = $price_id;
					$price_option_data['name'] = $name;
					
				}
				$get_cart_info_array_data['price_option'] = $price_option_data;
				/**/
				
				
				
				
			
				$get_cart_info_array[] = $get_cart_info_array_data;
			
				$quantity = $quantity  + $cart_info['quantity'];			  
			  
				$regular_price = $cart_info['quantity']*$cart_info['regular_price'];
				$price =$cart_info['quantity']*$cart_info['price'];
				$discount_price = ($price-$regular_price);  
				$total= $total+$regular_price;
				$total_discount_price= $total_discount_price+$discount_price; 
			} 
		}
		
		$output['status'] = $success; 
		if($msg){ $msg = strip_tags($msg); $msg = str_replace(array("\n", "\r"), '', $msg); $output['message']=$msg;  }
		if($get_cart_info){ $output['cart_info']=$get_cart_info_array; }	
		if($quantity!=0){ $output['quantity']=(int)$quantity; }		
		if($total){ $output['total_price']=number_format((float)$total, 2, '.', ''); }		
		if($total){ $output['discount_price']=number_format((float)$total_discount_price, 2, '.', ''); }	
		
		echo json_encode($output);
		die();
	}
	

	
	/*cart*/


	
	/*Wishlist*/
public function addToWishlist() {
		$success = false; 
		$msg = ""; 
		$quantity = 0;
		
		$config = array(
			array(
    			'field' => 'customer_id',
    			'label' => 'Customer Id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'product_id',
    			'label' => 'Product',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'quantity',
    			'label' => 'Quantity',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$product_info = $this->product_mdl->get_product_by_product_id($_POST['product_id']);
		$customer_info = $this->register_mdl->get_customer_info($_POST['customer_id']);
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "Error: Product not found.\n";
		}else if (empty($customer_info)) {	
			 $msg =  "Error: Customer not found.\n";
		}else{
			
			$success='true';	
			$gallery_featured = $product_info['gallery_featured_mobile'];
			if($gallery_featured==""){
				$product_images = json_decode($product_info['product_images']);
				$gallery_featured = $product_images[0];
			} 
			$productImg=base_url('assets/uploads/product/'.$gallery_featured.'');
			
			
			$product_id = 	$product_info['product_id'];
			$quantity = 	$_POST['quantity'];
			$price_option = 	$_POST['price_option'];
			
			$price = $product_info['price'];
			$discount = '0';
			$discount_price = '0';
			$price_id = '0';
			
			if($price>0){
				$discount = $product_info['discount']; 
				$discount_price = $product_info['discount_price']; 
				$product_title = $product_info['product_name'];
			}else{ 
			
				if($price_option==""){
					$success ='false';
					$msg =  "Please select product option\n";
					
				}else{
					$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$product_info['product_id']."' and `price_id`='".$price_option."' order by price ";
					$query_price_option = $this->db->query($sql_price_option);
					$result_price_option = $query_price_option->result();
					$price = number_format((float)$result_price_option[0]->price, 2, '.', ''); 
					$discount = number_format((float)$result_price_option[0]->discount, 2, '.', '');
					$discount_price = number_format((float)$result_price_option[0]->discount_price, 2, '.', ''); 
					$price_option_name =  $result_price_option[0]->name;	
					
					$price_id = (int)$result_price_option[0]->price_id;	
					
					$product_title = $product_info['product_name']." - ".$price_option_name;
					
					if($price_id==""){
						$success ='false';
						$msg =  "Please Select valid price option value.\n";
					
					}
					
				}
				
			}
			
			if($success !='false'){
			
				if($discount>0){
					$regular_price = $discount_price;
					$discount = $discount; 
				}else{
					$regular_price = $price;
					$discount = 0;
				}
				
				$car_data = array();
				
				
				$car_data['customer_id'] = (int)$_POST['customer_id'];
				$car_data['quantity'] = (int)$_POST['quantity']; 
				$car_data['product_id'] = (int)$product_info['product_id']; 
				$car_data['price_id'] =  (int)$price_id;			
				$car_data['product_title'] = $product_title;
				$car_data['price'] = number_format((float)$price, 2, '.', '');
				$car_data['regular_price'] = number_format((float)$regular_price, 2, '.', '');
				$car_data['discount'] = number_format((float)$discount, 2, '.', '');
				
				$wishlist_info = $this->wishlist_mdl->store_wishlist($car_data);
				$wishlist_info = array();
				$get_wishlist_info = $this->api_mdl->get_wishlist_info($_POST['customer_id']); 
				
				$quantity = 0;
				$total=0;	
				$total_discount_price=0;
				
				$get_wishlist_info_array = array();

				foreach($get_wishlist_info as $wishlist_info){	
					
					$get_wishlist_info_array['wishlist_id'] = (int)$wishlist_info['wishlist_id'];	
					$get_wishlist_info_array['customer_id'] = (int)$wishlist_info['customer_id'];	
					$get_wishlist_info_array['product_id'] = (int)$wishlist_info['product_id'];	
					$get_wishlist_info_array['price_id'] = (int)$wishlist_info['price_id'];	
					$get_wishlist_info_array['product_title'] = $wishlist_info['product_title'];	
					
					$get_wishlist_info_array['price'] = number_format((float)$wishlist_info['price'], 2, '.', '');	
					$get_wishlist_info_array['regular_price'] = number_format((float)$wishlist_info['regular_price'], 2, '.', '');	
					$get_wishlist_info_array['discount'] = number_format((float)$wishlist_info['discount'], 2, '.', '');	
					
					$get_wishlist_info_array['quantity'] = (int)$wishlist_info['quantity'];
					$get_wishlist_info_array['date_added'] = $wishlist_info['date_added'];	
				
				
					$quantity = $quantity  + $wishlist_info['quantity'];			  
				  
					$regular_price = number_format($wishlist_info['quantity']*$wishlist_info['regular_price'], 2, '.', '');
					$price =number_format($wishlist_info['quantity']*$wishlist_info['price'], 2, '.', '');
					$discount_price = number_format(($price-$regular_price), 2, '.', '');  
					$total= number_format($total+$regular_price, 2, '.', '');
					$total_discount_price= number_format($total_discount_price+$discount_price, 2, '.', ''); 
				} 
				
			}
		}
		
		
		$output['status'] = $success; 
		if($msg){ $msg = strip_tags($msg); $msg = str_replace(array("\n", "\r"), '', $msg); $output['message']=$msg; }
		if($get_wishlist_info){ $output['wishlist_info']=$get_wishlist_info_array; }	
		if($quantity!=0){ $output['quantity']=(int)$quantity; }		
		if($total){ $output['total_price']=(float)$total; }		
		if($total){ $output['discount_price']=(float)$total_discount_price; }		
		echo json_encode($output);
		die();
	}
	
	
	public function updateWishlist() {
		$success = false; 
		$msg = ""; 
		$quantity = 0;
		
		$config = array(
			array(
    			'field' => 'customer_id',
    			'label' => 'Customer Id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'product_id',
    			'label' => 'Product',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'quantity',
    			'label' => 'Quantity',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$product_info = $this->product_mdl->get_product_by_product_id($_POST['product_id']);
		$customer_info = $this->register_mdl->get_customer_info($_POST['customer_id']);
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "Error: Product not found.\n";
		}else if (empty($customer_info)) {	
			 $msg =  "Error: Customer not found.\n";
		}else{
			
			$success='true';	
			$gallery_featured = $product_info['gallery_featured_mobile'];
			if($gallery_featured==""){
				$product_images = json_decode($product_info['product_images']);
				$gallery_featured = $product_images[0];
			} 
			$productImg=base_url('assets/uploads/product/'.$gallery_featured.'');
			
			
			$product_id = 	$product_info['product_id'];
			$quantity = 	$_POST['quantity'];
			$price_option = 	$_POST['price_option'];
			
			$price = $product_info['price'];
			$discount = '0';
			$discount_price = '0';
			$price_id = '0';
			
			if($price>0){
				$discount = $product_info['discount']; 
				$discount_price = $product_info['discount_price']; 
				$product_title = $product_info['product_name'];
			}else{ 
			
				if($price_option==""){
					$success ='false';
					$msg =  "Please select product option\n";
					
				}else{
					$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$product_info['product_id']."' and `price_id`='".$price_option."' order by price ";
					$query_price_option = $this->db->query($sql_price_option);
					$result_price_option = $query_price_option->result();
					$price = number_format((float)$result_price_option[0]->price, 2, '.', ''); 
					$discount = number_format((float)$result_price_option[0]->discount, 2, '.', '');
					$discount_price = number_format((float)$result_price_option[0]->discount_price, 2, '.', ''); 
					$price_option_name = $result_price_option[0]->name;	
					
					$price_id = (int)$result_price_option[0]->price_id;	
					
					$product_title = $product_info['product_name']." - ".$price_option_name;
					
					if($price_id==""){
						$success ='false';
						$msg =  "Please Select valid price option value.\n";
					
					}
					
				}
				
			}
			
			if($success !='false'){
			
				if($discount>0){
					$regular_price = $discount_price;
					$discount = $discount; 
				}else{
					$regular_price = $price;
					$discount = 0;
				}
				
				$car_data = array();
				
				
				$customer_id = (int)$_POST['customer_id'];
				$quantity = (int)$_POST['quantity']; 
				$product_id = (int)$product_info['product_id']; 
				$price_id =  $price_id;	
				
				$wishlist_info = $this->wishlist_mdl->update_wishlist_by_customer($customer_id,$product_id,$price_id,$quantity);
				$wishlist_info = array();
				$get_wishlist_info = $this->api_mdl->get_wishlist_info($_POST['customer_id']); 
				
				$quantity = 0;
				$total=0;	
				$total_discount_price=0;
				
				$get_wishlist_info_array = array();
				foreach($get_wishlist_info as $wishlist_info){

					$get_wishlist_info_array['wishlist_id'] = (int)$wishlist_info['wishlist_id'];	
					$get_wishlist_info_array['customer_id'] = (int)$wishlist_info['customer_id'];	
					$get_wishlist_info_array['product_id'] = (int)$wishlist_info['product_id'];	
					$get_wishlist_info_array['price_id'] = (int)$wishlist_info['price_id'];	
					$get_wishlist_info_array['product_title'] = $wishlist_info['product_title'];	
					
					$get_wishlist_info_array['price'] = number_format((float)$wishlist_info['price'], 2, '.', '');	
					$get_wishlist_info_array['regular_price'] = number_format((float)$wishlist_info['regular_price'], 2, '.', '');	
					$get_wishlist_info_array['discount'] = number_format((float)$wishlist_info['discount'], 2, '.', '');	
					
					$get_wishlist_info_array['quantity'] = (int)$wishlist_info['quantity'];
					$get_wishlist_info_array['date_added'] = $wishlist_info['date_added'];	
					
					$quantity = $quantity  + $wishlist_info['quantity'];			  
				  
					$regular_price = $wishlist_info['quantity']*$wishlist_info['regular_price'];
					$price =$wishlist_info['quantity']*$wishlist_info['price'];
					$discount_price = ($price-$regular_price);  
					$total= number_format($total+$regular_price, 2, '.', '');
					$total_discount_price= number_format($total_discount_price+$discount_price, 2, '.', ''); 
				} 
				
			}
		}
		
		
		$output['status'] = $success; 
		if($msg){ $msg = strip_tags($msg); $msg = str_replace(array("\n", "\r"), '', $msg); $output['message']=$msg; }
		if($get_wishlist_info){ $output['wishlist_info']=$get_wishlist_info_array; }	
		if($quantity!=0){ $output['quantity']=(int)$quantity; }		
		if($total){ $output['total_price']=number_format((float)$total, 2, '.', ''); }		
		if($total){ $output['discount_price']=number_format((float)$total_discount_price, 2, '.', ''); }		
		echo json_encode($output);
		die();
	}
	
	public function removeFromWishlist(){
		$success = false; 
		$msg = ""; 
		
		$config = array(
			array(
    			'field' => 'wishlist_id',
    			'label' => 'Wishlist id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'product_id',
    			'label' => 'Product id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
			array(
    			'field' => 'customer_id',
    			'label' => 'Customer id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$wishlist_id = $this->input->post('wishlist_id', TRUE);
		$product_id = $this->input->post('product_id', TRUE);
		$customer_id = $this->input->post('customer_id', TRUE);
		$product_info = $this->product_mdl->get_product_by_wishlist_id($wishlist_id);
		
		$this->form_validation->set_rules($config);
    	if ($this->form_validation->run() == FALSE) {
			 $success ='false';
			 $msg =  validation_errors();
		}else if (empty($product_info)) {	
			 $msg =  "Error: Product not found.\n";
		}else{
			$success='true';	
			$this->wishlist_mdl->remove_wishlist_by_customer($wishlist_id,$product_id,$customer_id);
		} 
		
		
		
		$output['status'] = $success; 
		if($msg){ $msg = strip_tags($msg); $msg = str_replace(array("\n", "\r"), '', $msg); $output['message']=$msg;  }
		echo json_encode($output);
		die();
	}
	
	public function getWishlist(){
		$success = false; 
		$msg = ""; 
		
		$config = array(
			
			array(
    			'field' => 'customer_id',
    			'label' => 'Customer id',
    			'rules' => 'trim|required|max_length[250]',
				
    		),
    	);
		
		$customer_info = $this->register_mdl->get_customer_info($_POST['customer_id']);
		
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE) { 
			$success ='false';
			$msg =  validation_errors(); 
		}else if (empty($customer_info)) {	
			 $msg =  "Error: Customer not found.\n";	 
		}else{ 
			
			$success = true;
			$wishlist_info = array();
			$get_wishlist_info = $this->api_mdl->get_wishlist_info($_POST['customer_id']); 
			
			$quantity = 0;
			$total=0;	
			$total_discount_price=0;
			$get_wishlist_info_array = array();
			
			foreach($get_wishlist_info as $wishlist_info){	
			
				$get_wishlist_info_array_data['wishlist_id'] = (int)$wishlist_info['wishlist_id'];	
				$get_wishlist_info_array_data['customer_id'] = (int)$wishlist_info['customer_id'];	
				$get_wishlist_info_array_data['product_id'] = (int)$wishlist_info['product_id'];	
				$get_wishlist_info_array_data['price_id'] = (int)$wishlist_info['price_id'];	
				$get_wishlist_info_array_data['product_title'] = $wishlist_info['product_title'];	
				
				$get_wishlist_info_array_data['price'] = number_format((float)$wishlist_info['price'], 2, '.', '');	
				$get_wishlist_info_array_data['regular_price'] = number_format((float)$wishlist_info['regular_price'], 2, '.', '');	
				$get_wishlist_info_array_data['discount'] = number_format((float)$wishlist_info['discount'], 2, '.', '');	
				
				$get_wishlist_info_array_data['quantity'] = (int)$wishlist_info['quantity'];
				$get_wishlist_info_array_data['date_added'] = $wishlist_info['date_added'];	
				
				/**/
				$product_id = $wishlist_info['product_id'];	
				$product_info = $this->product_mdl->get_product_by_product_id($product_id);
				$categories = $product_info['product_category'];	
				$category_data = array();
				if($categories){
					$category_info = $this->product_mdl->get_categories_list_in($categories);
					$category_data['category_id'] = $category_info[0]['category_id'];
					$category_data['category_name'] = $category_info[0]['category_name'];
					if($category_info[0]['category_image']){
					$category_data['category_image'] = base_url('assets/uploads/category/')."".$category_info[0]['category_image'];
					}else{
					$category_data['category_image'] = "";	
					}
				}
				$get_wishlist_info_array_data['category_info'] = $category_data;
				
				
				$gallery_featured = $product_info['gallery_featured_mobile'];
				if($gallery_featured==""){
					$product_images = json_decode($product_info['product_images']);
					$gallery_featured = $product_images[0];
				} 
				$productImg=base_url('assets/uploads/product/'.$gallery_featured.'');
				$get_wishlist_info_array_data['productImg'] = $productImg;
				
				/**/
				
				
				/**/
				$price_id = $get_wishlist_info_array_data['price_id'];
				
				$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$wishlist_info['product_id']."' and `price_id`='".$price_id."' order by price ";
				$query_price_option = $this->db->query($sql_price_option);
				$result_price_option = $query_price_option->result();
				
				
				$price_option_data = array();
				
				$price_option_data['price_id'] = (int)0;
				$price_option_data['name'] = NULL;
				
				if($result_price_option){
					
					$name = $result_price_option[0]->name; 
					$price = number_format((float)$result_price_option[0]->price, 2, '.', ''); 
					$discount = number_format((float)$result_price_option[0]->discount, 2, '.', '');
					$discount_price = number_format((float)$result_price_option[0]->discount_price, 2, '.', ''); 
					$price_option_name =  $result_price_option[0]->name;	
					
					$price_id =  $result_price_option[0]->price_id;
					
					$price_option_data['price_id'] = $price_id;
					$price_option_data['name'] = $name;
					
				}
				$get_wishlist_info_array_data['price_option'] = $price_option_data;
				/**/
				
				
				
				
			
				$get_wishlist_info_array[] = $get_wishlist_info_array_data;
			
				$quantity = $quantity  + $wishlist_info['quantity'];			  
			  
				$regular_price = $wishlist_info['quantity']*$wishlist_info['regular_price'];
				$price =$wishlist_info['quantity']*$wishlist_info['price'];
				$discount_price = ($price-$regular_price);  
				$total= $total+$regular_price;
				$total_discount_price= $total_discount_price+$discount_price; 
			} 
		}
		
		$output['status'] = $success; 
		if($msg){ $msg = strip_tags($msg); $msg = str_replace(array("\n", "\r"), '', $msg); $output['message']=$msg;  }
		if($get_wishlist_info){ $output['wishlist_info']=$get_wishlist_info_array; }	
		if($quantity!=0){ $output['quantity']=(int)$quantity; }		
		if($total){ $output['total_price']=number_format((float)$total, 2, '.', ''); }		
		if($total){ $output['discount_price']=number_format((float)$total_discount_price, 2, '.', ''); }	
		
		echo json_encode($output);
		die();
	}	
 
	/*wishlist*/
	

	public function getAllOrder(){
		$success = false; 
		$msg = ""; 
		
		$config = array(
			
			/* array(
    			'field' => 'customer_id',
    			'label' => 'Customer id',
    			'rules' => 'trim|required|max_length[250]',
				
    		), 
			*/
    	);
		
		if($_POST['customer_id']){ 
		$customer_info = $this->register_mdl->get_customer_info($_POST['customer_id']);
		$msg = "Error: Customer not found.\n";
		}else if($_POST['delivery_id']){ 
		$customer_info = $this->register_mdl->get_delivery_info($_POST['delivery_id']);
		$msg = "Error: Delivery user not found.\n";
		}else if($_POST['outlet_id']){ 
		$customer_info = $this->register_mdl->get_outlet_info($_POST['outlet_id']);
		$msg = "Error: Outlet  not found.\n";
		}
		
		$this->form_validation->set_rules($config);
		
		/* if ($this->form_validation->run() == FALSE) { 
			$success ='false';
			$msg =  validation_errors(); 
		}else  */
		
		if (empty($customer_info)) {	
			 $msg =  $msg;	 
		}else{ 
				$msg = ""; 
				$success = true;
				$order_info = array();
				if($_POST['customer_id']){
				 $get_order_info = $this->api_mdl->get_order_info($_POST['customer_id']); 
				}
				
				if($_POST['delivery_id']){
				 $get_order_info = $this->api_mdl->get_order_delivery_info($_POST['delivery_id']); 
				}
				
				if($_POST['outlet_id']){
				 $get_order_info = $this->api_mdl->get_order_outlet_info($_POST['outlet_id']); 
				}
				
				foreach($get_order_info as $orderinfo){	
					
					unset($orderinfo['last_updated']);
					unset($orderinfo['deletion_status']);
					unset($orderinfo['razorpay_payment_id']);
					
					
					$orderinfo['order_id'] = (int)$orderinfo['order_id'];	
					$orderinfo['customer_id'] = (int)$orderinfo['customer_id'];	
					$orderinfo['shipping_id'] = (int)$orderinfo['shipping_id'];	
					$orderinfo['outlet_id'] = (int)$orderinfo['outlet_id'];	
					$orderinfo['delivery_id'] = (int)$orderinfo['delivery_id'];	
					
					$orderinfo['amount'] = number_format((float)$orderinfo['amount'], 2, '.', '');	
					$orderinfo['discount'] = number_format((float)$orderinfo['discount'], 2, '.', '');	
					$orderinfo['delivery_charge'] = (float)$orderinfo['delivery_charge'];


					$order_product = $this->api_mdl->get_order_product_by_customer_order_id($orderinfo['customer_id'],$orderinfo['order_id']); 
					$order_product_array = array();
					foreach($order_product as $order_product_v){
						
						
						$orderinfo['order_product_id'] = (int)$orderinfo['order_product_id'];	
						$orderinfo['customer_id'] = (int)$orderinfo['customer_id'];	
						$orderinfo['order_id'] = (int)$orderinfo['order_id'];	
						$orderinfo['product_id'] = (int)$orderinfo['product_id'];	
						$orderinfo['price_id'] = (int)$orderinfo['price_id'];	
						$orderinfo['quantity'] = (int)$orderinfo['quantity'];	
						
						$order_product_v['price'] = number_format((float)$order_product_v['price'], 2, '.', '');	
						$order_product_v['regular_price'] = number_format((float)$order_product_v['regular_price'], 2, '.', '');	
						$order_product_v['discount'] = number_format((float)$order_product_v['discount'], 2, '.', '');	
						
						$order_product_array[] = $order_product_v;
						
					}
					$orderinfo['order_product'] = $order_product;	
					
					$order_info[] = $orderinfo;
				} 
		
		}
		
			
		
		$output['status'] = $success; 
		if($msg){ $msg = strip_tags($msg); $msg = str_replace(array("\n", "\r"), '', $msg); $output['message']=$msg;  }
		if($order_info){ $output['order_info']=$order_info; }	 
		echo json_encode($output);
		die();		
	}
	
	public function getBrandFilter() {
		
		$seo_url = $this->input->post('category_id', TRUE);
		
		$success = true; 
		
		$category_info = $this->product_mdl->get_category_by_id($seo_url);
		$parent_cat = $this->product_mdl->get_parent_category_by_id($category_info['category_id']);
		
		$filter_brand = ""; 
		if(empty($category_info['filter_brand'])  and (!empty($parent_cat)) ){
			 $category_info_parent = $this->product_mdl->get_category_by_id($parent_cat);
			 $filter_brand=$category_info_parent['filter_brand'];
		}else if(!empty($category_info['filter_brand'])){	
			$filter_brand=$category_info['filter_brand'];
		}
		
		 if(!empty($filter_brand)){
		$brand_list = $this->product_mdl->get_brand_list_in($filter_brand); 
		}else{
		$brand_list = $this->product_mdl->get_brand_list($filter_brand); 
		}
	
		$brand_list_array= array();
		foreach($brand_list as $v_brand_list){
			
			$v_brand_list['brand_id'] = (int)$v_brand_list['brand_id'];
			unset($v_brand_list['deletion_status']);
			unset($v_brand_list['publication_status']);
			
			$brand_list_array[] = $v_brand_list;
		}
		
		
		$output['status'] = $success; 
		$output['data'] = $brand_list_array; 
		echo json_encode($output);
		die();	
	}
	
	
	/*getProduct*/
	
	public function getProducts(){
	
		$success = false; 
		$msg = ""; 
		
		
		
		$search = array();
		$search['category_id'] =  $this->input->post('category_id', TRUE);
		$search['brand_search'] =  $this->input->post('brand_search', TRUE);
		$search['price_search'] =  $this->input->post('price_search', TRUE);
		$search['discount_search'] =  $this->input->post('discount_search', TRUE);
		$search['orderby'] =  $this->input->post('orderby', TRUE); 	
		
		
		$search['s'] ='';
		if($_REQUEST['s']!=""){
			$search['s'] = $_REQUEST['s'];
		}
		$data['search'] = $search;
		
		if($_REQUEST['t']=="offer"){
			$search['t'] = 'offer';
		}
		
		
		
		file_put_contents('product_data.txt',print_r( $search ,true));
		
		
		$currentpage = $this->input->post('currentpage', TRUE);
		
		$product_list = $this->product_mdl->get_filter_products($search,$currentpage);	
		$product_count = $this->product_mdl->get_filter_products_count($search);
		
		$products = array();
		if($product_list){
			
			$success = true;   
			foreach($product_list as $v_result){
				unset($v_result['deletion_status']);
				
				
				/* $v_categories['category_id'] = (int)$v_categories['category_id']; */ 
				/* unset($v_categories['publication_status']); */
				
				$v_result['product_id'] = (int)$v_result['product_id']; 
				$v_result['user_id'] = (int)$v_result['user_id']; 
				$v_result['brand_id'] = (int)$v_result['brand_id']; 
				
				$brand_data =$this->api_mdl->get_brand_by_brand_id($v_result['brand_id']);
				if($brand_data){
					$v_result['brand_data']['brand_id'] = (int)$brand_data['brand_id'];
					$v_result['brand_data']['brand_name'] = $brand_data['brand_name'];
				}
				
				
				$v_result['price'] = number_format((float)$v_result['price'], 2, '.', ''); 
				$v_result['discount'] = number_format((float)$v_result['discount'], 2, '.', ''); 
				$v_result['discount_price'] = number_format((float)$v_result['discount_price'], 2, '.', ''); 
				$product_images = json_decode($v_result['product_images']); 
				
				if($v_result['gallery_featured_mobile']){
				$v_result['gallery_featured'] = base_url('assets/uploads/product/').$v_result['gallery_featured_mobile']; 
				}
				
				$product_images_array =  array();
				foreach($product_images as $v_product_images){
					$product_images_array[] = base_url('assets/uploads/product/').$v_product_images;
				}
				$v_result['product_images'] = $product_images_array;

				
				/*attribute*/
				$product_attribute = $this->product_mdl->get_dir_product_attribute($v_result['product_id']); 
				$product_attribute_array = array();
				foreach($product_attribute as $attribute){
					
					if($attribute['attribute_name']!="" and $attribute['product_attribute_description']!=""){
						$_product_attribute_array['attribute_name'] = $attribute['attribute_name'];
						$_product_attribute_array['sorting'] = (int)$attribute['sorting'];
						$_product_attribute_array['product_attribute_description'] = $attribute['product_attribute_description'];
						$product_attribute_array[] = $_product_attribute_array; 
					}
				}		
				$v_result['product_attribute'] = $product_attribute_array;
				/*attribute*/
				
				/*price option*/
				$price_option_array = array();
				$sql_price_option ="SELECT * FROM dir_product_price_option where `product_id`='".$v_result['product_id']."' order by price ";
				$query_price_option = $this->db->query($sql_price_option);
				$result_price_option = $query_price_option->result();
				foreach($result_price_option as $v_result_price_option){
					
					
					$_price_option_array['price_id'] = (int)$v_result_price_option->price_id;
					$_price_option_array['product_id'] = (int)$v_result_price_option->product_id;
					$_price_option_array['name'] = $v_result_price_option->name;
					$_price_option_array['sorting'] = (int)$v_result_price_option->sorting;
					
					$_price_option_array['price'] = number_format((float)$v_result_price_option->price, 2, '.', '');
					$_price_option_array['discount'] = number_format((float)$v_result_price_option->discount, 2, '.', '');
					$_price_option_array['discount_price'] = number_format((float)$v_result_price_option->discount_price, 2, '.', '');
					
					$price_option_array[] = $_price_option_array; 
				} 
				$v_result['price_option'] = $price_option_array; 
				/*price option*/ 
				 
				 /* reatils price */
				 $v_result['wholesale_price'] = [];
				 if($v_result['is_whole_sale'])
				 {
				 	 $sql_retails_price_option ="SELECT * FROM dir_product_wholesale where `product_id`='".$v_result['product_id']."'";

				$query_retails_price_option = $this->db->query($sql_retails_price_option);
				$result_retails_price_option = $query_retails_price_option->row_array();
					if( $result_retails_price_option && count($result_retails_price_option) ) {
						 $wholesaleArr =	isphpupdate()
											 ? (array)json_decode($result_retails_price_option['wholesale_price'])
											: (array)json_decode($result_retails_price_option['wholesale_price'], true);
							usort($wholesaleArr, function ($a, $b) {
										return $a->price - $b->price;
									});
							$v_result['wholesale_price'] = $wholesaleArr ;  
					}		
				 }
				$products[] = $v_result; 
			}
	 
		}
		
		
		
		$output['status'] = $success; 
		$output['product_list'] = $products; 
		$output['product_count'] = $product_count; 
		echo json_encode($output);
		die();	
	}
	
	
	
	
	public function send_verify_number($phone,$verify_number) {
	
		/* file_put_contents('verify_number.txt',print_r($verify_number,true));
		 */
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
	
	
	
	
	/*shipping*/
	
	public function getAllShippingAddress() {
		
		$msg = "";  
		$response="";
		
		$config = array(
				array(
					'field' => 'customer_id',
					'label' => 'Customer Id',
					'rules' => 'trim|required'
				),  
			);
			
			$customer_info = $this->register_mdl->get_customer_info($_POST['customer_id']);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {								
				$success ='false';
				$msg =  validation_errors();	
			}else if (empty($customer_info)) {
				
			   $success ='false';	
			   $msg =  "Error: Customer not found.\n";
			 
			}else{ 
				
				$success ='true';
				$customer_id = $_POST['customer_id']; 
				
				$response = array();
				$shipping_address_info = $this->register_mdl->get_shipping_address_info($customer_id);
				foreach($shipping_address_info as $v_result){
					
					$v_result['shipping_id'] = (int)$v_result['shipping_id']; 
					$v_result['customer_id'] = (int)$v_result['customer_id']; 
					
					unset($v_result['deletion_status']);
					
					$response[] = $v_result;
				}
				
			}
		
		
		
		
		$output['status'] = $success; 
		if($msg!=""){ 
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; 
		}
		$output['response'] = $response; 
		echo json_encode($output); 
		die(); 
	}
	
	
	
	public function getShippingDetails() {
		
		$msg = "";  
		$response="";
		
		$config = array(
				array(
					'field' => 'customer_id',
					'label' => 'Customer Id',
					'rules' => 'trim|required'
				),  
				array(
					'field' => 'shipping_id',
					'label' => 'Shipping Id',
					'rules' => 'trim|required'
				),
			);
			 $customer_id= $_POST['customer_id'];
			 $shipping_id= $_POST['shipping_id'];
			 $shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {								
				
				$success ='false';
				$msg =  validation_errors();	
				
			}else if(empty($shipping_info)) {
				
				$success ='false';
				$msg =  "Error: Shipping address not found.\n";
			 
			}else{ 
			
				$success ='true';
				
				$shipping_info['shipping_id']= (int)$shipping_info['shipping_id'];
				$shipping_info['customer_id']= (int)$shipping_info['customer_id'];
				unset($shipping_info['deletion_status']);
				
				$response = $shipping_info;
				
			}
			
		
		
		$output['status'] = $success; 
		if($msg!=""){ 
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; 
		}
		$output['response'] = $response; 
		echo json_encode($output); 
		die(); 
	}
	
	public function UpdateShippingDetails() {
		$msg = "";  
		$response="";
		
		$config = array(
				array(
					'field' => 'customer_id',
					'label' => 'Customer Id',
					'rules' => 'trim|required'
				),  
				array(
					'field' => 'shipping_id',
					'label' => 'Shipping Id',
					'rules' => 'trim|required'
				),
				
				array(
					'field' => 'firstname',
					'label' => 'First name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastname',
					'label' => 'Last name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email'
				),
				array(
					'field' => 'address',
					'label' => 'Address',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'city',
					'label' => 'City',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'postcode',
					'label' => 'Postcode',
					'rules' => 'trim|required'
				),
			);
			
			 $customer_id= $_POST['customer_id'];
			 $shipping_id= $_POST['shipping_id'];
			 $shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {	 
				$success ='false';
				$msg =  validation_errors();	 
			}else if(empty($shipping_info)) { 
				$success ='false';
				$msg =  "Error: Shipping address not found.\n"; 
			}else{  
				$success ='true';
				
				$data['firstname'] = $this->input->post('firstname', TRUE); 
				$data['lastname'] = $this->input->post('lastname', TRUE); 
				$data['email'] = $this->input->post('email', TRUE); 
				$data['address'] = $this->input->post('address', TRUE); 
				$data['city'] = $this->input->post('city', TRUE); 
				$data['postcode'] = $this->input->post('postcode', TRUE);  
				$data['last_updated'] = date('Y-m-d H:i:s'); 
				
				$result = $this->register_mdl->update_shipping_info($shipping_id, $data); 	
				
				if (!empty($result)) {
					$msg = 'Update successfully .';   
				} else {
					$msg = 'Operation failed !'; 
				}
			
			}
			
			
		$output['status'] = $success; 
		if($msg!=""){ 
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; 
		}
		echo json_encode($output); 
		die(); 
	}
	
	
	public function AddShippingDetails() {
		$msg = "";  
		$response="";
		
		$config = array(
				array(
					'field' => 'customer_id',
					'label' => 'Customer Id',
					'rules' => 'trim|required'
				),  
				
				
				array(
					'field' => 'firstname',
					'label' => 'First name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastname',
					'label' => 'Last name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|valid_email'
				),
				array(
					'field' => 'address',
					'label' => 'Address',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'city',
					'label' => 'City',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'postcode',
					'label' => 'Postcode',
					'rules' => 'trim|required'
				),
			);
			
			 $customer_id= $_POST['customer_id'];

			 $customer_info = $this->register_mdl->get_customer_info($customer_id);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {	 
				$success ='false';
				$msg =  validation_errors();	 
			}else if(empty($customer_info)) { 
				$success ='false';
				$msg =  "Error: Customer address not found.\n"; 
			}else{  
			
				$success ='true';
				
				$data['customer_id'] = $this->input->post('customer_id', TRUE);
				$data['firstname'] = $this->input->post('firstname', TRUE); 
				$data['lastname'] = $this->input->post('lastname', TRUE); 
				$data['email'] = $this->input->post('email', TRUE); 
				$data['address'] = $this->input->post('address', TRUE); 
				$data['city'] = $this->input->post('city', TRUE); 
				$data['postcode'] = $this->input->post('postcode', TRUE);  
				$data['last_updated'] = date('Y-m-d H:i:s'); 
				
				$result= $shipping_id = $this->register_mdl->store_shipping_info($data); 	
				
				
				if($customer_info['firstname']==""){
					$datausr = array();
					$datausr['firstname'] = $data['firstname'];
					$datausr['lastname'] = $data['lastname'];
					$datausr['email'] = $data['email'];
					$datausr['last_updated'] = date('Y-m-d H:i:s');
					$this->register_mdl->update_user($customer_id,$datausr);
				}
				
				
				if (!empty($result)) {
					$msg = 'Add successfully .';   
				} else {
					$msg = 'Operation failed !'; 
				}
			
			}
			
			
		$output['status'] = $success; 
		if($msg!=""){ 
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; 
		}
		if($shipping_id!=""){ $output['shipping_id'] = $shipping_id;  } 
		echo json_encode($output); 
		die(); 
	}
	
	public function RemoveShipping() {
		
		$msg = "";  
		$response="";
		
		$config = array(
				array(
					'field' => 'customer_id',
					'label' => 'Customer Id',
					'rules' => 'trim|required'
				),  
				array(
					'field' => 'shipping_id',
					'label' => 'Shipping Id',
					'rules' => 'trim|required'
				),
			);
			
			 $customer_id= $_POST['customer_id'];
			 $shipping_id= $_POST['shipping_id'];
			 $shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {	 
				$success ='false';
				$msg =  validation_errors();	 
			}else if(empty($shipping_info)) { 
				$success ='false';
				$msg =  "Error: Shipping address not found.\n"; 
			}else{  
				$success ='true';
				 
				
				$result = $this->register_mdl->remove_shipping($shipping_id); 	
				
				if (!empty($result)) {
					$msg = 'Deleted successfully .';   
				} else {
					$msg = 'Operation failed !'; 
				}
			
			}
			
			
		$output['status'] = $success; 
		if($msg!=""){ 
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; 
		}
		echo json_encode($output); 
		die(); 
	}
	
	/*shipping*/
   
   /*selectShipping*/
   
   public function checkShipping() {
		
		$msg = "";  
		$response="";
		
		$config = array(
				array(
					'field' => 'customer_id',
					'label' => 'Customer Id',
					'rules' => 'trim|required'
				),  
				array(
					'field' => 'shipping_id',
					'label' => 'Shipping Id',
					'rules' => 'trim|required'
				),
			);
		
		 $customer_id= $_POST['customer_id'];
		 $shipping_id= $_POST['shipping_id'];
		 $shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
		$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {	 
				$success ='false';
				$msg =  validation_errors();	 
			}else if(empty($shipping_info)) { 
				$success ='false';
				$msg =  "Error: Shipping address not found.\n"; 
			}else{  
				$success ='true';
				
				
				if($shipping_info['lat']=="" || $shipping_info['lng']=="" ){
				 $excution = $this->register_mdl->update_shipping_info($shipping_id,$shipping_info);
				 if($excution==false){ $success = 'false'; }
				}
				$shipping_outlet = $this->get_shipping_outlet($shipping_id,$customer_id); 
				if(empty($shipping_outlet) and $success=='true'){
					$success ='false';
					$msg =  "Error: We can not ship in this Location"; 
				}else  if (!empty($shipping_info) and $success=='true') {
					 $success = 'true';
					 
				}else{
					 $success = 'false';
					 $msg='Error: Something went wrong. Refresh page and try again.';
				 }
				
				
				
			}
		
		
		$output['status'] = $success; 
		if($msg!=""){ 
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; 
		}
		echo json_encode($output); 
		die(); 
   }
   
   /*selectShipping*/
   
   
   
   	/*order*/
	public function PAYMENT_COD() {
		$msg = "";  
		$response="";
		
		$settings_info= $setting_info = $this->get_settings_info(); 
		
		$config = array(
				array(
					'field' => 'customer_id',
					'label' => 'Customer Id',
					'rules' => 'trim|required'
				),  
				array(
					'field' => 'shipping_id',
					'label' => 'Shipping Id',
					'rules' => 'trim|required'
				),
				
			);
			
			
			 $customer_id= $_POST['customer_id'];
			 $shipping_id= $_POST['shipping_id'];
			 
			 $payment_type= 'COD';
			
			 $customer_info = $this->register_mdl->get_customer_info($_POST['customer_id']);
			
			$this->form_validation->set_rules($config);

			if ($this->form_validation->run() == FALSE) { 
				$success ='false';
				$msg =  validation_errors(); 
			}else if (empty($customer_info)) {
				 $success ='false';	
				 $msg =  "Error: Customer not found.\n";	 
			}else{ 		
				
				$shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
				$cart_info = $this->api_mdl->get_cart_info($_POST['customer_id']); 
				$shipping_outlet = $this->get_shipping_outlet($shipping_id,$customer_id); 
				
				$total=0;
				foreach($cart_info as $v_cart_info){	
					$regular_price = $v_cart_info['quantity']*$v_cart_info['regular_price'];
					$total= $total+$regular_price;
				}
				
				if (empty($shipping_info)) {
					$success ='false';
					$msg =  "Error: Shipping address not found.\n"; 	
				}else if(empty($shipping_outlet)){
					$success ='false';
					$msg =  "Error: We can not ship in this Location"; 
					
				}else if(count($cart_info)<=0){	
					$success ='false';
					$msg =  "Error: Cart is empty."; 
					
				}else if($total<$setting_info['minimum_order']){	
					
					$success ='false';
					$msg =  'Error: Please order minimum  '.CURRENCY_API.$settings_info['minimum_order'].''; 
					
				}else{
					
					/*else*/
					$success ='true';
					$outlet_id = $shipping_outlet->outlet_id;
					
					$amount = 0;
					$discount = 0;
					foreach($cart_info as $v_cart_info){
							$quantity = $v_cart_info['quantity'];
							
							$amount = $amount+($v_cart_info['regular_price']*$quantity); 
							$discount = $discount+($v_cart_info['discount']*$quantity); 
					
					}	
					$total = $amount;
					
					$delivery_charge= 0;
					if(!empty($setting_info['delivery_price'])){
					 $delivery_charge = $setting_info['delivery_price'];
					 $total = $total + $delivery_charge;
					 $amount = $total ;
					}
					$customer_info = $this->register_mdl->get_customer_info($customer_id);
						
					$fullname = $shipping_info['firstname']." ".$shipping_info['lastname'];
					$email = $shipping_info['email'];
					$phone = $customer_info['phone'];
					$address = $shipping_info['address'];	
					
					
					$data_order = array();
					$data_order['shipping_id'] = $shipping_id; 
					$data_order['customer_id'] = $customer_id; 
					$data_order['outlet_id'] = $outlet_id;
					$data_order['delivery_id'] = $outlet_info['associated_delivery_id'];

					$data_order['razorpay_order_id'] = $razorpayOrderId;

					$data_order['amount'] = $total;
					$data_order['discount'] = $discount;
					$data_order['payment_status'] = 'pending';  

					$data_order['firstname'] = $shipping_info['firstname'];
					$data_order['lastname'] = $shipping_info['lastname'];
					$data_order['phone'] = $customer_info['phone'];
					$data_order['email'] = $shipping_info['email'];

					$data_order['address'] = $shipping_info['address'];
					$data_order['city'] = $shipping_info['city'];
					$data_order['postcode'] = $shipping_info['postcode'];

					$data_order['delivery_charge'] = $delivery_charge; 
					$data_order['payment_type'] = $payment_type;  

					$data_order['date_added'] = date('Y-m-d H:i:s');  

					$order_id = $this->order_mdl->store_order($data_order);
					
					
					foreach($cart_info as $v_cart_info){
			
						$data_order_product = array();
						$data_order_product['customer_id'] = $customer_id; 
						$data_order_product['order_id'] = $order_id; 
						
						$data_order_product['product_id'] = $v_cart_info['product_id']; 
						$data_order_product['product_id'] = $v_cart_info['product_id']; 
						$data_order_product['price_id'] = $v_cart_info['price_id']; 
						$data_order_product['product_title'] = $v_cart_info['product_title']; 
						$data_order_product['price'] = $v_cart_info['price']; 
						$data_order_product['regular_price'] = $v_cart_info['regular_price']; 
						$data_order_product['discount'] = $v_cart_info['discount']; 
						$data_order_product['quantity'] = $v_cart_info['quantity']; 
						$order_product_id = $this->order_mdl->store_order_product($data_order_product);
					}	
					
					$shopping_order_id = (1000+$order_id);
					$data['shopping_order_id'] = $shopping_order_id;
					
					
					$this->cart_mdl->remove_cart_by_customer_id($customer_id); 
					$data_order_history = array();
					$data_order_history['order_id'] = $order_id;
					$data_order_history['customer_id'] = $customer_id;
					$data_order_history['order_status'] = 'pending';
					$data_order_history['date_added'] = date('Y-m-d H:i:s'); 
					$this->order_mdl->store_order_history($data_order_history);
					
					
					/*mail*/
					$setting_info = $this->get_settings_info(); 
					
					$mdata = array();
					$mdata['from_address'] = $setting_info['email_address'];
					$mdata['to_address'] = $setting_info['to_email']; 
					$mdata['site_name'] = $setting_info['site_name'];
					$mdata['web'] = $setting_info['web'];
					$mdata['hello_name'] = 'Admin';
					
					$mdata['subject'] = $setting_info['site_name'].' - You have received an order'; 
					$mdata['title'] = ' You have received an order'; 
					
					$order_info = $this->order_mdl->get_order_by_customer_order_id($customer_id,$order_id);
					$order_product = $this->order_mdl->get_order_product_by_customer_order_id($customer_id,$order_id);
					
					$outlet_info = $this->register_mdl->get_outlet_info($order_info['outlet_id']);
					$delivery_info = $this->register_mdl->get_delivery_info($outlet_info['associated_delivery_id']);
					
					
					
					$message =  '<div>';
						$message .= '<p>Order ID : '.$order_info['order_id'].'<br>';
						$message .= 'Date Added : '.date("d/m/Y",strtotime($order_info['date_added'])).'<br>';
						$message .= 'Payment Type : Cash on delivery<br>';
						$message .= 'Order Status : '.ucwords($order_info['order_status']).'</p>';
						
						
						 $message .= '<table class="table table-bordered table-hover">
							<thead>
							  <tr>
								<td class="text-left" style="width: 50%; vertical-align: top;">User Contact</td>
								<td class="text-left" style="width: 50%; vertical-align: top;">Shipping Address</td>
								</tr>
							</thead>
							<tbody>
							  <tr>
								<td class="text-left">
									'.$order_info['firstname'].' '.$order_info['lastname'].'<br>
									'.$order_info['email'].' <br>
									'.$order_info['phone'].'
								</td>
											
											
								<td class="text-left">
									'.$order_info['address'].'<br>
									'.$order_info['city'].' <br>
									'.$order_info['postcode'].'<br>
								</td>
								 </tr>
							</tbody>
						  </table><br>';
						 
					$settings_info = $this->get_settings_info();
					$delivery_charge = $settings_info['delivery_price'];
									
					$message .= '<table class="table table-bordered table-hover">
							<thead>
							  <tr>
								<td class="text-left" style="width: 50%; vertical-align: top;">Outlet Details</td>
								<td class="text-left" style="width: 50%; vertical-align: top;">Delivery Details</td>
								</tr>
							</thead>
							<tbody>
							  <tr>
								<td class="text-left">
									'.$outlet_info['outlet_name'].' <br>
									'.$outlet_info['address'].' <br>
									'.$outlet_info['assigned_city'].' <br>
									'.$outlet_info['zipcode'].' <br>
									'.$outlet_info['phone'].'
								</td>
											
											
								<td class="text-left">
									'.$delivery_info['delivery_name'].'<br> 
									'.$delivery_info['address'].'<br>
									'.$delivery_info['city'].'<br>
									'.$delivery_info['zipcode'].'<br>
									'.$delivery_info['phone'].'<br>
									 
								</td>
								 </tr>
							</tbody>
						  </table><br>';
									
									
						
						
						$message .= '<b>Products</b>';
						$message .= '<table class="table table-bordered table-hover">
								  <thead>
									<tr>
									  <td class="text-left">Product Name</td>
									  <td class="text-right">Quantity</td>
									  <td class="text-right">Unit Price</td>
									  <td class="text-right">Total</td> 
									  </tr>
								  </thead>
								  <tbody>';
								  
							$total = 0;
							foreach($order_product as $orderproduct){ 
							
							$total = $total+($orderproduct['quantity']*$orderproduct['regular_price']);
							
							$message .= '<tr> 
											<td class="text-left">'.$orderproduct['product_title'].'</td>
											<td class="text-right">'.$orderproduct['quantity'].'</td>
											<td class="text-right">'.CURRENCY.$orderproduct['regular_price'].'</td>
											<td class="text-right">'.(CURRENCY.($orderproduct['quantity']*$orderproduct['regular_price'])).'
											</td>
											  
										  </tr>';
							
							
							}										
								  
								  
					$message .= '</tbody>';		
					$message .= '<tfoot>';	
					
					$message .= '<tr>
										<td colspan="2"></td>
										<td class="text-right"><b>Sub-Total</b></td>
										<td class="text-right">'.CURRENCY." ".$total.'</td>
									 
									</tr>';	
									
					$sub_total = $total;
					if(!empty($delivery_charge)){
						
						$total = ($total+$delivery_charge);				
									
						$message .= '<tr>
							<td colspan="2"></td>
							<td class="text-right"><b>Delivery charge</b></td>
							<td class="text-right">'.CURRENCY." ".$delivery_charge.'</td>									 
						</tr>';	
					}									
							
									
					$message .= '<tr>
										<td colspan="2"></td>
										<td class="text-right"><b>Total</b></td>
										<td class="text-right">'.CURRENCY." ".$total.'</td>									 
									</tr>';	
									
					$message .= '</tfoot></table>';						
						
						
					$message .= '</div>';
					
					$mdata['message'] = $message; 
					
					
					$this->mail_mdl->sendEmail($mdata, 'basic_email');	
					
					
					/************/
					
					if($outlet_info){
							
							if($outlet_info['phone']){
							 $this->send_order_info($outlet_info['phone'],$order_info['order_id']);
							}							
							if($delivery_info['phone']){
							 $this->send_order_info($delivery_info['phone'],$order_info['order_id']);
							}
								
							$msg = "Success: Order placed successfully.";
						
					}
					
					/*else*/	
				}
				
				
				
			}			
				
		$output['status'] = $success;
		
		if($order_info['order_id']!=""){ 
		$output['order_id'] = (int)$order_info['order_id'];  	
		}		
		
		if($msg!=""){ 
			$msg = strip_tags($msg);
			$msg = str_replace(array("\n", "\r"), '', $msg);
			$output['message']=$msg; 
		}
		echo json_encode($output);
		die();
	}
	/*order*/
   
   
   /*order RAZOR*/
   
   public function PAYMENT_RAZOR() {

		$msg = "";  
		$response="";

		$setting_info = $this->get_settings_info(); 

		$config = array(
			array(
				'field' => 'customer_id',
				'label' => 'Customer Id',
				'rules' => 'trim|required'
			),  
			array(
				'field' => 'shipping_id',
				'label' => 'Shipping Id',
				'rules' => 'trim|required'
			),
			
		);
		
		
		 $customer_id= $_POST['customer_id'];
		 $shipping_id= $_POST['shipping_id'];
		 $payment_type= 'ROZERPAY';
		
		$customer_info = $this->register_mdl->get_customer_info($_POST['customer_id']);
			
		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE) { 
			$success ='false';
			$msg =  validation_errors(); 
		}else if (empty($customer_info)) {
			 $success ='false';	
			 $msg =  "Error: Customer not found.\n";	 
		}else{ 		
			
			    $shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
				$cart_info = $this->api_mdl->get_cart_info($_POST['customer_id']); 
				$shipping_outlet = $this->get_shipping_outlet($shipping_id,$customer_id); 
				
				$total=0;
				foreach($cart_info as $v_cart_info){	
					$regular_price = $v_cart_info['quantity']*$v_cart_info['regular_price'];
					$total= $total+$regular_price;
				}
				
				if (empty($shipping_info)) {
					$success ='false';
					$msg =  "Error: Shipping address not found.\n"; 	
				}else if(empty($shipping_outlet)){
					$success ='false';
					$msg =  "Error: We can not ship in this Location"; 
					
				}else if(count($cart_info)<=0){	
					$success ='false';
					$msg =  "Error: Cart is empty."; 
					
				}else if($total<$setting_info['minimum_order']){	
					
					$success ='false';
					$msg =  'Error: Please order minimum  '.CURRENCY_API.$settings_info['minimum_order'].''; 
					
				}else{
					
					/*else*/
						$amount = 0;
						$discount = 0;
						foreach($cart_info as $v_cart_info){
								$quantity = $v_cart_info['quantity'];
								
								$amount = $amount+($v_cart_info['regular_price']*$quantity); 
								$discount = $discount+($v_cart_info['discount']*$quantity); 
						
						}	
						$total = $amount;
						
						$delivery_charge= 0;
						if(!empty($setting_info['delivery_price'])){
						 $delivery_charge = $setting_info['delivery_price'];
						 $total = $total + $delivery_charge;
						 $amount = $total ;
						}
						
					
					$keyId= RAZOR_KEY_ID;
					$keySecret = RAZOR_KEY_SECRET;
							
					$get_order_data = 	$this->api_mdl->get_order_data($customer_id);
					
					if($get_order_data!=""){ 
						
						$orderData = [
									'receipt'         => 3456,
									'amount'          => ($amount * 100), 
									'currency'        => 'INR',
									'payment_capture' => 1 
								];
								
						$razorpayOrderId = $get_order_data['razorpay_order_id'];


					}else{
						
						$api = new RazorpayApi($keyId, $keySecret);

						$orderData = [
									'receipt'         => 3456,
									'amount'          => ($amount * 100), 
									'currency'        => 'INR',
									'payment_capture' => 1 
								];
								
						$razorpayOrder = $api->order->create($orderData);
						$razorpayOrderId = $razorpayOrder['id'];
					}
					
					
							
							
					$razorpay_order_id= $razorpayOrderId;		
					$displayAmount = $amount = $orderData['amount'];

					$fullname = $shipping_info['firstname']." ".$shipping_info['lastname'];
					$email = $shipping_info['email'];
					$phone = $customer_info['phone'];
					$address = $shipping_info['address'];

					$merchant_order_id = "12312321";					
							
					
$data_roz = [
			"key"               => $keyId,
			"amount"            => $amount,
			"name"              => $fullname,
			"description"       => $fullname,
			"image"             => "https://s29.postimg.org/r6dj1g85z/daft_punk.jpg",
			"prefill"           => [
									"name"              => $fullname,
									"email"             => $email,
									"contact"           => $phone,
									],
			"notes"             => [
									"address"           => $address,
									"merchant_order_id" => $merchant_order_id,
									],
			/* "theme"             => [
			"color"             => "#F37254"
			], */
			"order_id"          => $razorpayOrderId,
		];
		
		$json = json_encode($data_roz);
		
		$data['json'] = $json;
		$data['data_roz'] = $data_roz;  
		
		$success = "true";
		
		
		/******************** data_order ***********************/
		$outlet_info = $this->register_mdl->get_outlet_info($outlet_id);
		
		$data_order = array();
		/*$data_order['session_id'] = $this->session->userdata('session_id'); */
		if($get_order_data!=""){ 
			$data_order['order_id'] = $get_order_data['order_id']; 
		}
		
		$data_order['shipping_id'] = $shipping_id; 
		$data_order['customer_id'] = $customer_id; 
		$data_order['outlet_id'] = $outlet_id;
		$data_order['delivery_id'] = $outlet_info['associated_delivery_id'];
		
		$data_order['razorpay_order_id'] = $razorpayOrderId;
		
		$data_order['amount'] = $total;
		$data_order['discount'] = $discount;
		$data_order['payment_status'] = 'pending';  
		
		$data_order['firstname'] = $shipping_info['firstname'];
		$data_order['lastname'] = $shipping_info['lastname'];
		$data_order['phone'] = $customer_info['phone'];
		$data_order['email'] = $shipping_info['email'];
		
		$data_order['address'] = $shipping_info['address'];
		$data_order['city'] = $shipping_info['city'];
		$data_order['postcode'] = $shipping_info['postcode'];
		
		$data_order['delivery_charge'] = $delivery_charge; 
		$data_order['payment_type'] = $payment_type; 
		
		$data_order['device_type'] = 'MOBILE'; 
		
		
		$data_order['date_added'] = date('Y-m-d H:i:s'); 
		
		
		
		$order_id = $this->api_mdl->store_order($data_order);
		
		foreach($cart_info as $v_cart_info){
			
			$data_order_product = array();
			$data_order_product['customer_id'] = $customer_id; 
			$data_order_product['order_id'] = $order_id; 
			
			$data_order_product['product_id'] = $v_cart_info['product_id']; 
			$data_order_product['product_id'] = $v_cart_info['product_id']; 
			$data_order_product['price_id'] = $v_cart_info['price_id']; 
			$data_order_product['product_title'] = $v_cart_info['product_title']; 
			$data_order_product['price'] = $v_cart_info['price']; 
			$data_order_product['regular_price'] = $v_cart_info['regular_price']; 
			$data_order_product['discount'] = $v_cart_info['discount']; 
			$data_order_product['quantity'] = $v_cart_info['quantity']; 
			$order_product_id = $this->order_mdl->store_order_product($data_order_product);
		}	
		
		 
		/******************** data_order ***********************/
		
		$shopping_order_id = (1000+$order_id);
		$data['shopping_order_id'] = $shopping_order_id;					
							
							
					/*else*/
				}					
			
		}
	   
	   
	   
	   $output['status'] = $success;
		
		if($order_id!=""){ 
		$output['order_id'] = (int)$order_id;  	
		}		
		if($data_roz!=""){ 
		$output['data_roz'] =  $data_roz;  	
		}
		
		if($msg!=""){ 
			$msg = strip_tags($msg);
			$msg = str_replace(array("\n", "\r"), '', $msg);
			$output['message']=$msg; 
		}
		echo json_encode($output);
		die();
   }
   
   /*order RAZOR*/
   
   
   /*order RAZOR verify*/
   
   public function RAZOR_verify()
    {
		$success = true;	
		$msg = "";  
		$response="";
		
		$setting_info = $this->get_settings_info(); 

		$config = array(
			array(
				'field' => 'customer_id',
				'label' => 'Customer Id',
				'rules' => 'trim|required'
			),  
			array(
				'field' => 'order_id',
				'label' => 'order id',
				'rules' => 'trim|required'
			),
			
			array(
				'field' => 'razorpay_payment_id',
				'label' => 'razorpay payment id',
				'rules' => 'trim|required'
			),
			
			array(
				'field' => 'razorpay_signature',
				'label' => 'razorpay signature',
				'rules' => 'trim|required'
			),
			
		);
		
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
			$success ='false';
			$msg =  validation_errors(); 
			
		}else{
			/* else */ 
			
			$keyId= RAZOR_KEY_ID;
			$keySecret = RAZOR_KEY_SECRET;
			
	 
			$msg = "Payment Failed";
			
			$razorpay_payment_id = $_POST['razorpay_payment_id'];
			$razorpay_signature =$_POST['razorpay_signature'];
			
			$customer_id= $_POST['customer_id'];
			$shipping_id= $_POST['shipping_id'];
			
	 
			if (empty($razorpay_payment_id) === false)
			{
						
				try
				{
					$attributes = array(
						'razorpay_order_id' => $razorpay_order_id,
						'razorpay_payment_id' => $this->input->post('razorpay_payment_id'),
						'razorpay_signature' => $this->input->post('razorpay_signature')
					);

					$api->utility->verifyPaymentSignature($attributes);
				}
				catch(SignatureVerificationError $e)
				{
					$success = false;
					$msg = $e->getMessage();
				}		
					
				$this->cart_mdl->remove_cart_by_customer_id($customer_id); 
				if ($success === true)
				{
					$data_order = array();
					$data_order['razorpay_payment_id'] = $razorpay_payment_id;
					$data_order['payment_status'] = 'success';
					$this->order_mdl->update_order($razorpay_order_id,$data_order);
					
					$data_order_history = array();
					$data_order_history['order_id'] = $order_id;
					$data_order_history['customer_id'] = $customer_id;
					$data_order_history['order_status'] = 'pending';
					$data_order_history['date_added'] = date('Y-m-d H:i:s'); 
					$this->order_mdl->store_order_history($data_order_history);
					
					/*mail*/
					$setting_info = $this->get_settings_info(); 
					
					$mdata = array();
					$mdata['from_address'] = $setting_info['email_address'];
					$mdata['to_address'] = $setting_info['to_email']; 
					$mdata['site_name'] = $setting_info['site_name'];
					$mdata['web'] = $setting_info['web'];
					$mdata['hello_name'] = 'Admin';
					
					$mdata['subject'] = $setting_info['site_name'].' - You have received an order'; 
					$mdata['title'] = ' You have received an order'; 
					
					$order_info = $this->order_mdl->get_order_by_customer_order_id($customer_id,$order_id);
					$order_product = $this->order_mdl->get_order_product_by_customer_order_id($customer_id,$order_id);
					
					$outlet_info = $this->register_mdl->get_outlet_info($order_info['outlet_id']);
					$delivery_info = $this->register_mdl->get_delivery_info($outlet_info['associated_delivery_id']);
					
					
					
					$message =  '<div>';
						$message .= '<p>Order ID : '.$order_info['order_id'].'<br>';
						$message .= 'Payment Type : Rozerpay<br>';
						$message .= 'Date Added : '.date("d/m/Y",strtotime($order_info['date_added'])).'<br>';
						$message .= 'Order Status : '.ucwords($order_info['order_status']).'</p>';
						
						
						 $message .= '<table class="table table-bordered table-hover">
							<thead>
							  <tr>
								<td class="text-left" style="width: 50%; vertical-align: top;">User Contact</td>
								<td class="text-left" style="width: 50%; vertical-align: top;">Shipping Address</td>
								</tr>
							</thead>
							<tbody>
							  <tr>
								<td class="text-left">
									'.$order_info['firstname'].' '.$order_info['lastname'].'<br>
									'.$order_info['email'].' <br>
									'.$order_info['phone'].'
								</td>
											
											
								<td class="text-left">
									'.$order_info['address'].'<br>
									'.$order_info['city'].' <br>
									'.$order_info['postcode'].'<br>
								</td>
								 </tr>
							</tbody>
						  </table><br>';
						
						 
					$settings_info = $this->get_settings_info();
					$delivery_charge = $settings_info['delivery_price'];
									
					$message .= '<table class="table table-bordered table-hover">
							<thead>
							  <tr>
								<td class="text-left" style="width: 50%; vertical-align: top;">Outlet Details</td>
								<td class="text-left" style="width: 50%; vertical-align: top;">Delivery Details</td>
								</tr>
							</thead>
							<tbody>
							  <tr>
								<td class="text-left">
									'.$outlet_info['outlet_name'].' <br>
									'.$outlet_info['address'].' <br>
									'.$outlet_info['assigned_city'].' <br>
									'.$outlet_info['zipcode'].' <br>
									'.$outlet_info['phone'].'
								</td>
											
											
								<td class="text-left">
									'.$delivery_info['delivery_name'].'<br> 
									'.$delivery_info['address'].'<br>
									'.$delivery_info['city'].'<br>
									'.$delivery_info['zipcode'].'<br>
									'.$delivery_info['phone'].'<br>
									 
								</td>
								 </tr>
							</tbody>
						  </table><br>';
									
									
						
						
						$message .= '<b>Products</b>';
						$message .= '<table class="table table-bordered table-hover">
								  <thead>
									<tr>
									  <td class="text-left">Product Name</td>
									  <td class="text-right">Quantity</td>
									  <td class="text-right">Unit Price</td>
									  <td class="text-right">Total</td> 
									  </tr>
								  </thead>
								  <tbody>';
								  
							$total = 0;
							foreach($order_product as $orderproduct){ 
							
							$total = $total+($orderproduct['quantity']*$orderproduct['regular_price']);
							
							$message .= '<tr> 
											<td class="text-left">'.$orderproduct['product_title'].'</td>
											<td class="text-right">'.$orderproduct['quantity'].'</td>
											<td class="text-right">'.CURRENCY.$orderproduct['regular_price'].'</td>
											<td class="text-right">'.(CURRENCY.($orderproduct['quantity']*$orderproduct['regular_price'])).'
											</td>
											  
										  </tr>';
							
							
							}										
								  
								  
					$message .= '</tbody>';		
					$message .= '<tfoot>';	
					
					$message .= '<tr>
										<td colspan="2"></td>
										<td class="text-right"><b>Sub-Total</b></td>
										<td class="text-right">'.CURRENCY." ".$total.'</td>
									 
									</tr>';	
									
					$sub_total = $total;
					if(!empty($delivery_charge)){
						
						$total = ($total+$delivery_charge);				
									
						$message .= '<tr>
							<td colspan="2"></td>
							<td class="text-right"><b>Delivery charge</b></td>
							<td class="text-right">'.CURRENCY." ".$delivery_charge.'</td>									 
						</tr>';	
					}									
							
									
					$message .= '<tr>
										<td colspan="2"></td>
										<td class="text-right"><b>Total</b></td>
										<td class="text-right">'.CURRENCY." ".$total.'</td>									 
									</tr>';	
									
					$message .= '</tfoot></table>';						
						
						
					$message .= '</div>';
					
					$mdata['message'] = $message; 
					
					
					$this->mail_mdl->sendEmail($mdata, 'basic_email');	
					
					
					/************/
					
					
					if($outlet_info){
							
							/* 
							$mdata['hello_name'] = $outlet_info['outlet_name']; 
							$mdata['to_address'] = $outlet_info['to_email']; 

							$outlet_info['phone']	
							$delivery_info['phone']								
							*/
							
							if($outlet_info['phone']){
							 $this->send_order_info($outlet_info['phone'],$order_info['order_id']);
							}							
							if($delivery_info['phone']){
							 $this->send_order_info($delivery_info['phone'],$order_info['order_id']);
							}
							
							
						
					}
					
					/**************/
					
					
					/*mail*/
					
					$msg="Success: Order placed successfully.";
					
				}else{
					
					$data_order = array();
					$data_order['razorpay_payment_id'] = $razorpay_payment_id;
					$data_order['payment_status'] = 'failed';
					$this->order_mdl->update_order($razorpay_order_id,$data_order);
				}
				
					
			
			}
			
			/* else */ 
		}
		
		$output['status'] = $success;
		if($order_id!=""){ 
		$output['order_id'] = (int)$order_id;  	
		}		
	 
		
		
		if($msg!=""){ 
			$msg = strip_tags($msg);
			$msg = str_replace(array("\n", "\r"), '', $msg);
			$output['message']=$msg; 
		}
		echo json_encode($output);
		die();
	}
   /*order RAZOR verify*/
   
   /*get_shipping_outlet*/
	
	function get_shipping_outlet($shipping_id,$customer_id){
			
	 
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
	
	
	/*************** update order ****************/
	
	public function update_order() { 
	    $success = false; 
		$msg = ""; 
		
		$order_id = $_POST['order_id'];
		$order_info = $this->order_mdl->get_order_by_order_id($order_id); 
	
		
		$config = array(
				array(
					'field' => 'order_id',
					'label' => 'Order id',
					'rules' => 'trim|required'
				), 

				 array(
					'field' => 'order_status',
					'label' => 'Order Status',
					'rules' => 'trim|required'
				), 

				array(
					'field' => 'comment',
					'label' => 'Comment',
					'rules' => 'trim|required'
				), 

				
			);
		
		
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) { 
			
				$success ='false';
				$msg =  validation_errors(); 
			
			}else if (empty($order_info)) { 
		
				$success ='false';
				$msg =  "Error: Order not found.";
				
			}else if (!empty($order_info)) { 
			
			$data_order_history = array();
			$data_order_history['order_id'] = $order_id;
			$data_order_history['customer_id'] = $order_info['customer_id'];
			$data_order_history['order_status'] = $this->input->post('order_status', TRUE); 
			$data_order_history['comment'] = $this->input->post('comment', TRUE); 
			$data_order_history['date_added'] = date('Y-m-d H:i:s'); 
			$this->order_mdl->store_order_history($data_order_history);

			$data_order = array();  
			$data_order['order_status'] = $this->input->post('order_status', TRUE); 
			$data_order['last_updated'] = date('Y-m-d H:i:s'); 
			
			
			/*mail*/
			$notify = $this->input->post('notify', TRUE); 
			if($notify == 1 and $order_info['email']!=""){
				
			$setting_info = $this->get_settings_info(); 
				
			$mdata = array();
			$mdata['from_address'] = $setting_info['email_address'];
			$mdata['to_address'] = $order_info['email']; 
			$mdata['site_name'] = $setting_info['site_name'];
			$mdata['web'] = $setting_info['web'];
			$mdata['hello_name'] = $order_info['firstname']." ".$order_info['lastname'];
			
			$mdata['subject'] = $setting_info['site_name'].' - Order Update'; 
			$mdata['title'] = ' Order Update'; 
			
			
			$message =  '<div>';
				$message .= '<p>Order id : '.$order_info['order_id'].'</p>';
				$message .= '<p>Your order has been updated to the following status: '.$data_order['order_status'].'</p>';
				
				if($this->input->post('comment', TRUE)){
				$message .= '<p>Comment: '.$this->input->post('comment', TRUE).'</p>';
				}
			$message .= '</div>';
			
			$mdata['message'] = $message; 
			
			
			$this->mail_mdl->sendEmail($mdata, 'basic_email');	
				
			}
			/*mail*/
			
			$result = $this->order_mdl->update_data_order($order_id,$data_order);
			
            if (!empty($result)) {
			   $success = 'Success';
               $msg = 'Order status add successfully .'; 
            } else {
                $msg = 'Operation failed !'; 
            }
        } 
		
		$output['status'] = $success; 
		if($msg!=""){ 
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		$output['message']=$msg; }
		echo json_encode($output);
		die();
	}
	
	
	/*************** update order ****************/
	
	
	
	/*get Delivery info*/
	
	public function getOrderStatus() {
		
		$success = true; 
		$msg = ""; 
		 
		$order_status = $this->order_mdl->get_order_status();
		 
			
		$output['status'] = $success; 
		if($order_status!=""){ $output['order_status'] = $order_status; }
		$msg = strip_tags($msg);
		$msg = str_replace(array("\n", "\r"), '', $msg);
		echo json_encode($output);
		die();
	}
	
	/*get Delivery info*/
	
	
	
	
	public function send_order_info($phone,$order_id) {
	
		/* 
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
		} */
		 $success = 'true';	
		$output['success']= $success;
		$output['message']=$msg;
		return ($output);
		die(); 
	 }
   
} 
?>
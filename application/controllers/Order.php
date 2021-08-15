<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (BASEPATH .'/razorpay/razorpay-php/Razorpay.php');
use Razorpay\Api\Api as RazorpayApi;
use Razorpay\Api\Errors\SignatureVerificationError as SignatureVerificationError;

class Order extends CC_Controller
{
	
	public function __construct() {
        parent::__construct();   
		$this->load->model('frontend_models/Common_model', 'common_mdl'); 
		$this->load->model('frontend_models/Product_model', 'product_mdl'); 
		$this->load->model('frontend_models/Cart_model', 'cart_mdl');  
		$this->load->model('frontend_models/Register_model', 'register_mdl');
		
		$this->load->model('frontend_models/Order_model', 'order_mdl');  
		$this->load->model('mailer_models/mailer_model', 'mail_mdl');
    }
	
	
	public function success() {		 	 
    	 
		$data = array();
    	$data['title'] = 'Success Order'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = ''; 
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
		
		$data['categories'] = $this->product_mdl->dir_main_categories();
		
		 
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
    	$data['main_content'] = $this->load->view('frontend_views/success_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
    }
	
	public function notify() {		 	 
    	 
		$data = array();
    	$data['title'] = 'Failed Order'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = ''; 
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info; 
		
		$data['categories'] = $this->product_mdl->dir_main_categories();
		
		 
		
		$data['nav_mobile_content'] = $this->load->view('frontend_views/nav_mobile_content_v', $data, TRUE);
		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
    	$data['main_content'] = $this->load->view('frontend_views/notify_content_v', $data, TRUE); 
    	$this->load->view('frontend_views/user_master_v', $data);
    }
	
	public function verify()
    {
		
		$data = array();
		$this->load->view('frontend_views/loading_v', $data);
		
		
		$keyId= RAZOR_KEY_ID;
		$keySecret = RAZOR_KEY_SECRET;
		
		$success = true;
		$error = "Payment Failed";
		if (empty($this->input->post('razorpay_payment_id')) === false)
		{	
			$api = new RazorpayApi($keyId, $keySecret);
			$razorpay_order_id      = $this->session->userdata('razorpay_order_id'); 
			$order_id      = $this->session->userdata('order_id'); 
			$session_id      = $this->session->userdata('session_id'); 
			$customer_id      = $this->session->userdata('customer_id'); 
			
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
					$error = $e->getMessage();
				}
				
				
				/************/
				$razorpay_payment_id = $this->input->post('razorpay_payment_id');
				
				$this->session->unset_userdata('order_id');	
				$this->session->unset_userdata('razorpay_order_id');
				$this->session->unset_userdata('session_id');		
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
						
						/* $message .= '
										
							<table class="table table-bordered table-hover">
							<thead>
							  <tr>
								<td class="text-left" style="width: 100%; vertical-align: top;">Outlet Details</td>
		
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
								 </tr>
							</tbody>
						  </table><br>
									
									'; */
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
							*/
								
							
						
					}
					
					/**************/
					
					
					/*mail*/
					
					redirect('order/success', 'refresh');
				}
				else
				{
					$data_order = array();
					$data_order['razorpay_payment_id'] = $razorpay_payment_id;
					$data_order['payment_status'] = 'failed';
					$this->order_mdl->update_order($razorpay_order_id,$data_order);
					redirect('order/notify', 'refresh');
				}

				/************/
		
		}
		
	}
	
	/**/
	public function COD_PAYMENT(){
		$setting_info = $this->get_settings_info(); 	
		$data['cart_info'] = $cart_info = $this->cart_mdl->get_cart_info(); 
		$customer_id      = $this->session->userdata('customer_id'); 
		$shipping_id = $this->input->post('shipping_id', TRUE);
		$outlet_id = $this->input->post('outlet_id', TRUE);
		$payment_type = $this->input->post('payment_type', TRUE);
		
		$session_id      = $this->session->userdata('session_id'); 
 
		
		
		$shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
		
		if(count($cart_info)>0 and $customer_id!="" and $shipping_id!="" and $outlet_id!="" and $payment_type!=""){
			
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
			
			$outlet_info = $this->register_mdl->get_outlet_info($outlet_id);
			
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
		
		$sdata['order_id'] = $order_id;
		$this->session->set_userdata($sdata);
		/******************** data_order ***********************/
		
		$shopping_order_id = (1000+$order_id);
		$data['shopping_order_id'] = $shopping_order_id;
			
			
			$this->session->unset_userdata('order_id');	
			$this->session->unset_userdata('session_id');		
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
							
							/* 
							$mdata['hello_name'] = $outlet_info['outlet_name']; 
							$mdata['to_address'] = $outlet_info['to_email'];  
							*/
								
							
						
					}
					redirect('order/success', 'refresh');
			
			
		}else{
			$sdata['exception'] = 'Something went wrong please try again.';
			$this->session->set_userdata($sdata);
			redirect('checkout', 'refresh');
		}
		
	  
	
	}
	/**/
	
	
    public function index()
    {
		
		$payment_type = $this->input->post('payment_type', TRUE);
		if($payment_type=='COD'){
			
			$this->COD_PAYMENT();
			
		}else{
		
		
		$setting_info = $this->get_settings_info(); 	
		$data['cart_info'] = $cart_info = $this->cart_mdl->get_cart_info(); 
		$customer_id      = $this->session->userdata('customer_id'); 
		$shipping_id = $this->input->post('shipping_id', TRUE);
		$outlet_id = $this->input->post('outlet_id', TRUE);
		
		$shipping_info = $this->register_mdl->get_shipping_by_shipping_id($customer_id,$shipping_id);
		
		if(count($cart_info)>0 and $customer_id!="" and $shipping_id!="" and $outlet_id!=""){
			
			
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
		
		$api = new RazorpayApi($keyId, $keySecret);
		$orderData = [
						'receipt'         => 3456,
						'amount'          => ($amount * 100), 
						'currency'        => 'INR',
						'payment_capture' => 1 
					];
					
		$razorpayOrder = $api->order->create($orderData);
		$razorpayOrderId = $razorpayOrder['id'];

		$sdata['razorpay_order_id'] = $razorpayOrderId;
		$this->session->set_userdata($sdata);
		$displayAmount = $amount = $orderData['amount'];
		
		$customer_info = $this->register_mdl->get_customer_info($customer_id);
		
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
			"theme"             => [
			"color"             => "#F37254"
			],
			"order_id"          => $razorpayOrderId,
		];
		
		$json = json_encode($data_roz);
		
		$data['json'] = $json;
		$data['data_roz'] = $data_roz;  
		
		/******************** data_order ***********************/
		$outlet_info = $this->register_mdl->get_outlet_info($outlet_id);
		
		$data_order = array();
		/*$data_order['session_id'] = $this->session->userdata('session_id'); */
		
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
		
		$sdata['order_id'] = $order_id;
		$this->session->set_userdata($sdata);
		/******************** data_order ***********************/
		
		$shopping_order_id = (1000+$order_id);
		$data['shopping_order_id'] = $shopping_order_id;
		
	    $this->load->view('frontend_views/order_content_v', $data);
		
		}else{
			$sdata['exception'] = 'Something went wrong please try again.';
			$this->session->set_userdata($sdata);
			redirect('checkout', 'refresh');
		}
	}
	
	}
	
}
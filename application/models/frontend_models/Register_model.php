<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CC_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users'; 
	private $_customer = 'tbl_customer'; 
	private $_delivery = 'dir_delivery'; 
	private $_outlet = 'dir_outlet'; 
	
	private $_shipping_address = 'tbl_shipping_address'; 
	
	public function get_user_data_by_phone($phone) { 
		$result = $this->db->get_where($this->_customer, array('phone' => $phone, 'deletion_status' => 0));
        return $result->row_array();
    }
	
	public function get_delivery_data_by_phone($phone) { 
		$result = $this->db->get_where($this->_delivery, array('phone' => $phone, 'deletion_status' => 0));
        return $result->row_array();
    }
	
	public function get_outlet_data_by_phone($phone) { 
		$result = $this->db->get_where($this->_outlet, array('phone' => $phone, 'deletion_status' => 0));
        return $result->row_array();
    }
	
	
	public function verify_user($phone,$verify_number) { 
		
		$where  = ' `last_updated` >= (NOW()) - INTERVAL 5 MINUTE ';  
		$this->db->where( $where );  
		
		$result = $this->db->get_where($this->_customer, array('phone' => $phone,'verify_number' => $verify_number, 'deletion_status' => 0, 'activation_status' => 1));
        return $result->row_array();
    }
	
	
	public function verify_delivery($phone,$verify_number) { 
		
		$where  = ' `last_updated` >= (NOW()) - INTERVAL 5 MINUTE ';  
		$this->db->where( $where );  
		
		$result = $this->db->get_where($this->_delivery, array('phone' => $phone,'verify_number' => $verify_number, 'deletion_status' => 0, 'publication_status' => 1));
        return $result->row_array();
    }
	
	public function verify_outlet($phone,$verify_number) { 
		
		$where  = ' `last_updated` >= (NOW()) - INTERVAL 5 MINUTE ';  
		$this->db->where( $where );  
		
		$result = $this->db->get_where($this->_outlet, array('phone' => $phone,'verify_number' => $verify_number, 'deletion_status' => 0, 'publication_status' => 1));
        return $result->row_array();
    }
	
	
	public function store_user_registration_info($data){
		$this->db->insert($this->_customer, $data);
		return $this->db->insert_id();
	}
	
	public function store_delivery_registration_info($data){
		$this->db->insert($this->_delivery, $data);
		return $this->db->insert_id();
	}
	
	
	
	public function update_user($customer_id, $data) {   
        $this->db->update($this->_customer, $data, array('customer_id' => $customer_id)); 
        return $this->db->affected_rows(); 
    }
	
	public function update_delivery($delivery_id, $data) {   
        $this->db->update($this->_delivery, $data, array('delivery_id' => $delivery_id)); 
        return $this->db->affected_rows(); 
    }
	
	public function update_outlet($outlet_id, $data) {   
        $this->db->update($this->_outlet, $data, array('outlet_id' => $outlet_id)); 
        return $this->db->affected_rows(); 
    }
	
	
	
	public function check_user_login() {
        $email_or_mobile = $this->input->post('email', true);
        $password = $this->input->post('password', true);  
		
        $this->db->select('*'); 
        $this->db->from($this->_customer);
        $this->db->where("(phone = '$email_or_mobile' OR email = '$email_or_mobile')");
        $this->db->where('password', md5($password)); 
  /*       $this->db->where('activation_status', 1); 	 */
        $this->db->where('deletion_status', 0); 
        $query_result = $this->db->get(); 
        $result = $query_result->row();  
		
        return $result;
    }
	
	
	
	
	 public function get_customer_info($customer_id) {
        $result = $this->db->get_where($this->_customer, array('customer_id' => $customer_id, 'activation_status' => 1, 'deletion_status' => 0));
        return $result->row_array();

    }
	
	public function get_delivery_info($delivery_id) {
        $result = $this->db->get_where($this->_delivery, array('delivery_id' => $delivery_id, 'deletion_status' => 0));
        return $result->row_array();

    }
	
	public function get_shipping_address_info($customer_id) {          
		
		$this->db->select('data.*')
		->from('tbl_shipping_address as data')  
		->where('data.customer_id',$customer_id) 
		->where('data.deletion_status',0) 
		->order_by('data.shipping_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function store_shipping_info($data){
		
		$get_lat = $this->get_lat($data['postcode']);
		
		if($get_lat['lat']){ $data['lat'] = $get_lat['lat']; }
	    if($get_lat['lng']){ $data['lng'] = $get_lat['lng']; }
		
		if($get_lat['lat']!="" and $get_lat['lng']!=""){
			$this->db->insert($this->_shipping_address, $data);
			return $this->db->insert_id();
		}else{
		 
			return false;
			
		}
	}
	
	
	 public function get_shipping_by_shipping_id($customer_id,$shipping_id) {
        $result = $this->db->get_where($this->_shipping_address, array('customer_id' => $customer_id, 'shipping_id' => $shipping_id, 'deletion_status' => 0 ));
        return $result->row_array();
    }
	
	
	 public function get_outlet_info($outlet_id) {
        $result = $this->db->get_where('dir_outlet', array('outlet_id' => $outlet_id, 'deletion_status' => 0 ));
        return $result->row_array();
    }
	
	
	/* public function get_delivery_info($delivery_id) {
        $result = $this->db->get_where('dir_delivery', array('delivery_id' => $delivery_id, 'deletion_status' => 0 ));
        return $result->row_array();
    } */
	
	
	public function update_shipping_info($shipping_id, $data) {   
	
		$get_lat = $this->get_lat($data['postcode']);
		
		if($get_lat['lat']){ $data['lat'] = $get_lat['lat']; }
	    if($get_lat['lng']){ $data['lng'] = $get_lat['lng']; }
		
		if($get_lat['lat']!="" and $get_lat['lng']!=""){
			$this->db->update($this->_shipping_address, $data, array('shipping_id' => $shipping_id, 'deletion_status' => 0)); 
			return $this->db->affected_rows(); 
		}else{
			return false;
		}
    }
	
	public function remove_shipping($shipping_id) {   
	
		$this->db->update($this->_shipping_address, array('deletion_status' => 1) , array('shipping_id' => $shipping_id)); 
		return $this->db->affected_rows(); 
    }
	
	public function get_lat($zipcode) { 

		$lat= "";
		$lng= ""; 

		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zipcode)."&key=".MAP_KEY."";
		$result_string = file_get_contents($url);
		$result = json_decode($result_string, true);

		$result1[]=$result['results'][0];
		$result2[]=$result1[0]['geometry'];
		$result3[]=$result2[0]['location'];

		$lat= $result3[0]['lat'];
		$lng= $result3[0]['lng']; 

		$output['lat']=$lat;
		$output['lng']=$lng;
		return ($output);
		die(); 
    }
 
}
?>
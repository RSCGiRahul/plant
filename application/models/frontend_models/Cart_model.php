<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CC_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users'; 
	private $_cat = 'dir_categories'; 
	private $_cart = 'dir_cart'; 
	
	 
	public function get_cart_info() {
		
		$session_id = $this->session->userdata('session_id');
        $this->db->select('cart.*')
        ->from('dir_cart as cart') 
        ->where('cart.session_id', $session_id);
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }	
	
	 
	public function get_cart_data($session_id,$product_id,$price_id) {
         $result = $this->db->get_where($this->_cart, array('session_id' => $session_id, 'product_id' => $product_id, 'price_id' => $price_id));
        return $result->row_array();  
    }
	
	public function get_cart_data_by_id($cart_id) {
         $result = $this->db->get_where($this->_cart, array('cart_id' => $cart_id));
        return $result->row_array();  
    }
	 
	 
	public function store_cart($data) { 
		$cart_data = $this->get_cart_data($data['session_id'],$data['product_id'],$data['price_id']);
		
		if(empty($cart_data)){
			$data['date_added'] = date('Y-m-d H:i:s');  
			$this->db->insert($this->_cart, $data); 
			$cart_id =  $this->db->insert_id(); 
		}else{
			$data['quantity'] = $cart_data['quantity']+$data['quantity'];
			$data['last_updated'] = date('Y-m-d H:i:s');
			$this->db->update($this->_cart, $data, array('session_id' => $data['session_id'], 'product_id' => $data['product_id'], 'price_id' => $data['price_id']) ); 
		}
       return true;
    }  
	
	
	public function minus_to_cart($cart_id) { 
		
		$cart_data = $this->get_cart_data_by_id($cart_id);		
		if(!empty($cart_data)){
			$quantity = $cart_data['quantity']-1; 
			if($quantity>=1){  
				$data['quantity'] = $quantity;
				$data['last_updated'] = date('Y-m-d H:i:s');
				$this->db->update($this->_cart, $data, array('cart_id' => $cart_id) ); 
			}else{
				$this->db->delete($this->_cart,  array('cart_id' => $cart_id));
			}
		} 
       return true;
    }

	public function adding_to_cart($cart_id) { 

		$cart_data = $this->get_cart_data_by_id($cart_id);		
		if(!empty($cart_data)){
			
			$quantity = $cart_data['quantity']+1; 
			if($quantity>=1){  
				$data['quantity'] = $quantity;
				$data['last_updated'] = date('Y-m-d H:i:s');
				$this->db->update($this->_cart, $data, array('cart_id' => $cart_id) ); 
			}
		} 
	   return true;
	}	
	
	
	public function refresh_to_cart($cart_id,$quantity) { 
		$cart_data = $this->get_cart_data_by_id($cart_id);		
		if(!empty($cart_data)){ 
			if($quantity>=1){  
				$data['quantity'] = $quantity;
				$data['last_updated'] = date('Y-m-d H:i:s');
				$this->db->update($this->_cart, $data, array('cart_id' => $cart_id) ); 
			}else{
				$this->db->delete($this->_cart,  array('cart_id' => $cart_id));
			}
		} 
       return true;
    }
	
	
	public function update_cart_by_customer($customer_id,$product_id,$price_id,$quantity) { 
		
		$cart_data = '1';		
		if(!empty($cart_data)){ 
			if($quantity>=1){  
				$data['quantity'] = $quantity;
				$data['last_updated'] = date('Y-m-d H:i:s');
				$this->db->update($this->_cart, $data, array('customer_id' => $customer_id,'product_id' => $product_id,'price_id' => $price_id) ); 
			}else{
				$this->db->delete($this->_cart,  array('customer_id' => $customer_id,'product_id' => $product_id,'price_id' => $price_id));
			}
		} 
       return true;
    }
	
	public function remove_cart($cart_id) { 
		$this->db->delete($this->_cart,  array('cart_id' => $cart_id));
	}
	
	public function remove_cart_by_customer($cart_id,$product_id,$customer_id) { 
		$this->db->delete($this->_cart,  array('cart_id' => $cart_id,'product_id' => $product_id,'customer_id' => $customer_id));
	}
	
	
	
	public function remove_cart_by_session_id($session_id) { 
		$this->db->delete($this->_cart,  array('session_id' => $session_id));
	}
	
	public function remove_cart_by_customer_id($customer_id) { 
		$this->db->delete($this->_cart,  array('customer_id' => $customer_id));
	}
	
}
?>
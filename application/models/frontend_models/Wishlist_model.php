<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wishlist_model extends CC_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users'; 
	private $_cat = 'dir_categories'; 
	private $_wishlist = 'dir_wishlist'; 
	
	 
	public function get_wishlist_info() {
		
		$session_id = $this->session->userdata('session_id');
        $this->db->select('wishlist.*')
        ->from('dir_wishlist as wishlist') 
        ->where('wishlist.session_id', $session_id);
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }	
	
	 
	public function get_wishlist_data($session_id,$product_id,$price_id) {
         $result = $this->db->get_where($this->_wishlist, array('session_id' => $session_id, 'product_id' => $product_id, 'price_id' => $price_id));
        return $result->row_array();  
    }
	
	public function get_wishlist_data_by_id($wishlist_id) {
         $result = $this->db->get_where($this->_wishlist, array('wishlist_id' => $wishlist_id));
        return $result->row_array();  
    }
	 
	 
	public function store_wishlist($data) { 
		$wishlist_data = $this->get_wishlist_data($data['session_id'],$data['product_id'],$data['price_id']);
		
		if(empty($wishlist_data)){
			$data['date_added'] = date('Y-m-d H:i:s');  
			$this->db->insert($this->_wishlist, $data); 
			$wishlist_id =  $this->db->insert_id(); 
		}else{
			$data['quantity'] = $wishlist_data['quantity']+$data['quantity'];
			$data['last_updated'] = date('Y-m-d H:i:s');
			$this->db->update($this->_wishlist, $data, array('session_id' => $data['session_id'], 'product_id' => $data['product_id'], 'price_id' => $data['price_id']) ); 
		}
       return true;
    }  
	
	
	public function minus_to_wishlist($wishlist_id) { 
		
		$wishlist_data = $this->get_wishlist_data_by_id($wishlist_id);		
		if(!empty($wishlist_data)){
			$quantity = $wishlist_data['quantity']-1; 
			if($quantity>=1){  
				$data['quantity'] = $quantity;
				$data['last_updated'] = date('Y-m-d H:i:s');
				$this->db->update($this->_wishlist, $data, array('wishlist_id' => $wishlist_id) ); 
			}else{
				$this->db->delete($this->_wishlist,  array('wishlist_id' => $wishlist_id));
			}
		} 
       return true;
    }

	public function adding_to_wishlist($wishlist_id) { 

		$wishlist_data = $this->get_wishlist_data_by_id($wishlist_id);		
		if(!empty($wishlist_data)){
			
			$quantity = $wishlist_data['quantity']+1; 
			if($quantity>=1){  
				$data['quantity'] = $quantity;
				$data['last_updated'] = date('Y-m-d H:i:s');
				$this->db->update($this->_wishlist, $data, array('wishlist_id' => $wishlist_id) ); 
			}
		} 
	   return true;
	}	
	
	
	public function refresh_to_wishlist($wishlist_id,$quantity) { 
		$wishlist_data = $this->get_wishlist_data_by_id($wishlist_id);		
		if(!empty($wishlist_data)){ 
			if($quantity>=1){  
				$data['quantity'] = $quantity;
				$data['last_updated'] = date('Y-m-d H:i:s');
				$this->db->update($this->_wishlist, $data, array('wishlist_id' => $wishlist_id) ); 
			}else{
				$this->db->delete($this->_wishlist,  array('wishlist_id' => $wishlist_id));
			}
		} 
       return true;
    }
	
	
	public function update_wishlist_by_customer($customer_id,$product_id,$price_id,$quantity) { 
		
		$wishlist_data = '1';		
		if(!empty($wishlist_data)){ 
			if($quantity>=1){  
				$data['quantity'] = $quantity;
				$data['last_updated'] = date('Y-m-d H:i:s');
				$this->db->update($this->_wishlist, $data, array('customer_id' => $customer_id,'product_id' => $product_id,'price_id' => $price_id) ); 
			}else{
				$this->db->delete($this->_wishlist,  array('customer_id' => $customer_id,'product_id' => $product_id,'price_id' => $price_id));
			}
		} 
       return true;
    }
	
	public function remove_wishlist($wishlist_id) { 
		$this->db->delete($this->_wishlist,  array('wishlist_id' => $wishlist_id));
	}
	
	public function remove_wishlist_by_customer($wishlist_id,$product_id,$customer_id) { 
		$this->db->delete($this->_wishlist,  array('wishlist_id' => $wishlist_id,'product_id' => $product_id,'customer_id' => $customer_id));
	}
	
	
	
	public function remove_wishlist_by_session_id($session_id) { 
		$this->db->delete($this->_wishlist,  array('session_id' => $session_id));
	}
	
	public function remove_wishlist_by_customer_id($customer_id) { 
		$this->db->delete($this->_wishlist,  array('customer_id' => $customer_id));
	}
	
}
?>
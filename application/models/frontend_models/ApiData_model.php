<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiData_model extends CC_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users'; 
	private $_cat = 'dir_categories'; 
	private $_order = 'tbl_order';
	private $_order_product = 'tbl_order_product';	
	private $_cart = 'dir_cart'; 
	private $_wishlist = 'dir_wishlist'; 
	
	 
	public function get_main_categories() {          
		
		$this->db->select('cat.*')
		->from('dir_categories as cat')  
		->where('cat.publication_status', 1) 
		->where('cat.parent_id',0) 
		->where('cat.deletion_status',0) 
		->order_by('cat.category_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	 
	 public function get_all_categories() {          
		
		$get_categories_info = $this->CC_Model->get_all_categories_info(); 
		
		$ref   = [];
		$categories_info = [];
		
		/* 
		foreach($get_categories_info as $info) {
			$thisRef = &$ref[$info['category_id']];
			$thisRef['parent_id'] = $info['parent_id'];
			
			$thisRef['category_id'] = $info['category_id'];
			$thisRef['category_name'] = $info['category_name'];
			$thisRef['seo_url'] = $info['seo_url']; 
			
			 
			if($info['parent_id'] == 0) {
			$categories_info[$info['category_id']] = &$thisRef;
			} else {
			$ref[$info['parent_id']]['child'][$info['category_id']] = &$thisRef;
			} 
		}   
		*/
		
		foreach($get_categories_info as $info) {
			$thisRef = &$ref[$info['category_id']];
			$thisRef['parent_id'] = $info['parent_id'];
			$thisRef['seo_url'] = $info['seo_url'];
			
			$thisRef['category_id'] = $info['category_id'];
			$thisRef['category_name'] = $info['category_name'];
			$thisRef['seo_url'] = $info['seo_url']; 
			
			 
			if($info['parent_id'] == 0) {
			$categories_info[$info['category_id']] = &$thisRef;
			} else {
			/* $ref[$info['parent_id']]['child'][$info['seo_url']] = &$thisRef; */
			$ref[$info['parent_id']]['child'][] = &$thisRef;
			} 
		} 
		
		$ref2= [];
		
		foreach($ref as $v_ref){
			
			$ref2[''.$v_ref['seo_url'].''] = $v_ref; 
		}

		return $ref2;
	}
	
	public function getCategoriesByParentId($category_id) {          
		
		$this->db->select('cat.*')
		->from('dir_categories as cat')  
		->where('cat.publication_status', 1) 
		->where('cat.parent_id',$category_id) 
		->where('cat.deletion_status',0) 
		->order_by('cat.category_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_home_content() {          
		
		$this->db->select('homesetting.*')
		->from('dir_mobilesetting as homesetting')  
		->where('homesetting.publication_status', 1) 
		->order_by('homesetting.sort_order', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	} 
	
	public function get_cart_info($customer_id) {
		 
        $this->db->select('cart.cart_id,cart.customer_id,cart.product_id,cart.price_id,cart.product_title,cart.price,cart.regular_price,cart.discount,cart.quantity,cart.date_added')
        ->from('dir_cart as cart') 
        ->where('cart.customer_id', $customer_id);
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }
	
	
	public function get_wishlist_info($customer_id) {
		 
		$this->db->select('wishlist.wishlist_id,wishlist.customer_id,wishlist.product_id,wishlist.price_id,wishlist.product_title,wishlist.price,wishlist.regular_price,wishlist.discount,wishlist.quantity,wishlist.date_added')
		->from('dir_wishlist as wishlist') 
		->where('wishlist.customer_id', $customer_id);
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_order_info($customer_id) {
		 
       $this->db->select('order.*')
		->from('tbl_order as order')  
		->where('order.customer_id',$customer_id) 
		->order_by('order.order_id', 'asc');	
		
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }
	
	public function get_order_delivery_info($delivery_id) {
		 
       $this->db->select('order.*')
		->from('tbl_order as order')  
		->where('order.delivery_id',$delivery_id) 
		->order_by('order.order_id', 'asc');	
		
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }
	
	public function get_order_outlet_info($outlet_id) {
		 
       $this->db->select('order.*')
		->from('tbl_order as order')  
		->where('order.outlet_id',$outlet_id) 
		->order_by('order.order_id', 'asc');	
		
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }
	
	public function get_order_product_by_customer_order_id($customer_id,$order_id) {          
		
		$this->db->select('order_product.*')
		->from('tbl_order_product as order_product')  
		->where('order_product.customer_id',$customer_id) 
		->where('order_product.order_id',$order_id) 
		->order_by('order_product.order_product_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	
	
	public function store_order($data) { 
		
		$razorpayOrderId = $data['razorpayOrderId'];
		$customer_id = $data['customer_id'];
		$order_id = $data['order_id'];
		
		if($order_id!=""){
		$this->db->update($this->_order, $data, array('order_id' => $order_id)); 
		$this->db->delete('tbl_order_product', array('order_id' => $order_id));
		
		}else{
		$this->db->insert($this->_order, $data); 
		$order_id =  $this->db->insert_id(); 
		}
		
		return $order_id;
	}
	
	public function get_order_data($customer_id) {          
		
		$this->db->select('order.*')
		->from('tbl_order as order')  
		->where('order.deletion_status', 0)
		->where('order.device_type', 'MOBILE')
		->where('order.order_status', 'pending')
		->where('order.deletion_status', 0)
		->order_by('order.order_id', 'desc')
		->limit(1);
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		$order_data = '';
		if($result){ $result = $result[0]; $order_data = $result; } 
		return $order_data;
	}
	
	public function get_brand_by_brand_id($brand_id) {
        $result = $this->db->get_where('dir_brand', array('brand_id' => $brand_id, 'deletion_status' => 0));
        return $result->row_array();
    }
	 
	 
	
}
?>
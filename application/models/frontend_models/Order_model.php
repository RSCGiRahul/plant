<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CC_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users'; 
	private $_cat = 'dir_categories'; 
	private $_cart = 'dir_cart'; 
	private $_order = 'tbl_order';
	private $_order_product = 'tbl_order_product';	
	
	 
	 
	public function store_order($data) { 
		
		$razorpayOrderId = $data['razorpayOrderId'];
		$customer_id = $data['customer_id'];
		
		$this->db->insert($this->_order, $data); 
		return $order_id =  $this->db->insert_id(); 
	}	
	
	public function store_order_product($data) { 
		$this->db->insert($this->_order_product, $data); 
		return $order_id =  $this->db->insert_id(); 
	}
	
	public function store_order_history($data) { 
		$this->db->insert('tbl_order_history', $data); 
		return $order_history_id =  $this->db->insert_id(); 
	}
	
	
	
	public function update_order($razorpay_order_id,$data) { 
		 $this->db->update($this->_order, $data, array('razorpay_order_id' => $razorpay_order_id) ); 
       return true;
    }
	
	public function update_data_order($order_id,$data) {  
		 $this->db->update($this->_order, $data, array('order_id' => $order_id) ); 
       return true;
    }
	  public function get_order_by_order_id($order_id) { 
		$result = $this->db->get_where('tbl_order', array( 'order_id' => $order_id));
        return $result->row_array();
	}
	
	public function get_order_status() {          
		
		$this->db->select('order_status.*')
		->from('tbl_order_status as order_status')  
		->where('order_status.publication_status','1') 
		->where('order_status.deletion_status','0') 
		->order_by('order_status.order_status_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_order_by_customer_id($customer_id) {          
		
		$this->db->select('order.*')
		->from('tbl_order as order')  
		->where('order.customer_id',$customer_id) 
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
	
	public function get_order_history_by_customer_order_id($customer_id,$order_id) {          
		
		$this->db->select('order_history.*')
		->from('tbl_order_history as order_history')  
		->where('order_history.customer_id',$customer_id) 
		->where('order_history.order_id',$order_id) 
		->order_by('order_history.order_history_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	
	
	 
	 public function get_order_by_customer_order_id($customer_id,$order_id) { 
		$result = $this->db->get_where('tbl_order', array('customer_id' => $customer_id, 'order_id' => $order_id));
        return $result->row_array();
	}
	
}
?>
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_product = 'dir_product';
	private $_order = 'tbl_order';

	
	public function get_order_info($page=1,$search="",$status='',$payment_status='') {          

		if($page<1){
			$page=1;
		} 

		$offset = ($page - 1) * PAGINATION; 

		$this->db->select('order.*')
		->from('tbl_order as order') 
		->join('tbl_customer as customer', 'order.customer_id = customer.customer_id','left')
		->where('order.deletion_status', 0)
		->where('order.payment_status', $payment_status)
		->order_by('order.order_id', 'desc')
		->limit(PAGINATION,$offset);	

		$where=' 1=1 ';	

		if($search!=""){
			$where .= ' and customer.firstname LIKE "%'.trim($search).'%" '; 
		} 	

		if($status!=""){
			$where .= ' and order.order_status ="'.$status.'"';  	 
		}

		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}

	public function get_order_count($search='',$status='',$payment_status='') {          

		$this->db->select('order.*')
		->from('tbl_order as order') 
		->join('tbl_customer as customer', 'order.customer_id = customer.customer_id','left')
		->where('order.deletion_status', 0)
		->where('order.payment_status', $payment_status)
		->order_by('order.order_id', 'desc');	

		$where=' 1=1 ';	

		if($search!=""){
			$where .= ' and customer.firstname LIKE "%'.trim($search).'%" '; 
		} 	

		if($status!=""){
			$where .= ' and order.order_status ="'.$status.'"';  	 
		}

		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
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
	
	
	/**/
	
	public function get_order_product_by_order_id($order_id) {          
		
		$this->db->select('order_product.*')
		->from('tbl_order_product as order_product')  
		->where('order_product.order_id',$order_id) 
		->order_by('order_product.order_product_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_order_history_by_order_id($order_id) {          
		
		$this->db->select('order_history.*')
		->from('tbl_order_history as order_history')  
		->where('order_history.order_id',$order_id) 
		->order_by('order_history.order_history_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	} 
	 
	 public function get_order_by_order_id($order_id) { 
		$result = $this->db->get_where('tbl_order', array( 'order_id' => $order_id));
        return $result->row_array();
	}
	
	
	
	public function store_order_history($data) { 
		$this->db->insert('tbl_order_history', $data); 
		return $order_history_id =  $this->db->insert_id(); 
	}
	
	
	public function update_order($order_id,$data) {  
		 $this->db->update($this->_order, $data, array('order_id' => $order_id) ); 
       return true;
    }

}

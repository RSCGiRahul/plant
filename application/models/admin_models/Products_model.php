<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Products_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_product = 'dir_product';  
	private $_product_attribute = 'dir_product_attribute'; 
	private $_product_price = 'dir_product_price_option'; 

	
	public function get_product_info($page=1,$search="",$status='') {          

		if($page<1){

			$page=1;

		} 

		$offset = ($page - 1) * PAGINATION; 

		$this->db->select('product.*,users.first_name,users.last_name,users.email_address')
		->from('dir_product as product') 
		->join('tbl_users as users', 'product.user_id = users.user_id','left')
		->where('product.deletion_status', 0)
		->order_by('product.product_id', 'desc')
		->limit(PAGINATION,$offset);	

		$where=' 1=1 ';	

		if($search!=""){
			$where .= ' and product.product_name LIKE "%'.trim($search).'%" '; 
		} 	

		if($status!=""){
			if($status==1){  
			$where .= ' and product.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and product.publication_status ="0"  ';  
			}
		}

		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}

	public function get_product_count($search='',$status='') {          

		$this->db->select('product.*,users.first_name,users.last_name,users.email_address')
		->from('dir_product as product') 
		->join('tbl_users as users', 'product.user_id = users.user_id','left')
		->where('product.deletion_status', 0)
		->order_by('product.product_id', 'desc');	

		$where=' 1=1 ';	
		if($search!=""){
			$where .= ' and product.product_name LIKE "%'.trim($search).'%" '; 
		}
		if($status!=""){
			if($status==1){  
			$where .= ' and product.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and product.publication_status ="0"  ';  
			}
		}
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}
	
	
    public function store_product($data) { 
        $this->db->insert($this->_product, $data); 
        return $this->db->insert_id(); 
    } 
	
	
	public function store_product_attribute($product_id,$product_attribute) { 
			foreach($product_attribute as $v_product_attribute){
				$data = array();
				$data['product_id'] = $product_id; 
				$data['sorting'] = $v_product_attribute['sorting'];
				$data['product_attribute_name'] = $v_product_attribute['product_attribute_name'];
				$data['product_attribute_description'] = $v_product_attribute['product_attribute_description'];
				$data['date_added'] = date('Y-m-d H:i:s'); 
				$this->db->insert($this->_product_attribute, $data);
			}
        return $this->db->insert_id();  
    }
	
	public function store_product_price_option($product_id,$product_price_option) { 
			foreach($product_price_option as $v_product_price_option){
				$data = array();
				$data['product_id'] = $product_id; 
				$data['name'] = $v_product_price_option['name'];
				$data['price'] = $v_product_price_option['price'];
				$data['discount'] = $v_product_price_option['discount'];
				$data['discount_price'] = $v_product_price_option['discount_price'];
				$data['sorting'] = $v_product_price_option['sorting'];
				$data['date_added'] = date('Y-m-d H:i:s'); 
				$this->db->insert($this->_product_price, $data);
			}
        return $this->db->insert_id();  
    }
	
	
		public function update_product_attribute($product_id,$product_attribute) {
			
			$this->db->delete($this->_product_attribute,  array('product_id' => $product_id));
				
			foreach($product_attribute as $v_product_attribute){
				$data = array();
				$data['product_id'] = $product_id;  
				$data['sorting'] = $v_product_attribute['sorting'];
				$data['product_attribute_name'] = $v_product_attribute['product_attribute_name'];
				$data['product_attribute_description'] = $v_product_attribute['product_attribute_description'];
				$data['date_added'] = date('Y-m-d H:i:s'); 
				$this->db->insert($this->_product_attribute, $data);
			}
        return $this->db->insert_id();  
    }
	
	public function update_product_price_option($product_id,$product_price_option) { 
	
			$this->db->delete($this->_product_price,  array('product_id' => $product_id));
			foreach($product_price_option as $v_product_price_option){
				$data = array();
				$data['product_id'] = $product_id; 
				$data['name'] = $v_product_price_option['name'];
				$data['sorting'] = $v_product_price_option['sorting'];
				$data['price'] = $v_product_price_option['price'];
				$data['discount'] = $v_product_price_option['discount'];
				$data['discount_price'] = $v_product_price_option['discount_price'];
				
				$data['date_added'] = date('Y-m-d H:i:s'); 
				$this->db->insert($this->_product_price, $data);
				
			}
			
			
        return $this->db->insert_id();  
    }
	
	
	public function get_dir_product_price_option($product_id) {          
		
		$this->db->select('price.*')
		->from('dir_product_price_option as price') 
		->where('price.product_id', $product_id)
		->order_by('price.sorting', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_dir_product_attribute($product_id) {          
		
		$this->db->select('attribute.*')
		->from('dir_product_attribute as attribute') 
		->where('attribute.product_id', $product_id)
		->order_by('attribute.sorting', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	

    public function get_product_by_product_id($product_id) {
        $result = $this->db->get_where($this->_product, array('product_id' => $product_id, 'deletion_status' => 0));
        return $result->row_array();
    }

    public function published_product_by_id($product_id) {
        $this->db->update($this->_product, array('publication_status' => 1), array('product_id' => $product_id));
        return $this->db->affected_rows();
    }

    public function unpublished_product_by_id($product_id) {
        $this->db->update($this->_product, array('publication_status' => 0), array('product_id' => $product_id));
        return $this->db->affected_rows();
    }

    public function update_product($product_id, $data) {
        $this->db->update($this->_product, $data, array('product_id' => $product_id));
        return $this->db->affected_rows();
    }

    public function remove_product_by_id($product_id) {
        $this->db->update($this->_product, array('deletion_status' => 1), array('product_id' => $product_id));
        return $this->db->affected_rows();
    }

}

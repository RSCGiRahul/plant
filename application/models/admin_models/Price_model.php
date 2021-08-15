<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Price_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_price = 'dir_price_option';    
	
	
	public function get_price_option() {          
		
		$this->db->select('price.*')
		->from('dir_price_option as price')  
		->where('price.publication_status', 1)
		->where('price.deletion_status', 0)
		->order_by('price.price_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_price_info($page=1,$search="",$status='') {          
		if($page<1){ 
			$page=1; 
		}  
		$offset = ($page - 1) * PAGINATION; 
		$this->db->select('price.*')
		->from('dir_price_option as price')  
		->where('price.deletion_status', 0)
		->order_by('price.price_id', 'desc')
		->limit(PAGINATION,$offset);	 
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and price.price_name LIKE "%'.trim($search).'%" '; 
		} 	 
		if($status!=""){
			if($status==1){  
			$where .= ' and price.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and price.publication_status ="0"  ';  
			}
		} 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}

	public function get_price_count($search='',$status='') {          
		$this->db->select('price.*')
		->from('dir_price_option as price')  
		->where('price.deletion_status', 0)
		->order_by('price.price_id', 'desc');	 
		
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and price.price_name LIKE "%'.trim($search).'%" '; 
		} 	
		if($status!=""){
			if($status==1){  
			$where .= ' and price.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and price.publication_status ="0"  ';  
			}
		}
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}
	
	
    public function store_price($data) { 
        $this->db->insert($this->_price, $data); 
        return $this->db->insert_id(); 
    }  

    public function get_price_by_price_id($price_id) {
        $result = $this->db->get_where($this->_price, array('price_id' => $price_id, 'deletion_status' => 0));
        return $result->row_array();
    }

    public function published_price_by_id($price_id) {
        $this->db->update($this->_price, array('publication_status' => 1), array('price_id' => $price_id));
        return $this->db->affected_rows();
    }

    public function unpublished_price_by_id($price_id) {
        $this->db->update($this->_price, array('publication_status' => 0), array('price_id' => $price_id));
        return $this->db->affected_rows();
    }

    public function update_price($price_id, $data) {
        $this->db->update($this->_price, $data, array('price_id' => $price_id));
        return $this->db->affected_rows();
    }

    public function remove_price_by_id($price_id) {
        $this->db->update($this->_price, array('deletion_status' => 1), array('price_id' => $price_id));
        return $this->db->affected_rows();
    }
}
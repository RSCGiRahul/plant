<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Attribute_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_attribute = 'dir_attribute';    
	
	
	public function get_product_attribute() {          
		
		$this->db->select('attribute.*')
		->from('dir_attribute as attribute')  
		->where('attribute.publication_status', 1)
		->where('attribute.deletion_status', 0)
		->order_by('attribute.attribute_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_attribute_info($page=1,$search="",$status='') {          
		if($page<1){ 
			$page=1; 
		}  
		$offset = ($page - 1) * PAGINATION; 
		$this->db->select('attribute.*')
		->from('dir_attribute as attribute')  
		->where('attribute.deletion_status', 0)
		->order_by('attribute.attribute_id', 'desc')
		->limit(PAGINATION,$offset);	 
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and attribute.attribute_name LIKE "%'.trim($search).'%" '; 
		} 	 
		if($status!=""){
			if($status==1){  
			$where .= ' and attribute.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and attribute.publication_status ="0"  ';  
			}
		} 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}

	public function get_attribute_count($search='',$status='') {          
		$this->db->select('attribute.*')
		->from('dir_attribute as attribute')  
		->where('attribute.deletion_status', 0)
		->order_by('attribute.attribute_id', 'desc');	 
		
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and attribute.attribute_name LIKE "%'.trim($search).'%" '; 
		} 	
		if($status!=""){
			if($status==1){  
			$where .= ' and attribute.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and attribute.publication_status ="0"  ';  
			}
		}
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}
	
	
    public function store_attribute($data) { 
        $this->db->insert($this->_attribute, $data); 
        return $this->db->insert_id(); 
    }  

    public function get_attribute_by_attribute_id($attribute_id) {
        $result = $this->db->get_where($this->_attribute, array('attribute_id' => $attribute_id, 'deletion_status' => 0));
        return $result->row_array();
    }

    public function published_attribute_by_id($attribute_id) {
        $this->db->update($this->_attribute, array('publication_status' => 1), array('attribute_id' => $attribute_id));
        return $this->db->affected_rows();
    }

    public function unpublished_attribute_by_id($attribute_id) {
        $this->db->update($this->_attribute, array('publication_status' => 0), array('attribute_id' => $attribute_id));
        return $this->db->affected_rows();
    }

    public function update_attribute($attribute_id, $data) {
        $this->db->update($this->_attribute, $data, array('attribute_id' => $attribute_id));
        return $this->db->affected_rows();
    }

    public function remove_attribute_by_id($attribute_id) {
        $this->db->update($this->_attribute, array('deletion_status' => 1), array('attribute_id' => $attribute_id));
        return $this->db->affected_rows();
    }
}
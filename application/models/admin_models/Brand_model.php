<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Brand_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_brand = 'dir_brand';    
	
	public function get_brand_list() {          
		
		$this->db->select('brand.*')
		->from('dir_brand as brand')  
		->where('brand.publication_status', 1)
		->where('brand.deletion_status', 0)
		->order_by('brand.brand_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_brand_info($page=1,$search="",$status='') {          
		if($page<1){ 
			$page=1; 
		}  
		$offset = ($page - 1) * PAGINATION; 
		$this->db->select('brand.*')
		->from('dir_brand as brand')  
		->where('brand.deletion_status', 0)
		->order_by('brand.brand_id', 'desc')
		->limit(PAGINATION,$offset);	 
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and brand.brand_name LIKE "%'.trim($search).'%" '; 
		} 	 
		if($status!=""){
			if($status==1){  
			$where .= ' and brand.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and brand.publication_status ="0"  ';  
			}
		} 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}

	public function get_brand_count($search='',$status='') {          
		$this->db->select('brand.*')
		->from('dir_brand as brand')  
		->where('brand.deletion_status', 0)
		->order_by('brand.brand_id', 'desc');	 
		
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and brand.brand_name LIKE "%'.trim($search).'%" '; 
		} 	
		if($status!=""){
			if($status==1){  
			$where .= ' and brand.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and brand.publication_status ="0"  ';  
			}
		}
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}
	
	
    public function store_brand($data) { 
        $this->db->insert($this->_brand, $data); 
        return $this->db->insert_id(); 
    }  

    public function get_brand_by_brand_id($brand_id) {
        $result = $this->db->get_where($this->_brand, array('brand_id' => $brand_id, 'deletion_status' => 0));
        return $result->row_array();
    }

    public function published_brand_by_id($brand_id) {
        $this->db->update($this->_brand, array('publication_status' => 1), array('brand_id' => $brand_id));
        return $this->db->affected_rows();
    }

    public function unpublished_brand_by_id($brand_id) {
        $this->db->update($this->_brand, array('publication_status' => 0), array('brand_id' => $brand_id));
        return $this->db->affected_rows();
    }

    public function update_brand($brand_id, $data) {
        $this->db->update($this->_brand, $data, array('brand_id' => $brand_id));
        return $this->db->affected_rows();
    }

    public function remove_brand_by_id($brand_id) {
        $this->db->update($this->_brand, array('deletion_status' => 1), array('brand_id' => $brand_id));
        return $this->db->affected_rows();
    }
}
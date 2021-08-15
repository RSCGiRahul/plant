<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Delivery_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_delivery = 'dir_delivery';  

	public function get_outlet_list() {          
		
		$this->db->select('outlet.*')
		->from('dir_outlet as outlet')  
		->where('outlet.publication_status', 1)
		->where('outlet.deletion_status', 0)
		->order_by('outlet.outlet_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}	
	
	public function get_delivery_list() {          
		
		$this->db->select('delivery.*')
		->from('dir_delivery as delivery')  
		->where('delivery.publication_status', 1)
		->where('delivery.deletion_status', 0)
		->order_by('delivery.delivery_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	
	
	public function get_delivery_info($page=1,$search="",$status='') {          
		if($page<1){ 
			$page=1; 
		}  
		$offset = ($page - 1) * PAGINATION; 
		$this->db->select('delivery.*')
		->from('dir_delivery as delivery')  
		->where('delivery.deletion_status', 0)
		->order_by('delivery.delivery_id', 'desc')
		->limit(PAGINATION,$offset);	 
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and delivery.delivery_name LIKE "%'.trim($search).'%" '; 
		} 	 
		if($status!=""){
			if($status==1){  
			$where .= ' and delivery.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and delivery.publication_status ="0"  ';  
			}
		} 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}

	public function get_delivery_count($search='',$status='') {          
		$this->db->select('delivery.*')
		->from('dir_delivery as delivery')  
		->where('delivery.deletion_status', 0)
		->order_by('delivery.delivery_id', 'desc');	 
		
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and delivery.delivery_name LIKE "%'.trim($search).'%" '; 
		} 	
		if($status!=""){
			if($status==1){  
			$where .= ' and delivery.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and delivery.publication_status ="0"  ';  
			}
		}
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}
	
	
    public function store_delivery($data) { 
        $this->db->insert($this->_delivery, $data); 
        return $this->db->insert_id(); 
    }  

    public function get_delivery_by_delivery_id($delivery_id) {
        $result = $this->db->get_where($this->_delivery, array('delivery_id' => $delivery_id, 'deletion_status' => 0));
        return $result->row_array();
    }

    public function published_delivery_by_id($delivery_id) {
        $this->db->update($this->_delivery, array('publication_status' => 1), array('delivery_id' => $delivery_id));
        return $this->db->affected_rows();
    }

    public function unpublished_delivery_by_id($delivery_id) {
        $this->db->update($this->_delivery, array('publication_status' => 0), array('delivery_id' => $delivery_id));
        return $this->db->affected_rows();
    }

    public function update_delivery($delivery_id, $data) {
        $this->db->update($this->_delivery, $data, array('delivery_id' => $delivery_id));
        return $this->db->affected_rows();
    }

    public function remove_delivery_by_id($delivery_id) {
        $this->db->update($this->_delivery, array('deletion_status' => 1), array('delivery_id' => $delivery_id));
        return $this->db->affected_rows();
    }
}
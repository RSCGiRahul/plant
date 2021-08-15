<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Outlet_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_outlet = 'dir_outlet';    
	
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
	
	public function get_outlet_info($page=1,$search="",$status='') {          
		if($page<1){ 
			$page=1; 
		}  
		$offset = ($page - 1) * PAGINATION; 
		$this->db->select('outlet.*')
		->from('dir_outlet as outlet')  
		->where('outlet.deletion_status', 0)
		->order_by('outlet.outlet_id', 'desc')
		->limit(PAGINATION,$offset);	 
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and outlet.outlet_name LIKE "%'.trim($search).'%" '; 
		} 	 
		if($status!=""){
			if($status==1){  
			$where .= ' and outlet.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and outlet.publication_status ="0"  ';  
			}
		} 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}

	public function get_outlet_count($search='',$status='') {          
		$this->db->select('outlet.*')
		->from('dir_outlet as outlet')  
		->where('outlet.deletion_status', 0)
		->order_by('outlet.outlet_id', 'desc');	 
		
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and outlet.outlet_name LIKE "%'.trim($search).'%" '; 
		} 	
		if($status!=""){
			if($status==1){  
			$where .= ' and outlet.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and outlet.publication_status ="0"  ';  
			}
		}
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}
	
	
    public function store_outlet($data) { 
        $this->db->insert($this->_outlet, $data); 
        return $this->db->insert_id(); 
    }  

    public function get_outlet_by_outlet_id($outlet_id) {
        $result = $this->db->get_where($this->_outlet, array('outlet_id' => $outlet_id, 'deletion_status' => 0));
        return $result->row_array();
    }

    public function published_outlet_by_id($outlet_id) {
        $this->db->update($this->_outlet, array('publication_status' => 1), array('outlet_id' => $outlet_id));
        return $this->db->affected_rows();
    }

    public function unpublished_outlet_by_id($outlet_id) {
        $this->db->update($this->_outlet, array('publication_status' => 0), array('outlet_id' => $outlet_id));
        return $this->db->affected_rows();
    }

    public function update_outlet($outlet_id, $data) {
        $this->db->update($this->_outlet, $data, array('outlet_id' => $outlet_id));
        return $this->db->affected_rows();
    }

    public function remove_outlet_by_id($outlet_id) {
        $this->db->update($this->_outlet, array('deletion_status' => 1), array('outlet_id' => $outlet_id));
        return $this->db->affected_rows();
    }
}
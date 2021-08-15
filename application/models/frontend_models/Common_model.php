<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CC_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users'; 
	
	public function get_settings_info(){
        $result = $this->db->get($this->_settings); 
        return $result->row_array(); 
    }
	public function get_userinfo_by_id($user_id) { 
         $result = $this->db->join('tbl_state state','state.zipcode = '.$this->_users.'.zipcode', 'left')->get_where($this->_users, array('user_id' => $user_id,'deletion_status' => 0));
        return $result->row_array(); 
    }
	
	
	public function get_home_content() {          
		
		$this->db->select('homesetting.*')
		->from('dir_homesetting as homesetting')  
		->where('homesetting.publication_status', 1) 
		->order_by('homesetting.sort_order', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
}
?>
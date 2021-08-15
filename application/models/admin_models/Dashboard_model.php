<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* #********************************************#
  #                   codingmaker             #
  #*********************************************#
  #      Author:     codingmaker              #
  #      Email:      info@codingmaker.com     #
  #      Website:    http://codingmaker.com   #
  #                                             #
  #      Version:    1.0.0                      #
  #      Copyright:  (c) 2018 - codingmaker   #
  #                                             #
  #*********************************************# */

class Dashboard_model extends CC_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_listing = 'dir_listing';
    private $_cat = 'dir_categories';
    private $_city = 'dir_cities';
    private $_users = 'tbl_users';
	 private $_classified = 'dir_classified';
	  private $_events = 'dir_event';

    public function count_total_listing() {
        $result = $this->db->get_where($this->_listing, array('deletion_status' => 0));
        return $result->num_rows();
    }
    
    public function count_total_users() {
        $result = $this->db->get_where($this->_users, array('deletion_status' => 0));
        return $result->num_rows();
    }
	
	 public function count_total_classified() {
        $result = $this->db->get_where($this->_classified, array('deletion_status' => 0));
        return $result->num_rows();
    }
	
	public function count_total_events() {
        $result = $this->db->get_where($this->_events, array('deletion_status' => 0));
        return $result->num_rows();
    }
	
    
    public function count_total_categories() {
        $result = $this->db->get_where($this->_cat, array('deletion_status' => 0));
        return $result->num_rows();
    }
    
    public function count_total_cities() {
        $result = $this->db->get_where($this->_city, array('deletion_status' => 0));
        return $result->num_rows();
    }

}

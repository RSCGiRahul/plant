<?php

//dir_product_wholesale

defined('BASEPATH') OR exit('No direct script access allowed');


class ProductWholeSale_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    }
   private $_table = 'dir_product_wholesale';  

     public function store($data) { 
        $this->db->insert($this->_table, $data); 
        return $this->db->insert_id(); 
    } 

}
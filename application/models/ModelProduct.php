<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelProduct extends CC_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users'; 
	private $_cat = 'dir_categories'; 
    private $table = 'dir_product';




    public function getProductByCategory()
    {
       $result =  $this->db->select('*')
                ->from("$this->table as p")
                ->join('dir_categories as cat', 'cat.category_id = p.product_sub_category', 'left') 
                ->join('dir_product_wholesale as w', 'w.product_id = p.product_id', 'left') 
                // ->join('dir', 'left')
                ->where('p.deletion_status',0)
                ->where('cat.deletion_status',0)
                ->get();
return $result->result_array();


    }
	



}
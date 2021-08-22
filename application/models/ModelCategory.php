<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelCategory extends CC_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users'; 
	private $_cat = 'dir_categories'; 
    private $table = 'dir_categories';


    public function getCategryProduct()
    {
        $result = $this->db->select('*')
        ->from('dir_categories as c')
        ->join('dir_product as p',  'c.category_id = p.product_sub_category')
        ->join('dir_product_wholesale as w', 'w.product_id = p.product_id', 'left') 
        ->join('dir_product_price_option as po', 'po.product_id = p.product_id', 'left') 
        ->where('p.deletion_status', 0)
        ->get();

        return $result->result_array();


    }

    public function getCategoryProductArray()
    {
        $result = $this->getCategryProduct();
        $final = [];
        foreach( $result as $res)
        {
            $final[$res['category_id']][] = $res; 

        }
        return $final;
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CC_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users'; 
	private $_cat = 'dir_categories'; 
	
	 
	 
	public function get_parent_category_by_id($category_id) {          
		
		$this->db->select('data.*')
		->from('dir_categories_relation as data')  
		->join('dir_categories as cat', 'cat.category_id = data.category_id') 
		->where('cat.publication_status', 1) 
		->where('data.category_id',$category_id) 
		->where('cat.deletion_status',0) 
		->order_by('data.level', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		
		
		
		if($result){ $result = $result[0]['path_id']; }
		return $result;
	}
	 
	public function dir_side_categories($category_id) {    
		$get_categories_info = $this->CC_Model->get_all_categories_info(); 
		
		$ref   = [];
		$categories_info = [];
		foreach($get_categories_info as $info) {
			$thisRef = &$ref[$info['category_id']];
			$thisRef['parent_id'] = $info['parent_id'];
			
			$thisRef['category_id'] = $info['category_id'];
			$thisRef['category_name'] = $info['category_name'];
			$thisRef['seo_url'] = $info['seo_url']; 
			
			 
			if($info['parent_id'] == 0) {
			$categories_info[$info['category_id']] = &$thisRef;
			} else {
			$ref[$info['parent_id']]['child'][$info['category_id']] = &$thisRef;
			} 
		}  
		return $ref;
	} 
	 
	public function dir_main_categories() {          
		
		$this->db->select('cat.*')
		->from('dir_categories as cat')  
		->where('cat.publication_status', 1) 
		->where('cat.parent_id',0) 
		->where('cat.deletion_status',0) 
		->order_by('cat.category_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function dir_all_categories() {          
		
		$this->db->select('cat.*')
		->from('dir_categories as cat')  
		->where('cat.publication_status', 1) 
		->where('cat.deletion_status',0) 
		->order_by('cat.category_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function dir_categories_by_parent_id($category_id) {          
		
		$this->db->select('cat.*')
		->from('dir_categories as cat')  
		->where('cat.publication_status', 1) 
		->where('cat.parent_id',$category_id) 
		->where('cat.deletion_status',0) 
		->order_by('cat.category_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_categories_list_in($categories) {          
		
		$this->db->select('cat.*')
		->from('dir_categories as cat')  
		->where('cat.publication_status', 1) 
		->where('cat.deletion_status',0) 
		->order_by('cat.category_id', 'asc');	

		$where =' `cat`.`category_id` IN('.$categories.') ';   
		$this->db->where( $where ); 		
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
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
	
	public function get_brand_list_in($filter_brand) {          
		
		$this->db->select('brand.*')
		->from('dir_brand as brand')  
		->where('brand.publication_status', 1)
		->where('brand.deletion_status', 0)
		/* ->where_in('brand.brand_id', $filter_brand) */
		->order_by('brand.brand_id', 'asc'); 
		$where =' `brand`.`brand_id` IN('.$filter_brand.') ';   
		$this->db->where( $where ); 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		
		return $result;
	}
	
	
	public function get_category_by_id($seo_url) {
		
		$this->db->where('seo_url', $seo_url);
		$this->db->or_where('category_id', $seo_url); 
        $result = $this->db->get_where($this->_cat, array( 'deletion_status' => 0)); 
        return $result->row_array();
    }
	
	
	
	
	public function product_details_by_slug($seo_url) {
        $result = $this->db->get_where('dir_product', array('seo_url' => $seo_url, 'publication_status' => 1, 'deletion_status' => 0));
        return $result->row_array();
    } 
	
	public function dir_products_by_category_id($category_id,$page=1) {          
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		 
		
		$query_path="SELECT * FROM dir_categories_relation where path_id IN (".$category_id.") ";
		$sql_path = $this->db->query($query_path);
		$result_path=$sql_path->result_array();  
		foreach($result_path as $path){
		  $categories_relation=$path['category_id'];
		  $filter_category[]=$categories_relation; 
		}
		$filter_category[]= $category_id;
		
		$this->db->select('product.*')
		->from('dir_product as product')  
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->order_by('product.product_id', 'desc')
		->limit($PAGINATION,$offset);	 
		
		if(!empty($filter_category)) 
		{ 
			$condition='';  
			foreach($filter_category as $filter){  
				$condition .=" FIND_IN_SET('".$filter."',product.product_sub_category ) OR"; 
			}
			$condition=trim($condition,"OR"); 
			$where =' ('.$condition.') ';   
			$this->db->where( $where );
		} 
		
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();  
		 
		
		return $result;
	}
	
	public function dir_products_by_category_id_count($category_id,$page=1) { 
	 
		$this->db->select('product.*')
		->from('dir_product as product')  
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0)  
		->order_by('product.product_id', 'asc');	 
		 
		 
		 $query_path="SELECT * FROM dir_categories_relation where path_id IN (".$category_id.") ";
		$sql_path = $this->db->query($query_path);
		$result_path=$sql_path->result_array();  
		foreach($result_path as $path){
		  $categories_relation=$path['category_id'];
		  $filter_category[]=$categories_relation; 
		}
		$filter_category[]= $category_id;
		
		if(!empty($filter_category)) 
		{ 
			$condition='';  
			foreach($filter_category as $filter){  
				$condition .=" FIND_IN_SET('".$filter."',product.product_category ) OR"; 
			}
			$condition=trim($condition,"OR"); 
			$where =' ('.$condition.') ';   
			$this->db->where( $where );
		}
		 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}
	
	public function get_product_by_product_id($product_id) {
        $result = $this->db->get_where('dir_product', array('product_id' => $product_id, 'deletion_status' => 0,'publication_status' => 1));
        return $result->row_array();
    }
	
	
	public function related_products_by_category_id($productcategory) { 
		
		$product_category = explode(",",$productcategory);	
		
		$this->db->select('product.*')
		->from('dir_product as product')  
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		
		/* ->where('FIND_IN_SET("'.$category_id.'", product.product_category)') */ 
		->order_by('product.product_id', 'asc')
		->limit(4);	 
		
		
		 $where = ' 1=1';
		
		if($product_category!=""){
			  
			   $where .= '   and( ';  
			   $i=0;
			 foreach($product_category as $category_id){
			   $i=$i+1;
			   if($i!=1){ $where .= ' OR '; }
			   $where .= '  FIND_IN_SET("'.$category_id.'", product.product_category)  ';  
			  }
			   $where .= '   ) ';  
		} 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return ($result);
	}
	
	public function get_filter_products($search,$page=1,$order_by='desc') { 
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$category_id = $search['category_id'];
		$orderby = $search['orderby']; 
		
		
		$filter_orderby = 'product.product_id';
		$filter_order = 'desc';
		
		if($orderby=='date-desc'){
			$filter_orderby = 'product.date_added';
			$filter_order = 'desc'; 
		}
		
		if($orderby=='price'){
			$filter_orderby = 'product.sort_price';
			$filter_order = 'asc'; 
		}
		 
		if($orderby=='price-desc'){
			$filter_orderby = 'product.sort_price';
			$filter_order = 'desc'; 
		} 
		
		if($orderby=='popularity'){
			$filter_orderby = 'product.sort_popularity';
			$filter_order = 'desc'; 
		}
		
		
		
		
		 
		 $this->db->select('product.*')
		->from('dir_product as product')  
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		
		->order_by($filter_orderby, $filter_order)
		->limit($PAGINATION,$offset);	 
		
		
		
		
		
		$where = ' 1=1';
		if($search['brand_search']!=""){
			  
			   $where .= '   and( ';  
			   $i=0;
			  foreach($search['brand_search'] as $brand_search){
			   $i=$i+1;
			   if($i!=1){ $where .= ' OR '; }
			   $where .= '  `product`.`brand_id`= "'.$brand_search.'"    ';  
			  }
			   $where .= '   ) ';  
		} 
		
		
		if($search['price_search']!=""){
			
			 $where .= '   and( ';  
			   $i=0;
			  foreach($search['price_search'] as $price_search){
			   $i=$i+1;
			   if($i!=1){ $where .= ' OR '; }
			   
			   $ex_price = explode("-",$price_search);
			   $ex_price_0 = $ex_price[0];
			   $ex_price_1 = $ex_price[1];
			   
			   $where .= '  `product`.`sort_price` BETWEEN  "'.$ex_price_0.'"  and  "'.$ex_price_1.'"   ';  
			  
			  }
			   $where .= '   ) '; 
			
			
		} 
		
		if($search['discount_search']!=""){
			
			 $where .= '   and( ';  
			   $i=0;
			  foreach($search['discount_search'] as $discount_search){
			   $i=$i+1;
			   if($i!=1){ $where .= ' OR '; }
			   
			   $ex_discount = explode("-",$discount_search);
			   $ex_discount_0 = $ex_discount[0];
			   $ex_discount_1 = $ex_discount[1];
			   
			   $where .= '  `product`.`sort_discount` BETWEEN  "'.$ex_discount_0.'"  and  "'.$ex_discount_1.'"   ';  
			  
			  }
			   $where .= '   ) '; 
			
			
		} 
		
		$this->db->where( $where ); 			
		
		
		
		
		
		/**/
			if($category_id){
			    $query_path="SELECT * FROM dir_categories_relation where path_id IN (".$category_id.") ";
				$sql_path = $this->db->query($query_path);
				$result_path=$sql_path->result_array();  
				foreach($result_path as $path){
				  $categories_relation=$path['category_id'];
				  $filter_category[]=$categories_relation; 
				}
			    $filter_category[]= $category_id;
			}
			
			if(!empty($filter_category)) 
			{ 
				$condition='';  
				foreach($filter_category as $filter){  
					$condition .=" FIND_IN_SET('".$filter."',product.product_category ) OR"; 
				}
				$condition=trim($condition,"OR"); 
				$where =' ('.$condition.') ';   
				$this->db->where( $where );
			}
		/**/
		
		
		if($search['t']=='offer'){
				$where =' (product.sort_discount!=0 and  product.sort_discount!="") ';   
				$this->db->where( $where );
		}
		
		if($search['s']!=''){
				$where =' (product.product_name LIKE "%'.$search['s'].'%") ';   
				$this->db->where( $where );
		}
		
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		
		file_put_contents('array_data.txt',print_r( $this->db->last_query() ,true));
		
        return $result; 
    }
	
	
	
	public function get_filter_products_count($search) { 
		
		
		
		$category_id = $search['category_id'];
		
		 
		 $this->db->select('product.*')
		->from('dir_product as product')  
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		/* ->where('FIND_IN_SET("'.$category_id.'", product.product_category)') */
		->order_by('product.product_id', 'asc');	 
		
		$where = ' 1=1';
		if($search['brand_search']!=""){
			  
			   $where .= '   and( ';  
			   $i=0;
			  foreach($search['brand_search'] as $brand_search){
			   $i=$i+1;
			   if($i!=1){ $where .= ' OR '; }
			   $where .= '  `product`.`brand_id`= "'.$brand_search.'"    ';  
			  }
			   $where .= '   ) ';  
		} 
		
		if($search['price_search']!=""){
			
			 $where .= '   and( ';  
			   $i=0;
			  foreach($search['price_search'] as $price_search){
			   $i=$i+1;
			   if($i!=1){ $where .= ' OR '; }
			   
			   $ex_price = explode("-",$price_search);
			   $ex_price_0 = $ex_price[0];
			   $ex_price_1 = $ex_price[1];
			   
			   $where .= '  `product`.`sort_price` BETWEEN  "'.$ex_price_0.'"  and  "'.$ex_price_1.'"   ';  
			  
			  }
			   $where .= '   ) '; 
			
			
		} 
		
		if($search['discount_search']!=""){
			
			 $where .= '   and( ';  
			   $i=0;
			  foreach($search['discount_search'] as $discount_search){
			   $i=$i+1;
			   if($i!=1){ $where .= ' OR '; }
			   
			   $ex_discount = explode("-",$discount_search);
			   $ex_discount_0 = $ex_discount[0];
			   $ex_discount_1 = $ex_discount[1];
			   
			   $where .= '  `product`.`sort_discount` BETWEEN  "'.$ex_discount_0.'"  and  "'.$ex_discount_1.'"   ';  
			  
			  }
			   $where .= '   ) '; 
			
			
		} 
		
		$this->db->where( $where ); 		
		
		
		/**/
			if($category_id){
				$query_path="SELECT * FROM dir_categories_relation where path_id IN (".$category_id.") ";
				$sql_path = $this->db->query($query_path);
				$result_path=$sql_path->result_array();  
				foreach($result_path as $path){
				  $categories_relation=$path['category_id'];
				  $filter_category[]=$categories_relation; 
				}
				$filter_category[]= $category_id;
			}
			
			if(!empty($filter_category)) 
			{ 
				$condition='';  
				foreach($filter_category as $filter){  
					$condition .=" FIND_IN_SET('".$filter."',product.product_category ) OR"; 
				}
				$condition=trim($condition,"OR"); 
				$where =' ('.$condition.') ';   
				$this->db->where( $where );
			}
		/**/
		
		 if($search['t']=='offer'){
				$where =' (product.sort_discount!=0 and  product.sort_discount!="") ';   
				$this->db->where( $where );
		}
		if($search['s']!=''){
				$where =' (product.product_name LIKE "%'.$search['s'].'%") ';   
				$this->db->where( $where );
		}
		
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		 
	 
		
        return count($result); 
    }
	
	public function get_product_info($product_id) {
		
		$result = $this->db->get_where('dir_product', array('product_id' => $product_id, 'deletion_status' => 0));
        return $result->row_array();
    }
	
	public function get_product_by_cart_id($cart_id) {
		$result = $this->db->get_where('dir_cart', array('cart_id' => $cart_id));
        return $result->row_array();
    }
	
	public function get_product_by_wishlist_id($wishlist_id) {
		$result = $this->db->get_where('dir_wishlist', array('wishlist_id' => $wishlist_id));
        return $result->row_array();
    }
	
	
	
	
	public function get_dir_product_attribute($product_id) {          
		
		$this->db->select('product_attribute.*,attribute.attribute_name')
		->from('dir_product_attribute as product_attribute') 
		->join('dir_attribute as attribute', 'attribute.attribute_id = product_attribute.product_attribute_name') 
		->where('product_attribute.product_id', $product_id)
		->where('attribute.publication_status', 1)
		->order_by('product_attribute.sorting', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		
		
		
		return $result;
	}
	
}
?>
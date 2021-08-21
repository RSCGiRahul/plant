<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CC_Controller extends CI_Controller {

    function __construct() {
        parent::__construct(); 
        date_default_timezone_set('Asia/Kolkata');
		
		$this->load->model('CC_Model');
		
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

	public function get_settings_info() {
        
		$settings_info = $this->CC_Model->get_settings_info(); 
		return $settings_info;
    }

	public function get_common_data_info() {
        $common_data_info = array();
		
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
		
		$categories_info_menu=$this->get_menu($categories_info,'','');
		$categories_info_menu_mobile=$this->get_menu_mobile($categories_info,'','');
		$common_data_info['categories_info_menu'] =$categories_info_menu;    
		$common_data_info['categories_info_menu_mobile'] =$categories_info_menu_mobile;
		
		
		
		/**/
		
		$get_categories_infos= $this->CC_Model->get_all_categories_order_by(); 
		$footer_i=0;
		$footer_1= '';
		$footer_2= '';
		$footer_3= '';

		$footer_4= '';
		$footer_5= '';
		$footer_6= '';

		foreach($get_categories_infos as $menudata){
				
				$category_name = $menudata['category_name'];
				$seo_url = base_url().'category/'.$menudata['seo_url'];
				
				if($footer_i<3){
					$footer_1 .= '<li><a href="'.$seo_url.'">'.$category_name.'</a></li>';
				}else if($footer_i<6){				
					$footer_2 .= '<li><a href="'.$seo_url.'">'.$category_name.'</a></li>';
				}else if($footer_i<9){ 
					$footer_3 .= '<li><a href="'.$seo_url.'">'.$category_name.'</a></li>';
				}else if($footer_i<12){ 
					$footer_4 .= '<li><a href="'.$seo_url.'">'.$category_name.'</a></li>';
				} 
			$footer_i++;
		
		}
		
		$categories_footer_menu = '<div class="col-md-5">
                                    <div class="widget">
                                        <h4 class="widget-title">Categories</h4>
										
                                        <div class="row">
                                            
											<div class="col-sm-6 col-md-5">
                                                <ul class="links">
                                                    '.$footer_1.'
                                                </ul>
                                            </div> 
                                            <div class="col-sm-6 col-md-5">
                                                <ul class="links"> 
                                                   '.$footer_2.'
                                                </ul>
                                            </div>
											
                                        </div> 
                                    </div> 
                                </div> 

                                <div class="col-md-7">
                                    <div class="widget">
                                        <h4 class="widget-title">Categories</h4>
                                        
                                        <div class="row">
											 <div class="col-sm-6 col-md-5">
                                                <ul class="links">
                                                    '.$footer_3.'
                                                </ul>
                                            </div> 
                                            <div class="col-sm-6 col-md-5">
                                                <ul class="links"> 
                                                   '.$footer_4.'
                                                </ul>
                                            </div>
											
                                        </div> 
                                    </div> 
                                </div> 
								';
		
		$common_data_info['categories_footer_menu'] = $categories_footer_menu;
		/**/

		
		/*car_popup*/
		$get_cart_info = $this->CC_Model->get_cart_info(); 
		
		
		
		$cart_total = count($get_cart_info);
		$quantity = 0;
		foreach($get_cart_info as $cart_info){	
		  $quantity = $quantity  + $cart_info['quantity'];
		}
		
		$car_popup = '';
		$car_popup .= '<a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <span class="basket-style">Cart &nbsp;&nbsp;&nbsp;</span>
                                <span class="basket-style" class="popup_cart_total">'.$quantity.' item</span>
                            </a>';

         $car_popup .= '<div class="dropdown-menu" >
                                <div class="dropdownmenu-wrapper">
                                    <div class="dropdown-cart-products">';
									
									 $total=0;	
									 $total_discount_price=0;	
									 
									 if(count($get_cart_info)<=0){
									   $car_popup .= '<div class="row no-gutters align-items-center"><div class="col-sm-12"><p class="text-center">No product found</p></div></div>'; 
									 }
									 
									 foreach($get_cart_info as $cart_info){	
									 
										$regular_price = $cart_info['quantity']*$cart_info['regular_price'];
										$price =$cart_info['quantity']*$cart_info['price'];
										$discount_price = ($price-$regular_price);
										
										
										$total= $total+$regular_price;
										$total_discount_price= $total_discount_price+$discount_price;
										
										
									  $product_id = $cart_info['product_id'];
									  $product_info = $this->CC_Model->get_product_info($product_id);
									  
									   $gallery_featured = $product_info['gallery_featured'];
										if($gallery_featured==""){
											$product_images = json_decode($product_info['product_images']);
											$gallery_featured = $product_images[0];
										}
										
										$productImg=base_url('assets/uploads/product/'.$gallery_featured.'');
									  
									 
                                      $car_popup .= '  
									  
											<div class="row no-gutters align-items-center" id="popup_cart_'.$cart_info['cart_id'].'" >
                                            <div class="col-md-2">
                                                <img src="'.$productImg.'" alt="" class="img-fluid">
                                            </div>
                                            <div class="col-md-5">
                                                <span class="product-basket">'.$cart_info['product_title'].'</span>
                                                <!--<span class="product-basket">'.$cart_info['quantity'].' x '.($cart_info['quantity']*$cart_info['regular_price']).'</span>-->
                                            </div>
											
                                             <div class="col-md-2">
                                                        <div class="input-group number-spinner">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-default btn-quantity-minus" cart_id="'.$cart_info['cart_id'].'" data-dir="dwn">-</button>
                                                                </span>
                                                                <input type="text" id="cart_id_'.$cart_info['cart_id'].'" class="form-control text-center" value="'.$cart_info['quantity'].'">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-default btn-quantity-add" cart_id="'.$cart_info['cart_id'].'" data-dir="up">+</button>
                                                                </span>
                                                            </div>
                                               </div>
											   
                                                    <div class="col-md-3 text-right">
                                                            <ul>
                                                                <li><span class="product-basket">'.(CURRENCY.$regular_price).'</span>';
																	
																	if($discount_price>0){
                                                                     $car_popup .= ' <span class="product-basket" style="color:green;">Saved '.CURRENCY.$discount_price.'</span></li>';
																	}
																	
                                                                    $car_popup .= '<li><i cart_id="'.$cart_info['cart_id'].'" class="btn-remove-cart fas fa-times"></i></li>
                                                            </ul>
                                                            
                                                        </div>
                                        </div> 
                                    ';
									
									 }
									
								if(count($get_cart_info)>0){
                                   $car_popup .= ' </div><div class="custom-cart">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <span class="delivery-charges">Actual delivery charges checkout</span>
                                            </div>
                                            <div class="col-md-7">
                                                <ul>
                                                    <li>Sub total<span>'.CURRENCY.$total.'</span></li>
                                                    <!-- <li>Delivery Charges <span>***</span></li> -->
                                                </ul>
                                                    <a href="'.base_url('/cart').'" class="btn">View Basket And Checkout</a>
                                            </div>
                                        </div>
                                        
                                    ';
								}	
									
									
									
                             $car_popup .= '    </div></div> 
                            </div> 
							';	;
		
		
		$common_data_info['car_popup'] = $car_popup;
			
		/*car_popup*/

		
		return $common_data_info;
    }
	 
	 
	/*menu*/
	public function get_menu($items,$class,$id) {
		
		$html = '';
		$i=0;
		// href="'.base_url().'category/'.$articles_in['seo_url'].'"
		foreach($items as $key=>$articles_in) {
				
				$html.= '
				 <li>
				 <a href="javascript::void(0)" >
					'.$articles_in['category_name'].' 
				 </a>
				'; 
				
					if(array_key_exists('child',$articles_in)) {
						
						 $html .= $this->get_sub_menu($articles_in['child'],'category_ul_'.$articles_in['category_id'].'','hover-div');
					}
				
				$html .= "</li>"; 
				 
				  $i=$i+1;
			
		}
		
		$html .= "";
			
		return $html;
	}
	
	public function get_sub_menu($items,$id,$class) {
							
			$html = '<div class="'.$class.'"><ol>';
			 
			 foreach($items as $key=>$articles_in) {
				 
					$html.= '
						<li><a href="'.base_url().'category/'.$articles_in['seo_url'].'" >'.$articles_in['category_name'].'</a>
						';
						
						if(array_key_exists('child',$articles_in)) {
							 $html .= $this->get_sub_menu($articles_in['child'],'category_ul_'.$articles_in['category_id'].'','hover-div-1');
						 }
						 
					 $html .= "</li>"; 
			 }
			 
			 
			$html .= "</ol></div>";
			
			return $html;
	}
	
	/*menu*/	
	
	
	/*menu mobile*/
	public function get_menu_mobile($items,$class,$id) {
		
		$html = '';
		$i=0;
		foreach($items as $key=>$articles_in) {
				
				
				if(array_key_exists('child',$articles_in)) { 
				
					$href= 'javascript:;'; 
				
				}else{ 
					$href= ''.base_url().'category/'.$articles_in['seo_url'].''; 
				}
				
				$html.= '
				 <li>
				 <a href="'.$href.'" >
					'.$articles_in['category_name'].' 
				 </a>
				'; 
				
					if(array_key_exists('child',$articles_in)) {
						
						 $html .= $this->get_sub_menu_mobile($articles_in['child'],'category_ul_'.$articles_in['category_id'].'','');
					}
				
				$html .= "</li>"; 
				 
				  $i=$i+1;
			
		}
		
		$html .= "";
			
		return $html;
	}
	
	public function get_sub_menu_mobile($items,$id,$class) {
							
			$html = '<ul>';
			 
			 foreach($items as $key=>$articles_in) {
				 
					if(array_key_exists('child',$articles_in)) { 
					
						$href= 'javascript:;'; 
					
					}else{ 
						$href= ''.base_url().'category/'.$articles_in['seo_url'].''; 
					}
					
					$html.= '
						<li><a href="'.$href.'" >'.$articles_in['category_name'].'</a>
						';
						
						if(array_key_exists('child',$articles_in)) {
							 $html .= $this->get_sub_menu_mobile($articles_in['child'],'category_ul_'.$articles_in['category_id'].'','hover-div-1');
						 }
						 
					 $html .= "</li>"; 
			 }
			 
			 
			$html .= "</ul>";
			
			return $html;
	}
	
	/*menu mobile*/	
	

    public function user_login_authentication() {
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
    }

    public function super_admin_authentication_only() {
        $access_label = $this->session->userdata('access_label');
        if ($access_label != 1) {
            redirect('dashboard', 'refresh');
        }
    }

    public function super_admin_news_editor_and_news_reporter_authentication_only() {
        $access_label = $this->session->userdata('access_label');
        if ($access_label == 1 || $access_label == 2 || $access_label == 3) {
            return True;
        } else {
            redirect('admin-dashboard', 'refresh');
        }
    }

    public function super_admin_and_news_editor_authentication_only() {
        $access_label = $this->session->userdata('access_label');
        if ($access_label == 1 || $access_label == 2) {
            return True;
        } else {
            redirect('admin-dashboard', 'refresh');
        }
    }

    public function super_admin_and_news_reporter_authentication_only() {
        $access_label = $this->session->userdata('access_label');
        if ($access_label == 1 || $access_label == 3) {
            return True;
        } else {
            redirect('admin-dashboard', 'refresh');
        }
    }

    public function super_admin_and_comment_reviewer_authentication_only() {
        $access_label = $this->session->userdata('access_label');
        if ($access_label == 1 || $access_label == 4) {
            return True;
        } else {
            redirect('admin-dashboard', 'refresh');
        }
    }

}

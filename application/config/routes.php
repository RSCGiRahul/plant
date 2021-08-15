<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  $route['default_controller'] = 'Home';
  //$route['default_controller'] = 'admin/admin_login/index';
  $route['404_override'] = '';
  $route['translate_uri_dashes'] = FALSE;
  
  $route['admin'] = "admin/admin_login/index";
  $route['admin/dashboard'] = "admin/dashboard/index";
  $route['logout'] = "admin/logout/index";
  
 
  //Categories
  $route['admin/categories'] = "admin/categories/index";
  $route['admin/categories/add_category'] = "admin/categories/add_category";
  $route['admin/categories/edit_category/(:any)'] = "admin/categories/edit_category/$1";
  
  //Products
  
  $route['admin/products'] = "admin/products/index";
  $route['admin/products/add_product'] = "admin/products/add_product";
  $route['admin/products/edit_product/(:any)'] = "admin/products/edit_product/$1";
  
  
  
  //frontend
  
  //category
  $route['category'] = 'products/index';  
  $route['category/(:any)'] = 'products/category/$1';  
  $route['product/details/(:any)'] = 'products/details/$1';  
  
  $route['cart'] = 'cart/index'; 
  
  $route['user/order/info/(:any)'] = 'user/account/info/$1';  
  
?>
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CC_Controller { 
    public function __construct() {
      parent::__construct();
        // Check Login Status
      $this->user_login_authentication();
      $this->load->model('admin_models/dashboard_model', 'dash_mdl');	
         
    }

    public function index() {
      $data = array();
      $data['title'] = 'Dashboard';
      $data['active_menu'] = 'dashboard';
      $data['active_sub_menu'] = '';
      $data['active_sub_sub_menu'] = '';
	  
      $data['total_listing'] = 1;
      $data['total_users'] = 10;
      $data['total_classified'] = 10;
      $data['total_events'] = 100;
      
      $data['total_categories'] = 200;
      $data['total_cities'] = 3000;
      $data['all_notifications']= 400;
	  
      $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
      $data['main_content'] = $this->load->view('admin_views/dashboard/dashboard_v', '', TRUE);
      $this->load->view('admin_views/admin_master_v', $data);
    }		
	
	
   
   
}

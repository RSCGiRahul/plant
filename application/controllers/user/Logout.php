<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Logout extends CC_Controller {  
    public function __construct() {
        parent::__construct(); 
        $customer_id = $this->session->userdata('customer_id');
        if ($customer_id == NULL) { 
            redirect('/', 'refresh');
        } 
    } 
    public function index() {
		
        $this->session->unset_userdata('customer_id');		/* $this->session->sess_destroy(); */  
         $sdata['success'] = "You have logged out! ";
         $this->session->set_userdata($sdata); 
        redirect('/'); 
    }  
} 
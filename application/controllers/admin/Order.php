<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Order extends CC_Controller { 
	  
    public function __construct() {
        parent::__construct(); 
        $this->user_login_authentication(); 
        $this->load->model('admin_models/order_model', 'order_mdl');
		$this->load->model('mailer_models/mailer_model', 'mail_mdl');
		$this->load->model('admin_models/outlet_model', 'outlet_mdl');
    }

    public function index() { 		
        $data = array();
        $data['title'] = 'Manage Order';
        $data['active_menu'] = 'order';
        $data['active_sub_menu'] = 'order';
        $data['active_sub_sub_menu'] = ''; 

		$page = $_REQUEST['currentpage']; 
		$search = $_REQUEST['search'];
		$status = $_REQUEST['status'];
		$payment = $_REQUEST['payment'];
		if($payment==""){
			$payment = 'success';
		}
		
		$data['order_status'] = $this->order_mdl->get_order_status();
		
		$data['order_info'] = $this->order_mdl->get_order_info($page,$search,$status,$payment);
		$data['order_count'] = $this->order_mdl->get_order_count($search,$status,$payment);		
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/order/manage_order_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
	
	public function info($order_id) { 
		$data = array();
    	$data['title'] = 'Order Details'; 
		$data['seo_title'] = '';  
		$data['seo_keywords'] = '';  
		$data['seo_description'] = '';  
		
		$settings_info = $this->get_settings_info();
		$data['settings_info'] = $settings_info;   
		$common_data_info = $this->get_common_data_info();
		$data['common_data_info'] = $common_data_info;  
		
		$data['order_status'] = $this->order_mdl->get_order_status();
		
		
		$data['order_info'] = $order_info = $this->order_mdl->get_order_by_order_id($order_id);
		$data['order_product'] = $this->order_mdl->get_order_product_by_order_id($order_id);
		$data['order_history'] = $this->order_mdl->get_order_history_by_order_id($order_id);
		
		$outlet_info = $this->outlet_mdl->get_outlet_by_outlet_id($order_info['outlet_id']);
		if($outlet_info){
		 $data['outlet_info'] = $outlet_info;
		}
		
		$data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/order/view_order_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
			
    }

    
	public function update_order($order_id) { 
		$order_info = $this->order_mdl->get_order_by_order_id($order_id);
		if (!empty($order_info)) {
            
			
			$data_order_history = array();
			$data_order_history['order_id'] = $order_id;
			$data_order_history['customer_id'] = $order_info['customer_id'];
			$data_order_history['order_status'] = $this->input->post('order_status', TRUE); 
			$data_order_history['comment'] = $this->input->post('comment', TRUE); 
			$data_order_history['date_added'] = date('Y-m-d H:i:s'); 
			$this->order_mdl->store_order_history($data_order_history);

			$data_order = array();  
			$data_order['order_status'] = $this->input->post('order_status', TRUE); 
			$data_order['last_updated'] = date('Y-m-d H:i:s'); 
			
			
			/*mail*/
			$notify = $this->input->post('notify', TRUE); 
			if($notify == 1 and $order_info['email']!=""){
				
			$setting_info = $this->get_settings_info(); 
				
			$mdata = array();
			$mdata['from_address'] = $setting_info['email_address'];
			$mdata['to_address'] = $order_info['email']; 
			$mdata['site_name'] = $setting_info['site_name'];
			$mdata['web'] = $setting_info['web'];
			$mdata['hello_name'] = $order_info['firstname']." ".$order_info['lastname'];
			
			$mdata['subject'] = $setting_info['site_name'].' - Order Update'; 
			$mdata['title'] = ' Order Update'; 
			
			
			$message =  '<div>';
				$message .= '<p>Order id : '.$order_info['order_id'].'</p>';
				$message .= '<p>Your order has been updated to the following status: '.$data_order['order_status'].'</p>';
				
				if($this->input->post('comment', TRUE)){
				$message .= '<p>Comment: '.$this->input->post('comment', TRUE).'</p>';
				}
			$message .= '</div>';
			
			$mdata['message'] = $message; 
			
			
			$this->mail_mdl->sendEmail($mdata, 'basic_email');	
				
			}
			/*mail*/
			
			$result = $this->order_mdl->update_order($order_id,$data_order);
			
            if (!empty($result)) {
                $sdata['success'] = 'Order status add successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/order/info/'.$order_id.'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/order/info/'.$order_id.'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/order'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
		
		
	}

}

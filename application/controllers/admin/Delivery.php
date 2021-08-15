<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Delivery extends CC_Controller { 
	  
    public function __construct() {
        parent::__construct(); 
        $this->user_login_authentication(); 
        $this->load->model('admin_models/delivery_model', 'delivery_mdl');
    }

    public function index() { 		
        $data = array();
        $data['title'] = 'Manage Delivery';
        $data['active_menu'] = 'delivery';
        $data['active_sub_menu'] = 'delivery';
        $data['active_sub_sub_menu'] = ''; 

		$page = $_REQUEST['currentpage']; 
		$search = $_REQUEST['search'];
		$status = $_REQUEST['status'];
		$data['delivery_info'] = $this->delivery_mdl->get_delivery_info($page,$search,$status);
		$data['delivery_count'] = $this->delivery_mdl->get_delivery_count($search,$status);		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/delivery/manage_delivery_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function add_delivery() {
        $data = array();
        $data['title'] = 'Add Delivery';
        $data['active_menu'] = 'delivery';
        $data['active_sub_menu'] = 'add_delivery';
        $data['active_sub_sub_menu'] = ''; 	

		/* $data['associated_outlet'] = $this->delivery_mdl->get_outlet_list(); */		
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/delivery/add_delivery_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function create_delivery() { 
		
        $config = array(
            array(
                'field' => 'delivery_name',
                'label' => 'Delivery name',
                'rules' => 'trim|required|max_length[250]'
            ),       
			array(
				'field' => 'phone',
				'label' => 'Phone',
				'rules' => 'trim|required|max_length[250]'
			), 
			array(
				'field' => 'address',
				'label' => 'Address',
				'rules' => 'trim|required|max_length[250]'
			), 
			array(
				'field' => 'city',
				'label' => 'City',
				'rules' => 'trim|required|max_length[250]'
			),  
			array(
				'field' => 'zipcode',
				'label' => 'zipcode',
				'rules' => 'trim|required|max_length[250]'
			), 
			
            array(
                'field' => 'publication_status',
                'label' => 'publication status',
                'rules' => 'trim|required'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {  
			$this->add_delivery(); 
        } else {			
            $data['delivery_name'] = $this->input->post('delivery_name', TRUE); 
			$data['phone'] = $this->input->post('phone', TRUE);   
			$data['address'] = $this->input->post('address', TRUE);   
			$data['city'] = $this->input->post('city', TRUE);   
			$data['zipcode'] = $this->input->post('zipcode', TRUE);   
			/* $data['associated_outlet'] = $this->input->post('associated_outlet', TRUE);   */
			 
			 
			
			
            $data['publication_status'] = $this->input->post('publication_status', TRUE);
            $data['date_added'] = date('Y-m-d H:i:s');
			$insert_id = $this->delivery_mdl->store_delivery($data); 
            if (!empty($insert_id)) {
                $sdata['success'] = 'Add successfully . ';
                $this->session->set_userdata($sdata);
				redirect('admin/delivery', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/delivery', 'refresh');
            }
        }
    }

    public function published_delivery($delivery_id) {  
		
        $delivery_info = $this->delivery_mdl->get_delivery_by_delivery_id($delivery_id);
        if (!empty($delivery_info)) {
            $result = $this->delivery_mdl->published_delivery_by_id($delivery_id);
            if (!empty($result)) {
                $sdata['success'] = 'Published successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/delivery'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/delivery'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/delivery'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function unpublished_delivery($delivery_id) {  
	
        $delivery_info = $this->delivery_mdl->get_delivery_by_delivery_id($delivery_id);
        if (!empty($delivery_info)) {
            $result = $this->delivery_mdl->unpublished_delivery_by_id($delivery_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/delivery'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/delivery'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/delivery'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function edit_delivery($delivery_id) {
        $data = array();
        $data['delivery_info'] = $this->delivery_mdl->get_delivery_by_delivery_id($delivery_id); 
        if (!empty($data['delivery_info'])) {
            $data['title'] = 'Edit Delivery';
			$data['active_menu'] = 'delivery';
			$data['active_sub_menu'] = 'add_delivery';
            $data['active_sub_sub_menu'] = ''; 			
			
			/* $data['associated_outlet'] = $this->delivery_mdl->get_outlet_list(); */
			
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/delivery/edit_delivery_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data);
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/delivery', 'refresh');
        }
    }

    public function update_delivery($delivery_id) {
        $delivery_info = $this->delivery_mdl->get_delivery_by_delivery_id($delivery_id);
        if (!empty($delivery_info)) {
				$config = array(
            array(
                'field' => 'delivery_name',
                'label' => 'Delivery name',
                'rules' => 'trim|required|max_length[250]'
            ),       
			array(
				'field' => 'phone',
				'label' => 'Phone',
				'rules' => 'trim|required|max_length[250]'
			), 
			array(
				'field' => 'address',
				'label' => 'Address',
				'rules' => 'trim|required|max_length[250]'
			), 
			array(
				'field' => 'city',
				'label' => 'City',
				'rules' => 'trim|required|max_length[250]'
			),  
			array(
				'field' => 'zipcode',
				'label' => 'zipcode',
				'rules' => 'trim|required|max_length[250]'
			), 

			 
			
            array(
                'field' => 'publication_status',
                'label' => 'publication status',
                'rules' => 'trim|required'
            )
        );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $this->edit_delivery($delivery_id);
            } else {				
                $data['delivery_name'] = $this->input->post('delivery_name', TRUE); 
				$data['phone'] = $this->input->post('phone', TRUE);   
				$data['address'] = $this->input->post('address', TRUE);   
				$data['city'] = $this->input->post('city', TRUE);   
				$data['zipcode'] = $this->input->post('zipcode', TRUE);  
				/* $data['associated_outlet'] = $this->input->post('associated_outlet', TRUE);  				 */
				  
				
				$data['publication_status'] = $this->input->post('publication_status', TRUE); 
                $data['last_updated'] = date('Y-m-d H:i:s');
                $result = $this->delivery_mdl->update_delivery($delivery_id, $data); 				
                if (!empty($result)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
					redirect('admin/delivery', 'refresh');  
                } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('admin/delivery', 'refresh');
                }
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/delivery', 'refresh');
        }
    }

    public function remove_delivery($delivery_id) {
        $delivery_info = $this->delivery_mdl->get_delivery_by_delivery_id($delivery_id);
        if (!empty($delivery_info)) {
            $result = $this->delivery_mdl->remove_delivery_by_id($delivery_id);
            if (!empty($result)) {
                $sdata['success'] = 'Remove successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/delivery?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/delivery?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/delivery?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

}

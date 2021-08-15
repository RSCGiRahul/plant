<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Outlet extends CC_Controller { 
	  
    public function __construct() {
        parent::__construct(); 
        $this->user_login_authentication(); 
        $this->load->model('admin_models/outlet_model', 'outlet_mdl');
		$this->load->model('admin_models/delivery_model', 'delivery_mdl');
    }

    public function index() { 		
        $data = array();
        $data['title'] = 'Manage Outlet';
        $data['active_menu'] = 'outlet';
        $data['active_sub_menu'] = 'outlet';
        $data['active_sub_sub_menu'] = ''; 

		$page = $_REQUEST['currentpage']; 
		$search = $_REQUEST['search'];
		$status = $_REQUEST['status'];
		$data['outlet_info'] = $this->outlet_mdl->get_outlet_info($page,$search,$status);
		$data['outlet_count'] = $this->outlet_mdl->get_outlet_count($search,$status);		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/outlet/manage_outlet_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function add_outlet() {
        $data = array();
        $data['title'] = 'Add Outlet';
        $data['active_menu'] = 'outlet';
        $data['active_sub_menu'] = 'add_outlet';
        $data['active_sub_sub_menu'] = ''; 	

		$data['associated_delivery'] = $this->delivery_mdl->get_delivery_list();		
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/outlet/add_outlet_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function create_outlet() {
 
	
		
		
        $config = array(
            array(
                'field' => 'outlet_name',
                'label' => 'Outlet name',
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
				'field' => 'assigned_city',
				'label' => 'Assigned City',
				'rules' => 'trim|required|max_length[250]'
			),  
			array(
				'field' => 'zipcode',
				'label' => 'zipcode',
				'rules' => 'trim|required|max_length[250]'
			), 

			array(
				'field' => 'lat',
				'label' => 'Latitude',
				'rules' => 'trim|required|max_length[250]'
			), 		

			array(
				'field' => 'lng',
				'label' => 'Longitude',
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
			$this->add_outlet(); 
        } else {			
            $data['outlet_name'] = $this->input->post('outlet_name', TRUE); 
			$data['phone'] = $this->input->post('phone', TRUE);   
			$data['address'] = $this->input->post('address', TRUE);   
			$data['assigned_city'] = $this->input->post('assigned_city', TRUE);   
			$data['zipcode'] = $this->input->post('zipcode', TRUE);   
			$data['lat'] = $this->input->post('lat', TRUE);   
			$data['lng'] = $this->input->post('lng', TRUE);   
			
			$data['rating'] = $this->input->post('rating', TRUE);   
			$data['reviews'] = $this->input->post('reviews', TRUE);   
			
			$data['associated_delivery_id'] = $this->input->post('associated_delivery_id', TRUE);   
			
			
            $data['publication_status'] = $this->input->post('publication_status', TRUE);
            $data['date_added'] = date('Y-m-d H:i:s');
			$insert_id = $this->outlet_mdl->store_outlet($data); 
            if (!empty($insert_id)) {
                $sdata['success'] = 'Add successfully . ';
                $this->session->set_userdata($sdata);
				redirect('admin/outlet', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/outlet', 'refresh');
            }
        }
    }

    public function published_outlet($outlet_id) { 
        $outlet_info = $this->outlet_mdl->get_outlet_by_outlet_id($outlet_id);
        if (!empty($outlet_info)) {
            $result = $this->outlet_mdl->published_outlet_by_id($outlet_id);
            if (!empty($result)) {
                $sdata['success'] = 'Published successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/outlet'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/outlet'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/outlet'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function unpublished_outlet($outlet_id) { 
        $outlet_info = $this->outlet_mdl->get_outlet_by_outlet_id($outlet_id);
        if (!empty($outlet_info)) {
            $result = $this->outlet_mdl->unpublished_outlet_by_id($outlet_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/outlet'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/outlet'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/outlet'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function edit_outlet($outlet_id) {
        $data = array();
        $data['outlet_info'] = $this->outlet_mdl->get_outlet_by_outlet_id($outlet_id); 
        if (!empty($data['outlet_info'])) {
            $data['title'] = 'Edit Outlet';
			$data['active_menu'] = 'outlet';
			$data['active_sub_menu'] = 'add_outlet';
            $data['active_sub_sub_menu'] = ''; 			
			
			$data['associated_delivery'] = $this->delivery_mdl->get_delivery_list();
			
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/outlet/edit_outlet_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data);
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/outlet', 'refresh');
        }
    }

    public function update_outlet($outlet_id) {
        $outlet_info = $this->outlet_mdl->get_outlet_by_outlet_id($outlet_id);
        if (!empty($outlet_info)) {
				$config = array(
            array(
                'field' => 'outlet_name',
                'label' => 'Outlet name',
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
				'field' => 'assigned_city',
				'label' => 'Assigned City',
				'rules' => 'trim|required|max_length[250]'
			),  
			array(
				'field' => 'zipcode',
				'label' => 'zipcode',
				'rules' => 'trim|required|max_length[250]'
			), 

			array(
				'field' => 'lat',
				'label' => 'Latitude',
				'rules' => 'trim|required|max_length[250]'
			), 		

			array(
				'field' => 'lng',
				'label' => 'Longitude',
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
                $this->edit_outlet($outlet_id);
            } else {				
               $data['outlet_name'] = $this->input->post('outlet_name', TRUE); 
				$data['phone'] = $this->input->post('phone', TRUE);   
				$data['address'] = $this->input->post('address', TRUE);   
				$data['assigned_city'] = $this->input->post('assigned_city', TRUE);   
				$data['zipcode'] = $this->input->post('zipcode', TRUE);   
				$data['lat'] = $this->input->post('lat', TRUE);   
				$data['lng'] = $this->input->post('lng', TRUE);   
				
				$data['rating'] = $this->input->post('rating', TRUE);   
				$data['reviews'] = $this->input->post('reviews', TRUE);  

				$data['associated_delivery_id'] = $this->input->post('associated_delivery_id', TRUE);   
				$data['publication_status'] = $this->input->post('publication_status', TRUE); 
                $data['last_updated'] = date('Y-m-d H:i:s');
                $result = $this->outlet_mdl->update_outlet($outlet_id, $data); 				
                if (!empty($result)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
					redirect('admin/outlet', 'refresh');  
                } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('admin/outlet', 'refresh');
                }
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/outlet', 'refresh');
        }
    }

    public function remove_outlet($outlet_id) {
        $outlet_info = $this->outlet_mdl->get_outlet_by_outlet_id($outlet_id);
        if (!empty($outlet_info)) {
            $result = $this->outlet_mdl->remove_outlet_by_id($outlet_id);
            if (!empty($result)) {
                $sdata['success'] = 'Remove successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/outlet?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/outlet?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/outlet?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

}

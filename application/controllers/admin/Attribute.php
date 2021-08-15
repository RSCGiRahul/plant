<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Attribute extends CC_Controller { 
	  
    public function __construct() {
        parent::__construct(); 
        $this->user_login_authentication(); 
        $this->load->model('admin_models/attribute_model', 'attribute_mdl');
    }

    public function index() { 		
        $data = array();
        $data['title'] = 'Manage Attribute';
        $data['active_menu'] = 'attribute';
        $data['active_sub_menu'] = 'attribute';
        $data['active_sub_sub_menu'] = ''; 

		$page = $_REQUEST['currentpage']; 
		$search = $_REQUEST['search'];
		$status = $_REQUEST['status'];
		$data['attribute_info'] = $this->attribute_mdl->get_attribute_info($page,$search,$status);
		$data['attribute_count'] = $this->attribute_mdl->get_attribute_count($search,$status);		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/attribute/manage_attribute_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function add_attribute() {
        $data = array();
        $data['title'] = 'Add Attribute';
        $data['active_menu'] = 'attribute';
        $data['active_sub_menu'] = 'add_attribute';
        $data['active_sub_sub_menu'] = ''; 		 
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/attribute/add_attribute_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function create_attribute() {
 
		
        $config = array(
            array(
                'field' => 'attribute_name',
                'label' => 'Attribute name',
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
			$this->add_attribute(); 
        } else {			
            $data['attribute_name'] = $this->input->post('attribute_name', TRUE); 
            $data['publication_status'] = $this->input->post('publication_status', TRUE);
            $data['date_added'] = date('Y-m-d H:i:s');
			$insert_id = $this->attribute_mdl->store_attribute($data); 
            if (!empty($insert_id)) {
                $sdata['success'] = 'Add successfully . ';
                $this->session->set_userdata($sdata);
				redirect('admin/attribute', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/attribute', 'refresh');
            }
        }
    }

    public function published_attribute($attribute_id) { 
        $attribute_info = $this->attribute_mdl->get_attribute_by_attribute_id($attribute_id);
        if (!empty($attribute_info)) {
            $result = $this->attribute_mdl->published_attribute_by_id($attribute_id);
            if (!empty($result)) {
                $sdata['success'] = 'Published successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/attribute'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/attribute'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/attribute'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function unpublished_attribute($attribute_id) { 
        $attribute_info = $this->cat_mdl->get_attribute_by_attribute_id($attribute_id);
        if (!empty($attribute_info)) {
            $result = $this->attribute_mdl->unpublished_attribute_by_id($attribute_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/attribute'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/attribute'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/attribute'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function edit_attribute($attribute_id) {
        $data = array();
        $data['attribute_info'] = $this->attribute_mdl->get_attribute_by_attribute_id($attribute_id); 
        if (!empty($data['attribute_info'])) {
            $data['title'] = 'Edit Attribute';
			$data['active_menu'] = 'attribute';
			$data['active_sub_menu'] = 'add_attribute';
            $data['active_sub_sub_menu'] = ''; 			
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/attribute/edit_attribute_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data);
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/attribute', 'refresh');
        }
    }

    public function update_attribute($attribute_id) {
        $attribute_info = $this->attribute_mdl->get_attribute_by_attribute_id($attribute_id);
        if (!empty($attribute_info)) {
				 $config = array(
					array(
						'field' => 'attribute_name',
						'label' => 'Attribute name',
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
                $this->edit_attribute($attribute_id);
            } else {				
                $data['attribute_name'] = $this->input->post('attribute_name', TRUE); 
				$data['publication_status'] = $this->input->post('publication_status', TRUE); 
                $data['last_updated'] = date('Y-m-d H:i:s');
                $result = $this->attribute_mdl->update_attribute($attribute_id, $data); 				
                if (!empty($result)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
					redirect('admin/attribute', 'refresh');  
                } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('admin/attribute', 'refresh');
                }
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/attribute', 'refresh');
        }
    }

    public function remove_attribute($attribute_id) {
        $attribute_info = $this->attribute_mdl->get_attribute_by_attribute_id($attribute_id);
        if (!empty($attribute_info)) {
            $result = $this->attribute_mdl->remove_attribute_by_id($attribute_id);
            if (!empty($result)) {
                $sdata['success'] = 'Remove successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/attribute?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/attribute?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/attribute?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

}

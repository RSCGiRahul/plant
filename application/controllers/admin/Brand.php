<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Brand extends CC_Controller { 
	  
    public function __construct() {
        parent::__construct(); 
        $this->user_login_authentication(); 
        $this->load->model('admin_models/brand_model', 'brand_mdl');
    }

    public function index() { 		
        $data = array();
        $data['title'] = 'Manage Brand';
        $data['active_menu'] = 'brand';
        $data['active_sub_menu'] = 'brand';
        $data['active_sub_sub_menu'] = ''; 

		$page = $_REQUEST['currentpage']; 
		$search = $_REQUEST['search'];
		$status = $_REQUEST['status'];
		$data['brand_info'] = $this->brand_mdl->get_brand_info($page,$search,$status);
		$data['brand_count'] = $this->brand_mdl->get_brand_count($search,$status);		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/brand/manage_brand_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function add_brand() {
        $data = array();
        $data['title'] = 'Add Brand';
        $data['active_menu'] = 'brand';
        $data['active_sub_menu'] = 'add_brand';
        $data['active_sub_sub_menu'] = ''; 		 
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/brand/add_brand_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function create_brand() {
 
		
        $config = array(
            array(
                'field' => 'brand_name',
                'label' => 'Brand name',
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
			$this->add_brand(); 
        } else {			
            $data['brand_name'] = $this->input->post('brand_name', TRUE); 
			$data['brand_image'] = $this->input->post('brand_image', TRUE);   
            $data['publication_status'] = $this->input->post('publication_status', TRUE);
            $data['date_added'] = date('Y-m-d H:i:s');
			$insert_id = $this->brand_mdl->store_brand($data); 
            if (!empty($insert_id)) {
                $sdata['success'] = 'Add successfully . ';
                $this->session->set_userdata($sdata);
				redirect('admin/brand', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/brand', 'refresh');
            }
        }
    }

    public function published_brand($brand_id) { 
        $brand_info = $this->brand_mdl->get_brand_by_brand_id($brand_id);
        if (!empty($brand_info)) {
            $result = $this->brand_mdl->published_brand_by_id($brand_id);
            if (!empty($result)) {
                $sdata['success'] = 'Published successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/brand'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/brand'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/brand'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function unpublished_brand($brand_id) { 
        $brand_info = $this->cat_mdl->get_brand_by_brand_id($brand_id);
        if (!empty($brand_info)) {
            $result = $this->brand_mdl->unpublished_brand_by_id($brand_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/brand'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/brand'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/brand'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function edit_brand($brand_id) {
        $data = array();
        $data['brand_info'] = $this->brand_mdl->get_brand_by_brand_id($brand_id); 
        if (!empty($data['brand_info'])) {
            $data['title'] = 'Edit Brand';
			$data['active_menu'] = 'brand';
			$data['active_sub_menu'] = 'add_brand';
            $data['active_sub_sub_menu'] = ''; 			
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/brand/edit_brand_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data);
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/brand', 'refresh');
        }
    }

    public function update_brand($brand_id) {
        $brand_info = $this->brand_mdl->get_brand_by_brand_id($brand_id);
        if (!empty($brand_info)) {
				 $config = array(
					array(
						'field' => 'brand_name',
						'label' => 'Brand name',
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
                $this->edit_brand($brand_id);
            } else {				
                $data['brand_name'] = $this->input->post('brand_name', TRUE); 
				$data['brand_image'] = $this->input->post('brand_image', TRUE);   
				$data['publication_status'] = $this->input->post('publication_status', TRUE); 
                $data['last_updated'] = date('Y-m-d H:i:s');
                $result = $this->brand_mdl->update_brand($brand_id, $data); 				
                if (!empty($result)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
					redirect('admin/brand', 'refresh');  
                } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('admin/brand', 'refresh');
                }
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/brand', 'refresh');
        }
    }

    public function remove_brand($brand_id) {
        $brand_info = $this->brand_mdl->get_brand_by_brand_id($brand_id);
        if (!empty($brand_info)) {
            $result = $this->brand_mdl->remove_brand_by_id($brand_id);
            if (!empty($result)) {
                $sdata['success'] = 'Remove successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/brand?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/brand?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/brand?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

}

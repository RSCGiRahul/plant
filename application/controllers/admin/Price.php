<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Price extends CC_Controller { 
	  
    public function __construct() {
        parent::__construct(); 
        $this->user_login_authentication(); 
        $this->load->model('admin_models/price_model', 'price_mdl');
    }

    public function index() { 		
        $data = array();
        $data['title'] = 'Manage Price';
        $data['active_menu'] = 'price';
        $data['active_sub_menu'] = 'price';
        $data['active_sub_sub_menu'] = ''; 

		$page = $_REQUEST['currentpage']; 
		$search = $_REQUEST['search'];
		$status = $_REQUEST['status'];
		$data['price_info'] = $this->price_mdl->get_price_info($page,$search,$status);
		$data['price_count'] = $this->price_mdl->get_price_count($search,$status);		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/price/manage_price_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function add_price() {
        $data = array();
        $data['title'] = 'Add Price';
        $data['active_menu'] = 'price';
        $data['active_sub_menu'] = 'add_price';
        $data['active_sub_sub_menu'] = ''; 		 
		
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/price/add_price_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }

    public function create_price() {
 
		
        $config = array(
            array(
                'field' => 'price_name',
                'label' => 'Price name',
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
			$this->add_price(); 
        } else {			
            $data['price_name'] = $this->input->post('price_name', TRUE); 
            $data['publication_status'] = $this->input->post('publication_status', TRUE);
            $data['date_added'] = date('Y-m-d H:i:s');
			$insert_id = $this->price_mdl->store_price($data); 
            if (!empty($insert_id)) {
                $sdata['success'] = 'Add successfully . ';
                $this->session->set_userdata($sdata);
				redirect('admin/price', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/price', 'refresh');
            }
        }
    }

    public function published_price($price_id) { 
        $price_info = $this->price_mdl->get_price_by_price_id($price_id);
        if (!empty($price_info)) {
            $result = $this->price_mdl->published_price_by_id($price_id);
            if (!empty($result)) {
                $sdata['success'] = 'Published successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/price'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/price'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/price'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function unpublished_price($price_id) { 
        $price_info = $this->cat_mdl->get_price_by_price_id($price_id);
        if (!empty($price_info)) {
            $result = $this->price_mdl->unpublished_price_by_id($price_id);
            if (!empty($result)) {
                $sdata['success'] = 'Unublished successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/price'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/price'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/price'.$action.'?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

    public function edit_price($price_id) {
        $data = array();
        $data['price_info'] = $this->price_mdl->get_price_by_price_id($price_id); 
        if (!empty($data['price_info'])) {
            $data['title'] = 'Edit Price';
			$data['active_menu'] = 'price';
			$data['active_sub_menu'] = 'add_price';
            $data['active_sub_sub_menu'] = ''; 			
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/price/edit_price_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data);
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/price', 'refresh');
        }
    }

    public function update_price($price_id) {
        $price_info = $this->price_mdl->get_price_by_price_id($price_id);
        if (!empty($price_info)) {
				 $config = array(
					array(
						'field' => 'price_name',
						'label' => 'Price name',
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
                $this->edit_price($price_id);
            } else {				
                $data['price_name'] = $this->input->post('price_name', TRUE); 
				$data['publication_status'] = $this->input->post('publication_status', TRUE); 
                $data['last_updated'] = date('Y-m-d H:i:s');
                $result = $this->price_mdl->update_price($price_id, $data); 				
                if (!empty($result)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
					redirect('admin/price', 'refresh');  
                } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('admin/price', 'refresh');
                }
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/price', 'refresh');
        }
    }

    public function remove_price($price_id) {
        $price_info = $this->price_mdl->get_price_by_price_id($price_id);
        if (!empty($price_info)) {
            $result = $this->price_mdl->remove_price_by_id($price_id);
            if (!empty($result)) {
                $sdata['success'] = 'Remove successfully .';
                $this->session->set_userdata($sdata);
                redirect('admin/price?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('admin/price?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('admin/price?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }

}

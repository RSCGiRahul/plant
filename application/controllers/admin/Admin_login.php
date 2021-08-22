<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_login extends CC_Controller {
    public function __construct() {
        parent::__construct();

        $logged_info = $this->session->userdata('logged_info');
        if ($logged_info != FALSE) {
            redirect('admin/dashboard', 'refresh');
        }

        $this->load->model('admin_models/admin_login_model', 'login_mdl');
    }

    public function index() {
        $data = array();
        $data['title'] = 'Login';
        $this->load->view('admin_views/admin_login/admin_login_v', $data);
    }

    public function check_admin_login() {
        $this->form_validation->set_rules('username_or_email_address', 'username or email address', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('password', 'password', 'trim|required|max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            $sdata['exception'] = validation_errors();
            $this->session->set_userdata($sdata);
            redirect('admin', 'refresh');
        } else {

            $result = $this->login_mdl->check_login_info();
            if ($result) {
//              $this->login_mdl->insert_login_info($result->user_id);
                $sdata['admin_id'] = $result->user_id;
                $sdata['admin_first_name'] = $result->first_name;
                $sdata['admin_last_name'] = $result->last_name;
                $sdata['email_address'] = $result->email_address;
                $sdata['work'] = $result->work;
                $sdata['admin_avatar'] = $result->avatar;
                $sdata['date_added'] = $result->date_added;
                $sdata['access_label'] = $result->access_label;
                $sdata['logged_info'] = TRUE;
                $this->session->set_userdata($sdata);
                redirect('admin/dashboard', 'refresh');
            } else {
                $sdata['exception'] = 'The <b>Username</b> or <b>Password</b> you’ve entered doesn’t match any account !';
                $this->session->set_userdata($sdata);
                redirect('admin', 'refresh');
            }
        }
    }

}

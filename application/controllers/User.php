<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }
    
    public function all_user(){
        $data['user'] = $this->m_basic->gets("user")->result();
        $header = array(
            "subtitle"=>"User",
            "title"=>"View"
        );
        $this->load->view('header', $header);
        $this->load->view('allUser', $data);
        $this->load->view('footer');
    }

    public function new_user(){
        $header = array(
            "subtitle"=>"User",
            "title"=>"New User"
        );
        $this->load->view('header', $header);
        $this->load->view('newUser');
        $this->load->view('footer');

        redirect(base_url("user/all_user"));
    }

    public function insertUser(){
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $position = $this->input->post('position');
        $phone = $this->input->post('phone');

        $userId = date("YmdHis");

        $data = array(
            "userId"=>$userId,
            "userName"=>$name,
            "userEmail"=>$email,
            "userPosition"=>$position,
            "userPhone"=>$phone,
            "userStatus"=>1
        );
        $this->m_basic->insert("user", $data);
    }

    public function edit_user($userId){
        $data['user'] = $this->m_basic->find("user", array("userId"=>$userId))->row();

        $header = array(
            "subtitle"=>"User",
            "title"=>"Edit User"
        );
        $this->load->view('header', $header);
        $this->load->view('editUser', $data);
        $this->load->view('footer');
    }

    public function editUser(){
        $userId = $this->input->post('userId');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $position = $this->input->post('position');
        $phone = $this->input->post('phone');

        $data = array(
            "userName"=>$name,
            "userEmail"=>$email,
            "userPosition"=>$position,
            "userPhone"=>$phone,
            "userStatus"=>1
        );
        $this->m_basic->update(array("userId"=>$userId), "user", $data);
        redirect(base_url("user/all_user"));
    }
}

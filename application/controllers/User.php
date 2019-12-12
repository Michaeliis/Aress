<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');

        $this->load->library("session");

        if(!isset($_SESSION["userId"])){
            redirect(base_url("login/login"));
        }else if($_SESSION["userPosition"] != "admin"){
            redirect(base_url("login/login"));
        }
    }
    
    public function all_user(){
        $data['user'] = $this->m_basic->gets("user")->result();
        $header = array(
            "subtitle"=>"User",
            "title"=>"View User"
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
    }

    public function insertUser(){
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $position = $this->input->post('position');
        $phone = $this->input->post('phone');
        $userUsername = $this->input->post('userUsername');
        $userPassword = $this->input->post('userPassword');

        $userPassword = md5($userPassword);

        $userCount = $this->m_basic->find("user", array("userUsername"=>$userUsername))->num_rows();
        if(!$userCount > 0){
            $data = array(
                "userName"=>$name,
                "userEmail"=>$email,
                "userUsername"=>$userUsername,
                "userPassword"=>$userPassword,
                "userPhone"=>$phone,
                "userPosition"=>$position,
                "userStatus"=>1
            );
            $this->m_basic->insert("user", $data);
    
            redirect(base_url("user/all_user"));
        }else{
            $_SESSION["error"] = "This username has been used, please use another name";
            $this->session->mark_as_flash("error");

            redirect(base_url("user/new_user"));
        }
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
        $username = $this->input->post('username');
        $usernameOld = $this->input->post('usernameOld');
        $email = $this->input->post('email');
        $position = $this->input->post('position');
        $phone = $this->input->post('phone');
        $password = $this->input->post('password');

        $userCount = $this->m_basic->find("user", array("userUsername"=>$username))->num_rows();
        if($usernameOld == $username){
            $userCount--;
        }
        if(!$userCount > 0){
            $data = array(
                "userName"=>$name,
                "userEmail"=>$email,
                "userPosition"=>$position,
                "userPhone"=>$phone,
                "userUsername"=>$username
            );
    
            if($password != ""){
                $data["userPassword"] = md5($password);
            }
            $this->m_basic->update(array("userId"=>$userId), "user", $data);
            redirect(base_url("user/all_user"));
        }else{
            $_SESSION["error"] = "This username has been used, please use another name";
            $this->session->mark_as_flash("error");

            redirect(base_url("user/new_user"));
        }        
    }

    public function delete_user($userId){
        if($userId == $_SESSION["userId"]){
            $_SESSION["error"] = "You cannot delete your own account";
            $this->session->mark_as_flash("error");
        }else{
            $this->m_basic->update(array("userId"=>$userId), "user", array("userStatus"=>"0"));
        }

        redirect(base_url("user/all_user"));
    }

    public function activate_user($userId){
        if($userId == $_SESSION["userId"]){
            $_SESSION["error"] = "You cannot reactivate your own account";
            $this->session->mark_as_flash("error");
        }else{
            $this->m_basic->update(array("userId"=>$userId), "user", array("userStatus"=>"1"));
        }

        redirect(base_url("user/all_user"));
    }
}

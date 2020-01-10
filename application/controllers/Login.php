<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->model('m_basic');

        $this->load->library('session');
    }
    
    function login(){
        $header["title"] = "Login";
        $this->load->view("headerLogin", $header);
        $this->load->view("login");
        $this->load->view("footerLogin");
    }

    function checkLogin(){
        $userUsername = $this->input->post("username");
        $userPassword = md5($this->input->post("password"));

        $user = $this->m_basic->find("user", array("userUsername"=>$userUsername, "userPassword"=>$userPassword, "userStatus"=>"1"))->row();

        if(isset($user)){
            $_SESSION["userName"] = $user->userName;
            $_SESSION["userId"] = $user->userId;
            $_SESSION["userPosition"] = $user->userPosition;
            redirect(base_url("app/select_app"));
        }else{
            $_SESSION["notif"] = "Invalid username or password";
            $_SESSION["notifType"] = "error";
            $this->session->mark_as_flash(array("notif", "notifType"));
            redirect(base_url("login/login"));
        }
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url("login/login"));
    }

}
?>
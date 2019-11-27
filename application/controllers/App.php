<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');

        $this->load->library("session");

        if(!isset($_SESSION["userId"])){
            redirect(base_url("login/login"));
        }
    }
    
    function select_app(){
        $data["app"] = $this->m_basic->find('app', array("appStatus"=>"1"))->result();

        $header["title"] = "Select App";
        $this->load->view("headerLogin", $header);
        $this->load->view("selectApp", $data);
        $this->load->view("footerLogin");
    }

    function setActive($appId){
        $app = $this->m_basic->find("app", array("appId"=>$appId, "appStatus"=>"1"))->row();
        if(isset($app)){
            $_SESSION["appId"] = $app->appId;
            $_SESSION["appToken"] = $app->appToken;
            redirect(base_url("dashboard"));
        }
    }

    public function all_app(){
        $data["app"] = $this->m_basic->gets('app')->result();

        $header = array(
            "subtitle"=>"App",
            "title"=>"All App"
        );
        $this->load->view('header', $header);
        $this->load->view('allApp', $data);
        $this->load->view('footer');
    }

    public function new_app(){
        $header = array(
            "subtitle"=>"App",
            "title"=>"New App"
        );
        $this->load->view('header', $header);
        $this->load->view('newApp');
        $this->load->view('footer');
    }

    public function newApp(){
        $appName = $this->input->post("appName");
        $appDetail = $this->input->post("appDetail");
        $appLanguage = $this->input->post("appDetail");

        $json = json_encode(array("name"=>$appName, "lang"=>$appLanguage, "private"=>"false", "desc"=>$appDetail));
        $output = json_decode(doStuff("apps", null, $json));

        $appToken = $output->access_token;
        $appId = $output->app_id;

        $this->m_basic->insert("app", array("appId"=>$appId, "appName"=>$appName, "appLanguage"=>$appLanguage, "appToken"=>$appToken, "appDetail"=>$appDetail, "appStatus"=>"1"));

        redirect(base_url("app/all_app"));
    }

    public function edit_app($appId){
        $data["app"] = $this->m_basic->find("app", array("appId"=>$appId))->row();

        $header = array(
            "subtitle"=>"App",
            "title"=>"Edit App"
        );
        $this->load->view('header', $header);
        $this->load->view('editApp', $data);
        $this->load->view('footer');
    }

    public function editApp(){
        $appId = $this->input->post("appId");
        $appName = $this->input->post("appName");
        $appDetail = $this->input->post("appDetail");
        $appLanguage = $this->input->post("appLanguage");
        $appToken = $this->input->post("appToken");

        $json = json_encode(array("name"=>$appName, "lang"=>$appLanguage, "private"=>"false", "desc"=>$appDetail));
        $output = putStuff("apps/".$appId, null, $json, $appToken);

        $this->m_basic->update(array("appId"=>$appId), "app", array("appName"=>$appName, "appLanguage"=>$appLanguage, "appDetail"=>$appDetail, "appStatus"=>"1"));

        redirect(base_url("app/all_app"));
    }
}

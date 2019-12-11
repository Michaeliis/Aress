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
        $appToken = $_SESSION["appToken"];
        $appName = str_replace(" ", "_", $this->input->post("appName"));
        $appDetail = $this->input->post("appDetail");
        $appLanguage = $this->input->post("appLanguage");

        //check appName
        $appCount = $this->m_basic->find("app", array("appName"=>$appName))->num_rows();

        if(!$appCount > 0){
            $json = json_encode(array("name"=>$appName, "lang"=>$appLanguage, "private"=>"false", "desc"=>$appDetail));
            $output = json_decode(doStuff("apps", null, $json, $appToken));
            //check api
            if(isset($output->access_token)){
                $appToken = $output->access_token;
                $appId = $output->app_id;
        
                $this->m_basic->insert("app", array("appId"=>$appId, "appName"=>$appName, "appLanguage"=>$appLanguage, "appToken"=>$appToken, "appDetail"=>$appDetail, "appStatus"=>"1"));
            }else{
                $_SESSION["error"] = "There is a problem when inserting app, please check your connection";
                $this->session->mark_as_flash('error');
            }
        }else{
            $_SESSION["error"] = "The app name has been used, please use another name";
            $this->session->mark_as_flash('error');
        }

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
        $appName = str_replace(" ", "_", $this->input->post("appName"));
        $appNameOld = $this->input->post("appNameOld");
        $appDetail = $this->input->post("appDetail");
        $appLanguage = $this->input->post("appLanguage");
        $appToken = $this->input->post("appToken");

        //check appName
        $appCount = $this->m_basic->find("app", array("appName"=>$appName))->num_rows();
        if($appNameOld == $appName){
            $appCount--;
        }
        if(!$appCount > 0){
            $json = json_encode(array("name"=>$appName, "lang"=>$appLanguage, "private"=>"false", "desc"=>$appDetail));
            $server_output = json_decode(putStuff("apps/".$appId, null, $json, $appToken));

            if(isset($server_output->success)){
                $this->m_basic->update(array("appId"=>$appId), "app", array("appName"=>$appName, "appLanguage"=>$appLanguage, "appDetail"=>$appDetail, "appStatus"=>"1"));
            }else{
                $_SESSION["error"] = "There is a problem when editing app, please check your connection";
                $this->session->mark_as_flash('error');
            }
        }else{
            $_SESSION["error"] = "This app name has been used, please use another name";
            $this->session->mark_as_flash('error');
        }

        redirect(base_url("app/all_app"));
    }

    public function delete_app($appId){
        $this->m_basic->update(array("appId"=>$appId), "app", array("appStatus"=>"0"));
        redirect(base_url("app/all_app"));
    }

    public function activate_app($appId){
        $this->m_basic->update(array("appId"=>$appId), "app", array("appStatus"=>"1"));
        redirect(base_url("app/all_app"));
    }
}

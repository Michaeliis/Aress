<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intent extends CI_Controller {
    
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
    
    public function all_intent(){
        $data["intent"] = $this->m_basic->joinUser("intent")->result();

        $header = array(
            "subtitle"=>"Intent",
            "title"=>"All Intent"
        );
        $this->load->view('header', $header);
        $this->load->view('allIntent', $data);
        $this->load->view('footer');
    }

    public function new_intent(){
        $header = array(
            "subtitle"=>"Intent",
            "title"=>"New Intent"
        );
        $this->load->view('header', $header);
        $this->load->view('newIntent');
        $this->load->view('footer');
    }

    public function newIntent(){
        $appId = $_SESSION["appId"];
        $appToken = $_SESSION["appToken"];

        $intentName = $this->input->post("intentName");
        $intentName = str_replace(" ", "_", $intentName);
        $intentDetail = $this->input->post("intentDetail");

        $intentCount = $this->m_basic->find("intent", array("intentName"=>$intentName, "appId"=>$appId))->num_rows();

        $_SESSION["notif"] = "Intent successfully created.";
        $_SESSION["notifType"] = "success";
        $this->session->mark_as_flash(array("notif", "notifType"));
        if(!$intentCount > 0){

            $json = json_encode(array("value"=>$intentName));
            $server_output = json_decode(doStuff("/entities/intent/values", null, $json, $appToken));
            //cek api
            $intentStatus = 0;
            if(isset($server_output->name)){
                $intentStatus = 1;
            }else{
                $_SESSION["notif"] = "There's an error when creating intent, please check your internet connection";
                $_SESSION["notifType"] = "error";
                $this->session->mark_as_flash(array("notif", "notifType"));
            }
            $this->m_basic->insert("intent", array("intentName"=>$intentName, "appId"=>$appId, "intentDetail"=>$intentDetail, "userId"=>$_SESSION["userId"], "intentStatus"=>$intentStatus));
        }else{
            $_SESSION["notif"] = "This intent name has been used, please use another name";
            $_SESSION["notifType"] = "error";
            $this->session->mark_as_flash(array("notif", "notifType"));
        }
        
        redirect(base_url("intent/all_intent"));
    }

    public function edit_intent($intentId){
        $appId = $_SESSION["appId"];

        $data["intent"] = $this->m_basic->find("intent", array("intentId"=>$intentId, "appId"=>$appId))->row();
        $header = array(
            "subtitle"=>"Intent",
            "title"=>"Edit Intent"
        );
        $this->load->view('header', $header);
        $this->load->view('editIntent', $data);
        $this->load->view('footer');
    }

    public function editIntent(){
        $appToken = $_SESSION["appToken"];
        $appId = $_SESSION["appId"];

        $intentId = $this->input->post("intentId");
        $intentName = $this->input->post("intentName");
        $intentName = str_replace(" ", "_", $intentName);
        $intentNameBefore = $this->input->post("intentNameBefore");
        $intentDetail = $this->input->post("intentDetail");

        //cek double intent name
        $intentCount = $this->m_basic->find("intent", array("intentName"=>$intentName, "appId"=>$appId))->num_rows();
        $_SESSION["notif"] = "Intent successfully edited.";
        $_SESSION["notifType"] = "success";
        $this->session->mark_as_flash(array("notif", "notifType"));
        if($intentNameBefore == $intentName){
            $intentCount--;
            $changeIntent=false;
        }
        if(!$intentCount > 0){
            if(!$changeIntent){
                //delete old intent
                $server_output = json_decode(deleteStuff("/entities/intent/values/".$intentNameBefore, null, $appToken));
                //cek api
                if(isset($server_output->deleted)){
                    $json = json_encode(array("value"=>$intentName));

                    $server_output = json_decode(doStuff("/entities/intent/values", null, $json, $appToken));

                    //cek api
                    if(isset($server_output->name)){
                        $this->m_basic->update(array("intentId"=>$intentId), "intent", array("intentName"=>$intentName, "intentDetail"=>$intentDetail));
                    }else{
                        $this->m_basic->update(array("intentId"=>$intentId), "intent", array("intentName"=>$intentName, "intentDetail"=>$intentDetail, "intentStatus"=>"0"));
                        $_SESSION["notif"] = "There's an error when creating intent, please check your internet connection";
                        $_SESSION["notifType"] = "error";
                        $this->session->mark_as_flash(array("notif", "notifType"));
                    }
                }else{
                    $_SESSION["notif"] = "There's an error when deleting intent, please check your connection";
                    $_SESSION["notifType"] = "error";
                    $this->session->mark_as_flash(array("notif", "notifType"));
                }
            }
            
            $this->m_basic->update(array("intentId"=>$intentId), "intent", array("intentDetail"=>$intentDetail));
        }else{
            $_SESSION["notif"] = "This intent name have already been used, please use another name";
            $_SESSION["notifType"] = "error";
            $this->session->mark_as_flash(array("notif", "notifType"));
        }

        redirect(base_url("intent/all_intent"));
    }

    public function delete_intent($intentId){
        $appToken = $_SESSION["appToken"];

        $intent = $this->m_basic->find("intent", array("intentId"=>$intentId))->row();
        $server_output = json_decode(deleteStuff("/entities/intent/values/".$intent->intentName, null, $appToken));

        if(isset($server_output->deleted)){
            $_SESSION["notif"] = "Intent successfully deleted.";
            $_SESSION["notifType"] = "success";
            $this->session->mark_as_flash(array("notif", "notifType"));
            $this->m_basic->update(array("intentId"=>$intentId), "intent", array("intentStatus"=>"0"));
        }else{
            $_SESSION["notif"] = "There's an error when deleting intent, please check your connection";
            $_SESSION["notifType"] = "error";
            $this->session->mark_as_flash(array("notif", "notifType"));
        }
        
        redirect(base_url("intent/all_intent"));
    }

    public function activate_intent($intentId){
        $appToken = $_SESSION["appToken"];
        
        $intent = $this->m_basic->find("intent", array("intentId"=>$intentId))->row();
        $json = array("value"=>$intent->intentName);

        $server_output = json_decode(doStuff("/entities/intent/values", null, json_encode($json), $appToken));

        if(isset($server_output->name)){
            $_SESSION["notif"] = "Intent successfully reactivated.";
            $_SESSION["notifType"] = "success";
            $this->session->mark_as_flash(array("notif", "notifType"));
            $this->m_basic->update(array("intentId"=>$intentId), "intent", array("intentStatus"=>"1"));
        }else{
            $_SESSION["notif"] = "There's an error when creating intent, please check your internet connection";
            $_SESSION["notifType"] = "error";
            $this->session->mark_as_flash(array("notif", "notifType"));
        }
        
        redirect(base_url("intent/all_intent"));
    }
}

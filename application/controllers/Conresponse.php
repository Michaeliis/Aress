<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conresponse extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
        $this->load->model('m_condition');

        $this->load->library("session");
        
        if(!isset($_SESSION["userId"])){
            redirect(base_url("login/login"));
        }
    }
    
    public function all_condition_response(){
        $data["conresponse"] = $this->m_condition->conditionResponse()->result();

        $header = array(
            "subtitle"=>"Condition",
            "title"=>"All Condition Response"
        );
        $this->load->view('header', $header);
        $this->load->view('allConresponse', $data);
        $this->load->view('footer');
    }

    public function new_condition_response(){
        $appId = $_SESSION["appId"];

        $data["condition"] = $this->m_basic->find("conditionn", array("appId"=>$appId, "conditionStatus"=>"1"))->result();
        $data["response"] = $this->m_basic->find("response", array("appId"=>$appId, "responseStatus"=>"1"))->result();

        $header = array(
            "subtitle"=>"Condition",
            "title"=>"New Condition Response"
        );
        $this->load->view('header', $header);
        $this->load->view('newConresponse', $data);
        $this->load->view('footer');
    }

    public function newConresponse(){
        $appId = $_SESSION["appId"];

        $condition = $this->input->post("condition");
        $response = $this->input->post("response");
        $conresponseCount = $this->m_basic->find("conditionresponse", array("conditionId"=>$condition, "responseId"=>$response))->num_rows();
        $_SESSION["notif"] = "Condition-Response successfully created.";
        $_SESSION["notifType"] = "success";
        $this->session->mark_as_flash(array("notif", "notifType"));

        //check duplicate condition-response
        if(!$conresponseCount > 0){
            $conditionCount = $this->m_basic->find("conditionresponse", array("conditionId"=>$condition, "crStatus"=>"1"))->num_rows();
            //check already used condition
            if(!$conditionCount > 0){
                $this->m_basic->insert("conditionresponse", array("appId"=>$appId, "conditionId"=>$condition, "responseId"=>$response, "userId"=>$_SESSION["userId"], "crStatus"=>1));
                redirect(base_url("conresponse/all_condition_response"));
            }else{
                $_SESSION["notif"] = 'This condition has already been used and still active';
                $_SESSION["notifType"] = "error";
                $this->session->mark_as_flash(array("notif", "notifType"));
            }
        }else{
            $_SESSION["notif"] = 'This condition and response has already been used';
            $_SESSION["notifType"] = "error";
            $this->session->mark_as_flash(array("notif", "notifType"));
        }
        redirect(base_url("conresponse/new_condition_response"));
    }

    public function edit_condition_response($crId){
        $appId = $_SESSION["appId"];

        $data["conresponse"] = $this->m_basic->find("conditionresponse", array("crId"=>$crId))->row();
        $data["condition"] = $this->m_basic->find("conditionn", array("appId"=>$appId, "conditionStatus"=>"1"))->result();
        $data["response"] = $this->m_basic->find("response", array("appId"=>$appId, "responseStatus"=>"1"))->result();

        $header = array(
            "subtitle"=>"Condition",
            "title"=>"Edit Condition Response"
        );
        $this->load->view('header', $header);
        $this->load->view('editConresponse', $data);
        $this->load->view('footer');
    }

    public function editConresponse(){
        $condition = $this->input->post("condition");
        $oldCondition = $this->input->post("oldCondition");
        $response = $this->input->post("response");
        $crId = $this->input->post("crId");

        $count = $this->m_basic->find("conditionresponse", array("conditionId"=>$condition, "responseId"=>$response))->num_rows();
        $_SESSION["notif"] = "Condition-Response successfully edited.";
        $_SESSION["notifType"] = "success";
        $this->session->mark_as_flash(array("notif", "notifType"));
        //check duplicate condition-response
        if(!$count>0){
            $conditionCount = $this->m_basic->find("conditionresponse", array("conditionId"=>$condition, "crStatus"=>"1"))->num_rows();
            //check already used condition
            if($oldCondition == $condition){
                $conditionCount--;
            }    
            if(!$conditionCount > 0){
                $this->m_basic->update(array("crId"=>$crId), "conditionresponse", array("conditionId"=>$condition, "responseId"=>$response));
                redirect(base_url("conresponse/all_condition_response"));
            }else{
                $_SESSION["notif"] = 'This condition has already been used, please use another condition';
                $_SESSION["notifType"] = "error";
                $this->session->mark_as_flash(array("notif", "notifType"));
                redirect(base_url("conresponse/edit_condition_response/").$crId);
            }
        }else{
            $_SESSION["notif"] = 'This condition has already been used, please use another condition';
            $_SESSION["notifType"] = "error";
            $this->session->mark_as_flash(array("notif", "notifType"));
            redirect(base_url("conresponse/edit_condition_response/").$crId);
        }
    }

    public function delete_condition_response($crId){
        $this->m_basic->update(array("crId"=>$crId), "conditionresponse", array("crStatus"=>"0"));
        $_SESSION["notif"] = "Condition-Response successfully deleted.";
        $_SESSION["notifType"] = "success";
        $this->session->mark_as_flash(array("notif", "notifType"));
        redirect(base_url("conresponse/all_condition_response"));
    }

    public function activate_condition_response($crId){
        $condition = $this->m_basic->find("conditionresponse", array("crId"=>$crId))->row();
        $conditionCount = $this->m_basic->find("conditionresponse", array("conditionId"=>$condition->conditionId, "crStatus"=>"1"))->num_rows();
        $_SESSION["notif"] = "Condition-Response successfully reactivated.";
        $_SESSION["notifType"] = "success";
        $this->session->mark_as_flash(array("notif", "notifType"));
        //check already used condition
        if(!$conditionCount > 0){
            $this->m_basic->update(array("crId"=>$crId), "conditionresponse", array("crStatus"=>"1"));
        }else{
            $_SESSION["notif"] = 'This condition has already been used and still active';
            $_SESSION["notifType"] = "error";
            $this->session->mark_as_flash(array("notif", "notifType"));
        }
        redirect(base_url("conresponse/all_condition_response"));
    }
}

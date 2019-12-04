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
        $appId = $_SESSION["appId"];

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
        $condition = $this->input->post("condition");
        $response = $this->input->post("response");
        $count = $this->m_basic->find("conditionresponse", array("conditionId"=>$condition, "responseId"=>$response))->num_rows();

        if($count!=0){
            $_SESSION['error'] = 'primary';
            $this->session->mark_as_flash('error');
            redirect(base_url("conresponse/new_condition_response"));
        }else{
            $this->m_basic->insert("conditionresponse", array("conditionId"=>$condition, "responseId"=>$response, "crStatus"=>1));
            redirect(base_url("conresponse/all_condition_response"));
        }
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
        $response = $this->input->post("response");
        $crId = $this->input->post("crId");

        $count = $this->m_basic->find("conditionresponse", array("conditionId"=>$condition, "responseId"=>$response))->num_rows();

        if($count!=0){
            $_SESSION['error'] = 'primary';
            $this->session->mark_as_flash('error');
            redirect(base_url("conresponse/edit_condition_response/").$crId);
        }else{
            $this->m_basic->update(array("crId"=>$crId), "conditionresponse", array("conditionId"=>$condition, "responseId"=>$response));
            redirect(base_url("conresponse/all_condition_response"));
        }
    }

    public function delete_condition_response($crId){
        $this->m_basic->update(array("crId"=>$crId), "conditionresponse", array("crStatus"=>"0"));
        redirect(base_url("conresponse/all_condition_response"));
    }

    public function activate_condition_response($crId){
        $this->m_basic->update(array("crId"=>$crId), "conditionresponse", array("crStatus"=>"1"));
        redirect(base_url("conresponse/all_condition_response"));
    }
}

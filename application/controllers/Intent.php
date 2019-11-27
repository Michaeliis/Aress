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
        $appId = $_SESSION["appId"];

        $data["intent"] = $this->m_basic->find("intent", array("appId"=>$appId))->result();

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
        $intentDetail = $this->input->post("intentDetail");

        $json = array("value"=>$intentName);

        $response = doStuff("/entities/intent/values", null, $json, $appToken);

        $this->m_basic->insert("intent", array("intentName"=>$intentName, "appId"=>$appId, "intentDetail"=>$intentDetail, "intentStatus"=>"1"));
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
        $intentId = $this->input->post("intentId");
        $intentName = $this->input->post("intentName");
        $intentDetail = $this->input->post("intentDetail");

        $this->m_basic->update(array("intentId"=>$intentId), "intent", array("intentName"=>$intentName, "intentDetail"=>$intentDetail));
        redirect(base_url("intent/all_intent"));
    }

    public function delete_intent($intentId){
        $appToken = $_SESSION["appToken"];

        $intent = $this->m_basic->find("intent", array("intentId"=>$intentId))->row();
        deleteStuff("/entities/intent/values/".$intent->intentName, $appToken);

        $this->m_basic->update(array("intentId"=>$intentId), "intent", array("intentStatus"=>"0"));
        redirect(base_url("intent/all_intent"));
    }

    public function activate_intent($intentId){
        $appToken = $_SESSION["appToken"];
        
        $intent = $this->m_basic->find("intent", array("intentId"=>$intentId))->row();
        $json = array("value"=>$intent->intentName);

        $response = doStuff("/entities/intent/values", null, $json, $appToken);

        $this->m_basic->update(array("intentId"=>$intentId), "intent", array("intentStatus"=>"1"));
        redirect(base_url("intent/all_intent"));
    }
}

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

        $data["condition"] = $this->m_basic->find("conditionn", array("appId"=>$appId))->result();
        $data["response"] = $this->m_basic->find("response", array("appId"=>$appId))->result();

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
}

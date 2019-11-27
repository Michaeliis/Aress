<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conversation extends CI_Controller {
    
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
    
    public function all_flow(){
        $appId = $_SESSION["appId"];

        $data["conversationflow"] = $this->m_basic->find("conversationflow", array("appId"=>$appId))->result();

        $header = array(
            "subtitle"=>"Conversation Flow",
            "title"=>"All Conversation Flow"
        );
        $this->load->view('header', $header);
        $this->load->view('allConversationFlow', $data);
        $this->load->view('footer');
    }

    public function new_conversation_flow(){
        $appId = $_SESSION["appId"];
        
        $data["condition"] = $this->m_basic->find("condition", array("appId"=>$appId, "conditionStatus"=>"1"));
        $data["response"] = $this->m_basic->find("response", array("appId"=>$appId, "responseStatus"=>"1"));

        $header = array(
            "subtitle"=>"Conversation Flow",
            "title"=>"New Conversation Flow"
        );
        $this->load->view('header', $header);
        $this->load->view('newConversationFlow');
        $this->load->view('footer');
    }

    public function newConversationFlow(){
        $appId = $_SESSION["appId"];

        $conversationFlowName = $this->input->post("conversationFlowName");
        $conversationFlowDetail = $this->input->post("conversationFlowDetail");

        $conditionBefore = $this->input->post("conditionBefore");
        $conditionId = $this->input->post("conditionId");
        $responseId = $this->input->post("responseId");

        $conversationFlowId = $this->m_basic->insert("conversationFlow", array("appId"=>$appId, "conversationFlowName"=>$conversationFlowName, "conversationFlowDetail"=>$conversationFlowDetail, "conversationFlowStatus"=>"1"));

        foreach($conditionBefore as $counter =>$conditionBefores){
            $this->m_basic->insert("conversationstate", array("conditionId"=>$conditionId[$counter], "conditionBefore"=>$conditionBefores, "conversationFlowId"=>$conversationFlowId, "responseId"=>$responseId[$counter], "conversationStateStatus"=>"1"));
        }

        redirect(base_url("conversation/all_conversation"));
    }

    public function edit_conversation($conversationFlowId){
        $appId = $_SESSION["appId"];

        $data["conversationflow"] = $this->m_basic->find("conversationFlow", array("conversationFlowId"=>$conversationFlowId, "appId"=>$appId))->row();
        $data["conversationstate"] = $this->m_basic->find("conversationstate", array("conversationFlowId"=>$conversationFlowId))->row();
        $header = array(
            "subtitle"=>"Conversation Flow",
            "title"=>"Edit Conversation Flow"
        );
        $this->load->view('header', $header);
        $this->load->view('editIntent', $data);
        $this->load->view('footer');
    }
}

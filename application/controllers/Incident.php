<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incident extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }
    
    public function all_message(){
        $data['message'] = $this->m_basic->gets('message')->result();

        $header = array(
            "subtitle"=>"Incident",
            "title"=>"Incident List"
        );
        $this->load->view('header', $header);
        $this->load->view('msgAll', $data);
        $this->load->view('footer');
    }

    public function resolve($msgId){
        $data['msgInfo'] = $this->m_basic->find('message', array("msgId"=>$msgId))->row();
        $data['firstChat'] = $this->m_default->getFirstChat('chat', array("msgId"=>$msgId))->row();
        $data['restChat'] = $this->m_default->getRestChat('chat', array("msgId"=>$msgId))->result();
        $data['msgId'] = $msgId;
        $header = array(
            "subtitle"=>"Incident",
            "title"=>"Resolve"
        );
        $this->load->view('header', $header);
        $this->load->view('resolve', $data);
        $this->load->view('footer');
    }

    public function edit_resolve($msgId){
        $data['msgInfo'] = $this->m_basic->find('message', array("msgId"=>$msgId))->result();
        $data['firstChat'] = $this->m_default->getFirstChat('chat', array("msgId"=>$msgId))->result();
        $data['restChat'] = $this->m_default->getRestChat('chat', array("msgId"=>$msgId))->result();
        $data['msgId'] = $msgId;

        $header = array(
            "subtitle"=>"Incident",
            "title"=>"Resolve Edit"
        );
        $this->load->view('header', $header);
        $this->load->view('editResolve', $data);
        $this->load->view('footer');
    }

    public function editResolve($msgId){
        $impact = $this->input->post("impact");
        $urgency = $this->input->post("urgency");
        $priority = $this->input->post("priority");
        $team = $this->input->post("team");
        $agent = $this->input->post("agent");
        $resolution = $this->input->post("resolution");

        $data = array(
            "msgImpact"=>$impact,
            "msgUrgency"=>$urgency,
            "msgPriority"=>$priority,
            "msgTeam"=>$team,
            "msgReceiver"=>$agent
        );
        $where = array("msgId"=>$msgId);

        $this->m_basic->update($where, "message", $data);
    }
}

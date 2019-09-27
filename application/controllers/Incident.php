<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incident extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('M_basic');
    }
    
    public function message_all(){
        $data['message'] = $this->M_basic->gets('message')->result();

        $header = array(
            "subtitle"=>"Incident",
            "title"=>"Incident List"
        );
        $this->load->view('header', $header);
        $this->load->view('msgAll', $data);
        $this->load->view('footer');
    }

    public function resolve($msgId){
        $data['msgInfo'] = $this->M_basic->find('message', array("msgId"=>$msgId))->result();
        $data['firstChat'] = $this->m_default->getFirstChat('chat', array("msgId"=>$msgId))->result();
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

    public function resolve_edit($msgId){
        $data['msgInfo'] = $this->M_basic->find('message', array("msgId"=>$msgId))->result();
        $data['firstChat'] = $this->m_default->getFirstChat('chat', array("msgId"=>$msgId))->result();
        $data['restChat'] = $this->m_default->getRestChat('chat', array("msgId"=>$msgId))->result();
        $data['msgId'] = $msgId;

        $header = array(
            "subtitle"=>"Incident",
            "title"=>"Resolve Edit"
        );
        $this->load->view('header', $header);
        $this->load->view('resolveEdit', $data);
        $this->load->view('footer');
    }

    public function modify($msgId){
        $impact = $this->input->post("impact");
        $urgency = $this->input->post("urgency");
        $priority = $this->input->post("priority");
        $team = $this->input->post("team");
        $agent = $this->input->post("agent");
        $resolution = $this->input->post("resolution");

        $where = array("msgId"=>$msgId);
    }
}

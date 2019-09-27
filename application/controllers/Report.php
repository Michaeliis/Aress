<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('M_basic');
	}
	
    public function chat($msgId){
        $data['msgInfo'] = $this->M_basic->find('message', array("msgId"=>$msgId))->result();
        $data['chat'] = $this->M_basic->find('chat', array("msgId"=>$msgId))->result();

        $header = array(
            "collapse"=>true,
            "subtitle"=>"Report",
            "title"=>"Mail"
        );
        $this->load->view('header', $header);
        $this->load->view('messageSide');
        $this->load->view('chat', $data);
        $this->load->view('footer');
    }

    public function compose(){
        $header = array(
            "collapse"=>true,
            "subtitle"=>"Report",
            "title"=>"New Report"
        );
        $this->load->view('header', $header);
        $this->load->view('messageSide');
        $this->load->view('compose');
        $this->load->view('footer');
    }
    
    public function sendReport(){
        //tarik data form
        $message = $this->input->post('report');
        $subject = $this->input->post('subject');
        //$msgReceiver = $this->input->post('to');

        //tarik data session
        $msgSender = "Saya";

        //tarik tanggal
        $curDate = date("Y-m-d H:i:s");
        $msgId = date("YmdHis");

        //interact dengan NLP
        $server_output = doStuff("message", $message, null);
        
        $result = json_decode($server_output);
        
        if(isset($result->entities->intent[0]->value)){
            $intent = $result->entities->intent[0]->value;
            
            $querRes = $this->m_default->getResponse($intent)->result();
            foreach($querRes as $querRess){
                $answer = $querRess->response;
                $category = $querRess->category;
                $assignedTo = $querRess->assignedTo;
            }
            
        }else{
            $answer = "no intent";
        }
        
        //insert message baru
        $data = array(
            "msgId"=>$msgId,
            "msgSubject"=>$subject,
            "msgSender"=>$msgSender,
            "msgCategory"=>$category,
            "msgReceiver"=>$assignedTo,
            "msgDate"=>$curDate,
            "msgStatus"=>1
        );
        $this->M_basic->insert('message', $data);

        //insert chat baru
        $data = array(
            "msgId"=>$msgId,
            "chatId"=>$msgId,
            "chatSender"=>$msgSender,
            "chatReceiver"=>$assignedTo,
            "chatContent"=>$message,
            "chatDate"=>$curDate,
            "chatStatus"=>1
        );
        $this->M_basic->insert('chat', $data);
        
        //insert chat balasan bot
        $data = array(
            "msgId"=>$msgId,
            "chatId"=>"reply",
            "chatSender"=>"Ares",
            "chatReceiver"=>$msgSender,
            "chatContent"=>$answer,
            "chatDate"=>$curDate,
            "chatStatus"=>1
        );
        $this->M_basic->insert('chat', $data);
    }

    public function inbox(){
        //$data['message'] = $this->M_basic->find('message', array('msgReceiver'=>'Ares'))->result();

        $data['message'] = $this->M_basic->gets('message')->result();
        $header = array(
            "collapse"=>true,
            "subtitle"=>"Report",
            "title"=>"Report List"
        );
        $this->load->view('header', $header);
        $this->load->view('messageSide');
        $this->load->view('messageList', $data);
        $this->load->view('footer');
    }
}

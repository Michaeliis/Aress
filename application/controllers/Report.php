<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
        $this->load->library('session');
	}
	
    public function chat($msgId){
        $data['msgInfo'] = $this->m_basic->find('message', array("msgId"=>$msgId))->result();
        $data['chat'] = $this->m_basic->find('chat', array("msgId"=>$msgId))->result();

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
        $this->load->view('newMessage');
        $this->load->view('footer');
    }
    
    public function confirm_report(){
        //tarik data form
        $message = $this->input->post('report');
        $subject = $this->input->post('subject');
        $userFile = $this->input->post('userFile');
        //$msgReceiver = $this->input->post('to');

        //tarik data session
        $msgSender = "Saya";

        //tarik tanggal
        $curDate = date("Y-m-d H:i:s");
        $msgId = date("YmdHis");

        $fileAttached = "";

        //upload file
        if(isset($userFile)){
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 10240;
            $config['file_name'] = date("YmdHis");

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('userfile'))
            {
                $error = array('error' => $this->upload->display_errors());

                echo $error;
            }
            else
            {
                $fileValues = $this->upload->data();
                $fileExt = $fileValues['file_ext'];
                $fileName = $fileValues['file_name'];

                $fileData = array(
                    "fileName"=>$fileName,
                    "fileExtension"=>$fileExt
                );
                //insert file ke db
                $_SESSION["confirmReport"]["userFile"] = $userFile;
                $_SESSION["confirmReport"]["fileData"] = $fileData;
                //$this->m_basic->insert("file", $fileData);
            }
        }
        

        //interact dengan NLP
        $server_output = doStuff("message", strip_tags($message), null);
        
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
        $_SESSION["confirmReport"]["message"] = $data;
        //$this->m_basic->insert('message', $data);

        //insert chat baru
        $data = array(
            "msgId"=>$msgId,
            "chatId"=>$msgId,
            "chatSender"=>$msgSender,
            "chatReceiver"=>$assignedTo,
            "chatContent"=>$message,
            "chatDate"=>$curDate,
            "fileName"=>$fileAttached,
            "chatStatus"=>1
        );
        //$this->m_basic->insert('chat', $data);
        $_SESSION["confirmReport"]["chat"][0] = $data;
        
        //insert chat balasan bot
        $data = array(
            "msgId"=>$msgId,
            "chatId"=>"reply",
            "chatSender"=>"Ares",
            "chatReceiver"=>$msgSender,
            "chatContent"=>$answer,
            "chatDate"=>$curDate,
            "fileName"=>"",
            "chatStatus"=>1
        );
        //$this->m_basic->insert('chat', $data);
        $_SESSION["confirmReport"]["chat"][1] = $data;

        $data["category"] = $this->m_basic->gets("category")->result();

        $header = array(
            "collapse"=>true,
            "subtitle"=>"Report",
            "title"=>"Confirm Report"
        );
        $this->load->view('header', $header);
        $this->load->view('messageSide');
        $this->load->view('confirm_report', $data);
        $this->load->view('footer');
    }

    public function sendReport(){
        $category = $this->input->post('category');
        $_SESSION["confirmReport"]["message"]["msgCategory"] = $category;
        if(isset($_SESSION["confirmReport"]["fileData"])){
            $this->m_basic->insert("file", $_SESSION["confirmReport"]["fileData"]);
        }
        $this->m_basic->insert('message', $_SESSION["confirmReport"]["message"]);
        $this->m_basic->insert('chat', $_SESSION["confirmReport"]["chat"][0]);
        $this->m_basic->insert('chat', $_SESSION["confirmReport"]["chat"][1]);
        $msgId = $_SESSION["confirmReport"]["message"]["msgId"];
        
        $data['msgInfo'] = $this->m_basic->find('message', array("msgId"=>$msgId))->result();
        $data['chat'] = $this->m_basic->find('chat', array("msgId"=>$msgId))->result();

        redirect(base_url('report/chat/'). $msgId);
    }

    public function inbox(){
        //$data['message'] = $this->m_basic->find('message', array('msgReceiver'=>'Ares'))->result();

        $data['message'] = $this->m_basic->gets('message')->result();
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

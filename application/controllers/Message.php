<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
    
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
    
    public function all_message(){
        $appId = $_SESSION["appId"];
        $data["message"] = $this->m_basic->find("message", array("appId"=>$appId))->result();

        $header = array(
            "subtitle"=>"Message",
            "title"=>"All Message"
        );
        $this->load->view('header', $header);
        $this->load->view('allMessage', $data);
        $this->load->view('footer');
    }

    public function view_message($messageId){
        $message = $this->m_basic->find("message", array("messageId"=>$messageId))->row();

        $data["message"] = $message;

        $data["messageResponse"] = json_decode($message->messageResponse, true);
        $header = array(
            "subtitle"=>"Message",
            "title"=>"View Message"
        );
        $this->load->view('header', $header);
        $this->load->view('viewMessage', $data);
        $this->load->view('footer');
    }

    public function viewJson(){
        echo json_encode(array("test"=>"test value", "reply"=>"Ok then"));
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contest extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('M_basic');
	}
	public function index()
	{
		$this->load->view("testhome");
    }
    
    public function testConverse(){
        $this->load->view('test');
    }
    
    public function newIntent(){
        $this->load->view('testnew_intent');
    }
    
    public function converse(){
        $text = $this->input->post("text");

        $server_output = doStuff("message", $text, null);
        
        $result = json_decode($server_output);
        
        if(isset($result->entities->intent[0]->value)){
            $intent = $result->entities->intent[0]->value;
            
            $querRes = $this->m_default->getResponse($intent)->result();
            foreach($querRes as $querRess){
                $answer = $querRess->response;
            }
            
        }else{
            $answer = "no intent";
        }
        
        $data = array(
            "text"=>$text,
            "answer"=>$answer
        );
        
        $this->load->view("test2", $data);
    }
}

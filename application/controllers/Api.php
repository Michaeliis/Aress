<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }
    
    public function testApi(){
        $input = json_decode(file_get_contents('php://input'),true);
        $text = $input['text'];
        $message = strip_tags($input['text']);
        
        //interact dengan NLP
        $server_output = doStuff("message", strip_tags($message), null);
        
        $result = json_decode($server_output);
        
        //mengecek apa intent ada dalam sistem
        if(isset($result->entities->intent[0]->value)){
            $intent = $result->entities->intent[0]->value;
            
            $querRes = $this->m_default->getResponse($intent)->result();
            foreach($querRes as $querRess){
                $answer = $querRess->response;
                $category = $querRess->category;
                $assignedTo = $querRess->assignedTo;

                $text = $text . 
            "<b>Reply (bot)</b><br>
<p>". $answer."</p>";
            echo json_encode(array("reply"=>$text));
            }
            
        }else{
            echo json_encode(array("reply"=>$text));
        }
    }

}
?>
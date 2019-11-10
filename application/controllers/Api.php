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
        $data = strip_tags($input['text']);
        $ticketId = $input['id'];
        
        $text = $text . 
        "<b>Reply (bot)</b><br>
<p>This is the reply to ". $data."</p>";
        echo json_encode(array("reply"=>$text));
    }

    public function shootIt(){
        $url = "http://localhost:8080/Aress/api/testapi";

        $data = array("text"=>"description");

        $client = curl_init($url);
        curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($client, CURLOPT_POST, 1);
        curl_setopt($client, CURLOPT_POSTFIELDS, json_encode($data));
        $response = json_decode(curl_exec($client));

        echo $response->reply;
    }

    public function blob(){
        $result = $this->m_basic->gets('blobb')->result();
        foreach($result as $results){
            echo $results->blobb;
        }
    }

    public function insertBlob(){
        
    }

}
?>
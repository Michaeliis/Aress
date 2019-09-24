<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contest extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
	}
	public function index()
	{
		$this->load->view("home");
    }
    
    public function testConverse(){
        $this->load->view('test');
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

    public function newIntent(){
        $this->load->view('new_intent');
    }

    public function insertIntent(){
        $intentName = $this->input->post("intentName");
        $keyword = $this->input->post("keyword1");
        $keyword2 = $this->input->post("keyword2");
        $sample = $this->input->post("sample");
        

        //untuk memasukkan keyword baru berupa intent
        $json1 = json_encode(array("value"=>$intentName));
        echo $json1. "<br>";
        $server_output1 = doStuff("entities/intent", null, $json1);

        //untuk memasukkan intent baru
        $json = json_encode(array("id"=>$keyword));
        echo $json. "<br>";
        $server_output = doStuff("entities/", null, $json);
        //untuk memasukkan keyword baru
        $json1 = json_encode(array("value"=>$keyword));
        echo $json1. "<br>";
        $server_output1 = doStuff("entities/".$keyword, null, $json1);

        //untuk memasukkan intent baru
        $json = json_encode(array("id"=>$keyword2));
        echo $json. "<br>";
        $server_output = doStuff("entities/", null, $json);
        //untuk memasukkan keyword baru
        $json1 = json_encode(array("value"=>$keyword2));
        echo $json1. "<br>";
        $server_output1 = doStuff("entities/".$keyword2, null, $json1);


        $posKey1 = strpos($sample, $keyword);
        $endKey1 = $posKey1 + strlen($keyword);
        $posKey2 = strpos($sample, $keyword2);
        $endKey2 = $posKey2 + strlen($keyword2);
        
        //untuk memasukkan sample
        $sampleJson[0] = array(
            "text"=>$sample,
            "entities"=>array(
                array(
                    "entity"=>"intent",
                    "value"=>$intentName
                ),
                array(
                    "entity"=>$keyword,
                    "value"=>$keyword,
                    "start"=>$posKey1,
                    "end"=>$endKey1,
                    "value"=>$keyword
                ),
                array(
                    "entity"=>$keyword2,
                    "value"=>$keyword2,
                    "start"=>$posKey2,
                    "end"=>$endKey2,
                    "value"=>$keyword2
                )
                
            )
            
        );

        //untuk memasukkan sample baru
        $json1 = json_encode($sampleJson);
        echo $json1. "<br>";
        $server_output1 = doStuff("samples/", null, $json1);
        
        echo "Intent telah dibuat";
    }

    public function nyoba(){
        $this->load->view('chat');
    }

    public function nyobawys(){
        echo $this->input->post('beta'). "<br>";
        echo $this->input->post('elijah');
        echo "sup";
    }

    public function supbro(){
        echo "sup";
    }
}

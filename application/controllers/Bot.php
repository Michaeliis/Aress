<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bot extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('M_basic');
	}
    
    public function newIntent(){
        $this->load->view('new_intent');
    }

    public function train_bot(){
        $data['response'] = $this->M_basic->gets('response')->result();

        $header = array(
            "subtitle"=>"Train",
            "title"=>"Train Bot"
        );
        $this->load->view('header', $header);
        $this->load->view('trainbot', $data);
        $this->load->view('footer');
    }

    public function insertIntent(){
        $intentName = $this->input->post("intent");
        $sample = $this->input->post("sample");
        $keyword = $this->input->post('keyword');
        $synonym = $this->input->post('synonym');
        $category = $this->input->post('category');
        $assign = $this->input->post('assign');
        $response = $this->input->post('response');
        
        //untuk memasukkan intent baru 
        $json1 = json_encode(array("value"=>$intentName));
        echo $json1. "<br>";
        $server_output1 = doStuff("entities/intent", null, $json1);
        //ke DB
        $dataIntentDb = array(
            "intent"=>$intentName,
            "response"=>$response,
            "category"=>$category,
            "assignedTo"=>$assign
        );
        $this->M_basic->insert("response", $dataIntentDb);


        //untuk memasukkan sample
        $sampleJson[0] = array(
            "text"=>$sample,
            "entities"=>array(
                array(
                    "entity"=>"intent",
                    "value"=>$intentName
                )
                
            )
            
        );

        $counter = 0;
        foreach($keyword as $keywords){
            echo $keywords;
            echo $synonym[$counter];

            //untuk memasukkan entity baru
            $json = json_encode(array("id"=>$keywords));
            echo $json. "<br>";
            $server_output = doStuff("entities/", null, $json);

            //untuk memasukkan keyword baru
            $infoKeyword = array(
                "values"=>array(
                    "value"=>$keywords,
                    "expressions"=>array($synonym[$counter])
                    )
            );
            $json1 = json_encode($infoKeyword);
            echo $json1. "<br>";
            $server_output1 = doStuff("entities/".$keywords, null, $json1);

            //menambahkan keywords ke json sample
            $posKey = strpos($sample, $keywords);
            $endKey = $posKey + strlen($keywords);

            $sampleJson[0]["entities"][] = array(
                "entity"=>$keywords,
                "value"=>$keywords,
                "start"=>$posKey,
                "end"=>$endKey,
                "value"=>$keywords
            );

            $counter++;
        }

        //untuk memasukkan sample baru
        $json1 = json_encode($sampleJson);
        echo $json1. "<br>";
        $server_output1 = doStuff("samples/", null, $json1);
        
        echo "Intent telah dibuat";
    }
}

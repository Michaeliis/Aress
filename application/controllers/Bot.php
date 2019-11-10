<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bot extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
	}

    public function train_bot(){
        $data['response'] = $this->m_basic->gets('response')->result();
        $data['category'] = $this->m_basic->gets('category')->result();
        $data['user'] = $this->m_basic->gets('user')->result();

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
        $this->m_basic->insert("response", $dataIntentDb);


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
            //untuk memasukkan entity baru
            $json = json_encode(array("id"=>$keywords));
            echo $json. "<br>";
            $server_output = doStuff("entities/", null, $json);

            //untuk memasukkan keyword baru
            $keywordsArray = explode(", ", $synonym[$counter]);
            $infoKeyword = array(
                "value"=>$keywords,
                "expressions"=>$keywordsArray
            );
            $json1 = json_encode($infoKeyword);
            echo $json1. "<br>";
            $server_output1 = doStuff("entities/".str_replace(" ", "_", $keywords), null, $json1);
            //masukkan keyword ke db
            $this->m_basic->insert("keyword", array("entity"=>$keywords, "keyword"=>$keywords));
            foreach($keywordsArray as $keywordsArrays){
                $this->m_basic->insert("keyword", array("entity"=>$keywords, "keyword"=>$keywordsArrays));
            }

            //menambahkan keywords ke json sample
            $posKey = strpos($sample, $keywords);
            $endKey = $posKey + strlen($keywords);

            $sampleJson[0]["entities"][] = array(
                "entity"=>str_replace(" ", "_", $keywords),
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
        echo "<br><br><br>". $server_output1;
        
        echo "Intent telah dibuat";
    }

    public function all_response(){
        $data['response'] = $this->m_basic->gets('response')->result();

        $header = array(
            "subtitle"=>"Response",
            "title"=>"All Response"
        );
        $this->load->view('header', $header);
        $this->load->view('allIntent', $data);
        $this->load->view('footer');
    }

    public function testJson(){
        $this->load->view('testJson');
    }

    public function converse(){
        $message = $this->input->post('text');

        $server_output = doStuff("message", strip_tags($message), null);
        
        echo $server_output;
    }

    public function query(){
        echo $this->db->last_query();
    }
}

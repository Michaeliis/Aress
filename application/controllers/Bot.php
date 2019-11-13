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

        $data['entity'] = $this->m_basic->gets('entity')->result();

        $header = array(
            "subtitle"=>"Train",
            "title"=>"Train Bot"
        );
        $this->load->view('header', $header);
        $this->load->view('testNewSample', $data);
        $this->load->view('footer');
    }

    public function insertIntent(){
        $intentName = $this->input->post("intent");
        $category = $this->input->post('category');
        $assign = $this->input->post('assign');
        $sample = $this->input->post("sample");
        $entity = $this->input->post("entity");
        $value = $this->input->post("value");
        $start = $this->input->post("start");
        $end = $this->input->post("end");
        $response = $this->input->post('response');

        //memasukkan response ke DB
        $responseId = "";
        $response = array(
            "responseId"=>$responseId,
            "response"=>$response,
            "category"=>$category,
            "assignedTo"=>$assign
        );
        $this->m_basic->insert("response", $response);
        //menambahkan responseDetail
        $responseDetail = array(
            "responseId"=>$responseId,
            "entity"=>"intent",
            "value"=>$value
        );
        $this->m_basic->insert("responseDetail", $responseDetail);

        //untuk memasukkan intent ke json sample
        $sampleJson[0] = array(
            "text"=>$sample,
            "entities"=>array(
                array(
                    "entity"=>"intent",
                    "value"=>$intentName
                )
                
            )
            
        );

        foreach($entity as $counter => $entities){
            //menambahkan keywords ke json sample
            $sampleJson[0]["entities"][] = array(
                "entity"=>$entities,
                "start"=>$start[$counter],
                "end"=>$end[$counter],
                "value"=>$value[$counter]
            );

            //menambahkan responseDetail
            $responseDetail = array(
                "responseId"=>$responseId,
                "entity"=>$entities,
                "value"=>$value
            );
            $this->m_basic->insert("responseDetail", $responseDetail);
        }

        //untuk memasukkan sample baru ke Wit.ai
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

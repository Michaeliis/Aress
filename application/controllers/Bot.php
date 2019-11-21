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
        $appId = "1";
        $item = $this->m_basic->find('item', array("appId"=>$appId))->result();
        $data["itemOption"] = array();
        foreach($item as $items){
            if($items->itemValue == "select"){
                $data["itemOption"][$items->itemId] = $this->m_basic->find("itemoption", array("itemId"=>$items->itemId))->result_array();
            }
        }

        $data['item'] = $item;
        $data['entity'] = $this->m_basic->gets('entity')->result();

        $header = array(
            "subtitle"=>"Train",
            "title"=>"Train Bot"
        );
        $this->load->view('header', $header);
        $this->load->view('trainbot', $data);
        $this->load->view('footer');
    }

    public function check(){
        $appId = "1";
        $responseId = "";

        $item = $this->m_basic->find("item", array("appId"=>$appId))->result();
        foreach($item as $items){
            $output[$items->itemId] = $this->input->post($items->itemId);
        }

        //memasukkan responseDetail ke db
        foreach($output as $responseTitle => $responseValue){
            $responseDetail = array(
                "responseId"=>$responseId,
                "responseTitle"=>$responseTitle,
                "responseValue"=>$responseValue
            );
            echo json_encode($responseDetail). "<br>";
            //$this->m_basic->insert("responsedetail", $responseDetail);
        }

        echo $this->input->post("Response TextArea");
    }

    public function insertIntent(){
        $appId = "1";

        $intentName = $this->input->post("intent");
        $sample = $this->input->post("sample");
        $entity = $this->input->post("entity");
        $value = $this->input->post("value");
        $start = $this->input->post("start");
        $end = $this->input->post("end");

        $item = $this->m_basic->find("item", array("appId"=>$appId))->result();
        foreach($item as $items){
            $output[$items->itemId] = $this->input->post($items->itemId);
        }

        $sampleId = date("YmdHis");

        //memasukkan response ke DB
        $conditionId = "";
        $responseId = "";
        $response = array(
            "conditionId"=>$conditionId,
            "responseId"=>$responseId
        );
        $this->m_basic->insert("response", $response);

        //memasukkan responseDetail ke db
        foreach($output as $responseTitle => $responseValue){
            $responseDetail = array(
                "responseId"=>$responseId,
                "responseTitle"=>$responseTitle,
                "responseValue"=>$responseValue
            );
            //$this->m_basic->insert("responsedetail", $responseDetail);
        }
        
        //menambahkan sample intent ke db
        $sampleIntent = array(
            "sampleId"=>$responseId,
            "intentName"=>$intentName
        );
        $this->m_basic->insert("sampleintent", $sampleIntent);

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
            
            //memasukkan detail sample ke db
            $sampleDetail = array(
                "responseId"=>$responseId,
                "entityName"=>$entities,
                "valueName"=>$value[$counter]
            );
            $this->m_basic->insert("sampleentity", $sampleDetail);
        }

        //untuk memasukkan sample baru ke Wit.ai
        $json1 = json_encode($sampleJson);
        echo $json1. "<br>";
        $server_output1 = doStuff("samples/", null, $json1);
        echo "<br><br><br>". $server_output1;

        //memasukkan sample baru ke db
        $this->m_basic->insert("sample", array("sampleId"=>$sampleId, "date"=>date("Y-m-d")));
        
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends CI_Controller {
    
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

    public function all_sample(){
        $appId = $_SESSION["appId"];
        $data['sample'] = $this->m_basic->find('sample', array("appId"=>$appId))->result();

        $header = array(
            "subtitle"=>"Sample",
            "title"=>"All Sample"
        );
        $this->load->view('header', $header);
        $this->load->view('allSample', $data);
        $this->load->view('footer');
    }

    public function new_sample(){
        $appId = $_SESSION["appId"];
        $data['entity'] = $this->m_basic->find('entity', array("appId"=>$appId, "entityStatus"=>"1"))->result();

        $header = array(
            "subtitle"=>"Sample",
            "title"=>"New Sample"
        );
        $this->load->view('header', $header);
        $this->load->view('trainbot', $data);
        $this->load->view('footer');
    }

    public function newSample(){
        $appId = $_SESSION["appId"];
        $appToken = $_SESSION["appToken"];

        $intentName = $this->input->post("intent");
        $sample = $this->input->post("sample");
        $entityId = $this->input->post("entity");
        $valueId = $this->input->post("value");
        $start = $this->input->post("start");
        $end = $this->input->post("end");

        //convert entity id jadi entity value
        foreach($entityId as $entityIds){
            $resultValue = $this->m_basic->find("entity", array("entityId"=>$entityIds))->row();
            $entity[] = $resultValue->entityName;
        }
        foreach($valueId as $valueIds){
            $resultValue = $this->m_basic->find("value", array("valueId"=>$valueIds))->row();
            $value[] = $resultValue->value;
        }

        //menambahkan sample ke db
        $sampleDb = array(
            "appId"=>$appId,
            "sampleText"=>$sample,
            "sampleDate"=>date("Y-m-d"),
            "sampleStatus"=>"1"
        );
        $sampleId = $this->m_basic->insert("sample", $sampleDb);
        
        //menambahkan sample intent ke db
        $sampleIntent = array(
            "sampleId"=>$sampleId,
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
                "sampleId"=>$sampleId,
                "entityName"=>$entities,
                "valueName"=>$value[$counter]
            );
            $this->m_basic->insert("sampleentity", $sampleDetail);
        }

        //untuk memasukkan sample baru ke Wit.ai
        $json1 = json_encode($sampleJson);
        echo $json1. "<br>";
        $server_output1 = doStuff("samples/", null, $json1, $appToken);
        echo "<br><br><br>". $server_output1;
        
        echo "Intent telah dibuat";
    }

    public function delete_sample($sampleId){
        
    }
}

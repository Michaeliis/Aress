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
        $item = $this->m_basic->find('item', array("appId"=>$appId, "itemStatus"=>"1"))->result();
        $data["itemOption"] = array();
        foreach($item as $items){
            if($items->itemValue == "select"){
                $data["itemOption"][$items->itemId] = $this->m_basic->find("itemoption", array("itemId"=>$items->itemId, "itemOptionStatus"=>"1"))->result_array();
            }
        }

        $data['item'] = $item;
        $data['entity'] = $this->m_basic->find('entity', array("appId"=>$appId, "entityStatus"=>"1"))->result();

        $header = array(
            "subtitle"=>"Train",
            "title"=>"Train Bot"
        );
        $this->load->view('header', $header);
        $this->load->view('trainbot', $data);
        $this->load->view('footer');
    }

    public function insertConditionResponse(){
        $appId = "1";
        $appToken = "KQNFYUHSVRGMQJKL6GULGD62FGP5E5Y6";

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

        //ambil item dari form
        $item = $this->m_basic->find("item", array("appId"=>$appId, "itemStatus"=>"1"))->result();
        foreach($item as $items){
            $output[$items->itemName] = $this->input->post($items->itemId);
        }

        $sampleId = date("YmdHis");

        //memasukkan response & condition ke DB
        $conditionName = date("YmdHis");
        $responseName = date("YmdHis");

        $responseId = $this->m_basic->insert("response", array("appId"=>$appId, "responseName"=>$responseName, "responseStatus"=>"1"));
        $conditionId = $this->m_basic->insert("conditionn", array("appId"=>$appId, "conditionName"=>$conditionName, "conditionCount"=>count($value),  "conditionStatus"=>"1"));
        
        $conditionresponse = array(
            "conditionId"=>$conditionId,
            "responseId"=>$responseId,
            "crStatus"=>"1"
        );
        $this->m_basic->insert("conditionresponse", $conditionresponse);

        //memasukkan responseDetail ke db
        foreach($output as $responseTitle => $responseValue){
            $responseDetail = array(
                "responseId"=>$responseId,
                "responseTitle"=>$responseTitle,
                "responseValue"=>$responseValue,
                "responseDetailStatus"=>"1"
            );
            $this->m_basic->insert("responsedetail", $responseDetail);
        }

        //menambahkan sample ke db
        $sampleDb = array(
            "appId"=>$appId,
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

        //memasukkan intent ke conditionintent di db
        $conditionIntent = array(
            "conditionId"=>$conditionId,
            "conditionIntent"=>$intentName,
            "conditionIntentStatus"=>"1"
        );
        $this->m_basic->insert("conditionintent", $conditionIntent);

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

            //memasukkan entities ke conditiondetail di db
            $conditionDetail = array(
                    "conditionId"=>$conditionId,
                    "conditionEntity"=>$entities,
                    "conditionValue"=>$value[$counter],
                    "conditionStatus"=>"1"
            );
            $this->m_basic->insert("conditiondetail", $conditionDetail);
        }

        //untuk memasukkan sample baru ke Wit.ai
        $json1 = json_encode($sampleJson);
        echo $json1. "<br>";
        $server_output1 = doStuff("samples/", null, $json1, $appToken);
        echo "<br><br><br>". $server_output1;
        
        echo "Intent telah dibuat";
    }
}

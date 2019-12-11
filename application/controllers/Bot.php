<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bot extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
        $this->load->model('m_witai');

        $this->load->library("session");

        if(!isset($_SESSION["userId"])){
            redirect(base_url("login/login"));
        }
	}

    public function train_bot(){
        $appId = $_SESSION["appId"];
        
        $item = $this->m_basic->find('item', array("appId"=>$appId, "itemStatus"=>"1"))->result();
        $data['intent'] = $this->m_basic->find('intent', array("appId"=>$appId, "intentStatus"=>"1"))->result();
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
        $appId = $_SESSION["appId"];
        $appToken = $_SESSION["appToken"];

        $intentName = $this->input->post("intent");
        $sample = $this->input->post("sample");
        $entityId = $this->input->post("entity");
        $valueId = $this->input->post("value");
        $start = $this->input->post("start");
        $end = $this->input->post("end");
        $conditionName = $this->input->post("conditionName");
        $responseName = $this->input->post("responseName");

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

        //cek conditionName
        $conditionCount = $this->m_basic->find("conditionn", array("conditionName"=>$conditionName, "appId"=>$appId))->num_rows();
        if(!$conditionCount > 0){
            //cek intent dan detail condition serupa
            $entityList["intent"] = $intentName;
            foreach($entity as $counter => $entities){
                $entityList[$entities] = $value[$counter];
            }
            $entityCheck = $this->m_witai->searchCondition($entityList, $appId)->num_rows();
            if(!$entityCheck > 0){

                //cek responseName
                $responseCount = $this->m_basic->find("response", array("responseName"=>$responseName, "appId"=>$appId))->num_rows();
                if(!$responseCount > 0){
                    //interact dengan wit.ai
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
                    }
                    //untuk memasukkan sample baru ke Wit.ai
                    $json1 = json_encode($sampleJson);
                    $server_output = json_decode(doStuff("samples/", null, $json1, $appToken));

                    //cek api
                    if(isset($server_output->sent)){
                        //memasukkan response & condition ke DB
                        $responseId = $this->m_basic->insert("response", array("appId"=>$appId, "responseName"=>$responseName, "responseStatus"=>"1"));
                        $conditionId = $this->m_basic->insert("conditionn", array("appId"=>$appId, "conditionName"=>$conditionName, "conditionCount"=>count($value),  "conditionStatus"=>"1"));

                        $conditionresponse = array(
                            "appId"=>$appId,
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

                        //memasukkan intent ke conditionintent di db
                        $conditionIntent = array(
                            "conditionId"=>$conditionId,
                            "conditionIntent"=>$intentName,
                            "conditionIntentStatus"=>"1"
                        );
                        $this->m_basic->insert("conditionintent", $conditionIntent);

                        foreach($entity as $counter => $entities){
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
                                    "conditionDetailStatus"=>"1"
                            );
                            $this->m_basic->insert("conditiondetail", $conditionDetail);
                        }
                    }else{
                        $_SESSION["error"] = "There's a problem when inserting sample, please check your internet connection";
                        $this->session->mark_as_flash("error");
                    }
                }else{
                    $_SESSION["error"] = "This response name has been used, please use another name";
                    $this->session->mark_as_flash("error");
                }
            }else{
                $_SESSION["error"] = "This condition detail has been used, please check your condition";
                $this->session->mark_as_flash('error');
            }
        }else{
            $_SESSION["error"] = "This condition name has been used, please use another name";
            $this->session->mark_as_flash("error");
        }
        
        redirect(base_url("dashboard"));
    }

    public function check_message(){
        $header = array(
            "subtitle"=>"Bot",
            "title"=>"Check"
        );
        $this->load->view('header', $header);
        $this->load->view('newCheckBot');
        $this->load->view('footer');
    }

    public function check(){
        $appToken = $this->input->post("appToken");
        $message = $this->input->post("message");

        //interact dengan NLP
        $server_output = doStuff("message", strip_tags($message), null, $appToken);
        $result = json_decode($server_output, true);

        if(isset($result["_text"])){
            $entity = $result["entities"];

            //mengecek response dari db
            $result = $this->m_witai->searchCondition($entity, $_SESSION['appId'])->row();
            $output = array();
            
            if(isset($result)){
                $conditionId = $result->conditionId;
                $response = $this->m_basic->find("conditionresponse", array("conditionId"=>$conditionId, "crStatus"=>"1"))->row();
                if(isset($response)){
                    $responseDetail = $this->m_basic->find("responsedetail", array("responseId"=>$response->responseId, "responseDetailStatus"=>"1"))->result();
                    foreach($responseDetail as $responseDetails){
                        $output[$responseDetails->responseTitle] = $responseDetails->responseValue;
                    }
                }
            }
    
            $data["message"] = $message;
            $data["result"] = json_encode($output);
            $header = array(
                "subtitle"=>"Bot",
                "title"=>"Check Result"
            );
            $this->load->view('header', $header);
            $this->load->view('checkBotResult', $data);
            $this->load->view('footer');
        }else{
            $_SESSION["error"] = "There's a problem when testing, please check your internet connection";
            $this->session->mark_as_flash("error");
            redirect(base_url("bot/check_message"));
        }
    }
}

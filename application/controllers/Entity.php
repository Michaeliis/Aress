<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entity extends CI_Controller {
    
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

    public function all_entity(){
        $appId = $_SESSION["appId"];

        $entity = $this->m_basic->find('entity', array("appId"=>$appId))->result();
        $data['entity'] = $entity;
        foreach($entity as $entities){
            $data['value'][$entities->entityId] = $this->m_basic->find('value', array("entityId"=>$entities->entityId))->result();
        }

        $header = array(
            "subtitle"=>"Entity",
            "title"=>"All Entity"
        );
        $this->load->view('header', $header);
        $this->load->view('allEntity', $data);
        $this->load->view('footer');
    }

    public function new_entity(){
        $header = array(
            "subtitle"=>"Entity",
            "title"=>"New Entity"
        );
        $this->load->view('header', $header);
        $this->load->view('newEntity');
        $this->load->view('footer');
    }

    public function insertEntity(){
        $appToken = $_SESSION["appToken"];
        $appId = $_SESSION["appId"];

        $entityName = $this->input->post("entity");
        $entityDetail = $this->input->post("detail");
        $value = $this->input->post("value");
        $expression = $this->input->post("expression");

        //untuk memasukkan entity baru
        $json = json_encode(array("id"=>$entityName));
        $server_output = doStuff("entities/", null, $json, $appToken);
        //memasukkan entity ke db
        $entityId = $this->m_basic->insert("entity", array("appId"=>$appId, "entityName"=>$entityName, "entityDetail"=>$entityDetail, "entityStatus"=>"1"));

        //memasukkan value baru
        foreach($value as $counter =>$values){
            $expressions = explode(";", $expression[$counter]);

            $json = json_encode(array("value"=>$values, "expressions"=>$expressions));
            $server_output = doStuff("entities/".$entityName."/values/", null, $json, $appToken);

            //memasukkan value ke db
            $valueId = $this->m_basic->insert("value", array("entityId"=>$entityId, "value"=>$values, "valueStatus"=>"1"));

            //memasukkan expression ke db
            foreach($expressions as $expressionss){
                $this->m_basic->insert("expression", array("valueId"=>$valueId, "expression"=>$expressionss, "expressionStatus"=>"1"));
            }
        }

        redirect(base_url("entity/all_entity"));
    }

    public function edit_entity($entity){
        $header = array(
            "subtitle"=>"Entity",
            "title"=>"Edit Entity"
        );

        $data["entity"] = $this->m_basic->find("entity", array("entityId"=>$entity))->row();

        $value = $this->m_basic->find("value", array("entityId"=>$entity))->result();
        $data["value"] = $value;
        foreach($value as $values){
            $data["expression"][$values->valueId] = $this->m_basic->find("expression", array("valueId"=>$values->valueId))->result();
        }

        $this->load->view('header', $header);
        $this->load->view('editEntity', $data);
        $this->load->view('footer');
    }

    public function editEntity(){
        $appToken = $_SESSION["appToken"];

        $entityId = $this->input->post("entityId");
        $entityName = $this->input->post("entity");
        $value = $this->input->post("value");
        $expression  = $this->input->post("expression");

        //memasukkan value baru
        foreach($value as $counter =>$values){
            $expressions = explode(";", $expression[$counter]);

            $json = json_encode(array("value"=>$values, "expressions"=>$expressions));
            $server_output = doStuff("entities/".$entityName."/values/", null, $json, $appToken);

            //memasukkan value ke db
            $valueId = $this->m_basic->insert("value", array("entityId"=>$entityId, "value"=>$values, "valueStatus"=>"1"));

            //memasukkan expression ke db
            foreach($expressions as $expressionss){
                $this->m_basic->insert("expression", array("valueId"=>$valueId, "expression"=>$expressionss, "expressionStatus"=>"1"));
            }
        }
        redirect(base_url("entity/all_entity"));
    }

    public function edit_value($entity, $value){
        $data['value'] = $this->m_basic->find("value", array("valueId"=>$value))->row();
        $data['entity'] = $this->m_basic->find("entity", array("entityId"=>$entity))->row();
        $data['expression'] = $this->m_basic->find("expression", array("valueId"=>$value))->result();

        $header = array(
            "subtitle"=>"Entity",
            "title"=>"Edit Value"
        );
        $this->load->view('header', $header);
        $this->load->view('editValue', $data);
        $this->load->view('footer');
    }

    public function edit_expression($entity, $value, $expression){
        $data['value'] = $this->m_basic->find("value", array("valueId"=>$value))->row();
        $data['entity'] = $this->m_basic->find("entity", array("entityId"=>$entity))->row();
        $data['expression'] = $this->m_basic->find("expression", array("expressionId"=>$expression))->row();

        $header = array(
            "subtitle"=>"Entity",
            "title"=>"Edit Expression"
        );
        $this->load->view('header', $header);
        $this->load->view('editExpression', $data);
        $this->load->view('footer');
    }

    public function editExpression(){
        $appToken = $_SESSION["appToken"];

        $entity = $this->input->post("entity");
        $entityName = $this->input->post("entityName");
        $value = $this->input->post("value");
        $valueName = $this->input->post("valueName");
        $expressionOld = $this->input->post("expressionOld");
        $expression = $this->input->post("expression");

        //remove old expression
        $type = "entities/".$entityName."/values/".$valueName."/expressions/".rawurlencode($expressionOld);
        deleteStuff($type, $appToken);
        //insert new expression
        $type = "entities/".$entityName."/values/".$valueName."/expressions";
        $json = json_encode(array("expression"=>$expression));
        doStuff($type, null, $json, $appToken);
        //update expression to db
        $this->m_basic->update(array("entity"=>$entity, "value"=>$value, "expression"=>$expressionOld), "expression", array("expression"=>$expression));

        redirect(base_url("entity/edit_value/").$entity."/".$value);
    }

    public function testThis(){
        $appToken = $_SESSION["appToken"];
        
        $message = "tolong komputer saya tidak meledak";

        //interact dengan NLP
        $server_output = doStuff("message", strip_tags($message), null, $appToken);
        $result = json_decode($server_output, true);

        $entity = $result["entities"];

        //mengecek response dari db
        $result = $this->m_witai->searchCondition($entity)->row();
        if(isset($result)){
            $conditionId = $result->conditionId;
            $response = $this->m_basic->find("conditionresponse", array("conditionId"=>$conditionId))->row();
            if(isset($response)){
                $responseDetail = $this->m_basic->find("responsedetail", array("responseId"=>$response->responseId))->result();
                foreach($responseDetail as $responseDetails){
                    $output[$responseDetails->responseTitle] = $responseDetails->responseValue;
                }
            }
        }

        if(!isset($output)){
            $output = array("reply"=>"sorry");
        }
        
        echo json_encode($output);
    }
}?>
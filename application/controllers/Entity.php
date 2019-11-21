<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entity extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }

    public function all_entity(){
        $data['entity'] = $this->m_basic->gets('entity')->result();
        $data['value'] = $this->m_basic->gets('value')->result();

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
        $entity = $this->input->post("entity");
        $detail = $this->input->post("detail");
        $value = $this->input->post("value");
        $expression = $this->input->post("expression");

        //untuk memasukkan entity baru
        $json = json_encode(array("id"=>$entity));
        $server_output = doStuff("entities/", null, $json);
        echo $server_output. "<br>";
        //memasukkan entity ke db
        $this->m_basic->insert("entity", array("entity"=>$entity, "detail"=>$detail));

        //memasukkan value baru
        foreach($value as $counter =>$values){
            $expressions = explode(";", $expression[$counter]);

            $json = json_encode(array("value"=>$values, "expressions"=>$expressions));
            $server_output = doStuff("entities/".$entity."/values/", null, $json);
            echo $server_output. "<br>";

            //memasukkan expression ke db
            foreach($expressions as $expressionss){
                $this->m_basic->insert("expression", array("entity"=>$entity, "value"=>$values, "expression"=>$expressionss));
            }

            //memasukkan value ke db
            $this->m_basic->insert("value", array("entity"=>$entity, "value"=>$values));
        }
    }

    public function edit_entity($entity){
        $header = array(
            "subtitle"=>"Entity",
            "title"=>"Edit Entity"
        );

        $data["entity"] = $entity;
        $data["value"] = $this->m_basic->find("value", array("entity"=>$entity))->result();
        $data["expression"] = $this->m_basic->find("expression", array("entity"=>$entity))->result();

        $this->load->view('header', $header);
        $this->load->view('editEntity', $data);
        $this->load->view('footer');
    }

    public function editEntity(){
        $entity = $this->input->post("entity");
        $value = $this->input->post("value");
        $expression  = $this->input->post("expression");

        //memasukkan value baru
        foreach($value as $counter =>$values){
            $expressions = explode(";", $expression[$counter]);

            $json = json_encode(array("value"=>$values, "expressions"=>$expressions));
            $server_output = doStuff("entities/".$entity."/values/", null, $json);
            echo $server_output. "<br>";

            //memasukkan expression ke db
            foreach($expressions as $expressionss){
                $this->m_basic->insert("expression", array("entity"=>$entity, "value"=>$values, "expression"=>$expressionss));
            }

            //memasukkan value ke db
            $this->m_basic->insert("value", array("entity"=>$entity, "value"=>$values));
        }
    }

    public function edit_value($entity, $value){
        $data['value'] = $value;
        $data['entity'] = $entity;
        $data['expression'] = $this->m_basic->find("expression", array("entity"=>$entity, "value"=>$value))->result();

        $header = array(
            "subtitle"=>"Entity",
            "title"=>"Edit Value"
        );
        $this->load->view('header', $header);
        $this->load->view('editValue', $data);
        $this->load->view('footer');
    }

    public function edit_expression($entity, $value, $expression){
        $data['value'] = $value;
        $data['entity'] = $entity;
        $data['expression'] = $expression;

        $header = array(
            "subtitle"=>"Entity",
            "title"=>"Edit Expression"
        );
        $this->load->view('header', $header);
        $this->load->view('editExpression', $data);
        $this->load->view('footer');
    }

    public function editExpression(){
        $entity = $this->input->post("entity");
        $value = $this->input->post("value");
        $expressionOld = $this->input->post("expressionOld");
        $expression = $this->input->post("expression");

        //remove old expression
        $type = "entities/".$entity."/values/".$value."/expressions/".rawurlencode($expressionOld);
        deleteStuff($type);
        //insert new expression
        $type = "entities/".$entity."/values/".$value."/expressions";
        $json = json_encode(array("expression"=>$expression));
        doStuff($type, null, $json);
        //update expression to db
        $this->m_basic->update(array("entity"=>$entity, "value"=>$value, "expression"=>$expressionOld), "expression", array("expression"=>$expression));
    }

    public function testThis(){
        $message = "tolong komputer saya tidak meledak";

        //interact dengan NLP
        $server_output = doStuff("message", strip_tags($message), null);
        $result = json_decode($server_output, true);

        $entity = $result["entities"];

        //mengecek response dari db
        $query = "SELECT conditionDetail.conditionId, count(conditionDetailId) AS 'score', conditionCount FROM conditionDetail INNER JOIN conditionn ON conditionn.conditionId = conditionDetail.conditionId JOIN conditionintent ON conditionintent.conditionId = conditionDetail.conditionId WHERE ";
        $next = false;
        foreach($entity as $entities => $value){
            foreach($value as $values){
                if($next){
                    $query.= " OR ";
                }
                $query.= "(";
                $query.= "conditionEntity = '".$entities."'";
                $query.= " AND ";
                $query.= "conditionValue = '".$values["value"]."'";
                $query.= ")";
    
                $next = true;
            }
        }
        $query.= " GROUP BY conditionId HAVING count(conditionDetailId) = conditionCount";
        echo $query. "<br><br>";

        $result = $this->m_basic->runQuery($query)->row();
        if(isset($result)){
            $conditionId = $result->conditionId;
            $response = $this->m_basic->find("response", array("conditionId"=>$conditionId))->row();
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
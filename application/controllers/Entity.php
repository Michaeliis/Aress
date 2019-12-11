<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entity extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
        $this->load->model('m_witai');
        $this->load->model('m_entity');

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

        //menghilangkan spasi dari entityName
        $entityName = str_replace(" ", "_", $entityName);

        //mengecek apakah nama entity sudah ada
        $entity = $this->m_basic->find("entity", array("entityName"=>$entityName, "appId"=>$appId))->num_rows();
        if(!$entity > 0){
            //untuk memasukkan entity baru
            $json = json_encode(array("id"=>$entityName));
            $server_output = json_decode(doStuff("entities/", null, $json, $appToken));

            $entityStatus = 0;
            //check api result
            if(isset($server_output->name)){
                $entityStatus = 1;
            }else{
                $_SESSION["error"] = "There's a problem when inserting entity, please check your internet connection";
                $this->session->mark_as_flash("error");
            }

            //mengubah lookup entity
            if($entityStatus == 1){
                $json = json_encode(array("lookups"=>array("free-text", "keywords")));
                $server_output = json_decode(putStuff("entities/".$entityName, null, $json, $appToken));
            }

            //memasukkan entity ke db
            $entityId = $this->m_basic->insert("entity", array("appId"=>$appId, "entityName"=>$entityName, "entityDetail"=>$entityDetail, "entityStatus"=>$entityStatus));

            //memasukkan value baru
            foreach($value as $counter =>$values){
                //mengecek apakah value sudah digunakan
                $valueCount = $this->m_basic->find("value", array("entityId"=>$entityId, "value"=>$values))->num_rows();
                if(!$valueCount > 0){
                    $valueStatus = 1;
                    $expressions = explode(";", $expression[$counter]);
                    //memasukkan value & expression ke wit.ai
                    if($entityStatus == 1){
                        $json = json_encode(array("value"=>$values, "expressions"=>$expressions));
                        $server_output = json_decode(doStuff("entities/".$entityName."/values/", null, $json, $appToken));
                        //check api result
                        $valueStatus = 0;
                        if(isset($server_output->name)){
                            $valueStatus = 1;
                        }else{
                            $_SESSION["error"] = "There's a problem when inserting values, please check your internet connection";
                            $this->session->mark_as_flash("error");
                        }
                    }
                    
                    //memasukkan value ke db
                    $valueId = $this->m_basic->insert("value", array("entityId"=>$entityId, "value"=>$values, "valueStatus"=>$valueStatus));

                    //memasukkan expression ke db
                    if(!in_array($values, $expressions)){
                        $expressions[] = $values;
                    }
                    $expressions = array_unique($expressions);
                    foreach($expressions as $expressionss){
                        $this->m_basic->insert("expression", array("valueId"=>$valueId, "expression"=>$expressionss, "expressionStatus"=>"1"));
                    }
                }else{
                    $_SESSION["error"] = "One or more of the value name is duplicate";
                    $this->session->mark_as_flash('error');
                    continue;
                }
            }
        }else{
            $_SESSION["error"] = "The entity name has been used, please use another name";
            $this->session->mark_as_flash('error');
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
        $entityDetail = $this->input->post("entityDetail");
        $value = $this->input->post("value");
        $expression  = $this->input->post("expression");

        $this->m_basic->update(array("entityId"=>$entityId), "entity", array("entityDetail"=>$entityDetail));
        if($value[0]!=""){
            //memasukkan value baru
            foreach($value as $counter =>$values){
                //mengecek apakah value sudah digunakan
                $valueCount = $this->m_basic->find("value", array("entityId"=>$entityId, "value"=>$values))->num_rows();
                if(!$valueCount > 0){
                    $expressions = explode(";", $expression[$counter]);

                    $json = json_encode(array("value"=>$values, "expressions"=>$expressions));
                    $server_output = json_decode(doStuff("entities/".$entityName."/values/", null, $json, $appToken));

                    //check api result
                    $valueStatus = 0;
                    if(isset($server_output->name)){
                        $valueStatus = 1;
                    }else{
                        $_SESSION["error"] = "There's a problem when inserting value, please check your internet connection";
                        $this->session->mark_as_flash("error");
                    }
                    //memasukkan value ke db
                    $valueId = $this->m_basic->insert("value", array("entityId"=>$entityId, "value"=>$values, "valueStatus"=>$valueStatus));

                    //memasukkan expression ke db
                    $expressions[] = $values;
                    $expressions = array_unique($expressions);
                    foreach($expressions as $expressionss){
                        $this->m_basic->insert("expression", array("valueId"=>$valueId, "expression"=>$expressionss, "expressionStatus"=>"1"));
                    }
                }else{
                    $_SESSION["error"] = "One or more of the value name is duplicate";
                    $this->session->mark_as_flash('error');
                    continue;
                }
            }
        }
        
        redirect(base_url("entity/all_entity"));
    }

    public function delete_entity($entityId){
        $appToken = $_SESSION["appToken"];

        $entity = $this->m_basic->find("entity", array("entityId"=>$entityId))->row();
        $server_response = json_decode(deleteStuff("/entities/".$entity->entityName, null, $appToken));
        
        if(isset($server_response->deleted)){
            $this->m_basic->update(array("entityId"=>$entityId), "entity", array("entityStatus"=>"0"));
        }else{
            $_SESSION["error"] = "There's a problem when deleting entity, please check your connection";
            $this->session->mark_as_flash("error");
        }
        
        redirect(base_url("entity/all_entity"));
    }

    public function activate_entity($entityId){
        $appToken = $_SESSION["appToken"];
        $entityName = $this->m_basic->find("entity", array("entityId"=>$entityId))->row()->entityName;

        $json = json_encode(array("id"=>$entityName));
        $server_output = json_decode(doStuff("entities/", null, $json, $appToken));

        //check api result
        if(isset($server_output->name)){
            $this->m_basic->update(array("entityId"=>$entityId), "entity", array("entityStatus"=>"1"));
            //mengubah lookup entity
            $json = json_encode(array("lookups"=>array("free-text", "keywords")));
            $server_output = json_decode(putStuff("entities/".$entityName, null, $json, $appToken));
        
            $entitySet = $this->m_entity->entitySet($entityId)->result();
            foreach($entitySet as $entitySets){
                $entityArray[$entitySets->value][] = $entitySets->expression;
            }

            foreach($entityArray as $value => $expression){
                $valueJson["value"] = $value;
                $valueJson["expressions"] = $entityArray[$value];
                $server_output = json_decode(doStuff("/entities/".$entityName."/values", null, json_encode($valueJson), $appToken));
                //check api
                if(!isset($server_output->name)){
                    $this->m_basic->update(array("value"=>$value, "entityId"=>$entityId), "value", array("valueStatus"=>0));
                    $_SESSION["error"] = "There's a problem when inserting value(s), please check your internet connection";
                    $this->session->mark_as_flash("error");
                }
            }
        }else{
            $_SESSION["error"] = "There's a problem when inserting entity, please check your internet connection";
            $this->session->mark_as_flash("error");
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

    public function editValue(){
        $appToken = $_SESSION["appToken"];

        $entityId = $this->input->post("entityId");
        $valueId = $this->input->post("valueId");
        $expression = $this->input->post("expression");

        $value = $this->m_entity->valueEntity($valueId)->row();
        $expressions = explode(";", $expression);
        $expressions = array_unique($expressions);

        foreach($expressions as $expressionss){
            $type = "entities/".$value->entityName."/values/".$value->value."/expressions";
            $json = array("expression"=>$expressionss);

            //check duplicate expression
            $countExpression = $this->m_basic->find("expression", array("valueId"=>$valueId, "expression"=>$expressionss))->num_rows();
            if(!$countExpression > 0){
                $server_output = json_decode(doStuff(rawurlencode($type), null, json_encode($json), $appToken));
                
                $expressionStatus = 0;
                if(isset($server_output->name)){
                    $expressionStatus = 1;
                }else{
                    $_SESSION["error"] = "There's an error when inserting expression";
                    $this->session->mark_as_flash("error");
                }
                $this->m_basic->insert("expression", array("valueId"=>$valueId, "expression"=>$expressionss, "expressionStatus"=>$expressionStatus));
            }else{
                $_SESSION["error"] = "This expression(s) have already been used, please check your expressions";
                $this->session->mark_as_flash("error");
            }
        }

        redirect(base_url("entity/edit_value/".$entityId."/".$valueId));
    }

    public function delete_value($entityId, $valueId){
        $appToken = $_SESSION["appToken"];

        $valueEntity = $this->m_entity->valueEntity($valueId)->row();

        $type = "entities/".$valueEntity->entityName."/values/".$valueEntity->value;
        $result = deleteStuff(rawurlencode($type), null, $appToken);
        if(isset(json_decode($result)->deleted)){
            $this->m_basic->update(array("valueId"=>$valueId), "value", array("valueStatus"=>"0"));
        }else{
            $_SESSION["error"] = "There's an error when deleting value, please check your connection";
            $this->session->mark_as_flash("error");
        }
        
        redirect(base_url("entity/edit_entity/").$entityId);
    }

    public function activate_value($entityId, $valueId){
        $appToken = $_SESSION["appToken"];

        $entity = $this->m_entity->valueEntityAll($valueId)->row();
        $expression = $this->m_entity->valueExpressionAll($valueId)->result();
        $entityName = $entity->entityName;
        $valueName = $entity->value;
        
        //memasukkan value baru
        //memasukkan expressions ke dalam array
        $expressionArray = array();
        foreach($expression as $expressions){
            $expressionArray[] = $expressions->expression;
        }

        $json = json_encode(array("value"=>$valueName, "expressions"=>$expressionArray));
        $server_output = json_decode(doStuff("entities/".$entityName."/values/", null, $json, $appToken));
        
        //cek api
        if(isset($server_output->name)){
            $this->m_basic->update(array("valueId"=>$valueId), "value", array("valueStatus"=>"1"));
        }else{
            $_SESSION["error"] = "There's an error when deleting value, please check your connection";
            $this->session->mark_as_flash("error");
        }

        redirect(base_url("entity/edit_entity/").$entityId);
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
        $type = "entities/".$entityName."/values/".$valueName."/expressions/".$expressionOld;
        $server_output = json_decode(deleteStuff(rawurlencode($type), null, $appToken));

        if(isset($server_output->error)){
            $_SESSION["error"] = $server_output->error;
            $this->session->mark_as_flash('error');
        }else if(isset($server_output->deleted)){
            //insert new expression
            $type = "entities/".$entityName."/values/".$valueName."/expressions";
            $json = json_encode(array("expression"=>$expression));
            $server_output = json_decode(doStuff(rawurlencode($type), null, $json, $appToken));

            if(isset($server_output->name)){
                //update expression to db
                $this->m_basic->update(array("valueId"=>$value, "expression"=>$expressionOld), "expression", array("expression"=>$expression));
            }
        }else{
            $_SESSION["error"] = "There's an error when deleting this expression, please check your connection";
            $this->session->mark_as_flash('error');
        }

        redirect(base_url("entity/edit_value/").$entity."/".$value);
    }

    public function delete_expression($entityId, $valueId, $expressionId){
        $appToken = $_SESSION["appToken"];

        //ambil detail expression
        $expression = $this->m_entity->expressionSet($expressionId)->row();
        $entityName = $expression->entityName;
        $valueName = $expression->value;
        $expressionName = urlencode($expression->expression);

        $type = "entities/".$entityName."/values/".$valueName."/expressions/".$expressionName;

        $result = json_decode(deleteStuff(rawurlencode($type), null, $appToken));
        
        if(isset($result->error)){
            $_SESSION["error"] = $result->error;
            $this->session->mark_as_flash('error');
        }else if(isset($result->deleted)){
            $this->m_basic->update(array("expressionId"=>$expressionId), "expression", array("expressionStatus"=>"0"));
        }else{
            $_SESSION["error"] = "There's an error when deleting this expression, please check your connection";
            $this->session->mark_as_flash('error');
        }

        redirect(base_url("entity/edit_value/".$entityId."/".$valueId));
    }

    public function activate_expression($entityId, $valueId, $expressionId){
        $appToken = $_SESSION["appToken"];
        
        $expression = $this->m_entity->expressionSet($expressionId)->row();

        $expressionName = $expression->expression;

        $type = "entities/".$expression->entityName."/values/".$expression->value."/expressions";
        $json = array("expression"=>$expressionName);
        $server_output = json_decode(doStuff(rawurlencode($type), null, json_encode($json), $appToken));

        if(isset($server_output->name)){
            $this->m_basic->update(array("expressionId"=>$expressionId), "expression", array("expressionStatus"=>"1"));
        }else{
            $_SESSION["error"] = "There's an error when inserting expression";
            $this->session->mark_as_flash("error");
        }
        redirect(base_url("entity/edit_value/".$entityId."/".$valueId));
    }
}?>
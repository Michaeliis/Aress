<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Condition extends CI_Controller {
    
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
    
    public function all_condition(){
        $data["condition"] = $this->m_basic->joinUser("conditionn")->result();

        $header = array(
            "subtitle"=>"Condition",
            "title"=>"All Condition"
        );
        $this->load->view('header', $header);
        $this->load->view('allCondition', $data);
        $this->load->view('footer');
    }

    public function new_condition(){
        $appId = $_SESSION["appId"];
        $data['intent'] = $this->m_basic->find('intent', array("appId"=>$appId, "intentStatus"=>"1"))->result();
        $data['entity'] = $this->m_basic->find('entity', array("appId"=>$appId, "entityStatus"=>"1"))->result();

        $header = array(
            "subtitle"=>"Condition",
            "title"=>"New Conditiion"
        );
        $this->load->view('header', $header);
        $this->load->view('newCondition', $data);
        $this->load->view('footer');
    }

    public function newCondition(){
        $appId = $_SESSION["appId"];

        $intentName = $this->input->post("intent");
        $entityId = $this->input->post("entity");
        $valueId = $this->input->post("value");
        $conditionName = $this->input->post("conditionName");

        //convert entity id jadi entity value
        foreach($entityId as $entityIds){
            $resultValue = $this->m_basic->find("entity", array("entityId"=>$entityIds))->row();
            $entity[] = $resultValue->entityName;
        }
        foreach($valueId as $valueIds){
            $resultValue = $this->m_basic->find("value", array("valueId"=>$valueIds))->row();
            $value[] = $resultValue->value;
        }

        //cek condition di DB
        $conditionCount = $this->m_basic->find("conditionn", array("conditionName"=>$conditionName, "appId"=>$appId))->num_rows();

        if(!$conditionCount > 0){
            //cek intent dan detail condition serupa
            $entityList["intent"][0]["value"] = $intentName;
            foreach($entity as $counter => $entities){
                $entityList[$entities][]["value"] = $value[$counter];
            }
            $entityCheck = $this->m_witai->searchCondition($entityList, $appId)->num_rows();

            if(!$entityCheck > 0){
                //memasukkan condition ke DB
                $conditionId = $this->m_basic->insert("conditionn", array("appId"=>$appId, "conditionName"=>$conditionName, "conditionCount"=>count($value), "userId"=>$_SESSION["userId"], "conditionStatus"=>"1"));

                //memasukkan intent ke conditionintent di db
                $conditionIntent = array(
                    "conditionId"=>$conditionId,
                    "conditionIntent"=>$intentName,
                    "conditionIntentStatus"=>"1"
                );
                $this->m_basic->insert("conditionintent", $conditionIntent);

                foreach($entity as $counter => $entities){
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
                $_SESSION["error"] = "This condition detail has been used, please check your condition";
                $this->session->mark_as_flash('error');
            }
            
        }else{
            $_SESSION["error"] = "The condition name has been used, please use another name";
            $this->session->mark_as_flash('error');
        }
        
        redirect(base_url("condition/all_condition"));
    }

    public function edit_condition($conditionId){
        $appId = $_SESSION["appId"];

        $data["condition"] = $this->m_basic->find("conditionn", array("conditionId"=>$conditionId, "appId"=>$appId))->row();
        $data["conditiondetail"] = $this->m_basic->find("conditiondetail", array("conditionId"=>$conditionId))->result();
        $data["conditionintent"] = $this->m_basic->find("conditionintent", array("conditionId"=>$conditionId))->row();
        $data["intent"] = $this->m_basic->find("intent", array("appId"=>$appId, "intentStatus"=>1))->result();
        $data["entity"] = $this->m_basic->find("entity", array("appId"=>$appId, "entityStatus"=>1))->result();

        $header = array(
            "subtitle"=>"Condition",
            "title"=>"Edit Condition"
        );
        $this->load->view('header', $header);
        $this->load->view('editCondition', $data);
        $this->load->view('footer');
    }

    public function editCondition(){
        $appId = $_SESSION["appId"];

        $conditionName = $this->input->post('conditionName');
        $conditionNameOld = $this->input->post('conditionNameOld');
        $conditionId = $this->input->post('conditionId');
        $intent = $this->input->post('intent');
        $entityId = $this->input->post('entity');
        $valueId = $this->input->post('value');

        //convert entity id jadi entity value
        $entity = array();
        $value = array();
        if($entityId[0] != ""){
            foreach($entityId as $entityIds){
                $resultValue = $this->m_basic->find("entity", array("entityId"=>$entityIds))->row();
                $entity[] = $resultValue->entityName;
            }
            foreach($valueId as $valueIds){
                $resultValue = $this->m_basic->find("value", array("valueId"=>$valueIds))->row();
                $value[] = $resultValue->value;
            }
        }

        //cek condition di DB
        $conditionCountf = $this->m_basic->find("conditionn", array("conditionName"=>$conditionName, "appId"=>$appId))->num_rows();
        if($conditionName == $conditionNameOld){
            $conditionCountf = $conditionCountf - 1;
        }
        if(!$conditionCountf > 0){
            //cek intent dan detail condition serupa
            $entityList["intent"][0]["value"] = $intent;
            foreach($entity as $counter => $entities){
                $entityList[$entities][]["value"] = $value[$counter];
            }
            $entityCheck = $this->m_witai->searchCondition($entityList, $appId)->num_rows();

            if(!$entityCheck > 0){
                foreach($entity as $counter => $entities){
                    //memasukkan entities ke conditiondetail di db
                    $conditionDetail = array(
                            "conditionId"=>$conditionId,
                            "conditionEntity"=>$entities,
                            "conditionValue"=>$value[$counter],
                            "conditionDetailStatus"=>"1"
                    );
                    $this->m_basic->insert("conditiondetail", $conditionDetail);
                }
                
                $this->m_basic->update(array("conditionId"=>$conditionId), "conditionn", array("conditionName"=>$conditionName));
                $this->m_basic->set(array("conditionId"=>$conditionId), "conditionn", "conditionCount", "conditionCount+".count($value));
                
                $this->m_basic->update(array("conditionId"=>$conditionId), "conditionintent", array("conditionIntent"=>$intent));
            }else{
                $_SESSION["error"] = "This condition detail has been used, please check your condition";
                $this->session->mark_as_flash('error');
            }
        }else{
            $_SESSION["error"] = "This condition name has been used, please use another name";
            $this->session->mark_as_flash('error');
        }

        redirect(base_url("condition/all_condition"));
    }

    public function delete_condition($conditionId){
        $this->m_basic->update(array("conditionId"=>$conditionId), "conditionn", array("conditionStatus"=>"0"));
        redirect(base_url("condition/all_condition"));
    }

    public function activate_condition($conditionId){
        $this->m_basic->update(array("conditionId"=>$conditionId), "conditionn", array("conditionStatus"=>"1"));
        redirect(base_url("condition/all_condition"));
    }

    public function edit_condition_detail($conditionDetailId){
        $appId = $_SESSION["appId"];

        $conditionDetail = $this->m_basic->find("conditionDetail", array("conditionDetailId"=>$conditionDetailId))->row();
        $data["conditionDetail"] = $conditionDetail;
        $data["entity"] = $this->m_basic->find("entity", array("appId"=>$appId))->result();
        $curCon = $this->m_basic->find("entity", array("entityName"=>$conditionDetail->conditionEntity, "appId"=>$appId))->row();
        $data["value"] = $this->m_basic->find("value", array("entityId"=>$curCon->entityId))->result();

        $header = array(
            "subtitle"=>"Condition",
            "title"=>"Edit Condition"
        );
        $this->load->view('header', $header);
        $this->load->view('editConditionDetail', $data);
        $this->load->view('footer');
    }

    public function editConditionDetail(){
        $entity = $this->input->post('entity');
        $value = $this->input->post('value');
        $conditionDetailId = $this->input->post('conditionDetailId');
        $conditionId = $this->input->post('conditionId');

        $entityName = $this->m_basic->find("entity", array("entityId"=>$entity))->row()->entityName;
        $this->m_basic->update(array("conditionDetailId"=>$conditionDetailId), "conditiondetail", array("conditionEntity"=>$entityName, "conditionValue"=>$value));

        redirect(base_url("condition/edit_condition/").$conditionId);
    }

    public function delete_condition_detail($conditionDetailId){
        $this->m_basic->update(array("conditionDetailId"=>$conditionDetailId), "conditiondetail", array("conditionDetailStatus"=>0));
        $conditionId = $this->m_basic->find("conditiondetail", array("conditionDetailId"=>$conditionDetailId))->row()->conditionId;
        $this->m_basic->set(array("conditionId"=>$conditionId), "conditionn", "conditionCount", "conditionCount-1");

        redirect(base_url("condition/edit_condition/").$conditionId);
    }

    public function activate_condition_detail($conditionDetailId){
        $this->m_basic->update(array("conditionDetailId"=>$conditionDetailId), "conditiondetail", array("conditionDetailStatus"=>1));
        $conditionId = $this->m_basic->find("conditiondetail", array("conditionDetailId"=>$conditionDetailId))->row()->conditionId;
        $this->m_basic->set(array("conditionId"=>$conditionId), "conditionn", "conditionCount", "conditionCount+1");

        redirect(base_url("condition/edit_condition/").$conditionId);
    }
}

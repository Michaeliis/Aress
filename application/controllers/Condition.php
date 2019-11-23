<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Condition extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }
    
    public function all_condition(){
        $appId = "1";

        $data["condition"] = $this->m_basic->find("conditionn", array("appId"=>$appId))->result();

        $header = array(
            "subtitle"=>"Condition",
            "title"=>"All Condition"
        );
        $this->load->view('header', $header);
        $this->load->view('allCondition', $data);
        $this->load->view('footer');
    }

    public function new_condition(){
        $appId = "1";
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
        $appId = "1";

        $intentName = $this->input->post("intent");
        $entityId = $this->input->post("entity");
        $valueId = $this->input->post("value");

        //convert entity id jadi entity value
        foreach($entityId as $entityIds){
            $resultValue = $this->m_basic->find("entity", array("entityId"=>$entityIds))->row();
            $entity[] = $resultValue->entityName;
        }
        foreach($valueId as $valueIds){
            $resultValue = $this->m_basic->find("value", array("valueId"=>$valueIds))->row();
            $value[] = $resultValue->value;
        }

        //memasukkan response & condition ke DB
        $conditionName = date("YmdHis");
        
        $conditionId = $this->m_basic->insert("conditionn", array("appId"=>$appId, "conditionName"=>$conditionName, "conditionCount"=>count($value),  "conditionStatus"=>"1"));
        
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
                    "conditionStatus"=>"1"
            );
            $this->m_basic->insert("conditiondetail", $conditionDetail);
        }
    }

    public function edit_condition($conditionId){
        $appId = "1";

        $data["condition"] = $this->m_basic->find("conditionn", array("conditionId"=>$conditionId, "appId"=>$appId))->row();
        $data["conditiondetail"] = $this->m_basic->find("conditiondetail", array("conditionId"=>$conditionId))->result();
        $data["conditionintent"] = $this->m_basic->find("conditionintent", array("conditionId"=>$conditionId))->row();
        $header = array(
            "subtitle"=>"Condition",
            "title"=>"Edit Condition"
        );
        $this->load->view('header', $header);
        $this->load->view('editCondition', $data);
        $this->load->view('footer');
    }

    public function editCondition(){
        $conditionName = $this->input->post('conditionName');
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

        foreach($entity as $counter => $entities){
            //memasukkan entities ke conditiondetail di db
            $conditionDetail = array(
                    "conditionId"=>$conditionId,
                    "conditionEntity"=>$entities,
                    "conditionValue"=>$value[$counter],
                    "conditionStatus"=>"1"
            );
            $this->m_basic->insert("conditiondetail", $conditionDetail);
        }
        
        $this->m_basic->update(array("conditionId"=>$conditionId), "conditionn", array("conditionName"=>$conditionName, "conditionCount"=>"conditionCount+".count($value)));
        
        $this->m_basic->update(array("conditionId"=>$conditionId), "conditionintent", array("conditionIntent"=>$intent));
    }

    public function insertCategory(){
        $category = $this->input->post('category');
        $detail = $this->input->post('detail');
        
        $data = array(
            "categoryName"=>$category,
            "categoryDetail"=>$detail,
            "categoryStatus"=>1
        );

        $this->m_basic->insert("category", $data);
        
        redirect(base_url("category/all_category"));
    }

    public function edit_category($categoryName){
        $data['category'] = $this->m_basic->find("category", array("categoryName"=>$categoryName))->row();

        $header = array(
            "subtitle"=>"Category",
            "title"=>"New Category"
        );
        $this->load->view('header', $header);
        $this->load->view('editCategory', $data);
        $this->load->view('footer');
    }

    public function editCategory(){
        $prevcategory = $this->input->post('prevcategory');
        $category = $this->input->post('category');
        $detail = $this->input->post('detail');
        
        $data = array(
            "categoryName"=>$category,
            "categoryDetail"=>$detail,
            "categoryStatus"=>1
        );

        $this->m_basic->update(array("categoryName"=>$prevcategory), "category", $data);
        
        redirect(base_url("category/all_category"));
    }
}

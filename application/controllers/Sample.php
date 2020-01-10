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
        $data['sample'] = $this->m_basic->joinUser('sample')->result();

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
        $data['intent'] = $this->m_basic->find('intent', array("appId"=>$appId, "intentStatus"=>"1"))->result();

        $header = array(
            "subtitle"=>"Sample",
            "title"=>"New Sample"
        );
        $this->load->view('header', $header);
        $this->load->view('newSample', $data);
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

        $_SESSION["notif"] = "Sample successfully created.";
        $_SESSION["notifType"] = "success";
        $this->session->mark_as_flash(array("notif", "notifType"));

        //convert entity id jadi entity value
        foreach($entityId as $entityIds){
            $resultValue = $this->m_basic->find("entity", array("entityId"=>$entityIds))->row();
            $entity[] = $resultValue->entityName;
        }
        foreach($valueId as $valueIds){
            $resultValue = $this->m_basic->find("value", array("valueId"=>$valueIds))->row();
            $value[] = $resultValue->value;
        }

        //menghubungkan dengan wit.ai
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
            //menambahkan sample ke db
            $sampleDb = array(
                "appId"=>$appId,
                "sampleText"=>$sample,
                "sampleDate"=>date("Y-m-d"),
                "userId"=>$_SESSION["userId"], 
                "sampleStatus"=>"1"
            );
            $sampleId = $this->m_basic->insert("sample", $sampleDb);
            
            //menambahkan sample intent ke db
            $sampleIntent = array(
                "sampleId"=>$sampleId,
                "intentName"=>$intentName
            );
            $this->m_basic->insert("sampleintent", $sampleIntent);


            foreach($entity as $counter => $entities){
                //memasukkan detail sample ke db
                $sampleDetail = array(
                    "sampleId"=>$sampleId,
                    "entityName"=>$entities,
                    "valueName"=>$value[$counter]
                );
                $this->m_basic->insert("sampleentity", $sampleDetail);
            }
        }else{
            $_SESSION["notif"] = "There's a problem when inserting sample, please check your internet connection";
            $_SESSION["notifType"] = "error";
            $this->session->mark_as_flash(array("notif", "notifType"));
        }

        redirect(base_url("sample/all_sample"));
    }

    public function view_sample($sampleId){
        $data["sample"] = $this->m_basic->find("sample", array("sampleId"=>$sampleId))->row();
        $data["sampleintent"] = $this->m_basic->find("sampleintent", array("sampleId"=>$sampleId))->row();
        $data["sampleentity"] = $this->m_basic->find("sampleentity", array("sampleId"=>$sampleId))->result();

        $header = array(
            "subtitle"=>"Sample",
            "title"=>"View Sample"
        );
        $this->load->view('header', $header);
        $this->load->view('viewSample', $data);
        $this->load->view('footer');
    }

    public function delete_sample($sampleId){
        $appToken = $_SESSION["appToken"];

        $sampleText = $this->m_basic->find("sample", array("sampleId"=>$sampleId))->row()->sampleText;
        $json[] = array("text"=>$sampleText);
        
        $server_output = json_decode(deleteStuff("samples", json_encode($json), $appToken));
        
        if(isset($server_output->sent)){
            $this->m_basic->delete(array("sampleId"=>$sampleId), "sample");
            $_SESSION["notif"] = "Sample successfully deleted.";
            $_SESSION["notifType"] = "success";
            $this->session->mark_as_flash(array("notif", "notifType"));
        }else{
            $_SESSION["notif"] = "There's an error when deleting sample, please check your internet connection";
            $_SESSION["notifType"] = "error";
            $this->session->mark_as_flash(array("notif", "notifType"));
        }

        redirect("sample/all_sample");
    }
}

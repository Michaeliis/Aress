<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Response extends CI_Controller {
    
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
    
    public function all_response(){
        $appId = $_SESSION["appId"];
        $data["response"] = $this->m_basic->find("response", array("appId"=>$appId))->result();

        $header = array(
            "subtitle"=>"Response",
            "title"=>"All Response"
        );
        $this->load->view('header', $header);
        $this->load->view('allResponse', $data);
        $this->load->view('footer');
    }

    public function new_response(){
        $appId = $_SESSION["appId"];

        $item = $this->m_basic->find('item', array("appId"=>$appId, "itemStatus"=>"1"))->result();
        $data["itemOption"] = array();
        foreach($item as $items){
            if($items->itemValue == "select"){
                $data["itemOption"][$items->itemId] = $this->m_basic->find("itemoption", array("itemId"=>$items->itemId, "itemOptionStatus"=>"1"))->result_array();
            }
        }

        $data['item'] = $item;

        $header = array(
            "subtitle"=>"Response",
            "title"=>"New Response"
        );
        $this->load->view('header', $header);
        $this->load->view('newResponse', $data);
        $this->load->view('footer');
    }

    public function newResponse(){
        $appId = $_SESSION["appId"];

        $responseName = $this->input->post("responseName");

        //cek responseName
        $responseCount = $this->m_basic->find("response", array("responseName"=>$responseName, "appId"=>$appId))->num_rows();
        if(!$responseCount > 0){
            //insert response ke db
            $responseId = $this->m_basic->insert("response", array("appId"=>$appId, "responseName"=>$responseName, "responseStatus"=>"1"));

            //ambil item dari form
            $item = $this->m_basic->find("item", array("appId"=>$appId, "itemStatus"=>"1"))->result();
            foreach($item as $items){
                $output[$items->itemName] = $this->input->post($items->itemId);
            }

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
        }else{
            $_SESSION["error"] = "This response name has been used, please use another response";
            $this->session->mark_as_flash('error');
        }

        redirect(base_url("response/all_response"));
    }

    public function edit_response($responseId){
        $data["response"] = $this->m_basic->find("response", array("responseId"=>$responseId))->row();
        $data["responsedetail"] = $this->m_basic->find("responsedetail", array("responseId"=>$responseId))->result();

        $header = array(
            "subtitle"=>"Response",
            "title"=>"Edit Response"
        );
        $this->load->view('header', $header);
        $this->load->view('editResponse', $data);
        $this->load->view('footer');
    }

    public function delete_response($responseId){
        $this->m_basic->update(array("responseId"=>$responseId), "response", array("responseStatus"=>"0"));

        redirect(base_url("response/all_response"));
    }

    public function activate_response($responseId){
        $this->m_basic->update(array("responseId"=>$responseId), "response", array("responseStatus"=>"1"));

        redirect(base_url("response/all_response"));
    }

    public function editResponse(){
        $appId = $_SESSION["appId"];

        $responseId = $this->input->post("responseId");
        $responseName = $this->input->post("responseName");
        $responseNameOld = $this->input->post("responseNameOld");
        //cek responseName
        $responseCount = $this->m_basic->find("response", array("responseName"=>$responseName, "appId"=>$appId))->num_rows();
        if($responseNameOld == $responseName){
            $responseCount--;
        }
        if(!$responseCount > 0){
            $this->m_basic->update(array("responseId"=>$responseId), "response", array("responseName"=>$responseName));
        }

        redirect(base_url("response/all_response"));
    }

    public function edit_response_detail($responseId, $responseTitle){
        $responseTitle = rawurldecode($responseTitle);
        $data["responsedetail"] = $this->m_basic->find("responsedetail", array("responseId"=>$responseId, "responseTitle"=>$responseTitle))->row();

        $header = array(
            "subtitle"=>"Response",
            "title"=>"Edit Response Detail"
        );
        $this->load->view('header', $header);
        $this->load->view('editResponseDetail', $data);
        $this->load->view('footer');
    }

    public function editResponseDetail(){
        $responseId = $this->input->post("responseId");
        $oldresponseTitle = $this->input->post("oldresponseTitle");
        $responseTitle = $this->input->post("responseTitle");
        $responseValue = $this->input->post("responseValue");

        //check responseDetail duplicate
        $responseDetailCount = $this->m_basic->find("responsedetail", array("responseId"=>$responseId, "responseTitle"=>$responseTitle))->num_rows();
        if($oldresponseTitle == $responseTitle){
            $responseDetailCount--;
        }
        if(!$responseDetailCount > 0){
            $this->m_basic->update(array("responseId"=>$responseId, "responseTitle"=>$oldresponseTitle), "responsedetail", array("responseTitle"=>$responseTitle, "responseValue"=>$responseValue));
        }else{
            $_SESSION["error"] = "This response detail title has been used, please use another name";
            $this->session->mark_as_flash("error");
        }

        redirect(base_url("response/edit_response/").$responseId);
    }

    public function delete_response_detail($responseId, $responseTitle){
        $responseTitle = rawurldecode($responseTitle);
        $this->m_basic->update(array("responseId"=>$responseId, "responseTitle"=>$responseTitle), "responsedetail", array("responseDetailStatus"=>"0"));

        redirect(base_url("response/edit_response/$responseId"));
    }

    public function activate_response_detail($responseId, $responseTitle){
        $responseTitle = rawurldecode($responseTitle);
        $this->m_basic->update(array("responseId"=>$responseId, "responseTitle"=>$responseTitle), "responsedetail", array("responseDetailStatus"=>"1"));

        redirect(base_url("response/edit_response/$responseId"));
    }
}

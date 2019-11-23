<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Response extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }
    
    public function all_response(){
        $appId = "1";
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
        $appId = "1";

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
        $appId = "1";

        $responseName = $this->input->post("responseName");

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
}

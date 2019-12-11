<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {
    
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

    public function all_item(){
        $appId = $_SESSION["appId"];
        $data['item'] = $this->m_basic->find('item', array("appId"=>$appId))->result();

        $header = array(
            "subtitle"=>"Item",
            "title"=>"All Item"
        );
        $this->load->view('header', $header);
        $this->load->view('allItem', $data);
        $this->load->view('footer');
    }

    public function new_item(){
        $data["appId"] = $_SESSION["appId"];
        $header = array(
            "subtitle"=>"Item",
            "title"=>"New Item"
        );
        $this->load->view('header', $header);
        $this->load->view('newItem', $data);
        $this->load->view('footer');
    }

    public function newItem(){
        $appId = $_SESSION["appId"];
        $itemName = str_replace(" ", "_", $this->input->post("item"));
        $itemValue = $this->input->post("value");
        $itemDetail = $this->input->post("detail");
        $optionValue = $this->input->post("optionValue");
        $optionName = $this->input->post("optionName");
        
        $itemCounter = $this->m_basic->find("item", array("itemName"=>$itemName, "appId"=>$appId))->num_rows();
        if(!$itemCounter > 0){
            $itemId = $this->m_basic->insert("item", array("appId"=>$appId, "itemName"=>$itemName, "itemValue"=>$itemValue, "itemDetail"=>$itemDetail, "itemStatus"=>"1"));
    
            foreach($optionValue as $counter => $optionValues){
                if($optionValues != null){
                    $optionNames = $optionName[$counter];
                    
                    //check item option duplicate
                    $itemOptionCounter = $this->m_basic->find("itemOption", "itemId ='$itemId' AND (itemOptionValue = '$optionValues' OR itemOptionName = '$optionNames')")->num_rows();
                    if(!$itemOptionCounter > 0){
                        $this->m_basic->insert("itemOption", array("itemId"=>$itemId, "itemOptionValue"=>$optionValues, "itemOptionName"=>$optionName[$counter], "itemOptionStatus"=>"1"));
                    }else{
                        $_SESSION['error'] = 'This item option name(s) or value(s) has been used';
                        $this->session->mark_as_flash('error');
                    }
                }
            }
        }else{
            $_SESSION['error'] = 'This item name has been used, please use another name';
            $this->session->mark_as_flash('error');
        }

        redirect(base_url("item/all_item"));
    }

    public function edit_item($itemId){
        $appId = $_SESSION["appId"];

        $item = $this->m_basic->find("item", array("appId"=>$appId, "itemId"=>$itemId))->row();
        if($item->itemValue == "select"){
            $data["option"] = $this->m_basic->find("itemOption", array("itemId"=>$item->itemId))->result();
        }
        $data["item"] = $item;
        $header = array(
            "subtitle"=>"Item",
            "title"=>"Edit Item"
        );
        $this->load->view('header', $header);
        $this->load->view('editItem', $data);
        $this->load->view('footer');
    }

    public function editItem(){
        $itemId = $this->input->post("itemId");
        $itemDetail = $this->input->post("detail");
        $optionValue = $this->input->post("optionValue");
        $optionName = $this->input->post("optionName");
        
        $this->m_basic->update(array("itemId"=>$itemId), "item", array("itemDetail"=>$itemDetail));

        if(isset($optionValue)){
            foreach($optionValue as $counter => $optionValues){
                $optionNames = $optionName[$counter];
                    
                //check item option duplicate
                $itemOptionCounter = $this->m_basic->find("itemOption", "itemId ='$itemId' AND (itemOptionValue = '$optionValues' OR itemOptionName = '$optionNames')")->num_rows();
                if(!$itemOptionCounter > 0){
                    $this->m_basic->insert("itemOption", array("itemId"=>$itemId, "itemOptionValue"=>$optionValues, "itemOptionName"=>$optionName[$counter], "itemOptionStatus"=>"1"));
                }else{
                    $_SESSION['error'] = 'This item option name(s) or value(s) has been used';
                    $this->session->mark_as_flash('error');
                }
            }
        }

        redirect(base_url("item/all_item"));
    }

    public function delete_item($itemId){
        $this->m_basic->update(array("itemId"=>$itemId), "item", array("itemStatus"=>"0"));

        redirect(base_url("item/all_item"));
    }

    public function activate_item($itemId){
        $this->m_basic->update(array("itemId"=>$itemId), "item", array("itemStatus"=>"1"));

        redirect(base_url("item/all_item"));
    }

    public function edit_item_option($itemId, $itemOptionValue){
        $data['itemOption'] = $this->m_basic->find("itemOption", array("itemId"=>$itemId, "itemOptionValue"=>$itemOptionValue))->row();

        $header = array(
            "subtitle"=>"Item",
            "title"=>"Edit Item Option"
        );
        $this->load->view('header', $header);
        $this->load->view('editItemOption', $data);
        $this->load->view('footer');
    }

    public function editItemOption(){
        $itemId = $this->input->post("itemId");
        $itemOptionValue = $this->input->post("itemOptionValue");
        $itemOptionName = $this->input->post("itemOptionName");
        $itemOptionValueOld = $this->input->post("itemOptionValueOld");
        $itemOptionNameOld = $this->input->post("itemOptionNameOld");

        //check item option duplicate
        $itemOptionCounter = $this->m_basic->find("itemOption", "itemId ='$itemId' AND (itemOptionValue = '$itemOptionValue' OR itemOptionName = '$itemOptionName')")->num_rows();
        if(!$itemOptionCounter > 0){
            $this->m_basic->update(array("itemId"=>$itemId, "itemOptionValue"=>$itemOptionValueOld, "itemOptionName"=>$itemOptionNameOld), "itemoption", array("itemOptionName"=>$itemOptionName, "itemOptionValue"=>$itemOptionValue));
        }else{
            $_SESSION['error'] = 'This item option name(s) or value(s) has been used';
            $this->session->mark_as_flash('error');
        }
            
        redirect(base_url("item/edit_item/"). $itemId);
    }
}?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }

    public function all_item(){
        $data['item'] = $this->m_basic->find('item', array("appId"=>"1"))->result();

        $header = array(
            "subtitle"=>"Item",
            "title"=>"All Item"
        );
        $this->load->view('header', $header);
        $this->load->view('allItem', $data);
        $this->load->view('footer');
    }

    public function new_item(){
        $data["appId"] = "1";
        $header = array(
            "subtitle"=>"Item",
            "title"=>"New Item"
        );
        $this->load->view('header', $header);
        $this->load->view('newItem', $data);
        $this->load->view('footer');
    }

    public function newItem(){
        $appId = "1";
        $itemName = str_replace(" ", "_", $this->input->post("item"));
        $itemValue = $this->input->post("value");
        $itemDetail = $this->input->post("detail");
        $optionValue = $this->input->post("optionValue");
        $optionName = $this->input->post("optionName");
        
        $itemId = $this->m_basic->insert("item", array("appId"=>$appId, "itemName"=>$itemName, "itemValue"=>$itemValue, "itemDetail"=>$itemDetail, "itemStatus"=>"1"));

        foreach($optionValue as $counter => $optionValues){
            if($optionValues != null){
                $this->m_basic->insert("itemOption", array("itemId"=>$itemId, "itemOptionValue"=>$optionValues, "itemOptionName"=>$optionName[$counter], "itemOptionStatus"=>"1"));
            }
        }

        redirect(base_url("item/all_item"));
    }

    public function edit_item($itemId){
        $appId = "1";

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
        $appId = "1";
        $itemId = str_replace(" ", "_", $this->input->post("item"));
        $itemDetail = $this->input->post("detail");
        $optionValue = $this->input->post("optionValue");
        $optionName = $this->input->post("optionName");
        
        $this->m_basic->update(array("appId"=>$appId, "itemId"=>$itemId), "item", array("itemDetail"=>$itemDetail));

        if(isset($optionValue)){
            foreach($optionValue as $counter => $optionValues){
                $this->m_basic->insert("itemOption", array("itemId"=>$itemId, "itemOptionValue"=>$optionValues, "itemOptionName"=>$optionName[$counter], "itemOptionStatus"=>"1"));
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

        $this->m_basic->update(array("itemId"=>$itemId, "itemOptionValue"=>$itemOptionValue), "itemoption", array("itemOptionName"=>$itemOptionName));
        
        redirect(base_url("item/edit_item/"). $itemId);
    }
}?>
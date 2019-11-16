<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entity extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
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
        //$this->m_basic->insert("entity", array("entity"=>$entity, "detail"=>$detail));

        //memasukkan value baru
        foreach($value as $counter =>$values){
            $expressions = explode(";", $expression[$counter]);

            $json = json_encode(array("value"=>$values, "expressions"=>$expressions));
            $server_output = doStuff("entities/".$entity."/values/", null, $json);
            echo $server_output. "<br>";
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
}?>
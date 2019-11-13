<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entity extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }

    public function new_value(){
        $header = array(
            "subtitle"=>"Entity",
            "title"=>"New Entity"
        );
        $this->load->view('header', $header);
        $this->load->view('newValue');
        $this->load->view('footer');
    }

    public function insertValue(){
        $entity = $this->input->post("entity");
        $value = $this->input->post("value");

        //untuk memasukkan entity baru
        $json = json_encode(array("value"=>$value));
        $server_output = doStuff("entities/". $entity, null, $json);
        echo $server_output. "<br>";
        //memasukkan entity ke db
        $this->m_basic->insert("value", array("entity"=>$entity, "value"=>$value));
    }
}?>
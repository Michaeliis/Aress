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

        //untuk memasukkan entity baru
        $json = json_encode(array("id"=>$entity));
        $server_output = doStuff("entities/", null, $json);
        echo $server_output. "<br>";
        //memasukkan entity ke db
        $this->m_basic->insert("entity", array("entity"=>$entity, "detail"=>$detail));
    }
}?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bot extends CI_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }
    
    public function testApi(){
        $input = json_decode(file_get_contents('php://input'),true);
        $data = $input['text'];
        $this->m_basic->insert("keyword", array("entity"=>"Ini Test", "keyword"=>$data));
    }

}
?>
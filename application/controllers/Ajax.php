<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }
    
    public function selectValue(){
        $entity = $this->input->post('entity');
        $where = array("entity"=>$entity);
        $data = $this->m_basic->find("value", $where)->result();
        echo json_encode($data);
    }

}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keyword extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }
    
    public function all_keyword(){
        $data['keyword'] = $this->m_basic->gets('keyword')->result();

        $header = array(
            "subtitle"=>"Keyword",
            "title"=>"All Keyword"
        );
        $this->load->view('header', $header);
        $this->load->view('allKeyword', $data);
        $this->load->view('footer');
    }

    public function edit_keyword($entity){
        $data['keyword'] = $this->m_basic->find("keyword", array("entity"=>$entity))->result();
        $data['entity'] = $entity;

        $header = array(
            "subtitle"=>"Keyword",
            "title"=>"Edit Keyword"
        );
        $this->load->view('header', $header);
        $this->load->view('editKeyword', $data);
        $this->load->view('footer');
    }

    public function edit_keyword_detail($entity, $keyword){
        $data['keyword'] = $keyword;
        $data['entity'] = $entity;

        $header = array(
            "subtitle"=>"Keyword",
            "title"=>"Edit Keyword"
        );
        $this->load->view('header', $header);
        $this->load->view('editKeywordDetail', $data);
        $this->load->view('footer');
    }

    public function editKeywordDetail(){
        $entity = $this->input->post("entity");
        $keyword = $this->input->post("keyword");
        $keywordOld = $this->input->post("keywordOld");

        //remove old keyword
        $type = "entities/".$entity."/values/".$entity."/expressions/".rawurlencode($keywordOld);
        deleteStuff($type);
        //insert new keyword
        $type = "entities/".$entity."/values/".$entity."/expressions";
        $json = json_encode(array("expression"=>$keyword));
        doStuff($type, null, $json);
        //update keyword to db
        $this->m_basic->update(array("entity"=>$entity, "keyword"=>$keywordOld), "keyword", array("keyword"=>$keyword));
    }

    public function deleteKeywordDetail($entity, $keyword){
        $this->m_basic->delete(array("entity"=>$entity, "keyword"=>$keyword), "keyword");
        $type = "entities/".$entity."/values/".$entity."/expressions/".rawurlencode($keyword);
        deleteStuff($type);
    }

    public function new_keyword_detail($entity){
        $data['entity'] = $entity;
        
        $header = array(
            "subtitle"=>"Keyword",
            "title"=>"New Keyword"
        );
        $this->load->view('header', $header);
        $this->load->view('newKeywordDetail', $data);
        $this->load->view('footer');
    }

    public function insertKeywordDetail(){
        $entity = $this->input->post("entity");
        $keyword = $this->input->post("keyword");

        foreach($keyword as $keywords){
            $type = "entities/".$entity."/values/".$entity."/expressions";
            $json = json_encode(array("expression"=>$keywords));
            doStuff($type, null, $json);
        
            $this->m_basic->insert("keyword", array("entity"=>$entity, "keyword"=>$keywords));
        }
    }
}?>
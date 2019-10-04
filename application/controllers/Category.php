<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }
    
    public function all_category(){
        $data["category"] = $this->m_basic->gets("category")->result();

        $header = array(
            "subtitle"=>"Category",
            "title"=>"All Category"
        );
        $this->load->view('header', $header);
        $this->load->view('allCategory', $data);
        $this->load->view('footer');
    }

    public function new_category(){
        $header = array(
            "subtitle"=>"Category",
            "title"=>"New Category"
        );
        $this->load->view('header', $header);
        $this->load->view('newCategory');
        $this->load->view('footer');
    }

    public function insertCategory(){
        $category = $this->input->post('category');
        $detail = $this->input->post('detail');
        
        $data = array(
            "categoryName"=>$category,
            "categoryDetail"=>$detail,
            "categoryStatus"=>1
        );

        $this->m_basic->insert("category", $data);
        
        redirect(base_url("category/all_category"));
    }

    public function edit_category($categoryName){
        $data['category'] = $this->m_basic->find("category", array("categoryName"=>$categoryName))->row();

        $header = array(
            "subtitle"=>"Category",
            "title"=>"New Category"
        );
        $this->load->view('header', $header);
        $this->load->view('editCategory', $data);
        $this->load->view('footer');
    }

    public function editCategory(){
        $prevcategory = $this->input->post('prevcategory');
        $category = $this->input->post('category');
        $detail = $this->input->post('detail');
        
        $data = array(
            "categoryName"=>$category,
            "categoryDetail"=>$detail,
            "categoryStatus"=>1
        );

        $this->m_basic->update(array("categoryName"=>$prevcategory), "category", $data);
        
        redirect(base_url("category/all_category"));
    }
}

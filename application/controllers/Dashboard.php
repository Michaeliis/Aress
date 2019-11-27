<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
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
    
    public function index(){

        $header = array(
            "subtitle"=>"Dashboard",
            "title"=>"Dashboard"
        );
        $this->load->view('headerDashboard', $header);
        $this->load->view('dashboard');
        $this->load->view('footerDashboard');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
        $this->load->model('m_dashboard');

        $this->load->library("session");

        if(!isset($_SESSION["userId"])){
            redirect(base_url("login/login"));
        }
    }
    
    public function index(){
        //message in
        $startDate = strtotime(date("Y-m-d").' -7 days');
        $endDate = strtotime(date("Y-m-d"));
        while($startDate<=$endDate){
            $day = date("d-M", $startDate);
            $count = $this->m_dashboard->countMessageDay(date("Y-m-d", $startDate), null)->row()->count;
            $messageIns[] = array($day, $count);

            $startDate = strtotime(date("Y-m-d", $startDate). ' + 1 days');
        }
        
        $messageIn = 
        array(array(
            "data"=>$messageIns,
            "color"=>"#0088cc"
        ));

        //message replied
        $startDate = strtotime(date("Y-m-d").' -7 days');
        $endDate = strtotime(date("Y-m-d"));
        while($startDate<=$endDate){
            $day = date("d-M", $startDate);
            $count = $this->m_dashboard->countMessageDay(date("Y-m-d", $startDate), 1)->row()->count;
            $messageReplieds[] = array($day, $count);
            $startDate = strtotime(date("Y-m-d", $startDate). ' + 1 days');
        }
        
        $messageReplied = 
        array(array(
            "data"=>$messageReplieds,
            "color"=>"#0088cc"
        ));

        $data["messageIn"] = json_encode($messageIn, JSON_NUMERIC_CHECK);
        $data["messageReplied"] = json_encode($messageReplied, JSON_NUMERIC_CHECK);

        $totMes = $this->m_dashboard->countMessage(null, null, null)->row()->count;
        $data["totalMessage"] = $totMes;
        $totRep = $this->m_dashboard->countMessage(null, null, 1)->row()->count;
        $data["totalReplied"] = $totRep;

        $todMes = $this->m_dashboard->countMessageDay(date("Y-m-d"), null)->row()->count;
        $data["todayMessage"] = $todMes;
        $todRep = $this->m_dashboard->countMessageDay(date("Y-m-d"), 1)->row()->count;
        $data["todayReplied"] = $todRep;
        if($totMes !=0 ){
            $percentReplied = round($totRep/$totMes*100);
        }else{
            $percentReplied = 0;
        }
        $data["percentReplied"] = $percentReplied;

        if($todMes !=0 ){
            $percentRepliedToday = round($todRep/$todMes*100);
        }else{
            $percentRepliedToday = 0;
        }
        $data["percentRepliedToday"] = $percentRepliedToday;

        $header = array(
            "subtitle"=>"Dashboard",
            "title"=>"Dashboard"
        );
        $this->load->view('headerDashboard', $header);
        $this->load->view('dashboard', $data);
        $this->load->view('footerDashboard');
    }

    public function testDate(){
        $count = $this->m_dashboard->countMessageDay(date("Y-m-d"), null)->row()->count;
        echo $count;
    }
}

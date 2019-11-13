<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestDB extends CI_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
        $this->load->model('m_itop');
    }

    public function insertBlob(){
        $user_name = "AAA AAA";
        $user_id = "3";
        $date = "2019-11-01 03:15:47";
        $text = "<p>This is not a threat</p>";

        $length_text = strlen($text)+2;
        $separator = 52 + strlen($user_name) + strlen($user_id);

        $theText = 'a:1:{i:0;a:6:{s:9:"user_name";s:'.strlen($user_name).':"'.$user_name.'";s:7:"user_id";s:'.strlen($user_id).':"'.$user_id.'";s:4:"date";i:'.date_format(date_create($date), "U").';s:11:"text_length";i:'.$length_text.';s:16:"separator_length";i:'.$separator.';s:6:"format";s:4:"html";}};';

        $this->m_itop->insert("tabletest", array("stuff"=>"testmasuk"));
        echo $theText. "<br><br>";

        $full_text = "========== ".$date." : ".$user_name." (".$user_id.") ============

".$text;
        echo $full_text;
    }

    public function echoAssArray(){
        $thing = array();
        $thing["jjba"][] = "Phantom Blood";
        $thing["jjba"][] = "Burning Blood";
        $thing["jjba"][] = "Stardust Crusade";

        foreach($thing as $things => $value){
            echo $things . "->";
            foreach($value as $values){
                echo $values . "<br>";
            }
            
        }
    }

    public function testStuff(){
        $data['response'] = $this->m_basic->gets('response')->result();
        $data['category'] = $this->m_basic->gets('category')->result();
        $data['user'] = $this->m_basic->gets('user')->result();

        $data['entity'] = $this->m_basic->gets('entity')->result();

        $header = array(
            "subtitle"=>"Train",
            "title"=>"Train Bot"
        );
        $this->load->view('header', $header);
        $this->load->view('testNewSample', $data);
        $this->load->view('footer');
    }

    public function testJquery(){
        $this->load->view("testJquery");
    }
}
?>
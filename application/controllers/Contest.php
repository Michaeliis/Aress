<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contest extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('M_basic');
	}
	public function index()
	{
		$this->load->view("home");
    }
    
    public function testConverse(){
        $this->load->view('test');
    }
    
    public function converse(){
        $text = $this->input->post("text");

        $server_output = doStuff("message", $text, null);
        
        $result = json_decode($server_output);
        
        if(isset($result->entities->intent[0]->value)){
            $intent = $result->entities->intent[0]->value;
            
            $querRes = $this->m_default->getResponse($intent)->result();
            foreach($querRes as $querRess){
                $answer = $querRess->response;
            }
            
        }else{
            $answer = "no intent";
        }
        
        $data = array(
            "text"=>$text,
            "answer"=>$answer
        );
        
        $this->load->view("test2", $data);
    }

    public function newIntent(){
        $this->load->view('new_intent');
    }

    public function insertIntent(){
        $intentName = $this->input->post("intent");
        $sample = $this->input->post("sample");
        $keyword = $this->input->post('keyword');
        $synonym = $this->input->post('synonym');
        $category = $this->input->post('category');
        $assign = $this->input->post('assign');
        $response = $this->input->post('response');
        
        //untuk memasukkan intent baru 
        $json1 = json_encode(array("value"=>$intentName));
        echo $json1. "<br>";
        $server_output1 = doStuff("entities/intent", null, $json1);
        //ke DB
        $dataIntentDb = array(
            "intent"=>$intentName,
            "response"=>$response,
            "category"=>$category,
            "assignedTo"=>$assign
        );
        $this->M_basic->insert("response", $dataIntentDb);


        //untuk memasukkan sample
        $sampleJson[0] = array(
            "text"=>$sample,
            "entities"=>array(
                array(
                    "entity"=>"intent",
                    "value"=>$intentName
                )
                
            )
            
        );

        $counter = 0;
        foreach($keyword as $keywords){
            echo $keywords;
            echo $synonym[$counter];

            //untuk memasukkan entity baru
            $json = json_encode(array("id"=>$keywords));
            echo $json. "<br>";
            $server_output = doStuff("entities/", null, $json);

            //untuk memasukkan keyword baru
            $infoKeyword = array(
                "values"=>array(
                    "value"=>$keywords,
                    "expressions"=>array($synonym[$counter])
                    )
            );
            $json1 = json_encode($infoKeyword);
            echo $json1. "<br>";
            $server_output1 = doStuff("entities/".$keywords, null, $json1);

            //menambahkan keywords ke json sample
            $posKey = strpos($sample, $keywords);
            $endKey = $posKey + strlen($keywords);

            $sampleJson[0]["entities"][] = array(
                "entity"=>$keywords,
                "value"=>$keywords,
                "start"=>$posKey,
                "end"=>$endKey,
                "value"=>$keywords
            );

            $counter++;
        }

        /*Untuk mekasukkan keyword (legacy)
        //untuk memasukkan entity baru
        $json = json_encode(array("id"=>$keyword2));
        echo $json. "<br>";
        $server_output = doStuff("entities/", null, $json);
        //untuk memasukkan keyword baru
        $json1 = json_encode(array("value"=>$keyword2));
        echo $json1. "<br>";
        $server_output1 = doStuff("entities/".$keyword2, null, $json1);
        */

        //untuk memasukkan sample baru
        $json1 = json_encode($sampleJson);
        echo $json1. "<br>";
        $server_output1 = doStuff("samples/", null, $json1);
        
        echo "Intent telah dibuat";
    }

    public function chat($msgId){
        $data['msgInfo'] = $this->M_basic->find('message', array("msgId"=>$msgId))->result();
        $data['chat'] = $this->M_basic->find('chat', array("msgId"=>$msgId))->result();

        $header = array(
            "collapse"=>true,
            "subtitle"=>"Report",
            "title"=>"Mail"
        );
        $this->load->view('header', $header);
        $this->load->view('messageSide');
        $this->load->view('chat', $data);
        $this->load->view('footer');
    }

    public function compose(){
        $header = array(
            "collapse"=>true,
            "subtitle"=>"Report",
            "title"=>"New Report"
        );
        $this->load->view('header', $header);
        $this->load->view('messageSide');
        $this->load->view('compose');
        $this->load->view('footer');
    }
    
    public function sendReport(){
        //tarik data form
        $message = $this->input->post('report');
        $subject = $this->input->post('subject');
        //$msgReceiver = $this->input->post('to');

        //tarik data session
        $msgSender = "Saya";

        //tarik tanggal
        $curDate = date("Y-m-d H:i:s");
        $msgId = date("YmdHis");

        //interact dengan NLP
        $server_output = doStuff("message", $message, null);
        
        $result = json_decode($server_output);
        
        if(isset($result->entities->intent[0]->value)){
            $intent = $result->entities->intent[0]->value;
            
            $querRes = $this->m_default->getResponse($intent)->result();
            foreach($querRes as $querRess){
                $answer = $querRess->response;
                $category = $querRess->category;
                $assignedTo = $querRess->assignedTo;
            }
            
        }else{
            $answer = "no intent";
        }
        
        //insert message baru
        $data = array(
            "msgId"=>$msgId,
            "msgSubject"=>$subject,
            "msgSender"=>$msgSender,
            "msgCategory"=>$category,
            "msgReceiver"=>$assignedTo,
            "msgDate"=>$curDate,
            "msgStatus"=>1
        );
        $this->M_basic->insert('message', $data);

        //insert chat baru
        $data = array(
            "msgId"=>$msgId,
            "chatId"=>$msgId,
            "chatSender"=>$msgSender,
            "chatReceiver"=>$assignedTo,
            "chatContent"=>$message,
            "chatDate"=>$curDate,
            "chatStatus"=>1
        );
        $this->M_basic->insert('chat', $data);
        
        //insert chat balasan bot
        $data = array(
            "msgId"=>$msgId,
            "chatId"=>"reply",
            "chatSender"=>"Ares",
            "chatReceiver"=>$msgSender,
            "chatContent"=>$answer,
            "chatDate"=>$curDate,
            "chatStatus"=>1
        );
        $this->M_basic->insert('chat', $data);
    }

    public function inbox(){
        //$data['message'] = $this->M_basic->find('message', array('msgReceiver'=>'Ares'))->result();

        $data['message'] = $this->M_basic->gets('message')->result();
        $header = array(
            "collapse"=>true,
            "subtitle"=>"Report",
            "title"=>"Report List"
        );
        $this->load->view('header', $header);
        $this->load->view('messageSide');
        $this->load->view('messageList', $data);
        $this->load->view('footer');
    }

    public function message_all(){
        $data['message'] = $this->M_basic->gets('message')->result();

        $header = array(
            "subtitle"=>"Report",
            "title"=>"Report List"
        );
        $this->load->view('header', $header);
        $this->load->view('msgAll', $data);
        $this->load->view('footer');
    }

    public function train_bot(){
        $data['response'] = $this->M_basic->gets('response')->result();

        $header = array(
            "subtitle"=>"Train",
            "title"=>"Train Bot"
        );
        $this->load->view('header', $header);
        $this->load->view('trainbot', $data);
        $this->load->view('footer');
    }

    public function testDynamic(){
        $keyword = $this->input->post('keyword');
        $synonym = $this->input->post('synonym');
        
        $counter = 0;
        foreach($keyword as $keywords){
            echo $keywords;
            echo $synonym[$counter];
            $counter++;
        }
    }
}

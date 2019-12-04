<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
        $this->load->model('m_witai');
    }
    
    public function callApi(){
        $input = json_decode(file_get_contents('php://input'),true);
        $message = $input['text'];

        $appToken = $input["appToken"];

        $app = $this->m_basic->find("app", array("appToken"=>$appToken))->row();
        $appId = $app->appId;

        //interact dengan NLP
        $server_output = doStuff("message", strip_tags($message), null, $appToken);
        $result = json_decode($server_output, true);

        $entity = $result["entities"];

        //mengecek response dari db
        $result = $this->m_witai->searchCondition($entity, $appId)->row();
        if(isset($result)){
            $conditionId = $result->conditionId;
            $response = $this->m_basic->find("conditionresponse", array("conditionId"=>$conditionId))->row();
            if(isset($response)){
                $responseDetail = $this->m_basic->find("responsedetail", array("responseId"=>$response->responseId))->result();
                foreach($responseDetail as $responseDetails){
                    $output[$responseDetails->responseTitle] = $responseDetails->responseValue;
                }
            }
        }

        /*if(!isset($output)){
            $output = array("reply"=>"sorry");
            $this->m_basic->insert("message", array("messageText"=>$message, "messageResponse"=>json_encode($output), "messageDate"=>date("Y-m-d H:i:s"), "messageStatus"=>"1"));
        }else{
            $this->m_basic->insert("message", array("messageText"=>$message, "messageDate"=>date("Y-m-d H:i:s"), "messageStatus"=>"0"));
        }*/
        
        echo json_encode($output);
    }

    public function test(){
        $url = "http://localhost:8080/Aress/api/callapi";

        $data = array("appToken"=>"247QPD6IGXCPG5G5NEPQMYFNVFP3SV7L", "text"=>"komputer saya tidak bisa login");

        $client = curl_init($url);
        curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($client, CURLOPT_POST, 1);
        curl_setopt($client, CURLOPT_POSTFIELDS, json_encode($data));
        $response = json_decode(curl_exec($client));
        /*if(isset($response->reply)){
          $this->Set('description', $data."\n<b>Reply Bot</b>\n".$response->reply);
        }*/
        echo $response->reply;
    }

}
?>
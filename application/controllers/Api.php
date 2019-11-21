<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('m_default');
        $this->load->helper('witai');
        $this->load->model('m_basic');
    }
    
    public function testApi(){
        $input = json_decode(file_get_contents('php://input'),true);
        $text = $input['text'];
        $message = strip_tags($input['text']);


        //interact dengan NLP
        $server_output = doStuff("message", strip_tags($message), null);
        $result = json_decode($server_output, true);

        $entity = $result["entities"];

        //mengecek apa ada condition yang sesuai dalam db
        $query = "SELECT conditionDetail.conditionId, count(conditionDetailId) AS 'score', conditionCount FROM conditionDetail INNER JOIN conditionn ON conditionn.conditionId = conditionDetail.conditionId WHERE ";
        $next = false;
        foreach($entity as $entities => $value){
            foreach($value as $values){
                if($next){
                    $query.= " OR ";
                }
                $query.= "(";
                $query.= "conditionEntity = '".$entities."'";
                $query.= " AND ";
                $query.= "conditionValue = '".$values["value"]."'";
                $query.= ")";
    
                $next = true;
            }
        }
        $query.= " GROUP BY conditionId HAVING count(conditionDetailId) = conditionCount";
        echo $query. "<br><br>";
        $result = $this->m_basic->runQuery($query)->result();
        $conditionId = "";
        foreach($result as $results){
            $conditionId = $results->conditionId;
        }

        $response = $this->m_basic->find("response", array("conditionId"=>$conditionId))->row();
        $responseDetail = $this->m_basic->find("responsedetail", array("responseId"=>$response->responseId))->result();
        foreach($responseDetail as $responseDetails){
            $output[$responseDetails->responseTitle] = $responseDetails->responseValue;
        }

        echo json_encode($output);
    }

}
?>
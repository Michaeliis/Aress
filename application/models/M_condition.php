<?php
class M_condition extends CI_Model{

    function conditionResponse(){
        $appId = $_SESSION['appId'];
        //mengecek response dari db
        
        $this->db->select("conditionn.conditionId, response.responseId, conditionn.conditionName, response.responseName, conditionresponse.crStatus");
        $this->db->from("conditionresponse");
        $this->db->join("conditionn", "conditionn.conditionId = conditionresponse.conditionId");
        $this->db->join("response", "response.responseId = conditionresponse.responseId");
        $this->db->where(array("conditionn.appId"=>$appId, "response.appId"=>$appId));

        return $this->db->get();
    }
    
}
?>
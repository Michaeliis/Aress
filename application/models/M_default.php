<?php
class M_default extends CI_Model{
    
    function getResponse($intent){
        $this->db->select("response, category, assignedTo")->from("response")->where('intent', $intent);
        return $this->db->get();
    }    
}
?>
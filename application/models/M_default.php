<?php
class M_default extends CI_Model{
    
    function getResponse($intent){
        $this->db->select("response")->from("response")->where('intent', $intent);
        return $this->db->get();
    }    
}
?>
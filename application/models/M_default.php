<?php
class M_default extends CI_Model{
    
    function getResponse($intent){
        $this->db->select("response, category, assignedTo")
        ->from("response")
        ->where('intent', $intent);
        return $this->db->get();
    }   
    
    function getFirstChat($table, $where){
        $this->db->select('chatContent')
        ->from($table)
        ->where($where)
        ->limit(1);
        return $this->db->get();
    } 
    function getRestChat($table, $where){
        $this->db->select('chatContent, chatSender, chatDate')
        ->from($table)
        ->where($where)
        ->limit(256, 1);
        return $this->db->get();
	} 
}
?>
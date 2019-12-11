<?php
class M_dashboard extends CI_Model{

    function countMessageDay($date, $status){
        $appId = $_SESSION['appId'];
        //mengecek response dari db
        
        $dateAfter = date("Y-m-d", strtotime($date.' +1 days'));
        $this->db->select("count(messageId) as count");
        $this->db->from("message");

        $where = array("messageDate > "=>$date, "messageDate < "=>$dateAfter);
        if($status!=null){
            $where["messageStatus"] = $status;
        }
        $where["appId"] = $appId;
        $this->db->where($where);

        return $this->db->get();
    }

    function countMessage($dateStart, $dateEnd, $status){
        $appId = $_SESSION['appId'];

        $this->db->select("count(messageId) as count");
        $this->db->from("message");
        if($dateStart != null){
            $where = array("messageDate > "=>$dateStart, "messageDate < "=>$dateEnd);
        }
        if($status != null){
            $where["messageStatus"] = $status;
        }
        $where["appId"] = $appId;
        $this->db->where($where);

        return $this->db->get();
    }
    
}
?>
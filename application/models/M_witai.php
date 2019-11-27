<?php
class M_witai extends CI_Model{

    function searchCondition($entity){
        //mengecek response dari db
        $query = "SELECT conditionDetail.conditionId, count(conditionDetailId) AS 'score', conditionCount, conditionIntent.conditionIntent FROM conditionDetail INNER JOIN conditionn ON conditionn.conditionId = conditionDetail.conditionId JOIN conditionintent ON conditionintent.conditionId = conditionDetail.conditionId WHERE ";
        $next = false;
        foreach($entity as $entities => $value){
            if($entities != "intent"){
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
            }else{
                $intentValue = $value[0]["value"];
            }
        }

        if(isset($intentValue)){
            $query.= " AND conditionIntent.conditionIntent = '$intentValue'";
        }
        $query.= " GROUP BY conditionId HAVING count(conditionDetailId) = conditionCount";

        return $this->db->query($query);
    }
    
}
?>
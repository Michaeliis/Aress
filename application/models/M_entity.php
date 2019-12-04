<?php
class M_entity extends CI_Model{

    function entitySet($entityId){
        $appId = $_SESSION['appId'];
        //mengecek response dari db
        
        $this->db->select("entity.entityId, entity.entityName, value.valueId, value.value, expression.expressionId, expression.expression");
        $this->db->from("entity");
        $this->db->join("value", "value.entityId = entity.entityId");
        $this->db->join("expression", "expression.valueId = value.valueId");
        $this->db->where(array("value.valueStatus"=>1, "expression.expressionStatus"=>1, "entity.entityId"=>$entityId));

        return $this->db->get();
    }

    function valueEntity($valueId){
        $this->db->select("value.valueId, value.value, entity.entityId, entity.entityName");
        $this->db->from("value");
        $this->db->join("entity", "value.entityId = entity.entityId");
        $this->db->where(array("value.valueStatus"=>1, "value.valueId"=>$valueId));

        return $this->db->get();
    }

    function valueExpression($valueId){
        $this->db->select("value.valueId, value.value, expression.expressionId, expression.expression");
        $this->db->from("value");
        $this->db->join("expression", "expression.valueId = value.valueId");
        $this->db->where(array("value.valueStatus"=>1, "expression.expressionStatus"=>1, "value.valueId"=>$valueId));

        return $this->db->get();
    }   
}
?>
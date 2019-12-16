<?php
class M_basic extends CI_Model{
    
    function insert($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    
    function find($table, $where){
		return $this->db->get_where($table, $where);
	}
    
    function gets($table){
        return $this->db->get($table);
    }
    
    function coun($table)
    {
        return $this->db->get($table)->num_rows();
    }
    
    function update($where, $table, $data)
    {
		$this->db->where($where);
		$this->db->update($table, $data);
    }
    
    function delete($where, $table){
        $this->db->delete($table, $where);
    }

    function runQuery($query){
        return $this->db->query($query);
    }

    function set($where, $table, $from, $to){
        $this->db->set($from, $to, false);
        $this->db->where($where);
        $this->db->update($table);
    }

    function joinUser($table){
        $appId = $_SESSION['appId'];
        //mengecek response dari db
        
        $this->db->select("*");
        $this->db->from($table);
        $this->db->join("user", "$table.userId = user.userId");
        if($table != "app"){
            $this->db->where(array("appId"=>$appId));
        }

        return $this->db->get();
    }

    function joinUserWhere($table, $where){
        $appId = $_SESSION['appId'];
        //mengecek response dari db
        
        $this->db->select("*");
        $this->db->from($table);
        $this->db->join("user", "$table.userId = user.userId");
        $this->db->where($where);

        return $this->db->get();
    } 
    
}
?>
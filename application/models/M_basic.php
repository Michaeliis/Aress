<?php
class M_basic extends CI_Model{
    
    function insert($table, $data){
        $this->db->insert($table, $data);
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
    
}
?>
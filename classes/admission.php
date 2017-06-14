<?php
 class admission{
 	private $_db,
 			$_data,
			$_dept;
 

 	public function __construct(){
 		$this->_db = DB::getInstance();
 	}
	
	public function get_tb_all($table){
 		$data = $this->_db->get_assoc($table,array('1', '=' ,'1' ));
 			if($data->count()){
				return $this->_db->results();
 			}
			
 	}
	
	
	public function get_table($dept){
			$data = $this->_db->get('admission',array('department', '=' ,$dept ));
 			if($data->count()){
 				$this->_data = $data->first();
				$_dept;
				return true;
 			}
			
	}
	
	public function get_dept(){
	return $this->_dept;
	}
	
	 public function data(){
 		return $this->_data;
 	}

}
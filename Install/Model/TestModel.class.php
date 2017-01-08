<?php
 namespace Install\Model;
 use Think\Model;
 class TestModel extends Model{
	 public function __construct($connection=''){
		
		 if(!empty($connection)){
			 $this->connection =$connection ;
			 
		 }
		
		 
	 }
	 public function testConnectDb(){
		$this->db(1,$this->connection)->query("show tables");
	 }
	 public function executeSql($sql){
		 $this->db(1,$this->connection)->execute($sql);
	 }

 }
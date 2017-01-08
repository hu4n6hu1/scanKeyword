<?php
 namespace Admin\Model;
 class FileConfigModel{
	 protected $path;
	 protected $fileContents;
	 public function __construct($name,$path=''){

		$baseDir=dirname(__FILE__);
        $baseDir=str_replace('\\','/',$baseDir);
        $baseDir=substr($baseDir,-1)=='/'?$baseDir:$baseDir.'/';
		if(empty($path)){
			$this->path=$baseDir.'../../Common/Conf/'.$name;
			return true;
		}
		$this->path=$path.$name;
	 } 
	
	 public function readConfigFile(){
		 
		 if(!file_exists($this->path) ){
			 return false;
		 }
		
		 $this->fileContents=include $this->path;
		 if(!is_array($this->fileContents)){
			 $this->fileContents=array();
		 }
		 return $this->fileContents;
	 }
	 
	 public function addConfig($config){
		if(empty($this->fileContents)){ $this->readConfigFile();}
			//$this->fileContents=$this->fileContents+$config;//另外一种实现方法
			$this->fileContents=array_merge($this->fileContents,(array)$config);
			
		return $this->fileContents;
	 }
	 
	 public function addConfigRecursive($config){
		if(empty($this->fileContents)){ $this->readConfigFile();}
			$this->fileContents=array_merge_recursive($this->fileContents,(array)$config);
			
		return $this->fileContents;
	 }
	 
	 public function  updateConfig($key,$value){
		 if(empty($this->fileContents)){ $this->readConfigFile();}
		 $this->fileContents[$key]=$value;
		 return $this->fileContents;
	 }
	 
	 public function deleteConfig($key){
		 if(empty($this->fileContents)){ $this->readConfigFile();}
		 unset($this->fileContents[$key]);
		 return $this->fileContents;
	 }
	 
	 public function getConfig($key){
		 if(empty($this->fileContents)){ $this->readConfigFile();}
		 return $this->fileContents[$key];
	 }
	 
	 public function saveConfig(){
		  if(empty($this->fileContents)){ return false ;}
		  $content='<?php return   '.var_export($this->fileContents,true).';';
		 $status=file_put_contents($this->path,$content);
		  return $status;
	 }
	 
 }
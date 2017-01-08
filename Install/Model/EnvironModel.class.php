<?php
 namespace Install\Model;
 class EnvironModel {
	 private function __construct(){}
	 
	 public static function comparePHPVersion($version='5.3.0'){
		 return version_compare(phpversion(),$version,">=");
	 } 
	 
	 public static function setErrorReport(){
		 error_reporting(E_ALL & ~E_NOTICE);
	 }
	 
	 public static function setTimeZone(){
		 date_default_timezone_set('PRC');
	 }
	 
	 public static function getAgent(){
		 return php_uname();
	 }
	 
	 public static function  isSupportGd(){
		 return function_exists('gd_info')? true:false;
		
	 }
	 public static function getUploadInfo(){
		 return ini_get('file_uploads')?ini_get('upload_max_filesize'):false;
	 }
	 public static function isReadable($path){
		  if(file_exists($path)){
			 return is_readable($path);
		 }
		  return false;
	 }
	 public static function isWritable($path){
		 if(file_exists($path)){
			  return is_writable($path);
		 }
		 return false;
	 }
	 public static function isSupportPdo(){
		 return class_exists("pdo")?true:false;
	 }
	 public static function isSupportCurl(){
		 return function_exists("curl_init")?true:false;
	 }
	 public static function isExecutable($path){
		 if(file_exists($path)){
			  return is_executable($path);
		 }
		 return false;
	 }
	 public static function getFilePermission($path){
		  if(file_exists($path)){
			  return substr(sprintf('%o', fileperms($path)), -4);
		 }
		 return false;
	 }
	 public static function isSupportFile_put_contents(){
		 return function_exists('file_put_contents');
	 }
	
	 
	 
 }
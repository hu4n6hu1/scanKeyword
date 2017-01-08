<?php
  define('APP_DEBUG',True);
  
  $baseDir=dirname($_SERVER['SCRIPT_NAME']);
  $baseDir=str_replace('\\','/',$baseDir);
  $baseDir=substr($baseDir,-1)=='/'?$baseDir:$baseDir.'/';
  define("PUBLIC_PATH",$baseDir.'Public');
  require 'vendor/autoload.php';
  include './ThinkPHP/ThinkPHP.php';


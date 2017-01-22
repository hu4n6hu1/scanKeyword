<?php
    namespace Admin\Model;
	
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;
	use Monolog\Handler\FireHandler;
	
	class LogModel{
		public static function log($content,$context='',$path="./Runtime/Logs/")
		{
			$lostLog= new Logger('lost_log');
			$lostLog->pushHandler(new StreamHandler($path.'lost.log'),Logger::INFO );
			$lostLog->addInfo($content,$context);
	    }
	
	}
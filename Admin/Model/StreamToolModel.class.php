<?php
    namespace Admin\Model;
	
	class StreamToolModel 
	{
		public static function sendDataByGet($url){

			$urlInfo=parse_url($url);
			$host=$urlInfo['host'];
			$destination=$urlInfo['path'].'?'.$urlInfo['query'];
			$contents='';
			$fp = stream_socket_client("tcp://$host:80", $errno, $errstr, 30);
            
			if (!$fp) {
              echo "$errstr ($errno)<br />\n";
            } else {
                fwrite($fp, "GET $destination HTTP/1.0\r\nHost:$host\r\nAccept: */*\r\n\r\n");
                while (!feof($fp)) {
                       $contents=$contents.fgets($fp, 1024);
					   
                }
                fclose($fp);
				return $contents;
			}
           
		}
		
	}
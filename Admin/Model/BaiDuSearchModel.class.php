<?php
namespace  Admin\Model;

class BaiDuSearchModel{
	private function __construct(){}
	public static $instance='';
	
	public static function getInstance(){
		if(self::$instance instanceof BaiDuSearchModel){
			return self::$instance;
		}
		self::$instance= new self();
		return self::$instance;
	}
	
	public static function MatchClassF13($contents){
		$pattern='/<div class="f13">.*<\/div>/';
		$result=array();
		$armount=preg_match_all($pattern,$contents,$result);
		return $result[0];
	}
	
	public static function matchRedirectUrl($contents){
	//<script>window.location.replace("http://down.admin5.com/")</script>
		$pattern='/replace\("(.*)"\)/';
		$result=array();
		preg_match($pattern,$contents,$result);
		return $result[1];
	}
	
	
	public static function matchMyHost($contents){
		$pattern='/<a.*?href="(.*?)".*?>(.*?)<\/a>/';
		$result=array();
		$host=array();
		preg_match_all($pattern,$contents,$result);
		if(empty($result[2][0])){
			return false;
		}
		$origin=parse_url('http://'.$result[2][0]);
		$host['origin']='http://'.$origin['host'];
		$host['encryp']=$result[1][0];
		return $host;
	}
	
	public static function getUrlParams(){
	   	return explode('=',$query);
	}
	
	public static function getParams($query){
		$paramList=explode('&',$query);
		$param=array();
		foreach($paramList as $value){
			$temp=explode('=',$value);
			$param[$temp[0]]=$temp[1];
		}
		return $param;
	}
	
	public static function addParam($url,$key,$value){
		$url=$url.'&'.$key.'='.urlencode($value);
		return $url;
	}
}
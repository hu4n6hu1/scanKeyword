<?php
namespace Admin\Model;
use Think\Model;
class MatchModel extends Model{
	 protected $lastError;
	  public function getMatchRecordByLinkIdAndKeywordId($linkId,$keywordId){
		  $result=$this->where('link_id=%d and keyword_id=%d',$linkId,$keywordId)->find();
		  if($result===false){
			  $this->lasstError='数据库错误.';
		  }
		  
		  return $result;
	  }

	  
	  public function addMatchRecord($data){
		  $id=$this->field('keyword_id,link_id,date,rank')->data($data)->add();
		  if($id===false){
			  $this->lasstError='数据库错误.';
			  return false;  
		   }
		   return $id;
	  }
	  
	  protected function updateMatchRecord($data){
		  $affectRow=$this->field('date,rank')->where('link_id=%d and keyword_id=%d',$data['link_id'],$data['keyword_id'])->data($data)->save();
		  if($affectRow===false){
			  $this->lasstError='数据库错误.';
			  return false;  
		  }
		  return $affectRow;
	  }
	  
	  public function addRecord($data){
		  
		  $result=$this->getMatchRecordByLinkIdAndKeywordId($data['link_id'],$data['keyword_id']);
		  if($result===null){
			  return $this->addMatchRecord($data);
	
		  }
		  if($result!=false){
			  return $this-> updateMatchRecord($data);
		  }
		  if($result===false){
			  $this->lasstError='数据库错误.';
			  return false;  
		  } 
		  
		  
	  }
	  
	  public function getRecordList($page=1,$limit=10){
		  $result=$this->field('keyword,date,rank,link')->join('__KEYWORD__ on __MATCH__.keyword_id =__KEYWORD__.id')->page($page,$limit)
		 ->join('__LINK__ on __MATCH__.link_id= __LINK__.id')->select();
		  if($result===false){
			  $this->lasstError='数据库错误.';
			  return false;  
		  }
		  return $result;
	  }
	  
	  public function  getRecordAmount(){
		 return $this->where('1=1')->count();
	  }
	  
	  public function getLastError(){
		  return $this->lastError;
	  }
	  
	  public function cleatAll(){
		 return  $this->where('1=1')->delete();
	  }
	  
	  
}
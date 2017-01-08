<?php
namespace Admin\Model;
use Think\Model;
class MatchModel extends Model{
	 protected $lastError;
	  public function getMatchRecordByLinkId($linkId){
		  $result=$this->where('link_id=%d',$linkId)->find();
		  if($result===false){
			  $this->lasstError='���ݿ����.';
		  }
		  
		  return $result;
	  }

	  
	  public function addMatchRecord($data){
		  $id=$this->field('keyword_id,link_id,date,rank')->data($data)->add();
		  if($id===false){
			  $this->lasstError='���ݿ����.';
			  return false;  
		   }
		   return $id;
	  }
	  
	  protected function updateMatchRecord($data){
		  $affectRow=$this->field('keyword_id,date,rank')->where('link_id=%d',$data['link_id'])->data($data)->save();
		  if($affectRow===false){
			  $this->lasstError='���ݿ����.';
			  return false;  
		  }
		  return $affectRow;
	  }
	  
	  public function addRecord($data){
		  //�ر�����ӿ�
/* 		  $result=$this->getMatchRecordByLinkId($data['link_id']);
		  if($result===null){
			  return $this->addMatchRecord($data);
	
		  }
		  if($result!=false){
			  return $this-> updateMatchRecord($data);
		  }
		  if($result===false){
			  $this->lasstError='���ݿ����.';
			  return false;  
		  } */
		  
		  
	  }
	  
	  public function getRecordList($page=1,$limit=10){
		  $result=$this->field('record_id,keyword,date,rank,link')->join('__KEYWORD__ on __MATCH__.keyword_id =__KEYWORD__.id')->page($page,$limit)
		 ->join('__LINK__ on __MATCH__.link_id= __LINK__.id')->select();
		  if($result===false){
			  $this->lasstError='���ݿ����.';
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
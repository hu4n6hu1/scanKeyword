<?php
namespace Admin\Model;
use Think\Model;
class keywordModel extends Model{
	
	public function getKeywordById($id){
		return $this->where('id=%d',$id)->find();
	}
	
	public function getKeywordLimit($page=1,$limit=0){
		if($limit==0){
			return $this->order('id')->select();
		}
		return $this->page($page,$limit)->order('id')->select();
	}
	
	public function  getRecordAmount(){
		 return $this->where('1=1')->count();
    }
}
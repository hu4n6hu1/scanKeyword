<?php
namespace Admin\Model;
use Think\Model;
class LinkModel extends Model{
	
	public function getLinkById($id){
		return $this->where('id=%d',$id)->find();
	}
	
	public function getLinkLimit($url){
		$map['link'] = array('like',$url.'%');
		return $this->field('id,link')->order('id')->where($map)->select();
		
	}
	
	public function getLinkByLink($link){
		return $this->field('id')->where('link="%s"',$link)->find();
	}
	
	public function  getRecordAmount(){
		 return $this->where('1=1')->count();
	}
	
	public function getLinkList($page,$limit){
		return $this->page($page,$limit)->select();
	}
}
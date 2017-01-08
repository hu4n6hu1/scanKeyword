<?php
	namespace Admin\Model;
	
	  class PageModel {
			public $countData,$nextPage,$previousPage,$countPage,$cureentPage;
			
			/*
			$countData 数据总数量
			$cureentPage 当前处于第几页。 默认为第一页
			*/
			public function __construct($countData,$cureentPage=1){
				$this->countData=intval($countData);
				$this->cureentPage=intval($cureentPage);
			}
			
			/*
			该函数计算一共要分多少页显示数据
			$amountForEachPage 每一关页面显示多少数据，默认10
			return 划分的总页数
			*/
			
			public function getCountPage($amountForEachPage=10){
				
				if($this->countData % $amountForEachPage == 0){
					$this->countPage= $this->countData / $amountForEachPage;
				}else{
					$this->countPage= $this->countData / $amountForEachPage;
					$this->countPage=ceil($this->countPage);	
				}
				return $this->countPage;
			}
			
			/*
			  该函数取得下一个页面的值。
			  return 下一个页面的值
			*/
			public function getNextPage(){
				if(!isset($this->countPage)){
					$this->countPage=$this->getCountPage();
				}
				
				if($this->cureentPage < $this->countPage  && $this->cureentPage >0){
					$this->nextPage=$this->cureentPage+1;	
				}else{
				    $this->nextPage=$this->countPage;
				}
				return $this->nextPage;
				
			}
			
			/*
			  该函数取得上一个页面的值。
			  return 上一个页面的值
			*/
			
			public function getPreviousPage(){
				if(!isset($this->countPage)){
					$this->countPage=$this->getCountPage();
				}
				
				if($this->cureentPage > 1 && $this->cureentPage <= $this->countPage ){
					$this->previousPage=$this->cureentPage-1;	
					
				}else{
				    $this->previousPage=1;
				}
				return $this->previousPage;
			}
			
			
			
			
			
		}
		
/* 
	//测试类是否正常运行
	$obj= new PageModel(120,2);
	echo $obj->getCountPage()."<br>";
	echo $obj->cureentPage."<br>";
	echo $obj->getNextPage()."<br>";
	echo $obj->getPreviousPage()."<br>";
	 */
	
<?php
	namespace Admin\Model;
	
	  class PageModel {
			public $countData,$nextPage,$previousPage,$countPage,$cureentPage;
			
			/*
			$countData ����������
			$cureentPage ��ǰ���ڵڼ�ҳ�� Ĭ��Ϊ��һҳ
			*/
			public function __construct($countData,$cureentPage=1){
				$this->countData=intval($countData);
				$this->cureentPage=intval($cureentPage);
			}
			
			/*
			�ú�������һ��Ҫ�ֶ���ҳ��ʾ����
			$amountForEachPage ÿһ��ҳ����ʾ�������ݣ�Ĭ��10
			return ���ֵ���ҳ��
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
			  �ú���ȡ����һ��ҳ���ֵ��
			  return ��һ��ҳ���ֵ
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
			  �ú���ȡ����һ��ҳ���ֵ��
			  return ��һ��ҳ���ֵ
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
	//�������Ƿ���������
	$obj= new PageModel(120,2);
	echo $obj->getCountPage()."<br>";
	echo $obj->cureentPage."<br>";
	echo $obj->getNextPage()."<br>";
	echo $obj->getPreviousPage()."<br>";
	 */
	
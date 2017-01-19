<?php
namespace Admin\Controller;
use Think\Controller;
use QL\QueryList;

class KeywordController extends Controller {
		protected function isAuthorize(){
               $loginStatus=session('loginStatus');
               if(!$loginStatus){
                  $this->redirect('Index/index','',2,'not authirize');
				  return false;
                  exit();
                }
               $this->userId=session('id');
               $this->userName=session('email');
               $this->assign('userName',$this->userName);
               $this->assign('userId',$this->userId);	
			
		}
	
	public  function index($page=1,$limit=100){	
	    $this->isAuthorize();
		$keywordObj=D('Keyword');
		$linkObj=D('Link');
		$matchObj=D('Match');
		$recordList=$matchObj->getRecordList($page,$limit);
		$count=$matchObj->getRecordAmount();
		$pageObj= new \Admin\Model\PageModel($count,$page);
		$countPage=$pageObj->getCountPage($limit);
		$nextPage=$pageObj->getNextPage();
		$previousPage=$pageObj->getPreviousPage();
		$this->assign('nextPage',$nextPage);
		$this->assign('previousPage',$previousPage);
		$this->assign('countPage',$countPage);	
		$this->assign('currentPage',$page);	
		$this->assign('recordList',$recordList);	
		$this->display('matchList');
	}
	
	public function showKeyword($page=1, $limit=100){
		 $this->isAuthorize();
		$keywordObj=D('Keyword');
		$recordList=$keywordObj->getKeywordLimit($page,$limit);
		$count=$keywordObj->getRecordAmount($page,$limit);
		$pageObj= new \Admin\Model\PageModel($count,$page);
		$countPage=$pageObj->getCountPage($limit);
		$nextPage=$pageObj->getNextPage();
		$previousPage=$pageObj->getPreviousPage();
		$this->assign('nextPage',$nextPage);
		$this->assign('previousPage',$previousPage);
		$this->assign('countPage',$countPage);	
		$this->assign('currentPage',$page);	
		$this->assign('recordList',$recordList);	
		$this->display('keywordList');
	}
	
	public function showConsult($page=1, $limit=100){
		$this->isAuthorize();
		$keywordObj=D('Keyword');
		$recordList=$keywordObj->getKeywordLimit($page,$limit);
		$count=$keywordObj->getRecordAmount($page,$limit);
		$pageObj= new \Admin\Model\PageModel($count,$page);
		$countPage=$pageObj->getCountPage($limit);
		$this->assign('countPage',$countPage);
		$this->display('consult');
	}
	
	public function showLink($page=1, $limit=100){
		 $this->isAuthorize();
		$linkObj=D('Link');
		
		$recordList=$linkObj->getLinkList($page,$limit);
		$count=$linkObj->getRecordAmount($page,$limit);
		$pageObj= new \Admin\Model\PageModel($count,$page);
		$countPage=$pageObj->getCountPage($limit);
		$nextPage=$pageObj->getNextPage();
		$previousPage=$pageObj->getPreviousPage();
		$this->assign('nextPage',$nextPage);
		$this->assign('previousPage',$previousPage);
		$this->assign('countPage',$countPage);	
		$this->assign('currentPage',$page);	
		$this->assign('recordList',$recordList);	
		$this->display('urlList');
	}
	
	public function clearMatch(){
		$this->isAuthorize();
		$matchObj=D('Match');
		$status=$matchObj->cleatAll();
		if($status===false){
			echo "清除失败";
		}
		echo "清除匹配数据成功";
	}
	
	

	
}
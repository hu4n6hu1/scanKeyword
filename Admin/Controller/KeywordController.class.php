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
	
	public  function index($page=1){	
	    $this->isAuthorize();
		$keywordObj=D('Keyword');
		$linkObj=D('Link');
		$matchObj=D('Match');
		$limit=10;
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
	
	public function showKeyword($page=1){
		 $this->isAuthorize();
		$keywordObj=D('Keyword');
		$limit=10;
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
	
	public function showConsult(){
		 $this->isAuthorize();
		$this->display('consult');
	}
	
	public function showLink($page=1){
		 $this->isAuthorize();
		$linkObj=D('Link');
		$limit=10;
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
	
	/**
	 *多线程获取指定url的html内容，然后匹配到数据库内的连接，并且存储数据到数据库
	 *@param $list url列表
	 */
	
    protected function getHtmlContent($list){
		
		$cm=QueryList::run('Multi',[
    //待采集链接集合
    'list' => $list,
    'curl' => [
        'opt' => array(
                    //这里根据自身需求设置curl参数
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_AUTOREFERER => true,
                   
                ),
        //设置线程数
        'maxThread' => 100,
        //设置最大尝试数
        'maxTry' => 3 
    ],
	    //不自动开始线程，默认自动开始
    'start' => false,
    'success' => function($a){
        //采集规则
		$rules=array(
		'host'=>array('div.f13','html')
		);
        
		//匹配到百度的div class=f13 的节点，然后遍历返回一个页面的url链接。
        $ql = QueryList::Query($a['content'],$rules);
        $divList = $ql->getData();
		$hostList=array();
		foreach($divList as $f13){
			$hostList[]=\Admin\Model\BaiDuSearchModel::matchMyHost($f13['host']);
		}
		
		//$count变量保存一个页面的连接总数。循环查询数据库，看看里面有没有匹配这个url域名的地址。
		//如果数据库有该域名数据。就把百度搜索得到加密的url。进行解密，看看匹配数据库里面哪个url。
	   $count=count($hostList);
	   $linkObj=D('Link');
	   $encrypHostList=array();
	   $linkList=array();
	   $urlInfo=parse_url($a['info']['url']);
	   $query=$urlInfo['query'];
	   $paramList=\Admin\Model\BaiDuSearchModel::getParams($query);//把关键字id和排名传递给子函数。
	   $keywordId=$paramList['keyword_id'];
	   for($i=0;$i<$count;$i++){
			$linkList=$linkObj->getLinkLimit($hostList[$i]['origin']);
			if(!empty($linkList)){
				$url=$hostList[$i]['encryp'];
				$url=\Admin\Model\BaiDuSearchModel::addParam($url,'keyword_id',$keywordId);
				$url=\Admin\Model\BaiDuSearchModel::addParam($url,'rank',$i+1);
				$encrypHostList[$i]=$url;	
			}
			
	   }

	  $this->getDecriptLink($encrypHostList);
	   
	   
   
    }
 ]);

$cm->start();
    }
	
	/**
	 *解密百度link?url 的地址,最后调用回调函数 存储数据到数据库
	 *@param $encrypHostList 要解密的 url地址
	 */
	 
	protected function getDecriptLink($encrypHostList){
		QueryList::run('Multi',[
    'list' => $encrypHostList,
    'curl' => [
        'opt' => array(
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_AUTOREFERER => true,
                ),
        'maxThread' => 100,
        'maxTry' => 3 
    ],
    'start' => false,
    'success' => function($result,$info){
		$urlInfo=parse_url($result['info']['url']);
	    $query=$urlInfo['query'];
		$paramList=\Admin\Model\BaiDuSearchModel::getParams($query);
		$this->saveMatchData($result['content'],$paramList['keyword_id'],$paramList['rank']);
    }
]);
		
	}
	/**
	 *开始多线程爬行
	 */
	 
	 /**
	  *快速全表扫描
	 */
	public function quickScan(){
		 $this->isAuthorize();
		ignore_user_abort(true);
		set_time_limit(0);
		$keywordObj=D('Keyword');
		$matchObj=D('Match');
		$status=$matchObj->cleatALL();
		if($status===false){
			echo "程序错误";
			exit();
		}
		$keywordList=$keywordObj->getKeywordLimit();
		$list=array();
		foreach($keywordList as $keyword){
			$list[]='http://www.baidu.com/s?wd='.urlencode($keyword['keyword']).'&keyword_id='.$keyword['id'];
		}
		//$this->getHtmlContent($list);
	}
	
	/**
	 *获取html内容，获取解密后的url，地址。然后对比链接数据库。如果是我们要捕获的url，就记录到match表里
	 *@param 重定向的html内容
	 *@param 关键字数据库里面关键字对应的id
	 *@param 链接排名
	 */
	
	protected  function saveMatchData($htmlContent,$keywordId,$rank){
   
		$link=\Admin\Model\BaiDuSearchModel::matchRedirectUrl($htmlContent);
		$linkObj= D('Link');
		$result=$linkObj->getLinkByLink($link);
		if($result){
			$data['date']=time();
			$data['keyword_id']=$keywordId;
			$data['link_id']=$result['id'];
			$data['rank']=$rank;	
			$matchObj=D('Match');
			$matchObj->addMatchRecord($data);
			echo "找到匹配数据<br>";
			
		}
	}
	/**
	 *分页查询一次查询30个关键字。
	*/
	public function pageScan($limit=30){
		 $this->isAuthorize();
		
		ignore_user_abort(true);
		set_time_limit(0);
		$keywordObj=D('Keyword');
		$keywordObj=D('Keyword');
		$matchObj=D('Match');
		$status=$matchObj->cleatALL();
		if($status===false){
			echo "程序错误";
			exit();
		}
		$count=$keywordObj->getRecordAmount();
		
		$page=$count%$limit?intval(($count/$limit))+1:intval($count/$limit);
        for($i=1;$i<=$page;$i++){
		$keywordList=$keywordObj->getKeywordLimit($i,$limit);
		$list=array();
		foreach($keywordList as $keyword){
			$list[]='http://www.baidu.com/s?wd='.urlencode($keyword['keyword']).'&keyword_id='.$keyword['id'];
		}
		$this->getHtmlContent($list);
		echo "第 $i 页扫描完成<br>";
		
		}

	}
	

	

	
}
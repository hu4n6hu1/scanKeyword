<?php
    namespace Admin\Controller;
	
	use Think\Controller;
	use QL\QueryList;
	
	class AjaxScanController extends Controller
	{
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


  
	


	public function start($page=1, $limit=10){
		// $this->isAuthorize();
		
		set_time_limit(0);
		$keywordObj=D('Keyword');
		if($status===false){
			echo "程序错误";
			exit();
		}
		$keywordList=$keywordObj->getKeywordLimit($page,$limit);
		$list=array();
		foreach($keywordList as $keyword){
			$list[]='http://www.baidu.com/s?wd='.urlencode($keyword['keyword']).'&keyword_id='.$keyword['id'];
		}
		
		$this->step2($list);
		
		
		

	}
	
	
	  protected function step2($list){
		
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
        'maxThread' => 10,
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
		$linkObj=D('Link');
		$urlInfo=parse_url($a['info']['url']);
	    $query=$urlInfo['query'];
	    $paramList=\Admin\Model\BaiDuSearchModel::getParams($query);//把关键字id和排名传递给子函数。
	    $keywordId=$paramList['keyword_id'];
		foreach($divList as $f13){
			$tmp=\Admin\Model\BaiDuSearchModel::matchMyHost($f13['host']);
			if($tmp!==false){
			 $hostList[]=$tmp;
			}
			
		}
		
		$rank=0;
		foreach($hostList as $host ){
			$rank++;
			$linkList=$linkObj->getLinkLimit($host['origin']);
			
			if(!empty($linkList)){
				
				$htmlContent=\Admin\Model\StreamToolModel::sendDataByGet($host['encryp']);
			  $this->saveMatchData($htmlContent, $keywordId, $rank);
				
			} 
		}
     }
   ]);
   $cm->start();
 }
	
	
	/**
	 *获取html内容，获取解密后的url，地址。然后对比链接数据库。如果是我们要捕获的url，就记录到match表里
	 *@param 重定向的html内容
	 *@param 关键字数据库里面关键字对应的id
	 *@param 链接排名
	 */
	
	protected  function saveMatchData($htmlContent,$keywordId,$rank){
		$link=\Admin\Model\BaiDuSearchModel::matchRedirectUrl($htmlContent);
		var_dump($link);
		$linkObj= D('Link');
		$link=strtolower(trim($link));
		$result=$linkObj->getLinkByLink($link);
		if($result){
			$data['date']=time();
			$data['keyword_id']=$keywordId;
			$data['link_id']=$result['id'];
			$data['rank']=$rank;	
			$matchObj=D('Match');
			$matchObj->addRecord($data);
			echo "catch data<br>";
			
		}
	}
	
	
	
	
	
	 

	
}
	
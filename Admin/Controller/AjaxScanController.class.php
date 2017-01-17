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
			echo "�������";
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
    //���ɼ����Ӽ���
    'list' => $list,
    'curl' => [
        'opt' => array(
                    //�������������������curl����
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_AUTOREFERER => true,
                   
                ),
        //�����߳���
        'maxThread' => 10,
        //�����������
        'maxTry' => 3
    ],
	    //���Զ���ʼ�̣߳�Ĭ���Զ���ʼ
    'start' => false,
    'success' => function($a){
        //�ɼ�����
		$rules=array(
		'host'=>array('div.f13','html')
		);
        
		//ƥ�䵽�ٶȵ�div class=f13 �Ľڵ㣬Ȼ���������һ��ҳ���url���ӡ�
        $ql = QueryList::Query($a['content'],$rules);
        $divList = $ql->getData();
		$hostList=array();
		$linkObj=D('Link');
		$urlInfo=parse_url($a['info']['url']);
	    $query=$urlInfo['query'];
	    $paramList=\Admin\Model\BaiDuSearchModel::getParams($query);//�ѹؼ���id���������ݸ��Ӻ�����
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
	 *��ȡhtml���ݣ���ȡ���ܺ��url����ַ��Ȼ��Ա��������ݿ⡣���������Ҫ�����url���ͼ�¼��match����
	 *@param �ض����html����
	 *@param �ؼ������ݿ�����ؼ��ֶ�Ӧ��id
	 *@param ��������
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
	
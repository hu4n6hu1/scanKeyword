<?php
    namespace Admin\Controller;
	
	use Think\Controller;
	use QL\QueryList;
	
	class AjaxScanController extends Controller
	{
	

	/**
	 *���̻߳�ȡָ��url��html���ݣ�Ȼ��ƥ�䵽���ݿ��ڵ����ӣ����Ҵ洢���ݵ����ݿ�
	 *@param $list url�б�
	 */
	
    protected function getHtmlContent($list){
		
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
        'maxThread' => 100,
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
		foreach($divList as $f13){
			$tmp=\Admin\Model\BaiDuSearchModel::matchMyHost($f13['host']);
			if($tmp!==false){
			$hostList[]=$tmp;
			}
		}
		
		//$count��������һ��ҳ�������������ѭ����ѯ���ݿ⣬����������û��ƥ�����url�����ĵ�ַ��
		//������ݿ��и��������ݡ��ͰѰٶ������õ����ܵ�url�����н��ܣ�����ƥ�����ݿ������ĸ�url��
	   $count=count($hostList);
	   $linkObj=D('Link');
	   $encrypHostList=array();
	   $linkList=array();
	   $urlInfo=parse_url($a['info']['url']);
	   $query=$urlInfo['query'];
	   $paramList=\Admin\Model\BaiDuSearchModel::getParams($query);//�ѹؼ���id���������ݸ��Ӻ�����
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
	 *���ܰٶ�link?url �ĵ�ַ,�����ûص����� �洢���ݵ����ݿ�
	 *@param $encrypHostList Ҫ���ܵ� url��ַ
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
        'maxTry' => 5 
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
	 *��ȡhtml���ݣ���ȡ���ܺ��url����ַ��Ȼ��Ա��������ݿ⡣���������Ҫ�����url���ͼ�¼��match����
	 *@param �ض����html����
	 *@param �ؼ������ݿ�����ؼ��ֶ�Ӧ��id
	 *@param ��������
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
			$matchObj->addRecord($data);
			echo "�ҵ�ƥ������<br>";
			
		}
	}
	/**
	 *
	*/
	public function start($page=1, $limit=30){
		// $this->isAuthorize();
		
		ignore_user_abort(true);
		set_time_limit(0);
		$keywordObj=D('Keyword');
		if($status===false){
			echo "�������";
			exit();
		}

		
       
		$keywordList=$keywordObj->getKeywordLimit($i,$limit);
		$list=array();
		foreach($keywordList as $keyword){
			$list[]='http://www.baidu.com/s?wd='.urlencode($keyword['keyword']).'&keyword_id='.$keyword['id'];
		}
		var_dump($list);
		$this->getHtmlContent($list);
		
		
		

	}
	
	
	
	
	

	
	}
	
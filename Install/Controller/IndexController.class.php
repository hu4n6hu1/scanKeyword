<?php
namespace Install\Controller;
use Think\Controller;
use Install\Model\EnvironModel;
class IndexController extends Controller {
    public function index(){
	    $baseDir=dirname(__FILE__);
		$baseDir=str_replace('\\','/',$baseDir);
		$baseDir=substr($baseDir,-1)=='/'?$baseDir:$baseDir.'/';
		if(file_exists($baseDir.'../block.bl')){
			$this->display('error');
			return false;
		}
       $this->display('index');
    }
	public function step1(){
		$baseDir=dirname($_SERVER['SCRIPT_NAME']);
        $baseDir=str_replace('\\','/',$baseDir);
        $baseDir=substr($baseDir,-1)=='/'?$baseDir:$baseDir.'/';
		$this->assign('phpversion',EnvironModel::comparePHPVersion());
		$this->assign('pdo',EnvironModel::isSupportPdo());
		$this->assign('UploadInfo',EnvironModel::getUploadInfo());
		$this->assign('isSupportGd',EnvironModel::isSupportGd());
		$this->assign('isSupportCurl',EnvironModel::isSupportCurl());
		$this->assign('baseDir',$baseDir);
		$this->assign('isReadable',EnvironModel::isReadable($baseDir));
		$this->assign('isWritable',EnvironModel::isWritable($baseDir));
		$this->assign('permission',EnvironModel::getFilePermission($baseDir));
		$this->assign('isSupportFile_put_contents',EnvironModel::isSupportFile_put_contents());
		$this->display('step1');
	}
	
	public function step2(){
		$this->display('step2');
	}
	
	public function step3(){
		$baseDir=dirname(__FILE__);
		$baseDir=str_replace('\\','/',$baseDir);
		$baseDir=substr($baseDir,-1)=='/'?$baseDir:$baseDir.'/';
		if(file_exists($baseDir.'../block.bl')){
			$this->display('error');
			return false;
		}
		$result=$this->testConnectDb();
		if(!$result){
			echo "数据库配置错误,退出安装";
			exit();
		}
		$baseDir=dirname(__FILE__);
		$baseDir=str_replace('\\','/',$baseDir);
		$baseDir=substr($baseDir,-1)=='/'?$baseDir:$baseDir.'/';
		$contents=file_get_contents($baseDir.'../../Common/Conf/configTpl.php');
		if(contents===false){
			echo "读取配置模板文件错误，退出安装";
			exit();
		}
		$contents=str_replace('$dbHost',$_POST['dbhost'],$contents);
		$contents=str_replace('$dbName',$_POST['dbname'],$contents);
		$contents=str_replace('$dbUser',$_POST['dbuser'],$contents);
		$contents=str_replace('$dbPwd',$_POST['dbpw'],$contents);
		$contents=str_replace('$port',$_POST['dbport'],$contents);
		$contents=str_replace('$dbPrefix',$_POST['dbprefix'],$contents);
		$status=file_put_contents($baseDir.'../../Common/Conf/config.php',$contents);
		if($status===false){
			echo "写入配置文件错误，退出安装";
			exit();
		}
		$mysqlPath=$baseDir.'../1.sql';
		if(!file_exists($mysqlPath)){
			echo "mysql 文件不存在 ，退出安装";
			exit();
		}
		$obj= new \Install\Model\ExcuteSqlFileModel($mysqlPath);
		$content=$obj->readSqlFile();
		$sqlList=$obj->sql_split($obj->fileContent,$_POST['dbprefix']);
		$connection = array( 
		'db_type' => 'mysql',
		'db_host' => $_POST['dbhost'],
		'db_user' => $_POST['dbuser'],
		'db_pwd' => $_POST['dbpw'],
		'db_port' => $_POST['dbport'],
		'db_name' => $_POST['dbname'],
		'DB_PREFIX' => $_POST['dbprefix'],
		'db_charset' => 'utf8'
		);
		
		$testObj= new \Install\Model\TestModel($connection);
		$count=count($sqlList);
		for($i=0;$i<$count;$i++){
			$result=$testObj->executeSql($sqlList[$i]); 
			if($result===false){
				echo "初始化数据库错误，退出安装";
			    exit();
			}
		}
		$data=array();
		$data['password']=$_POST['manager_pwd'];
		$data['email']=$_POST['manager_email'];
		$data['password2']=$_POST['manager_ckpwd'];
		$adminObj= new \Admin\Model\AdminModel('Admin',$_POST['dbprefix'],$connection);
		$status=$adminObj->userRegister($data);
		if($status==false){
		 echo	$adminObj->lastErrorMessage;
		 exit();
		}
		$fp=fopen($baseDir.'../block.bl','w');
		if(!$fp){ 
		echo "写入block文件错误，请手动删除install目录";
		exit();
		}
		fclose($fp);
		$this->display('step3');
	
		
	}
	
	public function testConnectDb(){
		$connection = array( 
		'db_type' => 'mysql',
		'db_host' => $_POST['dbhost'],
		'db_user' => $_POST['dbuser'],
		'db_pwd' => $_POST['dbpw'],
		'db_port' => $_POST['dbport'],
		'db_name' => $_POST['dbname'],
		'DB_PREFIX' => $_POST['dbprefix'],
		'db_charset' => 'utf8'
		);
	    
	   try{
		   $testObj= new \Install\Model\TestModel($connection);
		   $testObj->testConnectDb();
		   return true;
	   }catch(\Exception $e){
		   return false;
	   }
		
	}

}
<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
	protected $userId, $userName;
	protected function isAuthorize(){
               $loginStatus=session('loginStatus');
               if(!$loginStatus){
                  $this->redirect('index','',2,'not authirize');
				  return false;
                  exit();
                }
               $this->userId=session('id');
               $this->userName=session('email');
               $this->assign('userName',$this->userName);
               $this->assign('userId',$this->userId);			
			
		}
	
    public function index(){
	    if(empty($_POST)){
			$this->display('login');
		 return true;	
		}
		$adminObj= D('Admin');
		$loginStatus=$adminObj->userLogin($_POST);
		if($loginStatus){
			session('email',$loginStatus['email']);
			session('id',$loginStatus['id']);
			session('loginStatus',true);
			$this->redirect('manager','',0,'登陆成功');
		}	else{
			$this->gotoNote("账号或者密码错误",'');
		} 
    }
	
	
	
	public function manager(){
		$this->isAuthorize();
		$this->display('manager');
	}
	
	public function signOut(){
		session(null);
		  $this->redirect('index','',2,'sign out ok');
	}
	
	 public function gotoNote($noteString,$url){
		 $this->assign('noteString',$noteString);
		 $this->assign('url',$url);
		 $this->display('Public/error');
	 }
	
}
<?php
	namespace	Admin\Model;
	use Think\Model;
	class AdminModel extends Model{

		protected $_validate=array(
	    //添加数据的时候启用这些规则
            array('email','require','邮箱不能为空',1,'',1),
			array('password','require','密码不能为空',1,'',1),	
			array('email','email','邮箱已经存在了',1,'unique',1),
            array('email','email','邮箱格式错误',1,'',1),
			array('password','6,20','密码长度错误',1,'length',1),
			array('password','password2','两次密码不一样',1,'confirm',1),

   
         //  修改密码时候启动的规则 规则5
			array('password','6,20','密码长度错误',2,'length',5),
			array('password','password2','两次密码不一样',2,'confirm',5),                  
                    
	        
		);
		
		protected $_auto=array(
			//添加数据时候都会触发的规则
			array('password','md5',1,'function'),//对密码进行md5加密
            //对密码修改时候启动的规则
			array('password','md5',5,'function'),//对密码进行md5加密
		
		);
            
			
             /**
			  *userRegister 用户注册函数
			  × $postData 包含post数据用于用户注册
			  × return 添加失败返回false 正确返回userId；
			 **/
			public  function userRegister($postData){
                 $data=$this->create($postData,1);
                 if($data){
                   $userId=$this->add();
				   if($userId===false){
				   $this->lastErrorMessage='添加用户失败，请联系管理员';
                   return FALSE;
                   }
                  return $userId;
                 }else{
				    $this->lastErrorMessage=$this->getError();
					return false;
                 }
                            
            }
                
       
                /**
				 * userLogin 拥有用户登录
				 × @postData 用户登录的email
				 × return 无效账号或者错误 返回 false 正确返回用户数据
				**/
                public function userLogin($postData){
                      $userInfo=$this->field('id,email,password')->where("email='%s'",$postData['email'])->find();
                    if($userInfo==''){
                        return false;
                    }
                    $password=md5($postData['password']);
                    if($userInfo['password'] != $password){
                        return false;
                    }
                    return $userInfo;
                    
                }

				
			/**
			 *函数用于修改密码
			 ×$userId 用于定位用户数据
			 ×$postData 该参数是一个数组，包含password和password2 调用系统函数自动验证。
			 ×return 正确返回受影响函数，错误返回false。 如果密码一样返回时0.
			**/
			public function  userModifyPassword($userId,$postData){
				$data=$this->create($postData,5);
				if($data){
				$affectRow=$this->field('password')->where("id='%d'",$userId)->save($data);
				return $affectRow;
				}else{
					$this->lastErrorMessage=$this->getError();
				return false;
					}
				}
      
		
	}
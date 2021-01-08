<?php
namespace api\controllers;

use api\controllers\Base;
use Yii;
use api\models\UserModel;
use api\models\ValidatorModel;
use api\models\SendModel;
use yii\base\BaseObject;

class LoginController extends Base
{
    public $openLoginCheck = false;
    
    public function init()
    {
        parent::init();
        
    }
    /**
     *
     * 用户登录接口(手机号)
     *
     * @author stenfan
     */
    public function actionLogin()
    {
        $this->openLoginCheck = false;
        $data = Yii::$app->request->post();
        $validator = new ValidatorModel();
        $mobile = $data['account'];
        $deviceid = $data['deviceid'];
        if(!$validator->isMobile($mobile)){
            return $this->error($validator->msg);
        }
        $password = $data['password'];
        if(!$validator->checkPassword($password)){
            return $this->error($validator->msg);
        }
        $userModel = new UserModel();
        $userInfo = $userModel->login($mobile,$password);
        if(!$userInfo){
            return $this->error($userModel->msg);
        }
        return $this->success($userInfo,'登录成功');
        
    }
    
    public function actionSms()
    {
        $this->openLoginCheck = false;
        $data = Yii::$app->request->post();
        $mobile = $data['account'];
        $deviceid = $data['deviceid'];
        $smscode = $data['verify'];
        $validator = new ValidatorModel();
        if(!$validator->isMobile($mobile)){
            return $this->error($validator->msg);
        }
        
        $userModel = new UserModel();
        if(!$userModel->checkUserExists($mobile)){
            return $this->error('此账号还没有注册');
        }
        
        if(!$validator->isSmscode($smscode)){
            return $this->error($validator->msg);
        }
        $deviceid = $data['deviceid'];
        $key = md5($mobile . $deviceid);
        if(!$validator->checkSmscode($key,$smscode)){
            return $this->error($validator->msg);
        }
        $sendModel = new SendModel();
        $sendModel->destroySmscode($key);
        $userInfo = $userModel->login($mobile);
        if(!$userInfo){
            return $this->error($userModel->msg);
        }
        return $this->success($userInfo,'登录成功');
    }
    
    
    /**
     * 注册接口
     */
    public function actionRegister()
    {
        $this->openLoginCheck = false;
        $data = Yii::$app->request->post();
        $mobile = $data['mobile'];
        $deviceid = $data['deviceid'];
        $validator = new ValidatorModel();
        if(!$validator->isMobile($mobile)){
            return $this->error($validator->msg);
        }
        $password = $data['password'];
        if(!$validator->checkPassword($password,$data['repassword'])){
            return $this->error($validator->msg);
        }
        $smscode = $data['verify'];
        if(!$validator->isSmscode($smscode)){
            return $this->error($validator->msg);
        }
        $deviceid = $data['deviceid'];
        $key = md5($mobile . $deviceid);
        if(!$validator->checkSmscode($key,$smscode)){
            return $this->error($validator->msg);
        }
        $userModel = new UserModel();
        if($userModel->checkUserExists($mobile)){
            return $this->error('手机号已经被注册了');
        }
        $sendModel = new SendModel();
        $sendModel->destroySmscode($key);
        //开始注册
        $data['ip'] = ip2long($this->clientIP());
        
        if($userModel->register($data)){
            return $this->success([],'注册成功');
        }else{
            return $this->error('注册失败');
        }
    }
}
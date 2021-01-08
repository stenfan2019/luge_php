<?php
namespace api\controllers;
use api\controllers\Base;
use Yii;
use common\models\User;


class LoginController extends Base
{
    public $openLoginCheck = false;

    public function init()
    {
        parent::init();
    }
    
    /**
     * 登录接口
     * @author stenfan
     */
    public function actionLogin()
    {
        if('POST' != Yii::$app->request->method){
            $this->error('请求方式错误');
        }
        $data = Yii::$app->request->post();
        $mobile = isset($data['mobile']) ? $data['mobile'] : '';
        $deviceid = isset($data['deviceid']) ? $data['deviceid'] : '';
        $password = isset($data['password']) ? $data['password'] : '';
        if(empty($mobile) || empty($deviceid) || empty($password)){
            $this->error('缺少必要参数');
        }
        $user_model = User::find()->where(['mobile' => $mobile])->one();
        if(empty($user_model)){
            $this->error('账号密码错误');
        }
        $user_info = $user_model->toArray();
        
        
        if(!$this->validatePassword($password,$user_info['password'])){
            $this->error('账号密码错误');
        }
        if($user_info['is_freeze'] == 1){
            $this->error('账号被冻结,无法登陆');
        }
       
        $data = $this->login($user_model, $user_info);
       
        return $this->success($data);
    }
    
    /**
     * 退出登录
     * @author stenfan
     */
    public function actionLoginout()
    {
        
    }
    
   
}
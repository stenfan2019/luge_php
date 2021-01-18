<?php
namespace frontend\controllers;
use common\models\User;
use yii;
use frontend\controllers\Base;

class UsersController extends Base
{
    public $layout = false;
    public $now_nav = 'home';
    public $seo_title = "在線成人視頻";
    
    
    
    public function actionReg()
    {
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            if(!Yii::$app->getRequest()->validateCsrfToken()){
               $this->fail('請刷新頁面重新註冊');
            }
            $email = isset($data['user_name']) ? trim($data['user_name']) : '';
            $nick_name = isset($data['nick_name']) ? trim($data['nick_name']) : '';
            $user_pwd = isset($data['user_pwd']) ? trim($data['user_pwd']) : '';
            $user_pwd2 = isset($data['user_pwd2']) ? trim($data['user_pwd2']) : '';
            $preg_email='/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5})$/ims';
            if(empty($email) || empty($nick_name) 
                || empty($user_pwd) || empty($user_pwd2)){
                $this->fail('參數不能為空');
            }
            if(!preg_match($preg_email,$email)){
                $this->fail('郵箱錯誤');
            }
            if($user_pwd != $user_pwd2){
                $this->fail('兩次密碼不一致');
            }
            $user_model = User::find()->where(['email' => $email])->one();
            if($user_model){
                $this->fail('郵箱已經被註冊了');
            }
            
            $time = time();
            $date = date('Y-m-d H:i:s',$time);
            $salt = mt_rand(100000, 99999999);
            $user = new User();
            $password = Yii::$app->security->generatePasswordHash($user_pwd);
            $user->email = $email;
            $user->password = $password;
            $user->salt     = $salt;
            $user->nick_name = $nick_name;
            $user->reg_time = $date;
            $user->reg_ip = $this->clientIP();
            $user->last_login_time = $date;
            $user->last_login_ip = $this->clientIP();
            $user->update_time = $date;
            $user->image = $this->getAvatar();
            $user->source = 'H5';
            $user->amount = 0;
            $user->status = 1;
            if($user->save()){
                $uid = $user->uid;
                if($uid){
                    $one = User::findOne($uid);
                    $expires = time() + 8640000;
                    $str = "$uid|$expires";
                    $token_str = $this->encrypt($str);
                    $one->token = $token_str;
                    $one->expires = $expires;
                    $one->update();
                    
                    $cookies = Yii::$app->response->cookies;
                    
                    $cookies->add(new \yii\web\Cookie([
                        'name'   => 'nick_name',
                        'value'  => $nick_name,
                        'expire' =>$expires
                    ]));
                    
                    $cookies->add(new \yii\web\Cookie([
                        'name'   => 'token',
                        'value'  =>  $token_str,
                        'expire' =>$expires
                    ]));
                }
                
                $this->success([],'註冊成功');
            }
           
        }
        
        return $this->render('reg');
    }
    
    public function actionLogin()
    {
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            if(!Yii::$app->getRequest()->validateCsrfToken()){
                $this->fail('請刷新頁面重新註冊');
            }
            $email = isset($data['user_name']) ? trim($data['user_name']) : '';
            $user_pwd = isset($data['user_pwd']) ? trim($data['user_pwd']) : '';
            if(empty($email)  || empty($user_pwd) ){
                $this->fail('賬號和密碼不能為空');
            }
            
            $user_model = User::find()->where(['email' => $email])->one();
            if(empty($user_model)){
                $this->fail('賬號密碼錯誤');
            }
            $time = time();
            $date = date('Y-m-d H:i:s',$time);
            $user_model->last_login_time = $date;
            $user_model->last_login_ip = $this->clientIP();
            $user_model->update_time = $date;
            $uid = $user_model->uid;
            $expires = time() + 8640000;
            $str = "$uid|$expires";
            $token_str = $this->encrypt($str);
            $user_model->token = $token_str;
            $user_model->expires = $expires;
            $user_model->update();
            
            $cookies = Yii::$app->response->cookies;
            
            $cookies->add(new \yii\web\Cookie([
                'name'   => 'nick_name',
                'value'  => $user_model->nick_name,
                'expire' =>$expires
            ]));
            
            $cookies->add(new \yii\web\Cookie([
                'name'   => 'token',
                'value'  =>  $token_str,
                'expire' =>$expires
            ]));
            
            $this->success([],'登錄成功');
        }
        return $this->render('login');
    }
    
    public function actionLogout()
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('token');
        $cookies->remove('nick_name');
        return $this->render('login');
    }
}

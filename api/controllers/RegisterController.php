<?php
namespace api\controllers;
use api\controllers\Base;
use api\models\NickModel;
use Yii;
use common\models\User;
use yii\base\BaseObject;


class RegisterController extends Base
{
    
    public function actionIndex()
    {
        if('POST' != Yii::$app->request->method){
            $this->error('请求方式错误');
        }
        $data = Yii::$app->request->post();
        $mobile = isset($data['mobile']) ? $data['mobile'] : '';
        $deviceid = isset($data['deviceid']) ? $data['deviceid'] : '';
        $password = isset($data['password']) ? $data['password'] : '';
        $code = isset($data['code']) ? $data['code'] : '';
        $re_passwd = isset($data['re_passwd']) ? $data['re_passwd'] : '';
        $channel   = isset($data['channel']) ? $data['channel'] : 'H5';
        if(empty($mobile) || empty($password) || empty($code) || empty($re_passwd)){
            $this->error('缺少必要参数');
        }
        if(strlen($password) < 6){
            $this->error('密码长度必须大于6');
        }
        if($password != $re_passwd){
            $this->error('两次密码不一致');
        }
        $user_model = User::find()->where(['mobile' => $mobile])->one();
        if($user_model){
            $this->error('手机号已经别注册');
        }
        $key = $this->getRedisKey('sms', $mobile);
        if($code != $this->getRedisValue($key)){
            $this->error('手机验证码错误');
        }
        $channel = array_key_exists($channel, User::$field_title['source']) ? $channel : 'H5';
        $NickModel = new NickModel();
        $time = time();
        $date = date('Y-m-d H:i:s',$time);
        $salt = mt_rand(100000, 99999999);
        $user = new User();
        
        $password = Yii::$app->security->generatePasswordHash($password);
        $user->mobile = $mobile;
        $user->password = $password;
        $user->salt     = $salt;
        $user->nick_name = $NickModel->getNick();
        $user->reg_time = $time;
        $user->reg_ip = $this->clientIP();
        $user->last_login_time = time();
        $user->last_login_ip = $this->clientIP();
        $user->update_time = $time;
        $user->image = $this->getAvatar();
        $user->source = $channel;
        $user->amount = 0;
        $user->give_game = 0;
        $user->status = 1;
        if($user->save()){
            $this->success([]);
        }
      
        $this->error('注册失败');
    }
}
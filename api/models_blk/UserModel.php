<?php
namespace api\models;

use common\models\User;
use Yii;

class UserModel extends User
{
    public $msg = '';
    public function register($data)
    {
        $rcode = array_key_exists('rcode', $data) ? intval($data['rcode']) : 0;
        $time = time();
        $date = date('Y-m-d H:i:s',$time);
        $nickanme = array_key_exists('username', $data) 
                    ? $data['username'] : $data['mobile'];
        $this->username = $nickanme;
        $this->mobile = $data['mobile'];
        $this->generateAuthKey();
        $this->setPassword($data['password']);
        $this->reg_time = $time;
        $this->reg_ip = $data['ip'];
        $this->last_login_time = time();
        $this->last_login_ip = $data['ip'];
        $this->update_time = $time;
        $tuid = $rcode;
        $this->tuid = $tuid;
        $this->image = $this->getAvatar();
        $this->allowance = 0;
        $this->allowance_updated_at = $time;
        $this->status = 1;
        return $this->save();
    }
    
    
    
    public function login($account,$password=false)
    {
        $userInfo = User::find()->where(['mobile' => $account])->asArray()->one();
        if(!$userInfo){
            $this->msg = '账号不存在';
            return false;
        }
        if($password){
            $this->password = $userInfo['password'];
            if(!$this->validatePassword($password)){
               $this->msg = '账号密码错误';
               return false;
            }
        }
        if($userInfo['is_freeze'] == 1){
            $this->msg = '账号被冻结,无法登陆';
            return false;
        }
        //限制机器人登陆
        if($userInfo['type'] == 2){
            $this->msg = '此账号禁止登陆';
            return false;
        }
        
        $redisModel = \vlogapi\models\RedisModel::getSession();
        unset($userInfo['salt']);
        unset($userInfo['password'],$userInfo['allowance'],$userInfo['allowance_updated_at']);
        unset($userInfo['reg_time'],$userInfo['update_time']);
        unset($userInfo['reg_ip'],$userInfo['last_login_time'],$userInfo['last_login_ip']);
        $token = $this->getToken();
        $key = md5($token);
        $oss_url = Yii::$app->params['oss_url'];
        $userInfo['image'] = $oss_url . $userInfo['image'];
        $redisModel->set($key,json_encode($userInfo));
        $redisModel->expire($key, 86400 * 30);
        $userInfo['token'] = $token;
        return $userInfo;
            
    }
    
    public function checkUserExists($account)
    {
        $userInfo = User::find()->where(['username' => $account])->asArray()->one();
        return $userInfo ? true : false;
    }
    
    /**
     *
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
    
   
    
    /**
     *
     * 创建token
     */
    protected function getToken(){
        return $authorization = \Yii::$app->security->generateRandomString(128);
    }
    
    
}
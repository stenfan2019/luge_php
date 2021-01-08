<?php
namespace api\models;
use Yii;
/**
 * 验证器
 * @author stenfan
 *
 */
class ValidatorModel
{
    public $msg = '';
   
    public function isMobile($mobile)
    {
        if(!preg_match('/^1([0-9]{9})/',$mobile)){
            $this->msg = '手机号错误';
            return false;
        }
        return true;
    }
    
    /**
     * 
     * @param string $pass
     * @param string $repass
     */
    public function checkPassword($pass,$repass=null){
        
        if (!preg_match('/^[0-9a-z_$]{6,16}$/i', $pass)) {
            $this->msg = '密码必须6位字符以上';
            return false;
        } 
        if($repass && ($pass != $repass)){
            $this->msg = '两次密码不一致';
            return false;
        }
        return true;
    }
    
    public function isSmscode($code){
        if(!preg_match('/^\d{6}/',$code)){
            $this->msg = '手机验证码格式错误';
            return false;
        }
        return true;
    }
    
    public function checkSmscode($key,$code)
    {
        $redisModel = \api\models\RedisModel::getSession();
        if($code != $redisModel->get($key)){
            $this->msg = '手机验证码错误';
            return false;
        }
        return true;
    }
}
<?php
namespace api\models;
use Yii;
use \Yunpian\Sdk\YunpianClient;
class SendModel 
{
    public function getSmsCode($len=6)
    {
        $chars = str_repeat('0123456789', 3);
        // 位数过长重复字符串一定次数
        $chars = str_repeat($chars, $len);
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
        return $str;
    }
    
    /**
     * 销毁验证码
     * @param string $key
     */
    public function destroySmscode($key) {
        $redisModel = \api\models\RedisModel::getSession();
        $redisModel->del($key);
    }
    
    /**
     * 发送手机验证码
     * @param $mobile 手机号
     */
    public function sendMobileCode($mobile,$code)
    {
      
        $url = "https://us.yunpian.com/v2/sms/single_send.json";
        $text = "【夜TV】您的验证码是{$code}";
        $apikey = 'eb4b4fddabd18ddb369d530abe526e8c';
        $clnt = YunpianClient::create($apikey);
        $param = [YunpianClient::MOBILE => $mobile,YunpianClient::TEXT => $text];
        $r = $clnt->sms()->single_send($param);
        if($r->isSucc()){
            return true;
        }
        return false;
    }
}
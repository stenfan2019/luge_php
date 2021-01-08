<?php
namespace api\controllers;

use api\controllers\Base;
use Yii;


class SmsController extends Base
{
    /**
     * 登录接口
     * @author stenfan
     */
    public function actionSend()
    {
        if('POST' != Yii::$app->request->method){
            $this->error('请求方式错误');
        }
        $data = Yii::$app->request->post();
        $mobile = isset($data['mobile']) ? $data['mobile'] : '';
        $deviceid = isset($data['deviceid']) ? $data['deviceid'] : '';
        if(empty($mobile) || empty($deviceid)){
            $this->error('缺少必要参数');
        }
        if(!preg_match('/^1([0-9]{9})/',$mobile)){
            $this->error('手机号错误');
        }
        $code = $this->getSmsCode(4);
        $key  = $this->getRedisKey('sms', $mobile);
        if($this->sendMobileCode($mobile, $code)){
            $this->setRedisValue($key, $code);
            $this->success([]);
        }
        $this->error('发送失败');
    }
    
    public function getSmsCode($len=6)
    {
        $chars = str_repeat('0123456789', 3);
        // 位数过长重复字符串一定次数
        $chars = str_repeat($chars, $len);
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
        return $str;
    }
    
    
}
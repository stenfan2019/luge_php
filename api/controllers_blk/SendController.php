<?php
namespace api\controllers;

use api\controllers\Base;
use Yii;
use api\models\SendModel;
use api\models\ValidatorModel;

class SendController extends Base
{
    public $openLoginCheck = false;

    public function init()
    {
        parent::init();

    }
    
    public function actionSms()
    {
        $this->openLoginCheck = false;
        $data = Yii::$app->request->post();
        $mobile = $data['mobile'];
        $deviceid = $data['deviceid'];
        if(empty($mobile) || empty($deviceid)){
            return $this->error('缺少必要参数');
        }
        $validator = new ValidatorModel();
        if(!$validator->isMobile($mobile)){
            return $this->error($validator->msg);
        }
        $sendModel = new SendModel();
        $redisModel = \api\models\RedisModel::getSession();
        $key = md5($mobile . $deviceid);
        $code = $redisModel->get($key);
        if(empty($code)){
            $code = $sendModel->getSmsCode();
            $redisModel->set($key,$code);
            $redisModel->expire($key, 300);
        }
        $res = $sendModel->sendMobileCode($mobile, $code);
        if($res){
           // $data['code'] = $code;
            return $this->success($data);
        }else{
            return $this->error('验证码发送失败');
        }
    }
}
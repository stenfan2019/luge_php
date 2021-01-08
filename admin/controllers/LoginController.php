<?php
namespace admin\controllers;

use admin\controllers\Base;
use admin\models\LoginForm;
use common\helpers\Captcha;

use common\models\Admin;
use Yii;


class LoginController extends Base
{
    public $openLoginCheck = false;
    
    public $layout = false;
    
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

        if(Yii::$app->request->get('data') == 1)
        {
            $vcode = strtoupper(Yii::$app->request->post('vcode'));
            $captchaKey = Yii::$app->request->post('captchaKey');
            $captcha = new Captcha();
            if(!$captcha->validateVerify($captchaKey,$vcode))
            {
                return $this->fail('验证码错误');
            }

            $model = new LoginForm();
            $data['info']['username'] = Yii::$app->request->post('username');
            $data['info']['password'] = Yii::$app->request->post('password');
            if ($model->load($data,'info') && $model->login()) {
                $model = Admin::findOne(\admin\models\Admin::getUid());
                $model->last_login_ip   = Yii::$app->request->getUserIP();
                $model->last_login      = date('Y-m-d H:i:s');
                $model->login_count +=1;
                $model->save();
                return $this->success();
            } else {
                return $this->fail('账号或密码错误');
            }

        }
        $captchaKey = Yii::$app->security->generateRandomString();
        return $this->render('login',[
            'captchaKey' => $captchaKey,
        ]);
        
    }

    /**
     * 退出登陆
     * @return \yii\web\Response
     * @author mike
     * @date 2020-12-18
     */
    public function actionLogout()
    {
        return $this->redirect('login');
    }

   
   

    /**
     * 获取验证码
     * @throws \yii\base\InvalidConfigException
     * @author mike
     * @date 2020-12-29
     */
    public function actionCaptcha()
    {
        $captchaKey = Yii::$app->request->get('captchaKey');
        $captcha = new Captcha();
        $captchaImg = $captcha->genVerify($captchaKey);
        header("content-type:image/jpeg");
        echo $captchaImg;
    }
    
    


}
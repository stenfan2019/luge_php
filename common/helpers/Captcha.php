<?php

namespace common\helpers;

use api\models\redis\RedisModel;
use common\core\redis\AdminRedis;
use admin\models\Vcode;
use Yii;

/**
 * @name 验证码函数
 * Class Html
 * @package common\helpers
 * @author Mike
 * @date 2020-08-13
 */
class Captcha extends \yii\captcha\CaptchaAction
{

    protected $model;

    static $pre_key= "captcha:";
    /**
     * Html constructor.
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct()
    {
        $this->init();
        $this->minLength = 4;
        $this->maxLength = 5;
        $this->foreColor = 0x00ff00;
        $this->width = 80;
        $this->height = 45;

    }

    /**
     * @name 生成验证码图片并保存到redis
     * @param string $username
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @author mike
     * @date 2020-08-13
     */
    public function genVerify(string $username)
    {
        $vcode = new Vcode();
        $image = $vcode->showImage();
        $verify = strtoupper($vcode->code);
        $key = self::$pre_key.$username;
        AdminRedis::set($key,$verify,300);
        return $image;
    }


    /**
     * @name 验证码验证
     * @param string $username
     * @param string $verify
     * @return bool
     * @author mike
     * @date 2020-08-13
     */
    public function validateVerify($username, $verify)
    {
        $key = self::$pre_key.$username;
        $redisVerify = AdminRedis::get($key);
        if($redisVerify != $verify)
            return false; // 验证失败
        return true; // 验证成功

    }



    public function generateVerifyCode()
    {
        if ($this->minLength > $this->maxLength) {
            $this->maxLength = $this->minLength;
        }
        if ($this->minLength < 3) {
            $this->minLength = 3;
        }
        if ($this->maxLength > 20) {
            $this->maxLength = 20;
        }
        $length = mt_rand($this->minLength, $this->maxLength);

        $letters = '0123456789';
        $vowels = 'ABCDEFGHGKLMNRSTUVWXY';
        $code = '';
        for ($i = 0; $i < $length; ++$i) {
            if ($i % 2 && mt_rand(0, 10) > 2 || !($i % 2) && mt_rand(0, 10) > 9) {
                $code .= $vowels[mt_rand(0, 20)];
            } else {
                $code .= $letters[mt_rand(0, 9)];
            }
        }

        return $code;
    }


}

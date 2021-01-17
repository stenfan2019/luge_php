<?php
namespace frontend\controllers;
use Yii;
class Base extends \yii\web\Controller
{
    public $enableCsrfValidation = true;
 
    public $uid;
    
    public $nick_name;
    
    public $token;
    
    public $user_info;
    
    public $user_model;
    
    private $key = 'LFJkfks$vGAcwBpl';

    public function init()
    {
        parent::init();
        $cookie = \Yii::$app->request->cookies;
        //$cookie->getValue(‘smister’);
        if($cookie->has('token')){
            $token = $cookie->getValue('token');
            $str   = $this->decrypt($token);
            $arr   = explode('|',$str);
            $this->uid = $arr[0];
            $this->token = $token;
            $this->nick_name = $cookie->getValue('nick_name');
        }
    }
    
    public  function decrypt($string) {
        $decrypted = openssl_decrypt(hex2bin($string), 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA);
        return $decrypted;
    }
    
    /**
     * @name 成功返回
     * @param string $message
     * @param array $data
     * @return array
     * @author stenfan
     * @date 2020-08-09
     */
    protected function success($data =[],$message = 'success')
    {
        $return_data['data'] = $data;
        $return_data['msg'] = $message;
        $return_data['code'] = 0;
        Yii::$app->response->statusCode = 200;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->data =  $return_data;
        Yii::$app->response->send();
        exit();
    }
    
    /**
     * @name 错误信息
     * @param string $message 错误信息
     * @param array $data 错误数据
     * @param int $code 状态码
     * @return json
     * @author stenfan
     * @date 2020-08-09
     */
    protected function fail($message = 'fail', $code='400', $data =[])
    {
        Yii::$app->response->statusCode = $code;
        $rs_data = array(
            'code' => $code,
            'msg'   => $message,
            'data'  => $data
        );
         
        Yii::$app->response->statusCode = 200;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->data   =  $rs_data;
        Yii::$app->response->send();
        exit();
    }
    
    public static function getAvatar($gender=1)
    {
        $avatar = 'B017.jpg';
        if($gender == 1){
            $n = mt_rand(1,43);
            $n = str_pad($n,3,"0",STR_PAD_LEFT);
            $avatar = "B$n.jpg";
        }else{
            $n = mt_rand(1,26);
            $n = str_pad($n,3,"0",STR_PAD_LEFT);
            $avatar = "G$n.jpg";
        }
        return "avatar/$avatar";
    }
    
    Public function clientIP()
    {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }
    
    public  function encrypt($string) {
        $data = openssl_encrypt($string, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA);
        $data = strtolower(bin2hex($data));
        return $data;
    }
}
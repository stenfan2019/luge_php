<?php
namespace api\controllers;
use \Yunpian\Sdk\YunpianClient;
use Yii;
use common\models\User;
class Base extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public $openLoginCheck = true;
 
    public $uid;
    
    public $user_info;
    
    public $user_model;
    
    private $key = 'LFJkfks$vGAcwBpl';


    public function init()
    {
        parent::init();
        if($this->openLoginCheck)
        {
            return $this->checkLogin();
        }
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
    protected function error($message = 'error', $code='-1', $data =[])
    {
        Yii::$app->response->statusCode = 200;
        $rs_data = array(
            'state' => $code,
            'msg'   => $message,
            'data'  => $data
        );
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Credentials:true');
        header('Access-Control-Allow-Method:GET,POST,PUT,PATCH,DELETE,HEAD,OPTIONS');
        header("Access-Control-Allow-Headers:Origin,X-Requested-With,Content-Type,Accept,Authorization");
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->data   =  $rs_data;
        Yii::$app->response->send();
        exit();
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
        $return_data['state'] = 0;
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Credentials:true');
        header('Access-Control-Allow-Method:GET,POST,PUT,PATCH,DELETE,HEAD,OPTIONS'); 
        header("Access-Control-Allow-Headers:Origin,X-Requested-With,Content-Type,Accept,Authorization");   
        Yii::$app->response->statusCode = 200;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->data =  $return_data;
        Yii::$app->response->send();
        exit();
    }
    
    protected function checkLogin()
    {
        $authorization = \Yii::$app->request->headers->get('Authorization');
        if(empty($authorization)){
            return $this->error('请先登录');
        }
        $str = $this->decrypt($authorization);
        $arr = explode('|', $str);
        $expires = isset($arr[1]) ? $arr[1] : 1;
        if($expires < time()){
            return $this->error('token过期，请重新登录');
        }
        $this->uid = $arr[0];
        $this->user_model = User::findOne($this->uid);
        $oss_url = Yii::$app->params['oss_url'];
        if(empty($this->user_model)){
            return $this->error('token无效，请登录');
        }
        $this->user_model->image =  $oss_url . $this->user_model->image;
        $this->user_info = $this->user_model->toArray();
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
    
    /**
     *
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password,$old_pass)
    {
        return Yii::$app->security->validatePassword($password, $old_pass);
    }
    
    public  function encrypt($string) {
        $data = openssl_encrypt($string, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA);
        $data = strtolower(bin2hex($data));
        return $data;
    }
    
 
    public  function decrypt($string) {
        $decrypted = openssl_decrypt(hex2bin($string), 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA);
        return $decrypted;
    }
    
    //封装登录后续处理
    protected function login($user_model,$user_info)
    {
        $expires = time() + 8640000;
        $uid = $user_info['uid'];
        $str = "$uid|$expires";
        $token_str = $this->encrypt($str);
        $oss_url = Yii::$app->params['oss_url'];
        $data = [
            'uid'        => $uid,
            'nick_name'  => $user_info['nick_name'],
            'mobile'     => $user_info['mobile'],
            'level'      => $user_info['level'],
            'amount'     => $user_info['amount'],
            'image'      => $oss_url . $user_info['image'],
            'token'      => $token_str,
            'expires'    => $expires
        ];
        $user_model->token = $token_str;
        $user_model->last_login_time = time();
        $user_model->last_login_ip = $this->clientIP();
        $user_model->expires = $expires;
        $user_model->update();
        return $data;
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
    
    /**
     * 销毁验证码
     * @param string $key
     */
    public function destroyRedisValue($key) {
        $redis = \api\models\RedisModel::getSession();
        $redis->del($key);
    }
    
    public function setRedisValue($key,$value,$expire=600)
    {
        $redis = \api\models\RedisModel::getSession();
        $redis->set($key,$value);
        $redis->expire($key, 300);
        return true;
    }
    
    public function getRedisValue($key)
    {
        $redisModel = \api\models\RedisModel::getSession();
        return $redisModel->get($key);
    }
    
    public function getRedisKey($type,$ext)
    {
        return $type . ':' . $ext;
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

}

<?php
namespace api\controllers;

use Yii;
use backend\controllers\PublicController;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use GuzzleHttp\Client;

class Base extends \yii\web\Controller
{
    public $controllerNamespace = 'api\modules';

    public $enableCsrfValidation = false;
    
    public $openLoginCheck = true;
    
    public $token_key;
    
    public $token ;
    
    public $userInfo;


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
    protected function error($message = 'error', $code=500, $data =[])
    {
        Yii::$app->response->statusCode = $code;
        $rs_data = array(
            'state' => $code,
            'msg'   => $message,
            'data'  => $data
        );
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Credentials:true');
        header('Access-Control-Allow-Method:GET,POST,PUT,PATCH,DELETE,HEAD,OPTIONS');
        header("Access-Control-Allow-Headers:Origin,X-Requested-With,Content-Type,Accept,Authorization");
        Yii::$app->response->statusCode = 200;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->data   = $this->version() + $rs_data;
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
        Yii::$app->response->data = $this->version() + $return_data;
        Yii::$app->response->send();
        exit();
    }
    
    protected function checkLogin()
    {
        $authorization = \Yii::$app->request->headers->get('Authorization');
        if(empty($authorization)){
            return $this->error('请先登录');
        }
        $this->token = $authorization;
        $this->token_key = md5($authorization);
        $redisModel = \vlogapi\models\RedisModel::getSession();
        $str  = $redisModel->get($this->token_key);
        if(empty($str)){
            return $this->error('请先登录');
        }
        $this->userInfo = \GuzzleHttp\json_decode($str,true);
    }
    
    /**
     * 版本号
     * @return multitype:string
     */
    private function version() 
    {
        return [ 'sversion' => 'V1.0.11'];
    
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
    
    protected function _http()
    {

        $url = Yii::$app->request->hostInfo . '/upload/img';
        $r_data = [
            'strToken' => \Yii::$app->request->headers->get('Authorization'),
            'expire'   => date('Y-m-d H:i:s',strtotime('+1 days')),
            'api_url'  => $url
        ];
        $this->success($r_data);
    }
    
    protected function _apiPage($models,$pagination,$page_size,$page)
    {
        $data['list'] = $models;
        $count = $pagination->totalCount;
        $data['page']['total'] = $count;
        $data['page']['pageSize'] = $page_size;
        $data['page']['page'] = $page+1;
        $data['page']['pageTotal'] = ceil($count / $page_size);
        return $data;
    }
    
    public function cleanUserinfo($userinfo)
    {
        $key = $this->token_key;
        $redisModel = \vlogapi\models\RedisModel::getSession();
        unset($userinfo['salt']);
        unset($userinfo['password'],$userinfo['allowance'],$userinfo['allowance_updated_at']);
        unset($userinfo['reg_time'],$userinfo['update_time']);
        unset($userinfo['reg_ip'],$userinfo['last_login_time'],$userinfo['last_login_ip']);
        
        $oss_url = Yii::$app->params['oss_url'];
        $userInfo['image'] = $oss_url . $userinfo['image'];
       
        $userinfo['token'] = $this->token;
        $userinfo['amount'] = sprintf("%.2f",$userinfo['amount'] / 100);
        $userinfo['give_gift'] = sprintf("%.2f",$userinfo['give_gift'] / 100);
        $userinfo['give_game'] = sprintf("%.2f",$userinfo['give_game'] / 100);
        $userinfo['withdraw'] = sprintf("%.2f",$userinfo['withdraw'] / 100);
        $redisModel->set($key,json_encode($userinfo));
        $redisModel->expire($key, 86400 * 30);
        return $userinfo;
    }
    
    public function _createOrderNumber()
    {
        return date('ymdHis',time()) . mt_rand(10000, 99999);
    }

}

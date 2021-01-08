<?php
namespace api\models;

class RedisModel 
{
    public $handle;
    
    public $preKey;
    
    /**
     * RedisModel constructor.
     */
    public function __construct($config = [])
    {
      
        $this->handle = \Yii::$app->redis;
    
    }
    
    /**
     * @name session存储用户登录信息
     * @author stenfan
     * @date 2020-07-24
     */
    public static function getSession($key = null)
    {
        return \Yii::$app->session->redis;
    }
    
    /**
     * @author stenfan
     * @date 2020-07-24
     */
    public static function getRedis($key = null)
    {
        return \Yii::$app->redis;
    }

}
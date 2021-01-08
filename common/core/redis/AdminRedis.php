<?php

namespace common\core\redis;
use common\modelsgii\Page;
use phpDocumentor\Reflection\Types\Parent_;

class AdminRedis extends BaseRedis
{

    static $pre_key = parent::PRE_KEY.'Admin:';


    /**
     * 保存redis
     * @param $key
     * @param $value
     * @param float|int $expire 有效时间
     * @return mixed
     * @author mike
     * @date 2020-12-16
     */
    public static function set($key,$value,$expire=24*3600)
    {
        $key = self::$pre_key.$key;
        $val = json_encode($value);
        \Yii::$app->redis->set($key,$val);
        \Yii::$app->redis->expire($key,$expire);
        return $value;

    }


    /**
     * 获取值
     * @param $key
     * @return bool|mixed
     * @author mike
     * @date 2020-12-16
     */
    public static function get($key)
    {
        $key = self::$pre_key.$key;
        $res = \Yii::$app->redis->get($key);
        if($res){
            return json_decode($res,true);
        }
        return false;

    }

}
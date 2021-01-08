<?php

namespace common\models;

use common\core\redis\AdminRedis;
use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property string $uid
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $mobile
 * @property string $reg_time
 * @property string $reg_ip
 * @property string $last_login_time
 * @property string $last_login_ip
 * @property string $update_time
 * @property integer $status
 */
class Admin extends Base
{

    static $pre_key = "adminInfo:";
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_admin';
    }

    /**
     * 获取所有管理账号
     * @param array $condition
     * @param $page
     * @param $limit
     * @return array
     * @author mike
     * @date 2020-12-16
     */
    public static function getAll($condition=[],$page,$limit)
    {
        $data = self::find()
            ->where($condition)
            ->orderBy('id DESC')
            ->limit($limit)
            ->offset(($page-1)*$limit)
            ->all();


        $list  = [
            'data'  => $data,
            'count' => self::find()->where($condition)->count(),
        ];
        return $list;
    }


    /**
     * 添加管理员账号
     * @param $data
     * @author mike
     * @date 2020-12-16
     */
    public static function add($data)
    {
        $model = new self();
        foreach ($data as $key =>$val)
        {
            $model->$key = $val;
        }
        $model->password = Yii::$app->security->generatePasswordHash($model->password);
        if($model->save())
        {
            return $model;
        }else{
            return false;
        }
    }

    
}

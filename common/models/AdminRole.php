<?php

namespace common\models;

use common\core\redis\AdminRedis;
use common\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "live_admin_role".
 * 管理员权限表
 **/

class AdminRole extends Base
{


    /**
     * @var 管理员权限缓存key
     */
    static $admin_role_key = "admin_roles:";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_role';
    }


    /**
     * 根据ID获取权限名称
     * @param $id
     * @author mike
     * @date 2020-12-16
     */
    public static function getIdName($id)
    {
        $key = "roles:".$id;
        $roles = AdminRedis::get($key);
        if(!$roles)
        {
            $role = AdminRole::findOne($id);
            if($role)
                return AdminRedis::set($key,$role->name);
            return false;
        }
        return $roles;
    }


    /**
     * @param array $condition
     * @param int $page
     * @param int $limit
     * @return mixed
     * @author mike
     * @date 2020-12-16
     */
    public static function getAll($condition=[],$page=1,$limit=20)
    {
        $list['count'] = self::find()
            ->where($condition)
            ->count();

        $list['data'] = self::find()
            ->where($condition)
            ->limit($limit)
            ->offset(($page-1)*$limit)
            ->asArray()
            ->all();
        return $list;
    }

    /**
     * 获取键值对权限列表
     * @author mike
     * @date 2020-12-16
     */
    public static function getId2Name()
    {
        $model = self::find()->select("id,name")->asArray()->all();
        if($model)
            return ArrayHelper::map($model,'id','name');
        return [];
    }


    /**
     * 添加权限
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
        if($model->save())
        {
            return $model;
        }else{
            return false;
        }
    }

    /**
     * 根据ID修改数据
     * @author mike
     * @date 2020-12-16
     */
    public static function setIdData($id,$data)
    {
        $model = self::findOne($id);
        foreach ($data as $k =>$v)
        {
            $model->$k = $v;
        }
        if($model->save()){
            $key = self::$admin_role_key.$id;
            return AdminRedis::set($key,json_decode($model->powers,true));
        }
        return false;

    }


    /**
     * 根据管理员ID获取权限
     * @param $uid
     * @author mike
     * @date 2020-12-17
     */
    public static function getUidPowers($id)
    {

        $key = self::$admin_role_key.$id;
        $list = AdminRedis::get($key);
        if(!$list)
        {
            $model = AdminRole::find()->where(['id'=>$id])->asArray()->one();
            if(!$model)
                return false;
            $list = AdminRedis::set($key,json_decode($model['powers'],true));
        }
        return $list;
    }

}

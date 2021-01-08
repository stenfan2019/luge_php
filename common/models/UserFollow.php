<?php
namespace common\models;

use Yii;
class UserFollow extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_user_follow';
    }
    
    public function getUser()
    {
        // 第一个参数为要关联的子表模型类名，
        // 第二个参数指定 通过子表的customer_id，关联主表的id字段
        return $this->hasMany(User::className(), ['uid' => 'user_id']);
    }
}
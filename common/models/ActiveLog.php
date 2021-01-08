<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "live_active_log".
 *
 * @property int $id
 * @property int $uid 会员ID
 * @property string $uname 会员名
 * @property int $active_id 活动ID
 * @property string $active_name 活动名称
 * @property string $active_type 活动类型
 * @property int $money 金额
 * @property string $is_get 是否领取
 * property string $get_type 领取方式
 * @property string $memo 备注
 * @property string $last_get_time 上次领取时间
 * @property string $updated 更新时间
 * @property string $created 创建时间
 */
class ActiveLog extends \yii\db\ActiveRecord
{

    //已领取
    const IS_GET_YES    = 'yes';
    //未领取
    const IS_GET_NO     = 'no';
    //已冻结
    const IS_GET_FREEZE = 'freeze';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_active_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'active_id', 'money'], 'integer'],
            [['is_get'], 'string'],
            [['last_get_time', 'updated', 'created'], 'safe'],
            [['uname'], 'string', 'max' => 50],
            [['active_name'], 'string', 'max' => 100],
            [['active_type','get_type'], 'string', 'max' => 20],
            [['memo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'uname' => 'Uname',
            'active_id' => 'Active ID',
            'active_name' => 'Active Name',
            'active_type' => 'Active Type',
            'money' => 'Money',
            'is_get' => 'Is Get',
            'memo' => 'Memo',
            'last_get_time' => 'Last Get Time',
            'updated' => 'Updated',
            'created' => 'Created',
        ];
    }


    /**
     * @param array $data
     * @author mike
     * @date 2020-12-25
     */
    public static function addData($data)
    {
        $model = new self();
        $model->uid = $data['uid'];
        $model->uname = $data['uname'];
        $model->active_id = $data['active_id'];
        $model->active_name = $data['active_name'];
        $model->active_type = $data['active_type'];
        $model->money   = $data['money'];
        $model->get_type = $data['get_type'];
        if($data['get_type'] == Active::GET_TYPE_AUTO)
        {
            $model->is_get  = self::IS_GET_YES;
            $model->last_get_time = date('Y-m-d H:i:s');
            $memo = $data['active_name'].':'.Active::get_type($data['get_type']).'领取';
            //自动领取时 直接添加金额
            User::balance($data['uid'],$data['money'],201,$memo);
        }
        $model->save();
        return $model->errors;


    }

    /**
     * 获取未领取的活动
     * @param $uid
     * @param $active_id
     * @return array|\yii\db\ActiveRecord[]
     * @author mike
     * @date 2020-12-30
     */
    public static function getBonus($uid,$active_id)
    {
        $where = [
            'and',
            ['=','uid',$uid],
            ['=','active_id',$active_id],
            ['=','is_get',self::IS_GET_NO]
        ];
        return self::find()
            ->where($where)
            ->all();
    }
}

<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "live_active".
 *
 * @property int $id
 * @property string $name 活动名称
 * @property string $type 活动类型
 * @property array $condition 条件
 * @property array $bonus 奖金
 * @property string $start_time 开始时间
 * @property string $end_time 截至时间
 * @property string $web_pic web图片
 * @property string $pc_pic pc图片
 * @property string $descript 描述
 * @property int $status 状态
 * @property int $get_type 领取方式
 * @property int $updated_uid 更改人
 * @property int $created_uid 创建人
 * @property string $updated 更新时间
 * @property string $created 创建时间
 */
class Active extends Base
{


    //领取方式:自动
    const GET_TYPE_AUTO = 'auto';

    //领取方式:手动
    const GET_TYPE_MANUAL   = 'manual';

    //状态:开启
    const STATUS_OPEN     = '1';
    //状态:关闭
    const STATUS_CLOSE    = '0';


    const STATE_VALID       = '正在进行';

    const STATE_INVALID     = '已结束';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_active';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['condition', 'bonus', 'start_time', 'end_time', 'updated', 'created'], 'safe'],
            [['descript'], 'string'],
            [['updated_uid', 'created_uid'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 50],
            [['web_pic', 'pc_pic'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '活动名',
            'type' => '类型',
            'condition' => '满足条件',
            'bonus' => '获得奖金',
            'start_time' => '开始时间',
            'end_time' => '截至时间',
            'web_pic' => 'Web图片',
            'pc_pic' => 'pc图片',
            'descript' => '描述',
            'updated_uid' => '修改人',
            'created_uid' => '创建人',
            'updated' => '更新时间',
            'created' => '创建时间',
        ];
    }

    /**
     * 获取
     * @author mike
     * @date 2020-12-22
     */
    public static function getPageData($where =[],$page=1,$pageSize=self::PAGE_SIZE)
    {
        $list['count'] = self::find()->count()??0;
        if($list['count']==0)
            return $list;
        $list['list'] = self::find()
            ->where($where)
            ->limit($pageSize)
            ->offset(($page-1)*$pageSize)
            ->orderBy('id DESC')
            ->asArray()
            ->all();
        return $list;
    }


    /**
     * 保存数据
     * @param $data
     * @param string $id
     * @return bool
     * @author mike
     * @date 2020-12-30
     */
    public static function saveData($data,$id="")
    {

        $model = self::findOne($id);
        if(!$model)
        {
            $model = new self();
            $model->created_uid = $data['created_uid'];
            unset($data['created_uid']);
        }
//        echo "<pre>";print_r($model);exit;
        foreach ($data as $key => $val)
        {
            $model->$key = $val;
        }
        return $model->save();
    }


    /**
     * 获取领取方式
     * @param string $type
     * @return array|mixed
     * @author mike
     * @date 2020-12-23
     */
    public static function get_type($type="")
    {
        $getTypes = [
            self::GET_TYPE_AUTO     => '自动',
            self::GET_TYPE_MANUAL   => '手动',
        ];
        if($type)
            return $getTypes[$type];
        return $getTypes;
    }

    /**
     * 获取活动状态
     * @param string $type
     * @return array|mixed
     * @author mike
     * @date 2020-12-23
     */
    public static function getStatus($type="")
    {
        $getTypes = [
            self::STATUS_OPEN     => '开启',
            self::STATUS_CLOSE    => '关闭',
        ];
        if(strlen($type))
            return $getTypes[$type];
        return $getTypes;
    }


    /**
     * 计算活动奖金
     * @param $uid
     * @param $type
     * @param $money
     * @param int $times
     * @param string $time
     * @return bool|int
     * @author mike
     * @date 2020-12-25
     */
    public static function computeActive($uid,$type,$money,$times=0,$time="")
    {
        if(!$time)
            $time =date('Y-m-d H:i:s');
        if($type == ActiveType::DEPOSIT)
            $types = [ActiveType::IS_FIRST,ActiveType::DEPOSIT];
        else
            $types = [$type];
        $where = [
            'and',
            ['in','type',$types],
            ['<','start_time',$time],
            ['>','end_time',$time],
            ['=','status',self::STATUS_OPEN],
//            ['=','get_type',self::GET_TYPE_AUTO],
        ];
        $models = self::find()->where($where)->orderBy('id desc')->all();
        if(!$models)
            return false;
        foreach ($models as $model)
        {
            $condition = json_decode($model->condition,true);
            $bonus = json_decode($model->bonus,true);

            if(isset($condition[ActiveType::CONDITION_MONEY])) //充值金额
            {
                foreach ($condition[ActiveType::CONDITION_MONEY] as $k => $v)
                {
                    $num = $condition[ActiveType::CONDITION_NUM][$k]??0;
                    if($money>=$v && $times>=$num)
                    {
                        if($bonus['name'][$k] == ActiveType::BONUS_MONEY)
                        {
                            $balance = intval($bonus['value'][$k]);

                        }elseif($bonus['name'][$k] == ActiveType::BONUS_RATE)
                        {
                            $balance = intval(($bonus['value'][$k]*$money)/100);
                        }else{
                            //其他方式 ,后续在配置奖励方式时在此添加
                            continue;
                        }
                        $data = [
                            'uid'=>$uid,
                            'uname' => User::getIdName($uid),
                            'active_id' => $model->id,
                            'active_name'   => $model->name,
                            'active_type'   => $model->type,
                            'money'         => $balance,
                            'get_type'      => $model->get_type,
                        ];
                        ActiveLog::addData($data); // 添加记录
                        continue;
                    }
                }
            }
        }
    }




}

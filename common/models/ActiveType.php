<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "live_active_type".
 *
 * @property int $id
 * @property string $name
 * @property string $condition
 * @property int $update_uid
 * @property int $create_uid
 * @property string $updated
 * @property string $created
 */
class ActiveType extends Base
{
    const IS_FIRST    = 'is_first'; //首充
    const BET         = 'bet'; //投注
    const DEPOSIT     = 'deposit';//充值


    const CONDITION_MONEY   = 'money';  //金额
    const CONDITION_NUM     = 'num';    //次数
//    const BET_MONEY         = 'bet_money';
//    const BET_NUM           = 'bet_num';

    const BONUS_MONEY           = 'money'; //奖励金额
    const BONUS_RATE            = 'rate'; //奖励金额比例

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_active_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['update_uid', 'create_uid'], 'integer'],
            [['updated', 'created'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['condition'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'condition' => 'Condition',
            'update_uid' => 'Update Uid',
            'create_uid' => 'Create Uid',
            'updated' => 'Updated',
            'created' => 'Created',
        ];
    }


    /**
     * 定义活动条件
     * @author mike
     * @date 2020-12-21
     */
    public static function getTypes($type="")
    {

        $types = [
            //首充
            self::IS_FIRST =>
                [
                    'name' => '首充',
                    'condition'=> [
                        self::CONDITION_MONEY     => ['name' =>'充值金额'],
//                        self::DEPOSIT_NUM       => ['name' =>'充值次数',],
                    ],
                    'bonus' => [
                        self::BONUS_MONEY        => ['name'=>'金额'],
                        self::BONUS_RATE         => ['name'=>'比例'],
                    ],
                ],
            //充值
            self::DEPOSIT =>
            [
                'name' => '充值',
                'condition'=>[
                    self::CONDITION_MONEY     => ['name' =>'充值金额'],
                    self::CONDITION_NUM       => ['name' =>'充值次数',],
                ],
                'bonus' => [
                    self::BONUS_MONEY       => ['name'=>'金额'],
                    self::BONUS_RATE        => ['name'=>'比例'],
                ],
            ],

            //投注
            self::BET   => [
                'name' => '投注',
                'condition' => [
                    self::CONDITION_MONEY     => ['name'=>'投注金额',],
                    self::CONDITION_NUM       => ['name'=>'投注次数',],
                ],
                'bonus' => [
                    self::BONUS_MONEY       => ['name'=>'金额'],
                    self::BONUS_RATE        => ['name'=>'比例'],
                ],
            ],
        ];
        if(strlen($type))
            return $types[$type]??[];
        return $types;

    }

    /**
     * 获取
     * @author mike
     * @date 2020-12-21
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
            ->asArray()
            ->all();
        return $list;
    }


    /**
     * 获取活动的类型
     * @param string $type
     * @return array|mixed
     * @author mike
     * @date 2020-12-22
     */
    public static function getTypeName($type="")
    {

        $typeName = [];
        foreach (self::getTypes() as $k =>$v)
        {
            $typeName[$k] = $v['name'];
        }
        if(strlen($type))
            return $typeName[$type];
        return $typeName;
    }



}

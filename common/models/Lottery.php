<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "live_lottery".
 * 彩票彩种表
 *
 * @property string $id
 * @property string $name 
 * @property string $code 
 * @property string $icon_url 
 * @property string $type
 * @property int $sort
 * @property int $is_private
 * @property int $envelop_time
 * @property int $status 是否删除 0为删除，1反之
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property int $period_time 彩票周期
 *
 */
class Lottery extends Base
{
    static $field_title = [
        'type' => ['low' => '低频彩', 'high' => '高频彩'],
        'is_private' => ['0' => '官彩', '1' =>'私彩'],
        'is_index'   => ['0' => '否', '1' =>'推荐'],
        'status' => ['0' => '删除', '1' =>'正常'],
    ];
    const STATUS_ACTIVE = 99;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_lottery';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code','icon_url','type','is_private','period_time'], 'required'],
            [['sort', 'is_private', 'envelop_time', 'status','period_time'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'name'         => '彩种名称',
            'code'         => '彩票编号',
            'icon_url'     => 'icon',
            'type'         => '彩票频率',
            'sort'         => '排序',
            'is_private'   => '私彩',
            'envelop_time' => '封盘时间',
            'status'       => '是否删除 0为删除，1反之',
            'create_time'  => '创建时间',
            'update_time'  => '更新时间',
            'period_time'  => '开奖周期'
        ];
    }



}
<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%s_room_day_list}}".
 *
 * @property string $id ID
 * @property string $room_id 用户ID
 * @property string $room_name 用户账号
 * @property string $anchor_id 主播ID
 * @property string $anchor_name 主播账号
 * @property string $start_time 开始时间
 * @property string $end_time 结束时间
 * @property string $gift_num 个数
 * @property string $gift_price 花费金额
 * @property string $view_num 观看人数
 * @property int $state 是否结算 0为未结算
 * @property int $status 是否删除 0为删除，1反之
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 *
 * @property Room $room
 */
class RoomDayList extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_room_day_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'room_name', 'anchor_id', 'anchor_name'], 'required'],
            [['room_id', 'anchor_id', 'gift_num', 'gift_price', 'view_num', 'state', 'status'], 'integer'],
            [['start_time', 'end_time', 'create_time', 'update_time'], 'safe'],
            [['room_name', 'anchor_name'], 'string', 'max' => 32],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::className(), 'targetAttribute' => ['room_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_id' => '用户ID',
            'room_name' => '用户账号',
            'anchor_id' => '主播ID',
            'anchor_name' => '主播账号',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'gift_num' => '个数',
            'gift_price' => '花费金额',
            'view_num' => '观看人数',
            'state' => '是否结算 0为未结算',
            'status' => '是否删除 0为删除，1反之',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::className(), ['id' => 'room_id']);
    }
}

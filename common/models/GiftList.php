<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "live_s_gift_list".
 *
 * @property string $id ID
 * @property string $user_id 用户ID
 * @property string $user_name 用户账号
 * @property string $anchor_id 主播ID
 * @property string $anchor_name 主播账号
 * @property string $gift_id 礼物ID
 * @property string $gift_name 礼物名
 * @property string $gift_num 个数
 * @property string $gift_price 花费金额
 * @property int $state 是否结算 0为未结算
 * @property int $status 是否删除 0为删除，1反之
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 *
 * @property Anchor $anchor
 * @property Anchor $anchorName
 * @property User $userName
 * @property User $user
 */
    class GiftList extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_s_gift_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_name', 'anchor_id', 'anchor_name', 'gift_id', 'gift_name'], 'required'],
            [['user_id', 'anchor_id', 'gift_id', 'gift_num', 'gift_price', 'state', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['user_name', 'anchor_name', 'gift_name'], 'string', 'max' => 32],
            [['anchor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Anchor::className(), 'targetAttribute' => ['anchor_id' => 'id']],
            [['anchor_name'], 'exist', 'skipOnError' => true, 'targetClass' => Anchor::className(), 'targetAttribute' => ['anchor_name' => 'username']],
            [['user_name'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_name' => 'username']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'uid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'user_name' => '用户账号',
            'anchor_id' => '主播ID',
            'anchor_name' => '主播账号',
            'gift_id' => '礼物ID',
            'gift_name' => '礼物名',
            'gift_num' => '个数',
            'gift_price' => '花费金额',
            'state' => '是否结算 0为未结算',
            'status' => '是否删除 0为删除，1反之',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnchor()
    {
        return $this->hasOne(Anchor::className(), ['id' => 'anchor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnchorName()
    {
        return $this->hasOne(Anchor::className(), ['username' => 'anchor_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserName()
    {
        return $this->hasOne(User::className(), ['username' => 'user_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['uid' => 'user_id']);
    }
}

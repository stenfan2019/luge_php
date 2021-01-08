<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "live_user_banks".
 * 主播银行卡
 *
 * @property string $id
 * @property string $uid uid
 * @property string $bank_code 银行编号
 * @property string $bank_name 银行名称
 * @property string $bank_account 开户人
 * @property string $bank_number 银行卡号
 * @property string $bank_address 开户行
 * @property int $status 是否删除 0为删除，1反之
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 *
 */
class UserBanks extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_user_banks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'bank_code','bank_name'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['bank_account', 'bank_address'], 'string', 'max' => 32],
            [['bank_number'], 'string', 'min'=> 16, 'max' => 19],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'uid',
            'bank_code' => '银行编号',
            'bank_account' => '开户人',
            'bank_name' => '银行名称',
            'bank_address' => '开户行',
            'bank_number' => '银行卡号',
            'status' => '是否删除 0为删除，1反之',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    


}

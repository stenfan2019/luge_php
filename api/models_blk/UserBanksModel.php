<?php
namespace api\models;

use common\models\UserBanks;

use Yii;

class UserBanksModel extends UserBanks
{
    /**
     * 检查银行卡号是否存在
     * @param string $number
     */
    public function checkNumberIsExist($number)
    {
        $info = UserBanks::find()->where(['bank_number' => $number])->asArray()->one();
        return $info ? true : false;
    }
    
    public function addBank(array $data){
        $banks = new UserBanks();
        $banks->create_time = date('Y-m-d H:i:s');
        $banks->update_time =  $banks->create_time;
        $banks->setAttributes($data,true);
        if ($banks->save()) {
            return true;
        }else{
            //print_r($banks->getErrors());
            return false;
        }
    }
    /**
     * 获取绑定的银行卡列表
     * @param int $anchor_id
     */
    public function getBankList($uid)
    {
        return UserBanks::find()->where(['uid' => $uid,'status' => 1])->asArray()->all();
    }
    
    /**
     * 删除绑定的银行卡
     * @param int $anchor_id
     * @param int $id
     */
    public function delBank($uid, $id)
    {
        $banks = UserBanks::find()->where(['uid' => $uid,'id' => $id])->one();
        $banks->status = 0;
        return $banks->save();
    }
}
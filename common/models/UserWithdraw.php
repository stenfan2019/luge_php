<?php
namespace common\models;
use common\models\Setting;
use Yii;

class UserWithdraw extends Base
{
   static $field_title = [
        'state' => ['1' => '审核中', '2' => '拒绝','3' => '成功'],
        
   ];
   /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'live_user_withdraw';
    }
    
    public function getFee($amount,$times = 1)
    {
        $conf  = Setting::findOne(Setting::USER_ID);
        if($conf){
            $data = $conf->data;
            $conf = unserialize($data);
            $free_times = $conf['user_free_times'];
            if($times <= $free_times){
                return '0.00';
            }else{
                $user_one_fee = $conf['user_one_fee'];
                $fee = $amount * $conf['user_fee'];
                return $fee > $user_one_fee ? $fee : $user_one_fee;
            }
            
        }else{
            return '20.00';
        }
    }
    
    public function getUser()
    {
        return $this->hasMany(User::className(), ['uid' => 'user_id']);
    }
    
    
}
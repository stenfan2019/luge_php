<?php
namespace common\models;

use Yii;

class HbaoPacketSub extends Base
{
    static $field_title = [
        'is_mine' => ['0' => '未中','1'=>'<font color="red">必中</font>'],
        'is_die'  =>  ['0' => '必死','1'=>'免死'],
        'is_hit'  =>  ['0' => '未中','1'=>'必中'],
        'is_good' =>  ['0' => '普通','1'=>'运气王']
    ];
    
    static $search = [
        'user_id'  => 'UID',
        'hbao_id'  => '红包ID',
        'room_id'  => '房间ID',
        'ip'       => 'IP'
    ];
    /**
     * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'hbao_packet_sub';
    }
    
   
}

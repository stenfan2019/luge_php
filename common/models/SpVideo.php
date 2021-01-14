<?php
namespace common\models;

use Yii;

class SpVideo extends Base
{
    static $field_title = [
        'type_id'   => [
            '1'   => '中文字幕',
            '2'   => '精選系列',
            '3'   => '亞洲無碼',
            '4'   => '亞洲有碼',
            '5'   => '無碼破解',
            '6'   => '偷拍自拍',
            '7'   => '網紅',
            '8'   => '主播',
            '12'  => '明星',
            '13'  => '三級',
            '14'  => '歐美',
            '15'  => '動漫',
            '16'  => '免費試看'
        ],
    ];
    
    /**
     * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'sp_video';
    }
}

     
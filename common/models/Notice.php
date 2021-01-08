<?php
namespace common\models;
use Yii;
class Notice extends Base
{
    static $field_title = [
        'type'    => ['1' => '滚动公告', '2' => '弹窗公告'],
        'cate'    => ['1' => '主播端',   '2' => '用户端'],
        'is_show' => ['1' => '显示',   '0' => '隐藏']
    ];
    /**
     * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'live_notice';
    }
     
}
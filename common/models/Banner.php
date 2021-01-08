<?php
namespace common\models;
use Yii;
class Banner extends Base
{
    static $field_title = [
        'type'    => ['1' => '内部跳转', '2' => '外部跳转'],
        'cate'    => ['1' => '主播端',   '2' => '用户端'],
        'is_show' => ['1' => '显示',   '0' => '隐藏'],
        'site'    => ['1' => '首页',   '2' => '内容页']
    ];
    /**
     * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'live_banner';
    }
     
}
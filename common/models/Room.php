<?php

namespace common\models;

use Yii;
/**
 * This is the model class for table "{{%room}}".
 *
 * @property string $id
 * @property string $title 房间名
 * @property string $discript 房间介绍
 * @property string $rtmp_url
 * @property string $flv_url
 * @property string $hls_url
 * @property int    $state 直播状态
 * @property string $category 所属栏目
 * @property string $anchor_id 主播ID
 * @property string $chat_id 所关联聊天室ID
 * @property string $online_num 观看人数
 * @property string $show_pic 展示图
 * @property string $keywords 标签/关键字
 * @property int    $status 是否删除 0为删除，1反之
 * @property is_index
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */

class Room extends Base
{
    /**
     * 推荐
     */
    const RECOMMEND_YES     = 1;
    
    /**
     * 不推荐
     */
    const RECOMMEND_NO      = 0;
    
    static $field_title = [
        'category'   => ['1' => '红包', '2' => '彩票'],
        'recommend'  => ['0' => '否', '1' => '推荐'],
        'is_index'   => ['0' => '否', '1' => '首页'],
        'state'      => ['0' => '下播', '1' => '<font color="green">直播中</font>'],
    ];
    
    static $search = [
        'anchor_id'  => '主播ID',
        'id'         => '房间ID',
        'title1'     => '标题[模糊匹配]',
        'title2'     => '标题[精确匹配]'
    ];
    
    public static function tableName()
    {
        return '{{%room}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['state', 'category', 'anchor_id', 'chat_id', 'online_num', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['title', 'show_pic', 'keywords'], 'string', 'max' => 256],
            [['discript', 'flv_url','hls_url','rtmp_url'], 'string', 'max' => 250],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '房间名',
            'discript' => '房间介绍',
            'state' => '直播状态',
            'category' => '所属栏目',
            'anchor_id' => '主播ID',
            'chat_id' => '所关联聊天室ID',
            'online_num' => '观看人数',
            'show_pic' => '展示图',
            'keywords' => '标签/关键字',
            'status' => '是否删除 0为删除，1反之',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
    
    /**
     * @param $where
     * @param int $page
     * @param int $pageSize
     * @author mike
     * @date 2020-08-22
     */
    public static function getData($where, $page =1 , $pageSize = parent::PAGE_SIZE)
    {
        $limit = ($page-1)*$pageSize;
        return self::find()->where($where)->limit($pageSize)->offset($limit)->orderBy("id DESC")->all();
    
    }
    
    public static function closeAnchorAllRoom($anchor_id)
    {
        //return Room::model()->updateAll(['state'=>0],['anchor_id'=>$anchor_id]);
        return Yii::$app->db->createCommand()->update('{{%room}}', ['state' => 0], "anchor_id = $anchor_id")->execute();
    }
    
    

}

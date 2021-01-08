<?php

namespace common\models;

use Yii;
use yii\data\Pagination;

class GiftRecord extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_gift_record';
    }
    
    static $search = [
        'gift_id'    => '礼物ID',
        'anchor_id'  => '主播ID',
        'room_id'    => '房间ID',
        'user_id'    => '用户ID'
    ];
    
    //获取主播礼物记录
    public function getAnchorGiftList($anchor_id,$select="*",$page=1,$page_size=20)
    {
        $query = self::find()->alias('R')
              ->where("R.anchor_id=$anchor_id and R.status=1")
              ->innerJoin('{{%gift}} G','G.id=R.gift_id')
              ->select($select);
        $countQuery = clone $query;
        $count = $countQuery->count();
        $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$page_size,'page'=>$page]);
        $models = $query->offset($pages->offset)
                ->orderBy('R.create_time desc')
                ->limit($pages->limit)
                ->asArray()->all();
        return ['data'=>$models,'pagination' => $pages];
    }
    
    //获取用户礼物记录
    public function getUserGiftList($uid,$select="*",$page=1,$page_size=20)
    {
        $query = self::find()->alias('R')
                ->where("R.user_id=$uid and R.status=1")
                ->innerJoin('{{%gift}} G','G.id=R.gift_id')
                ->select($select);
        $countQuery = clone $query;
        $count = $countQuery->count();
        $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$page_size,'page'=>$page]);
        $models = $query->offset($pages->offset)
                ->orderBy('R.create_time desc')
                ->limit($pages->limit)
                ->asArray()->all();
        return ['data'=>$models,'pagination' => $pages];
    }
}
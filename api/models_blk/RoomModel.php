<?php
namespace api\models;

use common\models\Room;
use Yii;

class RoomModel extends Room
{
    /**
     * 获取首页主播间
     */
    public function getIndexRoom()
    {
        
        $rooms = Room::find()->alias('r')
                       ->where("r.state=1 and r.status=1 and r.is_index=1")
                       ->innerJoin('{{%anchor}} a','a.id=r.anchor_id')
                      
                       ->select(
                           ['r.title','r.id','r.show_pic','r.flv_url','r.hls_url','r.category',
                            'r.anchor_id','a.nickname','a.image as avatar','r.status'])
                       ->limit(20)
                       ->orderBy('r.create_time desc')->asArray()->all();
        //echo $rooms->createCommand()->sql
        return $rooms;
    }
    
    public function getMyFollowRoom($uid)
    {
        $rooms = Room::find()->alias('r')
                ->where("r.state=1 and r.is_index=1 and f.user_id=$uid")
                ->innerJoin('{{%anchor}} a','a.id=r.anchor_id')
                ->innerJoin('{{%user_follow}} f','a.id=f.anchor_id')
                ->select(   
                        ['r.title','r.id','r.show_pic','r.flv_url','r.hls_url','r.category',
                            'r.anchor_id','a.nickname','a.image as avatar','r.status'])
                            ->limit(20)
                            ->orderBy('r.create_time desc')->asArray()->all();
        //echo $rooms->createCommand()->sql
        return $rooms;
    }
}
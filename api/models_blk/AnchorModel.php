<?php
namespace api\models;
use common\models\Anchor;
use common\models\UserFollow;
use Yii;
use yii\base\BaseObject;


class AnchorModel extends Anchor
{
   
    public function getAnchorById($aid)
    {
        $info = Anchor::find()->where(['id' => $aid,'status' => 1])->one();
        return $info;
    } 
    
    public function follow($uid,$anthor_id)
    {
        $follow = UserFollow::find()->where("user_id=$uid and anchor_id=$anthor_id")->one();
        if(empty($follow)){
            $time = time();
            $date = date('Y-m-d H:i:s',$time);
            $userFollow = new UserFollow();
            $userFollow->anchor_id = $anthor_id;
            $userFollow->user_id = $uid;
            $userFollow->status = 1;
            $userFollow->create_time = $date;
            $userFollow->update_time = $date;
            $userFollow->save();
            return true;
        }else{
            return false;
        }
    }
    
    public function getFollowList($uid)
    {
        $list = UserFollow::find()->alias('f')
                           ->where("f.user_id=$uid and f.status=1")
                           ->innerJoin('{{%anchor}} a','a.id=f.anchor_id')
                           ->select(['a.username','f.anchor_id','a.nickname','a.image as avatar','f.status'])
                           ->orderBy('a.create_time desc')->asArray()->all();
        return $list;
    }
    
}
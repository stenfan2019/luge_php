<?php
namespace api\controllers;

use api\models\RoomModel;
use api\controllers\Base;
use Yii;

class RoomController extends Base
{
    public function actionMy()
    {
        $userinfo = $this->userInfo;
        $uid = $userinfo['uid'];
       
        $roomModel = new RoomModel();
        $data = $roomModel->getMyFollowRoom($uid);
        $oss_url = Yii::$app->params['oss_url'];
        
        foreach ($data as $key=>$item){
            $data[$key]['show_pic'] = $oss_url . $data[$key]['show_pic'];
            $data[$key]['avatar'] = $oss_url . $data[$key]['avatar'];
            $data[$key]['category_title'] = '娱乐直播';
            $data[$key]['hot'] = mt_rand(100, 2000);
        }
        $this->success($data);
    }
}

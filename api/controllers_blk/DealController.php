<?php
namespace api\controllers;

use api\controllers\Base;
use Yii;
use common\models\UserFundsDeal;

class DealController extends Base
{
    public function actionList()
    {
        $page = Yii::$app->request->get('page',1);
        $page = $page - 1 ? $page - 1 : 0;
        $limit = Yii::$app->request->get('limit',20);
        $type = intval(Yii::$app->request->get('type'));
        $userinfo = $this->userInfo;
        $uid = $userinfo['uid'];
        $where = "uid=$uid";
        if($type > 0){
            $where = "uid=$uid and deal_type = $type";
        }
        $dealModel = new UserFundsDeal();
     
        $res = $dealModel->getDealList($where,'*',$page,$limit);
        $data = $this->_apiPage($res['data'], $res['pagination'],$limit,$page);
        
        return $this->success($data);
    }
}
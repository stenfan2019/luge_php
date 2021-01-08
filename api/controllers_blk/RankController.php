<?php
namespace api\controllers;

use api\controllers\Base;
use Yii;
use common\models\GiftRecord;
use common\models\Anchor;
use common\models\User;

class RankController extends Base
{
    
    public function init(){
         
        $this->openLoginCheck = false;
    }
    /***
     * 明星主播榜
     * @author stenfan
     */
    public function actionStar()
    {
        $type  = Yii::$app->request->get('type');
        $where = '';
        $time = time();
        switch ($type){
            case 'day':
                $date = date('Y-m-d 00:00:00',$time);
                $where = "'{$date}' <= create_time";
                break;
            case 'week':
                $date = date('Y-m-d 00:00:00',(time()-((date('w',time())==0?7:date('w',time()))-1)*24*3600));
                $where = "'{$date}' <= create_time";
                break;
            case 'month':
                $date = date('Y-m-01 00:00:00',$time);
                $where = "'{$date}' <= create_time";
                break;
            default:
                $this->error('参数错误');
                break;
        }
        $models = GiftRecord::find()
                ->where($where)
                ->select('sum(gift_total) as taotal,anchor_id')
                ->orderBy('taotal desc')
                ->groupBy('anchor_id')
                ->limit(10)
                ->asArray()->all();
        $oss_url = Yii::$app->params['oss_url'];
        $rk = 1;
        foreach ($models as &$item){
            $item['taotal'] = sprintf("%.2f",$item['taotal'] / 100);
            $one = Anchor::findOne($item['anchor_id']);
            $item['nickname'] = $one->nickname;
            $item['image'] = $oss_url . $one->image;
            $item['rank'] = $rk;
            $rk++;
        }
        return $this->success($models);
                  
    }
    
    /***
     * 贡献者榜单
     * @author stenfan
     */
    public function actionContributor()
    {
        $type  = Yii::$app->request->get('type');
        $where = '';
        $time = time();
        switch ($type){
            case 'day':
                $date = date('Y-m-d 00:00:00',$time);
                $where = "'{$date}' <= create_time";
                break;
            case 'week':
                $date = date('Y-m-d 00:00:00',(time()-((date('w',time())==0?7:date('w',time()))-1)*24*3600));
                $where = "'{$date}' <= create_time";
                break;
            case 'month':
                $date = date('Y-m-01 00:00:00',$time);
                $where = "'{$date}' <= create_time";
                break;
            default:
                $this->error('参数错误');
                break;
        }
        $models = GiftRecord::find()
                ->where($where)
                ->select('sum(gift_total) as taotal,user_id')
                ->orderBy('taotal desc')
                ->groupBy('user_id')
                ->limit(10)
                ->asArray()->all();
        $oss_url = Yii::$app->params['oss_url'];
        $rk = 1;
        foreach ($models as &$item){
            $item['taotal'] = sprintf("%.2f",$item['taotal'] / 100);
            $one = User::findOne($item['user_id']);
            $item['nickname'] = $one->username;
            $item['image'] = $oss_url . $one->image;
            $item['rank'] = $rk;
            $rk++;
        }
        return $this->success($models);
    }
    
    /***
     * 贡献者榜单
     * @author stenfan
     */
    public function actionRoom()
    {
        $type  = Yii::$app->request->get('type');
        $room_id  = intval(Yii::$app->request->get('room_id'));
        if(empty($room_id)){
            $this->error('房间id不能为空');
        }
        $where = "room_id = $room_id";
        $time = time();
        switch ($type){
            case 'day':
                $date = date('Y-m-d 00:00:00',$time);
                $where = "'{$date}' <= create_time";
                break;
            case 'week':
                $date = date('Y-m-d 00:00:00',(time()-((date('w',time())==0?7:date('w',time()))-1)*24*3600));
                $where = "'{$date}' <= create_time";
                break;
            case 'month':
                $date = date('Y-m-01 00:00:00',$time);
                $where = "'{$date}' <= create_time";
                break;
            default:
                $this->error('参数错误');
                break;
        }
        $models = GiftRecord::find()
                ->where($where)
                ->select('sum(gift_total) as taotal,user_id')
                ->orderBy('taotal desc')
                ->groupBy('user_id')
                ->limit(10)
                ->asArray()->all();
        $oss_url = Yii::$app->params['oss_url'];
        $rk = 1;
        foreach ($models as &$item){
            $item['taotal'] = sprintf("%.2f",$item['taotal'] / 100);
            $one = User::findOne($item['user_id']);
            $item['nickname'] = $one->username;
            $item['image'] = $oss_url . $one->image;
            $item['rank'] = $rk;
            $rk++;
        }
        return $this->success($models);
    }
}
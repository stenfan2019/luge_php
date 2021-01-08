<?php
namespace admin\controllers;

use yii;
use admin\controllers\Base;
use common\models\LotteryNumber;
use common\models\Lottery;
use yii\data\Pagination;

class PeriodController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $lottery_number = Yii::$app->request->get('lottery_number');
            $pid = intval(Yii::$app->request->get('pid'));
            $where = "status=1";
            if($pid > 0){
                $where = $where . " AND pid=$pid";
            }
            if($lottery_number){
                $where = $where . " AND lottery_number='{$lottery_number}'";
            }
         
            $query = LotteryNumber::find()
                   ->where($where);
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('end_time DESC')
                    ->limit($limit)
                    ->asArray()->all();
            $data = [
                'data'  => LotteryNumber::fetchTitle($models, LotteryNumber::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            $lotterys = Lottery::find()->where("status=1")->asArray()->all();
            $lotterys = $this->_filterArray($lotterys, 'id', 'name');
            $select_html = $this->html_select('pid', ['0' => '请选择'] + $lotterys);
            return $this->render('list',[
                'select_html'  => $select_html
            ]);
        }
    }
}
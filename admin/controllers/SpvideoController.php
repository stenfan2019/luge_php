<?php 
namespace admin\controllers;

use yii;
use common\models\SpVideo;
use yii\data\Pagination;
use admin\controllers\Base;

class SpvideoController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $query = SpVideo::find();
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('id desc')
                    ->limit($limit)
                    ->asArray()->all();
            $data = [
                'data'  => SpVideo::fetchTitle($models, SpVideo::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('list');
        }
    }
}
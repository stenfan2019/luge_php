<?php
namespace admin\controllers;

use yii;
use common\models\SpVideo;
use yii\data\Pagination;
use common\models\Video;

class VideoController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $keyword = Yii::$app->request->get('keyword','');
            $type_id = Yii::$app->request->get('type_id','');
            $query = Video::find()->where();
            if($keyword){
                $query->andWhere("vod_name like '%{$keyword}%'");
            }
            if($type_id){
                $query->andWhere("type_id=$type_id");
            }
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('id asc')
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
            return $this->render('list',[
                'type_label'   => $this->html_select('type_id', SpVideo::$field_title['type_id'])
            ]);
        }
    }
    
    //视频标签
    public function actionTags()
    {
        
    }
}
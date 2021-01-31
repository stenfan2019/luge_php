<?php 
namespace admin\controllers;

use yii;
use common\models\SpVideo;
use common\models\Video;
use yii\data\Pagination;
use admin\controllers\Base;
use yii\base\BaseObject;

class SpvideoController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $keyword = Yii::$app->request->get('keyword','');
            $type_id = Yii::$app->request->get('type_id','');
            $query = SpVideo::find()->where('is_yy=0 and is_do=1');
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
    
    public function actionTodo()
    {
        $id = Yii::$app->request->get('id');
        $one = SpVideo::findOne($id);
        if($one && $one->is_yy == '0' && $one->video_url != ''){
            $video = new Video();
            $date = date('Y-m-d H:i:s');
            $video->title = $one->vod_name;
            $video->cate_id = $one->type_id;
            $video->cate_name = $one->type_name;
            $video->is_vip = 1;
            $video->is_hd = 1;
            $video->hit_num = $one->vod_hits;
            $video->up_num = $one->vod_up;
            $video->down_num = $one->vod_down;
            $video->images = $one->image_path;
            $video->video_url = $one->video_path;
            $video->images_type = '11';
            $video->video_type = '11';
            $video->create_time = $one->vod_time_add;
            $video->update_time = $date;
            $video->third_type = $one->id;
            if($video->save()){
                $one->is_yy = 1;
                $one->update();
                $this->success([]);
            }
          
        }
        $this->fail();
    }
    
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = SpVideo::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $one->video_url = $data['video_url'];
            if($one->update()){
                $this->success([]);
            }
            $this->fail();
        }
        return $this->render('edit',[
            'item'   => $one->toArray(),
        ]);
    }
}
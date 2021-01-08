<?php
namespace admin\controllers;

use yii;
use common\models\Banner;
use yii\data\Pagination;
use admin\controllers\Base;

class AdController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $type = Yii::$app->request->get('type');
            $cate = Yii::$app->request->get('cate');
            $query = Banner::find();
            if($type){
                $page = 1;
                $query->where("type='$type");
            }  
            if($cate){
                $query->where("cate=$cate");
            }
            
           
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('create_date desc')
                    ->limit($limit)
                    ->asArray()->all();
           
            $data = [
                'data'  => Banner::fetchTitle($models, Banner::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('list',[
                'cate_label'    => $this->html_radio('cate', Banner::$field_title['type'],'1'),
                'is_show_label' => $this->html_radio('is_show', Banner::$field_title['is_show'],'1'),
                'type_label'    => $this->html_radio('type', Banner::$field_title['type'],'1')
            ]);
        }
    }
    
    
    
    //添加公告
    public function actionAdd()
    {
        $type = Yii::$app->request->get('type');
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $model = new Banner();
            $model->title   = $data['title'];
            $model->image   = $data['image'];
            $model->cate    = $data['cate'];
            $model->type    = $data['type'];
            $model->is_show = $data['is_show'];
            $model->url     = $data['url'];
            $model->sort    = $data['sort'];
            $model->site    = $data['site'];
            $model->create_date =date('Y-m-d H:i:s');
            if($model->insert()){
                $this->success($data);
            }else{
                $this->fail();
            }
        }else{
            $up_data = $this->_http();
            return $this->render('add',[
                'cate_label'    => $this->html_radio('cate', Banner::$field_title['cate'],'1'),
                'is_show_label' => $this->html_radio('is_show', Banner::$field_title['is_show'],'1'),
                'type_label'    => $this->html_radio('type', Banner::$field_title['type'],'1'),
                'site_label'    => $this->html_radio('site', Banner::$field_title['site'],'1'),
                'up_data'   => $up_data
            ]);
        }
    }
    
    //编辑会员账号
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = Banner::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $one->title   = $data['title'];
            $one->image   = $data['image'];
            $one->cate    = $data['cate'];
            $one->type    = $data['type'];
            $one->is_show = $data['is_show'];
            $one->url     = $data['url'];
            $one->sort    = $data['sort'];
            $one->site    = $data['site'];
            if($one->update()){
                $this->success([]);
            }
            $this->fail();
        }else{
            $up_data = $this->_http();
            return $this->render('edit',[
                'item'          => $one->toArray(),
                'cate_label'    => $this->html_radio('cate', Banner::$field_title['cate'],$one->cate),
                'is_show_label' => $this->html_radio('is_show', Banner::$field_title['is_show'],"{$one->is_show}"),
                'type_label'    => $this->html_radio('type', Banner::$field_title['type'],$one->type),
                'site_label'    => $this->html_radio('site', Banner::$field_title['site'],$one->site),
                'up_data'   => $up_data
            ]);
        }
    }
}
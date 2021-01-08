<?php
namespace admin\controllers;

use yii;
use common\models\Notice;
use yii\data\Pagination;
use admin\controllers\Base;

class NoticeController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $type = Yii::$app->request->get('type');
            $cate = Yii::$app->request->get('cate');
            $query = Notice::find();
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
                'data'  => Notice::fetchTitle($models, Notice::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('list',[
                'cate_label'    => $this->html_radio('cate', Notice::$field_title['type'],'1'),
                'is_show_label' => $this->html_radio('is_show', Notice::$field_title['is_show'],'1'),
                'type_label'    => $this->html_radio('type', Notice::$field_title['type'],'1')
            ]);
        }
    }
    
    
    
    //添加公告
    public function actionAdd()
    {
        $type = Yii::$app->request->get('type');
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $model = new Notice();
            $model->title   = $data['title'];
            $model->details = $data['details'];
            $model->cate    = $data['cate'];
            $model->type    = $data['type'];
            $model->is_show = $data['is_show'];
            $model->create_date =date('Y-m-d H:i:s');
            if($model->insert()){
                $this->success($data);
            }else{
                $this->fail();
            }
        }else{
            return $this->render('add',[
                'cate_label'    => $this->html_radio('cate', Notice::$field_title['cate'],'1'),
                'is_show_label' => $this->html_radio('is_show', Notice::$field_title['is_show'],'1'),
                'type_label'    => $this->html_radio('type', Notice::$field_title['type'],'1')
            ]);
        }
    }
    
    //编辑会员账号
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = Notice::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $one->title   = $data['title'];
            $one->details = $data['details'];
            $one->cate    = $data['cate'];
            $one->type    = $data['type'];
            $one->is_show = $data['is_show'];
            if($one->update()){
                $this->success([]);
            }
            $this->fail();
        }else{
           
            return $this->render('edit',[
                'item'          => $one->toArray(),
                'cate_label'    => $this->html_radio('cate', Notice::$field_title['cate'],$one->cate),
                'is_show_label' => $this->html_radio('is_show', Notice::$field_title['is_show'],"{$one->is_show}"),
                'type_label'    => $this->html_radio('type', Notice::$field_title['type'],$one->type)
            ]);
        }
    }
    
     
    
    
}
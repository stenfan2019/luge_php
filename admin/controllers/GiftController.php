<?php
namespace admin\controllers;

use yii;
use admin\controllers\Base;
use common\models\Gift;
use common\models\GiftRecord;
use yii\data\Pagination;

class GiftController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $query = Gift::find()
                    ->where("status=1");
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('create_time desc')
                    ->limit($limit)
                    ->asArray()->all();
           
            $data = [
                'data'  => Gift::fetchTitle($models, Gift::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('list');
        }
    }
    
    public function actionAdd()
    {
        if(Yii::$app->request->isPost){
          $data =  Yii::$app->request->post();
          $model = new Gift();
          $model->title = $data['title'];
          $model->descript = $data['title'];
          $model->price = $data['price'];
          $model->platform_harvest = $data['platform_harvest'];
          $model->image_mall = $data['image_mall'];
          $model->image_big = $data['image_big'];
          $model->create_time = date('Y-m-d H:i:s');
          $model->show_on = $data['show_on'];
          if($model->insert()){
              $this->success($data);
          }else{
              
              $this->fail();
          }
        }else{
            return $this->render('add',[
                'show_on' => $this->html_radio('show_on', Gift::$field_title['show_on'],1)
            ]);
        }
    }
    
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = Gift::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $one->title = $data['title'];
            $one->descript = $data['title'];
            $one->price = $data['price'];
            $one->platform_harvest = $data['platform_harvest'];
            $one->image_mall = $data['image_mall'];
            $one->image_big = $data['image_big'];
            $one->update_time = date('Y-m-d H:i:s');
            $one->show_on = $data['show_on'];
            if($one->update()){
                $this->success([]);
            }else{
                $this->fail();
            }
        }else{
            return $this->render('edit',[
                'item'    => $one->toArray(),
                'show_on' => $this->html_radio('show_on', Gift::$field_title['show_on'],"{$one->show_on}")
            ]);
        }
    }
    
    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        $one = Gift::findOne($id);
        if(empty($one)){
            $this->fail('数据不存在');
        }
        $one->delete();
        $this->success([]);
    }
    
    //礼物送出记录
    public function actionRecord()
    {
        $data = Yii::$app->request->get('data');
        $this->layuiParams();
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $keyword = Yii::$app->request->get('keyword');
            $search = Yii::$app->request->get('search');
            $query = GiftRecord::find();
            if($keyword){
               
                $query->where("$search='{$keyword}'");
            }
                   
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('create_time desc')
                    ->limit($limit)
                    ->asArray()->all();
            foreach ($models as &$item){
                $item['anchor_total'] = sprintf("%.2f",$item['anchor_total'] / 100);
                $item['gift_total'] = sprintf("%.2f",$item['gift_total'] / 100);
            }
            $data = [
                'data'  => $models,
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('record',[
                'search'   => $this->html_select('search', ['0' => '请选择']+GiftRecord::$search,$this->layui_key?$this->layui_key:'0'),
                'params'   => $this->parames,
                'keyword'  => $this->layui_val
            ]);
        }
    }
}
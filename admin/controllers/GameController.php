<?php
namespace admin\controllers;

use yii;
use admin\controllers\Base;
use common\models\Game;
use yii\data\Pagination;

class GameController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $query = Game::find()
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
                'data'  => Game::fetchTitle($models, Game::$field_title,2),
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
          $model = new Game();
          $model->id = $data['id'];
          $model->game_title = $data['title'];
          $model->icon = $data['icon'];
          $model->sort = $data['sort'];
          $model->type = $data['type'];
          $model->create_time = date('Y-m-d H:i:s');
          $model->show_on = $data['show_on'];
          if($model->insert()){
              $this->success($data);
          }else{
              
              $this->fail();
          }
        }else{
            return $this->render('add',[
                'show_on' => $this->html_radio('show_on', Game::$field_title['show_on'],1),
                'type' => $this->html_radio('type', Game::$field_title['type'],'lottery')
            ]);
        }
    }
    
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = Game::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $model->id = $data['id'];
            $model->game_title = $data['title'];
            $model->icon = $data['icon'];
            $model->sort = $data['sort'];
            $model->type = $data['type'];
            $model->show_on = $data['show_on'];
            if($model->update()){
                $this->success([]);
            }else{
                $this->fail();
            }
        }else{
            return $this->render('edit',[
                'item'    => $model->toArray(),
                'show_on' => $this->html_radio('show_on', Game::$field_title['show_on'],"{$model->show_on}"),
                'type' => $this->html_radio('type', Game::$field_title['type'],$model->type)
            ]);
        }
    }
    
    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        $one = Game::findOne($id);
        if(empty($one)){
            $this->fail('数据不存在');
        }
        $one->delete();
        $this->success([]);
    }
}
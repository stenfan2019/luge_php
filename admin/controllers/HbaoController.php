<?php
namespace admin\controllers;

use yii;
use common\models\HbaoRoom;
use common\models\HbaoSet;
use common\models\HbaoPacket;
use common\models\HbaoPacketSub;
use common\models\User;
use yii\data\Pagination;
use admin\controllers\Base;

class HbaoController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $query = HbaoRoom::find()
                    ->where("status=1");
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                            ->orderBy('created desc')
                            ->limit($limit)
                            ->asArray()->all();
            $data = [
                'data'  => HbaoRoom::fetchTitle($models, HbaoRoom::$field_title,2),
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
          $one = HbaoSet::findOne(1000);
          $max_odds = 2.5;
          if($one){
              $max_odds = $one->nine5;
          }
          $data =  Yii::$app->request->post();
   
          $limited_money = $data['end_money'] * $max_odds;
         
          $model = new HbaoRoom();
          $model->name = $data['name'];
          $model->start_money = $data['start_money'];
          $model->end_money = $data['end_money'];
          $model->life_time = $data['life_time'];
          $model->limited_money = $limited_money;
          $model->sort = $data['sort'];
          $model->type = $data['type'];
          $model->odds = $data['odds'];
          $model->robet_num = $data['robet_num'];
          $model->robet_send_odds = $data['robet_send_odds'];
          $model->robet_rob_odds = $data['robet_rob_odds'];
          $model->robet_ids = str_replace('，',',',$data['robet_ids']);
          $model->created = date('Y-m-d H:i:s');
          $model->status = 1;
          if($model->insert()){
              $this->success($data);
          }else{
              
              $this->fail('fail');
          }
        }else{
            return $this->render('add',[
                'show_on' => $this->html_radio('type', HbaoRoom::$field_title['type'],1)
            ]);
        }
    }
    
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = HbaoRoom::findOne($id);
        if(Yii::$app->request->isPost){
          $data =  Yii::$app->request->post();
          $odds = HbaoSet::findOne(1000);
          $max_odds = 2.5;
          if($one){
              $max_odds = $odds->nine5;
          }
          $limited_money = $data['end_money'] * $max_odds;
          $one->name = $data['name'];
          $one->start_money = $data['start_money'];
          $one->end_money = $data['end_money'];
          $one->life_time = $data['life_time'];
          $one->limited_money = $limited_money;
          $one->sort = $data['sort'];
          $one->type = $data['type'];
          $one->odds = $data['odds'];
          $one->robet_num = $data['robet_num'];
          $one->robet_send_odds = $data['robet_send_odds'];
          $one->robet_rob_odds = $data['robet_rob_odds'];
          $one->robet_ids = str_replace('，',',',$data['robet_ids']);
          if($one->update()){
              $this->success([]);
          }else{
              $this->fail('fail');
          }
        }else{
            return $this->render('edit',[
                'item'    => $one->toArray(),
                'show_on' => $this->html_radio('type', HbaoRoom::$field_title['type'],"{$one->type}")
            ]);
        }
    }
    
    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        $one = HbaoRoom::findOne($id);
        if(empty($one)){
            $this->fail('数据不存在');
        }
        $one->delete();
        $this->success([]);
    } 
    
    public function actionPacket()
    {
        $data = Yii::$app->request->get('data');
        $this->layuiParams();
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $keyword = Yii::$app->request->get('keyword');
            $search = Yii::$app->request->get('search');
            $query = HbaoPacket::find()
                   ->where("status=1");
            if($keyword){
                
                $query->where("$search='{$keyword}'");
            }
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('created desc')
                    ->limit($limit)
                    ->asArray()->all();
            $data = [
                'data'  => HbaoPacket::fetchTitle($models, HbaoPacket::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('packet',[
                'search_label'  => $this->html_select('search', array_merge(['0' => '请选择'],HbaoPacket::$search),$this->layui_key?$this->layui_key:'0'),
                'params'        => $this->layui_val
            ]);
        }
    }
    
    /**
     * 抢到的红包接口
     * @return string
     * @author stenfan
     */
    public function actionRob()
    {
        $data = Yii::$app->request->get('data');
        $this->layuiParams();
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $keyword = Yii::$app->request->get('keyword');
            $search = Yii::$app->request->get('search');
            $query = HbaoPacketSub::find();
            if($keyword){
               
                $query->where("$search='{$keyword}'");
            }
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('created desc')
                    ->limit($limit)
                    ->asArray()->all();
            $data = [
                'data'  => HbaoPacketSub::fetchTitle($models, HbaoPacketSub::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('rob',[
                'search_label'  => $this->html_select('search', array_merge(['0' => '请选择'],HbaoPacketSub::$search),$this->layui_key?$this->layui_key:'0'),
                'params'        => $this->layui_val
            ]);
        }
    }
    
    public function actionPtview()
    {
        $hbao_id = Yii::$app->request->get('hbao_id');
        
        $data = HbaoPacketSub::find()
              ->where("hbao_id=$hbao_id")
              ->orderBy('id asc')
              ->asArray()->all();
        $data = HbaoPacketSub::fetchTitle($data, HbaoPacketSub::$field_title,2);
        return $this->render('view',['data' => $data]);
    }
    
    public function actionSet()
    {
        $id = 1000;
        $one = HbaoSet::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $one->one7  = $data['one7'];
            $one->one9  = $data['one9'];
            $one->nine2 = $data['nine2'];
            $one->nine3 = $data['nine3'];
            $one->nine4 = $data['nine4'];
            $one->nine5 = $data['nine5'];
            if($one->update()){
                $this->success([]);
            }else{
                $this->fail('fail');
            }
        }else{
            if(empty($one)){
                $model = new HbaoSet();
                $model->one7   = '1.6';
                $model->one9   = '1.2';
                $model->nine2  = '1.05';
                $model->nine3  = '1.28';
                $model->nine4  = '1.8';
                $model->nine5  = '2.5';
                $model->status = 1;
                $model->id     = $id;
                $model->save();
                $one = HbaoSet::findOne($id);
            }
            return $this->render('set',[
                'item'    => $one->toArray()
            ]);
        }
        
    }
    
    //机器人
    public function actionRobot()
    {
        return $this->render('../user/list',[
            'search_label'  => $this->html_select('search', User::$search,'mobile'),
            'level_label'   => $this->html_select('level', array_merge(['0' => '请选择VIP等级'],User::$field_title['level']),'0'),
            'type_label'    => $this->html_select('type', array_merge(['0' => '请选择类型'],User::$field_title['type']),'2'),
            'params'        => '&type=2'
        ]);
    }
}
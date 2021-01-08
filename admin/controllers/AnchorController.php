<?php
namespace admin\controllers;

use yii;
use common\models\Anchor;
use common\models\User;
use yii\data\Pagination;
use admin\controllers\Base;

class AnchorController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $keyword = Yii::$app->request->get('keyword');
            $search = Yii::$app->request->get('search');
          
            $query = Anchor::find();
            if($keyword){
                $page = 1;
                $query->where("$search='{$keyword}'");
            }
           
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('id desc')
                    ->limit($limit)
                    ->asArray()->all();
            foreach ($models as $key=>$item){
                if($item['reg_time'])
                    $item['reg_time'] = date('Y-m-d H:i:s',$item['reg_time']);
                if($item['last_login_time'])
                    $item['last_login_time'] = date('Y-m-d H:i:s',$item['last_login_time']);
                if($item['reg_ip'])
                    $item['reg_ip'] = long2ip($item['reg_ip']);
                if($item['last_login_ip'])
                    $item['last_login_ip'] = long2ip($item['last_login_ip']);
                $item['amount'] = sprintf("%.2f",$item['amount'] / 100);
                $item['income_gift'] = sprintf("%.2f",$item['income_gift'] / 100);
                $item['income_game'] = sprintf("%.2f",$item['income_game'] / 100);
                $item['withdraw'] = sprintf("%.2f",$item['withdraw'] / 100);
                $models[$key] = $item;
            }
            $data = [
                'data'  => $models,
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('list',[
                'search_label'  => $this->html_select('search', Anchor::$search,'username')
              
            ]);
        }
    }
    
    public function actionAdd()
    {
        if(Yii::$app->request->isPost){
            $data  =  Yii::$app->request->post();
            $model = new Anchor();
            $time  = time();
            $date  = date('Y-m-d H:i:s',$time);
            $salt  = mt_rand(000000, 999999);
            $password = Yii::$app->security->generatePasswordHash($data['password'] . $salt);
            $model->username = $data['username'];
            $model->mobile   = $data['mobile'];
            $model->salt     = $salt;
            $model->password = $password;
            $model->nickname = $data['nickname'];
            $model->create_time = $date;
            $model->reg_time = $time;
            $model->reg_ip   = ip2long($this->clientIP()); 
            $model->live_rate = $data['live_rate'];
            $model->game_rate = $data['game_rate'];
            $model->image     = User::getAvatar(2);
            $model->status    = 1;
            $model->is_freeze = 0;
            if($model->insert()){
                $this->success($data);
            }else{
                //print_r($model->errors);
                $this->fail();
            }
        }else{
            return $this->render('add',[
               // 'show_on' => $this->html_radio('show_on', Gift::$field_title['show_on'],1)
            ]);
        }
    }
    
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = Anchor::findOne($id);
        if(Yii::$app->request->isPost){
            $data  =  Yii::$app->request->post();
            $one->mobile   = $data['mobile'];
            $one->nickname = $data['nickname'];
            $one->live_rate = $data['live_rate'];
            $one->game_rate = $data['game_rate'];
            if($data['password']){
               $salt = $one->salt;
               $password = Yii::$app->security->generatePasswordHash($data['password'] . $salt);
               $one->password = $password;
            }
            if($one->update()){
                $this->success([]);
            }else{
                $this->fail('操作失败');
            }
        }else{
            return $this->render('edit',[
                'item'    => $one->toArray()
            ]);
        }
    }
    
    //冻结会员账号
    public function actionFreeze()
    {
        $id = Yii::$app->request->get('id');
        $is_freeze = Yii::$app->request->get('is_freeze');
        $is_freeze = $is_freeze == 1 ? 0 : 1;
        $one = Anchor::findOne($id);
       
        $one->is_freeze = $is_freeze;
        if($one->update()){
            $this->success([]);
        }else{
            $this->fail('操作失败');
        }
    }
    
    public function actionRecord()
    {
        
    }
}
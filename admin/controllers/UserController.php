<?php
namespace admin\controllers;

use yii;
use common\models\User;
use common\models\UserFundsDeal;
use yii\data\Pagination;
use admin\controllers\Base;

class UserController extends Base
{
    public function actionList()
    {
        $data = Yii::$app->request->get('data');
        if(1 == $data){
            $page = Yii::$app->request->get('page',1);
            $limit = Yii::$app->request->get('limit',20);
            $keyword = Yii::$app->request->get('keyword');
            $search = Yii::$app->request->get('search');
            $level = Yii::$app->request->get('level');
            $type = Yii::$app->request->get('type');
            $query = User::find();
            if($keyword){
                $page = 1;
                $query->where("$search='{$keyword}'");
            }  
            if($level){
                $query->where("level=$level");
            }
            
            if($type){
                $query->where("type=$type");
            }
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                    ->orderBy('uid desc')
                    ->limit($limit)
                    ->asArray()->all();
            foreach ($models as $key=>$item){
                $item['reg_time'] = date('Y-m-d H:i:s',$item['reg_time']);
                $item['last_login_time'] = date('Y-m-d H:i:s',$item['last_login_time']);
                $item['reg_ip'] = long2ip($item['reg_ip']);
                
                $models[$key] = $item;
            }
            $data = [
                'data'  => User::fetchTitle($models, User::$field_title,2),
                'page'  => $page,
                'count' => $count,
                'limit' => $limit
            ];
            $this->success($data);
        }else{
            return $this->render('list',[
                'search_label'  => $this->html_select('search', User::$search,'mobile'),
                'level_label'   => $this->html_select('level', array_merge(['0' => '请选择VIP等级'],User::$field_title['level']),'0'),
                'type_label'   => $this->html_select('type', array_merge(['0' => '请选择类型'],User::$field_title['type']),'0')
            ]);
        }
    }
    
    //冻结会员账号
    public function actionFreeze()
    {
        $id = Yii::$app->request->get('id');
        $is_freeze = Yii::$app->request->get('is_freeze');
        $is_freeze = $is_freeze == 1 ? 0 : 1;
        $one = User::findOne($id);
        $one->is_freeze = $is_freeze;
        if($one->update()){
            $this->success([]);
        }else{
            $this->fail('操作失败');
        }
    }
    
    //添加会员账号
    public function actionAdd()
    {
        $type = Yii::$app->request->get('type');
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $model = new User();
            $time = time();
            $password = Yii::$app->security->generatePasswordHash($data['password']);
            $salt = mt_rand(000000, 999999);
            $model->mobile   = $data['mobile'];
            $model->username = $data['username'];
            $model->source   = $data['source'];
            $model->password = $password;
            $model->salt     = $salt;
            $model->image    = User::getAvatar(1);
            $model->reg_time = $time;
            $model->reg_ip = ip2long($this->clientIP());
            $model->type = $data['type'];
            $model->status = 1;
            if($model->insert()){
                $this->success($data);
            }else{
                $this->fail();
            }
        }else{
            return $this->render('add',[
                'source' => $this->html_radio('source', User::$field_title['source'],'SYSTEM'),
                'type'   => $this->html_radio('type', User::$field_title['type'],$type)
            ]);
        }
    }
    
    //编辑会员账号
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = User::findOne($id);
        if(Yii::$app->request->isPost){
            $data =  Yii::$app->request->post();
            $one->nick_name = $data['nick_name'];
            if($data['password']){
                $one->password = Yii::$app->security->generatePasswordHash($data['password']);
            }
            $amount = intval($data['change_amount']);
            if($amount){
                $deal_type = UserFundsDeal::I_SYSTEM;
                $memo = "系统奖励";
                if($amount < 0){
                    $deal_type = UserFundsDeal::O_SYSTEM;
                    $memo = "系统扣除";
                }
                if(User::balance($id,$amount,$deal_type,$memo)){
                    $this->success([]);
                }
            }
            if($one->update()){
                $this->success([]);
            }
            $this->fail();
            
        }else{
            return $this->render('edit',[
                'item'    => $one->toArray()
            ]);
        }
    }
    
     
    
    
}
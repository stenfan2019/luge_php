<?php
namespace admin\controllers;

use common\core\redis\AdminRedis;
use common\helpers\ArrayHelper;
use common\helpers\StringHelper;
use common\models\Admin;
use common\models\AdminRole;
use yii;
use common\models\Anchor;
use common\models\User;
use yii\data\Pagination;
use admin\controllers\Base;

class AdminController extends Base
{
    public function actionIndex()
    {

        $data = Yii::$app->request->get('data');
        $page = Yii::$app->request->get('page',1);
        $limit = Yii::$app->request->get('limit',self::PAGE_SIZE);
        if(1 == $data){
            $condition  = ['and'];
            $username = Yii::$app->request->get('username',false);
            $true_name = Yii::$app->request->get('true_name',false);
            if($username)
                $condition[] = ['=','username',$username];
            if($true_name)
                $condition[] = ['=','true_name',$true_name];
            $models = Admin::getAll($condition ,$page,$limit);
            $data = $models['data'];
            foreach ($data as $key => $v)
            {
                $data[$key]['role_id'] = AdminRole::getIdName($v['role_id']);
            }
            $datas = [
                'data'  => $data,
                'page'  => $page,
                'count' => $models['count'],
                'limit' => $limit
            ];
            $this->success($datas);
        }else{
            $roles = AdminRole::getId2Name();
            return $this->render('index',[
                'roles'=>$roles,
                ]);
        }
    }
    
    public function actionAdd()
    {
        if(Yii::$app->request->isPost){
            $data  =  Yii::$app->request->post();
            $data['create_admin_id'] = 1;
            $result = Admin::add($data);
            if($result){
                $this->success($result);
            }else{
                $this->fail();
            }
        }else{
            $roles = AdminRole::getId2Name();
            return $this->render('add',[
                'roles'=>$roles,
            ]);
        }
    }
    
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = Admin::findOne($id);
        if(Yii::$app->request->isPost){
            $data  =  Yii::$app->request->post();
            $one->username   = $data['username'];
            $one->true_name = $data['true_name'];
            $one->mobile = $data['mobile'];
            $one->role_id = $data['role_id'];
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
            $roles = AdminRole::getId2Name();
            return $this->render('edit',[
                'item'    => $one->toArray(),
                'roles'=>$roles,
            ]);
        }
    }
    
    public function actionPwd()
    {
        if(Yii::$app->request->isPost){
            $data  =  Yii::$app->request->post();
            $old_pwd  = $data['old_pwd'];
            if(empty($data['old_pwd'])){
                $this->fail('请填写密码');
            }
            if( empty($data['new_pwd'])){
                $this->fail('新密码不能为空');
            }
            $new_pwd = $data['new_pwd'];
            $re_pwd = $data['re_pwd'];
            if($re_pwd != $new_pwd){
                $this->fail('两次密码不一致');
            }
            $id = \admin\models\Admin::getUid();
            $one = Admin::findOne($id);
            if(!Yii::$app->security->validatePassword($old_pwd, $one->password)){
                $this->fail('旧密码错误');
            }
            $one->password = Yii::$app->security->generatePasswordHash($new_pwd );
            if($one->update()){
                $this->success([]);
            }else{
                $this->fail('操作失败');
            }
        }
        
        return $this->render('pwd');
    }

}
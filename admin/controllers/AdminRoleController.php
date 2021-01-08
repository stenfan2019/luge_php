<?php
namespace admin\controllers;

use admin\models\AdminMenu;
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

class AdminRoleController extends Base
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
            $models = AdminRole::getAll($condition ,$page,$limit);
            $data = $models['data'];

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
            $data['powers'] = json_encode($data['powers']);
//            $data['menu_powers'] = json_encode($data['menu_powers']);
            $data['create_admin_id'] = 1;
            $result = AdminRole::add($data);
            if($result){
                $this->success($result);
            }else{
                $this->fail();
            }
        }else{
            $roles = AdminRole::getId2Name();

            $allMenu = AdminMenu::getAllMenuTree();
            return $this->render('add',[
                'allMenu'=>$allMenu,

            ]);
        }
    }
    
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $one = AdminRole::findOne($id);
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $data['powers'] = json_encode($data['powers']);
//            $data['menu_powers'] = json_encode($data['menu_powers']);

            if(AdminRole::setIdData($id,$data)){
                $this->success([]);
            }else{
                $this->fail('操作失败');
            }
        }else{
            return $this->render('edit',[
                'item' => $one,
                'powers' => json_decode($one->powers,true),
                'menu_powers' => json_decode($one->menu_powers,true),
                'allMenu' => AdminMenu::getAllMenuTree(),
            ]);
        }
    }

}
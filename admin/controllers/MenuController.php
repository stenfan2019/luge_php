<?php
namespace admin\controllers;

use admin\models\AdminMenu;
use yii;
use admin\controllers\Base;
use yii\base\BaseObject;


class MenuController extends Base
{
     public function actionIndex()
     {
        $admin_menu = new AdminMenu();
        $list = $admin_menu->getMenuTree();
        return $this->render('index',['data' => $list]);
     }
     
     public function actionAdd()
     {
         $pid = Yii::$app->request->get('pid',0);
         $admin_menu = new AdminMenu();
         if(Yii::$app->request->isPost){
             $url = '';
             $level = 1;
             $data = Yii::$app->request->post();
             $admin_menu->title = $data['title'];
             $admin_menu->param = $data['param'];
             $admin_menu->pid = $data['pid'];
             $admin_menu->sort = $data['sort'];
             $admin_menu->icon = $data['icon'];
             $admin_menu->type = $data['type'];
             $admin_menu->controller = $data['controller'];
             $admin_menu->action = $data['action'];
             $admin_menu->status = 1;
             if($data['type']){
                 $url =  $data['controller'] . '/' . $data['action'] . $data['param'];
                 if ($admin_menu->checkExist($url)) {
                     $this->fail('url已经存在了');
                 }
             }
             if ($data['pid']) {
                 $level = $level + 1;
             }
             $admin_menu->url = $url;
             $admin_menu->level = $level;
             if($admin_menu->save()){
                 $this->success('添加成功');
             }else{
                 $this->fail('添加失败');
             }
             
         }else{
             $select = $admin_menu->getMenuSelect();
            
             return $this->render('add',
                 [
                     'html_select' => $this->html_select('pid', $select,$pid),
                     'html_radio'  => $this->html_radio('type', $admin_menu->field_title['type'],1)
                 ]);
         }
     }
     
     public function actionEdit()
     {
         $admin_menu = new AdminMenu();
         $id = Yii::$app->request->get('id');
         
         $one  = $admin_menu->findOne($id);
         $select = $admin_menu->getMenuSelect();
         if(empty($one)){
             $this->fail('不存在');
         }
         if(Yii::$app->request->isPost){
             $data = Yii::$app->request->post();
             $one->title      = $data['title'];
             $one->sort       = $data['sort'];
             $one->icon       = $data['icon'];
             $one->pid        = $data['pid'];
             if($data['pid'] > 0){
                 $level = 2;
                 $one->param      = $data['param'];
                 $one->type       = $data['type'];
                 $one->controller = $data['controller'];
                 $one->action     = $data['action'];
                 if($data['type']){
                     $url =  $data['controller'] . '/' . $data['action'] . $data['param'];
                 }
                 if ($data['pid']) {
                     $level = $level + 1;
                 }
                 $one->url = $url;
                 $one->level = $level;
             }
             $one->update();
             
             $this->success('success');
         }else{
             $pid  = $one->pid;
             $type = $one->type;
             return $this->render('edit',
                 [
                     'html_select' => $this->html_select('pid', $select,"$pid"),
                     'item'        => $one->toArray(),
                     'html_radio'  => $this->html_radio('type', $admin_menu->field_title['type'],"$type")
                 ]
             );
         }
     }
     
     public function actionDel()
     {
         $admin_menu = new AdminMenu();
         $id = Yii::$app->request->get('id');
         $one  = $admin_menu->findOne($id);
         if(empty($one)){
             $this->fail('不存在');
         }
         $one->delete();
         $this->success('删除失败');
     }
}
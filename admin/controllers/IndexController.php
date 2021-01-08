<?php
namespace admin\controllers;

use admin\models\Admin;
use admin\models\AdminMenu;
use common\models\AdminRole;
use yii;
use admin\controllers\Base;


class IndexController extends Base
{
   
    
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
       $admin_menu = new AdminMenu();
       $data = $admin_menu->getMenu();
//        print_r(Admin::getAdminInfo());exit;
       $adminInfo  = Admin::getAdminInfo();
       $uid = $adminInfo['id'];
       $adminRole = AdminRole::getUidPowers($adminInfo['role_id']);
       $menu = [];
       if($uid ==1)
       {
           $menu = $data;
       }else{
//           echo "<pre>";
//           print_r($data);exit;
           foreach ($data as $dk => $dv)
           {
               if(key_exists($dv['id'],$adminRole))
               {
                   $pidInfo = $dv;
                   unset($pidInfo['child']);
                   $menu[$dk] = $pidInfo;
                   if(isset($dv['child']))
                   {
                       foreach ($dv['child'] as $item =>$val)
                       {
                           if(key_exists($val['id'],$adminRole[$dk]))
                           {
                               $menu[$dk]['child'][$item] = $val;
                           }
                       }
                   }

               }
           }
       }
       return $this->render('index',
           [
               'menus' => $menu,
               'adminInfo' => $adminInfo
               
           ]);
    }
    
    public function actionMain()
    {
        $this->layout = false;
        return $this->render('main');
    }
    
    public function actionRoom()
    {
      
        $roomModel = new RoomModel();
        $data = $roomModel->getIndexRoom();
        $oss_url = Yii::$app->params['oss_url'];

        foreach ($data as $key=>$item){
            $data[$key]['show_pic'] = $oss_url . $data[$key]['show_pic'];
            $data[$key]['avatar'] = $oss_url . $data[$key]['avatar'];
            $data[$key]['category_title'] = '娱乐直播';
            $data[$key]['hot'] = mt_rand(100, 2000);
        }
        $this->success($data);
    }
    
    /**
     * 首页推荐游戏
     * @stenfan
     */
    public function actionGame()
    {
        $data = \common\models\Lottery::find()
              ->where(['status' => 1,'is_index'=>1])->orderBy('sort ASC')->asArray()->all();
        $oss_url = Yii::$app->params['oss_url'];
        foreach ($data as $key=>$item){
            $data[$key]['icon_url'] = $oss_url . $data[$key]['icon_url'];
           
        }
        $this->success($data);
    }



    
    
}
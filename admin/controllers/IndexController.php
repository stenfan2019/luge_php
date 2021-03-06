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
     
    
}
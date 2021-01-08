<?php
namespace console\controllers;

use common\core\Controller;
use common\models\Active;
use common\models\User;
use common\models\UserDay;
use common\models\UserLevel;
use Yii;


class DataController extends Controller
{


    /**
     * 等级晋升
     * @author mike
     * @date 2020-12-11
     */
    public function actionSetLevel()
    {
        $list = User::getTodayActiveUser();
        $levels = UserLevel::find()->orderBy('id DESC')->all();
        foreach ($list as $user)
        {
            foreach ($levels as $level)
            {
                if($level->score >0 && $user->give_gift>=$level->score)
                {
                    $user->live_level= $level->id;
                    if($user->save())
                    {
                        echo $user->username."晋升等级为：".$level->id.PHP_EOL;
                    }
                    break 1;
                }
            }
        }
    }


    /**
     * 计算用户每日数据
     * @author mike
     * @date 2020-12-25
     */
    public function actionUserDay(){
        $res = UserDay::computeData();
        print_r($res);
    }

    
}
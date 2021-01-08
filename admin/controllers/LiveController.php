<?php
namespace admin\controllers;

use yii;
use common\models\UserLevel;
use admin\controllers\Base;

class LiveController extends Base
{
    
    public function actionLevel()
    {
        return $this->render('level',['data' => UserLevel::find()->asArray()->all()]);
    }
}
<?php
namespace frontend\controllers;
use yii\web\Controller;

class UsersController extends Controller
{
    public $layout = false;
    public $now_nav = 'home';
    public $seo_title = "在線成人視頻";
    
    public function actionTest()
    {
        echo 'ddddd';
        exit;
    }
    
    public function actionReg()
    {
        
        return $this->render('reg');
    }
}

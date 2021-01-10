<?php
namespace frontend\controllers;
use yii\web\Controller;

class VideoController extends Controller
{
    public $layout = 'main1';
    public $now_nav = 'home';
    public function actionDetail()
    {
        return $this->render('detail1');
    }
}

<?php
namespace frontend\controllers;
use yii\web\Controller;
use yii;
class SiteController extends Controller
{
    public $layout = false;
    public function actionError()
    {
        return  $this->render('error');
    }
    
    
    
}
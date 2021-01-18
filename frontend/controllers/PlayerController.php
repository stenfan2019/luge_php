<?php
namespace frontend\controllers;
use frontend\controllers\Base;
use yii;
class PlayerController extends Base
{
    public $layout = false;
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionPrestrain()
    {
        return $this->render('prestrain');
    }
}

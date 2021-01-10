<?php
namespace frontend\controllers;
use yii\web\Controller;

class PlayerController extends Controller
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

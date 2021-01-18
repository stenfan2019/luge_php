<?php
namespace frontend\controllers;
use frontend\controllers\Base;
use yii;

class AboutController extends Base
{
    /**
     * @var string
     */
    public $layout = 'main';

    public function actionContact()
    {
        //phpinfo();
        return $this->render('contact');
    }
    
    public function actionTest()
    {
        echo 'test';
        exit;
    }
    
}

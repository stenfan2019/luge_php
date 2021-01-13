<?php
namespace frontend\controllers;
use yii\web\Controller;
use common\models\Video;

class VideoController extends Controller
{
    public $layout = 'main1';
    public $now_nav = 'home';
    public $seo_title;
    public function actionDetail($id)
    {
        $one = Video::findOne($id);
        if(empty($one)){
            
        }
        $this->seo_title = $one->title;
        return $this->render('detail1');
    }
}

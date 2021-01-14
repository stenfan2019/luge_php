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
            header("Location:/");
            exit;
        }
        $this->seo_title = $one->title;
        
        //获取视频推荐
        $list = Video::find()->where('is_vip=1')->orderBy('hit_num desc')->limit(20)->asArray()->all();
        return $this->render('detail1',[
               'video' => $one->toArray(),
               'lists' => $list
        ]);
    }
}

<?php
namespace frontend\controllers;
use yii\web\Controller;
use common\models\Video;
use frontend\controllers\Base;
use yii;

class VideoController extends Base
{
    public $layout = 'main1';
    public $now_nav = 'home';
    public $seo_title = "在線成人視頻";
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
    
    public function actionSearch()
    {
        $wd  = Yii::$app->request->get('wd');
        if(empty($wd)){
            header('Location: /');
        }
        
        $list = Video::find()->where("is_show=1 and title like '%$wd%'")
              ->orderBy('update_time desc')->limit(60)->asArray()->all();
        return $this->render('search',[
            'sub_title'   => "關鍵詞:$wd",
            'videos'      => $list
        ]);
    }
}

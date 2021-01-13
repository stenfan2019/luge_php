<?php
namespace frontend\controllers;
use yii\web\Controller;
use common\models\Video;

class IndexController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'main1';
    
    public $now_nav = 'home';
    
    public $seo_title = "在線成人視頻";

    public function actionIndex()
    {
         $this->now_nav = 'home';
        return $this->render('index');
    }
    
    //最近更新
    public function actionZjgx()
    {
        return $this->_videolist(4,'zjgx','最近更新');
       
    }
    
    //精选
    public function actionJingxuan()
    {
        return $this->_videolist(4,'jx','精選系列');
        
    }
    
    //中文字幕
    public function actionZwzm()
    {
        return $this->_videolist(4,'zwzm','中文字幕');
       
    }
    
    
    //亚洲无码
    public function actionYzwm()
    {
       return $this->_videolist(4,'yzwm','亞洲無碼');
      
    }
    
    //亚洲有码
    public function actionYzym()
    {
       return $this->_videolist(4,'yzym','亞洲有碼');
    }
    //无码破解
    public function actionWmpj()
    {
       return $this->_videolist(4,'wmpj','無碼破解');
    }
    //偷拍自拍
    public function actionTpzp()
    {
        return $this->_videolist(4,'tpzp','偷拍自拍');
         
    }
    
    //网红
    public function actionWh()
    {
        return $this->_videolist(4,'wh','網紅');
        
    }
    
    //主播
    public function actionZhubo()
    {
        return $this->_videolist(4,'zb','主播');
       
    }
    
    //明星
    public function actionStar()
    {
        return $this->_videolist(4,'mx','明星');
    }
    
    //主播
    public function actionSanji()
    {
       return $this->_videolist(4,'sj','三級');
    }
    
    //欧美
    public function actionOumei()
    {
        return $this->_videolist(4,'om','歐美');
        
    }
    
    //动漫
    public function actionDongman()
    {
        return $this->_videolist(4,'dm','動漫');
        
    }
    
    protected function _videolist($cate_id,$now_nav,$sub_title)
    {
        $this->now_nav = $now_nav;
        $this->seo_title = $sub_title;
        $list = Video::find()->where("cate_id=$cate_id")
              ->orderBy('update_time desc')->limit(60)->asArray()->all();
         
       return  $this->render('list',[
            'sub_title'   => $sub_title,
            'cate_id'     => $cate_id,
            'videos'      =>  $list
        ]);
    }
}

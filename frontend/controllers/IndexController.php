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
        return $this->render('index',[
            'lists_16'  => $this->getVideoList(16,4),//免费
            'lists_02'  => $this->getVideoList(2,8),//精选
            'lists_01'  => $this->getVideoList(1,8),//中文字幕
            'lists_03'  => $this->getVideoList(3,8),//亞洲無碼
            'lists_04'  => $this->getVideoList(4,8),//亞洲有碼
            'lists_05'  => $this->getVideoList(5,8),//無碼破解
            'lists_06'  => $this->getVideoList(6,8),//偷拍自拍
            'lists_07'  => $this->getVideoList(7,8),//網紅
            'lists_08'  => $this->getVideoList(8,8),//主播            
            'lists_12'  => $this->getVideoList(12,8),//明星
            'lists_13'  => $this->getVideoList(13,8),//三级
            'lists_14'  => $this->getVideoList(14,8),//欧美
            'lists_15'  => $this->getVideoList(15,8),//动漫
        ]);
    }
    
    //最近更新
    public function actionZjgx()
    {
        $this->now_nav = 'zjgx';
        $this->seo_title = '最近更新';
        $list = Video::find()->where("is_show=1")
                ->orderBy('update_time desc')->limit(60)->asArray()->all();
         
        return  $this->render('list',[
            'sub_title'   => '最近更新',
            'cate_id'     => 4,
            'videos'      =>  $list
        ]);
    }
    
    //中文字幕
    public function actionZwzm()
    {
        return $this->_videolist(1,'zwzm','中文字幕');
    }
    
    //精选
    public function actionJingxuan()
    {
        return $this->_videolist(2,'jx','精選系列');
    }
    
    //亚洲无码
    public function actionYzwm()
    {
       return $this->_videolist(3,'yzwm','亞洲無碼');
      
    }
    
    //亚洲有码
    public function actionYzym()
    {
       return $this->_videolist(4,'yzym','亞洲有碼');
    }
    //无码破解
    public function actionWmpj()
    {
       return $this->_videolist(5,'wmpj','無碼破解');
    }
    //偷拍自拍
    public function actionTpzp()
    {
        return $this->_videolist(6,'tpzp','偷拍自拍');
    }
    
    //网红
    public function actionWh()
    {
        return $this->_videolist(7,'wh','網紅');
        
    }
    
    //主播
    public function actionZhubo()
    {
        return $this->_videolist(8,'zb','主播');
    }
    
    //明星
    public function actionStar()
    {
        return $this->_videolist(12,'mx','明星');
    }
    
    //主播
    public function actionSanji()
    {
       return $this->_videolist(13,'sj','三級');
    }
    
    //欧美
    public function actionOumei()
    {
        return $this->_videolist(14,'om','歐美');
        
    }
    
    //动漫
    public function actionDongman()
    {
        return $this->_videolist(15,'dm','動漫');
        
    }
    
    protected function _videolist($cate_id,$now_nav,$sub_title)
    {
        $this->now_nav = $now_nav;
        $this->seo_title = $sub_title;
        return  $this->render('list',[
            'sub_title'   => $sub_title,
            'cate_id'     => $cate_id,
            'videos'      => $this->getVideoList($cate_id,60)
        ]);
    }
    
    protected function getVideoList($cate_id,$limit=60)
    {
        $list = Video::find()->where("is_show=1 and cate_id=$cate_id")
                ->orderBy('update_time desc')->limit($limit)->asArray()->all();
        return $list;
    }
}

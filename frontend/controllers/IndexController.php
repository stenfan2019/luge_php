<?php
namespace frontend\controllers;
use Yii;
use common\models\Video;
use frontend\controllers\Base;
use yii\data\Pagination;

class IndexController extends Base
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
            'lists_16'  => $this->getVideoList(6,58),//免费
            'lists_02'  => '',//$this->getVideoList(2,8),//精选
            'lists_01'  => '',//$this->getVideoList(1,8),//中文字幕
            'lists_03'  => '',//$this->getVideoList(3,8),//亞洲無碼
            'lists_04'  => '',//$this->getVideoList(4,8),//亞洲有碼
            'lists_05'  => '',//$this->getVideoList(5,8),//無碼破解
            'lists_06'  => '',//$this->getVideoList(6,8),//偷拍自拍
            'lists_07'  => '',//$this->getVideoList(7,8),//網紅
            'lists_08'  => '',//$this->getVideoList(8,8),//主播            
            'lists_12'  => '',//$this->getVideoList(12,8),//明星
            'lists_13'  => '',//$this->getVideoList(13,8),//三级
            'lists_14'  => '',//$this->getVideoList(14,8),//欧美
            'lists_15'  => '',//$this->getVideoList(15,8),//动漫
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
            'videos'      => $list
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
        $cate_id = 6;
        $seo_title = '偷拍自拍';
        $this->now_nav = 'tpzp';
        $this->seo_title = $seo_title;
        return  $this->render('list',[
            'sub_title'   => $seo_title,
            'cate_id'     => $cate_id,
            'videos'      => $this->getVideoListOrderByTime($cate_id,60)
        ]);
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
    
    //data
    public function actionDataPage()
    {
        $page = Yii::$app->request->getQueryParam('page',0);
        $limit = Yii::$app->request->getQueryParam('limit',20);
        $cate_id = Yii::$app->request->getQueryParam('cid',0);
        if($page){
            $query = Video::find()->where("is_show=1");
                   
            if($cate_id){
                $query->andWhere("cate_id=$cate_id");
            }
            $countQuery = clone $query;
            $count = $countQuery->count();
            $page_num = ceil($count / $limit);
            $pages = new Pagination(['totalCount' => $count,'defaultPageSize'=>$limit,'page'=>$page-1]);
            $models = $query->offset($pages->offset)
                        ->orderBy('create_time desc')
                        ->limit($limit)
                        ->asArray()->all();
           $html = '';
           foreach ($models as $item){
               $html = $html .'<div class="col-style d-4 m-2 lazy loaded">';
               $html = $html .'<a href="/detail_' . $item['id'] . '.html"  target="_blank"';
               $html = $html .' class="videoBox md-opjjpmhoiojifppkkcdabiobhakljdgm_doc">';
               $html = $html .' <div class="videoBox_wrap">';
               $html = $html .' <div class="videoBox-cover"';
               $html = $html .' style="background-image: url(' . $this->res_image . $item['images'] . ');"></div>';
               $html = $html .' </div>';
               $html = $html .' <div class="videoBox-info">';
               $html = $html .' <span class="title">' . $item['title'] . '</span>';
               $html = $html .' </div>';
               $html = $html .' <div class="videoBox-action">';
               $html = $html .' <span class="views"><i class="fa fa-eye"></i><span class="number">' . $item['hit_num'] . '</span></span>';
               $html = $html .' <span class="likes"><i class="fa fa-heart"></i><span class="number">' . $item['up_num'] . '</span></span>';
               $html = $html .' </div>';
               $html = $html .' </a>';
               $html = $html .' </div>';
          }
          echo $html;
          exit;
        }
        echo $page;
    }
    
    protected function _videolist($cate_id,$now_nav,$sub_title)
    {
        $this->now_nav = $now_nav;
        $this->seo_title = $sub_title;
        return  $this->render('list',[
            'sub_title'   => $sub_title,
            'cate_id'     => $cate_id,
            'videos'      => $this->getVideoList($cate_id,20)
        ]);
    }
    
    protected function getVideoListOrderByTime($cate_id,$limit=60)
    {
        $list = Video::find()->where("is_show=1 and cate_id=$cate_id")
                       ->orderBy('create_time desc')->limit($limit)->asArray()->all();
        return $list;
    }
    
    protected function getVideoList($cate_id,$limit=60)
    {
        $list = Video::find()->where("is_show=1 and cate_id=$cate_id")
                ->orderBy('hit_num desc')->limit($limit)->asArray()->all();
        return $list;
    }
}

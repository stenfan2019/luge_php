<?php
namespace frontend\controllers;
use yii\web\Controller;

class IndexController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'main1';
    
    public $now_nav = 'home';

    public function actionIndex()
    {
         $this->now_nav = 'home';
        return $this->render('index');
    }
    
    //最近更新
    public function actionZjgx()
    {
        $this->now_nav = 'zjgx';
        return $this->render('list',[
            'sub_title'   => '最近更新'
            
        ]);
    }
    
    //精选
    public function actionJingxuan()
    {
        $this->now_nav = 'jx';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    
    //中文字幕
    public function actionZwzm()
    {
        $this->now_nav = 'zwzm';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    
    
    //亚洲无码
    public function actionYzwm()
    {
       $this->now_nav = 'yzwm';
       return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    
    //亚洲有码
    public function actionYzym()
    {
        $this->now_nav = 'yzym';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    //无码破解
    public function actionWmpj()
    {
        $this->now_nav = 'wmpj';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    //偷拍自拍
    public function actionTpzp()
    {
        $this->now_nav = 'tpzp';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    
    //网红
    public function actionWh()
    {
        $this->now_nav = 'wh';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    
    //主播
    public function actionZhubo()
    {
        $this->now_nav = 'zb';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    
    //明星
    public function actionStar()
    {
        $this->now_nav = 'mx';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    
    //主播
    public function actionSanji()
    {
        $this->now_nav = 'sj';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    
    //欧美
    public function actionOumei()
    {
        $this->now_nav = 'om';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
    
    //动漫
    public function actionDongman()
    {
        $this->now_nav = 'dm';
        return $this->render('list',[
            'sub_title'   => '最近更新'
        ]);
    }
}

<?php
namespace frontend\controllers;
use yii;
use frontend\controllers\Base;

class MemberController extends Base
{
    public $layout = 'main1';
    public $now_nav = 'home';
    public $seo_title = "個人收藏";
    
    public function actionFavs()
    {
        if(empty($this->uid)){
            header('Location: /login.html');
            exit;
        }
        return  $this->render('favs',[
            'lists' => []
        ]);
    }
}
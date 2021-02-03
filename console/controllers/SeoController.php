<?php
namespace console\controllers;

use yii\console\Controller;
use common\models\Video;

/**
 * SEO
 *
 * @author stenfan       
 *        
 */
class SeoController extends Controller
{
    public function actionSitemap()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml = $xml . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $all = Video::find()->limit(10)->asArray()->all();
        $date = date('Y-m-d');
        foreach ($all as $item){
            $id = $item['id'];
            $xml = $xml . '<url>';
            $xml = $xml . "<loc>https://www.lugetv.info/detail_$id.html</loc>";
            $xml = $xml . "<lastmod>$date</lastmod>";
            $xml = $xml . '</url>';
        }
        $xml = $xml . '</urlset>';
        $file = 'frontend/web/google.xml';
        file_put_contents($file, $xml);
        
    }
}
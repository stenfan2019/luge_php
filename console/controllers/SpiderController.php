<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\SpVideo;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

/**
 * 爬虫脚本
 * @author stenfan
 * @do php yii sendprize 100
 */
class SpiderController extends Controller
{
    public function actionIndex()
    {
        $url = 'https://www.hxcsxs.org/index.php/ajax/data.html';
        $params = [ 
                'mid'   => '1',
                'page'  => '1',
                'limit' => '20',
                'by'    => 'vod_time'
        ];
        $str = $this->getPostData($url, $params);
        $data = json_decode($str,true);
        $pagecount = $data['pagecount'];
        $code = $data['code'];
        if($code == 1){
            for ($page=1;$page<=$pagecount;$page++){
                $params['page'] = $page;
                $str = $this->getPostData($url, $params);
                $data = json_decode($str,true);
                $list = $data['list'];
                if($list){
                    foreach ($list as $item){
                        $spvideo = new SpVideo(); 
                        $spvideo->third_id     = $item['vod_id'];
                        $spvideo->type_id      = $item['type_id'];
                        $spvideo->vod_name     = $item['vod_name'];
                        $spvideo->vod_pic      = $item['vod_pic'];
                        $spvideo->vod_hits     = $item['vod_hits'];
                        $spvideo->vod_up       = $item['vod_up'];
                        $spvideo->vod_down     = $item['vod_down'];
                        $spvideo->vod_time     = $item['vod_time'];
                        $spvideo->type_name    = $item['type']['type_name'];
                        $video_url = "https://www.hxcsxs.org/index.php/vod/play/id" . $item['vod_id'] . '/sid/1/nid/1.html';
                        $spvideo->url          = $video_url;
                        $spvideo->video_url    = '';
                        $spvideo->vod_time_add = $item['vod_time_add'];
                        $spvideo->insert();
                    }
                }
                echo "=======$page=====" . PHP_EOL;
            }
        }
    }
    
    public function actionOne()
    {
        $url = 'https://www.hxcsxs.org/index.php/vod/play/id/7748/sid/1/nid/1.html';
        $this->getVideoUrl($url);
    }
    
    
    protected function getPostData($url,$params)
    {
        $client = new Client();
        $response = $client->post($url, [
            'form_params' => $params,
            'headers' => [
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4173.2 Safari/537.36',
                'referer'    => 'https://www.hxcsxs.org/index.php/vod/type/id/2.html',
                'accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'upgrade-insecure-requests' => '1',
            
                'Cookie' => 'user_id=7543; user_name=stenfan; group_id=3; group_name=VIP%E4%BC%9A%E5%91%98; user_check=1ffeb39418a227841801589a544c9496; user_portrait=%2Fstatic%2Fimages%2Ftouxiang.png; Hm_lvt_ef7d69b0d8afbcf82c7fd9048fc1d037=1610158997,1610243548; Hm_lpvt_ef7d69b0d8afbcf82c7fd9048fc1d037=1610244340',
            ]
        ]);
        $body = $response->getBody(); //获取响应体，对象
        $bodyStr = (string)$body; //对象转字串
        return $bodyStr;
    }
    
    protected function getVideoUrl($url)
    {
        $client = new Client();
        
        $response = $client->request('GET', $url,[
            'headers' => [
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4173.2 Safari/537.36',
                'referer'    => 'https://www.hxcsxs.org/index.php/vod/type/id/2.html',
                'accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'upgrade-insecure-requests' => '1',
                
                'Cookie' => 'user_id=7543; user_name=stenfan; group_id=3; group_name=VIP%E4%BC%9A%E5%91%98; user_check=1ffeb39418a227841801589a544c9496; user_portrait=%2Fstatic%2Fimages%2Ftouxiang.png; Hm_lvt_ef7d69b0d8afbcf82c7fd9048fc1d037=1610158997,1610243548; Hm_lpvt_ef7d69b0d8afbcf82c7fd9048fc1d037=1610244340',
             ]
            
        ]);
        $body = $response->getBody(); //获取响应体，对象
        $newCookies = $response->getHeaders();
       // print_r($newCookies);
        $bodyStr = (string)$body;
        print_r($bodyStr);
        exit;
        
    }
}
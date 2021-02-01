<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use QL\QueryList;
use common\models\SpVideo;
use common\models\Video;

/**
 * www.asianssex.com 采集视频
 *
 * @author stenfan
 *         php yii hbaorebot
 */
class AsianssexController extends Controller
{

    protected $page = 160;
    public function actionCaiji()
    {
        echo "=====开始采集数据======\n";
        $page = $this->page;
        $url = "https://asianssex.com/most-viewed/page{$page}.html";
        $this->_caiji($url);
        echo "=====采集结束======\n";
        
    }

    protected function _caiji($url)
    {
        
        echo "=====开始采集{$this->page}页\n";
        ini_set('date.timezone', 'Asia/Shanghai');
        $date = date('Y-m-d H:i:s');
        $html = file_get_contents($url);
        $data = QueryList::html($html)->rules([ // 设置采集规则
                                                 // 采集所有a标签的href属性
            'link' => [
                'a',
                'href'
            ],
            'mp4' => [
                'a',
                'href',
                '',
                function ($content) {
                    if (strstr($content, 'video', true)) {
                        $rs = QueryList::get($content)->find('source ')
                            ->attrs('src')
                            ->all();
                        return empty($rs) ? $content : $rs[0];
                    }
                    return '';
                }
            ],
            // 图片
            "img" => [
                '.image>img',
                'src'
            ],
            // 标题：
            "title" => [
                '.image>img',
                'alt'
            ],
            // 时间
            'time' => [
                '.time',
                'text'
            ],
            // 好评
            'hpin' => [
                '.s-e-rate>.sub-desc',
                'text'
            ],

            // 浏览量
            'view' => [
                '.s-e-views>.sub-desc',
                'text'
            ]
        ])
            ->range('.item-inner-col')
            ->query()
            ->getData();

        // 打印结果
        foreach ($data as $k => $item) {
            $link = $item['link'];
            $img = $item['img'];
            $title = $item['title'];
            $time = $item['time'];
            $hpin = intval($item['hpin']);
            $view = intval($item['view']);
            $mp4 = $item['mp4'];
            if ($link && $img && $title && $time && $hpin && $view && $mp4) {
                $spvideo = new SpVideo();
                $pattern = '/(\d+\.?\d+)/';
                $third_id = 0;
                if (preg_match_all($pattern, $link, $match)) {
                    $third_id = $match[0][0];
                }
                $spvideo->third_id = $third_id;
                $spvideo->type_id = 6;
                $spvideo->vod_name = $title;
                $info = pathinfo($img);
                $pic = $info['dirname'] . '/' . $info['filename'] . 'b.' . $info['extension'];
                // $video_url = str_replace('thumbs','videos',$info['dirname']);
                $spvideo->vod_pic = $pic;
                $spvideo->vod_hits = $view;
                $vod_up = ceil($view * $hpin / 100);
                $spvideo->vod_up = $vod_up;

                $spvideo->vod_down = 0;
                $spvideo->vod_time = $time;
                $spvideo->url = $link;
                $spvideo->video_url = $mp4;
                $spvideo->vod_time_add = $date;
                $spvideo->is_yy = 0;
                $spvideo->save();
            }
        }
        
        if($this->page > 0){
            $this->page = $this->page - 1;
            $page = $this->page;
            $url = "https://asianssex.com/most-viewed/page{$page}.html";
            $this->_caiji($url);
        }
    }
    
    //下载
    public function actionDown()
    {
        ini_set('date.timezone', 'Asia/Shanghai');
        $date = date('ymd');
        $image_save_path = '/data/www/thumbs/' . $date;
        $video_save_path = '/data/www/videos/' . $date;
        
        $list = SpVideo::find()->where(['is_do' => '0'])->limit(100)->orderBy('id ASC')->asArray()->all();
        foreach ($list as $item)
        {
            $id = $item['id'];
            //下载图片
            $vod_pic = $item['vod_pic'];
            $info = pathinfo($vod_pic);
            $new_image = $date . '/' . $info['basename'];
            $ml = "wget -P $image_save_path {$vod_pic}";
            echo exec($ml);
            
            //下载视频
            $video_url = $item['video_url'];
            $info = pathinfo($video_url);
            $new_video = $date . '/' . $info['basename'];
            $ml = "wget -P $video_save_path {$video_url}";
            echo exec($ml);
            
            $one = SpVideo::findOne($id);
            $one->image_path = $new_image;
            $one->video_path = $new_video;
            $one->is_do =1;
            $one->update();
        }
    }
    
    public function actionToyy()
    {
        $list = SpVideo::find()->where("is_yy=0 and is_do=1")->limit(100)->orderBy('id ASC')->asArray()->all();
        foreach ($list as $item){
            $id = $item['id'];
            $one = SpVideo::findOne($id);
            $video = new Video();
            $date = date('Y-m-d H:i:s');
            $video->title = $one->vod_name;
            $video->cate_id = $one->type_id;
            $video->cate_name = $one->type_name;
            $video->is_vip = 1;
            $video->is_hd = 1;
            $video->hit_num = $one->vod_hits;
            $video->up_num = $one->vod_up;
            $video->down_num = $one->vod_down;
            $video->images = $one->image_path;
            $video->video_url = $one->video_path;
            $video->images_type = '11';
            $video->video_type = '11';
            $video->create_time = $one->vod_time_add;
            $video->update_time = $date;
            $video->third_type = $one->id;
            if($video->save()){
                $one->is_yy = 1;
                $one->update();
                $this->success([]);
            }
        }
    }
}
<?php
namespace admin\controllers;

use admin\models\Admin;
use Yii;
use yii\helpers\ArrayHelper;
use GuzzleHttp\Client;

class Base extends \yii\web\Controller
{
    public $controllerNamespace = 'admin\modules';

    public $enableCsrfValidation = false;
    
    public $openLoginCheck = true;
    
    public $token_key;
    
    public $token ;
    
    public $userInfo;
    
    public $layout = '@app/views/layouts/main.php';
    
    public $layui_key;
    
    public $layui_val;
    
    public $parames ;

    //20条每页
    const PAGE_SIZE = 20;


    public function init()
    {
        parent::init();
        if($this->openLoginCheck)
        {
            return $this->checkLogin();
        }
        
    }


    /**
     * @name 错误信息
     * @param string $message 错误信息
     * @param array $data 错误数据
     * @param int $code 状态码
     * @return 
     * @author stenfan
     * @date 2020-08-09
     */
    protected function fail($message = 'fail', $code='400', $data =[])
    {
        Yii::$app->response->statusCode = $code;
        $rs_data = array(
            'code' => $code,
            'msg'   => $message,
            'data'  => $data
        );
       
        Yii::$app->response->statusCode = 200;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->data   =  $rs_data;
        Yii::$app->response->send();
        exit();
    }

    /**
     * @name 成功返回
     * @param string $message
     * @param array $data
     * @return array
     * @author stenfan
     * @date 2020-08-09
     */
    protected function success($data =[],$message = 'success')
    {
        $return_data['data'] = $data;
        $return_data['msg'] = $message;
        $return_data['code'] = 0;
        Yii::$app->response->statusCode = 200;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->data =  $return_data;
        Yii::$app->response->send();
        exit();
    }


    /**
     * ----------------------------------------------
     * 默认跳转操作 支持错误导向和正确跳转
     * 调用模板显示 默认为public目录下面的success页面
     * 提示页面为可配置 支持模板标签
     * @param string $message 提示信息
     * @param int $status 状态
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @access private
     * @return void
     * ----------------------------------------------
     */
    private function location($jumpUrl, $message, $status = 1, $ajax = false)
    {
        $success_file = '@admin/views/layouts/success.php';
        $error_file = '@admin/views/layouts/error.php';
        $jumpUrl = !empty($jumpUrl) ? (is_array($jumpUrl) ? \yii\helpers\Url::toRoute($jumpUrl) : $jumpUrl) : '';

        if (true === $ajax || Yii::$app->request->isAjax) {// AJAX提交
            $data = is_array($ajax) ? $ajax : array();
            $data['info'] = $message;
            $data['status'] = $status;
            $data['url'] = $jumpUrl;
            $this->ajaxReturn($data);
        }
        // 成功操作后默认停留1秒
        $waitSecond = 1;

        if ($status) { //发送成功信息
            $message = $message ? $message : '提交成功';// 提示信息
            // 默认操作成功自动返回操作前页面
            echo $this->renderFile($success_file, [
                'message' => $message,
                'waitSecond' => $waitSecond,
                'jumpUrl' => $jumpUrl,
            ]);
        } else {
            $message = $message ? $message : '出错了';// 提示信息

            // 默认发生错误的话自动返回上页
            $jumpUrl = !empty($jumpUrl) ? (is_array($jumpUrl) ? \yii\helpers\Url::toRoute($jumpUrl) : $jumpUrl) : '';

            echo $this->renderFile($error_file, [
                'message' => $message,
                'waitSecond' => $waitSecond,
                'jumpUrl' => $jumpUrl,
            ]);
        }
        //Yii::$app->end();
        exit;
    }


    /**
     * ------------------------------------------------
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @return void
     * ------------------------------------------------
     */
    protected function ajaxReturn($data)
    {
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data);
        //Yii::$app->end();
        exit;
    }



    protected function checkLogin()
    {
        if(!Admin::getUid()){

            return $this->location('/login','请登录',false);
        }

    }
    
    /**
     * 版本号
     * @return multitype:string
     */
    private function version() 
    {
        return [ 'sversion' => 'V1.0.11'];
    
    }
    
    Public function clientIP()
    {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }
    
    protected function _http()
    {
        $url = Yii::$app->request->hostInfo . '/upload/img';
        $r_data = [
            'strToken' => \Yii::$app->request->headers->get('Authorization'),
            'expire'   => date('Y-m-d H:i:s',strtotime('+1 days')),
            'api_url'  => $url
        ];
        return $r_data;
    }
    
    protected function _apiPage($models,$pagination,$page_size,$page)
    {
        $data['list'] = $models;
        $count = $pagination->totalCount;
        $data['page']['total'] = $count;
        $data['page']['pageSize'] = $page_size;
        $data['page']['page'] = $page+1;
        $data['page']['pageTotal'] = ceil($count / $page_size);
        return $data;
    }
    
    
    
    public function _createOrderNumber()
    {
        return date('ymdHis',time()) . mt_rand(10000, 99999);
    }
    
    
    public function html_select($id, $array, $selected = '', $more = '')
    {
        $html = "<div class=\"layui-input-inline\"><select lay-filter=\"select_{$id}\" name=\"{$id}\" id=\"{$id}\">";
    
        if (is_array($array)) {
            if ($more) {
                $add_array = [
                    '' => $more
                ];
                //$array = array_merge($add_array, $array);
                $array = $add_array + $array;
                //reset($array);
            }
            if ($selected == '') {
                $selected_key = key($array);
            } else {
                $selected_key = $selected;
            }
    
            foreach ($array as $k => $v) {
                if ($selected_key === (string)$k) {
                    $selected_attr = ' selected ';
                } else {
                    $selected_attr = '';
                }
                $html .= "<option value=\"$k\" {$selected_attr}>{$v}</option>";
            }
        }
        $html .= "</select></div>";
        return $html;
    }
    
    public function html_radio($name, $array, $selected = '')
    {
        $html = "<div class=\"layui-input-block\">";
    
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $bind_key = "radio_{$name}_{$k}";
                if ($selected != '' && $selected == $k) {
                    $selected_attr = ' checked="" ';
                } else {
                    $selected_attr = '';
                }
                $html .= "<input type=\"radio\" name=\"$name\" value=\"$k\" lay-filter=\"$bind_key\" title=\"$v\" {$selected_attr}>";
            }
        }
        $html .= "</div>";
        return $html;
    }
    
    public function html_switch($name, $array, $selected = '')
    {
         
        $html = "<div class=\"layui-input-block\">";
    
        if (count($array) == 2) {
            arsort($array);
    
            $yes_key = key($array);
            $yes = current($array);
            $no = next($array);
            $text = $yes . '|' . $no;
            $bind_key = "switch_{$name}_{$yes_key}";
    
            if ($selected != '' && $selected == $yes_key) {
                //if ($selected != '' && in_array($yes_key, $selected)) {
                $selected_attr = ' checked="" ';
            } else {
                $selected_attr = '';
            }
             
    
            $html .= "<input type=\"checkbox\" name=\"$name\" value=\"$yes_key\" lay-skin=\"switch\" lay-text=\"$text\" lay-filter=\"$bind_key\" {$selected_attr}>";
        }
    
        $html .= "</div>";
        return $html;
    }
    
    public function html_checkbox($name, $array, $selected = '', $skin = 'primary')
    {
        $html = "<div class=\"layui-input-block\">";
        if (is_array($array)) {
            $selected_array = $selected != '' ? explode(",", $selected) : [];
            foreach ($array as $k => $v) {
                $bind_key = "checkbox_{$name}_{$k}";
                if (in_array($k, $selected_array)) {
                    $selected_attr = ' checked ';
                } else {
                    $selected_attr = '';
                }
                $html .= "<input value=\"$k\" type=\"checkbox\" name=\"{$name}[]\" lay-skin=\"$skin\" lay-filter=\"$bind_key\" title=\"$v\" {$selected_attr}>";
            }
        }
        $html .= "</select></div>";
        return $html;
    }
    
    
    
    /*
     * 自定义下拉菜单 带搜索框 html控件
     */
    public function html_select_search($id, $array, $selected = '', $more = '')
    {
        $html = "<div class=\"layui-input-inline\"><select lay-filter=\"select_{$id}\" name=\"{$id}\" id=\"{$id}\" lay-verify=\"required\" lay-search>";
        $html .= "<option value=\"\" placeholder='请输入关键字搜索'></option>";
        if (is_array($array)) {
            if ($more) {
                $add_array = [
                    '' => $more
                ];
                // $array = array_merge($add_array, $array);        //key会被重置
                $array = $add_array + $array;
                reset($array);
            }
            if ($selected == '') {
                $selected_key = key($array);
            } else {
                $selected_key = $selected;
            }
            foreach ($array as $k => $v) {
                if ($selected_key === (string)$k) {
                    $selected_attr = ' selected ';
                } else {
                    $selected_attr = '';
                }
                $html .= "<option value=\"$k\" {$selected_attr}>$v</option>";
            }
        }
        $html .= "</select></div>";
        return $html;
    }
    
    protected function _filterArray($arr,$id,$name)
    {
        $tmp = [];
        foreach ($arr as $item){
            $key = $item[$id];
            $val = $item[$name];
            $tmp[$key] = $val;
        }
        return $tmp;
    }
    
    protected function layuiParams()
    {
        $params = Yii::$app->request->get('params');
        $arr = explode('|', $params);
        $this->layui_key = array_key_exists(1, $arr) ? $arr[1] : 'user_id';
        $this->layui_val = $arr[0];
        if($this->layui_key && $this->layui_val){
            $this->parames = "keyword={$this->layui_val}&search={$this->layui_key}";
        }
    }
    
   

}

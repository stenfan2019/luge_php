<?php


namespace admin\controllers;


use Aws\S3\S3Client;
use GuzzleHttp\Client;
use Yii;

class UploadController extends \yii\web\Controller
{

    public $enableCsrfValidation = false;

    /**
     * @name 图片上传
     * @author mike
     * @date 2020-08-12
     */
    public function actionImg()
    {
        if(!isset($_FILES['file'])) return $this->error('缺少必要参数');
        $tmpFile = file_get_contents($_FILES['file']['tmp_name']);
        $fileName = $_FILES['file']['name'];
        $type = substr($fileName,strrpos($fileName,'.'));
        $filePath = Yii::$app->params['upload']['path'].date('Ymd').'/'.md5(time().rand(1000,9999)).$type;
        $this->awsUpFile($tmpFile,$filePath);
        return $this->success(['path'=>$filePath,'file_name'=>$filePath]);
    }


    /**
     * @name 图片上传editor专用
     * @author mike
     * @date 2020-12-22
     */
    public function actionImgEditor()
    {
        if(!isset($_FILES['file'])) return $this->error('缺少必要参数');
        $tmpFile = file_get_contents($_FILES['file']['tmp_name']);
        $fileName = $_FILES['file']['name'];
        $type = substr($fileName,strrpos($fileName,'.'));
        $filePath = Yii::$app->params['upload']['path'].date('Ymd').'/'.md5(time().rand(1000,9999)).$type;
        $this->awsUpFile($tmpFile,$filePath);

        $data = [
            'src'=>Yii::$app->params['oss_url'].$filePath,
            'title'=>$fileName,
        ];
        return $this->success($data);
    }


    /**
     * @name 上传文件到aws
     * @param $fileObj
     * @param string $filePath
     * @return \Psr\Http\Message\UriInterface
     * @author mike
     * @date 2020-08-12
     */
    public function awsUpFile($fileObj,$filePath='')
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-east-1b',
            'endpoint' => Yii::$app->params['upload']['url'],
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => '4OMI4G9UQL6THW1X88T9',
                'secret' => 'MEItdf4cp5YU+hZCnWe+7hWt0vahOlLFDVhFwzfn',
            ],
            'useSSL'=>false,
        ]);
        $insert = $s3->putObject([
            'Bucket' => 'static',
            'Key'    => $filePath,
            'Body'   => $fileObj,
        ]);

        $command = $s3->getCommand('GetObject', [
            'Bucket' => 'static',
            'Key'    => $filePath
        ]);
        $presignedRequest = $s3->createPresignedRequest($command, '+5 days');
        return $presignedRequest->getUri();
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
        $return_data['state'] = 0;
        $return_data['code'] = 0;
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Credentials:true');
        header('Access-Control-Allow-Method:GET,POST,PUT,PATCH,DELETE,HEAD,OPTIONS');
        header("Access-Control-Allow-Headers:Origin,X-Requested-With,Content-Type,Accept,Authorization");
        Yii::$app->response->statusCode = 200;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->data = $this->version() + $return_data;
        Yii::$app->response->send();
        exit();
    }


    /**
     * @name 错误信息
     * @param string $message 错误信息
     * @param array $data 错误数据
     * @param int $code 状态码
     * @return json
     * @author stenfan
     * @date 2020-08-09
     */
    protected function error($message = 'error', $code=500, $data =[])
    {
        Yii::$app->response->statusCode = $code;
        $rs_data = array(
            'state' => $code,
            'msg'   => $message,
            'data'  => $data
        );
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Credentials:true');
        header('Access-Control-Allow-Method:GET,POST,PUT,PATCH,DELETE,HEAD,OPTIONS');
        header("Access-Control-Allow-Headers:Origin,X-Requested-With,Content-Type,Accept,Authorization");
        Yii::$app->response->statusCode = 200;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->data   = $this->version() + $rs_data;
        Yii::$app->response->send();
        exit();
    }



    /**
     * 版本号
     * @return multitype:string
     */
    private function version()
    {
        return [ 'sversion' => 'V1.0.11'];

    }
}
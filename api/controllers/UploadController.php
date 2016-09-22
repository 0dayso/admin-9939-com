<?php
namespace api\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use common\models\Symptom;
use librarys\controllers\BaseController;

class UploadController extends BaseController {
    
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'error'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }*/
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    /**
     * 配置各模块上传参数
     * 图片上传路径配置/admin-9939-com/backend/config/params.php
     * @return array
     */
    public function getConfig() {
        $config = [
                    'symptom' => [
                        'path'      => \Yii::$app->params['uploadPath']['symptom']['path'],
                        'domain'    => \Yii::$app->params['uploadPath']['symptom']['domain'],
                        'filetype'  => ['jpg', 'jpeg', 'gif', 'png'],
                    ],
            
                    'article' => [
                        'path'      => \Yii::$app->params['uploadPath']['article']['path'],
                        'domain'    => \Yii::$app->params['uploadPath']['article']['domain'],
                        'filetype'  => ['jpg', 'jpeg', 'gif', 'png'],
                    ],
                    'disease' => [
                        'path'      => \Yii::$app->params['uploadPath']['disease']['path'],
                        'domain'    => \Yii::$app->params['uploadPath']['disease']['domain'],
                        'filetype'  => ['jpg', 'jpeg', 'gif', 'png'],
                    ],
                    'ad' => [
                        'path'      => \Yii::$app->params['uploadPath']['ad']['path'],
                        'domain'    => \Yii::$app->params['uploadPath']['ad']['domain'],
                        'filetype'  => ['jpg', 'jpeg', 'gif', 'png'],
                    ],
                ];
        return $config;
    }
    
    /**
     * 上传文件
     * @param type $type
     * @return string
     */
    public function actionIndex() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $sign = $this->helpGquery('sign');//验证加密串
        
        if($this->Signature($sign)){
            $category = $this->helpGquery('category');//模块类别
            $config = $this->getConfig();
            $path = $config[$category]['path'];//文件保存路径
            $domain = $config[$category]['domain'];//模块静态域名
            $pathTmp = explode('web', $path);///data/www/develop/code/trunk/admin-9939-com/frontend/web/upload/symptom从web分割
            
            $tempFile = $_FILES['Filedata']['tmp_name']; //得到上传的临时文件流
            $oldFilename = $_FILES["Filedata"]["name"]; //得到文件原名
            $extension = $this->getExtension($oldFilename);//得到文件扩展名
            $newFilename = date('YmdHis') . '-' . rand(10000, 99999) . "." . $extension;//新的文件名
            $fileUrl = $domain.str_replace('\\', '/',$pathTmp[count($pathTmp)-1]).$newFilename;//将\替换为/
            if(!in_array($extension, $config[$category]['filetype'])){//判断上传的文件文件是否合法
                return [
                    'code' => '0',
                    'msg' => 'file type not allowed.'
                ];
            }
    //        print_r($path);
    //        exit;
            if(!file_exists($path)):
                mkdir($path, 0777, true);
            endif;
            
            $result = [];
            $flag = $this->saveAs($tempFile, $path.$newFilename, 1);
            if($flag){
                $result = [
//                    'path' => $path,
                    'name' => $oldFilename,
                    'extension' => $extension,
                    'fileName' => $newFilename,
                    'domain' => $domain,
                    'fileUrl' => $fileUrl,
                ];
            }else{
                $result = [
                    'code' => '0',
                    'msg' => 'upload error,maybe the server\'s permission is not enough.'
                ];
            }
            return $result;
        }else{
            return [
                'code' => '0',
                'msg' => 'authentication is failed.'
            ];
        }

    }
    
    
    /**
     * 删除图片操作
     * @param string $fileName 图片的名称
     * @return array 删除操作的标识信息（0：失败；1：成功）
     */
    public function actionDelete() {
        $sign = $this->helpGquery('sign');//验证加密串
        if($this->Signature($sign)){
            $callback = $this->helpGquery('callback'); //回调函数名
            $category = $this->helpGquery('category'); //模块类别
            $fileName = $this->helpGquery('fileName'); //图片名称
            $config = $this->getConfig();
            $path = $config[$category]['path'];//文件保存路径
            $fileUrl = $path.$fileName;
            $flag = 0;
            $msg = 'delete fail.';
            //删除当前文件
            if (is_file($fileUrl) && file_exists($fileUrl)) {
                unlink($fileUrl);
                $flag = 1;
                $msg = 'delete success';
            }
            $res = [
                'code' => $flag,
                'msg' => $msg
            ];
            $jsonp = $callback.'('.json_encode($res).');';
            return $jsonp;
        }else{
            $res = [
                'code' => '0',
                'msg' => 'authentication is failed.'
            ];
            echo json_encode($res);
            exit;
        }
    }

    /**
     * 错误提示页面
     * @return type
     */
    public function actionError(){
        return $this->render('error');
    }

    
    /************************************公用方法********************************************************/
    /**
     * 加解密方法
     * @param type $string
     * @param type $operation
     * @param type $key
     * @param type $expiry
     * @return string
     */
    public function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙   
        $ckey_length = 4;

        // 密匙   
        $key = md5($key ? $key : '123456');

        // 密匙a会参与加解密   
        $keya = md5(substr($key, 0, 16));
        // 密匙b会用来做数据完整性验证   
        $keyb = md5(substr($key, 16, 16));
        // 密匙c用于变化生成的密文   
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) :
                        substr(md5(microtime()), -$ckey_length)) : '';
        // 参与运算的密匙   
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)， 
        //解密时会通过这个密匙验证数据完整性   
        // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确   
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
                sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        // 产生密匙簿   
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度   
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        // 核心加解密部分   
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            // 从密匙簿得出密匙进行异或，再转成字符   
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'DECODE') {
            // 验证数据有效性，请看未加密明文的格式   
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                    substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因   
            // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码   
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

    
    
    /**
     * 验证权限
     * @param type $sign
     * @return boolean
     */
    public function Signature($sign){
        $signArr = ['123456',];
        if(in_array($sign, $signArr)){
            return true;
        }else{
//            return [
//                'code' => '0',
//                'msg' => 'authentication is failed.'
//            ];
            return false;
        }
    }
    

    /**
     * 得到文件扩展名
     * @param type $tmpname
     * @return type
     */
    public function getExtension($tmpname) {
        return strtolower(pathinfo($tmpname, PATHINFO_EXTENSION));
    }
    
    /**
     * 保存上传临时文件
     * @param type $file
     * @param type $deleteTempFile
     * @return boolean
     */
    public function saveAs($tempFile, $file, $deleteTempFile = true) {
        if ($deleteTempFile) {
            return @move_uploaded_file($tempFile, $file);
        } elseif (@is_uploaded_file($tempFile)) {
            return @copy($tempFile, $file);
        }
        return false;
    }
    /************************************公用方法********************************************************/
}

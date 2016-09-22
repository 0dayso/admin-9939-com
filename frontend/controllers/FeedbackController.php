<?php
namespace frontend\controllers;

use Yii;
use librarys\controllers\frontend\FrontController;
use common\models\Feedback;
use yii\web\Response;

class FeedbackController extends FrontController
{
    private $feedback;
    private $path = "uploads/";
    private $temp = "temp/";

    public function init(){
        parent::init();
        $this->setLayout('feedback');
        $this->feedback = new Feedback();
    }
    
    public function actionIndex(){
        $request = \Yii::$app->request;
        if($request->isPost){
            $param['url'] = $request->post('url');
            $param['surgets'] = $request->post('surgets');
            $param['content'] = $request->post('content');
            $param['contact'] = $request->post('contact');
            $param['images'] =  $request->post('uploads');
            $param['createtime'] = time();
            if(empty($param['url']) || empty($param['surgets']) || empty($param['content']) || empty($param['contact'])){
                return 0; die();
            }else{
                return $this->feedback->feedbackAdd($param);die();
            }
        }
        return $this->render('index');
    }
    
    /**
	 * 上传图片的操作
	 * @author gaoqing
	 * 2016年1月28日
	 * @return array 上传成功后，返回图片的相关信息
	 */
	public function actionUpload() {
		\Yii::$app->response->format=Response::FORMAT_JSON;
		//设置上传目录
		$path = $this->temp;
		if (!empty($_FILES)) {
			//得到上传的临时文件流
			$tempFile = $_FILES['Filedata']['tmp_name'];

			//允许的文件后缀
			$fileTypes = array('jpg','jpeg','gif','png');
		
			//得到文件原名
			$fileName = iconv("UTF-8","GB2312",$_FILES["Filedata"]["name"]);
			$fileParts = pathinfo($_FILES['Filedata']['name']);
		
			//最后保存服务器地址
			$frontend = \Yii::getAlias("@frontend");
                        $fullpath = $frontend . DIRECTORY_SEPARATOR . "web" .DIRECTORY_SEPARATOR . $path;
			if(!file_exists($fullpath) || !is_dir($fullpath)){
				mkdir($fullpath, 0777);
			}
			$name = strstr($fileName, ".", true);
			$name = md5($name);
			$suffix = strstr($fileName, ".");
			$fileName = $name . $suffix;
			$domain = \Yii::getAlias("@jb_domain");
			
			if (move_uploaded_file($tempFile, $path.$fileName)){
				return [
						'path' => $path, 
						'name' => $name, 
						'suffix' => $suffix, 
						'fileName' => $fileName,
						'domain' => $domain,
				];
			}
		}
	}
    
}
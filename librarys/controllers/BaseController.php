<?php
namespace librarys\controllers;

use Yii;
use librarys\helpers\utils\Utils;
use librarys\helpers\Paging;
use yii\web\Controller;
use yii\helpers\Json;

/**
 * Site controller
 */
class BaseController extends Controller
{
    
    public $uid;
    public function init(){
        parent::init();
    }
    
    public function setLayout($layout='//main'){
        $this->layout = $layout;
    }
    
    public function disableLayout(){
        $this->layout = false;
    }
    
    /**
     * 
     * @param type $code
     * @param type $msg
     */
    public function helpHeader($code = 200, $msg = '') {
        header("content-type: text/html; charset=utf-8");
        $codeStr = "";
        switch ($code) {
            case 404 :
                $codeStr = " 404 Not Found";
                break;
            case 403 :
                $codeStr = " 403 Forbidden";
                break;
            case 500 :
                $codeStr = " 500 Internal Server Error";
                break;
            default :
                $codeStr = " 200 OK";
                break;
        }
        header("HTTP/1.0" . $codeStr);
        echo $msg;
    }

    /**
     * /**
     * js 跳转 并 提示
     * @param type $message
     * @param type $expression
     */
    protected function helpJsRedirect($message = '', $expression = "history.back()") {
        header("content-type: text/html; charset=utf-8");
        if ($message != "") {
            $message = Utils::String()->addslash($message);
            $message = str_replace("\n", "\\n", $message);
            echo "<script language=\"javascript\">";
            echo "alert(\"{$message}\");";
            echo "</script>";
        }
        if ($expression != "") {
            echo "<script language=\"javascript\">\n";
            echo $expression . "\n";
            echo "</script>";
        }
        exit();
    }

    /**
     * 跳转
     *
     * @param String $url
     * @param String $message
     */
    protected function helpGo($url, $message = '') {
        if (!empty($message)) {
            header("content-type: text/html; charset=utf-8");
            $message = Utils::String()->addslash($message);
            $message = str_replace("\n", "\\n", $message);
            echo "<script language=\"javascript\">";
            echo "alert(\"{$message}\");";
            echo "</script>";
        }
        header('Location: ' . ($url ? $url : '/'));
        exit();
    }

    /**
     * refresh跳转
     *
     * @param String $url
     * @param String $message
     * @param Integer $content
     */
    protected function helpRefresh($url, $message = '', $content = 0, $show = false) {
        if (!empty($message)) {
            header("content-type: text/html; charset=utf-8");
            $message = Utils::String()->addslash($message);
            $message = str_replace("\n", "\\n", $message);
            echo "<script language=\"javascript\">";
            echo "alert(\"{$message}\");";
            echo "</script>";
        }
        echo "<script language=\"javascript\">";
        echo "window.location.href='{$url}';";
        echo "</script>";
        if ($show == false) {
            exit();
        }
    }

    public function helpResult($retData) {
        $dataString = json_encode($retData);
        $ret = array(
            'code' => $retData['code'],
            'message' => $retData['message'],
            'data' => $retData['data'],
            'md5' => md5($dataString)
        );
        echo Json::encode($ret);
    }

    /**
     * JSON输出
     *
     * @param String $caption
     * @param Integer $code
     * @param mixed $content
     */
    protected function helpJsonResult($code, $message = null, $data = null) {
        echo  Json::encode(Utils::result($code, $message, $data));
    }

    /**
     * JSONP Callback输出,用于远程调用
     *
     * @param String $caption
     * @param Integer $code
     * @param mixed $content
     */
    protected function helpJsonCallbackResult($callbackString, $code, $message = null, $data = null) {
        echo $callbackString . "(";
        echo json_encode(Utils::result($code, $message, $data));
        echo ")";
        exit();
    }

    /**
     * 转义', "
     *
     * @param string $string
     * @return string
     */
    protected function helpAddslashes($string) {
        return get_magic_quotes_gpc() ? $string : addslashes($string);
    }

    

    /**
     * 封装一下获取param参数
     * @param String $key
     * @param mixed $default
     * @return mixed
     */
    protected function helpGparam($key, $default = null) {
        return isset($_GET[$key]) ? $_GET[$key] : (isset($_POST[$key]) ? $_POST[$key] : $default);
    }

    /**
     * 封装一下获取get参数
     * @param String $key
     * @param mixed $default
     * @return mixed
     */
    protected function helpGquery($key, $default = null) {
        return $this->getRequest()->get($key, $default);
    }

    /**
     * 封装一下获取post参数
     * @param String $key
     * @param mixed $default
     * @return mixed
     */
    protected function helpGpost($key, $default = null) {
        return $this->getRequest()->post($key, $default);
    }
    
    /**
     * 
     * @param type $paramName
     * @return type
     */
    protected function hasParam($paramName)
    {
        return null !== $this->helpGparam($paramName);
    }

    /**
     * 
     */
    protected function getParams() {
        $_params = array_merge($_GET,$_POST);
        foreach($_params as $k=>$v){
            if($v==null){
                unset($_params[$k]);
            }
        }
        return $_params;
    }

    /**
     * 输出xml信息
     *
     * @param mixed $data
     */
    protected function helpOutputXml($data) {
        $this->disableLayout();
        header("Content-Type: text/xml");
        echo $data;
    }

    /**
     * 获取module,controller,action的数组
     *
     * @return array
     */
    public function helpGetDispatchPath() {
        return array(
            'module' => $this->module->id,
            'controller' => Yii::$app->controller->id,
            'action' =>Yii::$app->controller->action->id
        );
    }
    
    /**
	 *
	 * @param String $template
	 * @return \librarys\helpers\Paging
	 */
	protected function helpPaging($template = 'pager') {
		if (empty($template)) {
			return false;
		}
		$paging = new Paging();
		$templateFile = Yii::getAlias('@librarys') . trim('/helpers/view/templet/paging/' . strtolower($template) . '.php');
        $paging->setTemplate($templateFile);
		return $paging;
	}

    /**
     * 
     * 获取节点
     * @return String
     */
    public function helpRandNode() {
        $randNum = time() % 2;
        return sprintf('%02d', ($randNum ? $randNum : 2));
    }

    /**
     * 
     * @return \yii\web\Request
     */
    public function getRequest() {
        return \Yii::$app->request;
    }
    
    /**
     * 
     * @return \yii\web\Response
     */
    public function getResponse(){
        return \Yii::$app->response;
    }
    
    /**
     * 
     * @return string
     */
    public function getRequestURIPath(){
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        if (stripos($uri, "?") !== false){
            $uri_arr = explode('?', $uri);
            $uri = $uri_arr[0];
        }
        return '/'.$uri;
    }

    
}

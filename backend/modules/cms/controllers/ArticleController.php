<?php
namespace backend\modules\cms\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use common\models\disease\Article;
use common\models\Relate;
use common\models\Disease;
use common\models\Symptom;
use common\models\Department;
use librarys\controllers\backend\BackController;

class ArticleController extends BackController
{
    private $article;
    private $relate;
    private $disease;
    private $symptom;
    private $depart;
    private $path;
    
    public $articleType = [
        '1' => '症状',
        '2' => '病因',
        '3' => '检查',
        '4' => '鉴别',
        '5' => '治疗',
        '6' => '护理',
        '7' => '饮食',
        '8' => '并发症'
    ];
    
    function init() {
        parent::init();
        $this->path = \Yii::$app->params['uploadPath']['article'];
        $this->article = new Article();
    }
    
    
    /**
     * 疾病文章列表页
     * @return type
     */
    public function actionIndex(){
        $this->relate = new Relate();
        $this->getView()->title = '疾病文章管理';
//        $model['unshow'] = $this->article->listByCondition([['status'=> 11]]);
//        $model['show'] = $this->article->listByCondition([['status'=> 99]]);
//        $perpage = 4;
//        $totalpage = $this->article->getRecords([['status'=> 11]])  / $perpage;//查询条件
        
        $perpage = 10;
        $pagenum = $this->helpGparam('page', 1);
        $totalPage = $this->article->getRecords([['status'=> 11]])  / $perpage;
        $page = ($pagenum <= ($totalPage / $perpage)) ? $pagenum : ($totalPage / $perpage);
        $paging = $this->helpPaging('pagerjs_3')->setSize($perpage);
        $paging->setTotal($totalPage)->setCurrent($page);
        $offset = $paging->getOffset();
        
        $tmpArticlesUnshow = $this->article->listByCondition([['status'=> 11]], $perpage, $offset);
        $tmpArticlesShow = $this->article->listByCondition([['status'=> 99]], $perpage, 0);
        
        foreach($tmpArticlesUnshow as $v){
            $articleArr[] = $v['id'];
        }
        foreach($tmpArticlesShow as $v){
            $articleArr[] = $v['id'];
        }
//        $articleIds = implode(",", $articleArr);
        
        $articles = [];
        foreach($tmpArticlesUnshow as $k=>$v){
            $articles[$k]['info'] = $v;
            $articles[$k]['disease'] = $this->relate->getArticleRelDiseaseByIds($v['id']);
        }
        $model['unshow'] = $articles;
        $model['paging'] = $paging;
        
        $articles = [];
        foreach($tmpArticlesShow as $k=>$v){
            $articles[$k]['info'] = $v;
            $articles[$k]['disease'] = $this->relate->getArticleRelDiseaseByIds($v['id']);
        }
        $model['show'] = $articles;
//        $pagination = new Pagination([
//            'defaultPageSize' => $perpage,
//            'totalCount' => $totalpage,
//        ]);
//        $model['pagination'] = $pagination;
//        $model['totalCount'] = $totalpage;
        
        
        return $this->render('index',[
            'model' => $model,  
        ]);
    }
    
    /**
     * 列表页搜索表单ajax返回数据
     * @return type
     */
    public function actionIndexAjax(){
        $this->relate = new Relate();
        $this->disease = new Disease();
        
        $articleid = (int)$this->helpGquery('articleid');
        $title = $this->helpGquery('title');
        $diseasename = $this->helpGquery('diseasename');
        $inputtime_begin = (int)$this->helpGquery('inputtime_begin');
        $inputtime_end = (int)$this->helpGquery('inputtime_end');
        $username = $this->helpGquery('username');
        $status = (int)$this->helpGquery('status');
//        print_r($status);exit;
//            exit;

        $condition = $where = [];
        
        if($diseasename){//通过搜索疾病名称并且有文章
            $where = ['like', '9939_disease.name', $diseasename];
            $diseaseTmp = $this->relate->getDiseaseByCondition($where);//通过模糊查询得到文章id
            if(count($diseaseTmp) > 0){
                foreach($diseaseTmp as $v){
                    $articleArr[] = $v['articleid'];
                }
                $articleArr = array_filter($articleArr);
                $articleIds = implode(",", $articleArr);
                $condition['diseasename'] = ['id' => $articleArr];//使用in方法查询
            }
            
        }else{//通过其他方式搜索
            
            //分别判断参数是否为空
            if($articleid){
                $condition["id"] = ["{{%disease_article}}.id" => $articleid];
            }

            if($status!==''){
                $condition["status"] = ["{{%disease_article}}.status" => $status];
            }

            if($title){
                $condition["title"] = ['like', "{{%disease_article}}.title", $title];
            }

            if($username){
                $condition["username"] = ['like', "{{%disease_article}}.username", $username];
            }

            if($inputtime_begin && $inputtime_end){
                $condition["inputtime"] = ['between', "{{%disease_article}}.inputtime", $inputtime_begin, $inputtime_end];
            }
            
            
        }
        
        //分页代码开始
//        $page = $this->helpGquery('page', 1);//页码参数
//        $perpage = 4;//每页记录数
//        $offset = $page * $perpage - $perpage;//偏移量
//        $totalpage = $this->article->getRecords($condition);//查询条件
        
        
        $perpage = 10;
        $pagenum = $this->helpGparam('page', 1);
        $totalPage = $this->article->getRecords($condition);
        $page = ($pagenum <= ($totalPage / $perpage)) ? $pagenum : ($totalPage / $perpage);
        $paging = $this->helpPaging('pagerjs_3')->setSize($perpage)->setPageSetSize(10);
        $paging->setTotal($totalPage)->setCurrent($page);
        $offset = $paging->getOffset();
        
        $model['diseaseIds'] = [''];
        $tmpArticles = $this->article->listByCondition($condition, $perpage, $offset);
        
        $model['paging'] = $paging;
        
        $articles = [];
        foreach($tmpArticles as $k=>$v){
            $articles[$k]['info'] = $v;
            $articles[$k]['disease'] = $this->relate->getArticleRelDiseaseByIds($v['id']);
        }
        $model['articles'] = $articles;
        
        $msg['content'] = $this->renderPartial('index_ajax',[
            'model' => $model,
        ]);
        return json_encode($msg);
    }
    
    /**
     * 添加文章内容
     * @return type
     */
    public function actionAdd(){
        $this->symptom = new Symptom();
        $this->depart = new Department();
        $this->relate = new Relate();
        
        
        if($this->request->isPost){//表单提交
            $flag = [];
                    
            //获取主表表单信息
            $articleFormData = $this->request->post('articleForm');//主表信息
            $articleFormData = array_filter($articleFormData);
            //设置默认字段值
            $articleFormData['userid'] = $this->user->id;//发布人id
            $articleFormData['username'] = $this->user->login_name;//发布人同登录用户名
            $articleFormData['fjc'] = $articleFormData['keywords'];//附加词
            $articleFormData['url'] = '';
            $articleFormData['click'] = rand(1000, 3000);
            $articleFormData['source'] = 1;//原创
            $articleFormData['status'] = 99;//默认 已发布
            $articleFormData['inputtime'] = $articleFormData['updatetime'] = time();
            
            
            $insertid = $flag[] = $this->article->addArticle($articleFormData);
//            $res = true;
            if($flag[0]){
                
                //获取上传的图片信息
                $ImageDataTmp = $this->request->post('diseaseImage');//上传的图片
//                var_dump($ImageDataTmp);exit;
                if($ImageDataTmp !== '0'){
                    $ImageData = json_decode($ImageDataTmp, true);
                    $ImgAttribute = ['name', 'weight', 'articleid', 'createtime', 'updatetime'];
                    $ImgData = ['articleid'=>$insertid];
                    if(count($ImageData) > 0){//如果是多个疾病id
                        foreach($ImageData as $v){
                            $ImgData['img'][] = [ $v['name'], $v['weight'], $insertid, time(), time()];
                        }
                    }else{//单个疾病id
                        $ImgData['img'][] = [ $ImageData[0]['name'], $ImageData[0]['weight'], $insertid, time(), time()];
                    }
                    $flag[] = $this->relate->addArticleImage($ImgAttribute, $ImgData);//添加图片
                }
                //获取所属疾病
                $articleRelDiseaseFormData = $this->request->post('diseaseRelate');//所属相关疾病
                $diseaseid = explode(",", $articleRelDiseaseFormData['disease_rel']);
                
                $attribute = ['articleid', 'diseaseid'];
                $diseaseData = ['articleid'=>$insertid];
                if(count($diseaseid) > 0){//如果是多个疾病id
                    foreach($diseaseid as $v){
                        $diseaseData['disease'][] = [ $insertid, $v];
                    }
                }else{//单个疾病id
                    $diseaseData['disease'][] = [ $insertid, $diseaseid];
                }
                $flag[] = $this->relate->addArticleRelDisease($attribute, $diseaseData);//添加关联疾病
//                print_r($diseaseid);
//                exit;
                $backurl = Url::to(['/cms/article/index']);
                $num = count($flag);//当前删除记录操作的总个数
                $n = 0;
                foreach($flag as $v){//循环出所有的值，值分为0 1 ，成功是1，失败是0
                    $n = $v + $n;
                }
                if($n < $num){
                    $this->helpGo($backurl, '文章添加失败，返回重试');
                }else{
                    $this->helpGo($backurl);
                }
            }else{
                $backurl = Url::to(['/cms/article/index']);
                $this->helpGo($backurl, '文章添加失败，返回重试');
            }
            
//            print_r($res);
//            exit;
        }else{//添加页面
            $this->getView()->title = '添加疾病文章';
            
            $model['relateDisease'] = 0;//所有与当前症状相关联的症状，因为是添加，所以默认为空
            $model['article'] = false;//文章内容信息
            $model['articleType'] = $this->articleType;
            $model['allArticle'] = $this->symptom->getSymptom();//所有的症状，供选择相关症状时使用
            $model['allArticle']['department'] = $this->depart->getDepartmentLevel1();//相关疾病弹窗条件 科室
            $model['diseaseImage'] = 0;
            //生成上传签名串
            $moduleName = 'article';
            $model['sign']  = \Yii::$app->params['uploadPath'][$moduleName]['api_id'];
            
            return $this->render('add',[
                'model' => $model,
            ]);
        }
        
    }
    
    /**
     * 修改文章
     */
    public function actionEdit(){
        $this->symptom = new Symptom();
        $this->depart = new Department();
        $this->relate = new Relate();
        
        if($this->request->isPost){//表单提交
            $flag = [];
                    
            //获取主表表单信息
            $articleFormData = $this->request->post('articleForm');//主表信息
//            $articleFormData = array_filter($articleFormData);
            //设置默认字段值
            $articleFormData['userid'] = $this->user->id;//发布人id
            $articleFormData['username'] = $this->user->login_name;//发布人同登录用户名
            $articleFormData['fjc'] = isset($articleFormData['keywords'])?$articleFormData['keywords']:'';//附加词
            $articleFormData['url'] = '';
            $articleFormData['click'] = rand(1000, 3000);
            $articleFormData['source'] = 1;//原创
            $articleFormData['inputtime'] = $articleFormData['updatetime'] = time();
            
            
            $insertid = $articleFormData['id'];
            $attribute = [$articleFormData];
            $condition = ['id' => $articleFormData['id']];
            $flag[] = $this->article->editArticle($articleFormData, $condition);//修改文章内容
            
            if($flag[0]){
                //获取所属疾病
                $articleRelDiseaseFormData = $this->request->post('diseaseRelate');//所属相关疾病
                $diseaseid = explode(",", $articleRelDiseaseFormData['disease_rel']);
                
                $attribute = ['articleid', 'diseaseid'];
                $diseaseData = ['articleid'=>$insertid];
                if(count($diseaseid) > 0){//如果是多个疾病id
                    foreach($diseaseid as $v){
                        $diseaseData['disease'][] = [ $insertid, $v];
                    }
                }else{//单个疾病id
                    $diseaseData['disease'][] = [ $insertid, $diseaseid];
                }
                $flag[] = $this->relate->addArticleRelDisease($attribute, $diseaseData);//添加关联疾病
                
                //获取上传的图片信息
                $ImageDataTmp = $this->request->post('diseaseImage');//上传的图片
                $ImageData = json_decode($ImageDataTmp, true);
                $ImgAttribute = ['name', 'weight', 'articleid', 'createtime', 'updatetime'];
                $ImgData = ['articleid'=>$insertid];
                if(count($ImageData) > 0 ){
                    if(count($ImageData) > 1){//如果是多个图片
                        foreach($ImageData as $v){
                            $ImgData['img'][] = [ $v['name'], $v['weight'], $insertid, time(), time()];
                        }
                    }elseif(count($ImageData) == 1){//单个图片
                        $ImgData['img'][] = [ $ImageData[0]['name'], $ImageData[0]['weight'], $insertid, time(), time()];
                    }
                    $flag[] = $this->relate->addArticleImage($ImgAttribute, $ImgData);//添加图片
                }
                
//                print_r($diseaseid);
//                exit;
                $backurl = Url::to(['/cms/article/index']);
                $num = count($flag);//当前删除记录操作的总个数
                $n = 0;
                foreach($flag as $v){//循环出所有的值，值分为0 1 ，成功是1，失败是0
                    $n = $v + $n;
                }
                if($n < $num){
                    $this->helpGo($backurl, '文章修改失败，返回重试');
                }else{
                    $this->helpGo($backurl);
                }
            }else{
                $backurl = Url::to(['/cms/article/index']);
                $this->helpGo($backurl, '文章修改失败，返回重试');
            }
            
//            print_r($flag);
//            exit;
//            
//            //获取图片信息
//            $ImageDataTmp = $this->request->post('diseaseImage');//
//            $ImageData = json_decode($ImageDataTmp, true);
//            exit;
            
        }else{
            $this->getView()->title = '编辑疾病文章';
            $id = $this->helpGquery('id');
            $model['relateDisease'] = 0;//所有与当前症状相关联的症状，因为是添加，所以默认为空
            $model['article'] = $this->article->getSimpleArticle($id);//文章内容信息
            $model['articleType'] = $this->articleType;
            
            $model['allArticle'] = $this->symptom->getSymptom();//所有的症状，供选择相关症状时使用
            $model['allArticle']['department'] = $this->depart->getDepartmentLevel1();//相关疾病弹窗条件 科室
            
            $model['diseaseImage'] = $this->relate->getArticleImage($id);//图片集
            
            $moduleName = 'article';
            $domain = \Yii::$app->params['uploadPath'][$moduleName]['domain'];
            $path = \Yii::$app->params['uploadPath'][$moduleName]['path'];
            $pathTmp = explode('web', $path);
            $imgUrl = $domain . str_replace('\\', '/', $pathTmp[count($pathTmp)-1]);
            $model['imgPath'] = $imgUrl;
            //生成上传签名串
            $model['sign']  = \Yii::$app->params['uploadPath'][$moduleName]['api_id'];
            
            return $this->render('add',[
                'model' => $model,
            ]);
        }
    }
    
    
    /**
     * 删除文章，此方法直接从数据库永久删除
     * 删除使用actionSetArticle
     */
    public function actionDelete(){
        $this->relate = new Relate();
        $ids = $this->helpGquery('id');
        if(strstr($ids, ',')){//操作多条记录
            $ids = explode(',', $ids);
        }
        
        if(is_array($ids)){
            foreach($ids as $aid){
                $condtion = ['id' => $aid];
                $flag[] = $this->article->delArticle($condtion);
                $flag[] = $this->relate->delArticleRelDiseaseById($aid);
                $flag[] = $this->relate->delArticleImageById($aid);
            }
        }else{
            $condtion = ['id' => $ids];
            $flag[] = $this->article->delArticle($condtion);
            $flag[] = $this->relate->delArticleRelDiseaseById($ids);
            $flag[] = $this->relate->delArticleImageById($ids);
        }
        
        $backurl = Url::to(['/cms/article/recycle/']);
        
        $num = count($flag);//当前删除记录操作的总个数
        $n = 0;
        foreach($flag as $v){//循环出所有的值，值分为0 1 ，成功是1，失败是0
            $n = $v + $n;
        }
        if($n < $num){
            $result['flag'] = 0;
//            $this->helpGo($backurl, '删除失败，请返回重新操作');
        }else{
            $result['flag'] = 1;
//            $this->helpGo($backurl);
        }
        return json_encode($result);
    }
    
    
    
    /**
     * 设置文章属性，主要设置文章状态码
     * 99已发布，0: 回收站 11 未发布 审核待发布
     */
    public function actionSetArticle(){
        $ids = $this->helpGquery('id');
        $act = 'del';//默认删除信息
        if(strstr($ids, ',')){//操作多条记录
            $ids = explode(',', $ids);
        }
        if($act == 'del'){
            $attribute = ['status' => 0];
            $actTip = '删除';
        }
        $condtion = ['id' => $ids];
        $res = $this->article->editArticle($attribute, $condtion);
        $backurl = Url::to(['/cms/article/index']);
        $result = [];
        if(!$res){
            $result['flag'] = 0;
//            $this->helpGo($backurl, "{$actTip}失败，请返回重新操作！");
        }else{
            $result['flag'] = 1;
//            $this->helpGo($backurl);
        }
        return json_encode($result);
    }
    
    /**
     * 回收站疾病文章列表页
     * @return type
     */
    public function actionRecycle(){
        $this->relate = new Relate();
        $this->getView()->title = '回收站疾病文章管理';
//        $model['unshow'] = $this->article->listByCondition([['status'=> 11]]);
//        $model['show'] = $this->article->listByCondition([['status'=> 99]]);
        
        $condition = [['status'=> 0]];
        $perpage = 10;
        $pagenum = $this->helpGparam('page', 1);
        $totalPage = $this->article->getRecords($condition);
        $page = ($pagenum <= ($totalPage / $perpage)) ? $pagenum : ($totalPage / $perpage);
        $paging = $this->helpPaging('pager')->setSize($perpage);
        $paging->setTotal($totalPage)->setCurrent($page);
        $offset = $paging->getOffset();
        $tmpArticlesUnshow = $this->article->listByCondition($condition, $perpage, $offset);
        
        $model['paging'] = $paging;
        
        if(count($tmpArticlesUnshow)>0){
            foreach($tmpArticlesUnshow as $v){
                $articleArr[] = $v['id'];
            }
            $articleIds = implode(",", $articleArr);

            $articles = [];
            foreach($tmpArticlesUnshow as $k=>$v){
                $articles[$k]['info'] = $v;
                $articles[$k]['disease'] = $this->relate->getArticleRelDiseaseByIds($v['id']);
            }
            $model['unshow'] = $articles;
        }else{
            $model['unshow'] = null;
        }
        
        return $this->render('recycle',[
            'model' => $model,  
        ]);
    }
    
    
    
    /*****************************通用方法*******************************************************/

    /**
     * ajax方式获取二级科室
     * 返回json字符串，分为下拉菜单和复选框
     */
    public function actionAjaxDepartment(){
        $this->depart = new Department();
        
        if( $this->request->isPost ){
            $level1 = $this->request->post('id');
            $type = $this->request->post('type');
            $level2 = $this->depart->getDepartmentListById($level1);
            $message = array();
            $message['code'] = 1;
            
            $message['info'] = '';
            if(count($level2) > 0){
                foreach ($level2 as $k => $v) {
                    $message['info'] .= '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
                }
            }else{
                $message['info'] .= '<option>无二级科室</option>';
            }
//                    $message['info'] .= '</select>';
            
            
        }else{
            $message['code'] = 0;
        }
        echo json_encode($message);
        exit;
    }
    
    
    /**
     * 添加症状对应的相关疾病
     * @return type
     */
    public function actionAjaxAddRelateDisease(){
        $this->disease = new Disease();
        
        if($this->request->isPost){
//            print_r($this->request->post());exit;
                $data['class_level1'] = $this->request->post('class_level1');
                $data['class_level2'] = is_array($this->request->post('class_level2')) ? $this->request->post('class_level2') : $this->request->post('class_level2');
                
                $condition['department'] = $conditionDepart = [
                            "ddr.class_level1" => $data['class_level1'],
                            "ddr.class_level2" => $data['class_level2']
                        ];
                $perpage = 10;
                $pagenum = $this->helpGparam('page', 1);
                $totalPage = $this->disease->getCounts($condition);
                $page = ($pagenum <= ($totalPage / $perpage)) ? $pagenum : ($totalPage / $perpage);
                $paging = $this->helpPaging('pagerjs_3')->setSize($perpage);
                $paging->setTotal($totalPage)->setCurrent($page);
                $offset = $paging->getOffset();
                
                $relDisease['diseases'] = $this->disease->getDiseasesByDepartment($data, $offset, $perpage);
                
                if(count($relDisease['diseases'])>0){
                    foreach($relDisease['diseases'] as $k=>$v){
                        echo '<tr><td><input type="checkbox" data-name="'.$v['name'].'" name="ids" id="ids" value="'.$v['id'].'"></td><td>'.($k+1).'</td><td>'.$v['id'].'</td><td>'.$v['name'].'</td></tr>';
                    }
                    echo '<tr><td colspan="4"><div class="paget" style="height:65px; width:350px;">';
                    $paging->view();
                    echo '</div></td></tr>';
                }else{
                    echo '<tr><td colspan="4">无结果</td></tr>';
                }
        }
    }
    
    
    /**
    * 上传图片的操作
    * @return array 上传成功后，返回图片的相关信息
    */
   public function actionUpload() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        //设置上传目录
        $path = $this->path;
        if (!empty($_FILES)) {
            //得到上传的临时文件流
            $tempFile = $_FILES['Filedata']['tmp_name'];

            //允许的文件后缀
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png');

            //得到文件原名
//                   $fileName = iconv("GB2312","UTF-8",$_FILES["Filedata"]["name"]);
            $fileName = $_FILES["Filedata"]["name"];
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            //新文件名
            $newfilename = date('YmdHis') . '-' . rand(10000, 99999);
//                   $newfilename = date('YmdHis').'.'.pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION);
            //最后保存服务器地址
            if (!is_dir($path)) {
                mkdir($path);
            }
            $name = strstr($fileName, ".", true);
            $suffix = strstr($fileName, ".");
            $domain = \Yii::getAlias("@domain");


            if (move_uploaded_file($tempFile, $path . $newfilename . $suffix)) {
                return [
                    'path' => $path,
                    'name' => $name,
                    'suffix' => $suffix,
                    'fileName' => $newfilename,
                    'domain' => $domain,
                ];
            }
        }
    }

    
    /**
     * 删除图片操作
     * @param string $fileName 图片的名称
     * @return array 删除操作的标识信息（0：失败；1：成功）
     */
    public function actionDeleteimage($fileName) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $flag = 0;
        $backend = \Yii::getAlias("@backend");
        $path = $backend . "/web/";
        //找到文件的路径
        $file = $path . $this->path . $fileName;

        //删除当前文件
        if (is_file($file) && file_exists($file)) {
            unlink($file);
            $flag = 1;
        }
        return ['flag' => $flag];
    }
    
    /*****************************通用方法*******************************************************/
}
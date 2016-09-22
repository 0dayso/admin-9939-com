<?php
namespace backend\modules\basedata\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Symptom;
use common\models\SymptomContent;
use common\models\Relate;
use common\models\Disease;
use common\models\Department;
use yii\web\Response;
use librarys\helpers\utils\Spell;
use librarys\controllers\backend\BackController;


/**
 * 症状控制器
 * 
 */
class SymptomController extends BackController
{
    public $enableCsrfValidation = false; //关闭重复提交表单
    
    public $symptom;
    public $symptomContent;
    public $relate;
    public $depart;
    public $disease;
    public $request;
    public $upload;
    public $path;
    
    private $uploadSign = '9939#qweasdzxc';
    
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    } 
    
    function init(){
        parent::init();
//        $this->setLayout('main');
//        $this->disableLayout();
        $this->path = \Yii::$app->params['uploadPath']['symptom'];
        
        $this->request = \Yii::$app->request;
        
        $this->symptom = new Symptom();
        $this->symptomContent = new SymptomContent();
        $this->relate = new Relate();
        $this->depart = new Department();
        $this->disease = new Disease();
    }
    
    /**
     * 症状管理
     * @return type
     */
    public function actionIndex(){
            
        if($this->request->isPost){
            //接收传过来的4个表单参数
            $symptomid = (int)$this->request->post('symptomid');
            $username = $this->request->post('username');
            $symptomName = $this->request->post('symptomname');
            $part_level1 = (int)$this->request->post('class_level1', 0);
            $part_level2 = (int)$this->request->post('class_level2', 0);
//            
//            print_r($part_level1);
//            print_r($part_level2);
//            exit;
            
            $condition = $condition_id = $condition_name = $condition_username = $condition_class_level1 = $condition_class_level2 = [];
            
            //分别判断参数是否为空
            if($symptomid){
                $condition_id = ["{{%symptom}}.id"=> $symptomid];
            }
            
            if($part_level1 !=='' && $part_level1 !==0){
                $condition_class_level1 = ["{{%symptom_part_rel}}.part_level1"=> $part_level1];
            }
            
            if($part_level2 !=='' && $part_level2 !==0){
                $condition_class_level2 = ["{{%symptom_part_rel}}.part_level2"=> $part_level2];
            }
            
            if($symptomName){
                $condition_name = ['like', "{{%symptom}}.name", $symptomName];
            }
            
            if($username){
                $condition_username = ['like', "{{%symptom}}.username", $username];
            }
            
            //普通查询条件与like查询分开成为两个查询条件
            //合并4个参数数组
            $condition = ArrayHelper::merge($condition_id, $condition_class_level1, $condition_class_level2);
            $conditionLike = ArrayHelper::merge($condition_name, $condition_username);
            
//            
//            print_r($condition);
//            exit;
//                    
            $model['symptom'] = $this->symptom->getSymptomByCondition($condition, $conditionLike);
            $model['part'] = $this->relate->getAllPartArr();
//            print_r($model);
//            exit;
            return $this->renderPartial('index_ajax',[
                'model' => $model,
            ]);
            
        }
        
        $this->getView()->title = '症状管理';
//        $model = $this->symptom->getSymptomByCondition();
        
        $perpage = 15;
        $pagenum = $this->helpGparam('page', 1);
        $totalPage = $this->symptom->getRecords();
        $page = ($pagenum <= ($totalPage / $perpage)) ? $pagenum : ($totalPage / $perpage);
        $paging = $this->helpPaging('pager_1')->setSize($perpage)->setPageSetSize(5);
        $paging->setTotal($totalPage)->setCurrent($page);
        $offset = $paging->getOffset();
        $model = $this->symptom->getSymptomByCondition([], [], $perpage, $offset); //查询结果

        $relDisease['part'] = $this->relate->getAllPartArr();
//        print_r($relDisease['part']);
//        exit;
        $relDisease['department'] = $this->depart->getDepartmentLevel1();
        return $this->render('index',[
                'model' => $model,
                'relDisease' => $relDisease,
                'page' => $paging
            ]);
    }
    
    
    /**
     * 添加症状
     * @return type
     */
    public function actionAdd(){
        $this->getView()->title = '添加症状';
        
//        $this->request = \Yii::$app->request;
        
        if( $this->request->isPost ){
            $symptomFormData = $this->request->post('symptomForm');//主表信息
            $symptomContentFormData = $this->request->post('symptomContentForm');//分表信息
            $symptomRelateFormData = $this->request->post('symptomRelate');//相关症状
            $diseaseRelateFormData = $this->request->post('diseaseRelate');//相关疾病
            $partRelateFormData = $this->request->post('partRelate');//所属部位
            
            //图片信息
            $imagesArr = [];
            $images = json_decode($this->request->post('diseaseImage'), true);
            
            foreach($images as $k=>$v){
                //头图数据写入主表缩略图字段
                if($v['weight']==1){
                    $symptomFormData['thumbnail'] = $v['name']; 
                }
            }
            
            //主表默认值字段
            $symptomFormData['userid'] = $this->user['id'];
            $symptomFormData['username'] = $this->user['login_name'];
            $symptomFormData['createtime'] = time();
            $symptomFormData['updatetime'] = time();
            
            //拼音部分
            $pinyin_initial = Spell::Pinyin($symptomFormData['name'], 'utf-8', true);
            $capital = strtoupper($pinyin_initial[0]);
            $map_pinyin_sn =$this->getPinYinSnDic();
            $pinyin_initial_sn = isset($map_pinyin_sn[$capital]) ? ($map_pinyin_sn[$capital]+1) : 0;
            $symptomFormData['capital'] = $capital;
            $symptomFormData['capital_sn'] = $pinyin_initial_sn;
            $symptomFormData['pinyin'] = Spell::Pinyin($symptomFormData['name']);
            $symptomFormData['pinyin_initial'] = $pinyin_initial;
            $symptomFormData['source_pinyin'] = Spell::Pinyin($symptomFormData['name']);
            
//            print_r($symptomFormData);
            
//            print_r($symptomFormData);
//            exit;
            
            $flag[] = $this->symptom->addSymptom($symptomFormData);
            $lastInsertId = $this->symptom->attributes['id'];
            
            if((int)$partRelateFormData['part_level2']==0){
                $partRelateFormData['part_level2'] = '';
                $partRelateFormData['partid'] = $partRelateFormData['part_level1'];
            }else{
                $partRelateFormData['partid'] = $partRelateFormData['part_level2'];
            }
            $partRelateFormData['symptomid'] = $lastInsertId;
            
            foreach($images as $k=>$v){
                $imagesArr[$k]['name'] = $v['name'];
                $imagesArr[$k]['flag'] = 2;
                $imagesArr[$k]['weight'] = $v['weight'];
                $imagesArr[$k]['createtime'] = time();
                $imagesArr[$k]['updatetime'] = time();
                $imagesArr[$k]['relid'] = $lastInsertId;
                
                //头图数据写入主表缩略图字段
                if($v['weight']==1){
                    $symptomFormData['thumbnail'] = $v['name']; 
                }
            }
//            print_r($imagesArr);
//            exit;
            
//            echo $lastInsertId;
//            exit;
            $flag[] = $this->relate->insertImage($imagesArr);
            $flag[] = $this->symptomContent->addSymptomContent($lastInsertId, $symptomContentFormData);
            $flag[] = $this->relateSymptomInsert($lastInsertId, $symptomRelateFormData);
            $flag[] = $this->relateDiseaseInsert($lastInsertId, $diseaseRelateFormData);
            
            $flag[] = $this->relate->addRelPart($lastInsertId, $partRelateFormData);
            
            $num = count($flag);//当前删除记录操作的总个数
            $n = 0;
            foreach($flag as $v){//循环出所有的值，值分为0 1 ，成功是1，失败是0
                $n = $v + $n;
            }
            if($n < $num){//如果结果小于总个数，说明有失败
                Yii::$app->getSession()->setFlash('error', '添加失败！');
                return $this->redirect(Url::toRoute('symptom/add'));
            }
            Yii::$app->getSession()->setFlash('success', '添加成功！');
            return $this->redirect(Url::toRoute('symptom/index'));
        }
        
        $allSymptom['allSymptom'] = $this->symptom->getSymptom();//所有的症状，供选择相关症状时使用
        $allSymptom['relateSymptoms'] = 0;//所有与当前症状相关联的症状，因为是添加，所以默认为空
        $allSymptom['relatePart'] = 0;//所有与当前症状相关联的症状
        $allSymptom['diseaseImage'] = 0;//所有与当前症状相关联的症状，因为是添加，所以默认为空
        
        $allSymptom['relSymptom']['part'] = $this->relate->getAllPart();//相关疾病弹窗条件 部位
        $allSymptom['relSymptom']['department'] = $this->depart->getDepartmentLevel1();//相关疾病弹窗条件 科室
        $allSymptom['relSymptom']['symptom'] = null;
        
        $allSymptom['relateDiseases'] = 0;//所有与当前症状相关联的症状，因为是添加，所以默认为空
        //生成上传签名串
        $moduleName = 'symptom';
        $allSymptom['sign']  = \Yii::$app->params['uploadPath'][$moduleName]['api_id'];
        
        return $this->render('add',[
            'model' => false,
            'allSymptom' => $allSymptom,
        ]);
    }
    
    
    /**
     * 删除症状
     * @param type $id
     * @return type
     */
    public function actionDelete($id){
        
        $flag[] = Symptom::deleteAll('id = :id', ['id' => $id]);
        $flag[] = SymptomContent::deleteAll('id = :id', ['id' => $id]);
        $flag[] = $this->relate->deleteRelateDisease($id);
        $flag[] = $this->relate->deleteRelateSymptom($id);
        $flag[] = $this->relate->deleteRelatePart($id);
        $flag[] = $this->relate->delImage($id);
        
        $num = count($flag);//当前删除记录操作的总个数
        $n = 0;
        foreach($flag as $v){//循环出所有的值，值分为0 1 ，成功是1，失败是0
            $n = $v + $n;
        }
        if($n < $num){//如果结果小于总个数，说明有失败
            if(!$flag){
            Yii::$app->getSession()->setFlash('error', 'ID:'.$id.' 删除失败！');
            return $this->redirect(Url::toRoute('symptom/index'));
        }
        }
        Yii::$app->getSession()->setFlash('success', 'ID:'.$id.' 成功删除！');
        return $this->redirect(Url::toRoute('symptom/index'));
    }
    
    
    /**
     * 修改症状
     * @param type $id
     * @return type
     */
    public function actionEdit($id=null){
        $this->getView()->title = '编辑症状';
        
        $this->request = \Yii::$app->request;
        if( $this->request->isPost ){
            $symptomFormData = $this->request->post('symptomForm');//主表信息
            $symptomContentFormData = $this->request->post('symptomContentForm');//分表信息
            $symptomRelateFormData = $this->request->post('symptomRelate');//相关症状
            $diseaseRelateFormData = $this->request->post('diseaseRelate');//相关疾病
            $partRelateFormData = $this->request->post('partRelate');//所属部位
            
            //图片信息
            $imagesArr = [];
            $images = json_decode($this->request->post('diseaseImage'), true);
            
            foreach($images as $k=>$v){
                //头图数据写入主表缩略图字段
                if($v['weight']==1){
                    $symptomFormData['thumbnail'] = $v['name']; 
                }
            }
            
            //主表默认值字段
            $id = $symptomFormData['id'];
            
            $symptomInfo = $this->symptom->getSymptom(['id'=>$id]);
            $symptomFormData['userid'] = $this->user['id'];
            $symptomFormData['username'] = $this->user['login_name'];
            $symptomFormData['createtime'] = $symptomInfo[0]['createtime'];
            $symptomFormData['updatetime'] = time();
            
            
            if((int)$partRelateFormData['part_level2']==0){
                $partRelateFormData['part_level2'] = '';
                $partRelateFormData['partid'] = $partRelateFormData['part_level1'];
            }else{
                $partRelateFormData['partid'] = $partRelateFormData['part_level2'];
            }
            $partRelateFormData['symptomid'] = $id;
            
//            print_r($this->request->post());
//            exit;
            foreach($images as $k=>$v){
                $imagesArr[$k]['name'] = $v['name'];
                $imagesArr[$k]['flag'] = 2;
                $imagesArr[$k]['weight'] = $v['weight'];
                $imagesArr[$k]['createtime'] = time();
                $imagesArr[$k]['updatetime'] = time();
                $imagesArr[$k]['relid'] = $id;
            }
//            print_r($imagesArr);
//            exit;
            
//            print_r($diseaseRelateFormData);
//            exit;
            $flag[] = $this->relateSymptomInsert($id, $symptomRelateFormData);
            $flag[] = $this->relateDiseaseInsert($id, $diseaseRelateFormData);
            $flag[] = $this->relate->insertImage($imagesArr);
            
            $flag[] = $this->symptom->editSymptom($symptomFormData);
            $flag[] = $this->symptomContent->editSymptomContent($symptomContentFormData);
            
            $flag[] = $this->relate->addRelPart($id, $partRelateFormData);
            
            $num = count($flag);//当前删除记录操作的总个数
            $n = 0;
            foreach($flag as $v){//循环出所有的值，值分为0 1 ，成功是1，失败是0
                $n = $v + $n;
            }
            if($n < $num){//如果结果小于总个数，说明有失败
                Yii::$app->getSession()->setFlash('error', '修改失败！');
                return $this->redirect(Url::toRoute(['symptom/edit', 'id'=>$symptomFormData['id']] ));
            }
            Yii::$app->getSession()->setFlash('success', '修改成功！');
            return $this->redirect(Url::toRoute('symptom/index'));
            
        }
        
        $model = $this->symptom->getOneSymptom($id);
        $allSymptom['allSymptom'] = $this->symptom->getSymptom();//所有的症状，供选择相关症状时使用
        $allSymptom['relateSymptoms'] = $this->getRelateSymptom($id);//所有与当前症状相关联的症状
        $allSymptom['relatePart'] = $this->getRelatePart($id);//所有与当前症状相关联的症状
        $allSymptom['diseaseImage'] = $this->relate->getImage(['flag'=>2, 'relid'=>$id]);//图片集
        
        
        $allSymptom['relSymptom']['part'] = $this->relate->getAllPart();//相关疾病弹窗条件 部位
        $allSymptom['relSymptom']['department'] = $this->depart->getDepartmentLevel1();//相关疾病弹窗条件 科室
        $allSymptom['relSymptom']['symptom'] = null;
        
        
        $allSymptom['allDisease'] = $this->symptom->getSymptom();//所有的疾病，供选择相关症状时使用
        $allSymptom['relateDiseases'] = $this->getRelateDisease($id);//所有与当前症状相关联的疾病
        
//        $domain = \Yii::$app->params['uploadPath']['symptom']['domain'];
//        $path = \Yii::$app->params['uploadPath']['symptom']['path'];
//        $pathTmp = explode('web', $path);
//        $allSymptom['imgPath'] = $domain.str_replace('\\', '/',$pathTmp[2]);
        
        $moduleName = 'symptom';
        $domain = \Yii::$app->params['uploadPath'][$moduleName]['domain'];
        $path = \Yii::$app->params['uploadPath'][$moduleName]['path'];
        $pathTmp = explode('web', $path);
//        print_r($pathTmp);exit;
        $imgUrl = $domain . str_replace('\\', '/', $pathTmp[count($pathTmp)-1]);
        $allSymptom['imgPath'] = $imgUrl;
        
        //生成上传签名串
        $allSymptom['sign']  = \Yii::$app->params['uploadPath'][$moduleName]['api_id'];
        
        return $this->render('edit',[
            'model' => $model,//当前查询结果
            'allSymptom' => $allSymptom,
        ]);
    }
    
    /**
     * 添加症状对应的相关疾病
     * @return type
     */
    public function actionAjaxAddRelateDisease(){
        $this->request = \Yii::$app->request;
        if($this->request->isPost){
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
     * 添加症状对应的相关疾病
     * @return type
     */
    public function actionAjaxAddRelateSymptom(){
        $this->getView()->title = '添加相关症状';
        $this->request = \Yii::$app->request;
        $relSymptom = array();
        $relSymptom['part'] = $this->relate->getAllPart();//获取部位信息
        $relSymptom['symptom'] = null;
        if($this->request->isPost){
                $data['part_level1'] = $this->request->post('class_level1');
                $data['part_level2'] = is_array($this->request->post('class_level2')) ? $this->request->post('class_level2') : (int)$this->request->post('class_level2');
                if((int)$data['part_level2']==0){
                    unset($data['part_level2']);
                }
                
                $perpage = 10;
                $pagenum = $this->helpGparam('page', 1);
                $totalPage = $this->symptom->getRecords($data);
                $page = ($pagenum <= ($totalPage / $perpage)) ? $pagenum : ($totalPage / $perpage);
                $paging = $this->helpPaging('pagerjs_4')->setSize($perpage);
                $paging->setTotal($totalPage)->setCurrent($page);
                $offset = $paging->getOffset();
                $whereLike = [];
                $relSymptom['symptom'] = $this->symptom->getSymptomByCondition($data, $whereLike, $perpage, $offset);
                
                if(count($relSymptom['symptom'])>0){
                    foreach($relSymptom['symptom'] as $k=>$v){
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
     * ajax方式获取二级科室
     * 返回json字符串，分为下拉菜单和复选框
     */
    public function actionAjaxDepartment(){
        $this->request = \Yii::$app->request;
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
    
    public function actionAjaxIndex(){
//        $requ
    }
    
    /**
     * 上传图片的操作
     * @author gaoqing
     * 2016年1月28日
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
     * @author gaoqing
     * 2016年1月28日
     * @param string $fileName 图片的名称
     * @return array 删除操作的标识信息（0：失败；1：成功）
     */
    public function actionDeleteimage($fileName){
            \Yii::$app->response->format=Response::FORMAT_JSON;
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
    
    /**
     * ajax方式获取部位
     * 返回json字符串，分为下拉菜单和复选框
     */
    public function actionAjaxPart(){
        $this->request = \Yii::$app->request;
        if( $this->request->isPost ){
            $level1 = $this->request->post('id');
            $type = $this->request->post('type');
            $level2 = $this->relate->getPartById($level1);
            $message = array();
            $message['code'] = 1;
            
            $message['info'] = '';
            if(count($level2) > 0){
                foreach ($level2 as $k => $v) {
                    $message['info'] .= '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
                }
            }else{
                $message['info'] .= '<option>无二级部位</option>';
            }
//                    $message['info'] .= '</select>';
            
            
        }else{
            $message['code'] = 0;
        }
        echo json_encode($message);
        exit;
        
        
    }
    
    /**
     * 根据当前症状id获取相关症状id及名称，修改症状方法里使用
     * 根据当前症状id获取所有的相关症状并在中间表中删除，然后重新添加
     * @param type $symptomId string 50
     * @param type $symptomRelateFormData string 56,34,65,
     * @return type
     */
    public function relateSymptomInsert($symptomId, $symptomRelateFormData){
        //插入相关症状
        $columns = ['symptomid', 'rel_symptomid'];//传入字段名称
        $relateSymptomData = array();
        $dataArr = explode(',', $symptomRelateFormData['symptom_rel']);//把获取的【相关症状id】字符串转为数组

        for( $i=0; $i<count($dataArr); $i++){//循环获取的【相关症状id】数组，赋值为一个二维数组
            $relateSymptomData[$i] = [ $symptomId, $dataArr[$i] ];//当前症状id，相关症状id
        }
//        print_r($relateSymptomData);
//        exit;

        return $this->relate->addRelateSymptom($symptomId, $columns, $relateSymptomData);
        
    }
    
    
    /**
     * 根据当前症状id获取相关症状id及名称，修改症状方法里使用
     * 
     * @param type $symptomId string 50
     * @param type $relateSymptomIds string 56,34,65,
     * @return type
     */
    public function getRelateSymptom($symptomId){
        $relateSymptomsTmp = $this->relate->getRelateSymptoms($symptomId);
        if(count($relateSymptomsTmp) <= 0){
            return 0;
        }
        foreach($relateSymptomsTmp as $k=>$v){
            $relateSymptoms[] = [
                'name' => $v['name'],
                'id' => $v['rel_symptomid'],
            ];
        }
        
        
//        $relateTitle = $relateId = '';
//        foreach($relateSymptomsTmp as $k=>$v){
//            $relateTitle .= $v['name'].',';
//            $relateId .= $v['rel_symptomid'].',';
//        }
//        $relateSymptoms['name'] = substr($relateTitle, 0, strlen($relateTitle)-1);//截取掉最有一个逗号
//        $relateSymptoms['id'] = substr($relateId, 0, strlen($relateId)-1);//截取掉最有一个逗号
        return $relateSymptoms;
    }
    
    
    /**
     * 根据当前症状id获取相关疾病id及名称，修改症状方法里使用
     * 根据当前症状id获取所有的相关疾病并在中间表中删除，然后重新添加
     * @param type $symptomId string 50
     * @param type $symptomRelateFormData string 56,34,65,
     * @return type
     */
    public function relateDiseaseInsert($symptomId, $symptomRelateFormData){
        //插入相关症状
        $columns = ['symptomid', 'diseaseid'];//传入字段名称
        $dataArr = explode(',', $symptomRelateFormData['disease_rel']);//把获取的【相关症状id】字符串转为数组

        for( $i=0; $i<count($dataArr); $i++){//循环获取的【相关疾病id】数组，赋值为一个二维数组
            $relateSymptomData[$i] = [ $symptomId, $dataArr[$i] ];//当前症状id，相关症状id
        }
//        print_r($dataArr);
//        exit;

        return $this->relate->addRelateDisease($symptomId, $columns, $relateSymptomData);
        
    }
    
    /**
     * 根据当前症状id获取相关疾病id及名称，修改症状方法里使用
     * 
     * @param type $symptomId string 50
     * @param type $relateSymptomIds string 56,34,65,
     * @return type
     */
    public function getRelateDisease($symptomId){
        $relateDiseasesTmp = $this->relate->getRelateDiseases($symptomId);
        if(count($relateDiseasesTmp) <= 0){
            return 0;
        }
        foreach($relateDiseasesTmp as $k=>$v){
            $relateDiseases[] = [
                'name' => $v['name'],
                'id' => $v['diseaseid'],
            ];
        }
//        $relateDiseasesTmp = $this->relate->getRelateDiseases($symptomId);
//        $relateTitle = $relateId = '';
//        foreach($relateDiseasesTmp as $k=>$v){
//            $relateTitle .= $v['name'].',';
//            $relateId .= $v['diseaseid'].',';
//        }
//        $relateDiseases['name'] = substr($relateTitle, 0, strlen($relateTitle)-1);//截取掉最有一个逗号
//        $relateDiseases['id'] = substr($relateId, 0, strlen($relateId)-1);//截取掉最有一个逗号
        return $relateDiseases;
    }
    
    
    
    /**
     * 根据当前症状id获取相关症状id及名称，修改症状方法里使用
     * 根据当前症状id获取所有的相关症状并在中间表中删除，然后重新添加
     * @param type $symptomId string 50
     * @param type $partRelateFormData string 56,34,65,
     * @return type
     */
    public function relatePartInsert($symptomId, $partRelateFormData){
        //插入相关症状
        $columns = ['part_level1', 'part_level2', 'partid', 'symptomid'];//传入字段名称
        return $this->relate->addRelPart($symptomId, $columns, $partRelateFormData);
    }    
    
    
    /**
     * 根据当前症状id获取相关症状id及名称，修改症状方法里使用
     * 
     * @param type $symptomId string 50
     * @param type $relateSymptomIds string 56,34,65,
     * @return type
     */
    public function getRelatePart($symptomId){
        $relatePartsTmp = $this->relate->getRelatePart($symptomId);
        if(count($relatePartsTmp) <= 0){
            return 0;
        }
        foreach($relatePartsTmp as $k=>$v){
            $relateParts[] = [
                'name' => $v['name'],
                'id' => $v['id'],
            ];
        }
        return $relateParts;
        
        
//        $relateTitle = $relateId = '';
//        foreach($relateSymptomsTmp as $k=>$v){
//            $relateTitle .= $v['name'].',';
//            $relateId .= $v['rel_symptomid'].',';
//        }
//        $relateSymptoms['name'] = substr($relateTitle, 0, strlen($relateTitle)-1);//截取掉最有一个逗号
//        $relateSymptoms['id'] = substr($relateId, 0, strlen($relateId)-1);//截取掉最有一个逗号
    }
    
    /**
     * 获取拼音首字母对应的编号
     * @return type
     */
    public function getPinYinSnDic(){
        $pinyin_arr = range('A','Z');
        return array_flip($pinyin_arr);
    }
}
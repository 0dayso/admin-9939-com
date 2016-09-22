<?php

namespace backend\modules\basedata\controllers;


use common\models\Disease;
use common\models\Symptom;
use librarys\helpers\utils\Spell;
use yii\base\Module;
use yii\web\Response;
use common\models\Department;
use common\models\Part;
use yii\web\Request;
use librarys\controllers\backend\BackController;

/**
 * 疾病部分的控制器类
 * @author gaoqing
 * 2016年1月13日
 */
class DiseaseController extends BackController{

	private $disease;
	private $symptom;
	private $department;
	private $part;
	private $path = "uploads/";
	private $temp = "temp/";

	public function __construct($id, Module $module, array $config = [])
	{
		parent::__construct($id, $module, $config);

		$this->disease = new Disease();
		$this->symptom = new Symptom();
		$this->department = new Department();
		$this->part = new Part();
	}

	/*public function init() {
		parent::init();
		
		$this->disease = new Disease();
		$this->symptom = new Symptom();
		$this->department = new Department();
		$this->part = new Part();
	}*/
	
	/**
	 * 删除图片操作
	 * @author gaoqing
	 * 2016年1月28日
	 * @param string $fileName 图片的名称
	 * @return array 删除操作的标识信息（0：失败；1：成功）
	 */
	public function actionDeleteimage($fileName, $from){
		\Yii::$app->response->format=Response::FORMAT_JSON;
		$flag = 0;
		$flags = $this->deleteImages($fileName, $from);
		if(!in_array(false, $flags)){
			$flag = 1;
		}
		return ['flag' => $flag];
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
			$backend = \Yii::getAlias("@backend");
            $fullpath = $backend . DIRECTORY_SEPARATOR . "web" .DIRECTORY_SEPARATOR . $path;
			if(!file_exists($fullpath) || !is_dir($fullpath)){
				mkdir($fullpath, 0777);
			}
			$name = strstr($fileName, ".", true);
			$name = md5($name);
			$suffix = strstr($fileName, ".");
			$fileName = $name . $suffix;
			$domain = \Yii::getAlias("@domain");
			
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
	
	/**
	 * 得到一级部位下对应的二级部位
	 * @author gaoqing
	 * 2016年1月22日
	 * @param string $part_level1 一级部位的名称
	 * @return array 二级部位
	 */
	public function actionGetpartlevel2($part_level1) {
		\Yii::$app->response->format=Response::FORMAT_JSON;
		$part_level2_json = [];
		
		if (isset($part_level1) && !empty($part_level1) && $part_level1 != "一级部位") {
			if (intval($part_level1) > 0) {
				$part_level1_id = $part_level1;
			}else {
				$part_level1_id = $this->part->getPartIDByName($part_level1);
			}
			$part_level2_json = $this->part->getPartListById($part_level1_id);
		}
		return $part_level2_json;
	}
	
	/**
	 * 得到一级科室下对应的二级科室
	 * @author gaoqing
	 * 2016年1月22日
	 * @param string $class_level1 一级科室的名称
	 * @return array 二级科室
	 */
	public function actionGetclasslevel2($class_level1) {
		\Yii::$app->response->format=Response::FORMAT_JSON;
		$class_level2_json = [];
		
		if (isset($class_level1) && !empty($class_level1) && $class_level1 != "一级科室") {
			if (intval($class_level1) > 0) {
				$class_level1_id = $class_level1;
			}else {
				$class_level1_id = $this->department->getDepIDByName($class_level1);
			}
			$class_level2_json = $this->department->getDepartmentListById($class_level1_id);
		}
		return $class_level2_json;
	}
	
	/**
	 * 编辑疾病信息
	 * @author gaoqing
	 * 2016年1月19日
	 * @return string 视图信息
	 */
	public function actionUpdate() {
		$request = \Yii::$app->request;
		$diseaseid = $request->post("diseaseid", 0);
		
		//得到更新的信息
		$updateArr = $this->getAddMapArr($request, false);
		$flag = $this->disease->updateDisease($updateArr, $diseaseid);
		
		$msg = "失败，请重试！";
		if($flag) {
			$msg = "成功！";

			//删除图集
			$deletefiles = $request->post("deletefiles", "");
			$this->deleteImages($deletefiles, "exist");

			//将文件从 temp 中，复制到 uplods 中
			$backend = \Yii::getAlias("@backend");
			$path = $backend . "/web/";
			$sourcePath = $path . "temp";
			$destPath = $path . "uploads";
			$this->copyImage($request, $sourcePath, $destPath);
		}
		$params = [
				"promptFlag" => $flag,
				"promptMsg" => $msg,
				"operation" => "编辑",
		];
		return $this->render("alert", $params);
	}
	
	/**
	 * 跳转到编辑疾病信息页
	 * @author gaoqing
	 * 2016年1月19日
	 * @return string 视图信息
	 */
	public function actionGoupdate() {
		$request = \Yii::$app->request;
		$id = $request->get("id", 0);
		
		$diseaseAndRel = [];
		$class_level1s = [];
		if (!empty($id)) {
			//根据 id 查询相应的疾病信息
			$diseaseAndRel = $this->disease->getDiseaseById($id);

			//查询所有的一级科室
			$class_level1s = $this->department->getDepartmentLevel1();
		}
		$params = [
				"diseaseAndRel" => $diseaseAndRel,
				"class_level1s" => $class_level1s,
		];
		return $this->render("update", $params);
	}
	
	/**
	 * 删除疾病操作
	 * @author gaoqing
	 * 2016年1月19日
	 * @return string 视图信息
	 */
	public function actionDelete() {
		//返回 json 数据
		\Yii::$app->response->format=Response::FORMAT_JSON;
		
		$request = \Yii::$app->request;
		$ids = $request->get("id", "");
		$ids = trim($ids, ",");
		
		$flag = 0;
		if (!empty($ids)) {
			$idArr = explode(",", $ids);
			
			//逐个删除指定 id 下的疾病信息
			foreach ($idArr as $id){
				$flag = $this->disease->deleteDiseaseById($id);
			}
		}
		return ['flag' => $flag];
	}
	
	/**
	 * 相关症状
	 * @author gaoqing
	 * 2016年1月18日
	 * @return string 视图信息
	 */
	public function actionRelsymptom() {
		//得到所有的一级部位
		$part_level1s = $this->part->getPartLevel1();

		$page = 1;
		$size = 5;
		$count = 0;
		$pageHTML = $this->getPageHTML($page, $size, $count);
		
		$params = ['part_level1s' => $part_level1s, "pageHTML" => $pageHTML];
		return $this->renderPartial("relsymptom", $params);
	}
	
	/**
	 * 根据科室或者部位查询条件，组装成数组形式
	 * @author gaoqing
	 * 2016年1月19日
	 * @param Request $request 请求对象
	 * @param string $typeName 类型名称（part or class）
	 * @return array 组装成数组形式的查询条件及返回查询条件信息
	 */
	private function getQueryConditionByLevel($request, $typeName) {
		$queryConditions = [];
		
		$type_level1 = $typeName . "_level1";
		$type_level2 = $typeName . "_level2";
		
		$level1 = $request->post($type_level1, 0);
		$level2 = $request->post($type_level2, "");
		$diseaseName = $request->post("diseaseName", "");
		$symptomName = $request->post("symptomName", "");
		$level2_checked = [];
		
		if (!empty($diseaseName)) {
			$queryConditions['diseaseName'] = $diseaseName;
		}
		if (!empty($symptomName)) {
			$queryConditions['symptomName'] = $symptomName;
		}
		if ($level1 != 0) {
			$queryConditions[$type_level1] = $level1;
		}
		if ($level2 != "" && $level2 != 0) {
			$level2 = trim($level2, ",");
			$level2_checked = explode(",", $level2);
			$queryConditions[$type_level2] = $level2_checked;
		}
		return ["query" => $queryConditions];
	}
	
	/**
	 * 相关症状
	 * @author gaoqing
	 * 2016年1月18日
	 * @return string 视图信息
	 */
	public function actionGetrelsymptoms() {
		$request = \Yii::$app->request;
		$params = $this->getQueryConditionByLevel($request, "part");
		
		//得到查询条件
		$queryConditions = $params['query'];

		$page = $request->post("page", 1);
		$size = 5;
		$count = $this->symptom->getSymByPartCount($queryConditions);
		$pageHTML = $this->getPageHTML($page, $size, $count);
		
		$symptomArr = [];
		if (!empty($queryConditions)) {
			$start = ($page - 1) * $size;
			$symptomArr = $this->symptom->getSymptomsByPart($queryConditions, $start, $size);
		}
		$params = [
				'relsymptomArr' => $symptomArr,
				'pageHTML' => $pageHTML,
		];
		return $this->renderPartial("relsymptom_list", $params);
	}
	
	/**
	 * 相关疾病
	 * @author gaoqing
	 * 2016年1月18日
	 * @return string 视图信息
	 */
	public function actionGetreldiseases() {
		$request = \Yii::$app->request;
		
		$params = $this->getQueryConditionByLevel($request, "class");
		
		//得到查询条件
		$queryConditions = $params['query'];

		$page = $request->post("page", 1);
		$size = 5;
		$count = $this->disease->getDisByDepCount($queryConditions);
		$pageHTML = $this->getPageHTML($page, $size, $count);
		
		$diseaseArr = [];
		if (!empty($queryConditions)) {
			$start = ($page - 1) * $size;
			$diseaseArr = $this->disease->getDiseasesByDepartment($queryConditions, $start, $size);
		}
		$params = [
				'reldiseaseArr' => $diseaseArr,
				'pageHTML' => $pageHTML,
		];
		return $this->renderPartial("reldisease_list", $params);
	}
	
	/**
	 * 相关疾病
	 * @author gaoqing
	 * 2016年1月18日
	 * @return string 视图信息
	 */
	public function actionReldisease() {
		//查询一级科室
		$class_level1s = $this->department->getDepartmentLevel1();

		$page = 1;
		$size = 5;
		$count = 0;
		$pageHTML = $this->getPageHTML($page, $size, $count);

		$params = [
				'class_level1s' => $class_level1s,
				'pageHTML' => $pageHTML,
		];
		return $this->renderPartial("reldisease", $params);
	}
	
	/**
	 * 添加疾病页
	 * @author gaoqing
	 * 2016年1月14日
	 * @return string 视图信息
	 */
	public function actionInsert() {
		$request = \Yii::$app->request;
		
		//得到新增的数据集
		$addMapArr = $this->getAddMapArr($request);
		
		$flag = $this->disease->addDisease($addMapArr);
		
		$msg = "失败，请重试！";
		if($flag) {
			$msg = "成功！";

			//将文件从 temp 中，复制到 uplods 中
			$backend = \Yii::getAlias("@backend");
			$path = $backend . "/web/";
			$sourcePath = $path . "temp";
			$destPath = $path . "uploads";
			$this->copyImage($request, $sourcePath, $destPath);
		}
		$params = [
				"promptFlag" => $flag,
				"promptMsg" => $msg,
				"operation" => "添加",
		];
		echo $this->render("alert", $params);
	}
	
	/**
	 * 跳转到添加疾病页
	 * @author gaoqing
	 * 2016年1月14日
	 * @return string 视图信息
	 */
	public function actionGoadd() {
		
		//得到所有的一级科室
		$class_level1s = $this->department->getDepartmentLevel1();
		
		
		$params = [
				"class_level1s" => $class_level1s,
		];
		return $this->render("add", $params);
	}
	
	/**
	 * 疾病列表
	 * @author gaoqing
	 * 2016年1月13日
	 * @return string 视图信息
	 */
	public function actionIndex() {
		$view = "index";
		$request = \Yii::$app->request;
		$isSearch = $request->post("isSearch", 0);

		$class_level1s = [];
		if($isSearch == 0){
			//得到所有的一级科室
			$class_level1s = $this->department->getDepartmentLevel1();

		//查询操作：
		} else {
			$view = "index_list";
		}
		$query = $request->post("query", []);
		//得到查询条件数组
		$queryConditions = $this->getQueryConditions($query);

		//查询疾病信息
		$page = $request->post("page", 1);
		$size = 5;
		$start = ($page - 1) * $size;
		$count = $this->disease->getCounts($queryConditions);
		$pageHTML = $this->getPageHTML($page, $size, $count);

		$diseaseArr = $this->disease->getDiseasesByCondition($queryConditions, $start, $size);
		if (isset($diseaseArr) && !empty($diseaseArr)) {
			foreach ($diseaseArr as &$disease){
				$disease['inputtime'] = date('Y-m-d');
			}
		}
		$params = [
				"diseaseArr" => $diseaseArr,
				"class_level1s" => $class_level1s,
				"isSearch" => $isSearch,
				"pageHTML" => $pageHTML,
		];
		if($isSearch == 0){
			return $this->render($view, $params);
		}else{
			return $this->renderPartial($view, $params);
		}
	}
	
	/**
	 * 从 request 中，得到新增疾病信息的数组
	 * @author gaoqing
	 * 2016年1月15日
	 * @param Request $request 请求对象
	 * @param boolean $isAdd 是否是新增操作（默认是新增操作）
	 * @return array 新增疾病信息的数组
	 */
	private function getAddMapArr($request, $isAdd = true) {
		$addMapArr = [];
		if ($request->post("disease", -1) != -1) {
			$disease = $request->post("disease");
			if ($isAdd) {
                $pinyin_initial = Spell::Pinyin($disease['name'], 'utf-8', true);
                $capital = strtoupper($pinyin_initial[0]);
                $map_pinyin_sn =$this->getPinYinSnDic();
                $pinyin_initial_sn = isset($map_pinyin_sn[$capital]) ? ($map_pinyin_sn[$capital]+1) : 0;
				$addMapArr['disease'] = $this->setDefaultValues($disease, 
						[
                            'status' => 2, 'userid' => $this->user->id, 'username' => $this->user->login_name,
						    'inputtime' => time(), 'updatetime' => time(), 'type' => '0',
                            'capital' => $capital,
                            'capital_sn' => $pinyin_initial_sn,
                            'pinyin' => Spell::Pinyin($disease['name']),
                            'pinyin_initial' => $pinyin_initial,
                            'source_pinyin' => Spell::Pinyin($disease['name']),
                        ]);
			}else {
				$addMapArr['disease'] = $this->setDefaultValues($disease,
						[
                            'userid' => $this->user->id, 'username' => $this->user->login_name, 'updatetime' => time(),
                        ]);
			}
		}
		if ($request->post("diseaseDepartment", -1) != -1) {
			$diseaseDepartment = $request->post("diseaseDepartment");
			$addMapArr['diseaseDepartment'] = $this->splitDatasByJSON($diseaseDepartment);
		}
		if ($request->post("diseaseDisease", -1) != -1) {
			$diseaseDisease = $request->post("diseaseDisease");
			$addMapArr['diseaseDisease'] = $this->splitDatas($diseaseDisease, "rel_diseaseid");
		}
		if ($request->post("diseaseSymptom", -1) != -1) {
			$diseaseSymptom = $request->post("diseaseSymptom");
			$addMapArr['diseaseSymptom'] = $this->splitDatas($diseaseSymptom, "symptomid");
		}
		if ($request->post("diseaseImage", -1) != -1) {
			$diseaseImage = $request->post("diseaseImage");
			$diseaseImage = $this->splitDatasByJSON($diseaseImage);
			if (isset($diseaseImage) && !empty($diseaseImage)) {
				foreach ($diseaseImage as $image){
					$singleImage = $this->setDefaultValues($image, ['flag' => 1, 'createtime' => time(), 'updatetime' => time()]);
					
					$addMapArr['diseaseImage'][] = $singleImage;
				}
			}
		}
		if ($request->post("diseaseContent", -1) != -1) {
			$addMapArr['diseaseContent'] = $request->post("diseaseContent");
		}
		return $addMapArr;
	}
    
    /**
     * 获取拼音首字母对应的编号
     * @return type
     */
    public function getPinYinSnDic(){
        $pinyin_arr = range('A','Z');
        return array_flip($pinyin_arr);
    }
	
	/**
	 * 拆分JSON格式的字符串信息
	 * @author gaoqing
	 * 2016年1月18日
	 * @param string $param 被拆分的字符串信息
	 * @return array 拆分后的数组信息
	 */
	private function splitDatasByJSON($param) {
		$dataArr = [];
		if (isset($param) && !empty($param)) {
			$param = trim($param, "-");
			$tempArr = explode("-", $param);
			if (isset($tempArr) && !empty($tempArr)) {
				foreach ($tempArr as $temp){
					
					//将 json 数组转为数组：
					$dataArr[] = json_decode($temp, true);
				}
			}
		}
		return $dataArr;
	}
	
	/**
	 * 拆分字符串信息
	 * @author gaoqing
	 * 2016年1月18日
	 * @param string $param 被拆分的字符串信息
	 * @return array 拆分后的数组信息
	 */
	private function splitDatas($param, $columnName) {
		$dataArr = [];
		if (isset($param) && !empty($param)) {
			$param = trim($param, " ");
			$tempArr = explode(" ", $param);
			if (isset($tempArr) && !empty($tempArr)) {
				foreach ($tempArr as $temp){
					$inner = [];
					$inner[$columnName] = $temp;
					$dataArr[] = $inner;
				}
			}
		}
		return $dataArr;
	}
	
	/**
	 * 设置插入数据的默认值
	 * @author gaoqing
	 * 2016年1月15日
	 * @param array $initValues 表单数据的初始值
	 * @param array $defaults 要设置的默认值
	 * @return array 设置默认值后的插入数据
	 */
	private function setDefaultValues($initValues, $defaults) {
		$values = $initValues;
		if (isset($defaults) && !empty($defaults)) {
			if (isset($initValues) && !empty($initValues)) {
				$values = array_merge($initValues, $defaults);
			}
		}
		return $values;
	}
	
	/**
	 * 解析并组装前台传来的查询参数
	 * @author gaoqing
	 * 2016年1月21日
	 * @param array $query 前台的查询参数集
	 * @return array 组装后的查询条件集
	 */
	private function getQueryConditions($query) {
		$queryConditions = [];
		if(isset($query) && !empty($query)){
			//疾病部分
			$disease = [];
			if (!empty($query['id'])) {
				$disease['de.id'] = $query['id'];
			}
			if (!empty($query['name'])) {
				$queryConditions['name'] = $query['name'];
			}
			$queryConditions['disease'] = $disease;

			//科室部分
			$department = [];
			if (!empty($query['class_level1'])) {
				$department['class_level1'] = $query['class_level1'];
			}
			if (!empty($query['class_level2'])) {
				$department['ddr.class_level2'] = $query['class_level2'];
			}
			$queryConditions['department'] = $department;

			//症状部分
			if (!empty($query['symptomname'])) {
				$queryConditions['typical_symptom'] = $query['symptomname'];
			}
		}
		return $queryConditions;
	}

	/**
	 *得到分页
	 * @author gaoqing
	 * 2016-02-17
	 * @param int $page 当前页数
	 * @param int $size 每页显示条数
	 * @param int $count 总记录数
	 * @return string 分页的 html
	 */
	public function getPageHTML($page, $size, $count){
		$pageHTML = '<a href="javascript:;" class="hko kos" data-id = "pre">&lt;&lt;</a>';
		$first = 1;
		$paging = ($size + 1) / 2;
		$floor = ($size - 1) / 2;
		$total = ceil($count / $size);
		if($page > $paging){
			$first = $page - $floor;
		}
		for($i = 0; $i < $size; $i++){
			$currNum = $first + $i;
			if($currNum > $total){
				break;
			}
			$style = $page == $currNum ? "class='curt'" : "";
			$dataValue = $currNum == $total ? 'data-value = "end"' : '';
			$pageHTML .= '<a href="javascript:;" '. $style .' data-id = "page" '. $dataValue .' >'. $currNum .'</a>';
		}
		if($size < $total){
			$pageHTML .= '<span>...</span>';
			$pageHTML .= '<a href="javascript:;" data-id = "page" data-value = "end">'. $total .'</a>';
		}
		$pageHTML .= '<a href="javascript:;" class="hko" data-id = "next">&gt;&gt;</a>';
		return $pageHTML;
	}

	/**
	 * 将临时文件夹中的图集，复制到指定目录下
	 * @author gaoqing
	 * 2016-02-24
	 * @param yii\web\Request $request request对象
	 * @param string $sourcePath 文件源路径
	 * @param string $destPath 目标文件路径
	 */
	public function copyImage($request, $sourcePath, $destPath)
	{
		$files = $request->post("files", "");
		$files = trim($files, ",");
		if (!empty($files)) {
			$fileArr = explode(",", $files);
			if (!empty($fileArr)) {
                if(!file_exists($destPath) || !is_dir($destPath)){
                    mkdir($destPath, 0777);
                }
				foreach ($fileArr as $file) {
					$source = $sourcePath . DIRECTORY_SEPARATOR . $file;
					$dest = $destPath . DIRECTORY_SEPARATOR . $file;
					if (copy($source, $dest)) {
						unlink($source);
					};
				}
			}
		}
	}

	/**
	 * @param $fileName
	 * @param $from
	 * @param $path
	 * @return array
	 */
	public function deleteImages($fileName, $from)
	{
		$backend = \Yii::getAlias("@backend");
		$path = $backend . "/web/";

		$flags = [];
		$fileName = trim($fileName, ",");
		$fileNameArr = explode(",", $fileName);
		if (isset($fileNameArr) && !empty($fileNameArr)) {
			foreach ($fileNameArr as $name) {
				//找到文件的路径
				$uploadFile = $path . $this->path . $name;
				$tempFile = $path . $this->temp . $name;

				//删除当前文件
				if ($from == "exist") {
					if (is_file($uploadFile) && file_exists($uploadFile)) {
						$flags[] = unlink($uploadFile);
					}
				}
				if ($from == "add") {
					if (is_file($tempFile) && file_exists($tempFile)) {
						$flags[] = unlink($tempFile);
					}
				}
			}
			return $flags;
		}
		return $flags;
	}

}


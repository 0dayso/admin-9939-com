<?php

namespace common\models;

use librarys\models\BaseModel;
use yii\db\Query;
use yii\base\Exception;

/**
 * 疾病类
 * @author gaoqing
 * 2016年1月13日
 */
class Disease extends BaseModel{
	use DiseaseQueryTrait;        //使用 disease 的 trait
	private $department;
	private $symptom;
	private $image;
	
	/** 动态数组 */
	public $dynamicArr = [];
	
    public static function tableName(){
        return '{{%disease}}';
    }
    
    public static function getDb(){
    	return \Yii::$app->db_jbv2;
    }
    
    public function init(){
    	parent::init();
    	
    	$this->department = new Department();
    	$this->symptom = new Symptom();
    	$this->image = new Image();
    }

	/**
	 *得到疾病总数
	 * @author gaoqing
	 * 2016-02-16
	 * @param array $diseaseQuery 查询条件数据集
	 * @return int 疾病总数
	 */
	public function getCounts($diseaseQuery){
		$queryObj = new Query();
		$queryObj
				->select(["de.id", "de.name", "de.typical_symptom", "de.inputtime"])
				->from("9939_disease de");
		$queryObj = $this->getQueryCondition($diseaseQuery, $queryObj);

		return $queryObj->count('*',static::getDb());
	}
    
    /**
     * 更新疾病的信息
     * @author gaoqing
     * 2016年1月20日
     * @param array $updateArr 更新的疾病信息值
     * @param int $diseaseid 疾病id
     * @return int 更新成功与否标识（0：失败；1：成功）
     */
    public function updateDisease($updateArr, $diseaseid) {
    	$flag = 0;
    	
    	if (!empty($diseaseid)) {
    		$connection = self::getDb();
    		//开始事物操作
    		$transaction = $connection->beginTransaction();
    		try {
    			//更新疾病信息
    			$connection->createCommand()->update("9939_disease", $updateArr['disease'], "id = " . $diseaseid)->execute();
    			$connection->createCommand()->update("9939_disease_content", $updateArr['diseaseContent'], "id = " . $diseaseid)->execute();
    			
    			//删除所有关联表的相关数据
    			$this->deleteDiseaseRel($diseaseid, $connection);
    			
    			//重新新增关联表的相关数据
    			$this->addDiseaseRel($connection, $updateArr, $diseaseid);
    			
    			$transaction->commit();
    			$flag = 1;
    		} catch (Exception $e) {
    			$transaction->rollBack();
    		}
    	}
    	return $flag;
    }
    
    /**
     * 根据疾病id,查询疾病及相关疾病信息
     * @author gaoqing
     * 2016年1月19日
     * @param int $id 疾病id
     * @return array 疾病及相关疾病信息
     */
    public function getDiseaseById($id) {
    	$diseaseAndRel = [];
    	
    	//查询疾病信息
    	$disease = Disease::find()->select(["id", "name", "alias", "description", "treat_department", "typical_symptom", "pinyin_initial"])->where(["id" => $id])->asArray(true)->one();
    	//查询疾病详细信息
    	$diseaseContent = DiseaseContent::find()->where(["id" => $id])->asArray(true)->one();
    	//所属科室
    	$diseaseDepartment = $this->getDepsByDisID($id);
    	//相关疾病
    	$diseaseDisease = $this->getDiseaseDisByDisid($id);
    	//相关症状
    	$diseaseSymptom = $this->symptom->getSymptomsByDisid($id);
    	//疾病图集
    	$diseaseImage = $this->image->getImagesByDiseaseid($id);
    	
    	$diseaseAndRel['disease'] = $disease;
    	$diseaseAndRel['diseaseContent'] = $diseaseContent;
    	$diseaseAndRel['diseaseDepartment'] = $diseaseDepartment;
    	$diseaseAndRel['diseaseDisease'] = $diseaseDisease;
    	$diseaseAndRel['diseaseSymptom'] = $diseaseSymptom;
    	$diseaseAndRel['diseaseImage'] = $diseaseImage;
    	
    	return $diseaseAndRel;
    }
    
    /**
     * 根据疾病id，得到其所属的科室信息
     * @author gaoqing
     * 2016年1月25日
     * @param int $diseaseid 疾病id
     * @return array 所属的科室信息集
     */
    private function getDepsByDisID($diseaseid){
    	$departments = [];
    	
    	$disDeps = $this->department->getDepartmentsByDisid($diseaseid);
    	if (isset($disDeps) && !empty($disDeps)) {
    		foreach ($disDeps as $disDep){
    			//查询科室的名称：
    			$class_level1s = $this->department->getDepartmentById($disDep['class_level1']);
    			$class_level2s = $this->department->getDepartmentById($disDep['class_level2']);
    			$disDep['class_level1_name'] = (isset($class_level1s) && !empty($class_level1s)) ? $class_level1s['name']: "";
    			$disDep['class_level2_name'] = (isset($class_level2s) && !empty($class_level2s)) ? $class_level2s['name']: "";
    			
    			$departments[] = $disDep;
    		}
    	}
    	return $departments;
    }
    
    /**
     * 根据疾病Id, 得到其相关疾病的信息
     * @author gaoqing
     * 2016年1月19日
     * @param int $diseaseid 疾病id
     * @return array 相关疾病的信息
     */
    public function getDiseaseDisByDisid($diseaseid){
    	$diseaseDisease = [];
    	$connection = $this->getDb();
    	
    	$sql = " SELECT * from 9939 de.id, de.name,de.pinyin_initial FROM 9939_disease de, ( SELECT ddr.rel_diseaseid diseaseid from 9939_disease_disease_rel ddr WHERE ddr.diseaseid = :diseaseid ) sde ";
    	$where = " WHERE de.id = sde.diseaseid ";

    	$diseaseDisease = $connection->createCommand($sql . $where, [":diseaseid" => $diseaseid])->queryAll(\PDO::FETCH_ASSOC);

    	return $diseaseDisease;
    }
    
    /**
     * 根据疾病id，删除疾病信息
     * @author gaoqing
     * 2016年1月19日
     * @param int $id 疾病id
     * @return int 删除成功与否标识（0：失败；1：成功）
     */
    public function deleteDiseaseById($id) {
    	$flag = 0;
    	$connection = self::getDb();
    	
    	$transaction = $connection->beginTransaction();
    	try {
    		$connection->createCommand()->delete("9939_disease", "id = :id", [":id" => $id])->execute();
    		$connection->createCommand()->delete("9939_disease_content", "id = :id", [":id" => $id])->execute();
    		$connection->createCommand()->delete("9939_part_disease_rel", "diseaseid = :id", [":id" => $id])->execute();
    		$connection->createCommand()->delete("9939_article_disease_rel", "diseaseid = :id", [":id" => $id])->execute();
    		$connection->createCommand()->delete("9939_category_disease_rel", "diseaseid = :id", [":id" => $id])->execute();
    		
    		//删除疾病的相关信息
    		$this->deleteDiseaseRel($id, $connection);
    		
    		$transaction->commit();
    		
    		$flag = 1;
    	} catch (Exception $e) {
    		$transaction->rollBack();
    	}
    	return $flag;
    }
    
    /**
     * 删除疾病的相关
     * @author gaoqing
     * 2016年1月20日
     * @param int $diseaseid 疾病id 
     * @param yii\db\Connection $connection 数据库连接对象
     * @return void 空
     */
    private function deleteDiseaseRel($diseaseid, $connection) {
    	$connection->createCommand()->delete("9939_image", "relid = :id", [":id" => $diseaseid])->execute();
    	$connection->createCommand()->delete("9939_disease_symptom_rel", "diseaseid = :id", [":id" => $diseaseid])->execute();
    	$connection->createCommand()->delete("9939_disease_disease_rel", "diseaseid = :id", [":id" => $diseaseid])->execute();
    	$connection->createCommand()->delete("9939_disease_department_rel", "diseaseid = :id", [":id" => $diseaseid])->execute();
    }
    
    /**
     * 根据科室信息，查询相关疾病
     * @author gaoqing
     * 2016年1月19日
     * @param array $queryConditions 查询条件（指定科室）
	 * @param int $start 分页开始值
	 * @param int $size 每页显示的条数
     * @return array 疾病集
     */
    public function getDiseasesByDepartment($queryConditions, $start, $size) {
        $diseaseArr = [];

        if (isset($queryConditions) && !empty($queryConditions)) {
            $query = $this->pakingQueryByDep($queryConditions);
            $query->offset($start)->limit($size);
            $diseaseArr = $query->createCommand(self::getDb())->queryAll(\PDO::FETCH_ASSOC);
        }
        return $diseaseArr;
    }

    /**
     * 根据科室信息，查询相关疾病数
     * @author gaoqing
     * 2016年2月17日
     * @param array 查询条件（指定科室）
     * @return int 相关疾病总数
     */
    public function getDisByDepCount($queryConditions) {
        $count = 0;

        if (isset($queryConditions) && !empty($queryConditions)) {
            $query = $this->pakingQueryByDep($queryConditions);
            $count = $query->count();
        }
        return $count;
    }

    /**
     * 插入疾病信息及其相关数据
     * @author gaoqing
     * 2016年1月15日
     * @param array $addMapArr 要插入的疾病信息集
     * @return int 成功标识（0：失败；1：成功）
     */
    public function addDisease($addMapArr) {
    	$flag = 0;
    	
    	if (isset($addMapArr) && !empty($addMapArr)) {
    		$connection = self::getDb();
    		
    		//开始事物操作
    		$transaction = $connection->beginTransaction();
    		try {
    			//插入 9939_disease 表信息
    			$diseaseid = $this->insertDisease($connection, "9939_disease", $addMapArr['disease']);
						
				//插入 9939_disease_content 表信息
    			$diseaseContentParams = $this->getDiseaseInsertColumns($addMapArr, "diseaseContent", "id", $diseaseid);
    			$this->batchInsertDisease($connection, "9939_disease_content", $diseaseContentParams);
    			
    			//添加疾病的相关信息
				$this->addDiseaseRel($connection, $addMapArr, $diseaseid);		
    			
    			$transaction->commit();
    			$flag = 1;
    		} catch (Exception $e) {
    			$transaction->rollBack();
    		}
    	}
    	return $flag;
    }
    
    /**
     * 添加疾病表的相关信息
     * @author gaoqing
     * 2016年1月20日
     * @param yii\db\Connection $connection 数据库连接对象
     * @param array $addMapArr 要插入的疾病信息集
     * @param int $diseaseid 疾病表id
     * @return void 空
     */
    private function addDiseaseRel($connection, $addMapArr, $diseaseid) {
    	//插入 9939_disease_department_rel 表信息
    	$diseaseDepartmentParams = $this->getDiseaseInsertColumns($addMapArr, "diseaseDepartment", "diseaseid", $diseaseid);
    	$this->batchInsertDisease($connection, "9939_disease_department_rel", $diseaseDepartmentParams);
    	 
    	//插入 9939_disease_disease_rel 表信息
    	$diseaseDiseaseParams = $this->getDiseaseInsertColumns($addMapArr, "diseaseDisease", "diseaseid", $diseaseid);
    	$this->batchInsertDisease($connection, "9939_disease_disease_rel", $diseaseDiseaseParams);
    	 
    	//插入 9939_disease_symptom_rel 表信息
    	$diseaseSymptomParams = $this->getDiseaseInsertColumns($addMapArr, "diseaseSymptom", "diseaseid", $diseaseid);
    	$this->batchInsertDisease($connection, "9939_disease_symptom_rel", $diseaseSymptomParams);
    	 
    	//插入 9939_image 表信息
    	$diseaseImageParams = $this->getDiseaseInsertColumns($addMapArr, "diseaseImage", "relid", $diseaseid);
    	$this->batchInsertDisease($connection, "9939_image", $diseaseImageParams);
    }
    
    /**
     * 得到插入的字段及值
     * @author gaoqing
     * 2016年1月15日
     * @param array $addMapArr 要插入的疾病信息集
     * @param string $key 【$addMapArr】中 key 的值
     * @param string $appendColumnName 追加列的名称
     * @param string $appendColumnVal 追加列的值
     * @return array 插入的字段及值
     */
    private function getDiseaseInsertColumns($addMapArr, $key, $appendColumnName = null, $appendColumnVal = null) {
    	if (!isset($addMapArr) || !isset($addMapArr[$key])) {
    		throw new \Exception($key . " 下，无更新数据！");
    		return;
    	}
    	$valArr = $addMapArr[$key];
    	$insertParams = [];
    	//判断当前数组是一维数组还是二维数组（单条插入 or 批量插入）
    	if (isset($valArr) && !empty($valArr)) {
    		
    		//二维数组
    		if (isset($valArr[0])) {
    			$values = [];
		    	if ($appendColumnName != null) {
		    		foreach ($valArr as &$initVal){
		    			//将追加的 字段 绑定原数组中
				    	$initVal[$appendColumnName] = $appendColumnVal;
				    	$values[] = array_values($initVal);
		    		}
		    	}
    			$columns = array_keys($valArr[0]);
    			
    			$insertParams['columns'] = $columns;
    			$insertParams['values'] = $values;
    			
    		//一维数组	
    		}else {
    			if ($appendColumnName != null) {
    				$valArr[$appendColumnName] = $appendColumnVal;
    			}
    			$insertParams['columns'] = array_keys($valArr);
    			$insertParams['values'][] = array_values($valArr);
    		}
    	}
    	return $insertParams;
    }
    
	/**
	 * 单条插入疾病及疾病相关信息
	 * @author gaoqing
	 * 2016年1月15日
	 * @param  yii\db\Connection $connection 数据库连接对象
	 * @param  string $tableName 表名
	 * @param  array $columns 插入的数据（name => value）
	 * @return string 最后插入的ID值
	 */
	 private function insertDisease($connection, $tableName, $columns) {
	 	if (!isset($columns) || empty($columns)) {
	 		throw new \Exception("无更新数据！");
	 		return;
	 	}
		$command = $connection->createCommand()->insert($tableName, $columns);
		$command->execute();
		return $command->db->getLastInsertID();
	}
	
	/**
	 * 批量插入疾病及疾病相关信息
	 * @author gaoqing
	 * 2016年1月15日
	 * @param  yii\db\Connection $connection 数据库连接对象
	 * @param  string $tableName 表名
	 * @param  array $insertParams 插入数据的字段集及值（columns, values）
	 * @return string 最后插入的ID值
	 */
	 private function batchInsertDisease($connection, $tableName, $insertParams) {
	 	if (!isset($insertParams) || empty($insertParams)) {
	 		throw new \Exception($tableName . "下，无更新数据！");
	 		return;
	 	}
		$command = $connection->createCommand()->batchInsert($tableName, $insertParams['columns'], $insertParams['values']);
		
		return $command->execute();
	}

    /**
     * 根据条件，查询疾病信息
     * @author gaoqing
     * 2016年1月14日
     * @param array $diseaseQuery 查询条件
     * @param int $start 开始值
     * @param int $size 每次查询的条数
     * @return array 疾病信息集
     */
    public function getDiseasesByCondition($diseaseQuery, $start = 0, $size = 10) {
    	$diseaseArr = [];
    	
    	//组装查询对象
    	$queryObj = new Query();
    	$queryObj
    			->select(["de.id", "de.name", "de.typical_symptom", "de.inputtime"])
    			->from("9939_disease de");
    	$queryObj = $this->getQueryCondition($diseaseQuery, $queryObj);
    	$queryObj->offset($start);
    	$queryObj->limit($size);
    	
    	$command = $queryObj->createCommand(static::getDb());
    	$diseaseArr = $command->queryAll(\PDO::FETCH_ASSOC);
    	
    	return $diseaseArr;
    }
    
	/**
	 * 得到查询条件的字符串值
	 * @author gaoqing
	 * 2016年1月14日
	 * @param array $diseaseQuery 查询条件
	 * @param Query $queryObj Query 查询对象
	 * @return string 查询条件的字符串值
	 */
	 private function getQueryCondition($diseaseQuery, $queryObj) {
	 	//判断是否有科室方面的查询条件
	 	if (isset($diseaseQuery['department']) && !empty($diseaseQuery['department'])) {
	 		$department = $diseaseQuery['department'];
	 		$queryObj->innerJoin("9939_disease_department_rel ddr", "de.id = ddr.diseaseid");
	 		$queryObj->andWhere($department);
	 	}
	 	//判断是否有疾病表中的查询条件
	 	if (isset($diseaseQuery['disease']) && !empty($diseaseQuery['disease'])) {
	 		$disease = $diseaseQuery['disease'];
	 		$queryObj->andWhere($disease);
	 	}
	 	//判断是否根据疾病名称，模糊查询
	 	if (isset($diseaseQuery['name'])) {
	 		$name = $diseaseQuery['name'];
	 		$queryObj->andWhere(["like", "de.name", $name]);
	 	}
	 	//判断是否根据症状信息，模糊查询
	 	if (isset($diseaseQuery['typical_symptom'])) {
	 		$symptom = $diseaseQuery['typical_symptom'];
	 		$queryObj->andWhere(["like", "de.typical_symptom", $symptom]);
	 	}
	 	return $queryObj;
	}
    
         /**
     * 疾病名称 => 查询某一科室下的疾病
     * @param string $name 疾病名称
     * @param integer $departmentid 科室id
     * @param integer $like 0=>正常查询； 1=>模糊查询
     * @param integer $start 
     * @param integer $offset
     * @return array 返回查询结果数组
     */
    public function getDiseaseByName($name = '', $departmentid, $like = 0, $start = 0, $offset = 10) {
        
        if (!empty($name)) {
            if ($like == 1) {
                $sql = 'select dis.id,name 
                    from 9939_disease as dis 
                    join 9939_disease_department_rel as dd 
                    on (dis.id = dd.diseaseid) 
                    where departmentid = :departmentid and name like :name 
                    limit ' . $start . ',' . $offset;
                $params = [':departmentid' => $departmentid, ':name' => '%' . $name . '%'];
            } else {
                $sql = 'select dis.id,name 
                    from 9939_disease as dis 
                    join 9939_disease_department_rel as dd 
                    on (dis.id = dd.diseaseid) 
                    where departmentid = :departmentid and name = :name
                    limit ' . $start . ',' . $offset;
                $params = [':departmentid' => $departmentid, ':name' => $name];
            }
        } else {
                $sql = 'select dis.id,name 
                    from 9939_disease as dis 
                    join 9939_disease_department_rel as dd 
                    on (dis.id = dd.diseaseid) 
                    where departmentid = :departmentid
                    limit ' . $start . ',' . $offset;
                $params = [':departmentid' => $departmentid];
        }



        $db = \Yii::$app->db_jbv2;
        return $db->createCommand($sql, $params)->queryAll(\PDO::FETCH_ASSOC);
    }
     /**
      * 配合getDiseaseByName()使用
     * 疾病名称 => 查询某一科室下的疾病数目
     */
    public function getDiseaseCountByName($name = '', $departmentid, $like = 0) {
        
        if(!empty($name)){
            if($like == 1){
                
                $sql = 'select count(dis.id) as count
                    from 9939_disease as dis 
                    join 9939_disease_department_rel as dd 
                    on (dis.id = dd.diseaseid) 
                    where departmentid = :departmentid and dis.name like :name';
            $params = [':departmentid' => $departmentid, ':name' => '%' . $name . '%'];
            $res = \Yii::$app->db_jbv2->createCommand($sql, $params)->queryAll(\PDO::FETCH_ASSOC);
            return $res['0']['count'];//;
            }else{
                return $this->getCounts([
                    'disease'=>[
                        'name'=>$name,
                    ],
                    'departmentid'=>[
                        'departmentid'=>$departmentid,
                    ],
                ]);
            }
        }else{
            return $this->getCounts(['department'=>['departmentid'=>$departmentid]]);
        }
    }
    /**
     * 根据 科室 或 疾病名称 获取疾病
     * @param type $param ['class_level1'=>$class_level1,'class_level2'=>$class_level2,'name'=>$diseasename]
     * retrun array $res 返回结果数组数据
     */
    public function getDiseaseByDepatmentAndName($param, $offset = 0, $length = 10) {
        $str = '';
        if (!empty($param['class_level1'])) {
            $str .= 'and class_level1 = ' . $param['class_level1'].' ';
        }
        if (!empty($param['class_level2'])) {
            $str .= 'and class_level2 = ' . $param['class_level2'].' ';
        }
        if (!empty($param['name'])) {
            $str .= 'and dis.name = "' . $param['name'].'" ';
        }
        $where = substr($str, 3);
        $query = new Query();
        $query->select([ 'ddr.class_level1', 'ddr.class_level2', 'dis.id','dis.name'])
                ->from('9939_disease_department_rel as ddr')
                ->join('LEFT JOIN', '9939_disease as dis', 'ddr.diseaseid = dis.id')
                ->where($where)
                ->limit($length)
                ->offset($offset);
        $command = $query->createCommand(static::getDb());
        $res = $command->queryAll();
        return $res;
    }
    
    /**
     * 根据 科室 或 疾病名称 获取疾病数目
     * @param type $param ['class_level1'=>$class_level1,'class_level2'=>$class_level2,'name'=>$diseasename]
     * retrun array $res 返回结果数组数据
     */
    public function getDisCountsByDepAndName($param) {
        $str = '';
        if (!empty($param['class_level1'])) {
            $str .= 'and class_level1 = ' . $param['class_level1'].' ';
        }
        if (!empty($param['class_level2'])) {
            $str .= 'and class_level2 = ' . $param['class_level2'].' ';
        }
        if (!empty($param['name'])) {
            $str .= 'and dis.name = "' . $param['name'].'" ';
        }
        $where = substr($str, 3);
        $query = new Query();
        $query->select([ 'count(ddr.id) as cou'])
                ->from('9939_disease_department_rel as ddr')
                ->join('LEFT JOIN', '9939_disease as dis', 'ddr.diseaseid = dis.id')
                ->where($where);
        $command = $query->createCommand(static::getDb());
        $res = $command->queryAll();
        return $res['0']['cou'];
    }
    
    /**
     * 分类ID 获取疾病
     * @param type $categoryId
     * @return type
     */
    public function getDiseaseByCategoryId($categoryId) {
        $query = new Query();
        $query->select([ 'cdr.class_level1', 'cdr.class_level2', 'dis.id','dis.name','dis.pinyin_initial'])
                ->from('9939_category_disease_rel as cdr')
                ->join('LEFT JOIN', '9939_disease as dis', 'cdr.diseaseid = dis.id')
                ->where('categoryid = :id');
        $command = $query->createCommand(static::getDb())->bindValue(':id', $categoryId);
        $res = $command->queryAll();
        return $res;
    }
    
    /**
     * 批量分类ID 获取疾病
     * lc 2016-4-14
     * @param type $categoryId array
     * @return type
     */
    public function batGetDiseaseByCategoryId($categoryId) {
        $query = new Query();
        $query->select([ 'cdr.class_level1', 'cdr.class_level2', 'cdr.categoryid', 'dis.id','dis.name','dis.pinyin_initial'])
                ->from('9939_category_disease_rel as cdr')
                ->join('LEFT JOIN', '9939_disease as dis', 'cdr.diseaseid = dis.id')
                ->where(['in', 'categoryid', $categoryId]);
        $res = $query->createCommand(static::getDb())->queryAll();
        return $res;
    }
    
    /**
     * 封装根据科室，查询疾病的条件
     * @param array $queryConditions 条件查询数据集
     * @return yii\db\Query 查询条件对象
     */
    public function pakingQueryByDep($queryConditions)
    {
        $query = new Query();
        $query->select("de.id, de.name")->from("9939_disease de ");

        if (isset($queryConditions['diseaseName']) && !empty($queryConditions['diseaseName'])) {
            $query->andWhere(['LIKE', "de.name", $queryConditions['diseaseName']]);
        }
        $hasSubQuery = false;
        $subQuery = new Query();
        if (isset($queryConditions['class_level1']) && !empty($queryConditions['class_level1'])) {
            $subQuery->select("ddr.diseaseid")->from("9939_disease_department_rel ddr  ");
            $subQuery->andWhere(["ddr.class_level1" => $queryConditions['class_level1']]);
            $hasSubQuery = true;
        }
        if (isset($queryConditions['class_level2']) && !empty($queryConditions['class_level2'])) {
            if (!isset($queryConditions['class_level1'])) {
                $subQuery->select("ddr.diseaseid")->from("9939_disease_department_rel ddr ");
            }
            $subQuery->andWhere(["ddr.class_level2" => $queryConditions['class_level2']]);
            $hasSubQuery = true;
        }
        if ($hasSubQuery) {
            $query->andWhere(["in", "de.id", $subQuery]);
            return $query;
        }
        return $query;
    }
    
    /**
     * 根据疾病id批量查询疾病信息
     * lc 2016-4-12
     * @param type $ids
     * @return type
     */
    public function batchGetDiseaseById($ids) {
    	//查询疾病信息
    	$disease = Disease::find()
                ->select(["id", "name", "description", "pinyin_initial", 'treat_department'])
                ->where(['in', 'id', $ids])
                ->asArray()
                ->all();
    	return $disease;
    }
    
    /**
     * 
     * @param type $diseaseids
     * @return array|bool
     */
    public static function List_ByIds($diseaseids = array()) {
        if (count($diseaseids) == 0) {
            return false;
        }
        $ids = implode(',', $diseaseids);
        $sql = "select * from 9939_disease where id in ($ids) order by field(id,$ids)";
        $result = static::getDb()->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getAllDisease() {
        $sql = "select id,name,keywords,pinyin_initial from 9939_disease where status=2";
        $result = static::getDb()->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * 获取所有疾病症状条数
     * @return type array
     */
    public function getCount() {
        return Disease::find()
                        ->count();
    }

    public function getDiseaseLimit($where = [], $offset = 0, $length = 10, $orderBy = 'id DESC') {
        return Disease::find()
                        ->where($where)
                        ->orderBy($orderBy)
                        ->offset($offset)
                        ->limit($length)
                        ->asArray()
                        ->all();
    }

}

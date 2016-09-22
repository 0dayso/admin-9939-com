<?php

namespace common\models;

use Yii;
use librarys\models\BaseModel;
use yii\db\Query;

/**
 * CategoryDisease 疾病分类 model
 */
class CategoryDisease extends BaseModel {

    public static function tableName() {
        return '{{%category_disease}}';
    }
    public function rules() {
        return [
            [['id','name','createtime','updatetime','userid','username'],'safe'],
        ];
    }
    public static function getDb() {
        return Yii::$app->db_jbv2;
    }

    /**
     * 添加分类
     * @param type $param
     * @return boolean
     */
    public function addCategory($param) {
        $this->attributes = $param;
        if ($this->save()) {
            return $this->attributes['id'];
        } else {
            return false;
        }
    }

    /**
     * 编辑分类
     * @param array $param
     * @return boolean
     */
    public function editCategory($param) {
        $id = $param['id'];
//        $name = $param['name'];
//        $param['name'] = ':name';
//        $bind = [
//            ':id' => $id,
//        ];
        unset($param['id']);

        $connection = self::getDb();
        $res = $connection->createCommand()->update('9939_category_disease', $param, 'id = :id')->bindValue(':id',$id)->execute();

        if (is_numeric($res)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 按 categoryid 查询该分类下的所有疾病
     * @param category $categoryId 分类ID
     */
    public function getDiseaseByCategoryId($categoryId) {
        $query = new Query();
        $query->select(['cdr.id as id', 'cdr.diseaseid', 'cdr.class_level11', 'cdr.class_level2', 'd.name'])
                ->from('9939_category_disease_rel as cdr')
                ->join('LEFT_JOIN', '9939_disease as d', 'd.id = cdr.diseaseid');
        $command = $query->createCommand(static::getDb());
        $res = $command->queryAll();
        return $res;
    }

    /**
     * 绑定  分类和疾病
     * @param string $categoryid 分类ID
     * @param array  [[$diseaseid,$class_level1,$class_level2],[$diseaseid,$class_level1,$class_level2],...]
     */
    public function addCategoryDiseaseRel($categoryId, $param) {
        $del = $this->deleteCategoryDiseaseRel($categoryId);
        if ($del || $del == 0) {
            $columns = ['categoryid', 'diseaseid', 'class_level1', 'class_level2'];
            $values = [];
            if (is_array($param)) {
                foreach ($param as $k => $v) {
                    $values[] = [$categoryId, $v['diseaseid'], $v['class_level1'], $v['class_level2']];
                }
            }
            $connection = static::getDb();
            $res = $connection->createCommand()->batchInsert('9939_category_disease_rel', $columns, $values)->execute();
            return $res['0'];
        }
        return false;
    }

    /**
     * 根据id获取单条分类
     * @param integer $id
     */
    public function getCategoryById($id) {
        $connection = self::getDb();
        $sql = 'SELECT id,name,createtime,updatetime,userid,username 
                 FROM 9939_category_disease  
                 WHERE id = :id';
        $res = $connection->createCommand($sql)->bindValue(':id', $id)->queryOne();
        return $res;
    }
    
    /**
     * 获取分类列表
     * @param array $condition 为[]时，获取所有科室
     * @param integer $offset
     * @param integer $length
     */
    public function getCategory($condition = [], $offset = 0, $length = 10) {
        $where = '';
        $bind = [];
        if (!empty($condition)) {
            if (array_key_exists('name', $condition)) {
                $where .= 'and name = :name ';
                $bind[':name'] = $condition['name'];
            }
            if (array_key_exists('userid', $condition)) {
                $where .= 'and userid = :userid ';
                $bind[':userid'] = $condition['userid'];
            }
            if (array_key_exists('username', $condition)) {
                $where .= 'and username = :username ';
                $bind[':username'] = $condition['username'];
            }
            $where = !empty($where) ? ' WHERE '.substr($where, 3) : '';
        }
        $sql = "SELECT id,name,createtime,updatetime,userid,username 
               FROM 9939_category_disease 
               {$where} 
               limit {$offset} , {$length}";
        $connect = $this->getDb();
        $res = $connect->createCommand($sql, $bind)->queryAll(\PDO::FETCH_ASSOC);
        return $res;
    }
    /**
     * 删除分类
     * @param type $categoryIds [$id1,$id2,……]
     */
    public function deleteCategory($categoryIds) {
        $connection = self::getDb();
        $model = $connection->createCommand('DELETE FROM 9939_category_disease WHERE id=:id');
        $flag = true;
        foreach ($categoryIds as $k => $v) {
            $this->deleteCategoryDiseaseRel($v);
            $model->bindParam(':id', $v);
            $res = $model->execute();
            if (is_bool($res)) {
                $flag = false;
                break;
            }
        }
        return $flag;
    }

    /**
     * 获取分类数目
     * @param array $condition 为[]时，获取所有科室
     * $return string 返回分类数目
     */
    public function getCounts($condition = []) {
        $where = '';
        $bind = [];
        if (!empty($condition)) {
            if (array_key_exists('name', $condition)) {
                $where .= 'and name = :name ';
                $bind[':name'] = $condition['name'];
            }
            if (array_key_exists('userid', $condition)) {
                $where .= 'and userid = :userid ';
                $bind[':userid'] = $condition['userid'];
            }
            if (array_key_exists('username', $condition)) {
                $where .= 'and username = :username ';
                $bind[':username'] = $condition['username'];
            }
            $where = !empty($where) ? ' WHERE '.substr($where, 3) : '';
        }
        $sql = "SELECT count(id) as cou 
               FROM 9939_category_disease 
               {$where}";
        $connect = $this->getDb();
        $res = $connect->createCommand($sql, $bind)->queryAll(\PDO::FETCH_ASSOC);
        return $res['0']['cou'];
    }
    /**
     * 解除  分类和疾病  所有关系
     * @param integer $categoryId 分类ID
     * @param array $relation_ids 关联表id的索引数组
     */
    public function deleteCategoryDiseaseRel($categoryId, $relationIds = []) {
        $count = count($relationIds);
        $connection = $this->getDb();
        if ($count === 0) {
            $res = $connection->createCommand()->delete('9939_category_disease_rel', 'categoryid = :categoryid', ['categoryid' => $categoryId])->execute();
        } elseif ($count > 0) {
            $res = $connection->createCommand()->delete(['in', 'id', $relationIds])->execute();
        }
        return $res;
    }
    
}

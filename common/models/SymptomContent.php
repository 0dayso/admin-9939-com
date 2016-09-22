<?php

namespace common\models;

use librarys\models\BaseModel;
use yii\base\UnknownMethodException;
use yii\db\Query;

class SymptomContent extends BaseModel {
    private $query;
    
    public static function tableName() {
        return '{{%symptom_content}}';
    }

    public static function getDb() {
        return \Yii::$app->db_jbv2;
    }
    
    public function init() {
        parent::init();
        $this->query = new Query();
    }
    
    public function rules() {
        return [
            [['id'], 'integer'],
            [['cause', 'examine', 'diagnose', 'relieve', 'goodfood', 'badfood'], 'safe'],
        ];
    }
    
    public function getSymptomContentById($columns='*', $id){
        $res = $this->query
                    ->select($columns)
                    ->from(self::tableName())
                    ->where(['id'=>[$id]])
                    ->one(self::getDb());
        return $res;
    }
    
    /**
     * 添加症状详情
     */
    public function addSymptomContent($id = NULL, $data) {
        $this->isNewRecord = true;
        $this->attributes = $data;
        $this->id = $id;
        if ($this->validate($this->attributes) && $this->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 修改症状详情
     */
    public function editSymptomContent($data) {
        $model = self::findOne($data['id']);
        $model->attributes = $data;
        if ($model->validate($this->attributes) && $model->save()) {
            return true;
        } else {
            return false;
        }
    }

}

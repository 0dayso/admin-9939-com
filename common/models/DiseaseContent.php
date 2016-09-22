<?php

namespace common\models;

use librarys\models\BaseModel;

/**
 * 疾病详细信息类
 * @author gaoqing
 * 2016年1月19日
 */
class DiseaseContent extends BaseModel{
	
	public static function tableName() {
		return '{{%disease_content}}';;
	}
	
	public static function getDB(){
		return \Yii::$app->db_jbv2;
	}
	
	
}


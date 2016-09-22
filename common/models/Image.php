<?php

namespace common\models;

use librarys\models\BaseModel;

class Image extends BaseModel{
	
	public static function tableName(){
		return '{{%image}}';
	}
	
	public function init(){
		parent::init();
		
	}
	
	public static function getDb() {
		return \Yii::$app->db_jbv2;
	}
	
	/**
	 * 根据疾病id, 查询相关图集信息
	 * @author gaoqing
	 * 2016年1月19日
	 * @param int $diseaseid 疾病id
	 * @return array 图集信息
	 */
	public function getImagesByDiseaseid($diseaseid) {
		$image = [];
		$image = Image::find()
					->asArray()
					->select(["id", "name", "weight", "flag"])
					->where("flag = :flag AND relid = :relid", [":flag" => 1, ":relid" => $diseaseid])
					->all();	
		return $image;
	}
	
}


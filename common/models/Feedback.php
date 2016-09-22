<?php

namespace common\models;

use librarys\models\BaseModel;
use yii\base\UnknownMethodException;
use yii\db\Query;

class Feedback extends BaseModel {

    public function rules() {
        return [
            [['id'],'integer'],
            [['url','surgets','content','contact','images','userid','username','createtime'],'safe'],
        ];
    }
   public function feedbackAdd($param=[]){
	$this->attributes = $param;
        if($this->save()){
            return 1;
        }else{
            return 0;
        }
   }

}

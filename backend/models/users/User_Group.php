<?php

namespace backend\models\users;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */

class User_Group extends BaseModel{
    
            
     /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_group}}';
    }
    
    public static function getDb()
    {
        return Yii::$app->db_portal;
    }

    
    public function rules() {
        return [
        ];
    }
}

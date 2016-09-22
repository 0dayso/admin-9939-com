<?php

namespace backend\models\funcs;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */

class Func extends BaseModel{
    
    const STATUS_ACTIVE = 1;
    const STATUS_DIE = 0; 

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%func}}';
    }
    
    public static function getDb()
    {
        return Yii::$app->db_portal;
    }

    
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DIE]],
        ];
    }
    
    /**
	 * 添加功能
	 * @param string $caption
     * @param string $moduleid
     * @param string $controllerid
	 * @param string $url
	 * @param int $parent_id
	 * @param int $show_style
	 * @param string $remark
	 * @param int $order_by
	 * @param tinyint $status
     * @param string $status 'Y' or 'N'
	 */
	public static function addFunc($caption,$moduleid,$controllerid, $url, $parent_id, $show_style, $remark, $order_by, $status, $is_super=0) {
        $params = array(
			'caption' => $caption,
            'moduleid' => $moduleid,
            'controllerid' => $controllerid,
			'url' => $url,
			'parent_id' => $parent_id,
			'show_style' => $show_style,
			'remark' => $remark,
			'order_by' => $order_by,
			'status' => $status,
			'is_super' => $is_super,
            'create_time'=>time()	
		);
        $db = static::getDb();
        $db->createCommand()->insert('func',$params)->execute();
        return $db->getLastInsertID();
	}
	
	/**
	 * 
	 * @param integer $id
	 * @param string $caption
	 * @param string $url
	 * @param integer $parent_id
	 * @param integer $show_style
	 * @param string $remark
	 * @param integer $order_by
	 * @param integer $status
	 * @param integer $is_super
	 */
	public static function updateFunc($id, $caption,$moduleid,$controllerid,$url, $parent_id, $show_style, $remark, $order_by, $status, $is_super=0) {
        $params = array(
				'caption' => $caption,
                'moduleid' => $moduleid,
                'controllerid' => $controllerid,
				'url' => $url,
				'parent_id' => $parent_id,
				'show_style' => $show_style,
				'remark' => $remark,
				'order_by' => $order_by,
				'status' => $status,
				'is_super' => $is_super
		);
        $condition =['id'=>$id];
        return static::getDb()->createCommand()->update('func',$params,$condition)->execute();
	}
	
	/**
	 * 通过ID获取数据
	 * @param integer $id
	 */
	public static function getById($id) {
        return static::findOne(['id' => $id]);
	}
	
	
	/**
     * 
     * @param type $parent_id
     * @param type $orderby
     * @return type
     */
	public static function getByParentId($parent_id,$status=[1,0],$orderby = array('id'=>SORT_ASC)) {
        return static::find()->where(['parent_id' => $parent_id,'status'=>$status])->orderBy($orderby)->asArray(true)->all();
	}
	
    /**
     * 
     * @param type $id
     * @return type
     */
	public static function deleteFuncById( $id ) {
        $params = array(
				'id' => $id
		);
        return static::getDb()->createCommand()->delete('func',$params)->execute();
	}

}

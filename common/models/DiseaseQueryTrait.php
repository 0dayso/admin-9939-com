<?php
/**
 * @version 0.0.0.1
 */

namespace common\models;
use librarys\helpers\utils\String;
use yii\db\mssql\PDO;
use yii\web\NotFoundHttpException;


/**
 * Disease Model trait
 * @author gaoqing
 */
trait DiseaseQueryTrait
{
	/**
	 * get disease collection by department id array 
	 * @param array $departmentid department id
     * @param string $class_level the department level
	 * @return array disease array
	 */
	public function getDiseaseByDepartment($departmentid, $class_level, $offset = 0, $size = 0){
		$diseases = array();

        $db = \Yii::$app->db_jbv2;
        $sql = " SELECT dsm.id, dsm.name, dsm.pinyin, dsm.pinyin_initial ";
        $sql .= " FROM `9939_depart_rel_merge` drm, `9939_disease_symptom_merge` dsm";
        $sql .= " WHERE drm.unique_key = dsm.unique_key AND drm.source_flag = 1 AND drm.${class_level} = ${departmentid} LIMIT ${offset}, ${size}";
        $diseases = $db->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);

		return $diseases;
	}

    /**
     * 根据 疾病文章 id, 获取所属疾病的信息
     * @author gaoqing
     * @date 2016-04-01
     * @param int $articleid 疾病文章id
     * @return array 疾病文章所属疾病的信息
     */
    public function getDiseaseByArtid($articleid){
        $disease = [];
        if ($this->isNotNull($articleid)){
            //查询当前文章在 9939_article_disease_rel 中对应的 疾病id，$diseaseid
            $artDisRel = Relate::getArtDisRel($articleid);
            $diseaseid = 0;
            if (!empty($artDisRel)){
                $diseaseid = $artDisRel[0]['diseaseid'];
            }else{
                return array();
            }

            $redisKey = 'disease_' . $diseaseid;
            $redis = \Yii::$app->redis;
            $disease = $redis->get($redisKey);
            if (isset($disease) && !empty($disease)){
                return $disease;
            }else {
                //根据 $diseaseid 获取疾病的信息
                $disease = Disease::find()->where(['id' => $diseaseid])->asArray(true)->one();
                if (isset($disease) && !empty($disease)){
                    $diseaseContent = DiseaseContent::find()->select('inspect')->where(['id' => $disease['id']])->asArray(true)->one();
                    if (isset($diseaseContent) && !empty($diseaseContent)){
                        $disease = array_merge($disease, $diseaseContent);
                    }
                    $redis->set($redisKey, $disease, 15 * 24 * 60 * 60);
                }
                return $disease;
            }
        }
        return $disease;
    }

    /**
     * 根据疾病的拼音简写，得到疾病的信息
     * @author gaoqing
     * @date 2016-03-23
     * @param String $pyInitial 疾病的拼音简写
     * @return array 疾病的信息集
     */
    public function getDiseasesByPinyin($pyInitial){
        $disease = [];
        if ($this->isNotNull($pyInitial)){
            //疾病基本信息
            $diseaseBasic = Disease::find()->where(['pinyin_initial' => $pyInitial])->asArray(true)->one();

            //疾病详细信息
            $diseaseContent = [];
            if ($this->isNotNull($diseaseBasic)){
                $diseaseContent = DiseaseContent::find()->where(['id' => $diseaseBasic['id']])->asArray(true)->one();
            }
            if ($this->isNotNull($diseaseBasic) && $this->isNotNull($diseaseContent)){
                $diseaseContentApp = $diseaseContent;
                foreach ($diseaseContentApp as $key => $content){
                    $diseaseContentApp[$key] = String::cutString($content, 35);
                }
                $disease = array_merge($diseaseBasic, $diseaseContent);
                $disease['content_app'] = $diseaseContentApp;
            }
        }
        if (!isset($disease) || empty($disease)){
            throw new NotFoundHttpException("当前访问的页面不存在！");
        }
        return $disease;
    }

    /**
     * 参数不为空的判断
     * @author gaoqing
     * @date 2016-03-23
     * @param mixed $param 参数
     * @return boolean true: 不为空；false: 为空
     */
    private function isNotNull($param){
        $isNotNull = false;
        if (isset($param) && !empty($param)){
            $isNotNull = true;
        }
        return $isNotNull;
    }

}
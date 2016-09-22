<?php
namespace common\models\disease;

use common\models\Disease;
use common\models\Symptom;
trait ArticlelinkTrait {

    public static function getAllDiseaseSymptom2Redis(){
        $redis = \Yii::$app->redis;
        $cache_all_disease_symptom_link_key = APP_CACHE_PREFIX .'CACHE_ALL_DISEASE_SYMPTOM_LINK';
        $result_list = $redis->hMget($cache_all_disease_symptom_link_key);
        if(empty($result_list)){
            $result_list = self::createAllDiseaseSymptomCache4Redis();
        }
        return $result_list;
    }
    
    
    public static function createAllDiseaseSymptomCache4Redis(){
        $redis = \Yii::$app->redis;
        $redis_expired = 24 * 60 * 60; //秒
        $cache_all_disease_symptom_link_key = APP_CACHE_PREFIX .'CACHE_ALL_DISEASE_SYMPTOM_LINK';
        
        $cache_all_disease_symptom_link_data=array();
        $all_disease = Disease::find()->select(['name', 'pinyin_initial'])->asArray()->all();
        foreach($all_disease as $k=>$v){
            $cache_all_disease_symptom_link_data[$v['name']] = \Yii::getAlias('@jb_domain').'/'.$v['pinyin_initial'].'/';
        }
        
        $all_symptom = Symptom::find()->select(['name', 'pinyin_initial'])->asArray()->all();
        foreach($all_symptom as $k=>$v){
            $cache_all_disease_symptom_link_data[$v['name']] =  \Yii::getAlias('@jb_domain').'/zhengzhuang/'.$v['pinyin_initial'].'/';
        }
        $redis->hMset($cache_all_disease_symptom_link_key, $cache_all_disease_symptom_link_data, $redis_expired);
        return $cache_all_disease_symptom_link_data;
    }
    
}
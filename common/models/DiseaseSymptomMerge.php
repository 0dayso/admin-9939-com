<?php

namespace common\models;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */

class DiseaseSymptomMerge extends BaseModel{
    
            
    public static function tableName()
    {
        return '{{%disease_symptom_merge}}';
    }
    
    public static function getDb()
    {
        return Yii::$app->db_jbv2;  
    }
    
    public function rules() {
        return [
            [['id'],'integer'],
            [['name','description','pinyin','pinyin_initial','source_flag','unique_key'],'safe'],
        ];
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
        $sql = "select * from 9939_disease_symptom_merge where unique_key in ($ids) order by field(unique_key,$ids)";
        $result = static::getDb()->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    
     public static function list_forpaging($where = '', $order = 'unique_key desc', $count = 0, $offset = 0) {
        $sql = 'select * from 9939_disease_symptom_merge';
        if (!empty($where)) {
            $sql.=' where ' . $where;
        }
        if(!empty($order)){
            $sql.=' order by '.$order;
        }
        if($count>0){
            $sql.=" limit $offset,$count";
        }
        $result = self::getDb()->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        $total = self::GetCount($where);
        return array('list'=>$result,'total'=>$total);
    }

    //获取数据总和
    public static function GetCount($where = '') {
        $sql = 'SELECT count(1) as num FROM `9939_disease_symptom_merge`';
        if (!empty($where)) {
            $sql.=' WHERE ' . $where;
        }
        $result = self::getDb()->createCommand($sql)->queryOne(\PDO::FETCH_ASSOC);
        return $result['num'];
    }
    
    
    public static function createCacheRandWords(array $condition = array(),$expired=24){
        ini_set('memory_limit', '512M');
        $return_pagenum_list = array();
        
        $expired =  $expired*3600;//一天
        $pagenum_expired = 2 * $expired;//两天
        $file_cache = \Yii::$app->cache_data_file; 
        
        $cache_key_letter_pagenum = sprintf('$s|%s|%s|%s', 'disease_words','caches', 'randwords', 'pagenum');
        $cache_letter_pagenum_data = $file_cache->get($cache_key_letter_pagenum);
        if ($cache_letter_pagenum_data) {
            $return_pagenum_list = $cache_letter_pagenum_data;
        }
        
        //获取字母所对应的数据
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        $max_kw_length = 2500; // $size;
        for ($i = 0; $i < $len; $i++) {
            $wd = strtoupper($letter_list{$i});
            $pagenum = isset($return_pagenum_list[$wd]) ? $return_pagenum_list[$wd] : 0;
            $pagenum = intval($pagenum) + 1;
            $tmp_offset = $pagenum * $max_kw_length;
            $return_info = Search::search_disease_symptom_words_byinitial($wd, $tmp_offset, $max_kw_length, $condition);
            if (count($return_info['list']) == 0 && $pagenum > 0) {
                $return_info = Search::search_disease_symptom_words_byinitial($wd, 0, $max_kw_length, $condition);
                $pagenum = 0;
            }
            $ret = $return_info['list'];
            $return_list[$wd] = $ret;
            $return_pagenum_list[$wd] = $pagenum;
        }
        self::createRandWordsForRedis($return_list);
        
        $cache_key_letter_words = sprintf('$s|%s|%s|%s', 'disease_words','caches', 'randwords', 'words');
        $file_cache->set($cache_key_letter_words,$return_list,$expired);
        $file_cache->set($cache_key_letter_pagenum,$return_pagenum_list,$pagenum_expired);
        return $return_list;
    }
    
    /**
     * 
     * 获取随机关键词
     * @param type $size
     * @param array $condition 
     *  $conditions = array(
      'column_id' => array(1)
      );
     * @return type
     */
    public static function getCacheRandWords($size = 30, array $condition = array()) {
        $max_dis_length = $size;
        $key_cache_words = APP_CACHE_PREFIX.'CACHE_DISEASE_SYMPTOM_MERGE_WORDS';
        $key_cache_words_total= APP_CACHE_PREFIX.'CACHE_DISEASE_SYMPTOM_MERGE_WORDS_TOTAL';
        
        $redis = \Yii::$app->redis;
        $cache_words_total = $redis->hMget($key_cache_words_total,range('A','Z'));
        $return_list = array();
        if(!empty($cache_words_total)){
            $rand_key = array();
            foreach($cache_words_total as $k=>$v){
                if(!empty($v)){
                    $rand_num = $v>$max_dis_length?$max_dis_length:$v;
                    $rand_index_arr = array_rand(range(0,$v-1),$rand_num);
                    if (is_array($rand_index_arr)) {
                        foreach($rand_index_arr as $vv){
                            $key = sprintf('%s_%d',$k,$vv);
                            $rand_key[] = $key;
                        }
                    }else{
                        $key = sprintf('%s_%d',$k,$rand_index_arr);
                        $rand_key[] = $key;
                    }
                }
            }
            $return_redis_list = $redis->hMget($key_cache_words,$rand_key);
            if(!empty($return_redis_list)){
                foreach($return_redis_list as $v){
                    if(!empty($v)){
                        $words_info = json_decode($v, true);
                        $capital = $words_info['capital'];
                        $return_list[$capital][] = $words_info;
                    }
                }
            }
        }
        
        if(empty($return_list)){
            $expired = 24; //小时
            $return_list = self::createCacheRandWords($condition, $expired);
        }
        return $return_list;
        
    }

    /**
     * 
     * 获取随机关键词
     * @param type $size
     * @param array $condition 
     *  $conditions = array(
      'column_id' => array(1)
      );
     * @return type
     */
    public static function getRandWordsFromFiles($size = 100, array $condition = array()) {
        $expired = 24; //小时
        $cache_key_letter_words = sprintf('$s|%s|%s|%s', 'disease_words','caches', 'randwords', 'words');
        //生成的缓存文件为24小时，由crontab：createcacherandwords.php控制缓存更新,此处缓存文件永不过期
        $file_cache = \Yii::$app->cache_data_file; 
        $data =$file_cache->get($cache_key_letter_words);
        if ($data) {
            return $data;
        } else {
            $return_list = self::createCacheRandWords($condition, $expired);
            return $return_list;
        }
    }
    
    /**
     * 创建redis缓存
     * @param array $return_list
     */
    private static function createRandWordsForRedis($return_list = array()){
        //保存缓存到redis
        $redis_expired = 12*30*24*3600; //秒
        $key_cache_words = APP_CACHE_PREFIX.'CACHE_DISEASE_SYMPTOM_MERGE_WORDS';
        $key_cache_words_total= APP_CACHE_PREFIX.'CACHE_DISEASE_SYMPTOM_MERGE_WORDS_TOTAL';
        $redis = \Yii::$app->redis;
        
        $hash_cache_words_total = array();
        $hash_cache_words = array();
        foreach($return_list as $k=>$word_child){
            $wd = $k;
            $hash_cache_words_total[$wd]=count($word_child);
            foreach($word_child as $kk=>$v){
                $key = sprintf('%s_%d',$wd,$kk);
                $hash_cache_words[$key] = json_encode($v);
            }
        }
        $redis->hMset($key_cache_words,$hash_cache_words, $redis_expired);
        $redis->hMset($key_cache_words_total,$hash_cache_words_total, $redis_expired);
    }
}

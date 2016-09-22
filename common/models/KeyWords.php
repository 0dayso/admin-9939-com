<?php

/**
 * @version 0.0.0.1
 */

namespace common\models;

use librarys\models\BaseModel;
use yii\db\mssql\PDO;
use yii\db\Query;

/**
 * 关键字
 * @author gaoqing
 */
class KeyWords extends BaseModel {

    public static function getDb() {
        return \Yii::$app->db_v2;
    }

    public static function tableName() {
        return 'keywords';
    }

    public function init() {
        parent::init();
    }

    public function List_ByIds($wdids = array()) {
        if (count($wdids) == 0) {
            return false;
        }
        $ids = implode(',', $wdids);
        //$sql = "select id,keywords,pinyin,pinyin_initial,typeid from keywords where id in ($ids) order by id desc";
        $sql = "select id,keywords,pinyin,pinyin_initial,typeid from keywords where id in ($ids) order by field(id,$ids)";
        $result = self::getDb()->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @param string $where
     * @param string $order
     * @param int $count
     * @param int $offset
     * @return array
     * 例如:EXPLAIN
     * SELECT * FROM keywords WHERE  pinyin_initial='A' and typeid in (2,3)  and  id >=(
     * SELECT id FROM keywords where pinyin_initial='A' and typeid in (2,3)
     * ORDER BY id asc limit 600,1
     * ) ORDER BY id asc limit 0,200;
     *
     */
    public function list_forpaging($where = '', $order = 'id desc', $count = 0, $offset = 0) {
        $sql = 'select id,keywords,pinyin,pinyin_initial,typeid from keywords';
        if (!empty($where)) {
            $sql.=' where ' . $where;
        }
        if (!empty($order)) {
            $sql.=' order by ' . $order;
        }
        if ($count > 0) {
            $sql.=" limit $offset,$count";
        }
        $result = self::getDb()->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
        $total = $this->GetCount($where);
        return array('list' => $result, 'total' => $total);
    }

    //获取数据总和
    public function GetCount($where = '') {
        $sql = 'SELECT count(id) as num FROM `' . self::tableName() . '`';
        if (!empty($where)) {
            $sql.=' WHERE ' . $where;
        }
        $result = self::getDb()->createCommand($sql)->queryOne(PDO::FETCH_ASSOC);
        return $result['num'];
    }

    public function getKeywordName($value) {
        $where = " `pinyin` = '" . $value . "'";
        $sql = 'SELECT `keywords` FROM `' . self::tableName() . '` WHERE ' . $where;
        $result = self::getDb()->createCommand($sql)->queryOne(); //获取一行
        return $result;
    }

    public function List_All($where = '1', $order = '', $count = '', $offset = '') {
        $query = new Query();
        $res = $query->select("*")
                ->from(self::tableName())
                ->where($where)
                ->offset($offset)
                ->limit($count)
                ->orderBy($order);
        $commandQuery = clone $res;
        $result = $commandQuery->createCommand(self::getDB())->queryAll();
        return $result;
    }
    
    public static function createCacheRandWords(array $condition = array(), $expired = 24) {
        ini_set('memory_limit', '512M');
        $key = md5(json_encode($condition));
        $return_pagenum_list = array();
        $expired = $expired * 3600; //一天
        $pagenum_expired = 2 * $expired; //两天
       
        $file_cache = \Yii::$app->cache_data_file;
        $file_cache->cachePath= \Yii::getAlias('@frontend').'/runtime/cache/rand_words';
        
        $cache_key_letter_pagenum = sprintf('%s|%s|%s|%s', 'rand_words', 'caches', 'randwords' . '_' . $key, 'pagenum');
        $cache_letter_pagenum_data = $file_cache->get($cache_key_letter_pagenum);
        if ($cache_letter_pagenum_data) {
            $return_pagenum_list = $cache_letter_pagenum_data;
        }

        //获取字母所对应的数据
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        $max_kw_length = 3000; // $size;
        for ($i = 0; $i < $len; $i++) {
            $wd = strtoupper($letter_list{$i});
            $pagenum = isset($return_pagenum_list[$wd]) ? $return_pagenum_list[$wd] : 0;
            $pagenum = intval($pagenum) + 1;
            $tmp_offset = $pagenum * $max_kw_length;
            $return_info = Search::search_words_byinitial($wd, $tmp_offset, $max_kw_length, $condition);
            if (count($return_info['list']) == 0 && $pagenum > 0) {
                $return_info = Search::search_words_byinitial($wd, 0, $max_kw_length, $condition);
                $pagenum = 0;
            }
            $ret = $return_info['list'];
            $return_list[$wd] = $ret;
            $return_pagenum_list[$wd] = $pagenum;
        }

        //根据查询条件生成redis缓存的key前缀
        $redis_cache_key_prefix = self::buildKey($condition);
        self::createRandWordsForRedis($redis_cache_key_prefix, $return_list);

        $cache_key_letter_words = sprintf('%s|%s|%s|%s', 'rand_words', 'caches', 'randwords' . '_' . $key, 'words');
        $file_cache->set($cache_key_letter_words, $return_list, $expired);
        $file_cache->set($cache_key_letter_pagenum, $return_pagenum_list, $pagenum_expired);
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
        $redis_cache_key_prefix = self::buildKey($condition);
        $key_cache_words = $redis_cache_key_prefix . 'CACHE_RAND_WORDS';
        $key_cache_words_total = $redis_cache_key_prefix . 'CACHE_RAND_WORDS_TOTAL';

        $redis = \Yii::$app->redis;
        $cache_words_total = $redis->hMget($key_cache_words_total, range('A', 'Z'));
        $return_list = array();
        if (!empty($cache_words_total)) {
            $rand_key = array();
            foreach ($cache_words_total as $k => $v) {
                if (!empty($v)) {
                    $rand_num = $v > $max_dis_length ? $max_dis_length : $v;
                    $rand_index_arr = array_rand(range(0, $v - 1), $rand_num);
                    if (is_array($rand_index_arr)) {
                        foreach ($rand_index_arr as $vv) {
                            $key = sprintf('%s_%d', $k, $vv);
                            $rand_key[] = $key;
                        }
                    } else {
                        $key = sprintf('%s_%d', $k, $rand_index_arr);
                        $rand_key[] = $key;
                    }
                }
            }
            $return_redis_list = $redis->hMget($key_cache_words, $rand_key);
            if (!empty($return_redis_list)) {
                foreach ($return_redis_list as $v) {
                    if (!empty($v)) {
                        $words_info = json_decode($v, true);
                        $capital = $words_info['pinyin_initial'];
                        $return_list[$capital][] = $words_info;
                    }
                }
            }
        }

        if (empty($return_list)) {
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
        $key = md5(json_encode($condition));
        
        $cache_key_letter_words = sprintf('%s|%s|%s|%s', 'rand_words', 'caches', 'randwords' . '_' . $key, 'words');
        
        //生成的缓存文件为24小时，由crontab：createcacherandwords.php控制缓存更新,此处缓存文件永不过期
        $file_cache = \Yii::$app->cache_data_file;
        $data = $file_cache->get($cache_key_letter_words);
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
    private static function createRandWordsForRedis($redis_cache_key_prefix, $return_list = array()) {
        //保存缓存到redis
        $redis_expired = 24 * 3600; //秒
        $key_cache_words = $redis_cache_key_prefix . 'CACHE_RAND_WORDS';
        $key_cache_words_total = $redis_cache_key_prefix . 'CACHE_RAND_WORDS_TOTAL';
        $redis = \Yii::$app->redis;

        $hash_cache_words_total = array();
        $hash_cache_words = array();
        foreach ($return_list as $k => $word_child) {
            $wd = $k;
            $hash_cache_words_total[$wd] = count($word_child);
            foreach ($word_child as $kk => $v) {
                $key = sprintf('%s_%d', $wd, $kk);
                $hash_cache_words[$key] = json_encode($v);
            }
        }
        $redis->hMset($key_cache_words, $hash_cache_words, $redis_expired);
        $redis->hMset($key_cache_words_total, $hash_cache_words_total, $redis_expired);
    }
    
    private static function buildKey(array $condition = array()) {
        $key = md5(json_encode($condition));
        $redis_cache_key_prefix = APP_CACHE_PREFIX . $key;
        return $redis_cache_key_prefix;
    }

}

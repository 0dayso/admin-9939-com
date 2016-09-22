<?php

namespace common\models;

use common\models\Search;
use common\models\KeyWords;
use librarys\helpers\utils\SearchHelper;

trait FSearchTrait {

    /**
     * 在【疾病文章详情页】中，得到疾病文章的相关文章 和 相关问答
     * @author gaoqing
     * @date 2016-04-20
     * @param array $keywords 关键词数组
     * @return array 疾病文章的相关文章 和 相关问答 集
     */
    public static function getRelArtsAndAsksInArticle($keywords, $isGetArticle = true){
        $relArtsAndAsks = [];

        $sphinxRecords = SearchHelper::batchSearch($keywords); 
        $relArticles = [];
        $relAsks = [];
        
        $result = array();
        if(!empty($sphinxRecords)){
            foreach($sphinxRecords as $kk=>$ret){
                $indexer_name = $ret['indexer'];
                $sphinx_result = Search::parse_search_data($ret,$indexer_name);
                $result[]=$sphinx_result;
            }

            if ($isGetArticle){
                $relArticles = count($result)>1?$result[0]:array();
                $relAsks =  count($result)>1?$result[1]:array();
            }else{
                $relAsks =  count($result)>0?$result[0]:array();
            }
        }

        //根据得到 id ，分别查询 疾病文章的相关文章 和 相关问答
        $relArtsAndAsks['relArticles'] =  $relArticles;
        $relArtsAndAsks['relAsks'] = $relAsks;
        return $relArtsAndAsks;
    }

    /**
     * 
     * @param type $word
     * @return type
     */
    public function letterHotWordsBatch($word) {
        //获取字母所对应的数据
        $letter_list = range('A','Z');
        //根据随机的记录id获取需要展示的记录数组
        $queries = [];
        $max_page = 100;
        for ($i = 1; $i <= 26; $i++) {
            $queries[]=array('word' => $word, 'indexer' => 'index_9939_com_v2_keywords_all', 'offset' => 0, 'size' => $max_page, 'condition' => array(array('filter' => 'filter', 'args' => array('pinyin_initial_sn', array($i)))));
        }
        $all_word_ids =SearchHelper::batchSearch($queries);
        $arr_ids = array();
        foreach ($all_word_ids as $k => $ret) {
            if (!empty($ret['matches'])) {
                foreach ($ret['matches'] as $kk => $kv) {
                    $arr_ids[] = $kk;
                }
            }
        }
        
        $wd_obj = new KeyWords();
        $result = $wd_obj->List_ByIds($arr_ids);
        $return_list = [];
        if (!empty($result)){
            $cache_rand_words =[];
            //把查找出的所有结果按字母放入数组
            foreach ($result as $k => $v) {
                $caption = $v['pinyin_initial'];
                if(!isset($cache_rand_words[$caption])){
                    $cache_rand_words[$caption]=[];
                }
                $cache_rand_words[$caption][] = $v;
            }
            $len = count($letter_list);
            $max_dis_length =28;
            for ($i = 0; $i < $len; $i++) {
                $wd = strtoupper($letter_list{$i});
                $ret =isset($cache_rand_words[$wd])? $cache_rand_words[$wd]:array();
                if (count($ret) > 0) {
                    $rand_num = count($ret) > $max_dis_length ? $max_dis_length : count($ret);
                    $rand_keys = array_rand($ret, $rand_num);
                    if (is_array($rand_keys)) {
                        foreach ($rand_keys as $k) {
                            $return_list[$wd][] = $ret[$k];
                        }
                    } else {
                        $return_list[$wd][] = $ret[0];
                    }
                } else {
                    $return_list[$wd] = array();
                }
            }
        }
        $result['letter'] = $letter_list;
        $result['words'] = $return_list;
        return $result;
    }

    /**
     * 获取26字母下的热词
     */
    public function letterRandWords() {
        $letters = range('A', 'Z');
        $offset = 0;
        $length = 28;
        $type = array(array('filter'=>'filter','args'=>array('typeid',array(0,2,3,4))));
        foreach ($letters as $k => $v) {
            $ret[$v] = Search::search_words_byinitial($v, $offset, $length, $type);
        }
        $result['letter'] = $letters;
        $result['words'] = $ret;
        return $result;
    }

}

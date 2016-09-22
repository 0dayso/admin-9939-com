#!/usr/bin/php
#/usr/bin/php /data/www/develop/code/trunk/admin-9939-com/console/shell/match_disease_article.php >/dev/null 2>&1

<?php
$app_path = dirname(__DIR__);
require $app_path . '/config/init.php';

//每次匹配的条数
$match_count = 5000;
match_disease_article($match_count);

/**
 * 将疾病文章匹配到对应的疾病上
 * @author gaoqing
 * @date 2016-05-31
 * @param int $match_count 匹配的条数
 * @return int 0
 */
function match_disease_article($match_count) {
    /*
     * 1、查询出指定条数的疾病文章集 $disease_articles
     * 2、循环遍历疾病文章集 $disease_articles => $disease_article
     *  2.1、根据 keywords、fjc、title 优先级，通过分词的方式，得到 XB、XZ 类型的值 $scws_words
     *  2.2、通过 $scws_words ，判断是否存在对应的 疾病 或者 症状
     *      2.2.1、如果不存在，则更新 9939_disease_article 表的 ismatch 字段的值，设置为 -1
     *      2.2.2、如果存在，则级联更新 9939_disease_article 表的 diseaseid, ismatch 字段的值为 1，更新 9939_article_disease_rel 的对应关系
     */

    //1、查询出指定条数的疾病文章集 $disease_articles
    $disease_articles = get_disease_articles($match_count);
    if (!empty($disease_articles)) {

        $disease_symptom_arr = get_disease_symptom();
        $connection = \Yii::$app->db_jbv2;
        $replace_str = array("|","/","\"");
        //2、循环遍历疾病文章集 $disease_articles => $disease_article
        foreach ($disease_articles as $key => $disease_article) {
            $disease_article->keywords = strip_tags($disease_article->keywords);
            $disease_article->keywords = str_replace($replace_str, " ", $disease_article->keywords);
            $arr_rel_ids = get_rel_disease_symptom_ids($disease_article, $disease_symptom_arr, $connection);
            $disease_ids = $arr_rel_ids['disease'];
            $symptom_ids = $arr_rel_ids['symptom'];
            $keywords = $arr_rel_ids['keywords'];

            //2.2.1、如果不存在，则更新 9939_disease_article 表的 ismatch 字段的值，设置为 -1
            if (empty($disease_ids) && empty($symptom_ids)) {
                $disease_article->ismatch = -1;
                $disease_article->update();

                //2.2.2、如果存在，则级联更新 9939_disease_article 表的 diseaseid, ismatch 字段的值为 1，更新 9939_article_disease_rel 的对应关系
            } else {
                $disease_article->ismatch = 1;
                $disease_article->diseaseid = count($disease_ids) > 0 ? $disease_ids[0] : 0;
                $disease_article->symptomid = count($symptom_ids) > 0 ? $symptom_ids[0] : 0;
                $str_keywords = empty($disease_article->keywords) ? $keywords : $disease_article->keywords . ' ' . $keywords;
                $arr_keywods = explode(' ', $str_keywords);
                $arr_keywods = array_unique($arr_keywods);
                $disease_article->keywords = implode(' ',$arr_keywods);
                if ($disease_article->update() !== false && count($disease_ids) > 0) {

                    //得到要更新的 文章--疾病 id 数组
                    $article_disease_id_arr = [];
                    foreach ($disease_ids as $disease_id) {
                        $inner = [];
                        $inner[] = $disease_article->id;
                        $inner[] = $disease_id;
                        $article_disease_id_arr[] = $inner;
                    }
                    $connection->createCommand()->batchInsert('9939_article_disease_rel', ['articleid', 'diseaseid'], $article_disease_id_arr)->execute();
                }
            }
        }
    }
}

function get_disease_symptom() {
    $console = Yii::getAlias("@console");
    $file = $console . '/shell/disease_symptom.php';
    $disease_symptom_arr = [];

    if (file_exists($file)) {
        $disease_symptom_str = file_get_contents($file);
        $disease_symptom_arr = unserialize($disease_symptom_str);
    } else {
        $diseases = \common\models\Disease::find()->asArray()->all();
        foreach ($diseases as $disease) {
            $name = $disease['name'];
            $row = array(
                'id' => $disease['id'],
                'source_flag' => 1
            );
            $disease_symptom_arr[$name] = $row;
        }
        $symptoms = \common\models\Symptom::find()->asArray()->all();
        foreach ($symptoms as $symptom) {
            $name = $symptom['name'];
            if (!isset($disease_symptom_arr[$name])) {
                $row = array(
                    'id' => $symptom['id'],
                    'source_flag' => 2
                );
                $disease_symptom_arr[$name] = $row;
            }
        }
        $disease_symptom_str = serialize($disease_symptom_arr);
        file_put_contents($file, $disease_symptom_str);
    }
    return $disease_symptom_arr;
}

function get_disease_articles($match_count) {
    return \common\models\disease\Article::find()->where(['diseaseid' => 0, 'status' => 99])->andWhere(['ismatch' => 0])->limit($match_count)->all();
}

function get_rel_disease_symptom_ids($disease_article, $disease_symptom_arr, $connection) {
    $keywords_scws = get_scws_words($disease_article);
    $keywords_scws = array_filter($keywords_scws, 'filter');
    $all_arr = [];
    foreach ($keywords_scws as $scws_word) {
        $all_arr[] = $scws_word['word'];
    }
    $all_arr = array_unique($all_arr);
    usort($all_arr, 'cmp');
    $keywords = implode(' ', $all_arr);
    $match_result = match_disease_symptom_ids($disease_symptom_arr, $all_arr);
    $ret = array(
        'disease' => $match_result['disease'],
        'symptom' => $match_result['symptom'],
        'keywords' => $keywords
    );
//    var_dump($ret);exit;
    return $ret;
}

function get_scws_words($disease_article) {
    $keywords_scws = array();
    if (empty($keywords_scws) && !empty($disease_article->keywords)) {
        $keywords_scws = \librarys\helpers\utils\SearchHelper::scws($disease_article->keywords);
    }
    if (empty($keywords_scws) && !empty($disease_article->title)) {
        $keywords_scws = \librarys\helpers\utils\SearchHelper::scws($disease_article->title);
    }
    return $keywords_scws;
}

/**
 * 根据分词后的值，得到其对应的 疾病 id 集
 * @author gaoqing
 * @date 2016-05-31
 * @param array $disease_symptom_arr 疾病、症状 name => id 数组
 * @param array $scws_words 分词后的数组值
 * @return array 匹配后的疾病 id 集
 */
function match_disease_symptom_ids($disease_symptom_arr, $scws_words) {
    $disease_ids = [];
    $symptom_ids = [];
    if (!empty($scws_words)) {
        foreach ($scws_words as $xb_word) {
            if (isset($disease_symptom_arr[$xb_word])) {
                $row = $disease_symptom_arr[$xb_word];
                if ($row['source_flag'] === 1) {
                    $disease_ids[] = $row['id'];
                } else {
                    $symptom_ids[] = $row['id'];
                }
            }
        }
    }
    return array(
        'disease' => $disease_ids,
        'symptom' => $symptom_ids
    );
}

//数组排序
function cmp($a, $b) {
    $encoding = 'utf8';
    $a_len = mb_strlen($a, $encoding);
    $b_len = mb_strlen($b, $encoding);
    if ($a_len == $b_len) {
        return 0;
    }
    return ($a_len < $b_len) ? 1 : -1;
}

//过滤
function filter($v) {
    return in_array($v['attr'], array('XB', 'XZ'));
}

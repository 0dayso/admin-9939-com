<?php

namespace wapjb\controllers;

use yii;
use librarys\controllers\wapjb\WapController;
use \common\models\Disease;
use \common\models\disease\Article;
use \common\models\ask\Ask;

/**
 * Description of IndexController
 *
 * @author Administrator
 */
class IndexController extends WapController {

    //当季多发疾病
    private $seasonalDiseaseMap = [
        24 => '当季多发疾病'
    ];
    //按人群查疾病 分类id信息
    private $midPeopleMap = [
        2 => '男性',
        3 => '女性',
        4 => '儿童',
        5 => '老人',
        6 => '孕妇',
        7 => '职业病',
    ];
    //按科室查疾病 分类id信息
    private $midDepartmentMap = [
        14 => ['内科','/jbzz/neike/'],
        15 => ['外科','/jbzz/waike/'],
        16 => ['儿科','/jbzz/erke/'],
        17 => ['妇产科','/jbzz/fuchanke/'],
        18 => ['皮肤科','/jbzz/pifuxingbingke/'],
        21 => ['肿瘤科','/jbzz/zhongliuke/'],
    ];
    //疾病热词
    private $diseaseHotWordsMap = [
        26 => '疾病热词'
    ];
    //疾病专区
    private $diseaseZone = [
        '男科专区' => 'http://nk.9939.com/',
        '妇科专区' => 'http://fk.9939.com/',
        '眼科专区' => 'http://yk.9939.com/',
        '肿瘤专区' => 'http://zl.9939.com/',
        '口腔专区' => 'http://kq.9939.com/',
        '癫痫专区' => 'http://dx.9939.com/',
        '儿科专区' => 'http://ek.9939.com/',
        '骨科专区' => 'http://gk.9939.com/',
        '肝病专区' => 'http://gb.9939.com/',
        '肾病专区' => 'http://shcare.9939.com/'
    ];

    public function init() {
        parent::init();
        $this->setLayout('index');
    }

    public function behaviors() {
        return [
            [
                'class' => '\librarys\actions\filters\PageCacheFilter',
                'cache' => 'cache_file',
                'enabled' => true,
                'only' => ['*'], //需要添加缓存的方法列表
                'duration' => 12 * 60 * 60, //默认一天
                'variations' => [
                    $_SERVER['REQUEST_URI']
                ],
            ],
        ];
    }

    /**
     * 疾病库 首页
     */
    public function actionIndex() {
        $data = [];
        //季发性疾病
        $seasonalDiseaseMap = $this->seasonalDiseaseMap;
        $seasonal_disease = $this->getCategoryData($seasonalDiseaseMap, 8);

        //分类疾病和文章
        //10疾病和4篇不同文章
        $midPeopleOptionMap = $this->midPeopleMap;
        $common_disease_population = $this->getCategoryData($midPeopleOptionMap, 10, true);

        //科室 以及相关疾病
        $midDepartmentMap = $this->midDepartmentMap;
        $department_classification = $this->getCategoryData($midDepartmentMap, 8);
        $model['department_classification'] = $department_classification;

        //问答 最新有专家回答的四个（ask+answer）
        $obj_ask = new Ask();
        $latest_disease_answer = $obj_ask->getLatestAsk(0, 4);

        //最新疾病文章 调取最新疾病文章时间倒序，前面为疾病词
        $obj_article = new Article();
        $latest_disease_article = $obj_article->getLatestDiseaseArticle(0, 8);

        //疾病热词
        $diseaseHotWordsMap = $this->diseaseHotWordsMap;
        $disease_hot_words = $this->getCategoryData($diseaseHotWordsMap, 10);

        $data['seasonal_disease'] = $seasonal_disease;                      //季发性疾病
        $data['common_disease_population'] = $common_disease_population;    //人类常见疾病
        $data['department_classification'] = $department_classification;    //科室分类
        $data['midDepartmentMap'] = $midDepartmentMap;                      //科室
        $data['latest_disease_answer'] = $latest_disease_answer;            //最新疾病问答
        $data['latest_disease_article'] = $latest_disease_article;          //最新疾病文章
        $data['disease_hot_words'] = $disease_hot_words;                    //最新疾病文章
        $data['diseaseZone'] = $this->diseaseZone;                          //疾病专区
        
        return $this->render('index', $data);
    }

    /**
     * 根据分类id获取该分类下的疾病内容
     * lc 2016-4-11
     * @param type $optionMap 分类id数组
     * @param type $contain_article 是否包含文章
     * @return type
     */
    public function getCategoryData($optionMap, $disease_length = 10, $contain_article = false, $article_length = 4) {
        $data = [];
        foreach ($optionMap as $k => $v) {
            $catId[] = $k;
        }
        $obj_disease = new Disease();
        $tmp = $obj_disease->batGetDiseaseByCategoryId($catId);
        $obj_article = new Article(); //
        $disid = [];
        foreach ($tmp as $k => $v) {
            $data[$v['categoryid']]['disease'][] = $v;
            $disid[$v['categoryid']][] = $v['id'];
        }
        $new_data = [];
        foreach ($disid as $kk => $vv) {
            $new_data[$kk]['disease'] = array_slice($data[$kk]['disease'], 0, $disease_length);
            if ($contain_article) {
                $dis_str = implode(',', $vv);
                $res = $obj_article->getListByGroup($dis_str);
                $new_data[$kk]['article'] = array_slice($res, 0, $article_length);
            }
        }

        ksort($new_data);
        return $new_data;
    }

}

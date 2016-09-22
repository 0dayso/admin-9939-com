<?php
namespace frontend\controllers;

use yii\helpers\Url;
use common\models\Symptom;
use common\models\SymptomContent;
use common\models\Relate;
use common\models\Disease;
use common\models\Department;
use common\models\ask\Ask;
use common\models\ask\Answer;
use common\models\disease\Article;
use common\models\doctor\Doctor;
use common\models\Search;
use common\models\FSearchTrait as SearchTrait;
use common\models\CategoryDisease;
use librarys\controllers\frontend\FrontController;
use common\models\news\News;
use common\models\CacheHelper;
use librarys\helpers\utils\SearchHelper;

class JbindexController extends FrontController {
    
    use SearchTrait;

    private $symptom;
    private $symptomContent;
    private $article;
    private $relate;
    private $disease;
    private $ask;
    private $answer;
    private $doctor;
    private $department;
    private $category;
    private $news;
    private $search;
    private $cacheHelper;
    private $searchHelper;
    //热门疾病拼音及id
    private $topDiseaseMap = [
                            'qlxy' => 1635,
                            'azb' => 3109,
                            'szkb' => 3745,
                            'jrsy' => 3177,
                            'gjml' => 2364,
                            'mjxydy' => 2408,
                            'gmxzd' => 1108,
                            'qmz' => 3414,
                            'tnb' => 6986,
                            'gxy' => 169,
                        ];
    //热门疾病 点击数
    private $topDiseaseClicksMap = [6602,6233,6034,5986,5668,5213,5022,4856,4533,3365];
    
    //按人群查疾病 分类id信息
    private $midPeopleMap = [
                            '常见病' => 1,
                            '男性' => 2,
                            '女性' => 3,
                            '儿童' => 4,
                            '老人' => 5,
                            '孕妇' => 6,
                            '职业病' => 7,
                        ];
    
    //按科室查疾病 分类id信息
    private $midDepartmentMap = [
                            '内科' => 14,
                            '外科' => 15,
                            '儿科' => 16,
                            '妇产科' => 17,
                            '皮肤科' => 18,
                            '五官科' => 19,
                            '性病科' => 20,
                            '肿瘤科' => 21,
                            '传染科' => 22,
                        ];
    
    //按部位查疾病 分类id信息
    private $midPartMap = [
        '男性' =>   [
                        '正面' =>
                                [
                                    '头部' => [21,'toubu'],
                                    '胸部' => [17,'xiongbu'],
                                    '上肢' => [36,'shangzhi'],
                                    '腰部' => [27,'yaobu'],
                                    '男性生殖' => [6,'nanxingshengzhi'],
                                    '下肢' => [56,'xiazhi'],
                                ],
                        '背面' =>
                                [
                                    '骨头' => [13,'jizhu'],
                                    '颈部' => [41,'jingbu'],
                                    '背部' => [53,'beibu'],
                                    '臀部' => [15,'tunbu'],
                                    '腰部' => [27,'yaobu'],
                                    '全身' => [4,'quanshen'],
                                ],
                    ],
        
        '女性' =>   [
                        '正面' =>
                                [
                                    '头部' => [21,'toubu'],
                                    '胸部' => [17,'xiongbu'],
                                    '上肢' => [36,'shangzhi'],
                                    '腰部' => [27,'yaobu'],
                                    '女性生殖' => [2,'nvxingshengzhi'],
                                    '下肢' => [56,'xiazhi'],
                                ],
                        '背面' =>
                                [
                                    '骨头' => [13,'jizhu'],
                                    '颈部' => [41,'jingbu'],
                                    '背部' => [53,'beibu'],
                                    '盆腔' => [2,'penqiang'],
                                    '腰部' => [27,'yaobu'],
                                    '臀部' => [15,'tunbu'],
                                    '全身' => [4,'quanshen'],
                                ],
                    ],

    ];
    
    //疾病问答 医院速查
    private $hospital = [
                            [
                                'title' => '北京协和医院（东院区）',
                                'level' => '三级甲等/综合医院',
                                'address' => '北京协和医院地址共有两个，分为东院和西院，协和医院东院位于北京市东城区帅 府园1号',
                                'img' => "@jb_domain/images/index_hospital_1.jpg",
                                'url' => 'http://hospital.9939.com/hosp/272446/index.shtml',
                            ],
                            [
                                'title' => '北京大学人民医院（西直门院区）',
                                'level' => '三级甲等/综合医院',
                                'address' => '北京市西城区西直门南大街11号',
                                'img' => "@jb_domain/images/index_hospital_2.jpg",
                                'url' => 'http://hospital.9939.com/hosp/19925/index.shtml',
                            ],
                            [
                                'title' => '武警总医院',
                                'level' => '三级甲等/综合医院',
                                'address' => '北京市海淀区永定路69号',
                                'img' => '@jb_domain/images/index_hospital_3.jpg',
                                'url' => 'http://hospital.9939.com/hosp/20362/index.shtml',
                            ],
                            [
                                'title' => '北京回龙观医院',
                                'level' => '三级甲等/综合医院',
                                'address' => '北京昌平回龙观镇派出所对面，万润家园东侧',
                                'img' => '@jb_domain/images/index_hospital_4.jpg',
                                'url' => 'http://hospital.9939.com/hosp/20425/index.shtml',
                            ],
        //*********************************************//
                            [
                                'title' => '北京仁和医院',
                                'level' => '二级甲等/综合医院',
                                'address' => '北京市大兴区兴丰大街1号',
                                'img' => '',
                                'url' => 'http://hospital.9939.com/hosp/20461/index.shtml',
                            ],
                            [
                                'title' => '武警北京市总队第二医院',
                                'level' => '三级甲等/综合医院',
                                'address' => '北京市西城区月坛北街丁3号',
                                'img' => '',
                                'url' => 'http://hospital.9939.com/hosp/19879/index.shtml',
                            ],
                            [
                                'title' => '北京市肛肠医院',
                                'level' => '二级甲等/综合医院',
                                'address' => '北京市西城区德外大街16号',
                                'img' => '',
                                'url' => 'http://hospital.9939.com/hosp/19931/index.shtml',
                            ],
                            [
                                'title' => '北京民康医院',
                                'level' => '二级甲等/综合医院',
                                'address' => '沙河镇民园小区',
                                'img' => '',
                                'url' => 'http://hospital.9939.com/hosp/20430/index.shtml',
                            ],
                            [
                                'title' => '北京市顺义区医院',
                                'level' => '二级甲等/综合医院',
                                'address' => '北京市顺义区近郊光明南街3号',
                                'img' => '',
                                'url' => 'http://hospital.9939.com/hosp/20413/index.shtml',
                            ],
                            [
                                'title' => '北京市房山区第一医院',
                                'level' => '二级甲等/综合医院',
                                'address' => '北京市房山区房窑路6号',
                                'img' => '',
                                'url' => 'http://hospital.9939.com/hosp/20385/index.shtml',
                            ],
                            [
                                'title' => '北京京北医院',
                                'level' => '一级甲等/综合医院',
                                'address' => '北京市海淀区清河龙岗路6号（清河桥东）',
                                'img' => '',
                                'url' => 'http://hospital.9939.com/hosp/20351/index.shtml',
                            ],
                            [
                                'title' => '北京市通州区妇幼保健院',
                                'level' => '二级甲等',
                                'address' => '北京市通州区玉桥中路124号',
                                'img' => '',
                                'url' => 'http://hospital.9939.com/hosp/20405/index.shtml',
                            ],
    ];
    //药品速查
    private $medicine = [
                            [
                                'title' => '二十六味通经散',
                                'useful' => '止血散瘀，调经活血。用于“木布病”引起的胃肠溃疡出血、肝血增盛、胸背疼痛、月经不调、闭经以及经血逆行引起的小腹胀满疼痛，血瘀症瘕。',
                                'address' => '西藏雄巴拉曲神水藏药厂',
                                'img' => "@jb_domain/images/index_medicine_1.jpg",
                                'url' => 'http://yiyao.9939.com/zhfl/200812/9377.shtml',
                            ],
                            [
                                'title' => '妇女痛经丸',
                                'useful' => '活血，调经，止痛。用于气血凝滞，小腹胀疼，经期腹痛。',
                                'address' => '北京同仁堂科技发展股份有限公司制药厂',
                                'img' => "@jb_domain/images/index_medicine_2.jpg",
                                'url' => 'http://yiyao.9939.com/zhfl/200812/3602.shtml',
                            ],
                            [
                                'title' => '儿童清肺口服液',
                                'useful' => '用于面赤身热，咳嗽，痰多，咽痛。',
                                'address' => '北京同仁堂股份有限公司同仁堂制药厂',
                                'img' => "@jb_domain/images/index_medicine_3.jpg",
                                'url' => 'http://yiyao.9939.com/zhfl/200812/3359.shtml',
                            ],
    ];
    //疾病资讯 左侧关键词
    private $newWords = [
            '阳痿'          => ['pinyin_initial' => 'yw',       'id' => 3105],
            '包皮龟头炎'    => ['pinyin_initial' => 'bpgty',    'id' => 1598],
            '糖尿病'        => ['pinyin_initial' => 'tnb',      'id' => 6986],
            '心脏病'        => ['pinyin_initial' => 'xzb',      'id' => 9011],
            '高血压'        => ['pinyin_initial' => 'gxy',      'id' => 169],
            '癫痫'          => ['pinyin_initial' => 'dx',       'id' => 3689],
            '中风'          => ['pinyin_initial' => 'zf',       'id' => 1530],
            '不孕不育'      => ['pinyin_initial' => 'byby',     'id' => 9153],
            '近视眼'        => ['pinyin_initial' => 'jsy',      'id' => 2652],
            '白内障'        => ['pinyin_initial' => 'bnz',      'id' => 2620],
            '鼻炎'          => ['pinyin_initial' => 'by_8977',  'id' => 8977],
            '食管癌'        => ['pinyin_initial' => 'sga',      'id' => 571],
        ];
    
    //焦点图
    private $focus = [
        [
            'txt' => '小儿流行性感冒',
            'title' => '小儿如何预防流行性感冒',
            'img' => "@jb_domain/images/banner1.jpg",
            'url' => "http://jb.9939.com/article/2016/0322/811430.shtml",
        ],
        [
            'txt' => '血糖升高',
            'title' => '不吃主食能降血糖 糖尿病友的话你信吗? ',
            'img' => "@jb_domain/images/banner2.jpg",
            'url' => "http://jb.9939.com/article/2016/0413/1049370.shtml",
        ],
        [
            'txt' => '泡脚养生',
            'title' => '泡脚养生有禁忌 5类人泡脚需谨慎',
            'img' => "@jb_domain/images/banner3.jpg",
            'url' => "http://baojian.9939.com/bjzd/2016/0412/3073733.shtml",
        ],
    ];
    public function init() {
        parent::init();
        $this->setLayout('jbindex');
        $this->symptom = new Symptom();
        $this->symptomContent = new SymptomContent();
        $this->relate = new Relate();
        $this->disease = new Disease();
        $this->department = new Department();
        $this->answer = new Answer();
        $this->ask = new Ask();
        $this->article = new Article();
        $this->doctor = new Doctor();
        $this->category = new CategoryDisease();
        $this->news = new News();
        $this->search = new Search();
        $this->cacheHelper = new CacheHelper();
        $this->searchHelper = new SearchHelper();
    }
    
    
    public function behaviors() {
        return [
            [
                'class' =>'\librarys\actions\filters\PageCacheFilter',
                'cache' => 'cache_file',
                'enabled' => true,  //是否开启缓存
                'only' => ['index'], //需要添加缓存的方法列表
                'duration' => 12*60*60, //默认一天
                'variations' => [
                    'uri'=>$this->getRequestURIPath()
                ],
            ],
        ];
    }
    
    public function actionIndex(){
        return $this->createIndex();
    }
    
    public function createIndex(){
        $model = [];
        //设置title,keywords,description
        $this->setMeta();
        //**********第一屏**********//

        //最受关注
        $midSearchOptionMap = [
            '最受关注1' => 13,
            '最受关注2' => 12,
        ];
        $inc_mid_searchCategory = $this->getCategoryData($midSearchOptionMap);
        //轮播图
        $inc_mid_searchCategory['focus'] = $this->focus;

        $inc_mid_searchCategory['report'] = $this->getReportNewsOption();//疫情播报 固定数据
        $inc_mid_searchCategory['zhuanti'] = $this->getDiseaseZhuantiOption();//疾病专题 固定数据
        $model['inc_mid_searchCategory'] = $inc_mid_searchCategory;

        //**********按人群查疾病**********//
        $midPeopleOptionMap = $this->midPeopleMap;
        $inc_mid_people = $this->getCategoryData($midPeopleOptionMap);
        $inc_mid_people['peopleCategory'] = $midPeopleOptionMap;
        $inc_mid_people['hotDisease'] = $this->disease->getDiseaseByCategoryId(23);
//        print_r($inc_mid_people);exit;
        $model['inc_mid_people'] = $inc_mid_people;

        //**********按科室查疾病**********//
        $midDepartmenOptionMap = $this->midDepartmentMap;
        $inc_mid_department = $this->getCategoryData($midDepartmenOptionMap);
        $inc_mid_department['topDisease'] = $this->getTopDisease();
        $model['inc_mid_department'] = $inc_mid_department;

        //**********按部位查疾病**********//
        $doctor = $this->getDoctorInfo();
        $inc_mid_part['part_disease'] =$this->batchGetDiseaseSymptomByPart();
        $inc_mid_part['doctors_top'] = $doctor['doctors_top'];
        $inc_mid_part['doctors_bottom'] = $doctor['doctors_bottom'];
        $model['inc_mid_part'] = $inc_mid_part;

        //**********疾病问答**********//
        $inc_mid_ask['leftAsk'] = $this->getDiseaseAsk();
        $inc_mid_ask['leftAskNoAnswer'] = $this->getAskNoAnswer();
        $inc_mid_ask['rightHospital'] = $this->hospital;
        $inc_mid_ask['rightMedicine'] = $this->medicine;
        $inc_mid_ask['rightDoctors'] = $this->doctor->getDoctorById('830991,830813');
        $model['inc_mid_ask'] = $inc_mid_ask;

        //**********疾病资讯**********//
        $newWords = $this->newWords;
        $inc_mid_news['newsWords'] = $newWords;
        $inc_mid_news['news'] = $this->getNewsByDiseaseId($newWords);//疾病资讯
//        print_r($inc_mid_news);exit;

        $inc_mid_news['top'] = $this->news->getTopArticle(10);//右侧 资讯排行榜
        $model['inc_mid_news'] = $inc_mid_news;
//        
        //**********底部热词**********//
        $inc_foot_hotwords = $this->letterHotWords();
        $model['inc_foot_hotwords'] = $inc_foot_hotwords;

        //**********底部友情链接**********//
        $inc_foot_links = $this->getLinks();
        $model['inc_foot_links'] = $inc_foot_links;
        $pageContent = $this->render('index', [
                'model' => $model
        ]);
        
        return $pageContent;
    }


    /**
     * 疾病症状 首页
     * lc 2016-4-11
     */
    public function actionMakehtml() {
        if($this->helpGquery('forcemakehtml') == 1 ){//生成静态页标记
            $app_index_path = \Yii::getAlias('@frontend/web/index.shtml');
            if(file_exists($app_index_path)){
                @unlink($app_index_path);
            }
            $pageContent = $this->createIndex();
            $res = @file_put_contents($app_index_path, $pageContent);
            if($res){
                echo  $this->helpJsonResult(200,'首页生成完毕', null);
            }
            exit;
        }
    }
    /**
     * 获取医生信息
     * @return type
     */
    public function getDoctorInfo(){
        $doctors_top_id = [830822,830770,830735];//,827331,830936,832167,832390,312932,832678
        $doctors_bottom_id = [827331,830936];
        $doctors_all_id = array_merge($doctors_top_id, $doctors_bottom_id);
        $doctors_all_id_str = implode(',', $doctors_all_id);
        $doctorTmp = $this->doctor->getDoctorById($doctors_all_id_str);
        foreach($doctorTmp as $k=>$v){
            if(in_array($v['uid'], $doctors_top_id)){
                $doctors_top[] = $v;
            }else{
                $doctors_bottom[] = $v;
            }
        }
        return [
            'doctors_top' => $doctors_top,
            'doctors_bottom' => $doctors_bottom
        ];
    }


    /**
     * 疾病问答 模块中间
     * 调用最新回复两条以上的问题根据id
     */
    public function getDiseaseAsk(){
        $doctor = [1440561,1253728,830735,1442194,987608,830834,830757,200224];
        $doctorId = implode(',', $doctor);
        $doctorTmp = $this->doctor->getDoctorById($doctorId);
//        print_r($doctorTmp);
//        exit;
        
        $ret = [];
        $docInfo=[];
        foreach($doctorTmp as $kk=>$vv){
            $docid = $vv['uid'];
            $docInfo[$docid] = $vv;
            $answer = $this->answer->getLatestByDoctorid($docid);
            if($answer){
                $ask = $this->ask->list_one($answer['0']['askid']);
                $ttmp['0'] = [
                    'id' => $ask['id'],
                    'ask' => $ask['title'],
                    'answer' => $answer['0']['content'],
                    'addtime' => $answer['0']['addtime'],
                ];

                $tmpDoc= [
                    'doctor' => isset($docInfo[$docid]) ? $docInfo[$docid] : '',
                    'qa' => isset($ttmp[0]) ? $ttmp[0] : '',
                ];
                $ret[$docid]= $tmpDoc;
            }
        }
        return $ret;
    }


    /**
     * 疾病问答 模块中间
     * 调用以下科室下的问题，当前问题最新回复三条以上则调用
     * @return array
     */
    public function getAskNoAnswer(){
        $keshi = [
            43   => '糖尿病',
            110  => '股骨头',
            120  => '前列腺增生',
            543  => '阳痿',
            195  => '月经不调',
            210  => '宫外孕',
            334  => '尖锐湿疣',
            340  => '湿疹',
            345  => '牛皮癣',
            240  => '婴幼儿腹泻',
            278  => '白内障',
            326  => '乙肝',
            379  => '胃癌',
            301  => '隆胸'
        ];
        
        $ask = [];
        foreach($keshi as $k=>$v){
            $keshiId[] = $k;
        }
        $classidStr = implode(',', $keshiId);
        $askIdMap = $this->ask->getListByGroup('`classid` IN ('.$classidStr.')');//通过Group By查询得到问题id
        
        foreach($askIdMap as $k=>$v){
            $askId[] = $v['id'];
        }
        
        $condition = [
            ['in', 'id', $askId],
        ];
        $ask = $this->ask->getListByCondition('id,title,classid,ctime',$condition, 14);
//        print_r($ask);
//        exit;
//        $ask[$k] = isset($ret[0]) ? $ret[0] : [''];
        
        $ret = [];
        foreach($keshi as $kk=>$vv){
            $keshiUrl = Url::to("@ask/classid/{$kk}");
            foreach($ask as $k=>$v){
                if($v['classid'] == $kk){
                    $askTitle = $v['title'];
                    $askUrl = Url::to("@ask/id/{$v['id']}");
                    $askTime = $this->formatTime($v['ctime']);
                    $v = [];
                    $v['keshiName'] = $vv;
                    $v['keshiUrl'] = $keshiUrl;
                    $v['askTitle'] = $askTitle;
                    $v['askUrl'] = $askUrl;
                    $v['askTime'] = $askTime;
                    
                    $ret[$kk] = $v;
                }
            }
        }
        
        return $ret;
    }
    
    
    /**
     * 时间计算
     * @param type $date
     * @return string
     */
    public function formatTime($timer) {
        $str = '';
        $diff = $_SERVER['REQUEST_TIME'] - $timer;
        $day = floor($diff / 86400);
        $free = $diff % 86400;
        if ($day > 0) {
            $year = floor($day / 7);
            if( $year > 0){
                return "1周前";
            }else{
                return $day."天前";
            }
        }else{
            if ($free > 0) {
                $hour = floor($free / 3600);
                $free = $free % 3600;
                if ($hour > 0) {
                    return $hour."小时前";
                }else{
                    if ($free > 0) {
                        $min = floor($free / 60);
                        $free = $free % 60;
                        if ($min > 0) {
                            return $min."分钟前";
                        }else{
                            if ($free > 0) {
                                return $free."秒前";
                            }else{
                                return '刚刚';
                            }
                        }
                    }else{
                        return '刚刚';
                    }
                }
            }else{
                return '刚刚';
            }
        }
    }


    /*
     * 获取友情链接
     * lc 2016-4-13
     */
    public function getLinks(){
        $tmp = '';
        $curl_url = sprintf('%s%s', \Yii::getAlias('@oldjb'), '/yqlj.html');
        $tmp = @file_get_contents($curl_url);
        return $tmp;
    }
    
    //随机热词
    private function rand_words () {
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        $max_kw_length = 40;//获取最多多少关键词
        $max_dis_length = 32;
        $filter_array = $this->getFilterArray();
        $cache_rand_words = \common\models\DiseaseSymptomMerge::getCacheRandWords($max_kw_length, $filter_array);
        for ($i = 0; $i < $len; $i++) {
            $wd = strtoupper($letter_list{$i});
            $ret = isset($cache_rand_words[$wd])?$cache_rand_words[$wd]:array();
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
        return $return_list;
    }
    private function getFilterArray(){
        return array(
            array(
                'filter'=>'filter',
                'args'=> array('source_flag',array(1,2))
            )
        );
    }

    /**
     * 随机热词
     * lc 2016-4-13
     * @param type $word
     * @return type
     */
    public function letterHotWords() {
        //获取字母所对应的数据
        $letter_list= range('A','Z');
        $letter_map_list = [];
        foreach($letter_list as $k=>$v){
            $letter_map_list[$v]=$v;
        }
        
        $rand_disease_symptom = $this->rand_words();
        
        $return_list = [];
        $return_list['letter'] = $letter_map_list;
        $return_list['words'] = $rand_disease_symptom;
        return $return_list;
    }
    
    /**
     * 通过疾病id查询出资讯
     * lc@2016-7-8
     * @param type $newWords
     */
    public function getNewsByDiseaseId($newWords){
        $news = $this->cacheIndexTopNews('frontend_index_inc_mid_news', ['newWords' => $newWords]);
        return $news;
    }
    
    /**
     * 缓存首页根据疾病查找的最新疾病资讯模块
     * lc@2016-7-8
     * @param type $cacheKey
     * @param type $parms
     * @return array
     */
    public static function cacheIndexTopNews($cacheKey, $parms){
        
        $result = array();
        $newWords = $parms['newWords'];
        $rel_obj =  new \common\models\Relate;
        /*方法2*/
        /**
         * 经测试方法2运行效率是方法1的5倍+
         */
        foreach($newWords as $kk=>$vv){
            $diseaseid[] = $vv['id'];
        }
        $diseaseids = implode(',', $diseaseid);
        $ret = $rel_obj->getArticlesGroupBy($diseaseids);
        foreach($ret as $k=>$v){
            $res[$v['tmp_diseaseid']] = $v;
        }
        foreach ($newWords as $kk=>$vv){
            if(isset($res[$vv['id']])){
                $result[$kk] = $res[$vv['id']];
            }
        }

        return $result;
    }


    /**
     * 关键词通过sphinx查询出资讯
     * lc 2016-4-13
     * @param type $newWords
     * @return type
     */
    public function getNewsBySphinx($newWords){
        $news = $this->cacheIndexNewsBySphinx('frontend_index_inc_mid_news', ['newWords' => $newWords]);
        return $news;
    }

    /**
     * 首页 疾病资讯 inc_mid_news文件里的数据缓存
     * @param string $cacheKey
     * @param type $parms
     * @return 
     */
    public static function cacheIndexNewsBySphinx($cacheKey, $parms){
        $newWords = $parms['newWords'];
        
        $art_obj =  new \common\models\disease\Article();
        $cache = \Yii::$app->cache_data_file;
        $key = $cacheKey;
        $data = $cache->get($key);
        
        if(!isset($data) || empty($data)){
            //1、根据不同的词拼出sphinx批量查询的条件
            $conditon = [];
            $n=0;
            foreach($newWords as $k=>$v){
                $w = $n;
                $conditon[$w] = ['word'=>$k, 'indexer'=>'index_9939_com_jb_art'];
                $n++;
            }
//            print_r($conditon);exit;
            //2、根据sphinx批量查询得到记录
            $sphinxRecords = SearchHelper::batchSearch($conditon);
            $result = array();
            foreach($sphinxRecords as $kk=>$ret){
                $indexer_name = $ret['indexer'];
                $sphinx_result = Search::parse_search_data($ret,$indexer_name);
                $ret_list = $sphinx_result['list'];
                $kw = $conditon[$kk]['word'];
                $result[$kw]=$ret_list;
            }
//            //7、设置缓存
//            $cache->set($key, $result);
            return $result;
        }else{
            return $data;
        }
        
    }
    
    /**
     * 批量通过部位查询疾病和症状
     * lc 2016-4-13
     * @param type $partArrMap
     * @return type
     */
    public function batchGetDiseaseSymptomByPart(){
        $partArrMap = $this->midPartMap;
        $tmp = [];
        foreach($partArrMap as $sexKey=>$sexVal){
            foreach($sexVal as $frondBackKey=>$frondBackVal){
                foreach($frondBackVal as $partKey=>$partVal){
                    $tmp[$sexKey][$frondBackKey][$partKey]['disease'] = $this->relate->getDiseaseByPartid($partVal[0], 1, 9);
                    $tmp[$sexKey][$frondBackKey][$partKey]['symptom'] = $this->relate->getDiseaseByPartid($partVal[0], 2, 9);
                    $tmp[$sexKey][$frondBackKey][$partKey]['diseaseUrl'] = Url::to("@jb_domain/jbzz/{$partVal[1]}_t1/");//部位疾病更多链接
                    $tmp[$sexKey][$frondBackKey][$partKey]['symptomUrl'] = Url::to("@jb_domain/jbzz/{$partVal[1]}_t2/");//部位症状更多链接
                }
            }
        }
//        print_r($tmp);exit;
        return $tmp;
    }

    /**
     * 获取疾病专题信息
     * lc 2016-4-12
     * @return array
     */
    public function getDiseaseZhuantiOption(){
        $tmp = [
            ['白癜风','http://bdf.9939.com/ '],
            ['高血压','http://gxy.9939.com'],
            ['男科疾病','http://nk.9939.com/'],
            ['儿科疾病','http://ek.9939.com/'],
            ['糖尿病','http://tnb.9939.com/'],
            ['肝病','http://gb.9939.com/'],
            
            ['癫痫病','http://dx.9939.com/'],
            ['心脏病','http://xzb.9939.com/'],
            ['妇科疾病','http://fk.9939.com/'],
            ['不孕不育','http://byby.9939.com/'],
            ['皮肤病','http://pf.9939.com/'],
            ['肿瘤','http://zl.9939.com/'],
        ];
        
        return $tmp;
    }

    /**
     * 疫情播报信息
     * lc 2016-4-12
     * @return string
     */
    public function getReportNewsOption(){
        $tmp = [
            'title' => '寨卡病毒（Zika Virus）',
            'url' => 'http://news.9939.com/jbyw/2016/0411/3038561.shtml',
            'desciption' => '(zika virus)通过蚊虫叮咬传播至人。塞卡病毒病最常见的症状是发热、皮疹、 关节痛及结膜炎 (红眼)。这种疾病通常轻度症状持续时间从几天到一个星期后自愈。病疾严重时，需要住院治疗，因本病死亡是罕见的。目前怀疑塞卡病毒感染可引起胎儿小头畸形和其它神经系统疾病。',
        ];
        return $tmp;
    }

    /**
     * 获取热门疾病信息
     * lc 2016-4-12
     * @return type
     */
    public function getTopDisease(){
        $diseaseTmpIdArr = $topDisease = $diseaseTmp =[];
        foreach($this->topDiseaseMap as $k=>$v){
            $diseaseTmpIdArr[] = $v;
        }
        
        $diseaseTmp = $this->disease->batchGetDiseaseById($diseaseTmpIdArr);
        foreach($diseaseTmp as $key=>$val){
            $disease[$val['pinyin_initial']] = $val;
        }
        $clicks = $this->topDiseaseClicksMap;
        $n=0;
        foreach($this->topDiseaseMap as $k=>$v){
            $topDisease[$k] = $disease[$k];
            $topDisease[$k]['click'] = $clicks[$n];
            $n++;
        }
        return $topDisease;
    }


    /**
     * 根据分类id获取该分类下的疾病内容
     * lc 2016-4-11
     * @param type $optionMap 分类id数组
     * @return type
     */
    public function getCategoryData($optionMap){
        $data = [];
        foreach($optionMap as $k=>$v){
            $catId[] = $v;
        }
        $tmp = $this->disease->batGetDiseaseByCategoryId($catId);
        foreach($tmp as $k=>$v){
            $categoryId = $v['categoryid'];
            foreach($optionMap as $kk=>$vv){
                if($categoryId == $vv ){
                    $data[$kk][] = $v;
                }
            }
//            $tmp[$categoryId][] = $v;
        }
//        print_r($tmp);
//        exit;
        $inc_mid_data['disease'] = $data;
        return $inc_mid_data;
    }

    /**
     * 设置网站title,keywords,description
     * lc 2016-4-1
     * @param type $name
     * @param type $page
     */
    public function setMeta() {
        $meta['title'] = "查疾病_疾病大全_最齐全的疾病百科_久久健康网";
        $meta['keywords'] = "疾病查询,疾病大全,疾病百科,疾病库";
        $meta['description'] = "久久健康网-疾病查询，提供最专业、全面的疾病数据库，是最详尽的疾病大全查询工具，包括疾病病因 、症状、检查、鉴别、预防及治疗等疾病百科知识，查询疾病方便、快捷，深受网民喜爱！";
        $this->getView()->title = $meta;
    }
}
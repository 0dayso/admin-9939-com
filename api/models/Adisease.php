<?php
/**
 * @version 0.0.0.1
 */

namespace api\models;

use common\models\CacheHelper;
use common\models\Department;
use common\models\Disease;
use common\models\disease\Article;
use common\models\Relate;
use common\models\Symptom;
use librarys\helpers\utils\String;

/**
 * 疾病的数据处理类
 * @date 2016-09-08
 * @author gaoqing
 */
class Adisease extends Common
{

    public static function articles($condition){
        $code = 200;

        $dname = $condition['dname'];
        $page = isset($condition['page']) ? $condition['page'] : 1;
        $type = ''; //文章类型分八种

        $disease = self::getDiseasesByPinyin($dname);
        //文章列表
        $cond['diseaseid'] = $disease['id'];
        $cond['type'] = [$type];

        $size = 10;
        $offset = ($page - 1) * 10;
        $articles = self::getListByDiseaseid($cond, $offset, $size);
        if (empty($articles)){
            $code = 500;
        }

        return [
            'code' => $code,
            'message' => '数据响应成功',
            'data' => $articles
        ];
    }

    public static function food($condition){
        $disease = self::getDiseasesByPinyin($condition['dname'], false, false, false, false);
        return [
            'code' => 200,
            'message' => '数据响应成功',
            'data' => $disease
        ];
    }

    public static function inspect($condition){
        $disease = self::getDiseasesByPinyin($condition['dname'], false, false, false, false);
        return [
            'code' => 200,
            'message' => '数据响应成功',
            'data' => $disease
        ];
    }

    public static function treat($condition){
        $disease = self::getDiseasesByPinyin($condition['dname'], false, false, false, false);
        return [
            'code' => 200,
            'message' => '数据响应成功',
            'data' => $disease
        ];
    }

    public static function neopathy($condition){
        $disease = self::getDiseasesByPinyin($condition['dname'], false, false, false, false);
        return [
            'code' => 200,
            'message' => '数据响应成功',
            'data' => $disease
        ];
    }

    public static function prevent($condition){
        $disease = self::getDiseasesByPinyin($condition['dname'], false, false, false, false);
        return [
            'code' => 200,
            'message' => '数据响应成功',
            'data' => $disease
        ];
    }

    public static function cause($condition){
        $disease = self::getDiseasesByPinyin($condition['dname'], false, false, false, false);
        return [
            'code' => 200,
            'message' => '数据响应成功',
            'data' => $disease
        ];
    }

    public static function symptom($condition){
        $disease = self::getDiseasesByPinyin($condition['dname'], false, true, false, false);
        return [
            'code' => 200,
            'message' => '数据响应成功',
            'data' => $disease
        ];
    }

    public static function jianjie($condition){
        $disease = self::getDiseasesByPinyin($condition['dname'], false, false, false, false);
        return [
            'code' => 200,
            'message' => '数据响应成功',
            'data' => $disease
        ];
    }

    /**
     * app 端 【疾病模块】首页接口数据
     * @author gaoqing
     * @date 2016-09-08
     * @return string json 格式的数据
     */
    public static function index($condition){
        //1、疾病的信息（根据疾病的 dname, 获取疾病信息）
        $disease = self::getDiseasesByPinyin($condition['dname'], false, true, true, true);
        array_walk($disease, function(&$value, $key){
            if (empty($value)){
                $value = '';
            }
        });
        $disease['inspect_short'] = String::cutString($disease['inspect'], 20);
        $disease['alias_arr'] = [];
        if (!empty($disease['alias'])){
            $disease['alias_arr'] = self::explodeStr($disease['alias']);
        }

        //2、获取 4 条症状信息
        $symptoms = [];
        if (self::isNotNull($disease['tsymptom'])){
            $symptoms = array_slice($disease['tsymptom'], 0, 4);
        }
        //3、获取全面解读部分数据
        $allReads = CacheHelper::getCache('frontend_disease_index_wzjd', ['id' => $disease['id'], 'name' => $disease['name']]);
        if (!empty($allReads)){
            foreach ($allReads as $module => $allRead){
                $subRead = [];
                foreach ($allRead as $index => $val){
                    if ($index < 2){
                        $val['app_url'] = \Yii::getAlias('@app_domain') . '/article/' . date('Y/md', $val['inputtime']) . '/' . $val['id'] . '.shtml';
                        $subRead[] = $val;
                    }
                }
                $allReads[$module] = $subRead;
            }
        }
        $disease['thumb']=empty($disease['thumb'])?'/images/dise_02.jpg': \librarys\helpers\utils\Url::getuploadfileUrl(1,$disease['thumb']);

        $params = [
            'disease' => $disease,
            'symptoms' => $symptoms,
            'allReads' => $allReads,
        ];
        return [
            'code' => 200,
            'message' => '数据响应成功',
            'data' => $params
        ];
    }

    public function getDiseaseByArtid($articleid){
        return $this->disease->getDiseaseByArtid($articleid);
    }

    public static function getListByDiseaseid($condition = [], $offset = 0, $limit = 10, $orderBy = 'id DESC') {
        $article = new Article();

        $articles = Article::find()->select(['id', 'title', 'description', 'inputtime', 'content'])->where($condition)->offset($offset)->limit($limit)->asArray()->all();

        if (isset($articles) && !empty($articles)){
            foreach ($articles as $key => &$article){
                if (empty($article['description'])){
                    $article['description'] = String::cutString($article['content'], 66);
                }else{
                    $article['description'] = String::cutString($article['description'], 66);
                }
                $article['url'] = '/article/'.date("Y/md", $article["inputtime"]).'/'.$article['id'].'.shtml';
            }
        }
        return $articles;
    }

    /**
     * 根据疾病名称，得到 对应 9939_com_v2sns wd_keshi 表中的 id 值
     * @author gaoqing
     * @date 2016-04-01
     * @param string $diseaseName 疾病名称
     * @return int 科室 id
     */
    public function getKeshiIDByName($diseaseName){
        $v2snsKeshiID = 0;

        if ($this->isNotNull($diseaseName)){
            $department = $this->department->getOldDepsByName($diseaseName);
            if ($this->isNotNull($department)){
                $v2snsKeshiID = $department['id'];
            }
        }
        return $v2snsKeshiID;
    }

    /**
     * 根据疾病的拼音简写，得到疾病的信息
     * @author gaoqing
     * @date 2016-09-08
     * @param String $pyInitial 疾病的拼音简写
     * @param boolean $isRelDis 是否获取其 相关疾病
     * @param boolean $isRelSym 是否获取其 典型症状
     * @param boolean $isRelPart 是否获取其相关 部位
     * @param boolean $isRelDep 是否获取其 就诊科室
     * @return array 疾病的信息集
     */
    public static function getDiseasesByPinyin($pyInitial, $isRelDis = false, $isRelSym = false, $isRelPart = false, $isRelDep = false){
        $disease = [];
        //1、得到疾病的疾病信息
        $odisease = new Disease();
        $disease = $odisease->getDiseasesByPinyin($pyInitial);

        if (self::isNotNull($disease)){
            $disease['treat_method'] = self::explodeStr($disease['treatment']);
            $disease = self::replace($disease, '<br/>');

            $disease['chuanranxing'] = '无';
            if ($disease['chuanranflag'] == 1){
                $disease['chuanranxing'] = '有';
            }
            //2、获取科室信息
            if ($isRelDep){
                $treatDepNames = self::explodeStr($disease['treat_department']);
                $odepartment = new Department();
                $disease['department']  = $odepartment->getDepsByName($treatDepNames);
                $disease['medicine'] = self::explodeStr($disease['medicine']);
            }
            //3、获取典型症状信息
            if ($isRelSym){
                $typicalSymptomNames = self::explodeStr($disease['typical_symptom']);
                $osymptom = new Symptom();
                $disease['tsymptom'] = $osymptom->getSymptomsByName($typicalSymptomNames);
            }
            //4、得到疾病对应的所有部位
            if ($isRelPart){
                $disease['part'] = Relate::getPartsByDisid($disease['id']);
            }
            //5、得到相关疾病
            if ($isRelDis){
                $relDiseaseNames = self::explodeStr($disease['rel_disease']);
                $values = Disease::search(['name' => $relDiseaseNames]);
                if (self::isNotNull($values)){
                    $disease['reldis'] = $values['list'];
                }
            }
        }
        return $disease;
    }

    public static function replace($datas, $replacement){
        $replaceArr = ['neopathy', 'cause', 'inspect', 'treat', 'symptom', 'food', 'prevent', 'description', 'content'];
        foreach ($replaceArr as $val){
            $source = $datas[$val];
            $datas[$val] = preg_replace('/[\r\n]+/', $replacement, $source);
        }
        return $datas;
    }

    /**
     * 将 字符串信息，按照 特定的分隔符，拆分成数组
     * @author gaoqing
     * @date 2016-09-08
     * @param string $str 字符串值
     * @return array 拆分后的数组
     */
    private static function explodeStr($str){
        $arr = [];
        $pattern = '/\s+/';
        if (strstr($str, ',')){
            $pattern = '/\,/';
        }
        if (strstr($str, '，')){
        	$pattern = '/\，/';
        }
        $arr = preg_split($pattern, $str);
        //$arr = explode($delimiter, trim($str, $delimiter));
       foreach ($arr as $key => $value){
       	if (empty($value)){
       		unset($arr[$key]);
       	}
       }
        return array_values($arr);
    }

    /**
     * 参数不为空的判断
     * @author gaoqing
     * @date 2016-09-08
     * @param mixed $param 参数
     * @return boolean true: 不为空；false: 为空
     */
    private static function isNotNull($param){
        $isNotNull = false;
        if (isset($param) && !empty($param)){
            $isNotNull = true;
        }
        return $isNotNull;
    }

}
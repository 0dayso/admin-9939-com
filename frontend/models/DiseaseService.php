<?php
/**
 * @version 0.0.0.1
 */

namespace frontend\models;

use common\models\Department;
use common\models\Disease;
use common\models\disease\Article;
use common\models\Relate;
use common\models\Symptom;

/**
 * 疾病的数据处理类
 * @author gaoqing
 */
class DiseaseService
{
    private $disease = null;
    private $department = null;
    private $symptom = null;

    public function __construct()
    {
        $this->disease = new Disease();
        $this->department = new Department();
        $this->symptom = new Symptom();
    }

    public function getDiseaseByArtid($articleid){
        return $this->disease->getDiseaseByArtid($articleid);
    }

    public function getListByDiseaseid($condition = [], $offset = 0, $limit = 10, $orderBy = 'id DESC') {
        $article = new Article();
        $articles = $article->getListByDiseaseid($condition, $offset, $limit, $orderBy);

        if (isset($articles) && !empty($articles)){
            foreach ($articles as $key => &$article){
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
     * @date 2016-03-23
     * @param String $pyInitial 疾病的拼音简写
     * @param boolean $isRelDis 是否获取其 相关疾病
     * @param boolean $isRelSym 是否获取其 典型症状
     * @param boolean $isRelPart 是否获取其相关 部位
     * @param boolean $isRelDep 是否获取其 就诊科室
     * @return array 疾病的信息集
     */
    public function getDiseasesByPinyin($pyInitial, $isRelDis = false, $isRelSym = false, $isRelPart = false, $isRelDep = false){
        $disease = [];
        //1、得到疾病的疾病信息
        $disease = $this->disease->getDiseasesByPinyin($pyInitial);

        if ($this->isNotNull($disease)){
            $disease['chuanranxing'] = '无';
            if ($disease['chuanranflag'] == 1){
                $disease['chuanranxing'] = '有';
            }
            //2、获取科室信息
            if ($isRelDep){
                $treatDepNames = $this->explodeStr($disease['treat_department']);
                $disease['department']  = $this->department->getDepsByName($treatDepNames);
                $disease['medicine'] = $this->explodeStr($disease['medicine']);
            }
            //3、获取典型症状信息
            if ($isRelSym){
                $typicalSymptomNames = $this->explodeStr($disease['typical_symptom']);
                $disease['tsymptom'] = $this->symptom->getSymptomsByName($typicalSymptomNames);
            }
            //4、得到疾病对应的所有部位
            if ($isRelPart){
                $disease['part'] = Relate::getPartsByDisid($disease['id']);
            }
            //5、得到相关疾病
            if ($isRelDis){
                $relDiseaseNames = $this->explodeStr($disease['rel_disease']);
                $values = Disease::search(['name' => $relDiseaseNames]);
                if ($this->isNotNull($values)){
                    $disease['reldis'] = $values['list'];
                }
            }
        }
        return $disease;
    }

    /**
     * 将 字符串信息，按照 特定的分隔符，拆分成数组
     * @author gaoqing
     * @date 2016-03-24
     * @param string $str 字符串值
     * @return array 拆分后的数组
     */
    private function explodeStr($str){
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
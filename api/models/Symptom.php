<?php
namespace api\models;

use Yii;
use api\models\Common;
use common\models\Symptom as ModelSymptom;
use common\models\SymptomContent as ModelSymptomContent;
use common\models\disease\Article;
use common\models\Relate;
use common\models\Disease;
use common\models\Department;
use common\models\doctor\Doctor;
use common\models\CacheHelper;

class Symptom extends Common {
    
    public static function getsymptom($params){
        $symptomObj = new ModelSymptom();
        $symptomContentObj = new ModelSymptomContent();
        
        $pinyin_initial = $params['pinyin_initial'];
        $condition = ["{{%symptom}}.pinyin_initial" => $pinyin_initial];
        $info = $symptomObj->getSymptomByCondition($condition, [], 1, 0);
        $res = $info[0];
        if (empty($info)) {//如果不存在抛出404
            return self::result(404, '找不到数据');
        }
        
        //处理缩略图
        $thumb = empty($res['thumbnail'])?'/patients/styles/images/dise_02.jpg':\librarys\helpers\utils\Url::getuploadfileUrl(2,$res['thumbnail']);
        $res['thumbnail'] = $thumb;
        
        //处理基本信息
        if(isset($params['fileds'])){
            if(strpos($params['fileds'], ',')===false){
                $column = $params['fileds'];
            }else{
                $column = explode(',', $params['fileds']);
            }
            $tmpCont = $symptomContentObj->getSymptomContentById($column, $res['id']);
            if (is_array($column)) {//如果是多个字段
                foreach ($column as $v) {
                    $res[$v] = str_replace("\n", "<br>", $tmpCont[$v]);
                }
            } else {
                $res['content'] = str_replace("\n", "<br>", $tmpCont[$column]);
            }
        }
        
        //处理相关文章
        if(isset($params['relarticles']) && $params['relarticles']==1){
            $symptomid = $res['id'];
            $self = new self();
            $arts = $self->getRightInfo($symptomid, ['disease', 'articles']);
             foreach ($arts as $k => $v) {
                $res[$k] = $v;
            }
        }
        
        return self::result(200, '获取数据成功', $res);
    }
    
    
    
    /**
     * 右侧公共信息，跟疾病有关的
     * lc 2016-4-6
     * @param type $symptomid
     * @param array $filter  ['disease','relSymptom'] 筛选需要的数据 
     * @return type
     */
    public function getRightInfo($symptomid, $filter = []) {
        $cacheHelper = new CacheHelper();
        
        
        $filter = !empty($filter) ? $filter : ['disease', 'articles', 'doctorInfos', 'leftDoctor', 'medicalDepartment', 'relSymptom'];

        $model = [];
        $diseaseList = [];
        $parms = [
            'id' => $symptomid,
        ];
        $diseaseCache = $cacheHelper->getCache('frontend_symptom_index_knjb', $parms);
        if (in_array('medicalDepartment', $filter) || in_array('disease', $filter)) {
            if (!empty($diseaseCache)) {
                $model['disid'] = $diseaseCache['diseaseId'];
                //症状首页左侧可能疾病及伴随症状
                $model['disease'] = $diseaseCache['diseaseTmp'];
            }
        }
        //右侧就诊科室
//        if (in_array('medicalDepartment', $filter)) {
//            if (!empty($diseaseCache)) {
//                //在取到的所有科室数据合并去重
//                $medicalDepartment = [];
//                foreach ($diseaseCache['departmentMap'] as $vv) {
//                    $Tmp['medicalDepartmentTmp'][] = $vv['id'];
//                    $Tmp['medicalDepartmentTmpName'][] = $vv['name'];
//                    $Tmp['medicalDepartmentTmpPinyin'][] = $vv['pinyin'];
//                }
//                $medicalDepartment['id'] = array_unique($Tmp['medicalDepartmentTmp']);
//                $medicalDepartment['name'] = array_unique($Tmp['medicalDepartmentTmpName']);
//                $medicalDepartment['pinyin'] = array_unique($Tmp['medicalDepartmentTmpPinyin']);
////                print_r($medicalDepartment);exit;
//                $model['medicalDepartment'] = $medicalDepartment;
//                //科室拼音
//                $model['departPinyin'] = $this->department->getDepartmentPinyin();
//            }
//        }

        //右侧相关症状
        if (in_array('relSymptom', $filter)) {
            $relateObj = new Relate();
            $model['relSymptom'] = $relateObj->getRelateSymptoms($symptomid);
        }

        //症状相关文章
        if (in_array('articles', $filter)) {
            $articleObj = new Article();
            $model['articles'] = [];
            $articles = $articleObj->listByCondition([['status' => '99'], ['symptomid' => $symptomid]], 7, 0, 'id DESC');
            if (!empty($articles)) {
                $model['articles'] = $articles;
            } else {
                if (!empty($diseaseCache)) {
                    $diseaseId = $diseaseCache['diseaseId'];
                    $disease_ids = implode(',', $diseaseId);
                    $articles = $articleObj->listBySqlCondition($disease_ids, 7, 0);
                    
                    $arts = [];
                    foreach($articles as $k=>$v){
                        $date_path = date('Y/md',$v['inputtime']);
                        $article_path = sprintf("%s/%s/%d.shtml",'article',$date_path,$v['id']);
                        $articleUrl =  sprintf('%s/%s', Yii::getAlias('@jb_domain'), $article_path);
                        foreach($v as $kk=>$vv){
                            $arts[$k][$kk] = $vv;
                            $arts[$k]['url'] = $articleUrl;
                        }
                    }
                    
                    $model['articles'] = $arts;
                }
            }
        }
        
        //专家（左侧）
        if (in_array('doctorInfos', $filter)) {
            if (!empty($diseaseCache)) {
                //取所有相关疾病里第一个疾病id来查专家
                $diseaserandid = $diseaseCache['diseaseId']['0'];
                $doctors = $this->getDoctor($diseaserandid,0,6);
                
                //专家（右侧）
                $rightDoctor = array_slice($doctors, 3, 3);
                $model['doctorInfos'] = $rightDoctor;
                
                //在线咨询 左侧
                $leftDoctor = [
                    [
                        'uid' => 1440561,
                        'nickname' => '陶丽萍',
                        'zhicheng' => '',
                        'best_dis' => '保健综合',
                        'pic' => '201601/1440561_avatar_middle.jpg'
                    ],
                    [
                        'uid' => 221102,
                        'nickname' => '王庆松',
                        'zhicheng' => '',
                        'best_dis' => '上呼吸道综合',
                        'pic' => '201601/221102_avatar_middle.jpg',
                    ],
                    [
                        'uid' => 831181,
                        'nickname' => '刘业生',
                        'zhicheng' => '',
                        'best_dis' => '常见病综合，呼吸道系统诊疗',
                        'pic' => '201604/831181_avatar_middle.jpg'
                    ],
                ];
                $model['leftDoctor'] = $leftDoctor;
            }
        }




        return $model;
    }
    
    /**
     * 通过疾病id 获取 医生
     * lc 2016-3-30
     * @param type $diseaseid
     * @return type
     */
    public function getDoctor($diseaseid, $offset = 0, $limit = 3) {
        require PROJECT_PATH.'/frontend/data/doctorid.php';
        $doctorObj = new Doctor();
        $departmentObj = new Department();

        $department = $departmentObj->getDepartmentsByDisid($diseaseid);
        $uid = array_key_exists($department[0]['name'], $_DOCTORID) ? $_DOCTORID[$department[0]['name']] : $_DOCTORID['内科']; //科室名称获取医生id信息
        $arruid = array_slice($uid, $offset, $limit);
        $uidstr = implode(',', $arruid);
        $doctor = $doctorObj->getDoctorById($uidstr);
        return $doctor;
    }
}
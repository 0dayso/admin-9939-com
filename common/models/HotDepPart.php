<?php
/**
 * @version 0.0.0.1
 */

namespace common\models;

use common\models\Disease;

/**
 * 热门科室、热门部位 的 trait
 * @author gaoqing
 */
class HotDepPart
{

    /**
     * 得到 热门科室、热门部位 数据集
     * @author gaoqing
     * @date 2016-04-13
     * @param int $columns 在页面中，显示的列数
     * @return array 热门科室、热门部位 数据集
     */
    public static function getCommonDisDep($columns=1){
        $commonDisDep = array();

        //查询科室下的疾病
        $departmentDis = self::getDepartmentDis($columns);

        //查询部位下症状
        $partSymptom = self::getPartSymptom($columns);

        $commonDisDep['departmentDis'] = $departmentDis;
        $commonDisDep['partSymptom'] = $partSymptom;
        return $commonDisDep;
    }

    /**
     * 得到 一二级热门科室、热门部位
     * @author gaoqing
     * @date 2016-04-13
     * @param int $columns 在页面中，显示的列数
     * @return array 热门科室、热门部位 数据集
     */
    public static function getCommonDepPart(){
        $commonDepPart = array();
        //获取科室
        $level1 = Department::find()->select('id,pinyin')->where('pid = 0')->asArray(true)->all();
        $level2 = Department::find()->select('id,name,pinyin,pid')->where('pid > 0')->asArray(true)->all();
        $dep = array(); //科室部分
        foreach($level1 as $k=>$v){
            $dep[$v['pinyin']] = array();
            foreach($level2 as $kk=>$vv){
                if($vv['pid'] == $v['id']){
                    $dep[$v['pinyin']][] = $vv;
                    unset($level2[$k]);
                }
            }
        }
        //查询部位
        $part1 = Part::find()->select('id,pinyin')->where('pid = 0')->asArray(true)->all();
        $part2 = Part::find()->select('id,name,pinyin,pid')->where('pid > 0')->asArray(true)->all();
        $part = array(); //部位部分
        foreach($part1 as $k=>$v){
            $part[$v['pinyin']] = array();
            foreach($part2 as $kk=>$vv){
                if($vv['pid'] == $v['id']){
                    $part[$v['pinyin']][] = $vv;
                    unset($part2[$k]);
                }
            }
        }
        $commonDepPart['department'] = $dep;
        $commonDepPart['part'] = $part;
        return $commonDepPart;
    }

    /**
     * 查询科室下的对应疾病集
     * @author gaoqing
     * @date 2016-04-08
     * @param int $columns 在页面中，显示的列数
     * @return array 科室下的对应疾病集
     */
    private static function getDepartmentDis($columns=1)
    {
        $departmentDis = array();
        $department = new Department();
        $disease = new Disease();

        //get the first level departments
        $firstLevel = $department->getDepartmentLevel1(1);
        if (self::isNotNull($firstLevel)) {
            foreach ($firstLevel as $level1) {

                //select diseases that all belong current first level department
                $inner = array();
                $inner['department'] = $level1;
                $size = count($firstLevel) * $columns;
                $inner['disease'] = $disease->getDiseaseByDepartment($level1['id'], 'class_level1', 0, $size);
                $departmentDis[] = $inner;
            }
            return $departmentDis;
        }
        return $departmentDis;
    }

    /**
     * 根据部位获取症状
     * @author gaoqing
     * @date 2016-04-13
     * @param int $columns 在页面中，显示的列数
     * @return array 部位及症状集
     */
    private static function getPartSymptom($columns=1){
        $partSymptom = [];

        $part = new Part();
        $symptom = new Symptom();

        $firstLevel = $part->getPartLevel1(1);
        if (self::isNotNull($firstLevel)){
            foreach ($firstLevel as $level1){
                $inner = array();
                $inner['part'] = $level1;
                $size = count($firstLevel) * $columns;
                $inner['symptom'] = $symptom->getSymptomsByPartid($level1['id'], 'part_level1', 0, $size);
                $partSymptom[] = $inner;
            }
        }
        return $partSymptom;
    }

    /**
     * 参数不为空的判断
     * @author gaoqing
     * @date 2016-03-25
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
<?php
/**
 * @version 0.0.0.1
 */

namespace wapjb\models;


use common\models\Disease;

class DiseaseQuery extends Disease
{
    public function init()
    {
        parent::init();
    }

    /**
     * 根据拼音简写，获取疾病的信息
     * @author gaoqing
     * @date 2016-03-22
     * @param string $pyInitial 拼音简写
     * @return array 疾病的信息
     */
    public function getDiseasesByPinyin($pyInitial){

    }

}
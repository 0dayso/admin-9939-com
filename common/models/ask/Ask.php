<?php
namespace common\models\ask;

use librarys\models\BaseModel;
use yii\db\mssql\PDO;
use yii\db\Query;
use librarys\helpers\utils\SearchHelper;

class Ask extends BaseModel {
    private $query;
    private static $tableName = 'wd_ask';
    
    public static function tableName() {
        return self::$tableName;
    }

    public static function getDB() {
        return \Yii::$app->db_v2sns;
    }

    public function init() {
        parent::init();
        $this->query = new Query();
    }


    private $map_table = array(
            'wd_ask_history_1' => array(0, 502014, 'wd_ask_history_1_answer'),
            'wd_ask_history_2' => array(502015, 1007110, 'wd_ask_history_2_answer'),
            'wd_ask_history_3' => array(1007111, 1517111, 'wd_ask_history_3_answer'),
            'wd_ask_history_4' => array(1517112, 2042111, 'wd_ask_history_4_answer'),
            'wd_ask_history_5' => array(2042112, 3372111, 'wd_ask_history_5_answer'),
            'wd_ask_history_6' => array(3372112, 4702068, 'wd_ask_history_6_answer'),
            'wd_ask_history_7' => array(4702069, 5702233, 'wd_ask_history_7_answer'),
            'wd_ask' => array(5702234, 100000000, 'wd_answer')
    );

    public function getList($where = '', $order = '', $count = '', $offset = '') {

        //-----------筛选掉 【未审核】的问答 （@author: gaoqing -------- @date: 2015-08-11）-----------//
        if (empty($where)) {
            $where = " examine = 1 ";
        }
        if (!empty($where) && !preg_match('/examine\s*=\s*1/', $where)) {
            $where .= " and examine = 1 ";
        }
        $sql = " select * from " . self::$tableName . " Where " . $where . " ORDER BY " . $order . " LIMIT ${offset}, ${count} ";
        $db = self::getDB();
        $result = $db->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function list_one($id = '') {
        if (!$id)
            return;
        $id = intval($id);
        foreach ($this->map_table as $k => $v) {
            if ($id >= $v[0] && $id <= $v[1]) {
                self::$tableName = $k;
                self::tableName();
                break;
            }
        }
        $where = 'id=' . intval($id);
        $sql = 'SELECT * FROM `' . self::tableName() . '` WHERE ' . $where;
        $result = self::getDB()->createCommand($sql)->queryOne(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * 根据条件查询问答信息
     * @param type $condition
     * @param type $limit
     * @param type $offset
     * @param type $orderBy
     * @return type
     */
    public function getListByCondition($columns='id,title,ctime', $condition = [], $limit=10, $offset=0, $orderBy = 'id DESC'){
        $res = '';
        if(count($condition) > 1){
            $res = $this->query->select("(SUBSTRING_INDEX(group_concat(id order by `id` desc),\',\',1)) as id,classid");
        }else{
            $res = $this->query->select($columns);
        }
        $res = $res->from($this->tableName());
        foreach($condition as $v){
            $res = $res->andWhere($v);
        }
        $res = $res->andWhere(['examine' => 1]);//默认调用审核过的数据
        $res = $res->limit($limit);
        $res = $res->offset($offset);
        $res = $res->orderBy($orderBy);
        $commandQuery = clone $res;
        $result = $commandQuery->createCommand(self::getDB())->queryAll();
        
//        $result = $commandQuery->createCommand(self::getDB())->getRawSql();
//        exit($result);
//        print_r($result);exit;
        return $result;
    }
    
    
    public function getListByGroup($where=1){
//        $sql = "SELECT (SUBSTRING_INDEX(group_concat(id order by `id` desc),',',1)) as id FROM `" . $this->tableName() . "` WHERE ".$where." AND `answernewnum` >= 2 AND `examine`=1 GROUP BY `classid` ORDER BY `id` DESC";
        $sql = "SELECT MAX(id) as id FROM `" . $this->tableName() . "` WHERE ".$where." AND `answernewnum` >= 2 AND `examine`=1 GROUP BY `classid`";
        $result = self::getDB()->createCommand($sql)->queryAll();
        return $result;
    }
    
    /**
     * 获取最新已回答的问题
     */
    public function getLatestAsk($offset = 0,$length = 5) {
        $sql = 'SELECT ask.id,ask.title,answer.content from wd_ask ask LEFT JOIN wd_answer answer on ask.id = answer.askid where ask.`examine` = 1 and ask.answernewnum > 0 GROUP BY ask.id ORDER BY ask.id DESC limit ' . $offset . ',' . $length;
        $result = self::getDB()->createCommand($sql)->queryAll();
        return $result;
    }

    
    public function filter($v){
        return in_array($v['attr'], array('XB','XZ','XS'));
    }
    
    /**
     * 分诊
     * @param type $askinfo 问答的信息
     */
    public function triage($askinfo){
        $db_v2sns = self::getDB();
        $db_jbv2 = \Yii::$app->db_jbv2;
        
        $wd_keshi_ret_default = array('class_level1'=>'15','class_level2'=>'0','class_level3'=>'0');
        
        $content = $askinfo['content'];
        
        $explain_result = SearchHelper::scws($content);
        
        $callback = array($this,'filter');
        //获取过滤数据
        $explain_result = array_filter($explain_result,$callback);
//        print_r($explain_result);exit;
        //如果无法从用户输入的内容里分出有意义的词，返回默认科室
        if(!isset($explain_result[0])){
            return $wd_keshi_ret_default;
        }
        
        $all = array();
        foreach($explain_result as $k=>$v){
            $all[$v['attr']][] = $v;
        }
        
        $wd_keshi_ret['class_level3'] = '0';//默认三级疾病为0
        //
        //Ⅰ
        //如果有疾病词
        if(isset($all['XB'][0])){
            //第一个病的词的名称
            $disease_name = $all['XB'][0]['word'];
            
            //通过疾病名查疾病id
            
            $disease_sql = "select id from 9939_disease where name='{$disease_name}'";
            $disease_ret = $db_jbv2->createCommand($disease_sql)->queryOne();
            $disease_id = $disease_ret['id'];//9725
            
            //先直接查疾病表是否有该疾病
            //如果有直接返回查询结果
            //如果没有，通过从症状表查
            //通过查wd_disease表得到disease_id
            $disease_name_sql = "select id,name from 9939_disease where id={$disease_id}";
            $disease_name_ret = $db_jbv2->createCommand($disease_name_sql)->queryOne();
            $disease_name = $disease_name_ret['name'];
            
            $class_level3_sql = "select class_level1,class_level2,id from wd_disease where name='{$disease_name}'";
            $class_level3 = $db_v2sns->createCommand($class_level3_sql)->queryOne();
            if(isset($class_level3['id'])){
                $wd_keshi_ret = $class_level3; 
                $wd_keshi_ret['class_level3'] = $class_level3['id'];
                unset($wd_keshi_ret['id']);
                return $wd_keshi_ret;
            }else{
                //通过疾病id查科室
                $disease_condition = 'disease'.$disease_id;
                $department_sql = "select depart.name from 9939_department depart,9939_depart_rel_merge merge where merge.source_flag=1 and merge.unique_key='{$disease_condition}' and merge.departmentid=depart.id";
                $department_ret = $db_jbv2->createCommand($department_sql)->queryOne();
                $department_name = $department_ret['name'];

                //通过科室名称进入wd_keshi查询最终的
                $wd_keshi_sql = "select class_level1,class_level2 from wd_keshi where name='{$department_name}'";
                $wd_keshi_ret = $db_v2sns->createCommand($wd_keshi_sql)->queryOne();
                //如果查不到数据放到默认科室里
                if(!isset($wd_keshi_ret['class_level1'])){
                    $wd_keshi_ret = $wd_keshi_ret_default;
                }else{
                    if(!$wd_keshi_ret['class_level3']){
                        $class_level3_sql = "select id from wd_disease where id='{$wd_keshi_ret['class_level3']}'";
                        $class_level3 = $db_v2sns->createCommand($class_level3_sql)->queryOne();
                    }
                }
                return $wd_keshi_ret;
            }
        }
        
        //Ⅱ
        //如果没有疾病词，症状词，只有部位词
        if(!isset($all['XZ'][0]) && isset($all['XS'][0])){
            //第一个部位的词的名称
            $condition_part_name = $all['XS'][0]['word'];
            
            //通过部位名查部位id
            $condition_part_sql = "select id from 9939_part where name='{$condition_part_name}'";
            $condition_part_ret = $db_jbv2->createCommand($condition_part_sql)->queryOne();
            $condition_part_id = $condition_part_ret['id'];//39
            
            //通过部位查找所有的疾病
            $part_disease_sql = "SELECT unique_key FROM 9939_part_rel_merge WHERE source_flag=1 AND partid={$condition_part_id}";
            $part_disease_ret = $db_jbv2->createCommand($part_disease_sql)->queryOne();
            $disease_id = str_replace('disease', '', $part_disease_ret['unique_key']);//7211
            
            //先直接查疾病表是否有该疾病
            //如果有直接返回查询结果
            //如果没有，通过从症状表查
            //通过查wd_disease表得到disease_id
            $disease_name_sql = "select id,name from 9939_disease where id={$disease_id}";
            $disease_name_ret = $db_jbv2->createCommand($disease_name_sql)->queryOne();
            $disease_name = $disease_name_ret['name'];
            
            $class_level3_sql = "select class_level1,class_level2,id from wd_disease where name='{$disease_name}'";
            $class_level3 = $db_v2sns->createCommand($class_level3_sql)->queryOne();
            if(isset($class_level3['id'])){
                $wd_keshi_ret = $class_level3; 
                $wd_keshi_ret['class_level3'] = $class_level3['id'];
                unset($wd_keshi_ret['id']);
                return $wd_keshi_ret;
            }else{
                //通过疾病id查科室
                $disease_condition = 'disease'.$disease_id;
                $department_sql = "select depart.name from 9939_department depart,9939_depart_rel_merge merge where merge.source_flag=1 and merge.unique_key='{$disease_condition}' and merge.departmentid=depart.id";
                $department_ret = $db_jbv2->createCommand($department_sql)->queryOne();
                $department_name = $department_ret['name'];

                //通过科室名称进入wd_keshi查询最终的
                $wd_keshi_sql = "select class_level1,class_level2 from wd_keshi where name='{$department_name}'";
                $wd_keshi_ret = $db_v2sns->createCommand($wd_keshi_sql)->queryOne();
                //如果查不到数据放到默认科室里
                if(!isset($wd_keshi_ret['class_level1'])){
                    $wd_keshi_ret = $wd_keshi_ret_default;
                }
                return $wd_keshi_ret;
            }
        }
        
        //Ⅲ
        //如果没有疾病词，部位词，只有症状词
        if(!isset($all['XS'][0]) && isset($all['XZ'][0])){
            //症状的词的名称
            $symtpom_name = $all['XZ'][0]['word'];
            
            
            //通过症状名查症状id
            $symtpom_sql = "select id from 9939_symptom where name='{$symtpom_name}'";
            $symtpom_ret = $db_v2jb->createCommand($symtpom_sql)->queryOne();
            $symtpom_id = $symtpom_ret['id'];//6521

            //通过症状id查关联疾病,取第一个病
//            $rel_disease_sql = "SELECT diseaseid FROM 9939_disease_symptom_rel WHERE symptomid ={$symtpom_id}";
            $rel_disease_sql = "SELECT 9939_disease.id,9939_disease.`name`,9939_disease_symptom_rel.diseaseid FROM 9939_disease LEFT JOIN 9939_disease_symptom_rel ON 9939_disease_symptom_rel.diseaseid=9939_disease.id WHERE symptomid = {$symtpom_id}";
            $rel_disease_ret = $db_v2jb->createCommand($rel_disease_sql)->queryOne();//获取所有症状关联的疾病id
            $rel_disease_id = $rel_disease_ret['diseaseid'];//取第一个病
            $rel_disease_name = $rel_disease_ret['name'];//取第一个病
            
            //先直接查疾病表是否有该疾病
            //如果有直接返回查询结果
            //如果没有，通过从症状表查
            //通过查wd_disease表得到disease_id
            $class_level3_sql = "select class_level1,class_level2,id from wd_disease where name='{$rel_disease_name}'";
            $class_level3 = $db_v2sns->createCommand($class_level3_sql)->queryOne();
            
            if(isset($class_level3['id'])){
                $wd_keshi_ret = $class_level3; 
                $wd_keshi_ret['class_level3'] = $class_level3['id'];
                unset($wd_keshi_ret['id']);
                return $wd_keshi_ret;
            }else{
                //通过疾病id查科室
                $disease_condition = 'disease'.$rel_disease_id;
                $department_sql = "select depart.name from 9939_department depart,9939_depart_rel_merge merge where merge.source_flag=1 and merge.unique_key='{$disease_condition}' and merge.departmentid=depart.id";
                $department_ret = $db_v2jb->createCommand($department_sql)->queryOne();
                
                $department_name = $department_ret['name'];

                //通过科室名称进入wd_keshi查询最终的
                $wd_keshi_sql = "select class_level1,class_level2 from wd_keshi where name='{$department_name}'";
                $wd_keshi_ret = $db_v2sns->createCommand($wd_keshi_sql)->queryOne();
                
                //如果查不到数据放到默认科室里
                if(!isset($wd_keshi_ret['class_level1'])){
                    $wd_keshi_ret = $wd_keshi_ret_default;
                }
                return $wd_keshi_ret;
            }
        }
        //Ⅳ
        //如果没有疾病词，有症状词和部位词
        if(isset($all['XZ'][0]) && isset($all['XS'][0])){
            
            //**************1、根据症状取出所有的疾病**************
            foreach($all['XZ'] as $k=>$v){
                //症状的词的名称
                $symtpom_name = $v['word'];

                //通过症状名查症状id
                $symtpom_sql = "select id from 9939_symptom where name='{$symtpom_name}'";
                $symtpom_ret = $db_v2jb->createCommand($symtpom_sql)->queryOne();
                $symtpom_id = $symtpom_ret['id'];//6521

                //通过症状id查关联疾病,取第一个病
                $rel_disease_sql = "SELECT diseaseid FROM 9939_disease_symptom_rel WHERE symptomid ={$symtpom_id}";
                $rel_disease_ret = $db_v2jb->createCommand($rel_disease_sql)->queryAll();//获取所有症状关联的疾病id
                if(isset($rel_disease_ret[0])){
                   break;
                }
            }
            foreach($rel_disease_ret as $k=>$v){
                $rel_disease_id_arr[] = $v['diseaseid'];
            }
            
            
            //**************2、根据部位取出所有的疾病**************
            //第一个部位的名称
            $condition_part_name = $all['XS'][0]['word'];
                    
            //通过部位名查部位id
            $condition_part_sql = "select id from 9939_part where name='{$condition_part_name}'";
            $condition_part_ret = $db_v2jb->createCommand($condition_part_sql)->queryOne();
            
            //3、如果根据部位查不到疾病，设置疾病id为根据症状查出来的第一个疾病
            if(!$condition_part_ret){
                $last_disease_id = $rel_disease_id_arr[0];
            }else{
                $condition_part_id = $condition_part_ret['id'];//67
                
                //3.1、通过部位查找所有的疾病
                $part_disease_sql = "SELECT unique_key FROM 9939_part_rel_merge WHERE source_flag=1 AND partid={$condition_part_id}";
                $part_disease_ret = $db_v2jb->createCommand($part_disease_sql)->queryAll();
                foreach($part_disease_ret as $k=>$v){
                    $part_disease_id_arr[] = str_replace('disease', '', $v['unique_key']);
                }
                
                //**************3.2、取二者的交集的第一个疾病作为最终疾病**************
                $last_disease_id_arr = array_intersect($rel_disease_id_arr, $part_disease_id_arr);
                //如果没有交集时：
                if (empty($last_disease_id_arr)){
                    if (!empty($rel_disease_id_arr)){
                        $last_disease_id_arr[0] = $rel_disease_id_arr[0];
                    }else if (!empty($part_disease_id_arr)){
                        $last_disease_id_arr[0] = $part_disease_id_arr[0];
                    }
                }
                sort($last_disease_id_arr);
                $last_disease_id = $last_disease_id_arr[0];
            }
            
            
            //先直接查疾病表是否有该疾病
            //如果有直接返回查询结果
            //如果没有，通过从症状表查
            //通过查wd_disease表得到disease_id
            $disease_name_sql = "select id,name from 9939_disease where id={$last_disease_id}";
            $disease_name_ret = $db_v2jb->createCommand($disease_name_sql)->queryOne();
            $disease_name = $disease_name_ret['name'];
            
            $class_level3_sql = "select class_level1,class_level2,id from wd_disease where name='{$disease_name}'";
            $class_level3 = $db_v2sns->createCommand($class_level3_sql)->queryOne();
            if(isset($class_level3['id'])){
                $wd_keshi_ret = $class_level3; 
                $wd_keshi_ret['class_level3'] = $class_level3['id'];
                unset($wd_keshi_ret['id']);
                return $wd_keshi_ret;
            }else{
                //通过疾病id查科室
                $disease_condition = 'disease'.$last_disease_id;
                $department_sql = "select depart.name from 9939_department depart,9939_depart_rel_merge merge where merge.source_flag=1 and merge.unique_key='{$disease_condition}' and merge.departmentid=depart.id";

                $department_ret = $db_v2jb->createCommand($department_sql)->queryOne();
                $department_name = $department_ret['name'];

                //通过科室名称进入wd_keshi查询最终的
                $wd_keshi_sql = "select class_level1,class_level2 from wd_keshi where name='{$department_name}'";
                $wd_keshi_ret = $db_v2sns->createCommand($wd_keshi_sql)->queryOne();

                //如果查不到数据放到默认科室里
                if(!isset($wd_keshi_ret['class_level1'])){
                    $wd_keshi_ret = $wd_keshi_ret_default;
                }

                return $wd_keshi_ret;
            }
        }
        //未考虑到的情形，直接返回默认科室
        return $wd_keshi_ret_default;
    }
    
}

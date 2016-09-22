<?php

namespace librarys\models;

use yii\db\ActiveRecord;

/**
 * 
 */
class BaseModel extends ActiveRecord {

    /**
     * $offset超过一定数量时采用子查询来提高效率
     * @param array $condition
     * @param integer $offset
     * @param integer $size
     * @param array $orderby
     *   *
     * For example:
     * array('id'=>SORT_ASC)
     *   *
     * 
     * @param bool $return_count_flag 是否返回记录数 true:返回 false:不返回
     * @param string $index_by
     * @return array
     */
    public static function search($condition = [], $offset = 0, $size = 0, $orderby = array(), $return_count_flag = false, $index_by = '') {
        $tmp_query_array = array();
        if ($offset > 5000) {
            $tmp_query_array = self::build_big_tmp_query($condition, $offset, $size, $orderby, $return_count_flag, $index_by);
        } else {
            $tmp_query_array = self::build_tmp_query(0,$condition, $offset, $size, $orderby, $return_count_flag, $index_by);
        }
        $query = $tmp_query_array['query'];
        $total = $tmp_query_array['total'];
//        var_dump($query->createCommand(static::getDb())->getRawSql());
        $list = $query->asArray(true)->all();
        return ['list' => $list, 'total' => $total];
    }
    /**
     * offset超过5000时使用
     * @param type $condition
     * @param type $offset
     * @param type $size
     * @param type $orderby
     * @param type $return_count_flag
     * @param type $index_by
     * @return type
     */
    private static function build_big_tmp_query($condition = [], $offset = 0, $size = 0, $orderby = array(), $return_count_flag = false, $index_by = '') {
        $tb_name = static::tableName();
        $pk_key_list = static::primaryKey();
        if (is_array($pk_key_list)) {
            $pk_name = $pk_key_list[0];
        } else {
            $pk_name = $pk_key_list;
        }

        $query = static::find();
        $on_condition = "{$tb_name}.{$pk_name}=tmp.{$pk_name}";
        $tmp_query_info = self::build_tmp_query(1,$condition, $offset, $size, $orderby, $return_count_flag, $index_by);
        $tmp_query = $tmp_query_info['query'];
        $total = $tmp_query_info['total'];

        $sql = $tmp_query->createCommand(static::getDb())->getRawSql();
        $query->innerJoin("({$sql}) tmp ", $on_condition);
        return ['query' => $query, 'total' => $total];
    }
    /**
     * 
     * @param type $is_sub_query_flag 是否子查询 0：否,1:是
     * @param type $condition
     * @param type $offset
     * @param type $size
     * @param type $orderby
     * @param type $return_count_flag
     * @param type $index_by
     * @return type
     */
    private static function build_tmp_query($is_sub_query_flag = 0,$condition = [], $offset = 0, $size = 0, $orderby = array(), $return_count_flag = false, $index_by = '') {
        $query = static::find();
        if($is_sub_query_flag===1){
            $query->select(static::primaryKey());
        }
        if (count($condition) > 0) {
            $query = $query->where($condition);
        }
        $total = 0;
        if ($return_count_flag === true) {
            $total = $query->count('*');
        }

        if (!empty($index_by)) {
            $query = $query->indexBy($index_by);
        }

        if (count($orderby) > 0) {
            $query = $query->orderBy($orderby);
        }

        if ($size > 0) {
            $query = $query->limit($size)->offset($offset);
        }
        return ['query' => $query, 'total' => $total];
    }

}

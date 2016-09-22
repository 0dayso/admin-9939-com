<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
        <?php
        if(!empty($model['symptom'])){
            foreach ($model['symptom'] as $v) {
//                print_r($v);
//                exit;
                $part_level1_id = $v['part_level1'];
                $part_level2_id = $v['part_level2'];
//                var_dump($part_level2_id);exit;
                $part_level1_name = $part_level2_name = '--';
                if($part_level1_id !== NULL){
                    $part_level1_name = $model['part'][$part_level1_id]['name'];
                }
                if($part_level2_id !== '0' && $part_level2_id !== NULL){
                    $part_level2_name = $model['part'][$part_level2_id]['name'];
                }
            ?>
            <tr>
                <td><label><input type="checkbox" name="ids[]" value="<?php echo $v['id']; ?>"></label></td>
                <td><?php echo $v['id']; ?></td>
                <td><?php echo $v['name']; ?></td>
                <td><?php echo $part_level1_name; ?></td>
                <td><?php echo $part_level2_name; ?></td>
                <td><?php echo date('Y-m-d H:i:s', $v['createtime']); ?></td>
                <td><?php echo $v['username']; ?></td>
                <!--td><?php echo $v['pinyin']; ?></td>
                <td><?php echo $v['pinyin_initial']; ?></td>
                <td><?php echo $v['capital']; ?></td-->
                <td>
                    <a href="<?php echo Url::to([ '/basedata/symptom/edit', 'id' => $v['id']]); ?>" class="d-schr">生成</a>
                    <a href="<?php echo Url::to([ '/basedata/symptom/edit', 'id' => $v['id']]); ?>" class="d-scee">预览</a>
                    <a href="<?php echo Url::to([ '/basedata/symptom/edit', 'id' => $v['id']]); ?>" class="d-editor">编辑</a>
                    <a href="<?php echo Url::to([ '/basedata/symptom/delete', 'id' => $v['id']]); ?>" class="d-delet">删除</a>
                </td>
            </tr>
        <?php
            }
        ?>
        <tr>
            <td colspan="8" align="left">　共有 <?php echo count($model['symptom']);?> 条数据</td>
        </tr>
        <?php
        }else{
        ?>
        <tr>
            <td colspan="11">根据条件暂时还查不到数据。</td>
        </tr>
        <?php } ?>

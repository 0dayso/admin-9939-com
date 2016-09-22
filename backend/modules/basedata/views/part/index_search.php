<?php

use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

?>
<table border="1" cellspacing="0" class="tablay"> 
    <thead>
        <tr style="border-left: 1px solid #ececec;"> 
            <th class="to_01">全部<input id="select_all"  class="d-asrl" type="checkbox"/></th> 
            <th class="to_02">ID</th>
            <th class="to_03">部位名称</th>  
            <th class="to_04">部位简介</th>
            <th class="to_07">操 作</th>                                 
        </tr> 
    </thead>
    <tbody class="ddf">

        <?php
        if(count($search) > 0){
        foreach ($search as $key => $val) {
            $part_level = ($val['level'] == 1) ? 'part-level1' : 'part-level2';
            ?>
            <tr level="<?php echo $val['level']; ?>" id='line<?php echo $val['id']; ?>' depid="<?php echo $val['id']; ?>" child="<?php echo $val['child']; ?>">
                <td><input type="checkbox" name="checkbox[]"/></td>
                <td><?php echo $val['id'] ?></td>
                <td><?php echo $val['name'] ?></td>
                <td><?php echo $val['description'] ?></td>
                <td>
                    <?php
                    if ($val['level'] == 1) {
                        ?>
                        <a href="<?php echo Url::to('@domain/basedata/part/second-part-add?id=' . $val['id'], true) ?>" class="d-schr">添加二级</a>&nbsp;
                        <?php
                    } elseif ($val['level'] == 2) {
                        ?>
                        <a href="javascript:void(0)" class="d-scee d-pop-dow note_level2" depid="<?php echo $val['id'];?>">添加疾病</a>&nbsp;
                        <?php
                    }
                    ?>
                    <a href="<?php echo Url::to('@domain/basedata/part/' . $part_level . '?id=' . $val['id'], true) ?>" class="d-find">查看</a>&nbsp;
                    <a href="<?php echo Url::to('@domain/basedata/part/edit?id=' . $val['id'], true) ?>" class="d-editor">编辑</a>&nbsp;
                    <a href="javascript:;" class="d-delet" child="<?php echo $val['child'] ?>" name="<?php echo $val['name']; ?>" level="<?php echo $val['level']; ?>" id="<?php echo $val['id']; ?>">删除</a>
                </td>
            </tr>
            <?php
        }
        }else{
            ?>
                <tr>
                    <td colspan="5" style="text-align:center;">无内容</td>
                </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<!-- 页码 -->
<div class="paget" style="width:400px;">
    <?php $paging->view_2(); ?>
</div>
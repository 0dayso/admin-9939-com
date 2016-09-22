<?php

use yii\helpers\Url;

$this->title = '查看一级科室';
?>

<table border="1" cellspacing="0" class="tablay"> 
    <thead>
        <tr style="border-left: 1px solid #ececec;"> 
            <th class="to_01">全部<input  class="d-asrl" type="checkbox" id="select_all" /></th> 
            <th class="to_02">ID</th>
            <th class="to_03">科室名称</th>  
            <th class="to_04">科室简介</th>
            <th class="to_07">操 作</th>                                 
        </tr> 
    </thead>
    <tbody class="ddf">

        <?php
        if ($class_level2) {
            foreach ($class_level2 as $key => $val) {
                ?>
                <tr depid="<?php echo $val['id']; ?>">
                    <td><input type="checkbox" name="checkbox[]"/></td>
                    <td><?php echo $val['id']; ?></td>
                    <td><?php echo $val['name']; ?></td>
                    <td><?php echo $val['description']; ?></td>
                    <td>
                        <a href="javascript:void(0)" class="d-scee d-pop-dow note_level2" depid="<?php echo $val['id']; ?>">添加疾病</a>&nbsp;
                        <a href="<?php echo Url::to('/basedata/department/check-level2?id=' . $val['id']); ?>" class="d-find">查看</a>&nbsp;
                        <a href="<?php echo Url::to('/basedata/department/edit?id=' . $val['id']); ?>" class="d-editor">编辑</a>&nbsp;
                        <a href="javascript:;" name="<?php echo $val['name']; ?>" id="<?php echo $val['id']; ?>" class="d-delet">删除</a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<div class="paget">
    <?php echo $page_html->view(); ?>
</div>
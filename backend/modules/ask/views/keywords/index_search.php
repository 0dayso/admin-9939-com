<?php

use yii\helpers\Url;
?>
<table border="1" cellspacing="0" class="tablay"> 
    <thead>
        <tr style="border-left: 1px solid #ececec;"> 
            <th class="chelay">全部<input  type="checkbox"   class="d-asrl"/></th> 
            <th class="idlay">ID</th> 
            <th class="clabe">疾病</th>
            <th class="creti">关键词</th>  
            <th class="cret">操 作</th>                                  
        </tr> 
    </thead>
    <tbody class="ddf">
        <?php
        if (!empty($keywords)) {
            foreach ($keywords as $k => $v) {
                ?>
                <tr> 
                    <td><input type="checkbox"/></td>
                    <td><?php echo $v['id']; ?></td> 
                    <td><?php echo $v['diseasename']; ?></td> 
                    <td><?php echo $v['name']; ?></td> 
                    <td><a href="<?php echo Url::to('@domain/ask/keywords/edit?id=') . $v['id']; ?>" class="d-editor">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" cateid ="<?php echo $v['id']; ?>" class="d-delet">删除</a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="6" style="text-align: center;">无内容，请添加！</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<div class="paget">
    <?php echo $page_html->view(); ?>
</div>
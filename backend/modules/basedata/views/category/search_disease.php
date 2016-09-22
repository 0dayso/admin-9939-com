<?php

use yii\helpers\Url;
?>
<table width="990" border="1" cellspacing="0"> 
    <thead class="ells-four">
        <tr> 
            <th>全部<input  class="d-asrl" type="checkbox"/></th> 
            <th>序号</th> 
            <th>ID</th>  
            <th>疾病名称 </th>
        </tr> 
    </thead>
    <tbody class="ddf">
        <?php
        if (!empty($disease)) {
            foreach ($disease as $k => $v) {
                ?>
                <tr> 
                    <td>
                        <input  type="checkbox"
                                name='checkbox[]'
                                value="<?php echo $v['id']; ?>"
                                class_level1="<?php echo $v['class_level1']; ?>"
                                class_level2="<?php echo $v['class_level2']; ?>"
                                disname="<?php echo $v['name']; ?>"
                                />
                    </td>
                    <td><?php echo ($k + 1); ?></td>
                    <td><?php echo $v['id']; ?></td> 
                    <td><a href=""><?php echo $v['name']; ?></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="4" style="text-align: center">无内容</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<!--表格 结束-->
<div class="d-kodrl">
    <a href="javascript:;" class="d-save-elec">保存选择</a>
    <a href="javascript:;" class="d-sr-elec d-errtu">取消选择</a>
</div>

<div class="paget d-mruw">
    <?php echo $page_html->view(); ?>
</div>


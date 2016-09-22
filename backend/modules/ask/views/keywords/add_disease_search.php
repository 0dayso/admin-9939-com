<table width="990" border="1" cellspacing="0"> 
    <thead class="ells-four">
        <tr> 
            <th>全部<input  class="d-asrl" id="select_all" type="checkbox"/></th> 
            <th>序号</th> 
            <th>ID</th>  
            <th>疾病名称 </th>
        </tr> 
    </thead>
    <tbody class="ddf">
        <?php
        foreach ($disease as $k => $v) {
            $page = isset($page) ? $page : 0;
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
                <td><?php echo (($page - 1) * 10 + $k + 1); ?></td> 
                <td><?php echo $v['id']; ?></td>
                <td><?php echo $v['name']; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<!--表格 结束-->
<div class="d-kodrl">
    <a href="javascript:void(0)" class="d-save-elec">保存选择</a>
    <!--<a href="javascript:void(0)" class="d-sr-elec d-errtu">取消选择</a>-->
</div>
<div class="paget">
    <?php echo $page_html->view();?>
</div>